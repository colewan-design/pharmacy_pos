<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{rawMaterials, rawMaterialInventory};
use \Carbon\Carbon;

class rawMatsController extends Controller
{
    public function saveRawMaterial(Request $req) {
        $this->validate($req, [
            'rawMaterial' => 'required'
        ]);

        if($req->editRawMatId != null && $req->editRawMatId != '') {
            $getItem = rawMaterials::where('id', $req->editRawMatId)->first();
            if(!is_null($getItem)) {
                $saveRawMat = rawMaterials::where('id', $req->editRawMatId)
                    ->update([
                        'material' => $req->rawMaterial,
                    ]);
                    return $saveRawMat;
            }
        } else {
            $saveRawMat = rawMaterials::create([
                'material' => $req->rawMaterial,
                'portions' => 0,
            ]);
            return $saveRawMat;
        }
    }

    public function getRawMats() {
        $rawMats = rawMaterials::all();
        return $rawMats;
    }

    public function saveRawMatBatch(Request $req) {
        $batchCode = '';
        $splitItemName = preg_split('/\s+/', $req->raw_mat_name);
        foreach($splitItemName as $word) {
            $batchCode .= $word[0];
        }
        $getMaxId = rawMaterialInventory::max('id');

        if(!is_null($req->editRawMatBatchId) && $req->editRawMatBatchId != '') {
            $getMat = rawMaterials::find($req->raw_mat_id);
            $getMatInv = rawMaterialInventory::find($req->editRawMatBatchId);

            if(!is_null($getMat)) {
                $save = rawMaterialInventory::where('id', $req->editRawMatBatchId)
                    ->update([
                        'originalPortions' => $req->portions,
                        'expiryDate' => strtotime($req->expiryDate) != false ? Carbon::parse($req->expiryDate)->format('Y-m-d') : null,
                        'value' => $req->value,
                    ]);
                if($save) {
                    $updateQty = $req->portions; // value to update item inventory portion
                    $origQty = $getMat->portions; // item portions from db
                    $origInvQty = $getMatInv->originalPortions; // item inventory portions from db
                    $newQty = $getMat->portions;

                    if($updateQty > $origInvQty) {
                        $diff = $updateQty - $origInvQty;
                        $newQty += $diff;
                    } else if($updateQty < $origInvQty) {
                        $diff = $origInvQty - $updateQty;
                        if($diff > $origQty) {
                            $newQty = $getMat->portions;
                        } else {
                            $newQty -= $diff;
                        }
                    }
                    $saveRawMat = rawMaterials::where('id', $req->raw_mat_id)
                        ->update([
                            'portions' => $newQty
                        ]);
                    if($saveRawMat) 
                        return $saveRawMat;
                    else 
                        return 'false';
                } else {
                    return 'false';
                }
            } else {
                return 'false';
            }
        } else {
            $save = rawMaterialInventory::create([
                'raw_materials_id' => $req->raw_mat_id,
                'batchCode' => strtoupper($batchCode) . ($getMaxId+1),
                'originalPortions' => $req->portions,
                'expiryDate' => Carbon::parse($req->expiryDate)->format('Y-m-d'),
                'value' => $req->value,
            ]);
    
            $getMat = rawMaterials::where('id', $req->raw_mat_id)->first();
            if($save) {
                $updateMatPortion = rawMaterials::where('id', $req->raw_mat_id)
                    ->update([
                        'portions' => $getMat->portions + $req->portions
                    ]);
            } else {
                return 'false';
            }
            return $save;
        }
    }

    public function getRawMatInventory($id) {
        $getInventory = rawMaterialInventory::where('raw_materials_id', $id)->get();
        return $getInventory;
    }
}
