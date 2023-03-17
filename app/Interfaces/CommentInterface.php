<?php
namespace App\Interfaces;

interface CommentInterface{

    public function index();
    public function save($request, $user_id,$post_id);

}