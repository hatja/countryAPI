<?php

namespace App\Exceptions;

use Exception;


class NoConnectionException extends Exception
{
  public function __construct($extraMessage = "")
  {
    $message = 'API is unreachable';
    $code = 408; //500 504  ...
    parent::__construct($message, $code);
  }
}


//...
