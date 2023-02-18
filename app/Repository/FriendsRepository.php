<?php
namespace App\Repository;

use App\Interfaces\FriendsInterface;
use App\Models\User;
use Illuminate\Http\Response;
use App\Exceptions\FriendException;

class FriendsRepository implements FriendsInterface
{

    public function searchFriends($request)
    {
        $user = auth()->user()->id;
        throw_if(!$user, FriendException::class, "User not authorized", Response::HTTP_UNAUTHORIZED);
        
        $friend = User::where('name', $request->name)->where('id', '!=', $user)->get();
        throw_if(count($friend) == 0, FriendException::class, "No friend found", Response::HTTP_NOT_FOUND);

        return $friend;
    }

    public function addFriend($friend_id)
    {
        $exist = auth()->user()->friends()->where('friend_id', $friend_id)->exists();
        // if new friend already exists
        throw_if($exist, FriendException::class, "Friend already exists", Response::HTTP_CONFLICT);
    
        return auth()->user()->friends()->attach($friend_id);
    }

    public function showUserFriends()
    {
        $friends = auth()->user()->friends()->get();

        throw_if(count($friends) == 0, FriendException::class, "No friends found", Response::HTTP_NOT_FOUND);

        return $friends;
    }

    public function showSingleFriend($friend_id)
    {
        $friend = $this->showUserFriends()->where('id', $friend_id)->first();
        throw_if(!$friend, FriendException::class, "No friend with an id of $friend_id", Response::HTTP_NOT_FOUND);
        
        return $friend;

    }

    public function showFriendPosts($friend_id)
    {
        // $friend = auth()->user()->friends()->where('id', $friend_id)->first();
        $singleFriend = $this->showSingleFriend($friend_id);

        $posts = $singleFriend->posts()->get();
        throw_if(count($posts) == 0, FriendException::class, "No posts found", Response::HTTP_NOT_FOUND);


        return $posts;

    }
    public function showFriendSinglePost($friend_id, $post_id)
    {
        $post = $this->showFriendPosts($friend_id)->where('id', $post_id)->first();
        throw_if(!$post, FriendException::class, "No post with the id of $post_id", Response::HTTP_NOT_FOUND);
        return $post;
    }

    public function deleteFriend($friend_id)
    {
        // $friend = $this->showUserFriends()->detach($friend_id);
        $user = auth()->user();
        $friend = $user->friends()->detach($friend_id);
        
        throw_if(!$friend, FriendException::class, "No friend with the id of $friend_id", Response::HTTP_NOT_FOUND);
        return $friend;
    }

}
