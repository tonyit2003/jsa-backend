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

    public function paginationJobPost($page = 1, $perPage = 10)
    {
        return $this->model->paginate($perPage, ['*'], 'page', $page);
    }

    public function findById($modelId)
    {
        return $this->model->with('recruiters')->findOrFail($modelId);
    }
}
