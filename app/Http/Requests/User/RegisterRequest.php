<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            'firstname' => ['required', 'max:255'],
            'lastname' => ['max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'phone' => ['regex:/^0[\d]{9}|\+?[\d]{12}|\+?\([\d]{3}\)[\d]{9}$/', 'unique:users'],
            'birthday' => ['before:today'],
            'photo' => ['mimes:jpeg,jpg,png,gif|max:10000'],
            'bio' => ['max:1000'],
            'password' => ['required', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Get Custom error messages
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'firstname.required' => trans('register.firstname_required'),
            'firstname.max' => trans('register.firstname_max'),
            'lastname.max' => trans('register.lastname_max'),

            'email.required' => trans('register.email_required'),
            'email.email' => trans('register.email_email'),
            'email.max' => trans('register.email_max'),
            'email.unique' => trans('register.email_unique'),

            'phone.regex' => trans('register.phone_regex'),
            'phone.unique' => trans('register.phone_unique'),

            'birthday.before' => trans('register.birthday_before'),

            'photo.mimes' => trans('register.photo_mimes'),
            'photo.max' => trans('register.photo_max'),

            'bio.max' => trans('register.bio_max'),

            'password.required' => trans('register.password_required'),
            'password.min' => trans('register.password_min'),
            'password.confirmed' => trans('register.password_confirmed'),
        ];
    }

}
