<?php

namespace App\Http\Requests\Api;

use App\Constants\ValidateConstant;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UserSettingRequest extends BaseRequest
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
            'skill' => 'required',
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
