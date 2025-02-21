<?php

namespace Modules\UserModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UserCandidateService;
use Auth;
use Illuminate\Http\Request;

class UserCandidateController extends Controller
{
    protected $userCandidateService;

    public function __construct(UserCandidateService $userCandidateService)
    {
        $this->userCandidateService = $userCandidateService;
    }

    public function getInformation()
    {
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            $companyInformation = $this->userCandidateService->getInformation($user->id);
            return response()->json([
                'status' => 'success',
                'data' => $companyInformation
            ], 200);
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
            $this->userCandidateService->updateInformation($user->id, $request);
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thông tin công ty thành công',
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Xác thực người dùng không thành công'
        ], 401);
    }
}
