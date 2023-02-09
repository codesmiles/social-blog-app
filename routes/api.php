<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\External\ApiController;

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
Route::get("/external-api", [UserController::class,"index"]);
Route::post("/signup", [AuthController::class,"store"]);
Route::post("/login", [AuthController::class,"login"]);
Route::get("/external-api", [ApiController::class,"index"]);

// password reset
// Route::post("forgot-password", [AuthController::class,"forgotPassword"]);
// Route::post("reset-password", [AuthController::class,"resetPassword"]);
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    // user
    Route::post("user/search", [UserController::class,"search"]);
    Route::get("user/profile",[UserController::class,"profile"]);
    Route::get("user/logout", [AuthController::class,"logout"]);

    // user post
    Route::post("user/create-post", [PostController::class,"store"]);
    Route::get("user/show-posts", [PostController::class,"show"]);
    Route::get("user/show-single-post/{post_id}", [PostController::class,"showSingle"]);
    Route::post("user/edit-single-post/{post_id}", [PostController::class,"editSinglePost"]);
    Route::delete("user/delete-single-post/{post_id}", [PostController::class,"deleteSinglePost"]);

    // user friends
    Route::post("user/search-friends", [FriendsController::class,"searchFriends"]);
    Route::post("user/add-friend/{friend_id}", [FriendsController::class,"addFriend"]);
    Route::get("user/show-user-friends/", [FriendsController::class,"showUserFriends"]);
    Route::get("user/show-user-single-friend/{friend_id}", [FriendsController::class,"showSingleFriend"]);

    // user friends post
    Route::get("user/{friend_id}/show-friend-posts", [PostController::class,"showFriendPosts"]);
    Route::get("user/{friend_id}/show-single-friend-post/{post_id}", [PostController::class,"showSingleFriendPost"]);
    Route::delete("user/delete-friend/{id}", [FriendsController::class,"deleteFriend"]);

});

