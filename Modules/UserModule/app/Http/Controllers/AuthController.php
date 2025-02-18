<?php

namespace Modules\UserModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Services\UserService;

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
}
