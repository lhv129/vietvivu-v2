<?php

namespace App\Services;

use App\Repositories\PropertyTypeRepository;
use App\Services\BaseService;

class PropertyTypeService extends BaseService
{
    public function __construct(PropertyTypeRepository $repository)
    {
        parent::__construct($repository);
    }
    protected string $notFoundMessage = "Loại chỗ ở không tồn tại hoặc đã bị xóa.";
}
