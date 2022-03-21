<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;

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


Route::get('/user', [UserController::class,'index']);
Route::post('/user', [UserController::class,'store']);
Route::get('/user/{id}', [UserController::class,'show']);
Route::patch('/user/{id}', [UserController::class,'update']);
Route::delete('/user/{id}', [UserController::class,'destroy']);