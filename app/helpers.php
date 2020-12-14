<?php

if (!function_exists('failedFormRequestValidation')) {
    function failedFormRequestValidation(\Illuminate\Contracts\Validation\Validator $validator) {
        $final = [
            'status' => "Declined.",
            'reason' => 'The given data was invalid.',
        ];

        $final['data'] = ['errors' => $validator->errors()];

        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json($final, 422));
    }
}
