<?php

namespace App\Exceptions;

use Exception;

class AuthException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'error' => 'Authentication error',
            'message' => $this->getMessage(),
        ], $this->getCode());
    }
}
