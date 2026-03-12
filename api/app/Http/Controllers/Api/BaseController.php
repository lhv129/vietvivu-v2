<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    protected function responseCommon(
        bool $status,
        string $message = '',
        $data = null,
        int $httpCode = 200
    ): JsonResponse {

        $allowedCodes = [
            200, // OK
            201, // Created
            400, // Bad request
            401, // Unauthorized
            403, // Forbidden
            404, // Not found
            422, // Validation
            500  // Server error
        ];

        if (!in_array($httpCode, $allowedCodes)) {
            $httpCode = 500;
        }

        return response()->json([
            'success' => $status,
            'message' => $message,
            'data' => $data
        ], $httpCode);
    }

    protected function paginateResponse($paginator, $message = '')
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $paginator->items(),
            'meta' => [
                'page' => $paginator->currentPage(),
                'limit' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage()
            ]
        ]);
    }
}
