<?php
namespace App\Repository;

use App\Interfaces\CommentInterface;

class CommentRepository implements CommentInterface
{
    public function index()
    {
        return "it works";

    }
    public function save($request, $user_id)
    {
        $comment = $request->comment;
        $post_id = $request->post_id;

    dump($comment, $post_id, $user_id);



    }
}
