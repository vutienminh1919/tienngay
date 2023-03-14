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
Route::get('/', function () {
    echo 'connected';
});
Route::post('/auth/signin', 'AuthController@signin');
Route::post('/user/create', 'UserController@createUser');
Route::post('/tool/tool_calculator_interest', 'ToolController@tool_calculator_interest');
Route::post('/tool/tool_calculator_commission', 'ToolController@tool_calculator_commission');
Route::post('/insert_lead_invest', 'LeadInvestorController@insertLeadInvest');


Route::group(['middleware' => 'auth'], function () {
    // Info
    Route::post('/profile', 'AuthController@getProfile');
    Route::post('/change-pass', 'AuthController@changePass');
    Route::post('kpi', 'KpiController@createKpi');
    Route::post('log_kpi', 'KpiController@get_all_log_kpi');

    // User
    Route::prefix('/user')->group(function () {
        Route::post('/list', 'UserController@userList');
        Route::post('/all', 'UserController@allUser');
        Route::post('/add-role', 'UserController@addRole');
        Route::post('/toggle-active', 'UserController@toggleActive');
        Route::post('/update', 'UserController@updateUser');
        Route::post('/detail', 'UserController@detailUser');
        Route::post('/add-menu', 'UserController@addMenu');
        Route::post('/get_action_user', 'UserController@get_action_user');
        Route::post('/get_action_login', 'UserController@get_action_login');
        Route::post('/import_user_ndt_uy_quyen', 'UserController@import_user_ndt_uy_quyen');
        Route::post('/tao_moi_ndt_uy_quyen', 'UserController@tao_moi_ndt_uy_quyen');
    });

    // Role
    Route::prefix('/role')->group(function () {
        Route::post('/create', 'RoleController@createRole');
        Route::post('/all', 'RoleController@allRole');
        Route::post('/add-user', 'RoleController@addUser');
        Route::post('/add-menu', 'RoleController@addMenu');
        Route::post('/list', 'RoleController@roleList');
        Route::post('/toggle-active', 'RoleController@toggleActive');
        Route::post('/detail', 'RoleController@roleDetail');
        Route::post('/update', 'RoleController@updateRole');
        Route::post('/getRoleUser', 'RoleController@getRoleUser');
        Route::post('/get_user_role_telesales', 'RoleController@get_user_role_telesales');
        Route::post('/get_role_user', 'RoleController@get_role_user');
    });

    // Menu
    Route::prefix('/menu')->group(function () {
        Route::post('/create', 'MenuController@createMenu');
        Route::post('/list', 'MenuController@menuList');
        Route::post('/add-role', 'MenuController@addRole');
        Route::post('/parent/all', 'MenuController@allParent');
        Route::post('/toggle-active', 'MenuController@toggleActive');
        Route::post('/detail', 'MenuController@detailMenu');
        Route::post('/update', 'MenuController@updateMenu');
        Route::post('/sidebar', 'MenuController@sidebarMenu');
        Route::post('/all', 'MenuController@allMenu');
    });

    // Action
    Route::prefix('/action')->group(function () {
        Route::post('/create', 'ActionController@create');
        Route::post('/update', 'ActionController@update');
        Route::post('/detail', 'ActionController@detail');
        Route::post('/all', 'ActionController@allAction');
    });

    // Investor New
    Route::post('/investor/new/list', 'InvestorController@getListNew');
    Route::post('/investor/new/confirm', 'InvestorController@comfirmNew');
    Route::post('/investor/new/block', 'InvestorController@blockNew');
    Route::post('/investor/new/detail', 'InvestorController@detailNew');
    Route::post('/investor/new/update', 'InvestorController@updateNew');

    // Investor
    Route::prefix('/investor')->group(function () {
        Route::post('/list', 'InvestorController@list');
        Route::post('/detail', 'InvestorController@detail');
        Route::post('/list_ndt_uy_quyen', 'InvestorController@list_ndt_uy_quyen');
        Route::post('/update_invester_active', 'InvestorController@update_invester_active');
        Route::post('/excel_list', 'InvestorController@excel_list');
        Route::post('/call_detail', 'InvestorController@call_detail');
        Route::post('/call_update_investor', 'InvestorController@call_update_investor');
        Route::post('/excel_call', 'InvestorController@excel_call');
        Route::post('/history_call', 'InvestorController@history_call');
        Route::post('/assign_call_old', 'InvestorController@assign_call_old');
        Route::post('/test_investment_status', 'InvestorController@test_investment_status');
        Route::post('/assign_call_investor_active', 'InvestorController@assign_call_investor_active');
        Route::post('/test_auto', 'InvestorController@test_auto');
        Route::post('/change_call', 'InvestorController@change_call');
        Route::post('/update_payment_interest', 'InvestorController@update_payment_interest');
        Route::post('/getCountListNew', 'InvestorController@getCountListNew');
        Route::post('/block_user_assign_call', 'InvestorController@block_user_assign_call');
        Route::post('/get_report_care_daily', 'InvestorController@getReportProductivityDl');
        Route::post('/total_excel_call', 'InvestorController@total_excel_call');
        Route::post('/excel_call_v2', 'InvestorController@excel_call_v2');
        Route::post('/excel_list_v2', 'InvestorController@excel_list_v2');
        Route::post('/list_v2', 'InvestorController@list_v2');
    });

    //contract
    Route::prefix('/contract')->group(function () {
        Route::post('/get_all_contract', 'ContractController@get_all_contract');
        Route::post('/contract_payment_schedule', 'ContractController@contract_payment_schedule');
        Route::post('/get_all', 'ContractController@get_all');
        Route::post('/excel_all_contract', 'ContractController@excel_all_contract');
        Route::post('/them_phu_luc_ndt_uy_quyen', 'ContractController@them_phu_luc_ndt_uy_quyen');
        Route::post('/run_low_interest_contract_again', 'ContractController@run_low_interest_contract_again');
        Route::post('/clear_contract_uy_quyen', 'ContractController@clear_contract_uy_quyen');
        Route::post('/active_contract', 'ContractController@active_contract');
        Route::post('/get_contract_to_check_status', 'ContractController@get_contract_to_check_status');
        Route::post('/clear_contract_uq', 'ContractController@clear_contract_uq');
        Route::post('/payment_many', 'ContractController@payment_many');
        Route::post('/update_code_contract', 'ContractController@update_code_contract');
        Route::post('/expire_contract', 'ContractController@expire_contract');
        Route::post('/report_contract_uq', 'ContractController@report_contract_uq');
        Route::post('/calculator_due_before_maturity', 'ContractController@calculator_due_before_maturity');
        Route::post('/detail_contract', 'ContractController@detail_contract');
        Route::post('/due_before_maturity', 'ContractController@due_before_maturity');
    });

    //transaction
    Route::prefix('/transaction')->group(function () {
        Route::post('/money_management', 'TransactionController@money_management');
        Route::post('/money_payment', 'TransactionController@money_payment');
        Route::post('/count_all_time', 'TransactionController@count_all_time');
        Route::post('/count_month', 'TransactionController@count_month');
        Route::post('/money_management_all', 'TransactionController@money_management_all');
        Route::post('/overview_transaction_proceeds', 'TransactionController@overview_transaction_proceeds');
        Route::post('/money_payment_all', 'TransactionController@money_payment_all');
        Route::post('/payment_nl', 'TransactionController@payment_nl');
        Route::post('/money_management_v2', 'TransactionController@money_management_v2');
        Route::post('/chart_invest', 'TransactionController@chart_invest');
        Route::post('/dashboard_ndt', 'TransactionController@dashboard_ndt');
        Route::post('/money_payment_v2', 'TransactionController@money_payment_v2');
    });

    Route::prefix('/notification')->group(function () {
        Route::post('/get_paginate_notification_user', 'NotificationController@get_paginate_notification_user');
        Route::post('/read_all', 'NotificationController@read_all');
    });

    Route::prefix('/interest')->group(function () {
        Route::post('/create_interest_general', 'InterestController@create_interest_general');
        Route::post('/get_list_interest_general', 'InterestController@get_list_interest_general');
        Route::post('/active_interest_general', 'InterestController@active_interest_general');
        Route::post('/thong_ke_hop_dong', 'InterestController@thong_ke_hop_dong');
        Route::post('/show', 'InterestController@show');
        Route::post('/show_contract', 'InterestController@show_contract');
        Route::post('/create_interest_period', 'InterestController@create_interest_period');
        Route::post('/get_interest_period', 'InterestController@get_interest_period');
        Route::post('/update_interest_period', 'InterestController@update_interest_period');
        Route::post('/edit_add_interest_period', 'InterestController@edit_add_interest_period');
    });

    Route::prefix('/pay')->group(function () {
        Route::post('/get_all_pay_paginate', 'PayController@get_all_pay_paginate');
        Route::post('/detail_paypal', 'PayController@detail_paypal');
        Route::post('/paypal_investor', 'PayController@paypal_investor')->middleware('checkAction');
        Route::post('/cap_nhat_ki_thanh_toan_ndt_uq', 'PayController@cap_nhat_ki_thanh_toan_ndt_uq');
        Route::post('/get_all_pay_app', 'PayController@get_all_pay_app');
        Route::post('/check_transaction_nl', 'PayController@check_transaction_nl');
        Route::post('/get_all_pay_app_v2', 'PayController@get_all_pay_app_v2');
    });

    Route::prefix('/investment')->group(function () {
        Route::post('/get_investment', 'InvestmentController@get_investment');
        Route::post('/create', 'InvestmentController@create');
    });

    Route::prefix('/lead')->group(function () {
        Route::post('/importLeadInvestor', 'LeadInvestorController@importLeadInvestor');
        Route::post('/get_list_lead_investor', 'LeadInvestorController@get_list_lead_investor');
        Route::post('/call_detail', 'LeadInvestorController@call_detail');
        Route::post('/call_update_investor', 'LeadInvestorController@call_update_investor');
        Route::post('/history_call_lead', 'LeadInvestorController@history_call_lead');
        Route::post('/excel_call_lead', 'LeadInvestorController@excel_call_lead');
        Route::post('/assign_call_old', 'LeadInvestorController@assign_call_old');
        Route::post('/test_auto', 'LeadInvestorController@test_auto');
        Route::post('/change_call', 'LeadInvestorController@change_call');
        Route::post('/total_excel_call_lead', 'LeadInvestorController@total_excel_call_lead');
        Route::post('/excel_call_lead_v2', 'LeadInvestorController@excel_call_lead_v2');
    });

    Route::prefix('/call')->group(function () {
        Route::post('/config_call', 'ConfigCallController@config_call');
    });

    Route::prefix('/commission')->group(function () {
        Route::post('/create', 'CommissionController@create');
        Route::post('/get_all_commission', 'CommissionController@get_all_commission');
        Route::post('/detail_commission_investor', 'CommissionController@detail_commission_investor');
        Route::post('/excel_all_commission', 'CommissionController@excel_all_commission');
        Route::post('/import_commission', 'CommissionController@import_commission');
    });

    Route::prefix('/event')->group(function () {
        Route::post('/create', 'EventController@create');
        Route::post('/list', 'EventController@list');
        Route::post('/update_status', 'EventController@update_status');
        Route::post('/show', 'EventController@show');
        Route::post('/update', 'EventController@update');
    });

});

