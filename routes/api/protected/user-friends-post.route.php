<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FriendsController;

Route::get("user/{friend_id}/show-friend-posts", [PostController::class, "showFriendPosts"]);
Route::get("user/{friend_id}/show-single-friend-post/{post_id}", [PostController::class, "showSingleFriendPost"]);
Route::delete("user/delete-friend/{id}", [FriendsController::class, "deleteFriend"]);
