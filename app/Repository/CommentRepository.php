<?php
namespace App\Repository;

use App\Interfaces\CommentInterface;
use App\Models\Comments_model;

class CommentRepository implements CommentInterface
{
    public function index()
    {
        return "it works";

    }
    public function save($comment, $user_id, $post_id)
    {

        $entry = Comments_model::create([
            "comment" => $comment,
            "user_id" => $user_id,
            "post_id" => $post_id
        ]);
        return $entry;



    }
}
