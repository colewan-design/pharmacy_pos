<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

use App\{category, item, transaction, order, table, role, User, rawMaterials, rawMaterialInventory, itemRawMaterial};

use App\Http\Resources\transaction as transactionResource;
use App\Http\Resources\transactionCollection;

use App\Http\Resources\order as orderResource;
use App\Http\Resources\orderCollection;

use Illuminate\Support\Facades\DB;
session_start();

class dashboardController extends BaseController
{
    public function createOrder(Request $request)
    {
        // validate request
        // $this->validate($request, [
        //     'transactionSlipNo' => 'required',
        //     'transactionTableNo' => 'required',
        //     'transactionServedBy' => 'required',
        //     'transactionStatus' => 'required',
        // ]);

        //check if has existing order
        $checkIfHasExistingOrder = transaction::select('*')
        ->where('transactionTableId', '=',  $request->transactionTableId)
        ->where('transactionStatus', '!=', 'Available' )
        ->where('transactionUserId', '=', $_SESSION['user_id'])
        ->get();

        $tid = '0';
         foreach($checkIfHasExistingOrder as $transactionAdditional){
                $tid = $transactionAdditional->transactionId;
        }

        if ($tid != '0') {
           $orderCollection = $request->orderVal;
            foreach ($orderCollection as $order_item) {
                $itemId = $order_item['itemId'];
                $categoryId = $order_item['categoryId'];
                $orderQty = $order_item['orderQty'];
                $itemNote = $order_item['itemNote'];
                $orderPrice = $order_item['orderPrice'];
                $itemQty = $order_item['itemQty'];
                $totalPrice = $order_item['totalPrice'];

                $order = order::create([
                   'transactionId' => $tid,
                   'itemId' => $itemId,
                   'categoryId' =>$categoryId,
                   'orderQty' => $orderQty,
                   'itemNote' => $itemNote,
                   'orderPrice' => $orderPrice,
                   'orderTotal' => $totalPrice,
                ]);

                // Find out what department status to be updated in Transaction
                $departments= DB::table('departments')
                ->leftjoin('categories', 'categories.departmentId', '=', 'departments.departmentId')
                ->where('categories.categoryId', '=', $categoryId)
                ->get();

                $departmentStatus='';
                foreach ($departments as $department) {
                    $departmentId =$department->departmentId;
                }

                if ($departmentId == 1){
                    $departmentStatus = "transactionKitchenStatus";
                }else if ($departmentId == 2){
                    $departmentStatus = "transactionBarStatus";
                }else if ($departmentId == 4){
                    $departmentStatus = "transactionOutsourcedStatus";
                }


                $data = [
                    $departmentStatus => 'Pending',
                ];

                $updateDepartment = transaction::where('transactionId', $tid)->update($data);

                //End Find out what department status to be updated in Transaction
                $data_inventory = [
                    'itemQty' =>$itemQty-$orderQty,
                    'updated_at' => now(),
                ];

                $inventory = item::where('itemId', $itemId)->update($data_inventory);

                // get raw materials used by item..
                $usedRawMats = itemRawMaterial::where('items_id', $itemId)->get();
                // total portions consumed per material..
                if(count($usedRawMats) > 0) {
                    foreach($usedRawMats as $material) {
                        $totalPortionsUsed = $orderQty * $material->portionConsumed;
                        $getRawMat = rawMaterials::find($material->raw_materials_id);
                        // deduct from raw materials..
                        if($getRawMat != null) {
                            $deductRawMat = rawMaterials::where('id', $material->raw_materials_id)
                            ->update([
                                'portions' => intval($getRawMat->portions) - intval($totalPortionsUsed),
                            ]);
                        }
                    }
                }
            }

        }else{
            //transaction
            $transaction = transaction::create([
                'transactionUserId' => $_SESSION['user_id'],
                'transactionSlipNo' => $request->transactionSlipNo,
                'transactionNote' => $request->transactionNote,
                'transactionTableId' => $request->transactionTableId,
                'transactionServedBy' => $request->transactionServedBy,
                'transactionStatus' => $request->transactionStatus,
                'transactionKitchenStatus' => $request->transactionKitchenStatus,
                'transactionBarStatus' => $request->transactionBarStatus,
                'transactionOutsourcedStatus' => $request->transactionOutsourcedStatus,
                'transactionOutsourcedStatus' => $request->transactionOutsourcedStatus,

            ]);
            $orderCollection = $request->orderVal;
            foreach ($orderCollection as $order_item) {
                $itemId = $order_item['itemId'];
                $categoryId = $order_item['categoryId'];
                $orderQty = $order_item['orderQty'];
                $orderPrice = $order_item['orderPrice'];
                $itemQty = $order_item['itemQty'];
                $itemNote = $order_item['itemNote'];
                $totalPrice = $order_item['totalPrice'];

                $order = order::create([
                'transactionId' => $transaction->id,
                'itemId' => $itemId,
                'categoryId' =>$categoryId,
                'orderQty' => $orderQty,
                'orderPrice' => $orderPrice,
                'orderTotal' => $totalPrice,
                'itemNote' => $itemNote,
            ]);

            $data_inventory = [
                'itemQty' =>$itemQty-$orderQty,
                'updated_at' => now(),
            ];

            $inventory = item::where('itemId', $itemId)->update($data_inventory);

            // get raw materials used by item..
            $usedRawMats = itemRawMaterial::where('items_id', $itemId)->get();
            // total portions consumed per material..
            if(count($usedRawMats) > 0) {
                foreach($usedRawMats as $material) {
                    $totalPortionsUsed = $orderQty * $material->portionConsumed;
                    $getRawMat = rawMaterials::find($material->raw_materials_id);
                    // deduct from raw materials..
                    if(!is_null($getRawMat)) {
                        $deductRawMat = rawMaterials::where('id', $material->raw_materials_id)
                            ->update([
                                'portions' => intval($getRawMat->portions) - intval($totalPortionsUsed),
                            ]);
                    }
                }
            }
        }

    }

    return  $order;

    }

