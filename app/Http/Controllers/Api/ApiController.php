<?php

namespace App\Http\Controllers\API;

use App\Models\Http;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function responseSuccess($data, $message = [], $httpCode = Http::HTTP_RESPONSE_SUCCESS)
    {
        $res = [
            'message' => $message, 
            'data' => $data
        ];

        $this->sendResponse($res, $httpCode);
    }

    public function responseError($data, $message = [], $httpCode = Http::HTTP_RESPONSE_SERVER_ERROR)
    {
        $res = [
            'message' => $message, 
            'data' => $data
        ];

        $this->sendResponse($res, $httpCode);
    }

    public function sendResponse($res, $httpCode) {
        return response()->json($res, $httpCode);
    }
}
