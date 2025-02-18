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
     * @todo: Hàm dùng để phân trang cho các mô hình dữ liệu.
     * @purpose:
     *  - Trả về kết quả phân trang của một mô hình Eloquenttrang.
     * @author: Tony
     * @since: 15-01-2025
     * @param int $page (mặc định là 1) - Số trang hiện tại.
     * @param int $perPage (mặc định là 10) - Số lượng kết quả trên mỗi trang.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator - Đối tượng phân trang chứa dữ liệu và thông tin phân trang.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException - Nếu mô hình không tìm thấy trong cơ sở dữ liệu.
     */
    public function pagination($page = 1, $perPage = 15)
    {
        return $this->model->paginate($perPage, ['*'], 'page', $page);
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


    public function findById($modelId)
    {
        return $this->model->findOrFail($modelId);
    }

    /**
     * @todo: Thêm một bản ghi mới vào cơ sở dữ liệu và trả về đối tượng đầy đủ dữ liệu vừa được lưu.
     * @purpose:
     *  - Hàm này thực hiện việc thêm một bản ghi mới vào cơ sở dữ liệu dựa trên dữ liệu được cung cấp thông qua `$payload`.
     *  - Sau khi thêm mới, bản ghi sẽ được tải lại từ cơ sở dữ liệu để đảm bảo nhận được các giá trị tự động sinh (nếu có).
     * @author: Tony
     * @since: 17-01-2025
     * @param array $payload - Mảng dữ liệu cần thêm mới, bao gồm các key tương ứng với các cột trong bảng.
     * @return \Illuminate\Database\Eloquent\Model|null - Đối tượng model đầy đủ dữ liệu vừa được lưu hoặc `null` nếu không thành công.
     * @throws \Exception - Nếu quá trình thêm bản ghi gặp lỗi.
     */
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

    public function delete($id = 0)
    {
        return $this->findById($id)->delete();
    }
}
