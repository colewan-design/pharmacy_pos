<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\beginingfund;
use DB;
session_start();
class beginingfundController extends Controller
{
   
    public function checkBeginingFund() {
        $beginingfund = DB::select('SELECT *
                FROM beginingfunds 
                WHERE beginingfundUserId = '.$_SESSION['user_id'].' AND DATE_FORMAT(created_at,"%d/%m/%Y")  = DATE_FORMAT(now(),"%d/%m/%Y") 
                ' );
        return $beginingfund;
    }

    public function createBeginingFund(Request $request) {
      try{
        $beginingfund = beginingfund::create([
            'beginingfundUserId' => $_SESSION['user_id'],
            'beginingAmount' => $request->beginingAmount,
        ]);
      

        return redirect()->back();
    } catch(Exception $e) {
        return false;
    }
    }

}
