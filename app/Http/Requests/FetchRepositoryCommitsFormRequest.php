<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class FetchRepositoryCommitsFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'github_username' => ['required', 'string'],
            'repository' => ['required', 'string', ],
        ];
    }

    public function failedValidation(Validator $validator) {
        //write your bussiness logic here otherwise it will give same old JSON response
        failedFormRequestValidation($validator);
    }
}
