<?php
declare(strict_types=1);

namespace App\Traits;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function success(string $message = '',  mixed $data = null, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    protected function ok(string $message, mixed $data): JsonResponse
    {
        return $this->success($message, $data);
    }

    protected function okPagination(string $message, mixed $data): JsonResponse
    {
        $newData = [
            'message' => $message,
            'data' => $data,
        ];


        return response()->json($newData);
    }

    protected function created(string $message): JsonResponse
    {
        return $this->success($message, null, 201);
    }

    protected function error(string $message, int $statusCode): JsonResponse
    {
        return response()->json([
            'error' => $message,
        ], $statusCode);
    }
}
