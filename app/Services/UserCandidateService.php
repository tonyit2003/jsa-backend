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
