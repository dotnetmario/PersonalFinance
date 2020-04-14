<?php

namespace App\Http\Requests\IncomeTransactions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

use App\IncomeTransaction;

class ManageIncomeTransactionsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!isset($this->action)){
            return false;
        }

        if($this->action == "add"){
            if(Auth::guard('api')->check() && IncomeTransaction::canAddTrans(Auth::id(), $this->income)){
                return true;
            }
        // }else if($this->action == "update" || $this->action == "delete"){ // edit desabled
        }else if($this->action == "delete"){
            if(Auth::guard('api')->check() && IncomeTransaction::canModify(Auth::id(), $this->income_t)){
                return true;
            }
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->action == "add"){
            return [
                "income" => "required|numeric",
                "price" => "required|regex:/^\d{1,8}(\.\d{1,2})?$/|between:0.01,99999999.99",
            ];
        }
        // update is desabled at the moment
        // else if($this->action == "update"){
        //     return [
        //         "income_t" => "required|numeric",
        //         "price" => "regex:/^\d{1,8}(\.\d{1,2})?$/|between:0.01,99999999.99",
        //     ];
        // }
        else if($this->action == "delete"){
            return [
                "income_t" => "required|string"
            ];
        }
    }
}
