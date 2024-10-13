<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\SubCategoryController;
use App\Http\Controllers\API\ProductController;

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

// User 

Route::prefix('user')->group(function()
{
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group( function () 
    {
        // Category 
        Route::post('product/category/create', [CategoryController::class, 'store']);
        Route::get('product/category/list', [CategoryController::class, 'index']);

        // Sub-Category 
        Route::post('product/subcategory/create', [SubCategoryController::class, 'store']);
        Route::get('product/subcategory/list', [SubCategoryController::class, 'index']);

        // Products 
        Route::post('product/create', [ProductController::class, 'store']);
        Route::get('product/list', [ProductController::class, 'index']);

    }); // middleware

}); // prefix
