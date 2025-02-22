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

    public function createEmpty($userId)
    {
        DB::beginTransaction();
        try {
            $payload = [
                'user_id' => $userId,
                'resume' => '',
                'skills' => '',
                'experience' => '',
                'education' => '',
            ];
            $this->userCandidateRepository->insert($payload);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function checkApply($userId, $request)
    {
        DB::beginTransaction();
        try {
            $candidates = $this->userCandidateRepository->searchByConditions(['user_id' => $userId]);
            if ($candidates->isEmpty()) {
                throw new Exception('User does not exist');
            }
            $candidate = $candidates->first();
            $jobId = $request->input('job_id');
            return $candidate->job_posts()->wherePivot('job_id', $jobId)->exists();
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function apply($userId, $request)
    {
        DB::beginTransaction();
        try {
            $candidates = $this->userCandidateRepository->searchByConditions(['user_id' => $userId]);
            if ($candidates->isEmpty()) {
                throw new Exception('User does not exist');
            }
            $candidate = $candidates->first();
            $jobId = $request->input('job_id');
            $candidate->job_posts()->attach($jobId, [
                'application_status' => 'applied',
                'applied_at'         => now(),
                'deleted_at'         => null,
            ]);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
