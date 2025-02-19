<?php

namespace Modules\UserModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Modules\UserModule\Http\Requests\Auth\AuthLoginRequest;
use Modules\UserModule\Http\Requests\Auth\AuthRegisterRequest;
use Modules\UserModule\Transformers\UserResource;
use Request;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(AuthRegisterRequest $authRegisterRequest)
    {
        $user = $this->userService->create($authRegisterRequest);
        if ($user !== null) {
            return response()->json([
                'message' => 'Đăng ký tài khoản thành công',
                'user' => $user
            ], 201);
        } else {
            return response()->json([
                'message' => 'Đăng ký tài khoản không thành công. Hãy thử lại.',
            ], 400);
        }
    }


    public function login(AuthLoginRequest $authLoginRequest)
    {
        $email = $authLoginRequest->input('email');
        $password = $authLoginRequest->input('password');
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => 'success',
                'message' => 'Đăng nhập thành công',
                'token' => $token,
            ], 200);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Tài khoản hoặc mật khấu không đúng',
        ], 401);
    }

    public function getUser(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        if ($user) {
            return response()->json([
                'status' => 'success',
                'user' => new UserResource($user)
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized'
        ], 401);
    }
}
