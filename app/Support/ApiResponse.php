<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponse
{
    /**
     * Return a JSON resource with a 200 status (default).
     */
    public static function resource(JsonResource $resource, int $status = 200): JsonResponse
    {
        return $resource->response()->setStatusCode($status);
    }

    /**
     * Return a 201 Created response.
     */
    public static function created(mixed $data = null): JsonResponse
    {
        return response()->json(['message' => 'Created.', 'data' => $data], 201);
    }

    /**
     * Return a simple success message.
     */
    public static function message(string $message, int $status = 200): JsonResponse
    {
        return response()->json(['message' => $message], $status);
    }
}
