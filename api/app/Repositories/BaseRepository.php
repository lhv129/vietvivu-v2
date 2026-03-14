<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    /**
     * Model sẽ được inject từ Repository con
     * Ví dụ: AmenityRepository sẽ truyền model Amenity vào
     */
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Lấy danh sách dữ liệu có phân trang
     * 
     * - Chỉ lấy những bản ghi đang active
     * - Sắp xếp theo sort_order tăng dần
     * - $this->model->active() -> chỉ hoạt động nếu model có scopeActive()
     *
     * @param int $limit số bản ghi mỗi trang
     */
    public function paginate($limit = 10)
    {
        return $this->model
            ->active()
            ->orderBy('sort_order', 'asc')
            ->paginate($limit);
    }

    /**
     * Lấy toàn bộ danh sách
     * 
     * Sắp xếp theo id giảm dần (mới nhất trước)
     */
    public function all()
    {
        return $this->model
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * Tìm bản ghi theo ID
     * 
     * Trả về null nếu không tồn tại
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Tìm bản ghi theo ID
     * 
     * Nếu không tồn tại sẽ throw ModelNotFoundException
     */
    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Tạo bản ghi mới
     *
     * @param array $data dữ liệu cần insert
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Tạo nhiều bản ghi
     *
     * @param array $data dữ liệu cần insert
     */
    public function bulkInsert(array $data)
    {
        return $this->model->insert($data);
    }


    /**
     * Cập nhật bản ghi
     *
     * @param Model $model model cần update
     * @param array $data dữ liệu cập nhật
     */
    public function update(Model $model, array $data)
    {
        $model->update($data);

        // fresh() giúp reload lại dữ liệu mới nhất từ database
        return $model->fresh();
    }

    /**
     * Xóa bản ghi
     *
     * Hỗ trợ cả soft delete nếu model có SoftDeletes
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }

    /**
     * Lấy giá trị sort_order tiếp theo
     *
     * Ví dụ:
     * max(sort_order) = 5
     * => next = 6
     *
     * @param string $column tên column sort
     */
    public function getNextSortOrder(string $column = 'sort_order'): int
    {
        return ($this->model->max($column) ?? 0) + 1;
    }

    /**
     * update is_active theo ID
     *
     * Hỗ trợ cả soft delete nếu model có SoftDeletes
     */

    public function updateIsActive(Model $model)
    {
        $model->update([
            'is_active' => !$model->is_active
        ]);

        return $model->refresh();
    }
}
