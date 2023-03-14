<?php

use Illuminate\Http\Response;
use Illuminate\Http\Request;
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

Route::prefix('ctv-tienngay')->group(function () {
    Route::post('/register_store', 'UserController@register_store');
    Route::post('/check_otp_register', 'UserController@check_otp_register');
    Route::post('/gui_lai_otp', 'UserController@gui_lai_otp');
    Route::post('/login', 'UserController@login');
    Route::post('/quen_mat_khau', 'UserController@quen_mat_khau');
    Route::post('/get_all_camnangCTV', 'NewController@get_all_camnangCTV');
    Route::post('/detail', 'NewController@detail');
    Route::post('/views', 'NewController@views');
    Route::post('/detail_user', 'UserController@detail_user');
    Route::post('/store_thongtintaikhoan', 'UserController@store_thongtintaikhoan');
    Route::post('/doi_mat_khau', 'UserController@doi_mat_khau');
    Route::post('/them_tai_khoan', 'UserController@them_tai_khoan');
    Route::post('/list_stk_user', 'UserController@list_stk_user');
    Route::post('/xoa_tai_khoan', 'UserController@xoa_tai_khoan');
    Route::post('/upload_image_cmt', 'UserController@upload_image_cmt');
    Route::post('/get_province', 'DonVayController@get_province');
    Route::post('/get_district', 'DonVayController@get_district');
    Route::post('/hk_ward', 'DonVayController@hk_ward');
    Route::post('/submit_donvay', 'DonVayController@submit_donvay');
    Route::get('/get_banner', 'BannerController@get_all');
    Route::post('/get_don_vay', 'DonVayController@get_don_vay');
    Route::get('/get_banner_admin', 'BannerController@get_banner_admin');
    Route::post('/get_user_introduce', 'UserController@get_all_user_introduce_by_my_self');

    Route::post('/search_get_don_vay', 'DonVayController@search_get_don_vay');
    Route::post('/check_otp_qmk', 'UserController@check_otp_qmk');
    Route::post('/register_new_password', 'UserController@register_new_password');
    Route::post('/gui_lai_otp_qmk', 'UserController@gui_lai_otp_qmk');
    Route::post('/get_user_info', 'UserController@get_user_info');
    Route::post('/danh_sach_don_vay', 'DonVayController@danh_sach_don_vay');
    Route::post('/search_danhsachdonvay', 'DonVayController@search_danhsachdonvay');
    Route::post('/danh_sach_bao_hiem', 'DonVayController@danh_sach_bao_hiem');
    Route::post('/search_danhsachbaohiem', 'DonVayController@search_danhsachbaohiem');

    Route::post('/create_member', 'UserController@create_member');
    Route::post('/get_all_user_member', 'UserController@getAllMember');
    Route::post('/update_user_status', 'UserController@update_user_status');
    Route::post('/get_all_order_loan', 'DonVayController@get_all_order_loan');
    Route::post('/get_all_order_insurance', 'DonVayController@get_all_order_insurance');
    Route::post('/get_main_product', 'CommissionController@getMainProduct');
    Route::post('/get_list_product', 'CommissionController@getListProduct');
    Route::post('/create_commission', 'CommissionController@createCommission');
    Route::post('/get_list_commission', 'CommissionController@getAllCommission');

    Route::post('/get_all_pay', 'PayController@get_all_pay');

    Route::post('/get_baocao', 'DonVayController@get_baocao');
    Route::post('/get_baocao_cannhan', 'DonVayController@get_baocao_cannhan');
    Route::post('/check_phone_introduce', 'DonVayController@check_phone_introduce');

    Route::post('/getUserNotAuth', 'UserController@getUserNotAuth');
    Route::post('/checkEkyc', 'UserController@checkEkyc');
    Route::post('/updateVerifiedUSer', 'UserController@updateVerifiedUSer');
    Route::post('/save_token_device', 'UserController@save_token_device');

    Route::prefix('/app')->group(function () {
        Route::middleware('auth_ctv')->group(function () {
            Route::prefix('/don-vay')->group(function () {
                Route::post('/create', 'App\DonVayController@create_donvay');
                Route::get('/list', 'App\DonVayController@get_don_vay');
                Route::get('/transaction', 'App\DonVayController@history_payment');
                Route::get('/report_general_by_user', 'App\DonVayController@report_general_by_user');
                Route::prefix('/doi-nhom')->group(function () {
                    Route::get('/don_vay_member', 'App\DonVayController@get_don_vay_member');
                    Route::get('/report_group_general', 'App\DonVayController@report_group_general');
                    Route::get('/report_by_year', 'App\DonVayController@report_by_year');
                    Route::get('/report_rate_by_month', 'App\DonVayController@report_rate_by_month');
                    Route::get('/report_rate_month_by_member', 'App\DonVayController@report_rate_month_by_member');
                    Route::get('/total_member', 'App\DonVayController@total_member');
                });
            });

            Route::prefix('/user')->group(function () {
                Route::get('/info', 'App\UserController@info');
                Route::post('/identity', 'App\UserController@identity');
                Route::post('/add_bank_payment', 'App\UserController@add_bank_payment');
                Route::get('/list_bank_user', 'App\UserController@get_list_bank_user');
                Route::post('/update_info', 'App\UserController@update_info');
                Route::post('/update_avatar', 'App\UserController@update_avatar');
                Route::get('/referral_link', 'App\UserController@referral_link');
                Route::post('/update_password', 'App\UserController@update_password');
                Route::post('/save_device_token_user', 'App\UserController@save_device_token_user');

                Route::prefix('/doi-nhom')->group(function () {
                    Route::get('/member', 'App\UserController@member');
                    Route::post('/status_member', 'App\UserController@update_status_member');
                    Route::post('/add-member', 'App\UserController@create_member');
                });
            });
        });

        Route::prefix('/config')->group(function () {
            Route::get('/lead_type_finance', 'ConfigController@lead_type_finance');
            Route::get('/get_list_bank', 'ConfigController@get_list_bank');
        });

        Route::prefix('/upload')->group(function () {
            Route::post('/', 'UploadController@upload');
        });

        Route::get('/review', 'App\AppController@review');
    });
});

Route::prefix('/ctv')->group(function () {
    Route::get('/document', function () {
        $openapi = \OpenApi\Generator::scan([__DIR__ . '/../Http']);
        header('Content-Type: application/x-yaml');
        return $openapi->toYaml();
    });
});
