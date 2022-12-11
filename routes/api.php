<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Validator;

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
Route::post("/signup", [UserController::class,"store"]);
Route::post("/login", [UserController::class,"login"]);


//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post("/search", [UserController::class,"search"]);
    Route::get("/profile",[UserController::class,"profile"]);
    Route::post("/logout", [UserController::class,"logout"]);
    // Route::get("/add-friend", [UserController::class,"addFriend"]);
});




// Route::get("/user/{id}/search", [UserController::class,"search"]);
// Route::get("/add-friend", [UserController::class,"addFriend"]);
