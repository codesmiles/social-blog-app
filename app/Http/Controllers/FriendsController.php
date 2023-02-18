<?php

namespace App\Http\Controllers;

use App\Interfaces\FriendsInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exceptions\FriendException;

class FriendsController extends Controller
{
   private FriendsInterface $FriendsRepository;
    public function __construct(FriendsInterface $FriendsRepository)
    {
        $this->FriendsRepository = $FriendsRepository;
    }

    public function searchFriends(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
        ]);
        throw_if($request->fails(), FriendException::class, $request->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);

        // $friends = app(FriendsInterface::class)->searchFriends();
        $friend = $this->FriendsRepository->searchFriends($request);
    
        return response()->json([
            "message" => "successful",
            "data" => $friend,
        ], Response::HTTP_OK);
    }

    public function addFriend($friend_id)
    {

        $data = $this->FriendsRepository->addFriend($friend_id);


        return response()->json([
            "message" => "Friend added successfully",
            "data" => $data,
        ], Response::HTTP_CREATED);
    }

    public function showUserFriends()
    {
        $friends = $this->FriendsRepository->showUserFriends();

        return response()->json([
            "message" => "successful",
            "data" => $friends,
        ], Response::HTTP_OK);

    }

    public function showSingleFriend($friend_id)
    {

        $friend = $this->FriendsRepository->showSingleFriend($friend_id);

        return response()->json([
            "message" => "successful",
            "data" => $friend,
        ], Response::HTTP_OK);
    }

    // enable friend to view posts
    public function showFriendPosts($friend_id)
    {
        // $posts = app(FriendsInterface::class)->showFriendPosts($friend_id);

        $posts = $this->FriendsRepository->showFriendPosts($friend_id);

        return response()->json([
            "message" => "successful",
            "posts" => $posts,
        ], Response::HTTP_OK);
    }

    public function showFriendSinglePost($friend_id, $post_id)
    {
        $post = $this->FriendsRepository->showFriendSinglePost($friend_id, $post_id);

        return response()->json([
            "message" => "successful",
            "post" => $post,
        ], Response::HTTP_OK);

    }

    // unfriend
    public function deleteFriend($friend_id)
    {

        $deleted = $this->FriendsRepository->deleteFriend($friend_id);

        return response()->json([
            "successful" => true,
            "data" => $deleted
        ], Response::HTTP_OK);
    }

}
