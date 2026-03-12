<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Helpers\ImageHelper;
use App\Helpers\SlugHelper;
use App\Repositories\LocationRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class LocationService extends BaseService
{
    public function __construct(LocationRepository $repository)
    {
        parent::__construct($repository);
    }
    protected string $notFoundMessage = "Địa điểm không tồn tại";

    public function create(array $data, $thumbnail = null)
    {
        $uploadedImage = null;

        try {

            DB::beginTransaction();

            $data['slug'] = SlugHelper::createSlug($data['name']);
            $data['sort_order'] = $this->repository->getNextSortOrder();

            if ($thumbnail) {
                $uploadedImage = ImageHelper::uploadSingle(
                    $thumbnail,
                    'locations'
                );

                $data['thumbnail'] = $uploadedImage;
            }

            $model = $this->repository->create($data);

            DB::commit();

            return $model;
        } catch (\Throwable $e) {

            DB::rollBack();

            // xóa ảnh nếu đã upload
            if ($uploadedImage) {
                ImageHelper::delete($uploadedImage);
            }

            throw $e;
        }
    }

    public function update($id, array $data, $thumbnail = null)
    {
        $location = $this->repository->find($id);

        if (!$location) {
            throw new ApiException("Địa điểm không tồn tại", 404);
        }

        // Lưu slug mới nếu name thay đổi
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