Route::post('/pay/lay_ki_tra_theo_ngay', 'PayController@lay_ki_tra_theo_ngay');
Route::post('/contract/import_contract_ndt_uy_quyen', 'ContractController@import_contract_ndt_uy_quyen');
Route::post('/contract/get_contract_by_promotions', 'ContractController@get_contract_by_promotions');
Route::post('/contract/report_contract', 'ContractController@report_contract');
Route::post('/transaction/import_transaction_pay_ndt_uy_quyen', 'TransactionController@import_transaction_pay_ndt_uy_quyen');
Route::post('/transaction/chart_invest_by_day_on_month', 'TransactionController@chart_invest_by_day_on_month');
Route::post('/transaction/chart_payment_by_day_on_month', 'TransactionController@chart_payment_by_day_on_month');
Route::post('/transaction/chart_payment', 'TransactionController@chart_payment');
Route::post('/pay/gach_no_ndt_uy_quyen', 'PayController@gach_no_ndt_uy_quyen');
Route::post('/logVimo/getLogVimo', 'LogVimoController@getLogVimo');
Route::post('/investor/test', 'InvestorController@test');
Route::post('/investor/get_call', 'InvestorController@get_call');
Route::post('/investor/identification', 'InvestorController@identification');
Route::post('/commission_cvkd', 'CommissionController@commission_cvkd');
Route::post('/find_user_by_event', 'UserController@find_user_by_event');
Route::post('/commission_group_cvkd', 'CommissionController@commission_group_cvkd');


