<?php

namespace App\Http\Requests\Income;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class GetIncomesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::guard('api')->check()){
            return true;
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
        return [
            'limit' => 'nullable|numeric',
            'day' => 'numeric|nullable',
            'month' => 'required_with:day|numeric|nullable',
            'year' => 'required|numeric|nullable',
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

        ];
    }
}
