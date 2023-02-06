<?php
namespace App\Interfaces;


interface FriendsInterface
{
    public function searchFriends($request);
    public function addFriend($friend_id);
    public function showUserFriends();
    public function showSingleFriend($friend_id);
    public function showFriendPosts($friend_id);
    public function showFriendSinglePost($friend_id, $post_id);
    public function deleteFriend($friend_id);
}

