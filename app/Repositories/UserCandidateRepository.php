<?php

namespace App\Repositories;

use App\Models\CandidateProfiles;
use App\Repositories\Interfaces\UserCandidateRepositoryInterface;

class UserCandidateRepository extends BaseRepository implements UserCandidateRepositoryInterface
{
    protected $model;

    public function __construct(CandidateProfiles $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }
}
