<?php

use App\Http\Controllers\Api\DirectoryController;
use App\Http\Controllers\Api\FileController;
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

Route::get('file', [FileController::class, 'show']);
Route::post('file', [FileController::class, 'store']);
Route::post('file/meta', [FileController::class, 'meta']);
Route::post('file/exists', [FileController::class, 'exists']);
Route::delete('file', [FileController::class, 'destroy']);

Route::post('directory', [DirectoryController::class, 'store']);
Route::post('directory/exists', [DirectoryController::class, 'exists']);
Route::delete('directory', [DirectoryController::class, 'destroy']);

// TODO add endpoints for bucket creation
