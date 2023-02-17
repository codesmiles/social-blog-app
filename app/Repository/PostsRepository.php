<?php
namespace App\Repository;

use App\Exceptions\PostException;
use App\Interfaces\PostsInterface;
use App\Models\Posts_model;
use Symfony\Component\HttpFoundation\Response;

// use Illuminate\Http\Response;
class PostsRepository implements PostsInterface
{

    public function savePost($request)
    {
        return Posts_model::create([
            'user_id' => auth()->user()->id,
            'title' => $request['title'],
            'contents' => $request['contents'],
        ]);

    }

    public function showAllUserPosts()
    {
        try {
            $user = auth()->user()->id;
            $posts = Posts_model::where('user_id', $user)->get();

            throw_if(count($posts) == 0, PostException::class, "No Posts Found", Response::HTTP_NOT_FOUND);
            // if (count($posts) == 0) {
            //     // return response()->json([
            //     //     "message" => "No posts found",
            //     // ], 404);
            // }

            return $posts;
        } catch (PostException $err) {
            throw_if($err, PostException::class, "$err", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function showSinglePost($post_id)
    {

        $post = $this->showAllUserPosts()->where('id', $post_id)->first();

        if (!$post) {
            return "No post with an id of $post_id found";
        }
        return $post;
    }

    public function updatePost($request, $post_id)
    {
        $post = $this->showSinglePost($post_id);

        $post->update([
            'title' => $request['title'],
            'contents' => $request['contents'],
        ]);

        return $post;
    }

    public function deletePost($post_id)
    {
        $this->showSinglePost($post_id)->delete();

        return "deleted";
    }
}
