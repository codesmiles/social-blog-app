<?php

namespace App\Exceptions;

use Exception;

class PostException extends Exception
{
public function render($request)
    {
        return response()->json([
            'error' => 'Post Error',
            'message' => $this->getMessage(),
        ], $this->getCode());
    }
}
