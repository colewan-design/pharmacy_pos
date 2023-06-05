<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\accountexpense;
use App\Http\Resources\accountexpense as accountexpenseResource;
use App\Http\Resources\accountexpenseCollection;

use DB;

class accountExpenseController extends Controller
{

    public function createAccountExpense(Request $request)
    {
        // validate request
        $this->validate($request, [
            'accountDescription' => 'required',
        ]);
        $accountexpense = accountexpense::create([
            'accountCode' => $request->accountCode,
            'accountDescription' => $request->accountDescription,
            'created_at' => now(),
            'updated_at' => NULL,
        ]);
        return $accountexpense;
    }
    public function editAccountExpense(Request $request)
    {
        // validate request
        $this->validate($request, [
            'accountDescription' => 'required',
        ]);
        $data = [
            'accountCode' => $request->accountCode,
            'accountDescription' => $request->accountDescription,
            'updated_at' => now(),
        ];
      
        $accountexpense = accountexpense::where('accountExpenseId', $request->accountExpenseId)->update($data);
        return $accountexpense;
    }

    public function getAccountExpense() {
        return accountexpense::all();
    }
 
}
