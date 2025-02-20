<?php

namespace App\Repositories;

use App\Models\Recruiters;
use App\Models\User;
use App\Repositories\Interfaces\UserRecruiterRepositoryInterface;

class UserRecruiterRepository extends BaseRepository implements UserRecruiterRepositoryInterface
{
    protected $model;

    public function __construct(Recruiters $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }
}
