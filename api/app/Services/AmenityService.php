<?php

namespace App\Services;

use App\Repositories\AmenityRepository;
use App\Services\BaseService;

class AmenityService extends BaseService
{
    public function __construct(AmenityRepository $repository)
    {
        parent::__construct($repository);
    }
    protected string $notFoundMessage = "Tiện ích không tồn tại hoặc đã bị xóa.";
}
