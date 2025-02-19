<?php

namespace Modules\AdminModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\UserRecruiterRepository;
use Modules\AdminModule\Http\Res;
use App\Repositories\UserRepository;
use App\Services\UserRecruiterService;
use Illuminate\Http\Request;
use Modules\AdminModule\Http\Resources\UserRecruiterResource;

class UserRecruitersController extends Controller
{
    protected $userRecruiterRepository;
    protected $userRecruiterService;

    public function __construct(UserRecruiterRepository $userRecruiterRepository, UserRecruiterService $userRecruiterService)
    {
        $this->userRecruiterRepository = $userRecruiterRepository;
        $this->userRecruiterService = $userRecruiterService;
    }

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $users = $this->userRecruiterRepository->pagination($page);
        return UserRecruiterResource::collection($users);
    }

    public function delete($id)
    {
        $user = $this->userRecruiterService->delete($id);
        if ($user !== null) {
            return response()->json([
                'message' => 'User deleted successfully',
                'user' => $user
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed to delete user. Please try again.',
            ], 400);
        }
    }
}
