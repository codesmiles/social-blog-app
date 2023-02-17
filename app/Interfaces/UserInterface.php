<?php
namespace App\Interfaces;

interface UserInterface{

    public function welcome();
    public function profile($request);
    public function search($request);   
}