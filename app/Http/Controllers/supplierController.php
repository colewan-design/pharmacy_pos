<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\supplier;
use App\Http\Resources\supplier as supplierResource;
use App\Http\Resources\supplierCollection;

class supplierController extends Controller
{


    public function getSupplier()
    {
        return supplier::whereNull('deleted_at')->get();
    }


    public function createSupplier(Request $request)
    {
        // validate request
        $this->validate($request, [
            'supplierName' => 'required',
        ]);
        $supplier = supplier::create([
            'supplierName' => $request->supplierName,
            'supplierDescription' => $request->supplierDescription,
            'supplierUse' => 'Y',
            'created_at' => now(),
            'updated_at' => NULL,
        ]);
        return $supplier;
    }
    public function editSupplier(Request $request)
    {
        // validate request
        $this->validate($request, [
            'supplierName' => 'required',
        ]);
        $data = [
            'supplierName' => $request->supplierName,
            'supplierDescription' => $request->supplierDescription,
            'supplierUse' => $request->supplierUse,
            'updated_at' => now(),
        ];
      
        $supplier = supplier::where('supplierId', $request->supplierId)->update($data);
        return $supplier;
    }

    public function deleteSupplier(Request $request)
    {
     $data =supplier::find($request->supplierId);
     return  $data->delete();
    }

}
