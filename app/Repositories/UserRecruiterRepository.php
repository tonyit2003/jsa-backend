<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRecruiterRepositoryInterface;

class UserRecruiterRepository extends BaseRepository implements UserRecruiterRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }

    public function pagination($page = 1, $perPage = 10)
    {
        return $this->model
            ->where('user_type', 'recruiter') // Lọc user_type là recruiter
            ->whereNull('deleted_at') //Lấy user chưa bị khóa deleted_at != null
            ->with(relations: 'recruiter') // Load hồ sơ ứng viên
            ->paginate($perPage, ['*'], 'page', $page);
    }
}
