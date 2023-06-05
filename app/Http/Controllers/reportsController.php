<?php

namespace App\Http\Controllers;
use App\{department, category, inventory, item, order, role, transaction};
use DB, Carbon\Carbon;

use Illuminate\Http\Request;

class reportsController extends Controller
{
    public function getSales($date1, $date2) {
        if(!is_null($date1) && !is_null($date2)) {
            $date1 = Carbon::parse($date1)->format('Y-m-d');
            $date2 = Carbon::parse($date2)->format('Y-m-d');
            $getSales = DB::table('payments')
                ->select(DB::raw('date(created_at) as date_created_at, sum(totalAmount) as total_sales, sum(accountReceivableAmount) as total_ar'))
                ->where(DB::raw('date(created_at)'), '>=', $date1)
                ->where(DB::raw('date(created_at)'), '<=', $date2)
                ->groupBy(DB::raw('date(created_at)'))
                ->get();
            $gtotal_sales = 0;
            $gtotal_ar = 0;
            $gtotal_items_sold = 0;
            
            if(!is_null($getSales)) {
                foreach($getSales as $sales) {
                    $getItemsSold = DB::select("select sum(orderQty) as total_items_sold
                        from orders
                        where transactionId in (
                            select transactionId 
                            from payments
                            where date(created_at) = '". $sales->date_created_at ."'
                        )");
                    $gtotal_sales += $sales->total_sales;
                    $gtotal_ar += $sales->total_ar;
                    $sales->total_items_sold = $getItemsSold != null ? $getItemsSold[0]->total_items_sold : 0;
                    $gtotal_items_sold = $sales->total_items_sold;
                    $sales->total_sales = number_format(floatval($sales->total_sales), 2, '.', '');
                    $sales->total_ar = number_format(floatval($sales->total_ar), 2, '.', '');
                }
            }

            // grandtotal
            $gtotal = (object) [
                'date_created_at' => 'GRANDTOTAL',
                'total_items_sold' => $gtotal_items_sold,
                'total_sales' => number_format($gtotal_sales, 2, '.', ''),
                'total_ar' => number_format($gtotal_ar, 2, '.', ''),
            ];
            $getSales = $getSales->toArray();
            array_push($getSales, $gtotal);

            return $getSales;
        }
    }

    public function getBestsellerItems($date1, $date2) {
        if(!is_null($date1) && !is_null($date2)) {
            $date1 = Carbon::parse($date1)->format('Y-m-d');
            $date2 = Carbon::parse($date2)->format('Y-m-d');
            $getBest = order::select(DB::raw('orders.itemId as order_item_id, date(orders.created_at) as date_ordered, sum(orderQty) as total_order_qty'), 'itemName')
                ->join('items', 'orders.orderId', '=', 'items.itemId')
                ->where(DB::raw('date(orders.created_at)'), '>=', $date1)
                ->where(DB::raw('date(orders.created_at)'), '<=', $date2)
                ->where('orderStatus', '1')
                ->groupBy('orders.itemId')
                ->orderBy(DB::raw('sum(orderQty)'), 'DESC')
                ->limit(10)
                ->get();
            return $getBest;
        }
    }

    public function getLeastsellerItems($date1, $date2) {
        if(!is_null($date1) && !is_null($date2)) {
            $date1 = Carbon::parse($date1)->format('Y-m-d');
            $date2 = Carbon::parse($date2)->format('Y-m-d');
            $getLeast = order::select(DB::raw('orders.itemId as order_item_id, date(orders.created_at) as date_ordered, sum(orderQty) as total_order_qty'), 'itemName')
                ->join('items', 'orders.orderId', '=', 'items.itemId')
                ->where(DB::raw('date(orders.created_at)'), '>=', $date1)
                ->where(DB::raw('date(orders.created_at)'), '<=', $date2)
                ->where('orderStatus', '1')
                ->groupBy('orders.itemId')
                ->orderBy(DB::raw('sum(orderQty)'), 'ASC')
                ->limit(10)
                ->get();
            return $getLeast;
        }
    }

    public function getExpiringItems() {
        $today = Carbon::now()->format('Y-m-d');
        $getExpiring = inventory::select(DB::raw('datediff(expiryDate, "' . $today . '") as date_diff'), 'expiryDate', 'itemName', 'dateEncoded')
            ->whereRaw('datediff(expiryDate, "' . $today . '") <= 5')
            ->join('items', 'items.itemId', '=', 'inventories.itemId')
            ->orderBy('expiryDate', 'ASC')
            ->get();
        return $getExpiring;
    }

    public function getRecentOrders() {
        $getRecent = order::select(DB::raw('sum(orderQty) as total_qty_ordered, max(orders.created_at) as latest_date_ordered'), 'itemName', 'orders.created_at')
            ->join('items', 'items.itemId', '=', 'orders.itemId')
            ->where(function($query) {
                $query->whereRaw('date(orders.created_at) = date(now())')
                    ->orWhereRaw('date(orders.created_at) = date(date_sub(now(), interval 1 day))');
            })
            ->where('orderStatus', '1')
            ->groupBy('orders.itemId')
            // ->orderBy('orders.created_at')
            ->orderBy('latest_date_ordered')
            ->limit(10)
            ->get();
        return $getRecent;
    }

    public function dailyIngrCount($date1, $date2) {
        if(!is_null($date1) && !is_null($date2)) {
            $ingr_inv = [];
            $date1 = Carbon::parse($date1)->format('Y-m-d');
            $date2 = Carbon::parse($date2)->format('Y-m-d');
            $get_sales_transac_ids = DB::table('transactions')
                ->join('orders', 'orders.transactionId', '=', 'transactions.transactionId')
                ->where(DB::raw('date(orders.created_at)'), '>=', $date1)
                ->where(DB::raw('date(orders.created_at)'), '<=', $date2)
                ->select(DB::raw('orders.transactionId, itemId as item_ordered, sum(orderQty) as order_qty'))
                ->groupBy(DB::raw('date(orders.created_at)'))
                ->groupBy('orders.transactionId')
                ->groupBy('orders.itemId')
                ->get();
            if(count($get_sales_transac_ids) > 0) {
                foreach($get_sales_transac_ids as $sold_item) {
                    $get_raw_mats = DB::table('item_raw_materials')
                        ->select('item_raw_materials.*', 'raw_materials.material', 'raw_materials.portions')
                        ->join('raw_materials', 'item_raw_materials.raw_materials_id', '=', 'raw_materials.id')
                        ->where('items_id', $sold_item->item_ordered)
                        ->get();
                    if(count($get_raw_mats) > 0) {
                        foreach($get_raw_mats as $raw_mat) {
                            $filter_ingr_inv_key = array_search($raw_mat->raw_materials_id, array_column($ingr_inv, 'rmaterial_id'));
                            
                            if($filter_ingr_inv_key != null) {
                                $ingr_inv[$filter_ingr_inv_key]->portions_used += $raw_mat->portionConsumed * $sold_item->order_qty;
                            } else {
                                array_push($ingr_inv, (object) [
                                    'rmaterial_id' => $raw_mat->raw_materials_id,
                                    'rmaterial' => $raw_mat->material,
                                    'portions_used' => $raw_mat->portionConsumed * $sold_item->order_qty,
                                    'portions_remaining' => $raw_mat->portions,
                                ]);
                            }
                        }
                    }
                }
            }
            return $ingr_inv;
        }
    }
}
