<?php

namespace App\Services;

use App\Repositories\FacilityRepository;
use App\Services\BaseService;

class FacilityService extends BaseService
{
    public function __construct(FacilityRepository $repository)
    {
        parent::__construct($repository);
    }
    protected string $notFoundMessage = "Cơ sở vật chất không tồn tại hoặc đã bị xóa.";
}
