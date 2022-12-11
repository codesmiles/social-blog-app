<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

 //public routes
Route::get("/", [UserController::class,"index"]);
Route::post("/signup", [AuthController::class,"store"]);
Route::post("/login", [AuthController::class,"login"]);


//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    // user
    Route::post("user/search", [UserController::class,"search"]);
    Route::get("user/profile",[UserController::class,"profile"]);
    Route::post("user/logout", [AuthController::class,"logout"]);

    // user post
    Route::post("user/create-post", [PostController::class,"store"]);
    Route::get("user/show-posts", [PostController::class,"show"]);
    Route::get("user/show-single-post/{id}", [PostController::class,"showSingle"]);
    Route::put("user/edit-single-post/{id}", [PostController::class,"editSinglePost"]);
    Route::delete("user/delete-single-post/{id}", [PostController::class,"deleteSinglePost"]);

    // user friends
    Route::post("user/add-friend/{id}", [FriendsController::class,"addFriend"]);
    Route::get("user/show-friends/", [FriendsController::class,"showFriends"]);
    Route::get("user/show-single-friend/{id}", [FriendsController::class,"showSingleFriend"]);
    Route::get("user/show-friend-posts", [PostController::class,"showFriendPosts"]);
    Route::delete("user/delete-friend/{id}", [FriendsController::class,"deleteFriend"]);
});

