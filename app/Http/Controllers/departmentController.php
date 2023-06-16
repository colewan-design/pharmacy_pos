<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\department;
use App\Http\Resources\department as departmentResource;
use App\Http\Resources\departmentCollection;

class departmentController extends Controller
{

    public function getDepartment()
    {
        return department::whereNull('deleted_at')->get();
    }

    public function createDepartment(Request $request)
    {
        // validate request
        $this->validate($request, [
            'departmentName' => 'required',
        ]);
        $department = department::create([
            'departmentName' => $request->departmentName,
            'departmentDescription' => $request->departmentDescription,
            'departmentUse' => 'Y',
            'created_at' => now(),
            'updated_at' => NULL,
        ]);
        return $department;
    }
    public function editDepartment(Request $request)
    {
        // validate request
        $this->validate($request, [
            'departmentName' => 'required',
        ]);
        $data = [
            'departmentName' => $request->departmentName,
            'departmentDescription' => $request->departmentDescription,
            'departmentUse' => $request->departmentUse,
            'updated_at' => now(),
        ];
      
        $department = department::where('departmentId', $request->departmentId)->update($data);
        return $department;
    }

    public function deleteDepartment(Request $request)
    {
    $data = [
        'departmentIsDeleted' => 'Y',
    ];
  
    $department = department::where('departmentId', $request->departmentId)->update($data);
    return $department;
    }

}
