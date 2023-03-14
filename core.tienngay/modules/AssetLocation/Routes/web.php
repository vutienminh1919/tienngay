<?php

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

Route::prefix('/assetLocation')->group(function () {
    Route::get('/', function () {
        echo 'connected';
    });

    Route::middleware('auth_asset_location')->group(function () {
        Route::prefix('/warehouse')->group(function () {
            Route::post('/create_warehouse_pgd', 'WarehouseController@create_warehouse_pgd');
            Route::post('/create_warehouse_general', 'WarehouseController@create_warehouse_general');
            Route::post('/list', 'WarehouseController@list');
            Route::post('/report_all', 'WarehouseController@report_all');
            Route::post('/report_partial', 'WarehouseController@report_partial');
            Route::post('/view_all', 'WarehouseController@view_all');
        });

        Route::prefix('/device')->group(function () {
            Route::post('/import_device', 'DeviceController@import_device');
            Route::post('/check_import_device', 'DeviceController@check_import_device');
            Route::post('/detail', 'DeviceController@detail');
            Route::post('/calculate_stock_price', 'DeviceController@calculate_stock_price');
            Route::post('/transfer', 'DeviceController@transfer');
            Route::post('/check_transfer', 'DeviceController@check_transfer');
            Route::post('/check_import_old', 'DeviceController@check_import_old');
            Route::post('/import_old', 'DeviceController@import_old');
            Route::post('/all_device', 'DeviceController@all_device');
        });

        Route::prefix('/partner')->group(function () {
            Route::post('/create', 'PartnerController@create');
            Route::post('/list', 'PartnerController@list');
        });

        Route::prefix('/contract')->group(function () {
            Route::post('/asset_by_user_business', 'ContractController@asset_by_user_business');
            Route::post('/recall_device', 'ContractController@recall_device');
            Route::post('/asset_by_asm_business', 'ContractController@asset_by_asm_business');
            Route::post('/get_store_by_asm', 'ContractController@get_store_by_asm');
            Route::post('/update_address_contract', 'ContractController@update_address_contract');
            Route::post('/update_note_contract', 'ContractController@update_note_contract');
            Route::post('/contract_by_collection', 'ContractController@contract_by_collection');
            Route::post('/get_store_by_collection', 'ContractController@get_store_by_collection');
            Route::post('/excel_asset_by_user_business', 'ContractController@excel_asset_by_user_business');
            Route::post('/recall_device_hand_over', 'ContractController@recall_device_hand_over');

        });

        Route::prefix('/warehouse')->group(function () {
            Route::post('/warehouse_local', 'WarehouseController@warehouse_local');
            Route::post('/detail', 'WarehouseController@detail');
            Route::post('/history', 'WarehouseController@history');
            Route::post('/backup', 'WarehouseController@backup');
        });

    });

    Route::prefix('/device')->group(function () {
        Route::post('/miles', 'DeviceController@miles');
        Route::post('/location', 'DeviceController@location');
        Route::post('/auth_vset', 'DeviceController@auth_vset');
        Route::post('/check_status_device_active', 'DeviceController@check_status_device_active');
        Route::post('/alarm', 'DeviceController@alarm');
    });

    Route::prefix('/contract')->group(function () {
        Route::post('/send_alarm_contract_by_product_asset_location', 'ContractController@send_alarm_contract_by_product_asset_location');
        Route::post('/contract_by_product_asset_location', 'ContractController@contract_by_product_asset_location');
        Route::post('/deepDetect', 'ContractController@deepDetect');
    });

    Route::prefix('/address')->group(function () {
        Route::post('/city', 'AddressController@city');
        Route::post('/district', 'AddressController@district');
        Route::post('/ward', 'AddressController@ward');
    });

    Route::prefix('/warehouse')->group(function () {
        Route::post('/report_warehouse', 'WarehouseController@report_warehouse');
        Route::post('/contract_disbursement', 'WarehouseController@contract_disbursement');;
    });

});
