<?php

namespace App\Http\Controllers;

// requests
use App\Http\Requests\Expence\GetExpencesRequest;
use App\Http\Requests\Expence\ManageExpencesRequest;

// models
use App\Expence;

use Illuminate\Support\Facades\Auth;

class ExpencesController extends Controller
{
    /**
     * manage expences (add/edit/delete)
     * 
     * route => api (/expences/manage)
     */
    public function manage(ManageExpencesRequest $request)
    {
        // get all the request params 
        $params = $request->all();
        $expence = new Expence;
        $user = Auth::id();

        $message = trans('app.something_went_wrong');
        $code = 500;

        // add request
        if($request->action === "add"){
            $expence = $expence->add($user, $params);
            $message = trans('expence.expence_added');
            $code = 201;

        }else if($request->action === "update"){ // update request
            $expence = $expence->edit($params['expence'], $params);
            $message = trans('expence.expence_updated');
            $code = 200;

        }else if($request->action === "delete"){ // delete request
            $expence = $expence->softDelete($params['expence']);
            $message = trans('expence.expence_deleted');
            $code = 200;

        }

        if(!empty($expence->id)){
            return response()->json([
                'expence' => $expence,
                'message' => $message
            ], $code);
        }else{
            return response()->json([
                'expence' => $expence,
                'message' => $message
            ], $code);
        }
    }

    /**
     * get expences
     * route => api (/expences/)
     */
    public function expences(GetExpencesRequest $request)
    {
        $params = $request->all();
        $user = Auth::id();
        $expences = new Expence;

        if(!isset($request->expence)){
            $expences = $expences->userExpenceDate($user, $params);
        }else{
            $expences = $expences->expence($request->expence);
        }

        if(!empty($expences)){
            return response()->json([
                'expences' => $expences,
                'message' => trans('expence.expences'),
            ], 201);
        }else{
            return response()->json([
                'expences' => $expences,
                'message' => trans('app.something_went_wrong'),
            ], 500);
        }
    }
}
