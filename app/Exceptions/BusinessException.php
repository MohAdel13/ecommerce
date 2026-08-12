<?php

namespace App\Exceptions;

use Exception;

class BusinessException extends Exception
{
    protected array $errors;

    public $unknown = false;

    public function __construct(
        string $message = 'Error',
        int $code = 400,
        array $errors = [],
    ) {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }

    public function getError(): array
    {
        return $this->errors;
    }
}