    public function getDashboardCategory() {
        return category::all();
    }

    public function getDashboardItem() {
        // $items= DB::table('items')->get()->toArray();

        $items = item::with('itemRawMaterial.rawMaterial')
            ->get()->toArray();

        return $items;

    }

    public function getDashboardTable() {
        $dashboardTables= DB::table('tables')
                        // ->leftjoin('transactions', 'transactions.transactionTableId', '=', 'tables.tableId')
                        ->orderBy('tables.tableOrder','ASC')
                        ->get()->toArray();

        return $dashboardTables;
    }

    public function checkIfHasExistingOrder(){
        $tableId = 1;
        $checkIfHasExistingOrder = transaction::select('*')
                           ->where('transactionTableId', '=', $tableId)
                           ->where('transactionStatus', '!=', 'Available' )
                           ->get();

        return $checkIfHasExistingOrder;


    }


    public function editServedKitchen($transactionId){

        $data = [
            // 'transactionStatus' => 'Served',
            'transactionKitchenStatus' => 'Served',
            'updated_at' => now(),
        ];

        $transaction = transaction::where('transactionId', $transactionId)->update($data);

        return $transaction ;

    }

    public function editServedBar($transactionId){

        $data = [
            // 'transactionStatus' => 'Served',
            'transactionBarStatus' => 'Served',
            'updated_at' => now(),
        ];

        $transaction = transaction::where('transactionId', $transactionId)->update($data);

        return $transaction ;

    }

    public function editServedOutsourced($transactionId){

        $data = [
            'transactionStatus' => 'Served',
            'transactionOutsourcedStatus' => 'Served',
            'updated_at' => now(),
        ];

        $transaction = transaction::where('transactionId', $transactionId)->update($data);

        return $transaction ;

    }

    public function getDashboardAllOrder(){
        $id = $_SESSION['user_id'];
        $orderAll=  DB::table('transactions')
        ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
        ->leftjoin('tables', 'tables.tableId', '=', 'transactions.transactionTableId')
        ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
        ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
        ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
        ->where('transactions.transactionStatus', '!=' , 'Available')
        ->where('transactions.transactionUserId', '=' , $id)
        ->get()->toArray();

        return $orderAll;

    }

    public function getDashboardAllOrderThisDay(){
        $id = $_SESSION['user_id'];
        $orderAll = DB::select('
        SELECT * FROM transactions a
        LEFT JOIN orders b ON a.transactionId = b.transactionId
        LEFT JOIN tables c ON c.tableId = a.transactionId
        LEFT JOIN items  d ON b.itemId = d.itemId
        LEFT JOIN categories e ON d.categoryId = e.categoryId
        LEFT JOIN departments f ON e.departmentId = f.departmentId
        WHERE a.transactionUserId = '.$id.'
        AND DATE_FORMAT(a.created_at, "%M %d %Y") = DATE_FORMAT(NOW(), "%M %d %Y")
        ');
        return $orderAll;

    }

    public function getDashboardAllTableThisDay(){
        $id = $_SESSION['user_id'];
        $allTable= DB::select('
        SELECT * FROM transactions a
            LEFT JOIN tables c ON c.tableId = a.transactionId
            WHERE a.transactionUserId = '.$id.'
            AND DATE_FORMAT(a.created_at, "%M %d %Y") = DATE_FORMAT(NOW(), "%M %d %Y")
            ORDER BY a.transactionTableId  ASC
        ');
        return  $allTable;
    }

    public function getDashboardAllTable(){
        $id = $_SESSION['user_id'];
        $allTable= DB::table('transactions')
        ->select('transactions.*', 'tables.*', 'payments.paymentId')
        ->leftjoin('tables', 'transactions.transactionTableId', '=', 'tables.tableId')
        ->leftjoin('payments', 'transactions.transactionId', '=', 'payments.transactionId')
        ->where('transactions.transactionStatus', '!=' , 'Available')
        ->where('transactions.transactionUserId', '=' , $id)
        ->orderBy('transactions.transactionSlipNo', 'DESC')
        ->get()->toArray();

        return  $allTable;
    }

    public function getTotal($transactionId){
       $total =  DB::select('SELECT transactionId,SUM(orderPrice) AS total
                            FROM orders z
                            WHERE z.transactionId = '.$transactionId.'
                            ' );


        return  $total;

    }

    public function getUserPermissions() {
        $get = role::select('roleName', 'permission', 'isAdmin')->get();
        return $get;
    }

    public function getDashboardAllWaiters(){

        $allWaiters= DB::select("SELECT * FROM users a
        LEFT JOIN roles b ON a.role_id = b.id
        WHERE b.roleName = 'Waiter'
        ");
        return  $allWaiters;
    }


    public function changeTable(Request $request){

        $data = [
            'transactionTableId' => $request->transactionTableId,
        ];

        $transaction = transaction::where('transactionId', $request->transactionId)->update($data);

        return $transaction ;

    }

    public function removeOrder($orderId){

       $deleteOder =  DB::table('orders')->where('orderId', '=', $orderId)->delete();

       return $deleteOder ;

    }

}
