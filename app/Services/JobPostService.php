<?php

namespace App\Services;

use App\Repositories\JobPostRepository;
use App\Repositories\UserRecruiterRepository;
use App\Services\Interfaces\JobPostServiceInterface;
use DB;
use Exception;

class JobPostService extends BaseService implements JobPostServiceInterface
{
    protected $userRecruiterRepository;
    protected $jobPostRepository;

    public function __construct(UserRecruiterRepository $userRecruiterRepository, JobPostRepository $jobPostRepository)
    {
        $this->userRecruiterRepository = $userRecruiterRepository;
        $this->jobPostRepository = $jobPostRepository;
    }

    public function getInformation($id)
    {
        DB::beginTransaction();
        try {
            $res = $this->jobPostRepository->findById($id);
            DB::commit();
            return $res;
        } catch (Exception $e) {
            DB::rollBack();
            return null;
        }
    }

    public function insert($userId, $request)
    {
        DB::beginTransaction();
        try {
            $recruiter_id = $this->userRecruiterRepository->searchByConditions(['user_id' => $userId])->first()->id ?? null;
            if (!$recruiter_id) {
                throw new Exception('Recruiter not found');
            }
            $payload = [
                'recruiter_id' => $recruiter_id,
                'job_title' => $request->input('job_title'),
                'job_description' => $request->input('job_description'),
                'job_requirements' => $request->input('job_requirements'),
                'job_location' => $request->input('job_location'),
                'job_type' => $request->input('job_type'),
                'salary_range' => $request->input('salary_range'),
                'status' => 'pending',
            ];
            $this->jobPostRepository->insert($payload);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return false;
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->all();
            $user = $this->jobPostRepository->update($id, $payload);
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return null;
        }
    }
}
