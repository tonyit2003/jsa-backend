<?php

namespace Modules\JobModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UserCandidateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\JobModule\Http\Requests\CandidateProfile\CandidateProfileApplyRequest;

class CandidateProfileController extends Controller
{
    protected $userCandidateService;

    public function __construct(UserCandidateService $userCandidateService)
    {
        $this->userCandidateService = $userCandidateService;
    }

    public function checkApply(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            $res =  $this->userCandidateService->checkApply($user->id, $request);
            if ($res === true) {
                return response()->json([
                    'status' => 'applied',
                    'message' => 'Đã ứng tuyển',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'not_applied',
                    'message' => 'Chưa ứng tuyển'
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Xác thực người dùng không thành công'
            ], 401);
        }
    }

    public function apply(CandidateProfileApplyRequest $candidateProfileApplyRequest)
    {
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            $res =  $this->userCandidateService->apply($user->id, $candidateProfileApplyRequest);
            if ($res === true) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Đăng ký ứng tuyển thành công',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Đăng ký ứng tuyển không thành công'
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Xác thực người dùng không thành công'
            ], 401);
        }
    }
}
