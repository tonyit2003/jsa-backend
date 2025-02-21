<?php

namespace App\Services;

use App\Repositories\UserCandidateRepository;
use App\Services\Interfaces\UserCandidateServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class UserCandidateService extends BaseService implements UserCandidateServiceInterface
{
    protected $userCandidateRepository;

    public function __construct(UserCandidateRepository $userCandidateRepository)
    {
        $this->userCandidateRepository = $userCandidateRepository;
    }

    public function getInformation($userId)
    {
        DB::beginTransaction();
        try {
            $res = $this->userCandidateRepository->searchByConditions(['user_id' => $userId], ['user']);
            DB::commit();
            return $res->first() ?? null;
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
            $data = [
                'resume' => $request->input('resume') ?? '',
                'skills' => $request->input('skills') ?? '',
                'experience' => $request->input('experience') ?? '',
                'education' => $request->input('education') ?? '',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $this->userCandidateRepository->updateOrInsert($conditions, $data);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
