<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// models
use App\Income;
use App\User;

use App\Http\Requests\Income\AddIncomeRequest;
use App\Http\Requests\Income\ManageIncomesRequest;
use App\Http\Requests\Income\GetIncomesRequest;
use \Auth;

class IncomesController extends Controller
{
    /**
     * add an income
     * route => api (/incomes/add)
     */
    public function add(AddIncomeRequest $request)
    {
        $params = $request->all();

        $income = (new Income)->add($params);

        if($income){
            return response()->json([
                "income" => $income,
                "message" => trans('income.income_added'),
            ], 201);
        }else{
            return response()->json([
                "income" => null,
                "message" => trans('app.something_went_wrong'),
            ], 500);
        }
    }

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
        $message = trans('app.something_went_wrong');

        // add request
        if($request->action === "add"){
            $income = $income->add($params);
            $message = trans('income.income_added');

        }else if($request->action === "update"){ // update request
            $income = $income->edit($params['income'], $params);
            $message = trans('income.income_updated');

        }else if($request->action === "delete"){ // delete request
            $income = $income->softDelete($params['income']);
            $message = trans('income.income_deleted');

        }

        if(!empty($income->id)){
            return response()->json([
                'income' => $income,
                'message' => $message
            ], 201);
        }else{
            return response()->json([
                'income' => $income,
                'message' => $message
            ], 500);
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
        $incomes = $incomes->userIncomeDate($user, $params);

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
}
