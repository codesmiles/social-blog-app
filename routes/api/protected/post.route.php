<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;


Route::post("user/create-post", [PostController::class, "store"]);
Route::get("user/show-posts", [PostController::class, "show"]);
Route::get("user/show-single-post/{post_id}", [PostController::class, "showSingle"]);
Route::post("user/edit-single-post/{post_id}", [PostController::class, "editSinglePost"]);
Route::delete("user/delete-single-post/{post_id}", [PostController::class, "deleteSinglePost"]);
