<?php
namespace App\Interfaces;

interface PostsInterface
{
    public function savePost($request);

    public function showAllUserPosts();
    public function showSinglePost($post_id);
    public function updatePost($request, $post_id);

    public function deletePost($post_id);
}

