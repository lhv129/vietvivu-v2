<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Helpers\ImageHelper;
use App\Helpers\SlugHelper;
use App\Repositories\LocationRepository;
use App\Services\BaseService;

class LocationService extends BaseService
{
    public function __construct(LocationRepository $repository)
    {
        parent::__construct($repository);
    }
    protected string $notFoundMessage = "Địa điểm không tồn tại";

    public function create(array $data, $thumbnail = null)
    {
        $data['slug'] = SlugHelper::createSlug($data['name']);

        if ($thumbnail) {

            $data['thumbnail'] = ImageHelper::uploadSingle(
                $thumbnail,
                'locations'
            );
        }

        return $this->repository->create($data);
    }

    public function update($id, array $data, $thumbnail = null)
    {
        $location = $this->repository->find($id);

        if (!$location) {
            throw new ApiException("Địa điểm không tồn tại", 404);
        }

        if (isset($data['name'])) {
            $data['slug'] = SlugHelper::createSlug($data['name']);
        }

        if ($thumbnail) {

            $data['thumbnail'] = ImageHelper::uploadSingle(
                $thumbnail, // ảnh mới
                'locations', // folder lưu ảnh
                $location->thumbnail // ảnh cũ
            );
        }

        return $this->repository->update($location, $data);
    }

    public function delete($id)
    {
        $location = $this->find($id);

        if ($location->thumbnail) {
            ImageHelper::delete($location->thumbnail);
        }

        return $this->repository->delete($location);
    }
}
