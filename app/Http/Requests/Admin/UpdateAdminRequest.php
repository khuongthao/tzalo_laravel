<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "email" => "required|email"
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $checkPassword = $this->customValidationPassword();
            if (!$checkPassword["status"]) {
                $validator->errors()->add('password', $checkPassword["message"]);
            }
        });
    }

    protected function customValidationPassword(): array
    {
        $inputs = $this->validationData();
        if (isset($inputs["password"])) {
            $lengthPassword = strlen($inputs["password"]);
            if ($lengthPassword < 6) {
                return ["status" => false, "message" => "Mật khẩu phải có tối thiểu 6 ký tự."];
            } else {
                return $this->customValidationPasswordConfirmation();
            }
        }

        return ["status" => true];
    }

    protected function customValidationPasswordConfirmation(): array
    {
        $inputs = $this->validationData();
        if (isset($inputs["password"]) && !isset($inputs["password_confirmation"])) {
            return ["status" => false, "message" => "Mật khẩu nhắc lại không được bỏ trống"];
        } else {
            if ($inputs["password"] !== $inputs["password_confirmation"]) {
                return ["status" => false, "message" => "Mật khẩu nhắc lại không giống"];
            }
        }

        return ["status" => true];
    }
}
