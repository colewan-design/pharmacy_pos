<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{expense, accountexpense};
use \Carbon\Carbon, PDF, DB;
session_start();

class expenseController extends Controller
{
    public function getExpenses() {
        $getExpenses = expense::all();
        return $getExpenses;
    }

    public function addExpense(Request $req) {
        $this->validate($req, [
            'accountId' => 'required',
            'amt' => 'required',
            'date' => 'required',
        ]);
        $user = $_SESSION['user_id'];

        $store = expense::create([
            'accountExpenseId' => $req->accountId,
            'accountDesc' => $req->accountDesc,
            'expenseAmount' => $req->amt,
            'expenseDate' => Carbon::parse($req->date)->format('Y-m-d'),
            'remarks' => $req->remarks,
            'userId' => $user,
        ]);

        return $store;
    }

    public function getExpense($id) {
        $getExpense = expense::where('expenseId', '=', $id)->first();
        return $getExpense;
    }

    public function updateExpense(Request $req) {
        $this->validate($req, [
                'accountId' => 'required',
                'expenseAmt' => 'required',
                'expenseDate' => 'required',
            ]);
        $store = expense::where('expenseId', '=', $req->expenseId)
            ->update([
                'accountExpenseId' => $req->accountId,
                'accountDescription' => $req->accountDesc,
                'expenseAmount' => $req->expenseAmt,
                'expenseDate' => Carbon::parse($req->expenseDate)->format('Y-m-d'),
                'remarks' => $req->remarks
            ]);
        return $store;
    }

    public function expenseSummary($date1, $date2, $preparedBy, $reviewedBy) {
        $date1 = Carbon::parse($date1)->format('Y-m-d');
        $date2 = Carbon::parse($date2)->format('Y-m-d');

        $data = expense::select(DB::raw('sum(expenseAmount) as totalExpense, group_concat(accountDescription) as expenseDesc'), 'accountExpenseId')
            ->where('expenseDate', '>=', $date1)
            ->where('expenseDate', '<=', $date2)
            ->groupBy('expenses.accountExpenseId')
            ->get();
        $accounts = accountexpense::all();
        $collection = [];

        for($i = 0; $i < count($accounts); $i++) {
            $collection[$i]['accountId'] = $accounts[$i]['accountExpenseId'];
            $collection[$i]['accountCode'] = $accounts[$i]['accountCode'];
            $collection[$i]['accountDesc'] = $accounts[$i]['accountDescription'];
            $collection[$i]['amount'] = 0.00;
            $collection[$i]['expenseDesc'] = [];
            if(count($data) > 0) {
                foreach($data as $expense) {
                    if($expense['accountExpenseId'] == $accounts[$i]['accountExpenseId']) {
                        $collection[$i]['amount'] = floatval($expense['totalExpense']);
                        if($accounts[$i]['accountCode'] == '' || $accounts[$i]['accountCode'] == 'null')
                            $collection[$i]['expenseDesc'] = explode(',', $expense['expenseDesc']);
                    }
                }
            }
        }
        $this->data['expense_accounts'] = $collection;
        $this->data['preparedBy'] = $preparedBy;
        $this->data['reviewedBy'] = $reviewedBy;
        $pdf = PDF::loadView('expenseReport', $this->data);
        return $pdf->stream('Expense Report '.date('Y-m-d'));
    }
}
