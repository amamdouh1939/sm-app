<?php

namespace App\Exceptions;

use Exception;

class UserInvalidLoginException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        \Log::Error($this->getMessage());
    }
}
