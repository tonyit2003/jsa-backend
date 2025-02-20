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

    public function getInformation($id)
    {
        DB::beginTransaction();
        try {
            $res = $this->userRepository->findById($id);
            DB::commit();
            return $res;
        } catch (Exception $e) {
            DB::rollBack();
            return null;
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->all();
            $user = $this->userRepository->update($id, $payload);
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return null;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->delete($id);
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            return null;
        }
    }
}
