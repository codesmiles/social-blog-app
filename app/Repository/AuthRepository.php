<?php
namespace App\Repository;

use App\Models\User;
use Illuminate\Http\Response;
use App\Interfaces\AuthInterface;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthInterface
{
    public function register($request){
        return User::create($request);
    }
    
    public function login($request){}


    
    public function logout($request){}

}



?>