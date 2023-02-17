<?php

namespace App\Exceptions;

use Exception;

class GenericExceptions extends Exception
{

   
    // public function report()
    // {
    //     // Log::error('Generic Error: ' . $this->getMessage());
    //     dump("abc");
    // }

    public function render($request)
    {
        return response()->json([
            'error' => 'Generic Error message test',
            'message' => $this->getMessage(),
        ], $this->getCode());
    }


    
}
