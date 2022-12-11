<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts_model;

// create
// show
// update
// delete
// index


class PostController extends Controller
{
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|string|min:3',
            'details' => 'required|string|min:3',
        ]);

        $post = Posts_model::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'details' => $request->details,
        ]);

        return response()->json([
            "message" => "Post created",
            "post" => $post
        ], 201);
    }

    public function show(){
        $user = auth()->user()->id;
        $posts = Posts_model::where('user_id', $user)->get();

        if($posts->isEmpty()){
            return response()->json([
                "message" => "No posts found",
            ], 404);
        }

        return response()->json([
            "message" => "successful",
            "posts" => $posts
        ], 200);
    }

    public function showSingle($id){
        $user = auth()->user()->id;
        $post = Posts_model::where('user_id', $user)->where('id', $id)->first();

        if(!$post){
            return response()->json([
                "message" => "No post found",
            ], 404);
        }

        return response()->json([
            "message" => "successful",
            "post" => $post
        ], 200);

    }
    public function editSinglePost(Request $request, $id){
        $user = auth()->user()->id;
        $post = Posts_model::where('user_id', $user)->where('id', $id)->first();

        if(!$post){
            return response()->json([
                "message" => "No post found",
            ], 404);
        }

        $post->title = $request->title;
        $post->details = $request->details;
        $post->save();

        return response()->json([
            "message" => "successful",
            "post" => $post
        ], 200);
    }

    public function deleteSinglePost($id){
        $user = auth()->user()->id;
        $post = Posts_model::where('user_id', $user)->where('id', $id)->first();

        if(!$post){
            return response()->json([
                "message" => "No post found",
            ], 404);
        }

        $post->delete();
        return response()->json([
            "message" => "successfully deleted post",
        ], 200);
    }

}