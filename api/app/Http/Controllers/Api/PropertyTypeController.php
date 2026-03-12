<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\PropertyType\CreatePropertyTypeRequest;
use App\Http\Requests\PropertyType\UpdatePropertyTypeRequest;
use App\Services\PropertyTypeService;
use Illuminate\Http\Request;

class PropertyTypeController extends BaseController
{
    protected $service;

    public function __construct(PropertyTypeService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $propertyTypes = $this->service->paginate($request->limit ?? 10);
        return $this->paginateResponse(
            $propertyTypes,
            "Lấy danh sách loại chỗ ở thành công"
        );
    }

    public function show($id)
    {
        $propertyTypes = $this->service->find($id);
        return $this->responseCommon(true, 'Tìm thành công loại chỗ ở', $propertyTypes, 200);
    }

    public function store(CreatePropertyTypeRequest $request)
    {
        $propertyType = $this->service->create($request->validated());
        return $this->responseCommon(true, 'Thêm mới loại chỗ ở thành công', $propertyType, 201);
    }

    public function update(UpdatePropertyTypeRequest $request, $id)
    {
        $propertyType = $this->service->update($id, $request->validated());
        return $this->responseCommon(true, 'Cập nhật loại chỗ ở thành công', $propertyType, 201);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return $this->responseCommon(true, 'Xóa loại chỗ ở thành công', [], 200);
    }
}
