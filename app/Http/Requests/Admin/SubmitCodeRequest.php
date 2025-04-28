<?php

namespace App\Http\Requests\Admin;

use App\Services\Service;
use App\Services\ApiService;
use Illuminate\Foundation\Http\FormRequest;

class SubmitCodeRequest extends FormRequest
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
            "code" => "required",
            "email" => "required"
        ];
    }
    /**
     * validate.
     * @param [type] $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $inputs = $this->validationData();
            $checkEmail = $this->customValidationEmail($inputs);
            $checkCode = $this->customValidationCode($inputs);
            if (!$checkCode["status"]) {
                $validator->errors()->add('code', $checkCode["message"]);
            }
            if (!$checkEmail["status"]) {
                $validator->errors()->add('email', $checkEmail["message"]);
            }
        });
    }
    /**
     * Undocumented function
     * @param [type] $inputs
     * @return array
     */
    protected function customValidationEmail($inputs): array
    {
        $user = ApiService::userService()->getUserWithEmail($inputs["email"]);
        if (empty($user)) {
            return ["status" => false, "message" => "Không tìm thấy user để mở khóa"];
        } else {
            return ["status" => true];
        }
    }
    /**
     * Verify email check code right
     * @param [type] $inputs
     * @return array
     */
    protected function customValidationCode($inputs): array
    {
        $code = ApiService::VipCodeService()->getCode(str_replace('-', '', $inputs["code"]));
        return [
            "status" => empty($code) || !empty($code["day_active"]) ? false : true,
            "message" => empty($code) || !empty($code["day_active"]) ? "mã code không đúng hoặc đã được sử dụng" : "Thành công"
        ];
    }
    /**
     * code
     * @return array
     */
    public function attributes(): array
    {
        return [
            "email" => 'Địa chỉ email',
            "code" => 'Mã code'
        ];
    }
}
