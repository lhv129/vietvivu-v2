<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Helpers\SlugHelper;
use App\Repositories\FacilityRepository;
use App\Services\BaseService;

class FacilityService extends BaseService
{
    public function __construct(FacilityRepository $repository)
    {
        parent::__construct($repository);
    }
    protected string $notFoundMessage = "Cơ sở vật chất không tồn tại hoặc đã bị xóa.";

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
