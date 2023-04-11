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
    public function update($comment,$comment_id, $user_id, $post_id)
    {
        $entry = Comments_model::where("user_id", $user_id)
            ->where("post_id", $post_id)
            ->where("id", $comment_id)
            ->update([
                "comment" => $comment
            ]);
        return $entry;
    }

    public function delete($comment_id,$user_id , $post_id){
        $entry = Comments_model::where("user_id", $user_id)
            ->where("post_id", $post_id)
            ->where("id", $comment_id)
            ->delete();
        return $entry;        
    }
}
