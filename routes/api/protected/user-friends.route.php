<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FriendsController;

Route::post("user/search-friends", [FriendsController::class, "searchFriends"]);
Route::post("user/add-friend/{friend_id}", [FriendsController::class, "addFriend"]);
Route::get("user/show-user-friends/", [FriendsController::class, "showUserFriends"]);
Route::get("user/show-user-single-friend/{friend_id}", [FriendsController::class, "showSingleFriend"]);
