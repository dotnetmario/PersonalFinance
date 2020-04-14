<?php

namespace App\Http\Requests\IncomePrices;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use App\IncomePrice;

class ManageIncomePricesRequest extends FormRequest
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
            if(Auth::guard('api')->check() && IncomePrice::canAddPrice(Auth::id(), $this->income)){
                return true;
            }
        }else if($this->action == "update" || $this->action == "delete"){
            if(Auth::guard('api')->check() && IncomePrice::canModify(Auth::id(), $this->income_p)){
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
     * "income", "price", "active",
     */
    public function rules()
    {
        if($this->action == "add"){
            return [
                "income" => "required|numeric",
                "price" => "required|regex:/^\d{1,8}(\.\d{1,2})?$/|between:0.01,99999999.99",
                "active" => "boolean"
            ];
        }else if($this->action == "update"){
            return [
                "income_p" => "required|numeric",
                "price" => "regex:/^\d{1,8}(\.\d{1,2})?$/|between:0.01,99999999.99",
                "active" => "boolean"
            ];
        }else if($this->action == "delete"){
            return [
                "income_p" => "required|numeric"
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
