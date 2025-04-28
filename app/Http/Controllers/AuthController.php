<?php

namespace App\Http\Controllers;

use App\Services\ApiService\AuthService;
use App\Services\ApiService\UserService;

/**
 * Class AuthController.
 *
 * @package namespace App\Http\Controllers;
 */
class AuthController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected AuthService $authService,
    )
    {
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        $user = $this->userService->updateUserLogin([
            'last_login' => now()
        ]);
        return $this->sendSuccess($user);
    }
}
