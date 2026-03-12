<?php

namespace App\Exceptions;

use Throwable;
use App\Exceptions\ApiException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $e)
    {
        if ($request->expectsJson()) {

            // Custom API Exception
            if ($e instanceof ApiException) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'data' => [],
                    'statusCode' => $e->getStatus()
                ], $e->getStatus());
            }

            // Model not found
            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không tồn tại',
                    'data' => [],
                    'statusCode' => 404
                ], 404);
            }

            // Auth error
            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn chưa đăng nhập',
                    'data' => [],
                    'statusCode' => 401
                ], 401);
            }

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
                'statusCode' => 500
            ], 500);
        }

        return parent::render($request, $e);
    }
}
