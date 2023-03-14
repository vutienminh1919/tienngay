<?php


namespace App\Service;


class Vimo
{
    public function __construct()
    {
        $this->VM_CHECKSUM_KEY = env('MERCHANT_VIMO_CHECKSUM');
        $this->VM_ENCRYPTION_KEY = env('MERCHANT_VIMO_ENCRYPTION_KEY');
        $this->VM_URL_CHECKOUT = env('MERCHANT_VIMO_URL');
        $this->VM_MERCHANT_ID = env('MERCHANT_VIMO_CODE');
        $this->VM_USER_ID = env('MERCHANT_VIMO_USER_ID');
    }

    #public $__eMethod = 'DES';
    public $__eMethod = 'AES';

    private $VM_CHECKSUM_KEY;
    private $VM_MERCHANT_ID;
    private $VM_USER_ID;
    private $VM_ENCRYPTION_KEY;
    private $VM_URL_CHECKOUT;

    function createWithdrawal($param, $type)
    {
        $fnc = 'CreateWithdrawal';
        $dataJson = json_encode($param);
        $encodeTRIPLEDES = $this->encryptNew($dataJson, $this->VM_ENCRYPTION_KEY);
        $checksum = md5($fnc . $this->VM_MERCHANT_ID . $this->VM_USER_ID . $type . $encodeTRIPLEDES . $this->VM_CHECKSUM_KEY);
        $send = array(
            "fnc" => $fnc,
            "mid" => $this->VM_MERCHANT_ID,
            "uid" => $this->VM_USER_ID,
            "type" => $type,
            "data" => $encodeTRIPLEDES,
            "checksum" => $checksum,
        );
        $result = $this->call($send, $fnc);
        return $result;
    }


    function getWithdrawalTransactionStatus($param)
    {
        $fnc = 'GetTransactionWithdrawalStatus';
        $dataJson = json_encode($param, true);
        $encodeTRIPLEDES = $this->encryptNew($dataJson, $this->VM_ENCRYPTION_KEY);
        $checksum = md5($fnc . $this->VM_MERCHANT_ID . $this->VM_USER_ID . $encodeTRIPLEDES . $this->VM_CHECKSUM_KEY);
        $send = array(
            "fnc" => $fnc,
            "mid" => $this->VM_MERCHANT_ID,
            "uid" => $this->VM_USER_ID,
            "data" => $encodeTRIPLEDES,
            "checksum" => $checksum,
            'order_code' => !empty($param['order_code']) ? $param['order_code'] : "" //Will be unset
        );
        $result = $this->call($send, $fnc);
        return $result;
    }

