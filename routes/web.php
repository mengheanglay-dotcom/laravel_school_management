<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\BuildingController;
use App\Http\Controllers\Web\FloorController;
use App\Http\Controllers\Web\RoomController;
use App\Http\Controllers\Web\TeacherController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('buildings', BuildingController::class)->except(['show']);
Route::resource('floors', FloorController::class)->except(['show']);
Route::resource('rooms', RoomController::class)->except(['show']);
Route::get('teacher', [TeacherController::class, 'index'])->name('teacher.index');
Route::resource('teachers', TeacherController::class)->except(['show']);
