<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Lấy list danh sách của user
     * @param Request $request
     */
    public function list(Request $request)
    {
        try {
            $inputs = $request->all();
            $page = $inputs["page"] ?? 1;
            $email = $inputs["email"] ?? null;
            $dataCustomers = AdminService::UserService()->getListCustomers([
                "page" => $page,
                "email" => $email
            ]);
            return view("pages.customer.list", [
                "email" => $email,
                "page" => $page,
                "totalPages" => $dataCustomers["totalPage"],
                "customers" => $dataCustomers["customers"]
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

        /**
     * Lấy list danh sách của user
     * @param Request $request
     */
    public function listDelete(Request $request)
    {
        try {
            $inputs = $request->all();
            $page = $inputs["page"] ?? 1;
            $email = $inputs["email"] ?? null;
            $code = $inputs["code"] ?? null;
            $display_name = $inputs["display_name"] ?? null;
            $dataCustomers = AdminStaticService::UserService()->getListCustomersDelete([
                "page" => $page,
                "email" => $email,
                "code" => str_replace('-', '', $code),
                "display_name" => $display_name
            ]);
            return view("pages.customer.list", [
                "email" => $email,
                "display_name" => $display_name,
                "code" => $code,
                "page" => $page,
                "totalPages" => $dataCustomers["totalPage"],
                "customers" => $dataCustomers["customers"]
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    /**
     * Lấy thông tin cá nhân của user
     * @param [type] $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function detail($id)
    {
        $customer = AdminService::UserService()->getUserById($id);

        return view("pages.customer.detail", ["customer" => $customer]);
    }

    public function update(Request $request, $id)
    {
        try {
            $inputs = $request->all();

            AdminService::UserService()->updateCustomer($inputs, $id);

            return redirect()
                ->back()
                ->with('success', 'Cập nhật thành công');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('errors', 'Cập nhật thất bại');
        }
    }
}
