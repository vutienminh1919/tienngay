<?php

namespace Modules\VPBank\Service;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

/**
* Endpoint: api.tienngay.vn
*/
class ApiTienNgay
{
    const CONTRACT_TYPE_TERM = 4;   // thanh toán kỳ api.tienngay transaction['type']
    const CONTRACT_TYPE_FINAL_SETTLEMENT = 3;   // tất toán api.tienngay transaction['type']
    const CONTRACT_TYPE_PAYMENT_TERM = 1;

    public static function getApiUrl($path) {

        if (env('APP_ENV') == 'dev') {
            return env('API_URL_STAGE') . '/' . $path;
        } elseif (env('APP_ENV') == 'product') {
            return env('API_URL_PROD') . '/' . $path;
        } else {
            return env('API_URL_LOCAL') . '/' . $path;
        }
    }

    /**
     * payment contract request to Api server.
     *
     * @param  Array  $data
     * @return Colection
     */
    public static function paymentTerm($data, $chanel = 'vpbank') {
        $url = self::getApiUrl('transaction/auto_payment_contract');
        $dataPost = array(
            "amount_total" => $data['total_amount'],
            "valid_amount" => $data['total_amount'],
            "penalty_pay" => $data['late_fee'],
            "total" => $data['paid_amount'],
            "valid_amount" => $data['total_amount'],
            "type_payment" => self::CONTRACT_TYPE_PAYMENT_TERM, // 1: thanh toán lãi kỳ, 2: gia hạn, 3: cơ cấu, 4: thanh toán hợp đồng đã thanh lý tài sản.
            "note" => $data['note'],
            "code_contract" => $data['contract_code'],
            "payment_method" => $data['epayment_code'],// 1:tiền mặt, 2: ck, 3: momoApp
            "type_pt" => self::CONTRACT_TYPE_TERM, //3 tat toan. 4 thanh toan ky lai. 5 gia han hop dong
            "date_pay" => $data['paid_date'],
            "created_by" => $data['created_by'],
            "code_transaction_bank" => $data['transactionId'],
            "bank" => "VPB",
            "discounted_fee" => $data['discounted_fee'],
            "total_deductible" => $data['total_deductible'],
            "id_exemption" => $data['id_exemption'] ? $data['id_exemption'] : ''
        );
        //call api
        Log::channel($chanel)->info('paymentTerm call-API :' . $url);
        Log::channel($chanel)->info('paymentTerm dataPost :' . print_r($dataPost, true));
        $result = Http::asForm()->post($url, $dataPost);
        Log::channel($chanel)->info('paymentTerm result :' . print_r($result->json(), true));
        return $result->json();
    }

    /**
     * payment final settlement contract request to Api server.
     *
     * @param  Array  $data
     * @return Colection
     */
    public static function paymentFinalSettlement($data, $chanel = 'vpbank') {
        $url = self::getApiUrl('transaction/auto_payment_contract');

        $dataPost = array(
            "amount_total" => $data['total_amount'],
            "valid_amount" => $data['total_amount'],
            "penalty_pay" => $data['late_fee'],
            "total" => $data['paid_amount'],
            "valid_amount" => $data['total_amount'],
            "type_payment" => self::CONTRACT_TYPE_PAYMENT_TERM, // 1: thanh toán lãi kỳ, 2: gia hạn, 3: cơ cấu, 4: thanh toán hợp đồng đã thanh lý tài sản.
            "note" => $data['note'],
            "code_contract" => $data['contract_code'],
            "payment_method" => $data['epayment_code'],// 1:tiền mặt, 2: ck, 3: momoApp
            "type_pt" => self::CONTRACT_TYPE_FINAL_SETTLEMENT, //3 tat toan. 4 thanh toan ky lai. 5 gia han hop dong
            "date_pay" => $data['paid_date'],
            "created_by" => $data['created_by'],
            "code_transaction_bank" => $data['transactionId'],
            "bank" => "VPB",
            "discounted_fee" => $data['discounted_fee'],
            "total_deductible" => $data['total_deductible'],
            "id_exemption" => $data['id_exemption'] ? $data['id_exemption'] : ''
        );
        // call api
        Log::channel($chanel)->info('paymentFinalSettlement call-API :' . $url);
        Log::channel($chanel)->info('paymentFinalSettlement dataPost :' . print_r($dataPost, true));
        $result = Http::asForm()->post($url, $dataPost);
        Log::channel($chanel)->info('paymentFinalSettlement result :' . print_r($result->json(), true));
        return $result->json();
    }

    /**
     * Get contract information from Api server.
     *
     * @param  string  $contractId
     * @return Colection
     */
    public static function getPaymentInfo($contractId, $datePay = null) {
        if (!$datePay) {
            $datePay = date('Y-m-d');
        }
        //refresh data before get payment amount
        self::refreshContractInfo($contractId);

        $url = self::getApiUrl('payment/get_payment_all_contract');

        $dataPost = array(
            'id' => $contractId,
            'date_pay' => $datePay,
            'amount_only' => 1,
        );
        //call api
        $detainPaymentData = Http::asForm()->post($url, $dataPost);
        return $detainPaymentData->json();
    }

    /**
     * Get contract information from Api server.
     *
     * @param  string  $contractId
     * @return Colection
     */
    public static function getPayment($codeContract, $datePay = null) {
        if (!$datePay) {
            $datePay = date('Y-m-d');
        }

        //refresh data before get payment amount
        self::refreshContractPaymentInfo($codeContract);

        $url = self::getApiUrl('payment/get_payment_all_contract');

        $dataPost = array(
            'amount_only' => 1,
            'code_contract' => $codeContract,
            'date_pay' => $datePay
        );
        //call api
        $detainPaymentData = Http::asForm()->post($url, $dataPost);
        return $detainPaymentData->json();
    }

    /**
     * Refresh contract's debt number to Api server.
     *
     * @param  string  $customerInfo
     * @return Colection
     */
    public static function refreshContractInfo($contractId) {
        $url = self::getApiUrl('payment/payment_all_contract');

        $dataPost = array(
            'id_contract' => $contractId,
        );
        //call api
        $response = Http::asForm()->post($url, $dataPost);
        return $response->json();
    }

    /**
     * send email approve.
     *
     * @param  Array  $data
     * @return Colection
     */
    public static function sendEmailApproveTransaction($data) {
        $url = self::getApiUrl('transaction/sendEmailApproveTransaction');

        $dataPost = array(
            "transactionId" => $data['transactionId'],
            "customer_name" => $data['customer_name'],
            "paidAmount" => $data['paidAmount'],
            "paidDate" => $data['paidDate'],
            "paymentMethod" => $data['paymentMethod'],
            "message" => $data['message'],
            "bank" => $data["bank"],
            "code_transaction_bank" => $data["code_transaction_bank"],
        );
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        return $result->json();
    }

    /**
     * Refresh contract's debt number to Api server.
     *
     * @param  string  $customerInfo
     * @return Colection
     */
    public static function refreshContractPaymentInfo($codeContract) {
        $url = self::getApiUrl('payment/payment_all_contract');

        $dataPost = array(
            'code_contract' => $codeContract,
        );
        //call api
        $response = Http::asForm()->post($url, $dataPost);
        return $response->json();
    }
}
