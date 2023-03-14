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

Route::get('demo/login', 'HomeController@login');
Route::get('demo/info', 'HomeController@info');

Route::get('/login', 'AuthController@login')->name('auth_login');
Route::post('/login', 'AuthController@login_post')->name('auth_login_post');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
    Route::get('/dashboard_telesales', 'DashboardController@dashboard_telesales')->name('dashboard_telesales');
    Route::post('/add_kpi', 'DashboardController@add_kpi')->name('dashboard.add_kpi');
    Route::get('/log_kpi', 'DashboardController@get_list_log_kpi')->name('get_list_log_kpi');
    // Info
    Route::get('/logout', 'AuthController@logout')->name('auth_logout');
    Route::get('/profile', 'AuthController@profile')->name('auth_profile');
    Route::post('/change-pass', 'AuthController@changePass')->name('change_pass');

    //notification
    Route::prefix('/notification')->group(function () {
        Route::get('/list', 'NotificationController@list')->name('notification.list');
        Route::get('/update_read/{id}', 'NotificationController@update_read')->name('notification.update_read');
        Route::get('/read_all', 'NotificationController@read_all')->name('notification.read_all');
    });

    //gioi han action
//    Route::group(['middleware' => 'checkAction'], function () {

    // check menu
    Route::group(['middleware' => 'checkMenu'], function () {
        Route::prefix('/user')->group(function () {
            Route::get('/list', 'UserController@list')->name('user_list');
        });

        Route::prefix('/role')->group(function () {
            Route::get('/list', 'RoleController@list')->name('role_list');
        });

        Route::prefix('/menu')->group(function () {
            Route::get('/list', 'MenuController@list')->name('menu_list');
        });

        Route::prefix('/action')->group(function () {
            Route::get('/list', 'ActionController@list')->name('action_list');
        });

        Route::prefix('/investor')->group(function () {
            Route::prefix('/new')->group(function () {
                Route::get('/list', 'InvestorController@listNew')->name('investor_new_list');
            });
            Route::get('/list', 'InvestorController@list')->name('investor_list');
            Route::get('/list_uq', 'InvestorController@list_ndt_uy_quyen')->name('investor_list_uq');
            Route::get('/thong_ke_call', 'InvestorController@thong_ke_call')->name('thong_ke_call');
            Route::get('/lead', 'InvestorController@get_list_lead_investor')->name('investor.lead');
            Route::get('/report_productivity_investor', 'InvestorController@report_productivity_investor')->name('report_productivity_investor');
            Route::get('/re_care', 'InvestorController@re_care')->name('investor_re_care');
        });

        Route::prefix('/contract')->group(function () {
            Route::get('/list', 'ContractController@list')->name('contract.list');
            Route::get('/list_uq', 'ContractController@list_uq')->name('contract.list_uq');
            Route::get('/report_uq', 'ContractController@report_uq')->name('contract.report_uq');
        });

        Route::prefix('/transaction')->group(function () {
            Route::get('/proceeds', 'TransactionController@proceeds')->name('transaction.proceeds');
            Route::get('/payment', 'TransactionController@payment')->name('transaction.payment');
            Route::get('/proceeds_uq', 'TransactionController@proceeds_uq')->name('transaction.proceeds_uq');
            Route::get('/payment_uq', 'TransactionController@payment_uq')->name('transaction.payment_uq');
        });

        Route::prefix('/interest')->group(function () {
            Route::get('/list_general', 'InterestController@list')->name('interest.list_general');
        });

        Route::prefix('/pay')->group(function () {
            Route::get('/list', 'PayController@index')->name('pay.list');

        });

        Route::prefix('/investment')->group(function () {
            Route::get('/', 'InvestmentController@index')->name('investment.list');
        });

        Route::prefix('/config')->group(function () {
            Route::get('/call', 'CallController@index')->name('config.call');
        });

        Route::prefix('/tool')->group(function () {
            Route::get('/', 'ToolController@index')->name('tool.index');
            Route::get('/index_commission', 'ToolController@index_commission')->name('tool.index_commission');
        });

        Route::prefix('/commission')->group(function () {
            Route::get('/', 'CommissionController@list')->name('commission');
        });

        Route::prefix('/event')->group(function () {
            Route::get('/list', 'EventController@list')->name('event.list');
        });

    });

    Route::get('/', 'DashboardController@index')->name('home');

    Route::prefix('/event')->group(function () {
        Route::get('/create', 'EventController@create')->name('event.create');
        Route::post('/store', 'EventController@store')->name('event.store');
        Route::post('/update_status', 'EventController@update_status')->name('event.update_status');
        Route::get('/show/{id}', 'EventController@show')->name('event.show');
        Route::post('/update', 'EventController@update')->name('event.update');
    });

    // User
    Route::prefix('/user')->group(function () {
        Route::get('/create', 'UserController@create')->name('user_create');
        Route::post('/create', 'UserController@create_post')->name('user_create_post');
        Route::post('/toggle-active', 'UserController@toggle_active')->name('user_toggle_active');
        Route::get('/update/{id}', 'UserController@update')->name('user_update');
        Route::post('/update/{id}', 'UserController@update_post')->name('user_update_post');
        Route::post('/tao_moi_ndt_uy_quyen', 'UserController@tao_moi_ndt_uy_quyen')->name('tao_moi_ndt_uy_quyen');
    });

    // Role
    Route::prefix('/role')->group(function () {
        Route::get('/create', 'RoleController@create')->name('role_create');
        Route::post('/create', 'RoleController@create_post')->name('role_create_post');
        Route::get('/update/{id}', 'RoleController@update')->name('role_update');
        Route::post('/update/{id}', 'RoleController@update_post')->name('role_update_post');
        Route::post('/toggle-active', 'RoleController@toggle_active')->name('role_toggle_active');
    });

    // Menu
    Route::prefix('/menu')->group(function () {
        Route::get('/create', 'MenuController@create')->name('menu_create');
        Route::post('/create', 'MenuController@create_post')->name('menu_create_post');
        Route::post('/toggle-active', 'MenuController@toggle_active')->name('menu_toggle_active');
        Route::get('/update/{id}', 'MenuController@update')->name('menu_update');
        Route::post('/update/{id}', 'MenuController@update_post')->name('menu_update_post');
    });

    // Action
    Route::prefix('/action')->group(function () {
        Route::get('/create', 'ActionController@create')->name('action_create');
        Route::post('/create', 'ActionController@create_post')->name('action_create_post');
        Route::get('/update/{id}', 'ActionController@update')->name('action_update');
        Route::post('/update/{id}', 'ActionController@update_post')->name('action_update_post');
    });

    // Investor
    Route::prefix('/investor')->group(function () {
        Route::prefix('/new')->group(function () {
            Route::post('/confirm', 'InvestorController@confirmNew')->name('investor_new_confirm');
            Route::post('/block', 'InvestorController@blockNew')->name('investor_new_block');
            Route::get('/detail/{id}', 'InvestorController@detailNew')->name('investor_new_detail');
            Route::post('/detail/{id}', 'InvestorController@detailNewPost')->name('investor_new_detail_post');
        });
        Route::post('/update', 'InvestorController@update_invester_active')->name('update_invester_active');
        Route::get('/excel_all_list_active', 'InvestorController@excel_all_list_active')->name('excel_all_list_active');
        Route::get('/detail_investor/{id}', 'InvestorController@detail_investor');
        Route::get('/detail/{id}', 'InvestorController@detail')->name('investor_detail');
        Route::post('/them_phu_luc_ndt_uy_quyen', 'InvestorController@them_phu_luc_ndt_uy_quyen');
        Route::post('/call_update_investor', 'InvestorController@call_update_investor');
        Route::get('/call_detail/{id}', 'InvestorController@call_detail');
        Route::get('/excel_call', 'InvestorController@excel_call')->name('excel_call');
        Route::get('/call_lead_detail/{id}', 'InvestorController@call_lead_detail');
        Route::post('/call_update_lead', 'InvestorController@call_update_lead');
        Route::get('/history_call_lead/{id}', 'InvestorController@history_call_lead');
        Route::get('/history_call_investor/{id}', 'InvestorController@history_call_investor');
        Route::get('/excel_call_lead', 'InvestorController@excel_call_lead')->name('excel_call_lead');
        Route::get('/change_call', 'InvestorController@change_call')->name('change_call');
        Route::post('/total_excel_call', 'InvestorController@total_excel_call');
        Route::post('/total_excel_call_lead', 'InvestorController@total_excel_call_lead');
    });

    //contract
    Route::prefix('/contract')->group(function () {
        Route::get('/show', 'ContractController@show')->name('contract.show');
        Route::get('/excel', 'ContractController@excelContract')->name('contract.excel');
        Route::post('/payment_many', 'ContractController@payment_many')->name('contract.payment_many');
        Route::get('/excel_report_uq', 'ContractController@excel_report_uq')->name('contract.excel_report_uq');
        Route::get('/detail_contract/{id}', 'ContractController@detail_contract')->name('contract.detail_contract');
        Route::post('/calculator_due_before_maturity', 'ContractController@calculator_due_before_maturity')->name('contract.calculator_due_before_maturity');
        Route::post('/due_before_maturity', 'ContractController@due_before_maturity')->name('contract.due_before_maturity');
    });

    //transaction
    Route::prefix('/transaction')->group(function () {
        Route::get('/excelTransactionInvest', 'TransactionController@excelTransactionInvest')->name('transaction.excelTransactionInvest');
        Route::get('/excelTransactionPayment', 'TransactionController@excelTransactionPayment')->name('transaction.excelTransactionPayment');
    });

    //interest
    Route::prefix('/interest')->group(function () {
        Route::get('/create_general', 'InterestController@create_interest_general')->name('interest.create_general');
        Route::get('/active_interest_general', 'InterestController@active_interest_general');
        Route::get('/detail_show', 'InterestController@detail_show')->name('interest.detail_show');
        Route::get('/create_period', 'InterestController@create_interest_period')->name('interest.create_period');
        Route::get('/update_interest_period', 'InterestController@update_interest_period')->name('interest.update_interest_period');
        Route::get('/show', 'InterestController@show')->name('interest.show');
        Route::get('/edit_add_interest_period', 'InterestController@edit_add_interest_period')->name('interest.edit_add_interest_period');
    });

    //pay
    Route::prefix('/pay')->group(function () {
        Route::get('/paypal/{id}', 'PayController@detail_paypal')->name('pay.detail_paypal');
        Route::post('/paypal_investor', 'PayController@paypal_investor')->name('pay.paypal_investor');
        Route::get('/detail_paypal_hd_uq/{id}', 'PayController@detail_paypal_hd_uq');
        Route::post('/cap_nhat_ki_thanh_toan_ndt_uq', 'PayController@cap_nhat_ki_thanh_toan_ndt_uq');
        Route::get('/excel_pay_app', 'PayController@excel_pay_app')->name('pay.excel_app');
        Route::get('/excel_pay_uq', 'PayController@excel_pay_uq')->name('pay.excel_uq');
        Route::get('/list_uq', 'PayController@list_uq')->name('pay.list_uq');
        Route::post('/update_wait_payment/{id}', 'PayController@update_wait_payment')->name('pay.update_wait_payment');
        Route::post('/expire_contract', 'PayController@expire_contract')->name('pay.expire_contract');
    });


    //import
    Route::prefix('/import')->group(function () {
        Route::get('/', 'ImportController@index')->name('import.index');
        Route::post('/ndt_uy_quyen', 'ImportController@import_user_ndt_uy_quyen');
        Route::post('/import_contract_ndt_uy_quyen', 'ImportController@import_contract_ndt_uy_quyen');
        Route::post('/import_transaction_ndt_uy_quyen', 'ImportController@import_transaction_ndt_uy_quyen');
        Route::post('/import_lead_investor', 'ImportController@import_lead_investor');
        Route::post('/import_block_user_call', 'ImportController@import_block_user_call');
        Route::post('/import_refferral_code', 'ImportController@import_refferral_code');
    });

