<?php

namespace Modules\UserModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UserRecruiterService;
use Auth;
use Illuminate\Http\Request;

class UserRecruitersController extends Controller
{
    protected $userRecruiterService;

    public function __construct(UserRecruiterService $userRecruiterService)
    {
        $this->userRecruiterService = $userRecruiterService;
    }

    public function getInformation()
    {
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            $res = $companyInformation = $this->userRecruiterService->getInformation($user->id);
            if ($res) {
                return response()->json([
                    'status' => 'success',
                    'data' => $companyInformation
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Lấy thông tin công ty không thành công'
                ], 500);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Xác thực người dùng không thành công'
        ], 401);
    }

    public function updateInformation(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            $res = $this->userRecruiterService->updateInformation($user->id, $request);
            if ($res) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Cập nhật thông tin công ty thành công',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Cập nhật thông tin công ty không thành công'
                ], 500);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Xác thực người dùng không thành công'
        ], 401);
    }
}
