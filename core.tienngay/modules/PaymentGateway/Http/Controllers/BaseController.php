<?php

namespace Modules\PaymentGateway\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use gnupg;
use Crypt_GPG;

class BaseController extends Controller
{
    /**
    * host: api.tienngay.vn
    */
    protected function getApiUrl($path) {

        if (env('APP_ENV') == 'dev') {
            return env('API_URL_STAGE') . '/' . $path;
        } elseif (env('APP_ENV') == 'product') {
            return env('API_URL_PROD') . '/' . $path;
        } else {
            return env('API_URL_LOCAL') . '/' . $path;
        }
    }

    /**
    * host: appkh.tienngay.vn
    */
    protected function getAppKHUrl($path) {

        if (env('APP_ENV') == 'dev') {
            return env('APPKH_URL_STAGE') . '/' . $path;
        } elseif (env('APP_ENV') == 'product') {
            return env('APPKH_URL_PROD') . '/' . $path;
        } else {
            return env('APPKH_URL_LOCAL') . '/' . $path;
        }
    }

    /**
	* Encrypt data
	* @param Array $data
	* @return String $ciphertext
    */
    protected function encryptDataMoMo (array $data) {

        Log::channel('momo')->info('encrypt data: ' . print_r($data, true));
        // key created at 15/09/2021 and exprires after 8 years (15/09/2029)
        $privateKey = file_get_contents(__DIR__.'/../'. '/../'. '/tn-sec.asc');
        $publicKey  = file_get_contents(__DIR__.'/../'. '/../'. '/momo-pub.asc');
        $passphrase = file_get_contents(__DIR__.'/../'. '/../'. '/passphrase.asc');
        $dataText = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $gpg = new Crypt_GPG(array('homedir' => config('paymentgateway.homedir'), 'debug' => false));
        $publicKeyInfo = $gpg->importKey($publicKey);
        $fingerPrint = $publicKeyInfo['fingerprint'];
        $gpg->addEncryptKey($fingerPrint);
        $privateKeyInfo = $gpg->importKey($privateKey);
        $fingerPrint = $privateKeyInfo['fingerprint'];
        $gpg->addSignKey($fingerPrint, $passphrase);

        return $gpg->encryptAndSign($dataText);
    }

    /**
    * Encrypt data
    * @param Array $data
    * @return String $ciphertext
    */
    protected function decryptDataMomo ($dataText) {
        Log::channel('momo')->info('decrypt data: ' . print_r($dataText, true));
        // key created at 15/09/2021 and exprires after 8 years (15/09/2029)
        $privateKey = file_get_contents(__DIR__.'/../'. '/../'. '/tn-sec.asc');
        $publicKey  = file_get_contents(__DIR__.'/../'. '/../'. '/momo-pub.asc');
        $passphrase = file_get_contents(__DIR__.'/../'. '/../'. '/passphrase.asc');

        $gpg = new Crypt_GPG(array('homedir' => config('paymentgateway.homedir'), 'debug' => false));
        $privateKeyInfo = $gpg->importKey($privateKey);
        $fingerPrint = $privateKeyInfo['fingerprint'];
        $gpg->addDecryptKey($fingerPrint, $passphrase);
        $publicKeyInfo = $gpg->importKey($publicKey);
        $fingerPrint = $publicKeyInfo['fingerprint'];
        $gpg->addSignKey($fingerPrint);

        return $gpg->decryptAndVerify($dataText);
    }

    /**
    * padding id
    * @param int $id
    * @return String
    */
    protected function getTNTransactionId($id) {
        return str_pad($id, 10, "0", STR_PAD_LEFT);
    }

    /**
    * Call MoMo crypto service to encrypt data
    * @param String $data
    * @return String $ciphertext
    */
    protected function momoEncrypt (String $data) {

        // $encrypt = Http::withHeaders([
        //     'Content-Type' => 'text/plain',
        // ])
        // ->withBody(
        //     $data, 'text'
        // )->post(env('MOMO_CRYPTO_SERVICE').'/momo/encode');
        // Log::channel('momo')->info('momoInitPaymentApi encryptData: ' . print_r($encrypt->body(), true));

        // return $encrypt->body();

        $privateKey = file_get_contents(__DIR__.'/../'. '/../'. '/tn-sec.asc');
        $publicKey  = file_get_contents(__DIR__.'/../'. '/../'. '/momo-pub.asc');
        $passphrase = file_get_contents(__DIR__.'/../'. '/../'. '/passphrase.asc');
        //$dataText = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $gpg = new Crypt_GPG(array('homedir' => config('paymentgateway.homedir'), 'debug' => false));
        $publicKeyInfo = $gpg->importKey($publicKey);
        $fingerPrint = $publicKeyInfo['fingerprint'];
        $gpg->addEncryptKey($fingerPrint);
        $privateKeyInfo = $gpg->importKey($privateKey);
        $fingerPrint = $privateKeyInfo['fingerprint'];
        $gpg->addSignKey($fingerPrint, $passphrase);

        return $gpg->encryptAndSign($data);
    }

