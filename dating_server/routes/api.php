<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(["middleware" => "auth:api"],function(){
    Route::post("/profile", [HomeController::class, "profile"])->name("profile");
    Route::post("/interested_in", [HomeController::class, "interested_in"])->name("interested-in");
    Route::post("/favorite", [HomeController::class, "favorite"])->name("favorite");
    Route::post("/inbox", [HomeController::class, "inbox"])->name("inbox");
    Route::post("/add_favorite", [HomeController::class, "add_favorite"])->name("add-favorite");
    Route::post("/add_block", [HomeController::class, "add_block"])->name("add-block");
    Route::post("/search", [HomeController::class, "search"])->name("search");
});

Route::post("/register", [AuthController::class, "register"])->name("register");
Route::post("/login", [AuthController::class, "login"])->name("login");
