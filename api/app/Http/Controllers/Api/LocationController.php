<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Location\CreateLocationRequest;
use App\Http\Requests\Location\UpdateLocationRequest;
use App\Services\LocationService;
use Illuminate\Http\Request;

class LocationController extends BaseController
{
    protected $service;

    public function __construct(LocationService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $locations = $this->service->paginate($request->limit ?? 10);

        return $this->paginateResponse(
            $locations,
            "Lấy danh sách địa điểm thành công"
        );
    }

    public function show($id)
    {
        $location = $this->service->find($id);
        return $this->responseCommon(true, 'Tìm thành công địa điểm', $location, 201);
    }

    public function store(CreateLocationRequest $request)
    {
        $location = $this->service->create(
            $request->validated(),
            $request->file('thumbnail')
        );

        return $this->responseCommon(true, 'Thêm mới thành công địa điểm', $location, 201);
    }

    public function update(UpdateLocationRequest $request, $id)
    {
        $location = $this->service->update($id, $request->validated(), $request->file('thumbnail'));

        return $this->responseCommon(true, 'Cập nhật thành công địa điểm', $location, 201);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return $this->responseCommon(true, 'Xóa địa điểm thành công', [], 200);
    }
}