    /**
    * Call MoMo crypto service to decrypt data
    * @param String $data
    * @return String $ciphertext
    */
    protected function momoDecrypt (String $data) {
        // $decrypt = Http::withHeaders([
        //     'Content-Type' => 'text/plain',
        // ])
        // ->withBody(
        //     $data, 'text'
        // )->post(env('MOMO_CRYPTO_SERVICE').'/momo/decode');

        // Log::channel('momo')->info('decrypted data: ' . print_r($decrypt->body(), true));
        // return $decrypt->body();

        $privateKey = file_get_contents(__DIR__.'/../'. '/../'. '/tn-sec.asc');
        $publicKey  = file_get_contents(__DIR__.'/../'. '/../'. '/momo-pub.asc');
        $passphrase = file_get_contents(__DIR__.'/../'. '/../'. '/passphrase.asc');

        $gpg = new Crypt_GPG(array('homedir' => config('paymentgateway.homedir'), 'debug' => false));
        $privateKeyInfo = $gpg->importKey($privateKey);
        $fingerPrint = $privateKeyInfo['fingerprint'];
        $gpg->addDecryptKey($fingerPrint, $passphrase);
        $publicKeyInfo = $gpg->importKey($publicKey);
        $fingerPrint = $publicKeyInfo['fingerprint'];
        $gpg->addSignKey($fingerPrint);

        return $gpg->decryptAndVerify($data);
    }

    /**
     * Get contract information from Api server.
     *
     * @param  string  $contractId
     * @return Colection
     */
    protected function callApiGetPaymentInfo($contractId) {
        $url = $this->getApiUrl('payment/get_payment_all_contract');

        $dataPost = array(
            'id' => $contractId,
        );
        //call api
        Log::channel('momo')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));

        $detainPaymentData = Http::asForm()->post($url, $dataPost);

        Log::channel('momo')->info('Result Api: ' . $url . ' ' . print_r($detainPaymentData->json(), true));
        return $detainPaymentData;
    }


    protected function checkLegalFinalSettlementAmount($contractId, $amount) {
        $detainPaymentData = $this->callApiGetPaymentInfo($contractId);
        if ($detainPaymentData["status"] != Response::HTTP_OK) {
            return false;
        }
        
        if (
            !empty($detainPaymentData["contractDB"]["status"]) 
            && $detainPaymentData["contractDB"]["status"] == config('paymentgateway.CONTRACT_COMPLETED')
        ) {
            Log::channel('momo')->info('contract status: ' . print_r($detainPaymentData["contractDB"]["status"], true));
            Log::channel('momo')->info('Hợp đồng đã được tất toán');
            return false;
        }
        Log::channel('momo')->info('FinalSettlementAmount: ' . print_r($detainPaymentData["tong_tien_tat_toan"], true));
        if ($amount < round($detainPaymentData["tong_tien_tat_toan"])) {
            return false;
        }
        return true;
    }

    /**
     * Get contract list from Api server.
     *
     * @param  string  $contractId
     * @return response $response
     */
    protected function callApiRefreshContractInfo($contractId) {
        $url = $this->getApiUrl('payment/payment_all_contract');

        $dataPost = array(
            'id_contract' => $contractId,
        );
        //call api
        Log::channel('momo')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));

        $response = Http::asForm()->post($url, $dataPost);

        Log::channel('momo')->info('Result Api: ' . $url . ' ' . print_r($response->json(), true));
        return $response;
    }

    /**
     * check totalAmount is valid ?
     *
     * @param  string  $contractId
     * @param  number  $amount
     * @return boolean
     */
    protected function greaterThanFinalSettlementAmount($contractId, $amount) {
        $detainPaymentData = $this->callApiGetPaymentInfo($contractId);
        if ($detainPaymentData["status"] != Response::HTTP_OK) {
            Log::channel('momo')->info('greaterThanFinalSettlementAmount is false');
            return false;
        }
        if ($amount >= $detainPaymentData["tong_tien_tat_toan"]) {
            Log::channel('momo')->info('greaterThanFinalSettlementAmount is true');
            return true;
        }
        Log::channel('momo')->info('greaterThanFinalSettlementAmount is false');
        return false;
    }

}
