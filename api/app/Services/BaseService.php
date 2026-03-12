<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Repositories\BaseRepository;

class BaseService
{
    // Repository dùng để thao tác database
    protected BaseRepository $repository;

    // Message mặc định khi không tìm thấy bản ghi
    protected string $notFoundMessage = "Bản ghi không tồn tại";

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Lấy danh sách dữ liệu có phân trang
     *
     * @param int $limit số bản ghi mỗi trang
     */
    public function paginate($limit = 10)
    {
        return $this->repository->paginate($limit);
    }

    /**
     * Tìm bản ghi theo ID
     *
     * Nếu không tồn tại sẽ throw ApiException
     */
    public function find($id)
    {
        $data = $this->repository->find($id);

        if (!$data) {
            throw new ApiException($this->notFoundMessage, 404);
        }

        return $data;
    }

    /**
     * Tạo mới bản ghi
     *
     */
    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * Cập nhật bản ghi theo ID
     *
     * - Tìm bản ghi trước khi update
     * - Tự động cập nhật slug nếu name thay đổi
     */
    public function update($id, array $data)
    {
        $record = $this->repository->find($id);
        
        return $this->repository->update($record, $data);
    }

    /**
     * Xóa bản ghi theo ID
     *
     * Nếu không tồn tại sẽ báo lỗi
     */
    public function delete($id)
    {
        $data = $this->repository->find($id);
        if (!$data) {
            throw new ApiException($this->notFoundMessage, 404);
        }
        return $this->repository->delete($data);
    }
}