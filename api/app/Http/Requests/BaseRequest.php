<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(

            response()->json([
                'success' => false,
                'message' => 'Lỗi validation',
                'errors' => $validator->errors()
            ], 422)

        );
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException(

            response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền truy cập'
            ], 403)

        );
    }
}
