<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('api')->group(function() {

    Route::get('/', 'HomeController@index');
    Route::get('/document', function() {
        $openapi = \OpenApi\Generator::scan([__DIR__.'/../Http']);
        header('Content-Type: application/x-yaml');
        return $openapi->toYaml();
    });

    Route::fallback(function(){
        return response()->json([
            'status' => Response::HTTP_NOT_FOUND,
            'message' => __('ApiCpanel::messages.page_not_found'),
        ]);
    });

    //Route::post('kt-helper/import', 'KTHelperController@import_20_11_2021');
    Route::post('kt-helper/import/custom', 'KTHelperController@import_23_11_2021');
    Route::post('kt-helper/import/rerun', 'KTHelperController@import_25_11_2021');
});
