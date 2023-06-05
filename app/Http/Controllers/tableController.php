<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\table;
use App\Http\Resources\department as departmentResource;
use App\Http\Resources\departmentCollection;

class tableController extends Controller
{

    public function getTable()
    {
        return table::where('tableIsDeleted', '!=' , 'Y')->get();
    }

    public function createTable(Request $request)
    {
        // validate request
        $this->validate($request, [
            'tableNumber' => 'required',
        ]);
        $table = table::create([
            'tableNumber' => $request->tableNumber,
            'tableName' => $request->tableName,
            'tableDescription' => $request->tableDescription,
            'tableCapacity' => $request->tableCapacity,
            'tableUse' => 'Y',
            'created_at' => now(),
            'updated_at' => NULL,
        ]);
        return $table;
    }
    public function editTable(Request $request)
    {
        // validate request
        $this->validate($request, [
            'tableNumber' => 'required',
        ]);
        $data = [
            'tableNumber' => $request->tableNumber,
            'tableName' => $request->tableName,
            'tableDescription' => $request->tableDescription,
            'tableCapacity' => $request->tableCapacity,
            'tableUse' =>  $request->tableUse,
            'updated_at' => now(),
        ];
      
        $table = table::where('tableId', $request->tableId)->update($data);
        return $table;
    }

    public function deleteTable(Request $request)
    {
    $data = [
        'tableIsDeleted' => 'Y',
    ];
  
    $table = department::where('tableId', $request->tableId)->update($data);
    return $table;
    }

}
