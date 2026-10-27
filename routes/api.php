<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;

Route::get('/teachers', [TeacherController::class, 'index']);
Route::post('/teachers', [TeacherController::class, 'store']);
Route::get('/teachers/{teacher}', [TeacherController::class, 'show']);
Route::put('/teachers/{teacher}', [TeacherController::class, 'update']);
Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy']);


// Route Building API routes
Route::get('/buildings', [BuildingController::class, 'index']);
Route::post('/buildings', [BuildingController::class, 'store']);
Route::get('/buildings/{building}', [BuildingController::class, 'show']);
Route::put('/buildings/{building}', [BuildingController::class, 'update']);
Route::delete('/buildings/{building}', [BuildingController::class, 'destroy']);

// Route Floor API routes
Route::get('/floors', [FloorController::class, 'index']);
Route::post('/floors', [FloorController::class, 'store']);
Route::get('/floors/{floor}', [FloorController::class, 'show']);
Route::put('/floors/{floor}', [FloorController::class, 'update']);
Route::delete('/floors/{floor}', [FloorController::class, 'destroy']);

//Room Api routes
Route::get('/rooms', [RoomController::class, 'index']);
Route::post('/rooms', [RoomController::class, 'store']);
Route::get('/rooms/{room}', [RoomController::class, 'show']);
Route::put('/rooms/{room}', [RoomController::class, 'update']);
Route::delete('/rooms/{room}', [RoomController::class, 'destroy']);

//Teacher Api

// Route::get('/teachers', [TeacherController::class, 'index']);
// Route::post('/teachers', [TeacherController::class, 'store']);
// Route::get('/teachers/{teacher}', [TeacherController::class, 'show']);
// Route::put('/teachers/{teacher}', [TeacherController::class, 'update']);
// Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy']);

Route::apiResource('teachers', TeacherController::class);

// Auth API routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);