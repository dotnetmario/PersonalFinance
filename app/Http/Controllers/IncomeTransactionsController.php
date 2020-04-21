<?php

namespace App\Http\Controllers;

use App\IncomeTransaction;
use App\Helper;

use App\Http\Requests\IncomeTransactions\GetIncomeTransactionsRequest;
use App\Http\Requests\IncomeTransactions\ManageIncomeTransactionsRequest;

class IncomeTransactionsController extends Controller
{
    /**
     * get income transactions
     * (route => incomes/transaction)
     */
    public function transactions(GetIncomeTransactionsRequest $request)
    {
        $params = $request->all();
        $income_t = new IncomeTransaction;

        $message = trans('app.something_went_wrong');
        $code = 500;

        // return all income transactions
        if(isset($request->income)){
            $trans = $income_t->transactions($request->income);
            $message = trans('incometrans.income-prices');
            $code = 200;
        }

        // return trasaction using id
        if(isset($request->trans) && Helper::getStringType($request->trans) == "integer"){
            $trans = $income_t->transaction($request->trans, null);
            $message = trans('incometrans.income-price');
            $code = 200;
        }

        // return transaction using reference
        if(isset($request->trans) && Helper::getStringType($request->trans) == "string"){
            $trans = $income_t->transaction(null, $request->trans);
            $message = trans('incometrans.income-price');
            $code = 200;
        }

        if(!empty($trans)){
            return response()->json([
                'transactions' => $trans,
                'message' => $message
            ], $code);
        }else{
            return response()->json([
                'transactions' => $trans,
                'message' => $message
            ], $code);
        }
    }

    /**
     * Manage income transaction
     * (add/edit/delete)
     * 
     * (route => incomes/manage
     */
    public function manage(ManageIncomeTransactionsRequest $request)
    {
        $params = $request->all();
        $income_t = new IncomeTransaction;

        $message = trans('app.something_went_wrong');
        $code = 500;

        // add
        if($request->action == "add"){
            $income_t = $income_t->add($params);
            $message = trans('incometrans.income-trans-created');
            $code = 201;
        }else if($request->action == "update"){ // update // update is desabled at the moment
            $income_t = $income_t->edit($params);
            $message = trans('incomeprice.income-trans-updated');
            $code = 200;
        }else if($request->action == "delete"){ // delete
            $income_t = $income_t->softDelete($params);
            $message = trans('incomeprice.income-trans-deleted');
            $code = 200;
        }

        if(!empty($income_t)){
            return response()->json([
                'income_transactions' => $income_t,
                'message' => $message
            ], $code);
        }else{
            return response()->json([
                'income_transactions' => $income_t,
                'message' => $message
            ], $code);
        }
    }
}
