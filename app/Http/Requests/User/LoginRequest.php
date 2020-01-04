<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
    // protected function failedValidation(Validator $validator) {
    //     throw new HttpResponseException(response()->json($validator->errors(), 422));
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'identifier' => 'required',
            'password' => 'required',
            'remember_me' => 'required|boolean',
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
            'identifier.required' => trans('login.identifier_required'),
            'password.required' => trans('login.password_required'),
            'remember_me.boolean' => trans('login.remember_me_boolean'),
            'remember_me.required' => trans('login.remember_me_required'),
        ];
    }
}
