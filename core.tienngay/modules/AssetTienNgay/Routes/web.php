<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Modules\AssetTienNgay\Model\User;

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

Route::prefix('/asset')->group(function () {
    Route::get('/document', function () {
        $openapi = \OpenApi\Generator::scan([__DIR__ . '/../Http']);
        header('Content-Type: application/x-yaml');
        return $openapi->toYaml();
    })->middleware('checkDoc');

    Route::prefix('/app')->group(function () {
        Route::post('/login', 'App\UserController@login');
        Route::post('/register', 'App\UserController@register');

        Route::middleware('auth_app')->group(function () {
            Route::prefix('/user')->group(function () {
                Route::post('/info', 'App\UserController@info');
                Route::post('/device', 'App\UserController@device');
                Route::post('/badge', 'App\UserController@badge');
                Route::post('/notification', 'App\UserController@notification');
                Route::post('/read_notification', 'App\UserController@read_notification');
            });

            Route::prefix('/supplies')->group(function () {
                Route::post('/list', 'App\SuppliesController@list');
                Route::post('/show', 'App\SuppliesController@show');
                Route::post('/upload', 'App\SuppliesController@upload');
                Route::post('/send_request', 'App\SuppliesController@send_request');
                Route::post('/type_request', 'App\SuppliesController@type_request');
                Route::post('/confirm', 'App\SuppliesController@confirm');
                Route::post('/supplies_status', 'App\SuppliesController@supplies_status');
            });

            Route::prefix('/menu')->group(function () {
                Route::post('/get_depart_main', 'App\MenuController@get_depart_main');
                Route::post('/get_child_app', 'App\MenuController@get_child_app');
                Route::post('/get_equip_main', 'App\MenuController@get_equip_main');
            });
        });
    });

    Route::prefix('/view')->group(function () {
        Route::post('/login', 'View\UserController@login');

        Route::middleware('auth_asset')->group(function () {
            Route::prefix('/menu')->group(function () {
                Route::post('/create', 'View\MenuAssetController@create');
                Route::post('/get_list_ware_house', 'View\MenuAssetController@get_list_ware_house');
                Route::post('/get_list_equipment', 'View\MenuAssetController@get_list_equipment');
                Route::post('/show', 'View\MenuAssetController@show');
                Route::post('/get_child', 'View\MenuAssetController@get_child');
                Route::post('/get_menu', 'View\MenuAssetController@get_menu');
                Route::post('/get_menu_parent', 'View\MenuAssetController@get_menu_parent');
                Route::post('/get_menu_add_role', 'View\MenuAssetController@get_menu_add_role');
                Route::post('/get_list_department', 'View\MenuAssetController@get_list_department');
                Route::post('/toggle_status', 'View\MenuAssetController@toggle_status');
                Route::post('/transfer_user', 'View\MenuAssetController@transfer_user');
                Route::post('/detail', 'View\MenuAssetController@detail');
                Route::post('/transfer_menu', 'View\MenuAssetController@transfer_menu');
                Route::post('/show_by_user', 'View\MenuAssetController@show_by_user');
                Route::post('/rename', 'View\MenuAssetController@rename');
                Route::post('/sw_user_depart', 'View\MenuAssetController@sw_user_depart');
                Route::post('/update_sign', 'View\MenuAssetController@update_sign');
            });

            Route::prefix('/supplies')->group(function () {
                Route::post('/create', 'View\SuppliesController@create');
                Route::post('/get_all_paginate', 'View\SuppliesController@get_all_paginate');
                Route::post('/get_count_all', 'View\SuppliesController@get_count_all');
                Route::post('/show', 'View\SuppliesController@show');
                Route::post('/get_all', 'View\SuppliesController@get_all');
                Route::post('/assign_user', 'View\SuppliesController@assign_user');
                Route::post('/change_user', 'View\SuppliesController@change_user');
                Route::post('/storage', 'View\SuppliesController@storage');
                Route::post('/broken', 'View\SuppliesController@broken');
                Route::post('/accept', 'View\SuppliesController@accept');
                Route::post('/update_info', 'View\SuppliesController@update_info');
                Route::post('/verified', 'View\SuppliesController@verified');
                Route::post('/update_image', 'View\SuppliesController@update_image');
                Route::post('/import_use', 'View\SuppliesController@import_use');
                Route::post('/import_save', 'View\SuppliesController@import_save');
                Route::post('/import_fail', 'View\SuppliesController@import_fail');
                Route::post('/get_all_paginate_dashboard', 'View\SuppliesController@get_all_paginate_dashboard');
                Route::post('/get_all_dashboard', 'View\SuppliesController@get_all_dashboard');
                Route::post('/get_count_all_dashboard', 'View\SuppliesController@get_count_all_dashboard');
                Route::post('/update_info_general', 'View\SuppliesController@update_info_general');
                Route::post('/clear_supplies', 'View\SuppliesController@clear_supplies');
                Route::post('/assign_many', 'View\SuppliesController@assign_many');
                Route::post('/office_confirm', 'View\SuppliesController@office_confirm');
                Route::post('/update_status_supplies', 'View\SuppliesController@update_status_supplies');
                Route::post('/report', 'View\SuppliesController@report');
                Route::post('/transfer_department', 'View\SuppliesController@transfer_department');
                Route::post('/get_warehouse_paginate', 'View\SuppliesController@get_warehouse_paginate');
                Route::post('/get_count_warehouse', 'View\SuppliesController@get_count_warehouse');
                Route::post('/get_all_data', 'View\SuppliesController@get_all_data');
                Route::post('/recall_many', 'View\SuppliesController@recall_many');
                Route::post('/verify_many', 'View\SuppliesController@verify_many');
            });

            Route::prefix('/role')->group(function () {
                Route::post('/create', 'View\RoleController@create');
                Route::post('/update', 'View\RoleController@update');
                Route::post('/get_menu_user', 'View\RoleController@get_menu_user');
                Route::post('/get_all', 'View\RoleController@get_all');
                Route::post('/show', 'View\RoleController@show');
                Route::post('/view_dashboard', 'View\RoleController@view_dashboard');
                Route::post('/get_all_user_role', 'View\RoleController@get_all_user_role');
                Route::post('/test', 'View\RoleController@test');
            });

            Route::prefix('/notification')->group(function () {
                Route::post('/badge', 'View\NotificationController@badge');
                Route::post('/notification_web', 'View\NotificationController@notification_web');
                Route::post('/read_notification', 'View\NotificationController@read_notification');
                Route::post('/notification_limit', 'View\NotificationController@notification_limit');
            });

            Route::prefix('/user')->group(function () {
                Route::post('/get_user', "View\UserController@get_user");
                Route::post('/get_user_add_role', "View\UserController@get_user_add_role");
            });

            Route::prefix('/action')->group(function () {
                Route::post('/create', 'View\ActionController@create');
                Route::post('/list', 'View\ActionController@list');
                Route::post('/get_action_add_user', 'View\ActionController@get_action_add_user');
            });

            Route::prefix('/action_user')->group(function () {
                Route::post('/create', 'View\ActionUserController@create');
                Route::post('/show_action_user', 'View\ActionUserController@show_action_user');
                Route::post('/get_slug_action_user', 'View\ActionUserController@get_slug_action_user');
            });
        });
    });

    Route::prefix('/supplies')->group(function () {
        Route::post('/general_code', 'View\SuppliesController@general_code');
    });
});
