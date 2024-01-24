<?php

use App\Http\Controllers\Api\FileController;
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

Route::get('file', [FileController::class, 'show']);
Route::put('file', [FileController::class, 'update']);
Route::post('file', [FileController::class, 'store']);
Route::delete('file', [FileController::class, 'destroy']);
Route::get('file/meta', [FileController::class, 'meta']);
Route::post('file/exists', [FileController::class, 'exists']);

// TODO add endpoints for directory

// TODO add endpoints for bucket creation
