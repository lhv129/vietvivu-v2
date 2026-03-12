<?php

namespace App\Services;

use App\Repositories\HouseRuleRepository;
use App\Services\BaseService;

class HouseRuleService extends BaseService
{
    public function __construct(HouseRuleRepository $repository)
    {
        parent::__construct($repository);
    }
    protected string $notFoundMessage = "Quy tắc nhà không tồn tại hoặc đã bị xóa.";
}
