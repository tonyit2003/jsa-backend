<?php

namespace Modules\AdminModule\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\AdminModule\Http\Res;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Modules\AdminModule\Http\Resources\UserCandidateResource;

class UserCandidateController extends Controller
{
    protected $userRepository;
    protected $userService;

    public function __construct(UserRepository $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $users = $this->userRepository->pagination($page);
        return UserCandidateResource::collection($users);
    }
}
