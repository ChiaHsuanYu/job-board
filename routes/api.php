<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\JobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',[AuthController::class, 'login']);
Route::post('logout',[AuthController::class, 'logout'])
    ->middleware('auth:sanctum');
    
Route::post('/jobs',[JobController::class, 'index']);
Route::post('/jobs/show',[JobController::class, 'show'])
    ->middleware('auth:sanctum');

// Route::middleware('auth:sanctum') //驗證身分是否合法
//     ->middleware('throttle:api') //限制每分鐘的API請求次數
//     ->apiResource('jobs', JobController::class);
