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

use DB;

class barDashboardController extends BaseController
{
  
    public function getDashboardBarAll() {
        $barAll=   DB::table('transactions')
                        ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
                        ->leftjoin('tables', 'tables.tableId', '=', 'transactions.transactionTableId')
                        ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
                        ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                        ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
                        ->where('departments.departmentId', '=' , '2')
                        ->where('transactions.transactionStatus', '!=' , 'Available')
                        ->get()->toArray();

    
        return $barAll;
    }

    public function getDashboardBarPending() {
        $barPending=  DB::table('transactions')
                            ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
                            ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
                            ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                            ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
                            ->where('transactions.transactionStatus', '=' , 'Pending')
                            ->get()->toArray();

        return $barPending;
    }

    public function getDashboardBarSuccess() {
        $barSuccess= DB::table('transactions')
                            ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
                            ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
                            ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                            ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
                            ->where('transactions.transactionStatus', '=' , 'Success')
                            ->get()->toArray();

        return $barSuccess;
    }

    public function getDashboardBarProcessing() {
        $barProcessing=  DB::table('transactions')
                                ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
                                ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
                                ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                                ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
                                ->where('transactions.transactionStatus', '=' , 'Processing')
                                ->get()->toArray();

        return $barProcessing;
    }

    public function getDashboardBarTable() {
     
        $barTables= DB::table('transactions')
                    ->leftjoin('tables', 'transactions.transactionTableId', '=', 'tables.tableId')
                    ->where('transactions.transactionStatus', '!=' , 'Available')
                    ->where('transactions.transactionBarStatus', '!=' , 'Served')
                    ->get()->toArray();

        return $barTables;
    }

   
    public function editPendingOrderStatus(Request $request,$transactionId){

      
        $data = [
            'transactionStatus' => 'Processing',
            'transactionBarStatus' => 'Processing',
            'updated_at' => now(),
        ];
      
        $transaction = transaction::where('transactionId', $transactionId)->update($data);

        $barOrders = DB::table('orders')
        ->leftjoin('categories', 'orders.categoryId', '=', 'categories.categoryId')
        ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
        ->where('departments.departmentId', '=', '2')
        ->where('orders.transactionId', '=', $transactionId)
        ->where('orders.orderStatus', '=','0')
        ->get()->toArray();


        foreach ($barOrders as $barOrder) {
            $orderId = $barOrder->orderId;
            
            $data_order = [
                'orderStatus' => '1',
                'updated_at' => now(),
            ];
          
          
            $order = order::where('orderId',$orderId )->update($data_order);
           
        }

       
        return $transaction ;

    }


}
