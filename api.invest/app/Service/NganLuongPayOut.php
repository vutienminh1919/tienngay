<?php


namespace App\Service;


class NganLuongPayOut extends BaseService
{
    function __construct()
    {
        $this->merchant_id_nl_withdraw = env('MERCHANT_ID_NL_WITHDRAW');
        $this->merchant_pass_nl_withdraw = env('MERCHANT_PASS_NL_WITHDRAW');
        $this->receiver_email_nl_withdraw = env('RECEIVER_EMAIL_NL_WITHDRAW');
        $this->url_nl_withdraw = env('URL_NL_WITHDRAW');
    }

    function SetCashoutRequest($data)
    {
        $params = array(
            'merchant_id' => $this->merchant_id_nl_withdraw, //Mã merchant khai báo tại NganLuong.vn
            'merchant_password' => MD5($this->merchant_pass_nl_withdraw), //MD5(Mật khẩu kết nối giữa merchant và NganLuong.vn)
            'receiver_email' => $this->receiver_email_nl_withdraw,
            'func' => "SetCashoutRequest",
            'ref_code' => $data['ref_code'], //Mã hóa đơn do website bán hàng sinh ra
            'total_amount' => $data['total_amount'], //Tổng số tiền rút
            'account_type' => $data['account_type'], //Kiểu giao dịch: 2 - Rút về thẻ; 3 - Rút về tài khoản; Nếu không truyền hoặc bằng rỗng thì =3
            'bank_code' => $data['bank_code'],
            'card_fullname' => $data['card_fullname'], //tên chủ tài khoản/ thẻ
            'card_number' => $data['card_number'], //Số thẻ/tài khoản
            'card_month' => $data['card_month'], //Tháng phát hành thẻ
            'card_year' => $data['card_year'], //Năm phát hành thẻ
            'branch_name' => $data['branch_name'], //Chi nhánh
            'reason' => !empty($data['reason']) ? $data['reason'] : 'TienNgay.vn thanh toán'
        );

        $post_field = '';
        foreach ($params as $key => $value) {
            if ($post_field != '')
                $post_field .= '&';
            $post_field .= $key . "=" . urlencode($value);
        }
        $nl_result = $this->CheckoutCall($post_field, 'SetCashoutRequest');
        return $nl_result;
    }

