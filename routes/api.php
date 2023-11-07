<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\TaskController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'admin'], function ($router) {
    Route::post('/login', [AdminController::class, 'login'])->name('login');
});

Route::group(['prefix' => 'employee'], function ($router) {
    Route::post('/login', [UserController::class, 'login'])->name('login');
});

Route::group(['prefix' => 'manager'], function ($router) {
    Route::post('/login', [ManagerController::class, 'login'])->name('login');
});

Route::group(['middleware' => ['jwt.role:admin', 'jwt.auth'], 'prefix' => 'admin'], function ($router) {
    Route::post('/register', [AdminController::class, 'register'])->name('register');
    Route::post('/mregister', [ManagerController::class, 'register'])->name('mregister');
    Route::post('/eregister', [UserController::class, 'register'])->name('eregister');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');


    Route::get('/task', [TaskController::class, 'index'])->name('task');
    Route::get('/task/{id}', [TaskController::class, 'show'])->name('task/{id}');
    Route::post('/task', [TaskController::class, 'store'])->name('task');
    Route::put('/task/{id}', [TaskController::class, 'update'])->name('task/{id}');
    Route::delete('/task/{id}', [TaskController::class, 'destroy'])->name('task/{id}');

});

Route::group(['middleware' => ['jwt.role:manager', 'jwt.auth'], 'prefix' => 'manager'], function ($router) {
    Route::post('/logout', [ManagerController::class, 'logout']);

    
    Route::get('/task', [TaskController::class, 'index'])->name('task');
    Route::get('/task/{id}', [TaskController::class, 'show'])->name('task/{id}');
    Route::post('/task', [TaskController::class, 'store'])->name('task');
    Route::put('/task/{id}', [TaskController::class, 'update'])->name('task/{id}');
});

Route::group(['middleware' => ['jwt.role:employee', 'jwt.auth'], 'prefix' => 'employee'], function ($router) {
    Route::post('/logout', [UserController::class, 'logout']);


    Route::get('/task', [TaskController::class, 'index'])->name('task');
    Route::get('/task/{id}', [TaskController::class, 'show'])->name('task/{id}');
});
