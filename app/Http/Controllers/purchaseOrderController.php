<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\purchaseOrder;
use App\Http\Resources\purchaseOrder as purchaseOrderResource;
use App\Http\Resources\purchaseOrderCollection;

class purchaseOrderController extends Controller
{


    public function getPurchaseOrder()
    {
        return purchaseOrder::whereNull('deleted_at')->get();
    }


    public function createPurchaseOrder(Request $request)
    {
        // validate request
        $this->validate($request, [
            'soldTo' => 'required',
        ]);
        $purchase_order = purchaseOrder::create([
            'soldTo' => $request->soldTo,
            'customerCode' => $request->customerCode,
            'salesman' => $request->salesman,
            'customerType' => $request->customerType,
            'date' => $request->date,
            'address' => $request->address,
            'poNumber' => $request->poNumber,
            'salesmanCode' => $request->salesmanCode,
            'terms' => $request->terms,
            // 'page' => $request->page,
            'productCode' => $request->productCode,
            // 'description' => $request->description,
            // 'quantity' => $request->quantity,
            // 'unitPrice' => $request->unitPrice,
            // 'productDiscount' => $request->productDiscount,
            // 'amount' => $request->amount,
            'taxCode' => $request->taxCode,
            'lotNumber' => $request->lotNumber,
            'expiryDate' => $request->expiryDate,
            'split' => $request->split,
            'order' => $request->order,
            'delivered' => $request->delivered,
            'uom' => $request->uom,
            'unitPriceWOVat' => $request->unitPriceWOVat,
            'unitPriceWithVat' => $request->unitPriceWithVat,
            'rate' => $request->rate,
            'productDiscountWOVat' => $request->productDiscountWOVat,
            'productDiscountWithVat' => $request->productDiscountWithVat,
            'amountWithVat' => $request->amountWithVat,
            'created_at' => now(),
            'updated_at' => NULL,
            'deleted_at' => NULL,
        ]);
        return $purchase_order;
    }
    public function editPurchaseOrder(Request $request)
    {
        // validate request
        $this->validate($request, [
            'supplierName' => 'required',
        ]);
        $data = [

            'supplierName' => $request->supplierName,
            'itemName' => $request->itemName,
            'itemDescription' => $request->itemDescription,
            'itemQty' => $request->itemQty,
            'fromLocation' => $request->fromLocation,
            'updated_at' => now(),
        ];
      
        $purchase_order = purchaseOrder::where('purchaseOrderId', $request->purchaseOrderId)->update($data);
        return $purchase_order;
    }

    public function deletePurchaseOrder(Request $request)
    {
     $data =purchaseOrder::find($request->purchaseOrderId);
     return  $data->delete();
    }

}
