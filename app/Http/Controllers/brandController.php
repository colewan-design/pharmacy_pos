<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\brand;
use App\category;
use App\Http\Resources\brand as brandResource;
use App\Http\Resources\brandCollection;

class brandController extends Controller
{

    public function getBrand()
    {
        return brand::whereNull('deleted_at')->get();
    }

    public function createBrand(Request $request)
    {
        // validate request
        $this->validate($request, [
            'brandName' => 'required',
        ]);
        $brand = brand::create([
            'brandName' => $request->brandName,
            'brandDescription' => $request->brandDescription,
            'brandUse' => 'Y',
            'created_at' => now(),
            'updated_at' => NULL,
        ]);
        return $brand;
    }
    public function editBrand(Request $request)
    {
        // validate request
        $this->validate($request, [
            'brandName' => 'required',
        ]);
        $data = [
            'brandName' => $request->brandName,
            'brandDescription' => $request->brandDescription,
            'brandUse' => $request->brandUse,
            'updated_at' => now(),
        ];
      
        $brand = brand::where('brandId', $request->brandId)->update($data);
        return $brand;
    }

    public function deleteBrand(Request $request)
    {
        $data =brand::find($request->brandId);
        return  $data->delete();
    }
    public function getBrandCategory() {
        return category::all();
    }

}
