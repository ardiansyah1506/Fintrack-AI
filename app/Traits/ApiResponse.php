<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Build standard JSON success response
     *
     * @param  mixed   $data
     * @param  string  $message
     * @param  int     $code
     * @param  string  $intent   Intent name (e.g. create_transaction)
     * @param  string  $resource Resource name (e.g. transaction)
     */
    protected function successResponse(
        $data = null,
        string $message = 'Success',
        int $code = 200,
        string $intent = '',
        string $resource = ''
    ): JsonResponse {
        return response()->json([
            'success'  => true,
            'intent'   => $intent,
            'resource' => $resource,
            'status'   => 'success',
            'message'  => $message,
            'data'     => $data,
        ], $code);
    }

    /**
     * Build standard JSON error response
     *
     * @param  string  $message
     * @param  int     $code
     * @param  mixed   $errors
     * @param  string  $intent
     * @param  string  $resource
     */
    protected function errorResponse(
        string $message = 'Error',
        int $code = 400,
        $errors = null,
        string $intent = '',
        string $resource = ''
    ): JsonResponse {
        return response()->json([
            'success'  => false,
            'intent'   => $intent,
            'resource' => $resource,
            'status'   => 'error',
            'message'  => $message,
            'errors'   => $errors,
        ], $code);
    }
}
