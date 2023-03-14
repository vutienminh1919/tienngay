<?php

namespace Modules\VFCPayment\Service;

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

    public static function getlink($data) {
        $link = self::APP_URL . self::BANK_CODE . '-' . $data['van'] .'-'. self::SIZE_IMG 
            . '?amount=' . $data['amount'] 
            . '&addInfo='. str_replace(" ", "%", $data['description']) 
            . '&accountName=' . str_replace(" ", "%", self::ACCOUNT_NAME);
        return $link;
    }
}
