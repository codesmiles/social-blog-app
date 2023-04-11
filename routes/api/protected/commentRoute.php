<?php
use App\Http\Controllers\CommentsController;
use Illuminate\Support\Facades\Route;


Route::get("comment", [CommentsController::class, "index"]);

Route::post("comment/save/{post_id}",[CommentsController::class, "save"]);
Route::post("comment/update/{comment_id}/{post_id}",[CommentsController::class, "update"]);
Route::post("comment/delete/{comment_id}/{post_id}",[CommentsController::class, "delete"]);