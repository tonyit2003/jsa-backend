<?php

namespace Modules\AdminModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Modules\AdminModule\Http\Resources\UserAdminResource;

class UserAdminController extends Controller
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
        $users = $this->userRepository->paginationAdmin($page);
        return UserAdminResource::collection($users);
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

        $info = $this->userService->getInformation($id);

        return response()->json([
            'status' => 'success',
            'data' => $info,
        ], 200);
    }

    public function store(Request $request)
    {
        $user = $this->userService->create($request);
        if ($user !== null) {
            return response()->json([
                'message' => 'User created successfully',
                'user' => $user
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed to create user. Please try again.',
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $user = $this->userService->update($id, $request);
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

    public function delete($id)
    {
        $user = $this->userService->delete($id);
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
