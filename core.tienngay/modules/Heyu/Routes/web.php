<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

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

Route::prefix('heyu')->middleware('locale')->group(function () {
    Route::get('/', function () {
        echo "Wellcome to HeyuStore module";
    });

    Route::post('findUserByCode', 'HeyuController@findUserByCode');
    Route::post('charge', 'HeyuController@charge');
    Route::post('getStatus', 'HeyuController@getStatus');
    Route::post('getTransactions', 'HeyuController@getTransactions');
    Route::post('handover', 'HeyuController@handover');
    Route::post('inventory', 'HeyuController@inventory');

    Route::post('insertStoreTienngay', 'HeyuStoreController@insertStoreTienngay');
    Route::post('getAllUniform', 'HeyuStoreController@getAllUniform');


    Route::post('insertStoreTienngay', 'HeyuStoreController@insertStoreTienngay');
    Route::post('getAllUniform', 'HeyuStoreController@getAllUniform');
    Route::post('updateOrInsertStoreTienngay', 'HeyuStoreController@updateOrInsertStoreTienngay');
    Route::post('editStoreTienngay', 'HeyuStoreController@editStoreTienngay');

    Route::prefix('handover')->group(function() {
    	Route::post('store', 'HeyuHandoverController@storeHandoverBill');
    	Route::post('approve', 'HeyuHandoverController@approveHandoverBill');
    	Route::post('cancel', 'HeyuHandoverController@cancleHandoverBill');
    });

});