//    });
    Route::prefix('/investment')->group(function () {
        Route::post('/create', 'InvestmentController@create')->name('investment.create');
    });

    Route::post('/upload_img', 'UploadImageController@upload_img');

    Route::prefix('/config')->group(function () {
        Route::post('/config_call', 'CallController@config_call')->name('config');
    });

    Route::prefix('/tool')->group(function () {
        Route::post('/tool_calculator_interest', 'ToolController@tool_calculator_interest');
        Route::post('/tool_calculator_commission', 'ToolController@tool_calculator_commission');
    });

    Route::prefix('/commission')->group(function () {
        Route::get('/detail', 'CommissionController@detail')->name('commission.detail');
        Route::get('/excel', 'CommissionController@excel')->name('commission.excel');
        Route::get('/excel_detail', 'CommissionController@excel_detail')->name('commission.excel_detail');
    });
});

Route::prefix('/template')->group(function () {
    Route::get('/invest', 'TemplateController@invest');
    Route::get('/list_id_invest', 'TemplateController@list_id_invest');
    Route::get('/ndt_app', 'TemplateController@ndt_app');
    Route::get('/ndt_uyquyen', 'TemplateController@ndt_uyquyen');
    Route::get('/details_uyquyen', 'TemplateController@details_uyquyen');
    Route::get('/details_ndt', 'TemplateController@details_ndt');
});;
