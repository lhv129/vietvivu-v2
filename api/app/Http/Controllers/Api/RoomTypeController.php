<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\RoomTypeService;
use App\Http\Controllers\Api\BaseController;

class RoomTypeController extends BaseController
{
    protected $service;

    public function __construct(RoomTypeService $service)
    {
        $this->service = $service;
    }

    // Lấy danh sách loại phòng (room-types) theo hotel
    public function getByHotelSlug(string $slug)
    {
        $perPage = request()->query('per_page', 10);

        $roomTypes = $this->service->getByHotelSlug($slug, $perPage);

        return $this->paginateResponse($roomTypes, "Lấy danh sách khách sạn thành công", 200);
    }



    public function show($id)
    {
        $data = $this->service->find($id);

        return $this->responseCommon(
            true,
            "Tìm loại phòng thành công",
            $data
        );
    }

    public function store(Request $request)
    {
        $data = $this->service->create($request->all());

        return $this->responseCommon(
            true,
            "Thêm loại phòng thành công",
            $data,
            201
        );
    }

    public function update(Request $request, $id)
    {
        $data = $this->service->update($id, $request->all());

        return $this->responseCommon(
            true,
            "Cập nhật loại phòng thành công",
            $data
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return $this->responseCommon(
            true,
            "Xóa loại phòng thành công",
            []
        );
    }

    public function updateIsActive($id)
    {
        $roomType = $this->service->updateIsActive($id);
        return $this->responseCommon(true, 'Cập nhật trạng thái hoạt động thành công', $roomType, 200);
    }
}
