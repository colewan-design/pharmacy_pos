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

class outsourcedDashboardController extends BaseController
{
    public function getDashboardOutsourcedAll() {
        $outsourcedAll=  DB::table('transactions')
                            ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
                            ->leftjoin('tables', 'tables.tableId', '=', 'transactions.transactionTableId')
                            ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
                            ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                            ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
                            ->where('departments.departmentId', '=' , '4')
                            ->where('transactions.transactionStatus', '!=' , 'Available')
                            ->get()->toArray();
                            
        return $outsourcedAll;
    }

    public function getDashboardOutsourcedPending() {
        $outsourcedPending=  DB::table('transactions')
                                ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
                                ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
                                ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                                ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
                                ->where('transactions.transactionStatus', '=' , 'Pending')
                                ->get()->toArray();

        return $outsourcedPending;
    }

    public function getDashboardOutsourcedSuccess() {
        $outsourcedSuccess=  DB::table('transactions')
                                ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
                                ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
                                ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                                ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
                                ->where('transactions.transactionStatus', '=' , 'Success')
                                ->get()->toArray();

        return $outsourcedSuccess;
    }

    public function getDashboardOutsourcedProcessing() {
        $outsourcedProcessing= DB::table('transactions')
                                ->leftjoin('orders', 'transactions.transactionId', '=', 'orders.transactionId')
                                ->leftjoin('items', 'orders.itemId', '=', 'items.itemId')
                                ->leftjoin('categories', 'items.categoryId', '=', 'categories.categoryId')
                                ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
                                ->where('transactions.transactionStatus', '=' , 'Processing')
                                ->get()->toArray();

        return $outsourcedProcessing;
    }

    public function getDashboardOutsourcedTable() {
     
        $outsourcedTables= DB::table('transactions')
                        ->leftjoin('tables', 'transactions.transactionTableId', '=', 'tables.tableId')
                        ->where('transactions.transactionStatus', '!=' , 'Available')
                        ->orderBy('transactions.transactionTableId', 'ASC')
                        ->get()->toArray();

        return $outsourcedTables;
    }

    

    public function editPendingOrderStatus(Request $request,$transactionId){

      
        $data = [
            'transactionStatus' => 'Processing',
            'transactionOutsourcedStatus' => 'Processing',
            'updated_at' => now(),
        ];

        $transaction = transaction::where('transactionId', $transactionId)->update($data);

        $outsourcedOrders =  DB::table('orders')
        ->leftjoin('categories', 'orders.categoryId', '=', 'categories.categoryId')
        ->leftjoin('departments', 'categories.departmentId', '=', 'departments.departmentId')
        ->where('departments.departmentId', '=', '4')
        ->where('orders.transactionId', '=', $transactionId)
        ->where('orders.orderStatus', '=','0')
        ->get()->toArray();


        foreach ($outsourcedOrders as $outsourcedOrder) {
            $orderId = $outsourcedOrder->orderId;
            
            $data_order = [
                'orderStatus' => '1',
                'updated_at' => now(),
            ];
          
          
            $order = order::where('orderId',$orderId )->update($data_order);
           
        }

       
        return $transaction ;

    }

   


}
