<?php


namespace App\Helpers;


use Illuminate\Http\JsonResponse;

class CustomResponse
{
    /**
     * @param $message
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    static public function successResponse($message, array $data = [], int $status = 200): JsonResponse
    {
        return response()->json(['message' => $message, 'data' => $data], $status);
    }

    /**
     * @param $message
     * @param int $status
     * @param string $error
     * @return JsonResponse
     */
    static public function errorResponse($message, string $error = '', int $status = 400): JsonResponse
    {
        return response()->json(['message' => $message, 'error' => $error], $status);
    }
}
