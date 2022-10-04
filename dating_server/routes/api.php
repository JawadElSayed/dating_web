<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(["middleware" => "auth:api"],function(){
    Route::post("/home", [HomeController::class, "home"])->name("home");
});

Route::post("/register", [AuthController::class, "register"])->name("register");
Route::post("/login", [AuthController::class, "login"])->name("login");
