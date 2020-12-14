<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ApiLoginFormRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'exists:users,email',],
            'password' => ['required', 'min:6',],
        ];
    }

    public function failedValidation(Validator $validator) {
        //write your bussiness logic here otherwise it will give same old JSON response
        failedFormRequestValidation($validator);
    }
}
