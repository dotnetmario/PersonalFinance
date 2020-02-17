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
     *"user", "name", "price", "steady", "pay_schedule", "pay_date", "tax", "description",
     * @return array
     * 
     */
    public function rules()
    {
        if($this->action === "add"){
            return [
                "user" => 'required|numeric',
                "name" => 'required|string',
                "price" => "required|regex:/^\d{1,8}(\.\d{1,2})?$/|between:0.01,99999999.99",
                "steady" => 'sometimes|boolean',
                "pay_schedule" => ['required_if:steady,true',
                                    Rule::in(['monthly', 'bimonthly', 'trimonthly', 'semiannually', 'yearly'])
                                ],
                "pay_date" => 'required_if:steady,true|date',
                "tax" => 'numeric|sometimes',
                "description" => 'string|sometimes',
            ];
        }else if($this->action === "update"){
            return [
                "income" => 'numeric|required',
                "user" => 'required|numeric',
                "name" => 'required|string',
                "price" => "required|regex:/^\d{1,8}(\.\d{1,2})?$/|between:0.01,99999999.99",
                "steady" => 'sometimes|boolean',
                "pay_schedule" => ['required_if:steady,true',
                                    Rule::in(['monthly', 'bimonthly', 'trimonthly', 'semiannually', 'yearly'])
                                ],
                "pay_date" => 'required_if:steady,true|date',
                "tax" => 'numeric|sometimes',
                "description" => 'string|sometimes',
            ];
        }else if($this->action === "delete"){
            return [
                "income" => 'required|numeric',
            ];
        }
    }

    // /**
    //  * custom error messages
    //  * 
    //  * @return array
    //  */
    // public function messages()
    // {
    //     if($this->action === "add"){
    //         return [
    //             //
    //         ];
    //     }else if($this->action === "update"){
    //         return [
    //             //
    //         ];
    //     }else if($this->action === "delete"){
    //         return [
    //             //
    //         ];
    //     }
    // }
}
