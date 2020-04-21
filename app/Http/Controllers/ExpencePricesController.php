<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpencePrices\GetExpencePricesRequest;
use App\Http\Requests\ExpencePrices\ManageExpencePricesRequest;

use App\ExpencePrice;

class ExpencePricesController extends Controller
{
    /**
     * manage expence prices
     * add/edit/delete
     * 
     * route => expences/prices/manage
     */
    public function manage(ManageExpencePricesRequest $request)
    {
        $params = $request->all();
        $expence_p = new ExpencePrice;

        $message = trans('app.something_went_wrong');
        $code = 500;

        if($request->action == "add"){
            $expence_p = $expence_p->add($params);
            $message = trans('expenceprice.expence-price-created');
            $code = 201;
        }else if($request->action == "update"){
            $expence_p = $expence_p->edit($params);
            $message = trans('expenceprice.expence-price-updated');
            $code = 200;
        }else if($request->action == "delete"){
            $expence_p = $expence_p->softDelete($params['expence_p']);
            $message = trans('expenceprice.expence-price-deleted');
            $code = 200;
        }

        if(!empty($expence_p)){
            return response()->json([
                'expence_prices' => $expence_p,
                'message' => $message
            ], $code);
        }else{
            return response()->json([
                'expence_prices' => $expence_p,
                'message' => $message
            ], $code);
        }
    }


    /**
     * get expence prices
     * 
     * route => expences/prices
     */
    public function prices(GetExpencePricesRequest $request)
    {
        $params = $request->all();
        $expence_p = new ExpencePrice;

        $message = trans('app.something_went_wrong');
        $code = 500;

        if(isset($request->expence)){
            $prices = $expence_p->prices($request->expence);
            $message = trans('expenceprice.expence-prices');
            $code = 200;
        }

        if(isset($request->price)){
            $prices = $expence_p->prices(null, $request->price);
            $message = trans('expenceprice.expence-price');
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
