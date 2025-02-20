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
}
