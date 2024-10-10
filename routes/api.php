<?php

use App\Http\Controllers\API\Admin\AdminController;
use App\Http\Controllers\API\Admin\RoleAndPermissionController;
use App\Http\Controllers\API\Admin\RoleController;
use App\Http\Controllers\API\Admin\UserController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\TaskController;
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



Route::controller(AuthController::class)->group(function(){
    Route::post('/register','register');
    Route::post('/login','login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

    Route::apiResource('tasks', TaskController::class)->except(['store'])->middleware(['auth:sanctum','check.editor.or.owner']);

    Route::post('tasks', [TaskController::class, 'store'])->middleware('auth:sanctum');


Route::prefix('admin')->middleware(['auth:sanctum','role:admin'])->group(function () {
    Route::apiResource('roles' , RoleController::class);
    Route::apiResource('users', UserController::class);
    

});

