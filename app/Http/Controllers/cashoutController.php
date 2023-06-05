<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\{cashout};
use DB, Carbon\Carbon;
session_start();

class cashoutController extends BaseController
{

    public function addCashOut(Request $request){
        try {
            $cashout = cashout::create([
                'cashoutUserId' => $_SESSION['user_id'],
                'receiveBy' => $request->receiveBy,
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

    public function getCashOut()
    {
        $cashOut=  DB::table('cashouts')
                    ->get()->toArray();

        return $cashOut;
    }

    public function editCashOut(Request $request)
    {
 
        $data = [
            'cashoutUserId' => $_SESSION['user_id'],
            'cashOutId' => $request->cashOutId,
            'receiveBy' => $request->receiveBy,
            'amount' => $request->amount,
            'note' => $request->note,
            'updated_at' => now(),
        ];
      
        $cashOut = cashout::where('cashOutId', $request->cashOutId)->update($data);
       
        return $cashOut;
    }


}
