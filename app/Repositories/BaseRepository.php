<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Phân trang dữ liệu kèm theo eager load các relationship và áp dụng điều kiện.
     *
     * @param int   $page       Số trang cần lấy, mặc định là trang 1.
     * @param int   $perPage    Số bản ghi trên mỗi trang, mặc định là 10.
     * @param array $relations  Mảng chứa tên các relationship muốn eager load.
     * @param array $conditions Mảng chứa các điều kiện dạng key-value để áp dụng where.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Trả về đối tượng phân trang.
     */
    public function pagination($page = 1, $perPage = 10, $relations = [], $conditions = [])
    {
        $query = $this->model->with($relations);

        if (!empty($conditions)) {
            foreach ($conditions as $column => $value) {
                $query->where($column, $value);
            }
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }


    public function search($filters = [])
    {
        $query = $this->model->query();

        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                $query->where($field, 'LIKE', '%' . $value . '%');
            }
        }

        return $query->get();
    }

    /**
     * Tìm kiếm theo điều kiện.
     *
     * @param array $conditions Danh sách điều kiện tìm kiếm.
     *        Mỗi phần tử của mảng có thể là dạng:
     *         - 'field' => 'value' (so sánh bằng)
     *         - 'field' => [operator, value] (ví dụ: ['like', '%keyword%'])
     * @param array $with Danh sách quan hệ cần eager load (mặc định rỗng)
     * @param array $select Các cột cần lấy (mặc định lấy tất cả)
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchByConditions(array $conditions = [], array $with = [], array $select = ['*'])
    {
        $query = $this->model->select($select);

        if (!empty($with)) {
            $query->with($with);
        }

        foreach ($conditions as $field => $value) {
            if (is_array($value)) {
                if (count($value) === 2) {
                    [$operator, $val] = $value;
                    $query->where($field, $operator, $val);
                }
            } else {
                $query->where($field, $value);
            }
        }

        return $query->get();
    }


    public function findById($modelId)
    {
        return $this->model->findOrFail($modelId);
    }

    public function insert($payload = [])
    {
        return $this->model->create($payload)->fresh();
    }

    public function update($id = 0, $payload = [])
    {
        $model = $this->findById($id);
        $model->fill($payload);
        $model->save();
        return $model;
    }

    public function updateOrInsert($conditions, $data)
    {
        return $this->model->updateOrInsert($conditions, $data);
    }

    public function delete($id = 0)
    {
        return $this->findById($id)->delete();
    }
}
