<?php

namespace App\Http\Requests\Income;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class AddIncomeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
        return [
            "user" => "required|numeric",
            "name" => "required",
            "price" => "required|numeric",
            "steady" => "boolean",
            "pay_schedule" => [Rule::in(['monthly', 'bimonthly', 'trimonthly', 'semiannually', 'yearly'])],
            "pay_date" => "integer",
            "tax" => "integer",
            "desc" => "max:2000",
        ];
    }

    /**
     * Custom error messages
     * 
     * @return array
     */
    public function messages()
    {
        return [
            "user.required" => trans('income.user_required'),
            "user.numeric" => trans('income.user_numeric'),
            "name.required" => trans('income.name_required'),
            "price.required" => trans('income.price_required'),
            "price.numeric" => trans('income.price_numeric'),
            "steady.boolean" => trans('income.steady_boolean'),
            "pay_schedule.in" => trans('income.pay_schedule_in'),
            "pay_date.integer" => trans('income.pay_date_integer'),
            "tax.integer" => trans('income.tax_integer'),
            "desc.max" => trans('income.desc_max'),
        ];
    }
}