// api app ndt
Route::prefix('/investment')->group(function () {
    Route::post('/get_investment_app', 'InvestmentController@get_investment_app');
    Route::post('/show', 'InvestmentController@show');
    Route::post('/investor_confirm', 'InvestmentController@investor_confirm');
    Route::post('/create_cpanel', 'InvestmentController@create_cpanel');
});

Route::group(['middleware' => 'authApp'], function () {
    Route::prefix('/auth')->group(function () {
        Route::post('/signin_app', 'AuthController@signin_app');
        Route::post('/checkLoginApp', 'AuthController@checkLoginApp');
        Route::post('/checkOtpResetPassApp', 'AuthController@checkOtpResetPassApp');
        Route::post('/checkOtpApp', 'AuthController@checkOtpApp');
        Route::post('/activeUserApp', 'AuthController@activeUserApp');
        Route::post('/update_password', 'AuthController@update_password');
    });

    Route::prefix('/user')->group(function () {
        Route::post('/app_register', 'UserController@app_register');
        Route::post('/getInfoUser', 'UserController@getInfoUserApp');
        Route::post('/findUserByPhone', 'UserController@findUserByPhone');
        Route::post('/updateOtpResetPass', 'UserController@updateOtpResetPass');
        Route::post('/resend_token', 'UserController@resend_token');
        Route::post('/update_info_user', 'UserController@update_info_user');
        Route::post('/change_password', 'UserController@change_password');
        Route::post('/link_social', 'UserController@link_social');
        Route::post('/phone_number_login_social', 'UserController@phone_number_login_social');
        Route::post('/active_phone_social', 'UserController@active_phone_social');
        Route::post('/link_account_social', 'UserController@link_account_social');
        Route::post('/rate_app', 'UserController@rate_app');
    });

    Route::prefix('/investor')->group(function () {
        Route::post('/create_investor', 'InvestorController@create_investor');
        Route::post('/update_link_vimo', 'InvestorController@update_link_vimo');
        Route::post('/active_link_vimo', 'InvestorController@active_link_vimo');
        Route::post('/unlink_vimo', 'InvestorController@unlink_vimo');
        Route::post('/upload_accuracy_app', 'InvestorController@upload_accuracy_app');
        Route::post('/get_investor_send_mkt', 'InvestorController@get_investor_send_mkt');
    });

    Route::prefix('/contract')->group(function () {
        Route::post('/sum_money_investor', 'ContractController@sum_money_investor');
        Route::post('/get_contract_investor_app', 'ContractController@get_contract_investor_app');
        Route::post('/confirm_investor_contract', 'ContractController@confirm_investor_contract');
        Route::post('/show_contract', 'ContractController@show_contract');
        Route::post('/financial_report_app', 'ContractController@financial_report_app');
        Route::post('/send_otp_invest', 'ContractController@send_otp_invest');
        Route::post('/xac_nhan_dau_tu', 'ContractController@xac_nhan_dau_tu');
        Route::post('/check_transaction_nl', 'ContractController@check_transaction_nl');
        Route::post('/get_promotions', 'ContractController@get_promotions');
        Route::post('/update_promotions', 'ContractController@update_promotions');
        Route::post('/financial_report_app_v2', 'ContractController@financial_report_app_v2');
    });

    Route::prefix('/transaction')->group(function () {
        Route::post('/create_transaction_investor_contract', 'TransactionController@create_transaction_investor_contract');
        Route::post('/history_transaction_investor', 'TransactionController@history_transaction_investor');
        Route::post('/get_transaction_nl_warning', 'TransactionController@get_transaction_nl_warning');
        Route::post('/get_bill_nl_warning', 'TransactionController@get_bill_nl_warning');
    });

    Route::prefix('/pay')->group(function () {
        Route::post('/create_pay_interest', 'PayController@create_pay_interest');
    });


    Route::prefix('/device')->group(function () {
        Route::post('/create_device', 'DeviceController@save_device');
        Route::post('/update_device', 'DeviceController@update_device');
        Route::post('/get_device_user', 'DeviceController@get_device_user');
        Route::post('/delete_device', 'DeviceController@delete_device');
        Route::post('/collect_device', 'DeviceController@collect_device');
    });

    Route::prefix('logVimo')->group(function () {
        Route::post('/create_log', 'LogVimoController@create_log');
    });
    Route::post('auth/test', 'AuthController@test');
    Route::post('test_excel', 'InvestorController@test_excel');
    Route::post('feedback/create', 'FeedbackController@create');

    //appV2
    Route::prefix('/v2')->group(function () {
        Route::prefix('/investor')->group(function () {
            Route::post('/target_account_receiving_interest', 'AppV2\InvestorController@target_account_receiving_interest');
        });

        Route::prefix('/contract')->group(function () {
            Route::post('/investment_confirmation_vimo', 'AppV2\ContractController@investment_confirmation_vimo');
            Route::post('/create_transaction_ngan_luong', 'AppV2\ContractController@create_transaction_ngan_luong');
            Route::post('/create_transaction_ngan_luong_v3', 'AppV2\ContractController@create_transaction_ngan_luong_v3');
            Route::post('/cancel', 'AppV2\ContractController@cancel');
            Route::post('/success_nl', 'AppV2\ContractController@success_nl');
            Route::get('/success', 'AppV2\ContractController@success');
            Route::post('/get_bill', 'AppV2\ContractController@get_bill');
            Route::post('/check_bill', 'AppV2\ContractController@check_bill');
        });

        Route::prefix('/user')->group(function () {
            Route::post('/app_register', 'AppV2\UserController@app_register');
            Route::post('/block_account', 'AppV2\UserController@block_account');
            Route::post('/confirm_block_account', 'AppV2\UserController@confirm_block_account');
            Route::post('/get_notification_user', 'AppV2\UserController@get_notification_user');
            Route::post('/get_all_active', 'AppV2\UserController@get_all_active');
            Route::post('/update_referral', 'AppV2\UserController@update_referral');
        });
    });




});
Route::prefix('/commission')->group(function () {
    Route::post('/commission_investor', 'CommissionController@commission_investor');
});
Route::prefix('/interest')->group(function () {
    Route::post('/get_interest', 'InterestController@get_interest');
});

