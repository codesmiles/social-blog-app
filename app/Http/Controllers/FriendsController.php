<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FriendsController extends Controller
{
    public function searchFriends(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|min:3',
        ]);

        $user = auth()->user()->id;
        $friend = User::where('name', $request->name)->where('id', '!=', $user)->get();
        
        return response()->json([
            "message" => "successful",
            "data" => $friend
        ], 200);
    }

    public function addFriend($friend_id)
    {
        auth()->user()->friends()->attach($friend_id);

        return response()->json([
            "message" => "Friend added successfully",
        ], 201);
    }


    public function showUserFriends()
    {
        $friends = auth()->user()->friends()->get();
        if ($friends->isEmpty()) {
            return response()->json([
                "message" => "No friends found",
            ], 201);
        }

        return response()->json([
            "message" => "successful",
            "data" => $friends
        ], 201);
    }

    public function showSingleFriend($friend_id)
    {
        $friend = auth()->user()->friends()->where('id', $friend_id)->first();
        if (!$friend) {
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
    public function showFriendPosts($friend_id)
    {

        $friend = auth()->user()->friends()->where('id', $friend_id)->first();

        if (!$friend) {
            return response()->json([
                "message" => "No friend found",
            ], 404);
        }

        $posts = $friend->posts()->get();

        if ($posts->isEmpty()) {
            return response()->json([
                "message" => "No posts found",
            ], 404);
        }

        return response()->json([
            "message" => "successful",
            "posts" => $posts
        ], 200);
    }

    public function showFriendSinglePost($friend_id,$post_id){
        $friend = auth()->user()->friends()->where('id', $friend_id)->first();

        if (!$friend) {
            return response()->json([
                "message" => "No friend found",
            ], 404);
        }

        $post = $friend->posts()->where('id', $post_id)->first();

        if (!$post) {
            return response()->json([
                "message" => "No post found",
            ], 404);
        }

        return response()->json([
            "message" => "successful",
            "post" => $post
        ], 200);
    }

    // unfriend
    public function deleteFriend($friend_id)
    {
        $user = auth()->user();
        $friend = $user->friends()->detach($friend_id);

        if (!$friend) {
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