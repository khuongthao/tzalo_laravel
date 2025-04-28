<?php

namespace App\Http\Requests\Api;

use App\Constants\ValidateConstant;
use App\Http\Requests\Api\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class AuthRequest extends BaseRequest
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
            'name' => 'required',
            'email'        => 'required|unique:users',
            'password'     => 'required|min:6',
            'device_token'     => 'nullable',
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