Route::prefix('/bot')->group(function () {
    Route::post('/send_error', 'BotController@send_error');
});

//all app and dashboard
Route::prefix('/notification')->group(function () {
    Route::post('/get_notification_user', 'NotificationController@get_notification_user');
    Route::post('/count_unread_noti_user', 'NotificationController@count_unread_noti_user');
    Route::post('/update_read', 'NotificationController@update_read');
    Route::post('/create_notification_app', 'NotificationController@create_notification_app');
    Route::post('/create_transaction_ngan_luong', 'NotificationController@create_transaction_ngan_luong');
    Route::post('/popup', 'NotificationController@popup');
    Route::post('/read_all_app', 'NotificationController@read_all_app');
});

Route::post('/missed_call', 'LeadInvestorController@missed_call_investor');

//Call api data plan actual
Route::prefix('/plan')->group(function () {
    Route::post('/getDataInvestor', 'PlanActualController@getDataInvestor');
    Route::post('/sumPayNdt', 'PlanActualController@sumPayNdt');
    Route::post('/sumTransactionWallet', 'PlanActualController@sumTransactionWallet');
    Route::post('/sumTransactionWalletLastMonth', 'PlanActualController@sumTransactionWalletLastMonth');
    Route::post('/sumPayNdtActual', 'PlanActualController@sumPayNdtActual');
});

Route::prefix('/vbee')->group(function (){
    Route::post('/',function (){
        echo 'success';
    });
    Route::post('/vbeeImport','LeadInvestorController@vbeeImport');
    Route::post('/webhookVbeeNdt','LeadInvestorController@webhookVbeeNdt');
});
