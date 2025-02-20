<?php

namespace App\Repositories;

use App\Models\JobPost;
use App\Repositories\Interfaces\JobPostRepositoryInterface;

class JobPostRepository extends BaseRepository implements JobPostRepositoryInterface
{
    protected $model;

    public function __construct(JobPost $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }
}
