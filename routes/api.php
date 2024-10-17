<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\BooksController;
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

Route::group(['prefix'=>'authors',], function(){
    Route::get('/', [AuthorsController::class, 'index']);
    Route::get('/{id}', [AuthorsController::class, 'show']);
    Route::post('/', [AuthorsController::class, 'store']);
    Route::put('/{id}', [AuthorsController::class, 'update']);
    Route::delete('/{id}', [AuthorsController::class, 'destroy']);
    Route::get('/{id}/books', [BooksController::class, 'getBooksByAuthor']);
});

Route::group(['prefix'=>'books',], function(){
    Route::get('/', [BooksController::class, 'index']);
    Route::get('/{id}', [BooksController::class, 'show']);
    Route::post('', [BooksController::class, 'store']);
    Route::put('/{id}', [BooksController::class, 'update']);
    Route::delete('/{id}', [BooksController::class, 'destroy']);
});