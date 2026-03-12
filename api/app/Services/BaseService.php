<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Repositories\BaseRepository;

class BaseService
{
    protected BaseRepository $repository;

    protected string $notFoundMessage = "Bản ghi không tồn tại";

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function paginate($limit = 10)
    {
        return $this->repository->paginate($limit);
    }

    public function find($id)
    {
        $data = $this->repository->find($id);

        if (!$data) {
            throw new ApiException($this->notFoundMessage, 404);
        }

        return $data;
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        $data = $this->repository->find($id);

        if (!$data) {
            throw new ApiException($this->notFoundMessage, 404);
        }

        return $this->repository->delete($id);
    }
}
