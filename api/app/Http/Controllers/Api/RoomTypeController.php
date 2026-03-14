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

    public function index(Request $request)
    {
        $data = $this->service->paginate($request->limit ?? 10);

        return $this->paginateResponse(
            $data,
            "Lấy danh sách loại phòng thành công"
        );
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
}
