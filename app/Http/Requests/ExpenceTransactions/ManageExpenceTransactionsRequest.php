<?php

namespace App\Http\Requests\ExpenceTransactions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

use App\ExpenceTransaction;

class ManageExpenceTransactionsRequest extends FormRequest
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
            if(Auth::guard('api')->check() && ExpenceTransaction::canAddTrans(Auth::id(), $this->expence)){
                return true;
            }
        // }else if($this->action == "update" || $this->action == "delete"){ // edit desabled
        }else if($this->action == "delete"){
            if(empty($this->expence_t) || Helper::getStringType($this->expence_t) !== "integer"){
                return false;
            }

            // not existing or deleted
            if(empty((new ExpenceTransaction)->transaction($this->expence_t))){
                return false;
            }

            if(Auth::guard('api')->check() && ExpenceTransaction::canModify(Auth::id(), $this->expence_t)){
                return true;
            }
        }

        return false;
    }

    /**
     * code to return error messages as a response JSON
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
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
                "expence" => "required|numeric",
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
                "expence_t" => "required|numeric"
            ];
        }
    }

    /**
     * Custom error messages
     * 
     * @return array
     */
    public function messages()
    {
        return [

        ];
    }
}
