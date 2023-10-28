<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class AuthException extends Exception
{
    private array $error;

    /**
     * @param array $error
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(array $error, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->error = $error;
    }

    /**
     * @return array
     */
    public function getCustomError() : array
    {
        return $this->error;
    }
}
