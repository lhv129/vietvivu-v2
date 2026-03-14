<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Helpers\ImageHelper;
use App\Helpers\SlugHelper;
use App\Repositories\HotelRepository;
use App\Repositories\UserRepository;
use App\Services\RoomTypeCalendarService;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class HotelService extends BaseService
{
    protected string $notFoundMessage = "Khách sạn không tồn tại hoặc đã bị xóa.";

    protected $mediaService;
    protected $userRepository;
    protected $roomTypeCalendarService;

    public function __construct(
        HotelRepository $repository,
        MediaService $mediaService,
        UserRepository $userRepository,
        RoomTypeCalendarService $roomTypeCalendarService
    ) {
        parent::__construct($repository);

        $this->mediaService = $mediaService;
        $this->roomTypeCalendarService = $roomTypeCalendarService;
        $this->userRepository = $userRepository;
    }

    public function index($limit)
    {
        return $this->repository->index($limit);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $media = $data['media'] ?? [];
            unset($data['media']);

            $data['slug'] = SlugHelper::createSlug($data['title']);
            $data['author_id'] = JWTAuth::user()->id;
            $data['sort_order'] = $this->repository->getNextSortOrder();

            /**
             * tạo hotel trước để lấy id
             */
            $hotel = $this->repository->create($data);

            /**
             * upload featured image
             */
            if (isset($data['featured_image'])) {

                $featured = ImageHelper::uploadSingle(
                    $data['featured_image'],
                    "hotels/{$hotel->id}"
                );

                $this->repository->update($hotel, [
                    'featured_image' => $featured
                ]);
            }

            /**
             * gallery
             */
            if (!empty($media)) {

                $this->mediaService->syncMedia(
                    'hotel',
                    $hotel->id,
                    $media
                );
            }

            return $hotel->load('media');
        });
    }

    public function update($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {

            $hotel = $this->repository->find($id);

            $media = $data['media'] ?? null;
            unset($data['media']);

            if (isset($data['title'])) {
                $data['slug'] = SlugHelper::createSlug($data['title']);
            }

            /**
             * update featured image
             */
            if (isset($data['featured_image'])) {

                $data['featured_image'] = ImageHelper::uploadSingle(
                    $data['featured_image'],
                    "hotels/$hotel->id",
                    $hotel->featured_image
                );
            }

            $hotel = $this->repository->update($hotel, $data);

            /**
             * update gallery
             */
            if ($media !== null) {

                $this->mediaService->syncMedia(
                    'hotel',
                    $hotel->id,
                    $media
                );
            }

            return $hotel->load('media');
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {

            $hotel = $this->repository->find($id);

            $medias = $this->mediaService->getByMediable('hotel', $id);

            foreach ($medias as $media) {
                ImageHelper::delete($media->path);
            }

            $this->mediaService->deleteByMediable('hotel', $id);

            if ($hotel->featured_image) {
                ImageHelper::delete($hotel->featured_image);
            }

            /**
             * delete folder
             */
            ImageHelper::deleteDirectory("uploads/hotels/$id");

            return $this->repository->delete($hotel);
        });
    }

    public function publish($hotel)
    {
        $user = JWTAuth::user();
        /**
         * check quyền
         */
        if ($user->id !== $hotel->author_id) {
            throw new ApiException('Bạn không có quyền đăng tải khách sạn này.', 403);
        }

        $roomTypes = $hotel->roomTypes()
            ->where('is_active', 1)
            ->get();

        if ($roomTypes->isEmpty()) {
            throw new ApiException(
                'Khách sạn phải có ít nhất một loại phòng đang hoạt động trước khi đăng tải.',
                404
            );
        }

        DB::transaction(function () use ($hotel, $roomTypes) {

            $hotel->update([
                'status' => 'published'
            ]);

            foreach ($roomTypes as $roomType) {

                $this->roomTypeCalendarService->generate($roomType);
            }
        });
    }
}
