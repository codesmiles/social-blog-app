<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FriendsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function addFriend($id)
    {
        $user = auth()->user();
        $addUser = $user->friends()->attach($id);

        return response()->json([
            "message" => "Friend added successfully",
            "data" => $addUser
        ], 201);
    }

    
    public function showFriends()
    {
        $friends = auth()->user()->friends()->get();
        if($friends->isEmpty()){
            return response()->json([
                "message" => "No friends found",
            ], 201);
        }

        return response()->json([
            "message" => "successful",
            "data" => $friends
        ], 201);
    }

    public function showSingleFriend($id){
        $user = auth()->user()->id;
        $friend = auth()->user()->friends()->where('id', $id)->first();

        if(!$friend){
            return response()->json([
                "message" => "No friend found",
            ], 404);
        }

        return response()->json([
            "message" => "successful",
            "data" => $friend
        ], 200);
    }

    // enable friend to view posts
    public function showFriendPosts($id){
        
        $friend = auth()->user()->friends()->where('id', $id)->first();

        if(!$friend){
            return response()->json([
                "message" => "No friend found",
            ], 404);
        }

        $posts = $friend->posts()->get();

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
    
    // unfriend
    public function deleteFriend($id){
        $user = auth()->user();
        $friend = $user->friends()->detach($id);

        if(!$friend){
            return response()->json([
                "message" => "No friend found",
            ], 404);
        }

        return response()->json([
            "message" => "Friend deleted successfully",
            "data" => $friend
        ], 200);
    }

}
