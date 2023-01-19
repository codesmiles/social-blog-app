<?php
namespace App\Repository;

use App\Models\User;
use App\Interfaces\AuthInterface;

class AuthRepository implements AuthInterface
{
    public function register($request){
        return User::create($request);
    }
    public function login($request){}
    public function logout($request){}

}



?>