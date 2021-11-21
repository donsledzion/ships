<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class InvalidShipException extends Exception
{
    protected $message;

    public function __construct($message = 'Nieprawidłowa konfiguracja statku.', $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
