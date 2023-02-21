<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


    Route::post("user/search", [UserController::class,"search"]);
    Route::get("user/profile",[UserController::class,"profile"]);
    Route::get("user/logout", [AuthController::class,"logout"]);
