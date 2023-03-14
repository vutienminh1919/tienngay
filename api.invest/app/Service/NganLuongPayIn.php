<?php


namespace App\Service;


class NganLuongPayIn
{
    public function __construct()
    {
        $this->nganluong_url = env('URL_NGAN_LUONG');
        $this->merchant_site_code = env('MERCHANT_ID');
        $this->secure_pass = env('MERCHANT_PASS');
        $this->url_nl_order = env('URL_ORDER_NL');
        $this->receiver = env('RECEIVER');
        $this->affiliate_code = "";
    }

    //HÀM TẠO ĐƯỜNG LINK THANH TOÁN QUA NGÂNLƯỢNG.VN VỚI THAM SỐ MỞ RỘNG
    public function buildCheckoutUrlExpand($arr_param)
    {
        if ($arr_param['affiliate_code'] == "") $arr_param['affiliate_code'] = $this->affiliate_code;
        $secure_code = '';
        $secure_code = implode(' ', $arr_param) . ' ' . $this->secure_pass;
        //var_dump($secure_code). "<br/>";
        $arr_param['secure_code'] = md5($secure_code);
        //echo $arr_param['secure_code'];
        $redirect_url = $this->nganluong_url;
        if (strpos($redirect_url, '?') === false) {
            $redirect_url .= '?';
        } else if (substr($redirect_url, strlen($redirect_url) - 1, 1) != '?' && strpos($redirect_url, '&') === false) {
            $redirect_url .= '&';
        }
        $url = '';
        foreach ($arr_param as $key => $value) {
            $value = urlencode($value);
            if ($url == '') {
                $url .= $key . '=' . $value;
            } else {
                $url .= '&' . $key . '=' . $value;
            }
        }
//		var_dump($redirect_url . $url);
        return $redirect_url . $url;
    }

    //HÀM KIỂM TRA TÍNH ĐÚNG ĐẮN CỦA ĐƯỜNG LINK KẾT QUẢ TRẢ VỀ TỪ NGÂNLƯỢNG.VN
    public function verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code)
    {
        // Tạo mã xác thực từ chủ web
        $str = '';
        $str .= ' ' . strval($transaction_info);
        $str .= ' ' . strval($order_code);
        $str .= ' ' . strval($price);
        $str .= ' ' . strval($payment_id);
        $str .= ' ' . strval($payment_type);
        $str .= ' ' . strval($error_text);
        $str .= ' ' . strval($this->merchant_site_code);
        $str .= ' ' . strval($this->secure_pass);
        // Mã hóa các tham số
        $verify_secure_code = '';
        $verify_secure_code = md5($str);
        // Xác thực mã của chủ web với mã trả về từ nganluong.vn
        if ($verify_secure_code === $secure_code) return true;
        else return false;
    }


    function getTransactionDetails($order_code)
    {
        $fnc = "getTransactionDetails";
        $checksum = $order_code . "|" . $this->secure_pass;
        //echo $checksum;
        $params = array(
            'merchant_id' => $this->merchant_site_code,
            'checksum' => MD5($checksum),
            'order_code' => $order_code
        );
        $api_url = $this->url_nl_order;
        $post_field = '';
        foreach ($params as $key => $value) {
            if ($post_field != '') $post_field .= '&';
            $post_field .= $key . "=" . $value;
        }
        $this->WriteLog($fnc . "-" . date("dmY", time()) . ".txt", " ================= START ======================= ");
        $this->WriteLog($fnc . "-" . date("dmY", time()) . ".txt", "[INPUT]: " . json_encode($params));
        $this->WriteLog($fnc . "-" . date("dmY", time()) . ".txt", " ================= END ======================= ");
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
        $this->WriteLog($fnc . "-" . date("dmY", time()) . ".txt", " ================= START ======================= ");
        $this->WriteLog($fnc . "-" . date("dmY", time()) . ".txt", "[OUTPUT_exec]: " . json_encode($result));
        $this->WriteLog($fnc . "-" . date("dmY", time()) . ".txt", "[OUTPUT_getinfo]: " . json_encode($status));
        $this->WriteLog($fnc . "-" . date("dmY", time()) . ".txt", " ================= END ======================= ");
        if ($result != '' && $status == 200) {
            return $result;
        }
        return false;
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

    function web_getTransactionDetails($order_code)
    {
        $fnc = "getTransactionDetails";
        $checksum = $order_code . "|" . $this->secure_pass;
        //echo $checksum;
        $params = array(
            'merchant_id' => $this->merchant_site_code,
            'checksum' => MD5($checksum),
            'order_code' => $order_code
        );
        $api_url = $this->url_nl_order;
        $post_field = '';
        foreach ($params as $key => $value) {
            if ($post_field != '') $post_field .= '&';
            $post_field .= $key . "=" . $value;
        }
        $this->web_WriteLog($fnc . "-" . date("dmY", time()) . ".txt", " ================= START ======================= ");
        $this->web_WriteLog($fnc . "-" . date("dmY", time()) . ".txt", "[INPUT]: " . json_encode($params));
        $this->web_WriteLog($fnc . "-" . date("dmY", time()) . ".txt", " ================= END ======================= ");
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
        $this->web_WriteLog($fnc . "-" . date("dmY", time()) . ".txt", " ================= START ======================= ");
        $this->web_WriteLog($fnc . "-" . date("dmY", time()) . ".txt", "[OUTPUT_exec]: " . json_encode($result));
        $this->web_WriteLog($fnc . "-" . date("dmY", time()) . ".txt", "[OUTPUT_getinfo]: " . json_encode($status));
        $this->web_WriteLog($fnc . "-" . date("dmY", time()) . ".txt", " ================= END ======================= ");
        if ($result != '' && $status == 200) {
            return $result;
        }
        return false;
    }

    function web_WriteLog($fileName, $data, $breakLine = true, $addTime = true)
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
        }
    }
}
