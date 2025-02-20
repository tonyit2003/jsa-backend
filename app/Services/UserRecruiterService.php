<?php

namespace App\Services;

use App\Repositories\UserCandidateRepository;
use App\Repositories\UserRecruiterRepository;
use App\Services\Interfaces\UserCandidateServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class UserRecruiterService extends BaseService implements UserCandidateServiceInterface
{
    protected $userCandidateRepository;
    protected $userRecruiterRepository;

    public function __construct(UserCandidateRepository $userCandidateRepository, UserRecruiterRepository $userRecruiterRepository)
    {
        $this->userCandidateRepository = $userCandidateRepository;
        $this->userRecruiterRepository = $userRecruiterRepository;
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $user = $this->userCandidateRepository->delete($id);
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            return null;
        }
    }

    public function getInformation($userId)
    {
        DB::beginTransaction();
        try {
            $res = $this->userRecruiterRepository->searchByConditions(['user_id' => $userId]);
            DB::commit();
            return $res;
        } catch (Exception $e) {
            DB::rollBack();
            return null;
        }
    }

    public function updateInformation($userId, $request)
    {
        DB::beginTransaction();
        try {
            $conditions = ['user_id' => $userId];
            $data = array_filter([
                'company_name' => $request->input('company_name') ?? '',
                'company_description' => $request->input('company_description') ?? '',
                'company_website' => $request->input('company_website') ?? '',
                'created_at' => now(),
                'updated_at' => now(),
            ], fn($value) => $value !== '');
            $this->userRecruiterRepository->updateOrInsert($conditions, $data);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
