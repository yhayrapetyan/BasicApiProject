<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PostsController;

/*
|----------------------------------------------------------------------------------
| API Routes
|----------------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
require __DIR__ . '/auth.php';

Route::apiResource('users', UserController::class)
    ->middleware('auth:sanctum')
    ->except(['create', 'edit']);
Route::apiResource('/posts', PostsController::class)
    ->middleware('auth:sanctum')
    ->except(['create', 'edit']);

