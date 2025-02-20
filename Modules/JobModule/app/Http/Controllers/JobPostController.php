<?php

namespace Modules\JobModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\JobPostService;
use Illuminate\Support\Facades\Auth;
use Modules\JobModule\Http\Requests\JobPost\InsertJobPostRequest;

class JobPostController extends Controller
{
    protected $jobPostService;

    public function __construct(JobPostService $jobPostService)
    {
        $this->jobPostService = $jobPostService;
    }

    public function insert(InsertJobPostRequest $insertJobPostRequest)
    {
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            $this->jobPostService->insert($user->id, $insertJobPostRequest);
            return response()->json([
                'status' => 'success',
                'message' => 'Đăng bài tuyển dụng thành công',
            ], 200);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Xác thực người dùng không thành công'
        ], 401);
    }
}
