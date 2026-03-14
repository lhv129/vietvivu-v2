<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Facility\CreateFacilityRequest;
use App\Http\Requests\Facility\UpdateFacilityRequest;
use App\Services\FacilityService;
use Illuminate\Http\Request;

class FacilityController extends BaseController
{
    protected $service;

    public function __construct(FacilityService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $facilities = $this->service->paginate($request->limit ?? 10);
        return $this->paginateResponse(
            $facilities,
            "Lấy danh sách cơ sở vật chất thành công"
        );
    }

    public function show($id)
    {
        $facilities = $this->service->find($id);
        return $this->responseCommon(true, 'Tìm thành công cơ sở vật chất', $facilities, 200);
    }

    public function store(CreateFacilityRequest $request)
    {
        $facility = $this->service->create($request->validated());
        return $this->responseCommon(true, 'Thêm mới cơ sở vật chất thành công', $facility, 201);
    }

    public function update(UpdateFacilityRequest $request, $id)
    {
        $facility = $this->service->update($id, $request->validated());
        return $this->responseCommon(true, 'Cập nhật cơ sở vật chất thành công', $facility, 201);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return $this->responseCommon(true, 'Xóa cơ sở vật chất thành công', [], 200);
    }
}
