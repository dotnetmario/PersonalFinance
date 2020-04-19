<?php

namespace App\Http\Requests\Expence;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\Expence;

class GetExpencesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::guard('api')->check()){
            if(!empty($this->expence)){
                if(!Expence::canModify(Auth::id(), $this->expence)){
                    return false;
                }
            }

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
            'year' => 'required_without:expence|numeric|nullable',
            'expence' => 'sometimes|numeric',
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
