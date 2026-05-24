<?php

namespace App\Exceptions;

class ControlledException extends \Exception
{
    function __construct($message = null, $code = 0, public int $status_code = 400)
    {
        parent::__construct($message, $code);
    }

    public function render()
    {
        return response()->message($this->message, $this->status_code);
    }
}
