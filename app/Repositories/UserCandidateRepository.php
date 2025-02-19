<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserCandidateRepositoryInterface;

class UserCandidateRepository extends BaseRepository implements UserCandidateRepositoryInterface
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
            ->where('user_type', 'candidate') // Lọc user_type là candidate
            ->whereNull('deleted_at') //Lấy user chưa bị khóa deleted_at != null
            ->with(relations: 'candidateProfile') // Load hồ sơ ứng viên
            ->paginate($perPage, ['*'], 'page', $page);
    }
}
