<?php

use App\Http\Controllers\Api\ApiController;
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

Route::group(['prefix' => 'v1'], function() {
    //upload, Process and import data to database
    Route::post('upload-dataset', [ApiController::class,'uploadDataset']);

    //search database records by amount, winning_company and date
    Route::get('search', [ApiController::class,'search']);

    //search database records by id
    Route::get('search-by-id/{id}', [ApiController::class,'getContractById']);

    //check contract read status
    Route::get('check-read-status/{id}', [ApiController::class,'checkreadStatus']);
    
});
