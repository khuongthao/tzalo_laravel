<?php

namespace App\Http\Requests\Api;

use App\Constants\ValidateConstant;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class SignInSocialRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id_token' => 'required|string',
        ];
    }

    public function messages()
    {
        return ValidateConstant::MESSAGE;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, $this->buildResponse($validator));
    }

    protected function buildResponse(Validator $validator)
    {
        return response()->json([
            'code' => 0,
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);
    }
}
