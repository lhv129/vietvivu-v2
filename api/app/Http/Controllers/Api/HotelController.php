<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Hotel\StoreHotelRequest;
use App\Http\Requests\Hotel\UpdateHotelRequest;
use App\Services\HotelService;
use Illuminate\Http\Request;

class HotelController extends BaseController
{
    protected $service;

    public function __construct(HotelService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $hotels = $this->service->index($request->limit ?? 10);
        return $this->paginateResponse(
            $hotels,
            "Lấy danh sách khách sạn thành công"
        );
    }

    public function show($id)
    {
        $hotel = $this->service->find($id);
        return $this->responseCommon(true, 'Tìm thành công khách sạn', $hotel, 200);
    }

    public function store(StoreHotelRequest $request)
    {
        $hotel = $this->service->create($request->validated());
        return $this->responseCommon(true, 'Thêm mới khách sạn thành công', $hotel, 201);
    }

    public function update(UpdateHotelRequest $request, $id)
    {
        $hotel = $this->service->update($id, $request->validated());
        return $this->responseCommon(true, 'Cập nhật khách sạn thành công', $hotel, 201);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return $this->responseCommon(true, 'Xóa khách sạn thành công', [], 200);
    }

    public function publish($id)
    {
        $hotel = $this->service->find($id);

        $this->service->publish($hotel);

        return $this->responseCommon(true, 'Đăng tải thành công', [], 200);
    }
}
