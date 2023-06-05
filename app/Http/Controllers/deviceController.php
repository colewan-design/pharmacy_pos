<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\device;
use App\department;
use App\Http\Resources\device as deviceResource;
use App\Http\Resources\deviceCollection;

use DB;
class deviceController extends Controller
{

    public function getDevice()
    {
       
        $Devices_to_Department =  DB::table('devices')
        ->leftjoin('departments', 'devices.departmentId', '=', 'departments.departmentId')
        ->where('devices.deviceIsDeleted', '!=' , 'Y')
        ->get()->toArray();

        return $Devices_to_Department;
    }

    public function createDevice(Request $request)
    {
        // validate request
        $this->validate($request, [
            'deviceName' => 'required',
        ]);
        $device = device::create([
            'departmentId' => $request->departmentId,
            'deviceName' => $request->deviceName,
            'deviceDescription' => $request->deviceDescription,
            'deviceUse' => 'Y',
            'created_at' => now(),
            'updated_at' => NULL,
        ]);
        return $device;
    }
    public function editDevice(Request $request)
    {
        // validate request
        $this->validate($request, [
            'deviceName' => 'required',
        ]);
        $data = [
            'departmentId' => $request->departmentId,
            'deviceName' => $request->deviceName,
            'deviceDescription' => $request->deviceDescription,
            'deviceUse' => $request->deviceUse,
            'updated_at' => now(),
        ];
      
        $device = device::where('deviceId', $request->deviceId)->update($data);
        return $device;
    }

    public function deleteDevice(Request $request)
    {
        $data = [
            'deviceIsDeleted' => 'Y',
        ];

        $checkItems = device::where('deviceId', $request->deviceId)
            ->first();
        // check if device still in use..
        if(!is_null($checkItems)) {
            if($checkItems->deviceUse == 'Y') {
                return 'false';
            }
        }
    
        $device = device::where('deviceId', $request->deviceId)->update($data);
        return $device;
    }

    public function getDeviceDepartment() {
        return department::all();
    }
}
