<?php
namespace App\Service;

class NL_Checkoutv3
{
    public $cur_code = 'vnd';


    function __construct()
    {
        $this->version = '3.2';
        $this->url_api = env('URL_NL_CHECKOUT_V3');
        $this->merchant_id = env('MERCHANT_ID');
        $this->merchant_password = env('MERCHANT_PASS');
        $this->receiver_email = env('RECEIVER');

        $this->url_nl_order = env('URL_ORDER_NL');
        $this->affiliate_code = "";

    }

    function GetTransactionDetail($token)
    {
        $func = 'GetTransactionDetail';
        $params = array(
            'merchant_id' => $this->merchant_id,
            'merchant_password' => MD5($this->merchant_password),
            'version' => $this->version,
            'function' => $func,
            'token' => $token
        );
        $this->cron_WriteLog("NL" . $func . date("Ymd", time()) . ".txt", " ================= START ======================= ");
        $this->cron_WriteLog("NL" . $func . date("Ymd", time()) . ".txt", "[INPUT]: " . json_encode($params));
        $this->cron_WriteLog("NL" . $func . date("Ymd", time()) . ".txt", " ================= END ======================= ");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url_api);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->cron_WriteLog("NL" . $func . date("Ymd", time()) . ".txt", " ================= START ======================= ");
        $this->cron_WriteLog("NL" . $func . date("Ymd", time()) . ".txt", "[INPUT_WD]: nl_result :" . json_encode($result));
        $this->cron_WriteLog("NL" . $func . date("Ymd", time()) . ".txt", "[OUTPUT_WD]: status :" . json_encode($status));
        $this->cron_WriteLog("NL" . $func . date("Ymd", time()) . ".txt", " ================= END ======================= ");
        $error = curl_error($ch);
        if ($result != '' && $status == 200) {
            $nl_result = simplexml_load_string($result);
            return $nl_result;
        }
        return false;

    }

    function CheckoutCall($data, $func)
    {
        $this->WriteLog("NL" . $func . date("Ymd", time()) . ".txt", " ================= START ======================= ");
        $this->WriteLog("NL" . $func . date("Ymd", time()) . ".txt", "[INPUT]: " . json_encode($data));
        $this->WriteLog("NL" . $func . date("Ymd", time()) . ".txt", " ================= END ======================= ");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url_api);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->WriteLog("NL" . $func . date("Ymd", time()) . ".txt", " ================= START ======================= ");
        $this->WriteLog("NL" . $func . date("Ymd", time()) . ".txt", "[INPUT_WD]: nl_result :" . json_encode($result));
        $this->WriteLog("NL" . $func . date("Ymd", time()) . ".txt", "[OUTPUT_WD]: status :" . json_encode($status));
        $this->WriteLog("NL" . $func . date("Ymd", time()) . ".txt", " ================= END ======================= ");
        $error = curl_error($ch);
        if ($result) {
            $nl_result = simplexml_load_string($result);
            return $nl_result;
        }
        return null;

    }

    function GetErrorMessage($error_code)
    {
        $arrCode = array(
            '00' => 'Thành công',
            '99' => 'Lỗi chưa xác minh',
            '06' => 'Mã merchant không tồn tại hoặc bị khóa',
            '02' => 'Địa chỉ IP truy cập bị từ chối',
            '03' => 'Mã checksum không chính xác, truy cập bị từ chối',
            '04' => 'Tên hàm API do merchant gọi tới không hợp lệ (không tồn tại)',
            '05' => 'Sai version của API',
            '07' => 'Sai mật khẩu của merchant',
            '08' => 'Địa chỉ email tài khoản nhận tiền không tồn tại',
            '09' => 'Tài khoản nhận tiền đang bị phong tỏa giao dịch',
            '10' => 'Mã đơn hàng không hợp lệ',
            '11' => 'Số tiền giao dịch lớn hơn hoặc nhỏ hơn quy định',
            '12' => 'Loại tiền tệ không hợp lệ',
            '29' => 'Token không tồn tại',
            '80' => 'Không thêm được đơn hàng',
            '81' => 'Đơn hàng chưa được thanh toán',
            '110' => 'Địa chỉ email tài khoản nhận tiền không phải email chính',
            '111' => 'Tài khoản nhận tiền đang bị khóa',
            '113' => 'Tài khoản nhận tiền chưa cấu hình là người bán nội dung số',
            '114' => 'Giao dịch đang thực hiện, chưa kết thúc',
            '115' => 'Giao dịch bị hủy',
            '118' => 'tax_amount không hợp lệ',
            '119' => 'discount_amount không hợp lệ',
            '120' => 'fee_shipping không hợp lệ',
            '121' => 'return_url không hợp lệ',
            '122' => 'cancel_url không hợp lệ',
            '123' => 'items không hợp lệ',
            '124' => 'transaction_info không hợp lệ',
            '125' => 'quantity không hợp lệ',
            '126' => 'order_description không hợp lệ',
            '127' => 'affiliate_code không hợp lệ',
            '128' => 'time_limit không hợp lệ',
            '129' => 'buyer_fullname không hợp lệ',
            '130' => 'buyer_email không hợp lệ',
            '131' => 'buyer_mobile không hợp lệ',
            '132' => 'buyer_address không hợp lệ',
            '133' => 'total_item không hợp lệ',
            '134' => 'payment_method, bank_code không hợp lệ',
            '135' => 'Lỗi kết nối tới hệ thống ngân hàng',
            '140' => 'Đơn hàng không hỗ trợ thanh toán trả góp',);

        return $arrCode[(string)$error_code];
    }

    function BTO_NLCheckout($order_code, $total_amount, $bank_code, $order_description, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile,
                            $buyer_address, $notify_url)
    {
        $fnc = 'SetExpressCheckout';
        $params = array(
            'merchant_id' => $this->merchant_id, //Mã merchant khai báo tại NganLuong.vn
            'merchant_password' => MD5($this->merchant_password), //MD5(Mật khẩu kết nối giữa merchant và NganLuong.vn)
            'version' => $this->version,
            'function' => $fnc,
            'receiver_email' => $this->receiver_email,
            'order_code' => $order_code, //Mã hóa đơn do website bán hàng sinh ra
            'total_amount' => $total_amount, //Tổng số tiền của hóa đơn
            'payment_method' => 'BANK_TRANSFER_ONLINE', //Phương thức thanh toán
            'bank_code' => $bank_code, //Mã Ngân hàng
            'payment_type' => '1', //Kiểu giao dịch: 1 - Ngay; 2 - Tạm giữ; Nếu không truyền hoặc bằng rỗng thì lấy theo chính sách của NganLuong.vn
            'order_description' => $order_description, //Mô tả đơn hàng
            'tax_amount' => 0, //Tổng số tiền thuế
            'fee_shipping' => 0, //Phí vận chuyển
            'discount_amount' => 0, //Số tiền giảm giá
            'return_url' => $return_url, //Địa chỉ website nhận thông báo giao dịch thành công
            'cancel_url' => $cancel_url, //Địa chỉ website nhận "Hủy giao dịch"
            'notify_url' => $notify_url, //Địa chỉ server ( website ) nhận thông báo giao dịch thành công giữa 2 server
            'buyer_fullname' => $buyer_fullname, //Tên người mua hàng
            'buyer_email' => $buyer_email, //Địa chỉ Email người mua
            'buyer_mobile' => $buyer_mobile, //Điện thoại người mua
            'buyer_address' => $buyer_address, //Địa chỉ người mua hàng
            'total_item' => 1,
            'cur_code' => "vnd",
        );
//        $post_field = '';
//        $post_field .= http_build_query($params);

        $nl_result = $this->CheckoutCall($params, $fnc);
        return $nl_result;
    }

    function cron_WriteLog($fileName, $data, $breakLine = true, $addTime = true)
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
//            chmod(storage_path("log/") . $fileName, 0777);
        }
    }

    function WriteLog($fileName, $data, $breakLine = true, $addTime = true)
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

}

?>
