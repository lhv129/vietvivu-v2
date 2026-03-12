<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Amenity\CreateAmenityRequest;
use App\Http\Requests\Amenity\UpdateAmenityRequest;
use App\Services\AmenityService;
use Illuminate\Http\Request;

class AmenityController extends BaseController
{
    protected $service;

    public function __construct(AmenityService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $amenities = $this->service->paginate($request->limit ?? 10);
        return $this->paginateResponse(
            $amenities,
            "Lấy danh sách tiện ích thành công"
        );
    }

    public function show($id)
    {
        $amenities = $this->service->find($id);
        return $this->responseCommon(true, 'Tìm thành công tiện ích', $amenities, 200);
    }

    public function store(CreateAmenityRequest $request)
    {
        $amenity = $this->service->create($request->validated());
        return $this->responseCommon(true, 'Thêm mới tiện ích thành công', $amenity, 201);
    }

    public function update(UpdateAmenityRequest $request, $id)
    {
        $amenity = $this->service->update($id, $request->validated());
        return $this->responseCommon(true, 'Cập nhật tiện ích thành công', $amenity, 201);
    }

    public function destroy($id){
        $this->service->delete($id);
        return $this->responseCommon(true, 'Xóa tiện ích thành công', [], 200);
    }
}