    function call($params, $fnc)
    {
        $this->WriteLog($fnc . date("Ymd", time()) . ".txt", " ================= START ======================= ");
        $this->WriteLog($fnc . date("Ymd", time()) . ".txt", "[INPUT]: " . json_encode($params));
        $this->WriteLog($fnc . date("Ymd", time()) . ".txt", " ================= END ======================= ");
        unset($params['order_code']);
        unset($params['amount']);
        $curl = curl_init($this->VM_URL_CHECKOUT);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        $response = curl_exec($curl);
        $resultStatus = curl_getinfo($curl);
        $this->WriteLog($fnc . date("Ymd", time()) . ".txt", " ================= START ======================= ");
        $this->WriteLog($fnc . date("Ymd", time()) . ".txt", "[OUTPUT_exec]: " . json_encode($response));
        $this->WriteLog($fnc . date("Ymd", time()) . ".txt", "[OUTPUT_getinfo]: " . json_encode($resultStatus));
        $this->WriteLog($fnc . date("Ymd", time()) . ".txt", " ================= END ======================= ");
        $data = json_decode($response, true);
        return $data;
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

    function getBalance($param)
    {
        $fnc = 'GetBalance';
        $dataJson = json_encode($param);
        $encodeTRIPLEDES = $this->encryptNew($dataJson, $this->VM_ENCRYPTION_KEY);
        $checksum = md5($fnc . $this->VM_MERCHANT_ID . $this->VM_USER_ID . $encodeTRIPLEDES . $this->VM_CHECKSUM_KEY);
        $send = array(
            "fnc" => $fnc,
            "mid" => $this->VM_MERCHANT_ID,
            "uid" => $this->VM_USER_ID,
            "data" => $encodeTRIPLEDES,
            "checksum" => $checksum,
        );
        $result = $this->call($send, $fnc);
        return $result;
    }

    public function sendUserLinked($param)
    {
        $fnc = 'SendUserLinked';
        $dataJson = json_encode($param);
        $encodeTRIPLEDES = $this->encryptNew($dataJson, $this->VM_ENCRYPTION_KEY);
        $checksum = md5($fnc . $this->VM_MERCHANT_ID . $this->VM_USER_ID . $encodeTRIPLEDES . $this->VM_CHECKSUM_KEY);
        $send = array(
            "fnc" => $fnc,
            "mid" => $this->VM_MERCHANT_ID,
            "uid" => $this->VM_USER_ID,
            "data" => $encodeTRIPLEDES,
            "checksum" => $checksum,
        );
        $result = $this->call($send, $fnc);
        return $result;
    }

    public function activeUserLinked($param)
    {
        $fnc = 'ActiveUserLinked';
        $dataJson = json_encode($param);
        $encodeTRIPLEDES = $this->encryptNew($dataJson, $this->VM_ENCRYPTION_KEY);
        $checksum = md5($fnc . $this->VM_MERCHANT_ID . $this->VM_USER_ID . $encodeTRIPLEDES . $this->VM_CHECKSUM_KEY);
        $send = array(
            "fnc" => $fnc,
            "mid" => $this->VM_MERCHANT_ID,
            "uid" => $this->VM_USER_ID,
            "data" => $encodeTRIPLEDES,
            "checksum" => $checksum,
        );
        $result = $this->call($send, $fnc);
        return $result;
    }

    public function unLinkUser($param)
    {
        $fnc = 'UnLinkUser';
        $dataJson = json_encode($param);
        $encodeTRIPLEDES = $this->encryptNew($dataJson, $this->VM_ENCRYPTION_KEY);
        $checksum = md5($fnc . $this->VM_MERCHANT_ID . $this->VM_USER_ID . $encodeTRIPLEDES . $this->VM_CHECKSUM_KEY);
        $send = array(
            "fnc" => $fnc,
            "mid" => $this->VM_MERCHANT_ID,
            "uid" => $this->VM_USER_ID,
            "data" => $encodeTRIPLEDES,
            "checksum" => $checksum,
        );
        $result = $this->call($send, $fnc);
        return $result;
    }

    public function getTokenLinked($param)
    {
        $fnc = 'GetTokenLinked';
        $dataJson = json_encode($param);
        $encodeTRIPLEDES = $this->encryptNew($dataJson, $this->VM_ENCRYPTION_KEY);
        $checksum = md5($fnc . $this->VM_MERCHANT_ID . $this->VM_USER_ID . $encodeTRIPLEDES . $this->VM_CHECKSUM_KEY);
        $send = array(
            "fnc" => $fnc,
            "mid" => $this->VM_MERCHANT_ID,
            "uid" => $this->VM_USER_ID,
            "data" => $encodeTRIPLEDES,
            "checksum" => $checksum,
        );
        $result = $this->call($send, $fnc);
        return $result;
    }

    public function requestCharging($param)
    {
        $fnc = 'RequestCharging';
        $dataJson = json_encode($param);
        $encodeTRIPLEDES = $this->encryptNew($dataJson, $this->VM_ENCRYPTION_KEY);
        $checksum = md5($fnc . $this->VM_MERCHANT_ID . $this->VM_USER_ID . $encodeTRIPLEDES . $this->VM_CHECKSUM_KEY);
        $send = array(
            "fnc" => $fnc,
            "mid" => $this->VM_MERCHANT_ID,
            "uid" => $this->VM_USER_ID,
            "data" => $encodeTRIPLEDES,
            "checksum" => $checksum,
        );
        $result = $this->call($send, $fnc);
        return $result;
    }

    public function getBalanceUserLinked($param)
    {
        $fnc = 'GetBalanceUserLinked';
        $dataJson = json_encode($param);
        $encodeTRIPLEDES = $this->encryptNew($dataJson, $this->VM_ENCRYPTION_KEY);
        $checksum = md5($fnc . $this->VM_MERCHANT_ID . $this->VM_USER_ID . $encodeTRIPLEDES . $this->VM_CHECKSUM_KEY);
        $send = array(
            "fnc" => $fnc,
            "mid" => $this->VM_MERCHANT_ID,
            "uid" => $this->VM_USER_ID,
            "data" => $encodeTRIPLEDES,
            "checksum" => $checksum,
        );
        $result = $this->call($send, $fnc);
        return $result;
    }

    //php v7.3
    function encryptNew($data, $encryptkey)
    {
        $method = 'AES-256-ECB';
        $key = hash('sha256', $encryptkey);
        $ivSize = openssl_cipher_iv_length($method);
        $iv = openssl_random_pseudo_bytes($ivSize);
        $encrypted = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv);
        // For storage/transmission, we simply concatenate the IV and cipher text
        $encrypted = base64_encode($iv . $encrypted);
        return $encrypted;
    }

