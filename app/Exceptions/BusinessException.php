<?php

namespace App\Exceptions;


use Exception;
use Throwable;

class BusinessException extends Exception
{

    public $data;

    public $message;

    public $previous;

    public function __construct($message, $data = [], Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->message = $message;
        $this->data = $data;
        $this->previous = $previous;
    }

}