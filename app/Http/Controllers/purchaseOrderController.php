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
            'supplierName' => 'required',
        ]);
        $purchase_order = purchaseOrder::create([
            'supplierName' => $request->supplierName,
            'itemName' => $request->itemName,
            'itemDescription' => $request->itemDescription,
            'itemQty' => $request->itemQty,
            'fromLocation' => $request->fromLocation,
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

    public function deleteSupplier(Request $request)
    {
     $data =purchaseOrder::find($request->purchaseOrderId);
     return  $data->delete();
    }

}
