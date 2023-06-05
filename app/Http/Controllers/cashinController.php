<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\{cashin};
use DB, Carbon\Carbon;
session_start();

class cashinController extends BaseController
{
    public function addCashIn(Request $request){
        try {
            $cashin = cashin::create([
                'cashinUserId' => $_SESSION['user_id'],
                'giveBy' => $request->giveBy,
                'amount' => $request->amount,
                'note' => $request->note,
                'created_at' => now(),
                'updated_at' => NULL,
            ]);

            return redirect()->back();
        } catch(Exception $e) {
            return false;
        }
    }

    public function getCashIn()
    {
        $cashIn=  DB::table('cashins')
                        ->get()->toArray();

        return $cashIn;
    }

    public function editCashIn(Request $request)
    {
 
        $data = [
            'cashInId' => $request->cashInId,
            'cashinUserId' => $_SESSION['user_id'],
            'giveBy' => $request->giveBy,
            'amount' => $request->amount,
            'note' => $request->note,
            'updated_at' => now(),
        ];
      
        $cashIn = cashin::where('cashInId', $request->cashInId)->update($data);
       
        return $cashIn;
    }



 
}
