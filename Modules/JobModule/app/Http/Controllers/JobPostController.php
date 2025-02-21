<?php

namespace Modules\JobModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\JobPostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\JobModule\Http\Requests\JobPost\InsertJobPostRequest;
use Modules\JobModule\Transformers\JobPostDetailResource;
use Modules\JobModule\Transformers\JobPostResource;

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
            $res = $this->jobPostService->insert($user->id, $insertJobPostRequest);
            if ($res) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Thêm bài tuyển dụng thành công'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Thêm bài tuyển dụng không thành công'
                ], 500);
            }
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Xác thực người dùng không thành công'
        ], 401);
    }

    public function getPagination(Request $request)
    {
        $jobPosts = $this->jobPostService->getPagination($request);
        if ($jobPosts !== null) {
            return JobPostResource::collection($jobPosts)
                ->additional(['status' => 'success']);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy bài tuyển dụng'
            ], 404);
        }
    }

    public function getDetail(Request $request)
    {
        $jobPost = $this->jobPostService->getDetail($request);
        if ($jobPost !== null) {
            return response()->json([
                'status' => 'success',
                'data' => new JobPostDetailResource($jobPost)
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy bài tuyển dụng'
            ], 404);
        }
    }
}
