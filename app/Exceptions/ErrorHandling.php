<?php

namespace App\Exceptions;

use App\Exceptions\BuisnessException;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Log;
use Throwable;

class ErrorHandling
{
    use ApiResponseTrait;

    public function buisnessErrorHandle(BusinessException $e)
    {
        Log::error($e->getError()[0]);
        return $this->error(message: $e->getMessage(), error: $e->getMessage(), code: $e->getCode());
    }

    public function unexpectedErrorHandle(Throwable $th)
    {
        Log::error('Exception occurred', [
            'message' => $th->getMessage(),
            'file' => $th->getFile(),
            'line' => $th->getLine(),
            'class' => get_class($th),
            'trace' => $th->getTraceAsString(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'route' => optional(request()->route())->getName(),
            'controller' => optional(request()->route())->getActionName(),
        ]);

        return $this->error(message: __('message.unknown_error'), error: __('message.unknown_error'));
    }
}