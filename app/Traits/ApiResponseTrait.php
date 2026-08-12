<?php
namespace App\Traits;

trait ApiResponseTrait
{
    public function success($message = 'Success', $code = 200, $data = [])
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function error($message = 'error', $code = 400, $error = '')
    {
        return response()->json([
            'message' => $message,
            'error' => $error
        ], $code);
    }
}