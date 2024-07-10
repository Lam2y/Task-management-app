<?php

use App\Http\Controllers\Employee\TaskStatusController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminTaskController;
use App\Http\Controllers\AdminTaskStatusController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('employee/mainpage', function () {
    return view('employee.layouts.app');
})->middleware(['auth', 'verified'])->name('mainpage');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('api/tasks/search',[TaskController::class,'search'])->middleware('auth');
Route::get('api/tasks/search',[TaskController::class,'search'])->middleware('auth');
Route::get('/api/user-details',[UserController::class,'getUserDetails'])->middleware('auth');
Route::get('/api/users',[UserController::class,'getAllUsers'])->middleware('auth');
Route::delete('api/admintasks/{task}', [AdminTaskController::class,'destroy'])->middleware('auth');
Route::delete('api/tasks/{task}', [TaskController::class,'destroy'])->middleware('auth');
Route::get('admin/mainpage', [HomeController::class,'index'])->middleware(['auth','admin']);
Route::get('admin/mainpage', ApplicationController::class)->where('view','.*'); 
Route::put('api/admintasks/{task}', [AdminTaskController::class,'update'])->middleware('auth');
Route::get('api/admintasks', [AdminTaskController::class,'index'])->middleware('auth');
Route::post('api/admintasks', [AdminTaskController::class,'store'])->middleware('auth');
Route::put('api/tasks/{task}', [TaskController::class,'update'])->middleware('auth');
Route::get('api/tasks', [TaskController::class,'index'])->middleware('auth');
Route::post('api/tasks', [TaskController::class,'store'])->middleware('auth');
Route::get('api/usertasks', [TaskController::class,'groupTaskByEmployee'])->middleware('auth');
Route::get('api/alladmintask-status', [AdminTaskStatusController::class,'getAllStatusWithCount'])->middleware('auth');
Route::get('api/admintask-status', [AdminTaskStatusController::class,'getStatusWithCount'])->middleware('auth');
Route::get('api/task-status', [TaskStatusController::class,'getStatusWithCount'])->middleware('auth');
Route::middleware('auth')->group(function () {
    Route::get('employee/{path}', function () {
        return view('employee.layouts.spa');
    })->where('path', '.*');
});
Route::middleware('auth')->group(function () {
    Route::get('admin/{path}', function () {
        return view('admin.layouts.spa');
    })->where('path', '.*');
});

require __DIR__.'/auth.php';
