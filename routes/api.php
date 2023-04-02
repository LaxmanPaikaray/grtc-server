<?php

use App\Http\Controllers\BlockController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\PanchayatController;
use App\Http\Controllers\VillageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SchoolManagementBoardController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CitySubareaController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MediaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// [Subrat] disable register link for some time
// Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

// Route::middleware('auth:sanctum')->get('/users', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('districts', DistrictController::class)->middleware('auth:sanctum');
Route::apiResource('blocks', BlockController::class)->middleware('auth:sanctum');
Route::apiResource('panchayats', PanchayatController::class)->middleware('auth:sanctum');
Route::apiResource('villages', VillageController::class)->middleware('auth:sanctum');
Route::apiResource('schoolmanagementboards', SchoolManagementBoardController::class)->middleware('auth:sanctum');
Route::apiResource('cities', CityController::class)->middleware('auth:sanctum');
Route::apiResource('city_subareas', CitySubareaController::class)->middleware('auth:sanctum');
Route::apiResource('users', UserController::class)->middleware('auth:sanctum');
Route::apiResource('schools', SchoolController::class)->middleware('auth:sanctum');
Route::apiResource('courses', CourseController::class)->middleware('auth:sanctum');



Route::post('/districts/bulk', [DistrictController::class, 'bulk_store'])->middleware('auth:sanctum');
Route::post('/blocks/bulk', [BlockController::class, 'bulk_store'])->middleware('auth:sanctum');
Route::post('/panchayats/bulk', [PanchayatController::class, 'bulk_store'])->middleware('auth:sanctum');
Route::post('/villages/bulk', [VillageController::class, 'bulk_store'])->middleware('auth:sanctum');
Route::post('/schoolmanagementboards/bulk', [SchoolManagementBoardController::class, 'bulk_store'])->middleware('auth:sanctum');
Route::post('/cities/bulk', [CityController::class, 'bulk_store'])->middleware('auth:sanctum');
Route::post('/city_subareas/bulk', [CitySubareaController::class, 'bulk_store'])->middleware('auth:sanctum');
Route::post('/users/bulk', [UserController::class, 'bulk_store'])->middleware('auth:sanctum');
Route::post('/schools/bulk', [SchoolController::class, 'bulk_store'])->middleware('auth:sanctum');
Route::post('/courses/bulk', [CourseController::class, 'bulk_store'])->middleware('auth:sanctum');
Route::post('/media_files/bulk', [MediaController::class, 'bulk_store'])->middleware('auth:sanctum');
