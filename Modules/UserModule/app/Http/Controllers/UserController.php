<?php

namespace Modules\UserModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function updateInformation(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            $this->userService->updateInformation($user->id, $request);
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thông tin cá nhân thành công',
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Xác thực người dùng không thành công'
        ], 401);
    }
}
