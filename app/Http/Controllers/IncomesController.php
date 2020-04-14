<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// models
use App\Income;
use App\User;
use App\IncomeTransaction;
use App\ExpenceTransaction;
use App\Balance;

// requests
use App\Http\Requests\Income\ManageIncomesRequest;
use App\Http\Requests\Income\GetIncomesRequest;

use Illuminate\Support\Facades\Auth;

class IncomesController extends Controller
{
    /**
     * manage incomes (add/edit/delete)
     * 
     * route => api (/incomes/manage)
     */
    public function manage(ManageIncomesRequest $request)
    {
        // get all the request params 
        $params = $request->all();
        $income = new Income;
        $user = Auth::id();

        $message = trans('app.something_went_wrong');
        $code = 500;

        // add request
        if($request->action === "add"){
            $income = $income->add($user, $params);
            $message = trans('income.income_added');
            $code = 201;

        }else if($request->action === "update"){ // update request
            $income = $income->edit($params['income'], $params);
            $message = trans('income.income_updated');
            $code = 200;

        }else if($request->action === "delete"){ // delete request
            $income = $income->softDelete($params['income']);
            $message = trans('income.income_deleted');
            $code = 200;

        }

        if(!empty($income->id)){
            return response()->json([
                'income' => $income,
                'message' => $message
            ], $code);
        }else{
            return response()->json([
                'income' => $income,
                'message' => $message
            ], $code);
        }
    }

    /**
     * get incomes
     * route => api (/incomes/)
     */
    public function incomes(GetIncomesRequest $request)
    {
        $params = $request->all();
        $user = Auth::id();
        $incomes = new Income;

        if(!isset($request->income)){
            $incomes = $incomes->userIncomeDate($user, $params);
        }else{
            $incomes = $incomes->income($request->income);
        }

        if(!empty($incomes)){
            return response()->json([
                'incomes' => $incomes,
                'message' => trans('income.incomes'),
            ], 201);
        }else{
            return response()->json([
                'incomes' => $incomes,
                'message' => trans('app.something_went_wrong'),
            ], 500);
        }
    }

    /**
     * x
     */
    public function x(Request $request)
    {
        // $schedule = \App\IncomeTransaction::makeRef();
        // $user = new User;
        // $user = $user->find(9);

        // $income = $user->incomes()->take(10)->get();

        // $income2 = new Income;
        // $income2 = $income2->find(12);

        // $user2 = Income::find(12)->user()->first();

        


        // $transaction = new ExpenceTransaction;
        // $transaction = $transaction->transaction(1);
        // $expence = $transaction->expence()->first();
        // $type = "expence";
        // $name = $expence->name;

        // return view('mail.transactionmade', compact('transaction', 'type', 'name'));

        // $expence = $transaction->expence()->first();
        // $price = $expence->prices()->where('active', 1)->orderBy('id', 'DESC')->first();
        // $user = $expence->user()->first();

        // $balance = Balance::where('user', $user->id)->first();
        // $balance->last_expence_trans = $transaction->id;
        // $balance->balance -= $transaction->price;
        // $balance->save();

        // return response()->json([
        //     'user' => $user,
        //     'income' => $expence,
        //     'transaction' => $transaction,
        //     'price' => $price,
        //     'balance' => $balance,
        //     'message' => trans('income.incomes'),
        // ], 200);

        // $incomes = Income::all();

        // foreach($incomes as $i){
        //     $i->created_at = \Carbon\Carbon::now()->subDays(rand(1, 300));
        //     $i->save();
        // }

        // return response()->json([
        //     'user' => "done",
        //     'message' => trans('income.incomes'),
        // ], 200);
    }
}
