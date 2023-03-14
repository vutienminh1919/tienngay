<?php

namespace Modules\ViewCpanel\Service;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

/**
* Tạo link QR Code Giao Dịch Ngân Hàng
*/
class VietQR
{
    const APP_URL = 'https://img.vietqr.io/image/';
    const BANK_CODE = 'VPB';
    const SIZE_IMG = 'compact2.png';
    const ACCOUNT_NAME = 'CTCP CONG NGHE TIEN NGAY';
    const MASTER_ACCOUNT = 222973988;
    const BANK_NAME = 'VPBank';

    public static function getlink($data) {
        $link = self::APP_URL . self::BANK_CODE . '-' . self::MASTER_ACCOUNT .'-'. self::SIZE_IMG 
            . '?amount=' . $data['amount'] 
            . '&addInfo='. str_replace(" ", "%", $data['description']) 
            . '&accountName=' . str_replace(" ", "%", self::ACCOUNT_NAME);
        return $link;
    }

    public static function bankInfo($data) {
        $link = self::APP_URL . self::BANK_CODE . '-' . self::MASTER_ACCOUNT .'-'. self::SIZE_IMG 
            . '?amount=' . $data['amount'] 
            . '&addInfo='. str_replace(" ", "%", $data['description']) 
            . '&accountName=' . str_replace(" ", "%", self::ACCOUNT_NAME);
        return [
            'BANK_NAME' => self::BANK_NAME,
            'ACCOUNT_NAME' => self::ACCOUNT_NAME,
            'MASTER_ACCOUNT' => self::MASTER_ACCOUNT,
            'AMOUNT' => $data['amount'],
            'DESCRIPTION' => $data['description'],
            'QRCODE' => $link
        ];
    }
}
