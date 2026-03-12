<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Helpers\SlugHelper;
use App\Repositories\AmenityRepository;
use App\Services\BaseService;

class AmenityService extends BaseService
{
    public function __construct(AmenityRepository $repository)
    {
        parent::__construct($repository);
    }
    protected string $notFoundMessage = "Tiện ích không tồn tại hoặc đã bị xóa.";


    public function create(array $data)
    {
        // Tạo slug từ name
        $data['slug'] = SlugHelper::createSlug($data['name']);

        // Lấy sort_order tiếp theo
        $data['sort_order'] = $this->repository->getNextSortOrder();

        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->repository->find($id);

        if (!$record) {
            throw new ApiException($this->notFoundMessage, 404);
        }

        // Tạo lại slug từ name
        $data['slug'] = SlugHelper::createSlug($data['name']);

        return $this->repository->update($record, $data);
    }
}
