<?php

namespace App\Http\Controllers;

use App\ExpenceTransaction;
use App\Helper;

use App\Http\Requests\ExpenceTransactions\GetExpenceTransactionsRequest;
use App\Http\Requests\ExpenceTransactions\ManageExpenceTransactionsRequest;

class ExpenceTransactionsController extends Controller
{
    /**
     * get expence transactions
     * (route => expences/transaction)
     */
    public function transactions(GetExpenceTransactionsRequest $request)
    {
        $params = $request->all();
        $expence_t = new ExpenceTransaction;

        $message = trans('app.something_went_wrong');
        $code = 500;

        // return all expence transactions
        if(isset($request->expence)){
            $trans = $expence_t->transactions($request->expence);
            $message = trans('expencetrans.expence-prices');
            $code = 200;
        }

        // return trasaction using id
        if(isset($request->trans) && Helper::getStringType($request->trans) == "integer"){
            $trans = $expence_t->transaction($request->trans, null);
            $message = trans('expencetrans.expence-price');
            $code = 200;
        }

        // return transaction using reference
        if(isset($request->trans) && Helper::getStringType($request->trans) == "string"){
            $trans = $expence_t->transaction(null, $request->trans);
            $message = trans('expencetrans.expence-price');
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
     * Manage expence transaction
     * (add/edit/delete)
     * 
     * (route => expences/manage
     */
    public function manage(ManageExpenceTransactionsRequest $request)
    {
        $params = $request->all();
        $expence_t = new ExpenceTransaction;

        $message = trans('app.something_went_wrong');
        $code = 500;

        // add
        if($request->action == "add"){
            $expence_t = $expence_t->add($params);
            $message = trans('expencetrans.expence-trans-created');
            $code = 201;
        }else if($request->action == "update"){ // update // update is desabled at the moment
            $expence_t = $expence_t->edit($params);
            $message = trans('expenceprice.expence-trans-updated');
            $code = 200;
        }else if($request->action == "delete"){ // delete
            $expence_t = $expence_t->softDelete($params);
            $message = trans('expenceprice.expence-trans-deleted');
            $code = 200;
        }

        if(!empty($expence_t)){
            return response()->json([
                'expence_transactions' => $expence_t,
                'message' => $message
            ], $code);
        }else{
            return response()->json([
                'expence_transactions' => $expence_t,
                'message' => $message
            ], $code);
        }
    }
}
