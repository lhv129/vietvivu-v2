<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    protected int $status;

    public function __construct(string $message = "Server Error", int $status = 400)
    {
        parent::__construct($message);
        $this->status = $status;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}
