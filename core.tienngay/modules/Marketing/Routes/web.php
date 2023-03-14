<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
// use Modules\Hcns\Http\Middleware\Authorization;

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

Route::prefix('/marketing')->group(function() {

    Route::get('/', function () {
        echo("Wellcome to module Marketing");
    });
    Route::prefix('/trade')->group(function () {
        Route::post('/insert', 'TradeItemController@insert');
        Route::post('/update/{id}', 'TradeItemController@update');
        Route::post('/getALlItem', 'TradeItemController@getALlItem');
        Route::post('/getTypeByName', 'TradeItemController@getTypeByName');
        Route::post('/blockItem', 'TradeItemController@blockItem');
        Route::post('/getItemsByStoreId', 'TradeItemController@getItemsByStoreId');
        Route::post('/getItemByItemId', 'TradeItemController@getItemByItemId');

        Route::prefix('/request-order')->group(function () {
            Route::post('/order', 'TradeOrderController@requestOrder');
            Route::post('/update-progress', 'TradeOrderController@updateProgress');
            Route::post('/updateOrder', 'TradeOrderController@updateOrder');
            Route::post('/deleteOrder', 'TradeOrderController@deleteOrder');
            Route::post('/confirmedAllotment', 'TradeOrderController@confirmedAllotment');
        });

        Route::prefix('/budget-estimates')->group(function () {
            Route::post('/addBudgetEstimate', 'TradeBudgetEstimatesController@addBudgetEstimate');
            Route::post('/removeBudgetEstimate', 'TradeBudgetEstimatesController@removeBudgetEstimate');
            Route::post('/updateCustomerGoal', 'TradeBudgetEstimatesController@updateCustomerGoal');
            Route::post('/addComment', 'TradeBudgetEstimatesController@addComment');
            Route::post('/updateProgress', 'TradeBudgetEstimatesController@updateProgress');
            Route::post('/deleteBE', 'TradeBudgetEstimatesController@deleteBE');
        });

        Route::prefix('/inventory')->group(function () {
            Route::post('/reportCreate', 'TradeInventoryController@insertInventoryReport');
            Route::post('/adjustmentInsert', 'TradeInventoryController@adjustmentInsert');
            Route::post('/getItemByStoreId', 'TradeInventoryController@getItemByStoreId');
            Route::post('/updateAdjustmentDone', 'TradeInventoryController@updateAdjustmentDone');
            Route::post('/updateAdjustmentCancel', 'TradeInventoryController@updateAdjustmentCancel');
            Route::post('/getAreaByDomain', 'TradeInventoryController@getAreaByDomain');
            Route::post('/getStoreByCodeArea', 'TradeInventoryController@getStoreByCodeArea');
            Route::post('/getAllItem', 'TradeInventoryController@getAllItem');
            Route::post('/insertExplanation', 'TradeInventoryController@insertExplanation');
            Route::post('/getSumAdjustment', 'TradeInventoryController@getSumAdjustment');
            Route::post('/forControlStorageReport', 'TradeInventoryController@forControlStorageReport');
        });

        Route::prefix('/publications')->group(function () {
            Route::post('/create_one_publication', 'QlpublicationsController@create_one_publication');
            Route::post('/create_publication_status1', 'QlpublicationsController@create_publication_status1');
            Route::post('/create_publication_status2', 'QlpublicationsController@create_publication_status2');
            Route::post('/acceptance_publication', 'QlpublicationsController@acceptance_publication');
            Route::post('/find_publication/{id}', 'QlpublicationsController@find_publication');
            Route::post('/find_publication1', 'QlpublicationsController@find_publication1');
            Route::post('/detail_publication/{id}', 'QlpublicationsController@detail_publication');
            //ghi chú từng ấn phẩm
            Route::post('/note_publications', 'QlpublicationsController@note_publications');
            Route::post('/update_publications', 'QlpublicationsController@update_publications');
            Route::post('/findLog', 'QlpublicationsController@findLog');

            Route::post('/findLog1', 'QlpublicationsController@findLog1');


            Route::post('/get_all_publications', 'QlpublicationsController@get_all_publications');
            Route::post('/update_status_block', 'QlpublicationsController@update_status_block');
            Route::post('/note_one_publication', 'QlpublicationsController@note_one_publication');
            Route::post('/find_publics', 'QlpublicationsController@find_publics');
            Route::post('/find_one_trade', 'QlpublicationsController@find_one_trade');
            Route::post('/allLogAcception/{id}', 'QlpublicationsController@allLogAcception');
            Route::post('/update_status_order', 'QlpublicationsController@update_status_order');
            Route::post('/findKeyId/{id}/{key_id}', 'QlpublicationsController@findKeyId');
            Route::post('/changeStatusAcception', 'QlpublicationsController@changeStatusAcception');
            Route::post('/getAllTradeOder/{id}/{key_id}', 'QlpublicationsController@getAllTradeOder');
            Route::post('/allotment_publication', 'QlpublicationsController@allotment_publication');
            Route::post('/test/', 'QlpublicationsController@test');
        });

        Route::prefix('/warehouse')->group(function () {
            Route::post('/pgd_save', 'DeliveryBillController@pgdSave');
            Route::post('/getItemByStore', 'DeliveryBillController@getItemByStore');
            Route::post('/updateLisence/{id}', 'DeliveryBillController@updateLisence');
            Route::post('/getAreaByDomain', 'DeliveryBillController@getAreaByDomain');
            Route::post('/getStoreByArea', 'DeliveryBillController@getStoreByArea');
        });

        Route::prefix('/transfer')->group(function () {
            Route::post('/save', 'TransferController@save');
            Route::post('/update/{id}', 'TransferController@update');
            Route::post('/cancel', 'TransferController@cancel');
            Route::post('/delete', 'TransferController@deleteItem');
            Route::post('/confirmExport', 'TransferController@confirmExport');
            Route::post('/confirmImport', 'TransferController@confirmImport');
            Route::post('/confirmCreate', 'TransferController@confirmCreate');
            Route::post('/getAvgByCodeItem', 'TransferController@getAvgByCodeItem');

        });

    });

});

