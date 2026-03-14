<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\HouseRule\CreateHouseRuleRequest;
use App\Http\Requests\HouseRule\UpdateHouseRuleRequest;
use App\Services\HouseRuleService;
use Illuminate\Http\Request;

class HouseRuleController extends BaseController
{
    protected $service;

    public function __construct(HouseRuleService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $houseRules = $this->service->paginate($request->limit ?? 10);
        return $this->paginateResponse(
            $houseRules,
            "Lấy danh sách quy tắc nhà thành công"
        );
    }

    public function show($id)
    {
        $houseRules = $this->service->find($id);
        return $this->responseCommon(true, 'Tìm thành công quy tắc nhà', $houseRules, 200);
    }

    public function store(CreateHouseRuleRequest $request)
    {
        $houseRule = $this->service->create($request->validated());
        return $this->responseCommon(true, 'Thêm mới quy tắc nhà thành công', $houseRule, 201);
    }

    public function update(UpdateHouseRuleRequest $request, $id)
    {
        $houseRule = $this->service->update($id, $request->validated());
        return $this->responseCommon(true, 'Cập nhật quy tắc nhà thành công', $houseRule, 201);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return $this->responseCommon(true, 'Xóa quy tắc nhà thành công', [], 200);
    }
}
