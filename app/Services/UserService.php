<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\Interfaces\UserServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->all(['full_name', 'email', 'password', 'phone_number', 'user_type']);
            $user = $this->userRepository->insert($payload);
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            return null;
        }
    }
}
