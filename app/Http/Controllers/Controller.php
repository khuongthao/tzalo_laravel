<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function sendSuccess($data, $message = 'Success', $statusCode = 200)
    {
        $response = [
            'data' => $data,
            'msg' => $message,
        ];

        return response()->json($response, $statusCode);
    }

    protected function sendError($message, $statusCode = 400, $data = [])
    {
        $response = [
            'msg' => $message,
            'data' => $data,
        ];

        return response()->json($response, $statusCode);
    }
}
