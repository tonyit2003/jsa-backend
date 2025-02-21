<?php

namespace Modules\AdminModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\JobPostRepository;
use App\Services\JobPostService;
use Illuminate\Http\Request;
use Modules\AdminModule\Http\Resources\JobPostResource;

class JobPostController extends Controller
{
    protected $jobPostService;
    protected $jobPostRepository;

    public function __construct(JobPostService $jobPostService, JobPostRepository $jobPostRepository)
    {
        $this->jobPostService = $jobPostService;
        $this->jobPostRepository = $jobPostRepository;
    }

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $users = $this->jobPostRepository->paginationJobPost($page);
        return JobPostResource::collection($users);
    }

    public function getInformation(Request $request)
    {
        $id = $request->query('id'); // Lấy id từ query string (?id=1)

        if (!$id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Thiếu tham số id',
            ], 400);
        }

        $info = $this->jobPostService->getInformation($id);

        return response()->json([
            'status' => 'success',
            'data' => $info,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $user = $this->jobPostService->update($id, $request);
        if ($user !== null) {
            return response()->json([
                'message' => 'User updated successfully',
                'user' => $user
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed to update user. Please try again.',
            ], 400);
        }
    }
}
