<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\MyJobApplicationController;
use App\Http\Controllers\MyJobController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/setlang/{lang}', 
    [AuthController::class, 'setlang'])
    ->name('auth.setlang');

Route::middleware('language')->group(function (){

    //寫法1,以路由名稱進行跳轉
    Route::get('',function (){
        return redirect()->route('jobs.index'); 
    });
    //寫法2
    // Route::get('',fn() => to_route('jobs.index'));

    Route::get('login',function (){
        return redirect()->route('auth.create');
    })->name('login');

    Route::resource('jobs', JobController::class)
        ->only(['index','show']);

    Route::resource('auth', AuthController::class)
        ->only(['create','store','setlang']);

    Route::delete('logout', function (){
        return redirect()->route('auth.destroy');
    })->name('logout');

    Route::delete('auth', [AuthController::class, 'destroy'])
        ->name('auth.destroy');

    Route::middleware('auth')->group(function (){
        Route::resource('job.appliation', JobApplicationController::class)
            ->only(['create', 'store']);

        Route::resource('my-job-applications', MyJobApplicationController::class)
            ->only(['index', 'destroy']);

        Route::resource('employer', EmployerController::class)
            ->only(['create', 'store']);

        Route::middleware('employer')
            ->resource('my-jobs', MyJobController::class)
            ->except(['show']);

        // Route::put('/my-jobs/restore', 
        //     [MyJobController::class, 'restore'])
        //     ->name('my-jobs.restore');
        Route::get('/my-jobs/{id}/restore', 
            [MyJobController::class, 'restore'])
            ->name('my-jobs.restore');
    });
});