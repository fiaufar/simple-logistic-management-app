<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Http;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegistrationRequest;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegistrationRequest $request)
    {
        $data = $request->all();
        $result = [];

        try {
            $user = $this->authService->registerUser($data);
            $result['data']['user'] = $user;
        } catch (Exception $th) {
            Log::info($th->getMessage());

            $result['message'] = ['User registration failed!'];
            return response()->json($result, Http::HTTP_RESPONSE_SERVER_ERROR);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $result['data']['accessToken'] = $token;
        $result['message'] = ['User registration success!'];
        return response()->json($result, Http::HTTP_RESPONSE_SUCCESS);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()
                ->json(['message' => 'Unauthorized'], Http::HTTP_RESPONSE_UNAUTHORIZED);
        }

        $data = $request->all();
        $result = [];

        try {
            $user = $this->authService->getUserbyEmail($data['email']);
            $result['data']['user'] = $user;
        } catch (Exception $th) {
            Log::info($th->getMessage());

            $result['message'] = ['User login failed!'];
            return response()->json($result, Http::HTTP_RESPONSE_SERVER_ERROR);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $result['data']['accessToken'] = $token;
        $result['message'] = ['User login success!'];
        return response()->json($result, Http::HTTP_RESPONSE_SUCCESS);
    }
}
