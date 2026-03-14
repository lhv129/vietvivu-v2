<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Helpers\ImageHelper;
use App\Repositories\RoomTypeRepository;
use Illuminate\Support\Facades\DB;

class RoomTypeService extends BaseService
{
    protected string $notFoundMessage = "Loại phòng không tồn tại.";

    public function __construct(RoomTypeRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Tạo room type
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            $featuredImage = $data['featured_image'] ?? null;
            $data['featured_image'] = '';

            $roomType = $this->repository->create($data);

            if ($featuredImage) {

                $path = ImageHelper::uploadSingle(
                    $featuredImage,
                    "hotels/{$roomType->hotel_id}/room-types/{$roomType->id}"
                );

                $this->repository->update($roomType, [
                    'featured_image' => $path
                ]);
            }

            return $roomType;
        });
    }

    /**
     * Update room type
     */
    public function update($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {

            $roomType = $this->repository->find($id);

            if (!$roomType) {
                throw new ApiException($this->notFoundMessage, 404);
            }

            if (isset($data['featured_image'])) {

                $data['featured_image'] = ImageHelper::uploadSingle(
                    $data['featured_image'],
                    "hotels/{$roomType->hotel_id}/room-types/{$roomType->id}",
                    $roomType->featured_image
                );
            }

            return $this->repository->update($roomType, $data);
        });
    }

    /**
     * Xóa room type
     */
    public function delete($id)
    {
        return DB::transaction(function () use ($id) {

            $roomType = $this->repository->find($id);

            if (!$roomType) {
                throw new ApiException($this->notFoundMessage, 404);
            }

            ImageHelper::deleteDirectory(
                "uploads/hotels/{$roomType->hotel_id}/room-types/{$roomType->id}"
            );

            return $this->repository->delete($roomType);
        });
    }
}
