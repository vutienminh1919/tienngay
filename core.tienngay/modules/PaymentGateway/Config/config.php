<?php

return [
    'name' => 'PaymentGateway',
    'homedir' => base_path(),
    'momoCrypto' => true,
    'disable_module' => env("DISABLE_MODULE_PAYMENT_GATEWAY", false),
    'PAYMENT_TERM' => 1,	// thanh toán
    'FINAL_SETTLEMENT' => 2,	// tất toán
	'momoResultCode' => [
		'SUCCESS' => 0,
		'DECRYPTION_FAIL' => 2,
		'INVALID_PARTNER_CODE' => 9,
		'INVALID_REFERENCE1' => 1201,
		'INVALID_REFERENCE2' => 1202,
		'DATA_NOT_FOUND' => 1203,
		'DATA_EXPIRED' => 1204,
		'CONTRACT_COMPLETED' => 1205,
	],
    'momoAppkhResultCode' => [
        'SUCCESS'                        => 0,
        'INVALID_ENCRYPT_DATA'           => 2,
        'INVALID_WALLET_ID'              => 4,
        'DUPLICATE_REQUEST_ID'           => 8,
        'INVALID_PARTNER_CODE'           => 9,
        'INSUFFICIENT_FUNDS'             => 1001,
        'WALLET_CAP_EXCEEDED'            => 1004,
        'INVALID_CLIENT'                 => 2001,
        'INVALID_REFERENCE_1'            => 2002,
        'INVALID_REQUEST_ID'             => 2003,
        'INVALID_CHECKSUM_KEY'           => 2004,
        'INVALID_ACCOUNT_INFO'           => 2005,
        'INVALID_TOTAL_AMOUNT'           => 2006,
        'INVALID_BILL_TOTAL_AMOUNT'      => 2007,
        'INVALID_CHECK_REQUEST_ID'       => 2008,
        'TRANSACTION_EXPIRED'            => 2009,
        'TRANSACTION_NOT_FOUND'          => 2010,
        'TRANSACTION_CANCELED_BY_USER'   => 2011,
        'INVALID_BILL_INFO'              => 2013,
        'OVER_TRANS_IN_MONTHS'           => 2014,
        'OVER_TRANS_IN_DAYS'             => 2015,
    ],
    'momoResultCodeMessage' => [
        '0'           => 'Thành công',
        '1001'        => 'Lỗi khi thanh toán, ví MoMo không đủ tiền',
        '1004'        => 'Lỗi khi thanh toán, vượt quá giới hạn ví MoMo',
        '2009'        => 'Giao dịch trên MoMo đã hết hạn',
        '2006'        => 'Số tiền giao dịch vượt quá hạn mức MoMo cho phép',
        '2010'        => 'Giao dịch trên MoMo không tồn tại',
        '2011'        => 'Giao dịch đã huỷ trên ứng dụng MoMo',
        '2014'        => 'Vượt quá số giao dịch MoMo cho phép trong tháng',
        '2015'        => 'Vượt quá số giao dịch MoMo cho phép trong ngày',
    ],
	'CONTRACT_STATUS_PENDING' => 1,	// đang xử lý
    'CONTRACT_STATUS_SUCCESS' => 2,	// đã gạch nợ
    'CONTRACT_STATUS_FAILED' => 3,	// gạch nợ thất bại
    'CONTRACT_TYPE_TERM' => 4,	// thanh toán kỳ api.tienngay transaction['type']
    'CONTRACT_TYPE_FINAL_SETTLEMENT' => 3,	// tất toán api.tienngay transaction['type']
    'CONTRACT_TYPE_PAYMENT_TERM' => 1,	// thanh toán lãi kỳ
    'CONTRACT_COMPLETED' => 19, // Hợp đồng đã tất toán.
    'SEARCH_TYPE_CUSTOMER_INFO' => 1,
    'SEARCH_TYPE_CONTRACT_INFO' => 2,
    'MOMO_CLIENT_CODE' => [
        'WEB'       => 'webinapp',
        'ANDROID'   => 'android_app',
        'IOS'       => 'ios_app'
    ],
    'ios_uri' => 'vnTienngayCustomersScheme://',
];
