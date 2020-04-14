<?php

namespace App\Http\Controllers;

use App\IncomePrice;

use Illuminate\Http\Request;
use App\Http\Requests\IncomePrices\GetIncomePricesRequest;
use App\Http\Requests\IncomePrices\ManageIncomePricesRequest;

class IncomePricesController extends Controller
{
    /**
     * manage income prices
     * add/edit/delete
     * 
     * route => incomes/prices/manage
     */
    public function manage(ManageIncomePricesRequest $request)
    {
        $params = $request->all();
        $income_p = new IncomePrice;

        $message = trans('app.something_went_wrong');
        $code = 500;

        if($request->action == "add"){
            $income_p = $income_p->add($params);
            $message = trans('incomeprice.income-price-created');
            $code = 201;
        }else if($request->action == "update"){
            $income_p = $income_p->edit($params);
            $message = trans('incomeprice.income-price-updated');
            $code = 200;
        }else if($request->action == "delete"){
            $income_p = $income_p->softDelete($params['income_p']);
            $message = trans('incomeprice.income-price-deleted');
            $code = 200;
        }

        if(!empty($income_p)){
            return response()->json([
                'income_prices' => $income_p,
                'message' => $message
            ], $code);
        }else{
            return response()->json([
                'income_prices' => $income_p,
                'message' => $message
            ], $code);
        }
    }
    /**
     * get income prices
     * 
     * route => incomes/prices
     */
    public function prices(GetIncomePricesRequest $request)
    {
        $params = $request->all();
        $income_p = new IncomePrice;

        $message = trans('app.something_went_wrong');
        $code = 500;

        if(isset($request->income)){
            $prices = $income_p->prices($request->income);
            $message = trans('incomeprice.income-prices');
            $code = 200;
        }

        if(isset($request->price)){
            $prices = $income_p->prices(null, $request->price);
            $message = trans('incomeprice.income-price');
            $code = 200;
        }

        if(!empty($prices)){
            return response()->json([
                'prices' => $prices,
                'message' => $message
            ], $code);
        }else{
            return response()->json([
                'prices' => $prices,
                'message' => $message
            ], $code);
        }
    }
}
