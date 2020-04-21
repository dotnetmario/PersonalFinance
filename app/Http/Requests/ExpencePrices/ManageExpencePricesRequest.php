<?php

namespace App\Http\Requests\ExpencePrices;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use App\ExpencePrice;

class ManageExpencePricesRequest extends FormRequest
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
            if(Auth::guard('api')->check() && ExpencePrice::canAddPrice(Auth::id(), $this->expence)){
                return true;
            }
        }else if($this->action == "update" || $this->action == "delete"){
            if(empty($this->expence_p) || Helper::getStringType($this->expence_p) !== "integer"){
                return false;
            }

            // not existing or deleted
            if(empty((new ExpencePrice)->prices(null, $this->expence_p))){
                return false;
            }
            

            if(Auth::guard('api')->check() && ExpencePrice::canModify(Auth::id(), $this->expence_p)){
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
                "active" => "boolean"
            ];
        }else if($this->action == "update"){
            return [
                "expence_p" => "required|numeric",
                "price" => "regex:/^\d{1,8}(\.\d{1,2})?$/|between:0.01,99999999.99",
                "active" => "boolean"
            ];
        }else if($this->action == "delete"){
            return [
                "expence_p" => "required|numeric"
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
