<?php

namespace App\Http\Middleware\Api;

use App\Models\User;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if (!$request->bearerToken()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $decode = $this->decodeToken($request->bearerToken());
            if (!empty($decode)) {

                return $next($request);
            }
            return response()->json(['error' => 'Unauthorized'], 401);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * decode token
     * @param $token
     * @return array
     */
    public function decodeToken(string $token): array
    {
        try {
            $key = new Key(ENV('JWT_SECRET'), ENV('JWT_ALGO'));
            return (array)JWT::decode($token, $key);
        } catch (\Exception $e) {
            return [];
        }
    }

    public function updateUser($user, $uid, $email, $userToken)
    {
        $updateData = [];

        if (empty($user->email)) {
            $updateData['email'] = $email;
        }
        if (empty($user->uid)) {
            $updateData['uid'] = $uid;
        }
        if (empty($user->user_token)) {
            $updateData['user_token'] = $userToken;
        }

        if (!empty($updateData)) {
            $user->update($updateData);
        }
    }
}
