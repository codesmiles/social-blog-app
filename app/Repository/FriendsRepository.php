<?php
namespace App\Repository;

use App\Interfaces\FriendsInterface;
use App\Models\User;
use Illuminate\Http\Response;

class FriendsRepository implements FriendsInterface
{

    public function searchFriends($request)
    {
        $user = auth()->user()->id;
        $friend = User::where('name', $request->name)->where('id', '!=', $user)->get();

        if ($friend->isEmpty()) {
            return Response::HTTP_NOT_FOUND;
        }
        return $friend;
    }

    public function addFriend($friend_id)
    {
        $exist = auth()->user()->friends()->where('friend_id', $friend_id)->exists();

        // if new friend already exists
        if ($exist) {
            return Response::HTTP_CONFLICT;
        }

        return auth()->user()->friends()->attach($friend_id);
    }

    public function showUserFriends()
    {
        $friends = auth()->user()->friends()->get();

        if ($friends->isEmpty()) {
            return "No friends found";
        }

        return $friends;
    }

    public function showSingleFriend($friend_id)
    {
        $friend = $this->showUserFriends()->where('id', $friend_id)->first();
        // $friend = auth()->user()->friends()->where('id', $friend_id)->first();
        if (!$friend) {
            return "no friend with an id of $friend_id";
        }
        return $friend;

    }

    public function showFriendPosts($friend_id)
    {
        // $friend = auth()->user()->friends()->where('id', $friend_id)->first();
        $singleFriend = $this->showSingleFriend($friend_id);

        $posts = $singleFriend->posts()->get();

        if ($posts->isEmpty()) {
            return "No posts found";
        }

        return $posts;

    }
    public function showFriendSinglePost($friend_id, $post_id)
    {
        $post = $this->showFriendPosts($friend_id)->where('id', $post_id)->first();
        if (!$post) {
            return "No post with the id of $post_id";
        }
        return $post;
    }

    public function deleteFriend($friend_id)
    {
        // $friend = $this->showUserFriends()->detach($friend_id);
        $user = auth()->user();
        $friend = $user->friends()->detach($friend_id);

        if (!$friend) {
            return "No friend with the id of $friend_id";
        }

        return $friend;
    }

}
