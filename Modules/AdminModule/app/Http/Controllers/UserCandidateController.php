<?php

namespace Modules\AdminModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\UserCandidateRepository;
use Modules\AdminModule\Http\Res;
use App\Repositories\UserRepository;
use App\Services\UserCandidateService;
use Illuminate\Http\Request;
use Modules\AdminModule\Http\Resources\UserCandidateResource;

class UserCandidateController extends Controller
{
    protected $userCandidateRepository;
    protected $userCandidateService;

    public function __construct(UserCandidateRepository $userCandidateRepository, UserCandidateService $userCandidateService)
    {
        $this->userCandidateRepository = $userCandidateRepository;
        $this->userCandidateService = $userCandidateService;
    }

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $users = $this->userCandidateRepository->pagination($page);
        return UserCandidateResource::collection($users);
    }

    public function delete($id)
    {
        $user = $this->userCandidateService->delete($id);
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