    function decryptNew($data, $encryptkey, $method = 'AES-256-ECB')
    {
        $key = hash('sha256', $encryptkey);
        $data = base64_decode($data);
        $ivSize = openssl_cipher_iv_length($method);
        $iv = substr($data, 0, $ivSize);
        $data = openssl_decrypt(substr($data, $ivSize), $method, $key, OPENSSL_RAW_DATA, $iv);
        return $data;
    }

    function web_createWithdrawal($param, $type)
    {
        $fnc = 'CreateWithdrawal';
        $dataJson = json_encode($param);
        $encodeTRIPLEDES = $this->encryptNew($dataJson, $this->VM_ENCRYPTION_KEY);
        $checksum = md5($fnc . $this->VM_MERCHANT_ID . $this->VM_USER_ID . $type . $encodeTRIPLEDES . $this->VM_CHECKSUM_KEY);
        $send = array(
            "fnc" => $fnc,
            "mid" => $this->VM_MERCHANT_ID,
            "uid" => $this->VM_USER_ID,
            "type" => $type,
            "data" => $encodeTRIPLEDES,
            "checksum" => $checksum,
        );
        $result = $this->web_call($send, $fnc);
        return $result;
    }

    function web_call($params, $fnc)
    {
        $this->web_WriteLog($fnc . date("Ymd", time()) . ".txt", " ================= START ======================= ");
        $this->web_WriteLog($fnc . date("Ymd", time()) . ".txt", "[INPUT]: " . json_encode($params));
        $this->web_WriteLog($fnc . date("Ymd", time()) . ".txt", " ================= END ======================= ");
        unset($params['order_code']);
        unset($params['amount']);
        $curl = curl_init($this->VM_URL_CHECKOUT);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        $response = curl_exec($curl);
        $resultStatus = curl_getinfo($curl);
        $this->web_WriteLog($fnc . date("Ymd", time()) . ".txt", " ================= START ======================= ");
        $this->web_WriteLog($fnc . date("Ymd", time()) . ".txt", "[OUTPUT_exec]: " . json_encode($response));
        $this->web_WriteLog($fnc . date("Ymd", time()) . ".txt", "[OUTPUT_getinfo]: " . json_encode($resultStatus));
        $this->web_WriteLog($fnc . date("Ymd", time()) . ".txt", " ================= END ======================= ");
        $data = json_decode($response, true);
        return $data;
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
//            chmod(storage_path("log/") . $fileName, 0777);
        }
    }
}
