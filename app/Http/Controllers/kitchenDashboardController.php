<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\category;
use App\item;
use App\transaction;
use App\order;
use App\department;
use App\table;


use App\Http\Resources\transaction as transactionResource;
use App\Http\Resources\transactionCollection;

use App\Http\Resources\order as orderResource;
use App\Http\Resources\orderCollection;

use App\Http\Resources\category as categoryResource;
use App\Http\Resources\categoryCollection;

use App\Http\Resources\department as departmentResource;
use App\Http\Resources\departmentCollection;

use App\Http\Resources\item as itemResource;
use App\Http\Resources\itemCollection;

use App\Http\Resources\table as tableResource;
use App\Http\Resources\tableCollection;


use DB;

class kitchenDashboardController extends BaseController
{
    public function getDashboardKitchenAll() {
        $kitchenAll=  DB::table('transactions')
                            ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
                            ->leftjoin('tables', 'tables.tableId', '=', 'transactions.transactionTableId')
                            ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
                            ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                            ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
                            ->where('departments.departmentId', '=' , '1')
                            ->where('transactions.transactionStatus', '!=' , 'Available')
                            ->get()->toArray();
                            
        return $kitchenAll;
    }

    public function getDashboardKitchenPending() {
        $kitchenPending=  DB::table('transactions')
                                ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
                                ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
                                ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                                ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
                                ->where('transactions.transactionStatus', '=' , 'Pending')
                                ->get()->toArray();

        return $kitchenPending;
    }

    public function getDashboardKitchenSuccess() {
        $kitchenSuccess=  DB::table('transactions')
                                ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
                                ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
                                ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                                ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
                                ->where('transactions.transactionStatus', '=' , 'Success')
                                ->get()->toArray();

        return $kitchenSuccess;
    }

    public function getDashboardKitchenProcessing() {
        $kitchenProcessing= DB::table('transactions')
                                ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
                                ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
                                ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                                ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
                                ->where('transactions.transactionStatus', '=' , 'Processing')
                                ->get()->toArray();

        return $kitchenProcessing;
    }

    public function getDashboardKitchenTable() {
     
        $kitchenTables= DB::table('transactions')
                        ->leftjoin('tables', 'transactions.transactionTableId', '=', 'tables.tableId')
                        ->where('transactions.transactionStatus', '!=' , 'Available')
                        ->where('transactions.transactionKitchenStatus', '!=' , 'Served')
                        ->orderBy('transactions.transactionTableId', 'ASC')
                        ->get()->toArray();

        return $kitchenTables;
    }

    

    public function editPendingOrderStatus(Request $request,$transactionId){

      
        $data = [
            'transactionStatus' => 'Processing',
            'transactionKitchenStatus' => 'Processing',
            'updated_at' => now(),
        ];

        $transaction = transaction::where('transactionId', $transactionId)->update($data);

        $kitchenOrders =  DB::table('orders')
        ->leftjoin('categories', 'orders.categoryId', '=', 'categories.categoryId')
        ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
        ->where('departments.departmentId', '=', '1')
        ->where('orders.transactionId', '=', $transactionId)
        ->where('orders.orderStatus', '=','0')
        ->get()->toArray();

            
        foreach ($kitchenOrders as $kitchenOrder) {
            $orderId = $kitchenOrder->orderId;
            $data_order = [
                'orderStatus' => '1',
                'updated_at' => now(),
            ];
          
          
            $order = order::where('orderId',$orderId )->update($data_order);
       
           
        }

       
        return $transaction ;

    }

    public function editOrderServedStatus($orderId){

        $data = [
            'orderServed' => 1
        ];
      
        $orderServed = order::where('orderId', $orderId)->update($data);
       
        return $orderServed;
                           
    }

   


}
