<?php
/**
 * Created by PhpStorm.
 * User: khimf
 * Date: 1/28/2021
 * Time: 3:03 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\{item, category, inventory, itemRawMaterial, rawMaterialInventory, rawMaterials};
use App\Http\Resources\item as itemResource;
use App\Http\Resources\itemCollection;
use DB, Carbon\Carbon, Auth;
use Illuminate\Support\Arr;
session_start();

class itemController extends Controller
{
    public function getItem()
    {
        $user_role = $_SESSION["user_role"];
        switch($user_role) {
            case 1:  // admin
            case 4:  // cashier
                $Item_to_Category=  DB::table('items')
                    ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                    ->where('items.itemIsDeleted', '!=' , 'Y')
                    ->get()->toArray();
                break;
            case 2:  // kitchen
                $Item_to_Category=  DB::table('items')
                    ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                    ->where('items.itemIsDeleted', '!=' , 'Y')
                    ->where('categories.departmentId', '=', 1)
                    ->get()->toArray();
                break;
            case 3:  // bar
                $Item_to_Category=  DB::table('items')
                    ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                    ->where('items.itemIsDeleted', '!=' , 'Y')
                    ->where('categories.departmentId', '=', 2)
                    ->get()->toArray();
                break;
            case 5:  // outsource
                $Item_to_Category=  DB::table('items')
                    ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                    ->where('items.itemIsDeleted', '!=' , 'Y')
                    ->where('categories.departmentId', '=', 4)
                    ->get()->toArray();
                break;
            default:
                $Item_to_Category=  DB::table('items')
                    ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                    ->where('items.itemIsDeleted', '!=' , 'Y')
                    ->get()->toArray();
                break;
        }

        for($i = 0; $i < count($Item_to_Category); $i++) {
            $itemRawMat = itemRawMaterial::where('items_id', $Item_to_Category[$i]->itemId)
                ->with(['rawMaterial.rawMaterialInventory'])
                ->get()->toArray();
            if(count($itemRawMat) > 0) {
                $Item_to_Category[$i]->rawMaterial = $itemRawMat;
            } else {
                $Item_to_Category[$i]->rawMaterial = [];
            }
        }

        return $Item_to_Category;
    }

    public function createItem(Request $request)
    {
        // validate request
        $this->validate($request, [
            'itemName' => 'required',
        ]);
        $item = item::create([
            'categoryId' => $request->categoryId,
            'itemName' => $request->itemName,
            'itemDescription' => $request->itemDescription,
            // 'itemQty' => $request->itemQty,
            'itemQty' => 1000,
            'itemPrice' => $request->itemPrice,
            'itemUse' => 'Y',
            'created_at' => now(),
            'updated_at' => NULL,
        ]);
        
        $lastId = item::max('itemId');
        for($i = 0; $i < count($request->rawItemId); $i++) {
            $itemRawMaterial = itemRawMaterial::create([
                'items_id' => intval($lastId),
                'raw_materials_id' => intval($request->rawItemId[$i]),
                'portionConsumed' => intval($request->rawItemProportions[$i]),
            ]);
        }
        return $item;
    }
    public function editItem(Request $request)
    {
        // dd($request);
        // validate request
        $this->validate($request, [
            'itemName' => 'required',
        ]);
        $data = [
            'categoryId' => $request->categoryId,
            'itemName' => $request->itemName,
            'itemDescription' => $request->itemDescription,
            'itemQty' => $request->itemQty,
            'itemPrice' => $request->itemPrice,
            'itemUse' => $request->itemUse,
            'updated_at' => now(),
        ];

        $item = item::where('itemId', $request->itemId)->update($data);

        $editId = $request->itemId;
        for($i = 0; $i < count($request->rawItemId); $i++) {
            if(isset($request->itemRawEditId[$i])) {
                $findExist = itemRawMaterial::find($request->itemRawEditId[$i]);
                if(!is_null($findExist)) {
                    $itemRawMaterial = itemRawMaterial::where('id', $request->itemRawEditId[$i])
                        ->update([
                            'raw_materials_id' => intval($request->rawItemId[$i]),
                            'portionConsumed' => floatval($request->rawItemProportions[$i]),
                        ]);
                } else {
                    $itemRawMaterial = itemRawMaterial::create([
                            'items_id' => intval($editId),
                            'raw_materials_id' => intval($request->rawItemId[$i]),
                            'portionConsumed' => floatval($request->rawItemProportions[$i]),
                        ]);
                }
            } else {
                $itemRawMaterial = itemRawMaterial::create([
                    'items_id' => intval($editId),
                    'raw_materials_id' => intval($request->rawItemId[$i]),
                    'portionConsumed' => floatval($request->rawItemProportions[$i]),
                ]);
            }
            
        }
        // delete item - raw material records on db if id not in itemRawEditId
        if(count($request->rawItemId) > 0) {
            $item_rm_ids = implode(',', $request->rawItemId);
            $getItemRawMats = itemRawMaterial::whereRaw('raw_materials_id NOT IN (' . $item_rm_ids . ')')
                ->where('items_id', $editId)
                ->delete();
        }
        return $item;
    }

    public function deleteItem(Request $request)
    {
        $data = [
            'itemIsDeleted' => 'Y',
        ];

        $checkItems = item::where('itemId', $request->itemId)
            ->first();
        // check if item still in use..
        if(!is_null($checkItems)) {
            if($checkItems->itemUse == 'Y') {
                return 'false';
            }
        }
    
        $item = item::where('itemId', $request->itemId)->update($data);
        return $item;
    }

    public function getItemCategory() {
        return category::all();
    }

    public function addItemInventory(Request $req) {
        try {
            $this->validate($req, [
                'itemId' => 'required',
                'qty' => 'required',
                // 'expiryDate' => 'required',
            ]);

            // check raw materials used
            // $getItemRawMaterials = itemRawMaterial::where('items_id', $req->itemId)->with('rawMaterial')->get();
            // $rawMatsInsufficient = [];
            // if(count($getItemRawMaterials) > 0) {
            //     // check if raw materials left are enough
            //     foreach($getItemRawMaterials as $raw) {
            //         // get all items using the raw material
            //         $getItemsWithRM = itemRawMaterial::select('items_id')->where('raw_materials_id', $raw->raw_materials_id)->get()->toArray();
            //         $getItemsWithRM = Arr::flatten($getItemsWithRM);
            //         $itemsWithRM = implode(',', $getItemsWithRM);
            //         // get sum of itemQty of all items in (getItemsWithRM)
            //         $getSumItemsWithRM = item::whereRaw('itemId IN (' . $itemsWithRM . ')')->where('itemUse', 'Y')->get()->toArray();

            //         // get sum of portionConsumed of RM
            //         $getSumConsumedPortions = itemRawMaterial::select('id', 'items_id', 'raw_materials_id', 'portionConsumed', 'itemQty')
            //             ->where('raw_materials_id', $raw->raw_materials_id)
            //             ->join('items', 'items.itemId', '=', 'item_raw_materials.items_id')
            //             ->where('itemQty', '>', 0)
            //             ->where('itemUse', 'Y')
            //             ->get();

            //         $toConsume = $req->qty * $raw->portionConsumed;
            //         if($toConsume <= $raw->rawMaterial[0]->portions)
            //             continue;
            //         else
            //             array_push($rawMatsInsufficient, $raw->rawMaterial[0]->material);
            //     }
            // } else {
            //     return 'ItemRawMaterialNotSet';
            // }
            // if(count($rawMatsInsufficient) > 0)
            //     return $rawMatsInsufficient;

            $getItem = item::where('itemId', $req->itemId)->first();
            $getMaxId = inventory::max('inventoryId');
            $batchCode = '';
            $splitItemName = preg_split('/\s+/', $getItem->itemName);
            foreach($splitItemName as $word) {
                $batchCode .= $word[0];
            }
            
            if(is_null($getMaxId))
                $batchCode .= 1;
            else
                $batchCode .= $getMaxId + 1;
    
            if($getItem) {
                inventory::create([
                    'itemId' => $getItem->itemId,
                    'dateEncoded' => date('Y-m-d'),
                    'batchCode' => strtoupper($batchCode),
                    'originalQty' => $req->qty,
                    // 'currentQty' => $req->qty,
                    'expiryDate' => strtotime($req->expiryDate) != false ? Carbon::parse($req->expiryDate)->format('Y-m-d') : null
                ]);

                item::where('itemId', $getItem->itemId)
                    ->update([
                        'itemQty' => $getItem->itemQty + $req->qty
                    ]);
            }
            return redirect()->back();
        } catch(Exception $e) {
            return false;
        }
    }

    public function getItemInventory($item_id) {
        $getItemInventory = inventory::where('itemId', $item_id)->get();
        if($getItemInventory)
            return $getItemInventory;
        else
            return false;
    }

    public function editItemInventory(Request $req) {
        try {
            $this->validate($req, [
                'batchId' => 'required',
                'qty' => 'required',
                'expiryDate' => 'required',
            ]);

            $getItem = item::where('itemId', $req->itemId)->first();
            // $currentQty = $req->origCurrentQtyVal;
            $currentQty = $getItem->itemQty;
            $originalQty = $req->qty;

            // get raw materials used
            $getItemRawMaterials = itemRawMaterial::where('items_id', $req->itemId)->with('rawMaterial')->get();
            $rawMatsInsufficient = [];
            if(count($getItemRawMaterials) > 0) {
                // check if raw materials left are enough
                foreach($getItemRawMaterials as $raw) {
                    // get all items using the raw material
                    $getItemsWithRM = itemRawMaterial::select('items_id')->where('raw_materials_id', $raw->raw_materials_id)->get()->toArray();
                    $getItemsWithRM = Arr::flatten($getItemsWithRM);
                    $itemsWithRM = implode(',', $getItemsWithRM);
                    // get sum of itemQty of all items in (getItemsWithRM)
                    $getSumItemsWithRM = item::whereRaw('itemId IN (' . $itemsWithRM . ')')->where('itemUse', 'Y')->get()->toArray();

                    // get sum of portionConsumed of RM
                    $getSumConsumedPortions = itemRawMaterial::select('id', 'items_id', 'raw_materials_id', 'portionConsumed', 'itemQty')
                        ->where('raw_materials_id', $raw->raw_materials_id)
                        ->join('items', 'items.itemId', '=', 'item_raw_materials.items_id')
                        ->where('itemQty', '>', 0)
                        ->where('itemUse', 'Y')
                        ->get();
                    
                    // get total portions that will be consumed by all items using the raw material
                    // $totalPortionsConsumed = 0;
                    // foreach($getSumConsumedPortions as $perItemRM) {
                    //     $getKey = array_search($perItemRM->items_id, array_column($getSumItemsWithRM, 'itemId'));
                    //     if($getKey !== false)
                    //         $totalPortionsConsumed += intval($getSumItemsWithRM[$getKey]['itemQty']) * $perItemRM->portionConsumed;
                    // }
                    $toConsume = $req->qty * $raw->portionConsumed;
                    // $toConsumeAll = ($totalPortionsConsumed - ($currentQty * $raw->portionConsumed)) + $toConsume;
                    // if($toConsumeAll <= $raw->rawMaterial[0]->portions)
                    if($toConsume <= $raw->rawMaterial[0]->portions)
                        continue;
                    else
                        array_push($rawMatsInsufficient, $raw->rawMaterial[0]->material);
                }
            } else {
                return 'ItemRawMaterialNotSet';
            }

            if(count($rawMatsInsufficient) > 0)
                return array_unique($rawMatsInsufficient);

            if($req->qty > $req->origQtyVal) {
                $diff = $req->qty - $req->origQtyVal;
                $currentQty += $diff;
            } else if($req->qty < $req->origQtyVal) {
                $diff = $req->origQtyVal - $req->qty;
                if($diff > $currentQty)
                    $currentQty = $getItem->itemQty;
                else
                    $currentQty -= $diff;
            }
            
            if($getItem) {
                inventory::where('inventoryId', $req->batchId)
                    ->update([
                        'originalQty' => $originalQty,
                        // 'currentQty' => $currentQty,
                        'expiryDate' => Carbon::parse($req->expiryDate)->format('Y-m-d')
                    ]);

                item::where('itemId', $getItem->itemId)
                    ->update([
                        'itemQty' => $currentQty
                    ]);
            }
            
            return redirect()->back();
        } catch(Exception $e) {
            return false;
        }
    }

    public function getInventoryRecords() {
        $user_role = $_SESSION["user_role"];
        $records = [];
        switch($user_role) {
            case 1:  // admin
            case 4:  // cashier
                $records = inventory::select('dateEncoded', 'batchCode', 'originalQty', 'expiryDate', 'items.itemName', 'items.itemQty')
                    ->join('items', 'items.itemId', '=' ,'inventoryId')
                    ->where('itemIsDeleted', '=', 'N')
                    ->get();
                break;
            case 2:  // kitchen
                $records = inventory::select('dateEncoded', 'batchCode', 'originalQty', 'expiryDate', 'items.itemName', 'items.itemQty')
                    ->join('items', 'items.itemId', '=' ,'inventoryId')
                    ->join('categories', 'categories.categoryId', '=', 'items.categoryId')
                    ->where('itemIsDeleted', '=', 'N')
                    ->where('departmentId', '=', 1)
                    ->get();
                break;
            case 3:  // bar
                $records = inventory::select('dateEncoded', 'batchCode', 'originalQty', 'expiryDate', 'items.itemName', 'items.itemQty')
                    ->join('items', 'items.itemId', '=' ,'inventoryId')
                    ->join('categories', 'categories.categoryId', '=', 'items.categoryId')
                    ->where('itemIsDeleted', '=', 'N')
                    ->where('departmentId', '=', 2)
                    ->get();
                break;
            case 5:  // outsource
                $records = inventory::select('dateEncoded', 'batchCode', 'originalQty', 'expiryDate', 'items.itemName', 'items.itemQty')
                    ->join('items', 'items.itemId', '=' ,'inventoryId')
                    ->join('categories', 'categories.categoryId', '=', 'items.categoryId')
                    ->where('itemIsDeleted', '=', 'N')
                    ->where('departmentId', '=', 4)
                    ->get();
                break;
            default:
                $records = inventory::select('dateEncoded', 'batchCode', 'originalQty', 'expiryDate', 'items.itemName', 'items.itemQty')
                    ->join('items', 'items.itemId', '=' ,'inventoryId')
                    ->where('itemIsDeleted', '=', 'N')
                    ->get();
                break;
        }
        return $records;
    }

    public function pulloutItem(Request $request)
    {
        // validate request
        $this->validate($request, [
            'itemId' => 'required',
        ]);
        $data = [
            'itemQty' => $request->itemQty - 1,
        ];
      
        $item = item::where('itemId', $request->itemId)->update($data);
       
        $newItem = item::create([
            'categoryId' => $request->categoryId,
            'itemName' => $request->itemName,
            'itemDescription' => $request->itemDescription,
            'itemQty' => 0,
            'itemPrice' => $request->itemPrice,
            'itemUse' => 'Y',
            'created_at' => now(),
            'updated_at' => NULL,
        ]);

        return $newItem;
    }

}
