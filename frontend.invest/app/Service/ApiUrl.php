<?php

namespace App\Service;

class ApiUrl {

	// Investor New
	const INVESTOR_NEW_LIST = 'investor/new/list';
	const INVESTOR_NEW_CONFIRM = 'investor/new/confirm';
	const INVESTOR_NEW_BLOCK = 'investor/new/block';
	const INVESTOR_NEW_DETAIL = 'investor/new/detail';
	// Investor
	const INVESTOR_LIST = 'investor/list';
	const INVESTOR_REPORT_TLS = 'investor/get_report_care_daily';
	const INVESTOR_DETAIL = 'investor/detail';
	const INVESTOR_LIST_UY_QUYEN = 'investor/list_ndt_uy_quyen';
	// Menu
    const MENU_SIDEBAR = 'menu/sidebar';
    // Transaction
    const TRANSACTION_MONEY_PAYMENT = 'transaction/money_payment_v2';
    const TRANSACTION_COUNT_ALL_TIME = 'transaction/count_all_time';
    const TRANSACTION_COUNT_MONTH = 'transaction/count_month';

}
