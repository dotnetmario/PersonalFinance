<?php

namespace App\Http\Requests\Income;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use \Auth;
use App\Income;

class ManageIncomesRequest extends FormRequest
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

        if($this->action === "add"){
            return Auth::guard('api')->check();
        }else if($this->action === "update" || $this->action === "delete"){
            return Income::canModify(Auth::guard('api')->id(), $this->income) && Auth::guard('api')->check();
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
     * 
     */
    public function rules()
    {
        if($this->action === "add"){
            return [
                "name" => 'required|string',
                "steady" => 'sometimes|boolean',
                "pay_schedule" => ['required_if:steady,true',
                                    Rule::in(['monthly', 'bimonthly', 'trimonthly', 'semiannually', 'yearly'])
                                ],
                "pay_date" => 'required_if:steady,true|date|date_format:Y-m-d',
                "tax" => 'numeric|sometimes',
                "description" => 'string|sometimes',
            ];
        }else if($this->action === "update"){
            return [
                "income" => 'numeric|required',
                "name" => 'required|string',
                "steady" => 'sometimes|boolean',
                "pay_schedule" => ['required_if:steady,true',
                                    Rule::in(['monthly', 'bimonthly', 'trimonthly', 'semiannually', 'yearly'])
                                ],
                "pay_date" => 'required_if:steady,true|date|date_format:Y-m-d',
                "tax" => 'numeric|sometimes',
                "description" => 'string|sometimes',
            ];
        }else if($this->action === "delete"){
            return [
                "income" => 'required|numeric',
            ];
        }
    }

    /**
     * custom error messages
     * 
     * @return array
     */
    public function messages()
    {
        return [
            
        ];
    }
}
