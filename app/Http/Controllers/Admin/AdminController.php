<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Customers;
use App\Models\CustomerValue;
use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use App\Services\AdminService;
use App\Services\AdminStaticService;
use App\Services\ApiService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        try {
            $provinceId = $request->province_id ?? '';
            $districtId = $request->district_id ?? '';

            $provinces = Province::all()->keyBy('id')->toArray();
            $districts = District::all()->keyBy('id')->toArray();
            $customers = Customers::whereIn('user_type_id', [4])
                ->whereNotNull('province_id')
                ->where('phone', '!=', '')
                ->when($provinceId, function ($q) use ($provinceId) {
                    $q->where('province_id', $provinceId);
                })
                ->when($districtId, function ($q) use ($districtId) {
                    $q->where('district_id', $districtId);
                })
                ->paginate(12);

            foreach ($customers as $customer) {
                $address = '';
                $valueAddress = CustomerValue::where([
                    'user_id' => $customer->user_id,
                    'user_field' => 'address',
                ])->first('value')->value ?? null;
                $wardId = CustomerValue::where([
                    'user_id' => $customer->user_id,
                    'user_field' => 'ward_id',
                ])->first('value')->value ?? null;

                $ward = Ward::where('id', $wardId)->first('name')->name ?? null;

                $customer->avatar = CustomerValue::where([
                    'user_id' => $customer->user_id,
                    'user_field' => 'image',
                ])->first('value')->value ?? null;
                $customer->district_id = CustomerValue::where([
                    'user_id' => $customer->user_id,
                    'user_field' => 'district_id',
                ])->first('value')->value ?? null;
                if (!empty($valueAddress)) {
                    $address = $valueAddress;
                }
                if (!empty($ward)) {
                    $address = !empty($address) ? $address . ', ' . $ward : $ward;
                }
                if (!empty($customer->district_id)) {
                    $address = !empty($address) ? $address . ', ' . @$districts[$customer->district_id]['name'] : @$districts[$customer->district_id]['name'];
                }
                $customer->address = !empty($address) ? $address . ', ' . @$provinces[$customer->province_id]['name'] : @$provinces[$customer->province_id]['name'];
            }
            if (!Auth::check()) {
                return view("pages.login", compact('provinces', 'districts', 'customers'));
            }

            return view('dashboard.index', compact('provinces', 'districts', 'customers'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Login
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function submitLogin(LoginRequest $request): RedirectResponse
    {
        try {
            $inputs = $request->all();
            $user = Arr::only($inputs, ["email", "password"]);

            if (Auth::guard('admin')->attempt($user)) {
                return redirect()->route('dashboard.index');
            }

            return redirect()
                ->back()
                ->withErrors('Email hoặc mật khẩu không đúng');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()
                ->back()
                ->withErrors('Login không thành công');
        }
    }

    /**
     * logout
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        try {
            if (Auth::guard('admin')->check()) {
                Auth::guard('admin')->logout();
            }
            return redirect()->route("login");
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * list admin
     * @return Application|Factory|View
     */
    public function list()
    {
        $admins = ApiService::adminService()->getAll();

        return view("pages.admin.list", ["admins" => $admins]);
    }

    /**
     * create admin
     * @return Application|Factory|View
     */
    public function create()
    {
        $routes = Route::getRoutes();
        $urls = [];
        foreach ($routes as $route) {
            strpos($route->uri(), "admin") === 0 && $urls[] = $route->getName();
        }

        return view("pages.admin.create", [
            "action" => "create",
            "urls" => $urls,
            "router" => route("admin.manager.store")
        ]);
    }

    /**
     * save admin
     * @param CreateAdminRequest $request
     * @return RedirectResponse
     */
    public function store(CreateAdminRequest $request): RedirectResponse
    {
        ApiService::adminService()->create(Arr::only($request->all(), [
            "email",
            "password",
            "roles"
        ]));
        return redirect()->route("admin.manager.list");
    }

    /**
     * edit admin
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $admin = ApiService::adminService()->getDetail($id);
        $routes = Route::getRoutes();
        $urls = [];
        foreach ($routes as $route) {
            strpos($route->uri(), "admin") === 0 && $urls[] = $route->getName();
        }

        return view("pages.admin.create", [
            "action" => "edit",
            "urls" => $urls,
            "admin" => $admin,
            "router" => route("admin.manager.update", ["id" => $id])
        ]);
    }

    /**
     * update admin
     * @param UpdateAdminRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(UpdateAdminRequest $request, $id): RedirectResponse
    {
        $dataUpdate = Arr::only($request->all(), ["email", "roles"]);
        if (isset($request->password)) {
            $dataUpdate["password"] = $request->password;
        }

        ApiService::adminService()->update($dataUpdate, $id);

        return redirect()->route("admin.manager.list");
    }

    /**
     * delete admin
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Request $request): RedirectResponse
    {
        ApiService::adminService()->delete($request->id);

        return redirect()->route("admin.manager.list");
    }

}
