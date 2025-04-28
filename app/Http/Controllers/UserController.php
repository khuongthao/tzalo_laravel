<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\UserQuestionRequest;
use App\Http\Requests\Api\UserSettingRequest;
use App\Services\ApiService\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class UserController.
 *
 * @package namespace App\Http\Controllers;
 */
class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    )
    {}
}
