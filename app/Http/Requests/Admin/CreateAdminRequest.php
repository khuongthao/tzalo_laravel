<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminRequest extends FormRequest
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
            "email" => "required|email|unique:mochikana_admins,email",
            "password" => "required|min:6|confirmed",
        ];
    }

    public function attributes(): array
    {
        return [
            "email" => 'Địa chỉ email',
            "password" => "Mật khẩu",
            "username" => "UserName"
        ];
    }
}
