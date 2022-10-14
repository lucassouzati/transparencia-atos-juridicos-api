<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Api\LegalActController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);



Route::apiResource('legalacts', LegalActController::class)->only([
    'index', 'show'
]);

Route::apiResource('types', TypeController::class)->only([
    'index', 'show'
]);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('legalacts', LegalActController::class)->only([
        'store', 'update', 'destroy'
    ]);
    Route::apiResource('types', TypeController::class)->only([
        'store', 'update', 'destroy'
    ]);
});



Route::get('/', function () {
    return response()->json([
        'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
    ]);
});