    function CheckoutCall($post_field, $fnc)
    {
        $this->WriteLog($fnc . date("Ymd", time()) . ".txt", " ================= START ======================= ");
        $this->WriteLog($fnc . date("Ymd", time()) . ".txt", "[INPUT]: " . json_encode($post_field));
        $this->WriteLog($fnc . date("Ymd", time()) . ".txt", " ================= END ======================= ");
        $api_url = $this->url_nl_withdraw;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field);
        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        $this->WriteLog($fnc . date("Ymd", time()) . ".txt", " ================= START ======================= ");
        $this->WriteLog($fnc . date("Ymd", time()) . ".txt", "[INPUT_WD]: nl_result :" . json_encode($result));
        $this->WriteLog($fnc . date("Ymd", time()) . ".txt", "[OUTPUT_WD]: status :" . json_encode($status));
        $this->WriteLog($fnc . date("Ymd", time()) . ".txt", " ================= END ======================= ");
        if ($result != '' && $status == 200) {
            $nl_result = json_decode($result);
            $nl_result->error_message = $this->GetErrorMessage($nl_result->error_code);
        } else
            $nl_result->error_message = $error;
        return $nl_result;
    }

    function GetErrorMessage($error_code)
    {
        $arrCode = array(
            '00' => 'Thành công',
            '99' => 'Lỗi chưa xác minh',
            '01' => 'Merchant không được phép sử dụng phương thức này',
            '02' => 'Thông tin thẻ sai định dạng',
            '03' => 'Thông tin merchant không chính xác',
            '04' => 'Có lỗi trong quá trình kết nối',
            '05' => 'Tên chủ thẻ không hợp lệ hoặc Số tiền không hợp lệ',
            '06' => 'Tên chủ thẻ không hợp lệ hoặc Số tiền không hợp lệ',
            '07' => 'Số tài khoản không hợp lệ',
            '08' => 'Lỗi kết nối tới ngân hàng. Lỗi xảy ra khi ngân hàng đang bảo trì, nâng cấp mà không xuất phát từ merchant',
            '09' => 'Mã ngân hàng không hợp lệ',
            '10' => 'Số dư tài khoản không đủ để thực hiện giao dịch',
            '11' => 'Mã tham chiếu ( ref_code ) không hợp lệ',
            '12' => 'Mã tham chiếu ( ref_code ) đã tồn tại',
            '14' => 'Function không đúng',
            '16' => 'receiver_email đang bị khóa hoặc phong tỏa không thể giao dịch',
            '17' => 'account_type không hợp lệ',
            '18' => 'Ngân hàng đang bảo trì',
        );
        return array_key_exists(trim($error_code), $arrCode) ? $arrCode[trim($error_code)] : '99';
    }

    function WriteLog($fileName, $data, $breakLine = true, $addTime = true)
    {
        $fp = fopen(storage_path("cron_log/") . $fileName, 'a');
        if ($fp) {
            if ($breakLine) {
                if ($addTime)
                    $line = date("H:i:s, d/m/Y:  ", time()) . $data . " \n";
                else
                    $line = $data . " \n";
            } else {
                if ($addTime)
                    $line = date("H:i:s, d/m/Y:  ", time()) . $data;
                else
                    $line = $data;
            }
            fwrite($fp, $line);
            fclose($fp);
            chmod(storage_path("cron_log/") . $fileName, 0777);
        }
    }

    function CheckCashout($ref_code, $transaction_id)
    {
        $params = array(
            'merchant_id' => $this->merchant_id_nl_withdraw,
            'merchant_password' => MD5($this->merchant_pass_nl_withdraw),
            'receiver_email' => $this->receiver_email_nl_withdraw,
            'func' => 'CheckCashout',
            'ref_code' => $ref_code,
            'transaction_id' => $transaction_id
        );
        $post_field = '';
        foreach ($params as $key => $value) {
            if ($post_field != '')
                $post_field .= '&';
            $post_field .= $key . "=" . urlencode($value);
        }
        $nl_result = $this->CheckoutCall($post_field, 'CheckCashout');
        return $nl_result;
    }

    function web_writeLog($fileName, $data, $breakLine = true, $addTime = true)
    {
        $fp = fopen(storage_path("log/") . $fileName, 'a');
        if ($fp) {
            if ($breakLine) {
                if ($addTime)
                    $line = date("H:i:s, d/m/Y:  ", time()) . $data . " \n";
                else
                    $line = $data . " \n";
            } else {
                if ($addTime)
                    $line = date("H:i:s, d/m/Y:  ", time()) . $data;
                else
                    $line = $data;
            }
            fwrite($fp, $line);
            fclose($fp);
//            chmod(storage_path("log/") . $fileName, 0777);
        }
    }

    function web_CheckCashout($ref_code, $transaction_id)
    {
        $params = array(
            'merchant_id' => $this->merchant_id_nl_withdraw,
            'merchant_password' => MD5($this->merchant_pass_nl_withdraw),
            'receiver_email' => $this->receiver_email_nl_withdraw,
            'func' => 'CheckCashout',
            'ref_code' => $ref_code,
            'transaction_id' => $transaction_id
        );
        $post_field = '';
        foreach ($params as $key => $value) {
            if ($post_field != '')
                $post_field .= '&';
            $post_field .= $key . "=" . urlencode($value);
        }
        $nl_result = $this->web_CheckoutCall($post_field, 'CheckCashout');
        return $nl_result;
    }

    function web_CheckoutCall($post_field, $fnc)
    {
        $this->web_writeLog($fnc . date("Ymd", time()) . ".txt", " ================= START ======================= ");
        $this->web_writeLog($fnc . date("Ymd", time()) . ".txt", "[INPUT]: " . json_encode($post_field));
        $this->web_writeLog($fnc . date("Ymd", time()) . ".txt", " ================= END ======================= ");
        $api_url = $this->url_nl_withdraw;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field);
        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        $this->web_writeLog($fnc . date("Ymd", time()) . ".txt", " ================= START ======================= ");
        $this->web_writeLog($fnc . date("Ymd", time()) . ".txt", "[INPUT_WD]: nl_result :" . json_encode($result));
        $this->web_writeLog($fnc . date("Ymd", time()) . ".txt", "[OUTPUT_WD]: status :" . json_encode($status));
        $this->web_writeLog($fnc . date("Ymd", time()) . ".txt", " ================= END ======================= ");
        if ($result != '' && $status == 200) {
            $nl_result = json_decode($result);
            $nl_result->error_message = $this->GetErrorMessage($nl_result->error_code);
        } else
            $nl_result->error_message = $error;
        return $nl_result;
    }

    function web_SetCashoutRequest($data)
    {
        $params = array(
            'merchant_id' => $this->merchant_id_nl_withdraw, //Mã merchant khai báo tại NganLuong.vn
            'merchant_password' => MD5($this->merchant_pass_nl_withdraw), //MD5(Mật khẩu kết nối giữa merchant và NganLuong.vn)
            'receiver_email' => $this->receiver_email_nl_withdraw,
            'func' => "SetCashoutRequest",
            'ref_code' => $data['ref_code'], //Mã hóa đơn do website bán hàng sinh ra
            'total_amount' => $data['total_amount'], //Tổng số tiền rút
            'account_type' => $data['account_type'], //Kiểu giao dịch: 2 - Rút về thẻ; 3 - Rút về tài khoản; Nếu không truyền hoặc bằng rỗng thì =3
            'bank_code' => $data['bank_code'],
            'card_fullname' => $data['card_fullname'], //tên chủ tài khoản/ thẻ
            'card_number' => $data['card_number'], //Số thẻ/tài khoản
            'card_month' => $data['card_month'], //Tháng phát hành thẻ
            'card_year' => $data['card_year'], //Năm phát hành thẻ
            'branch_name' => $data['branch_name'], //Chi nhánh
            'reason' => !empty($data['reason']) ? $data['reason'] : 'TienNgay thanh toán NĐT'
        );

        $post_field = '';
        foreach ($params as $key => $value) {
            if ($post_field != '')
                $post_field .= '&';
            $post_field .= $key . "=" . urlencode($value);
        }
        $nl_result = $this->web_CheckoutCall($post_field, 'SetCashoutRequest');
        return $nl_result;
    }
}
