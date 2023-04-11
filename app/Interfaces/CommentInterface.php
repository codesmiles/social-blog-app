<?php
namespace App\Interfaces;

interface CommentInterface{

    public function index();
    public function save($comment, $user_id,$post_id);
    public function update($comment,$comment_id, $user_id,$post_id);
    public function delete($comment_id, $user_id,$post_id);
}