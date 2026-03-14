<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\RoomTypePriceRuleService;
use App\Http\Controllers\Api\BaseController;

class RoomTypePriceRuleController extends BaseController
{
    protected $service;

    public function __construct(RoomTypePriceRuleService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $data = $this->service->paginate($request->limit ?? 10);

        return $this->paginateResponse(
            $data,
            "Lấy danh sách price rule thành công"
        );
    }

    public function show($id)
    {
        $data = $this->service->find($id);

        return $this->responseCommon(
            true,
            "Lấy price rule thành công",
            $data
        );
    }

    public function store(Request $request)
    {
        $data = $this->service->create($request->all());

        return $this->responseCommon(
            true,
            "Thêm price rule thành công",
            $data,
            201
        );
    }

    public function update(Request $request, $id)
    {
        $data = $this->service->update($id, $request->all());

        return $this->responseCommon(
            true,
            "Cập nhật price rule thành công",
            $data
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return $this->responseCommon(
            true,
            "Xóa price rule thành công",
            []
        );
    }
}
