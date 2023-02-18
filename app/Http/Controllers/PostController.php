<?php

namespace App\Http\Controllers;

use App\Interfaces\PostsInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\PostException;
class PostController extends Controller
{
    private PostsInterface $PostsRepository;
    public function __construct(PostsInterface $PostsRepository)
    {
        $this->PostsRepository = $PostsRepository;
    }

    public function store(Request $request)
    {
        $post = Validator::make($request->all(), [
            'title' => 'required|string|min:3',
            'contents' => 'required|string|min:3',
        ]);

        throw_if($post->fails(), PostException::class, $post->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        // THIS OUTPUT IS THE SAME AS ABOVE LINE
        // if ($post->fails()) {
        //     return response()->json([
        //         "message" => "Validation error",
        //         "errors" => $post->errors(),
        //     ], Response::HTTP_UNPROCESSABLE_ENTITY);
        
        // }

        $savedPost = $this->PostsRepository->savePost($request);

        return response()->json([
            "message" => "Post created",
            "post" => $savedPost
        ], Response::HTTP_CREATED);
    }

    public function show()
    {
        $posts = $this->PostsRepository->showAllUserPosts();

        return response()->json([
            "message" => "successful",
            "posts" => $posts,
        ], Response::HTTP_OK);
    }

    public function showSingle($post_id)
    {
        $post = $this->PostsRepository->showSinglePost($post_id);

        return response()->json([
            "message" => "successful",
            "post" => $post,
        ], Response::HTTP_OK);
    }

    public function editSinglePost(Request $request, $post_id)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|min:3',
            'contents' => 'required|string|min:3',
        ]);
        throw_if($validate->fails(), PostException::class, $validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);

        $post = $this->PostsRepository->updatePost($request, $post_id);

        return response()->json([
            "message" => "successful",
            "post" => $post,
        ], Response::HTTP_OK);
    }

    public function deleteSinglePost($post_id)
    {
        $post = $this->PostsRepository->deletePost($post_id);

        return response()->json([
            "message" => "successfully deleted post",
            "post"=> $post
        ], Response::HTTP_OK);
    }

}
