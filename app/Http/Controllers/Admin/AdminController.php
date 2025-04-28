<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
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
    public function login()
    {
        try {
            if (!Auth::check()) {
                return view("pages.login");
            }
            return redirect()->route("dashboard.index");
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
