<?php

use App\Http\Controllers\RDSController;
use App\Http\Controllers\RDSSingleInstanceController;
use App\Http\Controllers\RegionController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('rds')->group(function () {
    Route::post('stop/{DBInstanceIdentifier}', [RDSController::class, 'stopInstance']);
    Route::post('start/{DBInstanceIdentifier}', [RDSController::class, 'startInstance']);
    Route::get('{DBInstanceIdentifier}/events', [RDSSingleInstanceController::class,'getEvents']);
});

Route::get('regions', RegionController::class);

Route::apiResources([
    'rds' => RDSController::class
]);
