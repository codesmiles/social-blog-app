<?php

namespace App\Exceptions;

use Exception;

class FriendException extends Exception
{
 public function render($request)
    {
        return response()->json([
            'error' => 'friend error',
            'message' => $this->getMessage(),
        ], $this->getCode());
    }
}
