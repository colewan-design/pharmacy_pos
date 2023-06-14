<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\badOrder;
use App\Http\Resources\badOrder as deliveredStockResource;
use App\Http\Resources\badOrderCollection;

class badOrderController extends Controller
{


    public function getBadOrder()
    {
        return badOrder::whereNull('deleted_at')->get();
    }

    public function createBadOrder(Request $request)
    {
        // Validate request
        $validatedData = $request->validate([
            'purchaseOrderId' => 'required',
            'supplierName' => 'required',
            'itemName' => 'required',
            'itemDescription' => 'required',
            'itemQty' => 'required|numeric',
            'fromLocation' => 'required',
        ]);
    
        // Create a new delivered stock record
        $deliveredStock = badOrder::create($validatedData);
    
        return response()->json($deliveredStock, 201);
    }

    // public function editDeliveredStock(Request $request)
    // {
    //     // validate request
    //     $this->validate($request, [
    //         'supplierName' => 'required',
    //     ]);
    //     $data = [

    //         'supplierName' => $request->supplierName,
    //         'itemName' => $request->itemName,
    //         'itemDescription' => $request->itemDescription,
    //         'itemQty' => $request->itemQty,
    //         'fromLocation' => $request->fromLocation,
    //         'updated_at' => now(),
    //     ];
      
    //     $purchase_order = deliveredStock::where('deliveredStockId', $request->deliveredStockId)->update($data);
    //     return $purchase_order;
    // }

    // public function deleteDeliveredStock(Request $request)
    // {
    //  $data =deliveredStock::find($request->deliveredStockId);
    //  return  $data->delete();
    // }

}
