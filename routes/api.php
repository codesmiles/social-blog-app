<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
UPDATE ON THE API ROUTES: NOW THE ROUTES ARE ON DIFFERENT DIRECTORY
AND THIS API.PHP FILE IS USED TO REGISTER THOSE ROUTES
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//public routes
//  signup,login,external
require __DIR__ . '/api/public.php';

// password reset
// Route::post("forgot-password", [AuthController::class,"forgotPassword"]);
// Route::post("reset-password", [AuthController::class,"resetPassword"]);
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    // user, search, profile, logout
    require __DIR__ . "/api/protected/user.route.php";

    // user post
    // create-post,show-post,show-single-post,edit-single-post,delete-single-post
    require __DIR__ . "/api/protected/post.route.php";

    // user friends
    // search-friends,add-friend,show-user-friends,show-user-single-friend
    require __DIR__ . "/api/protected/user-friends.route.php";

    // user friends post
    // show-friend-posts,show-single-friend-post,delete-friend
    require __DIR__ . "/api/protected/user-friends-post.route.php";

});
