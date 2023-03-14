<?php

namespace Modules\PaymentGateway\Http\Controllers;

use Modules\PaymentGateway\Http\Controllers\BaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Modules\MysqlCore\Repositories\Interfaces\MoMoAppRepositoryInterface;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\MysqlCore\Entities\MoMoApp;
use Modules\MongodbCore\Repositories\Interfaces\ContractRepositoryInterface;
use gnupg;
use Crypt_GPG;

class MoMoAppKHController extends BaseController
{

    /**
     * @OA\Info(
     *     version="1.0",
     *     title="API Momo Payment on appKH"
     * )
     */
    private $momoAppRepository;

    private $contractRepository;

    public function __construct(MoMoAppRepositoryInterface $momoAppRepository, ContractRepositoryInterface $contractRepository) {
       $this->momoAppRepository = $momoAppRepository;
       $this->contractRepository = $contractRepository;
    }

    /**
    * Call Momo init payment api
    * @param Array $data
    * @return $response
    */
    protected function momoInitPaymentApi($data) {
        $dataPost = [
            "requestId"                 => $data["requestId"],
            "reference1"                => $data["reference1"],
            "reference2"                => $data["reference2"],
            "client"                    => $data["client"],
            "callbackUrl"               => $data["callbackUrl"],
            "notifyUrl"                 => $data["notifyUrl"],
            "description"               => $data["description"],
            "totalAmount"               => (int)$data["totalAmount"],
            "checksumKey"               => $data["checksumKey"],
            "accountInfo"               => [
                "name"          => $data["accountInfo"]["name"]
            ],
            "extras"                    => new \stdClass()
        ];
        $dataPost["billList"] = [];
        Log::channel('momo')->info('MOMO_PARTNER_CODE: ' . env('MOMO_PARTNER_CODE'));
        foreach ($data["billList"] as $value) {
            $bill = [
                "billId"      => $value["billId"],
                "totalAmount" => (int)$value["totalAmount"],
                "description" => $value["description"],
                "extras"      => new \stdClass()
            ];
            $dataPost["billList"][] = $bill;
        }
        $rawData = json_encode($dataPost, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        Log::channel('momo')->info('momoInitPaymentApi rawData: ' . print_r($rawData, true));
        $encryptData = $this->momoEncrypt($rawData);
        Log::channel('momo')->info('momoInitPaymentApi encryptData: ' . print_r($encryptData, true));
        $response = Http::withHeaders([
            'Accept' => 'application/pgp-encrypted',
            'Content-Type' => 'application/pgp-encrypted',
            'partner-code' => env('MOMO_PARTNER_CODE')
        ])
        ->withBody(
            $encryptData, 'raw'
        )->post(env('MOMO_INIT_PAYMENT') . '/api/gw_payment/init');
        Log::channel('momo')->info('API URL: ' . env('MOMO_INIT_PAYMENT') . '/api/gw_payment/init');
        Log::channel('momo')->info('momoInitPaymentApi response: ' . print_r($response->body(), true));

        $decryptData = $this->momoDecrypt($response->body());

        Log::channel('momo')->info('payment response: ' . print_r($decryptData, true));

        $plainData = json_decode($decryptData["data"], true);
        if (isset($plainData["resultCode"]) 
            && $plainData["resultCode"] === config('paymentgateway.momoAppkhResultCode.SUCCESS')
        ) {
            $plainData["status"] = Response::HTTP_OK;
        } else {
            $plainData["status"] = Response::HTTP_BAD_REQUEST;
        }

        if (
            isset($plainData["resultCode"])
            && !empty(config('paymentgateway.momoResultCodeMessage.'.$plainData["resultCode"]))
        ) {
            $plainData["message"] = config('paymentgateway.momoResultCodeMessage.'.$plainData["resultCode"]);
        } else {
            $plainData["message"] = __('PaymentGateway::messages.momo_unknow');
        }
        $plainData["transactionId"] = $data["reference1"];
        Log::channel('momo')->info('payment response: ' . print_r($plainData, true));
        return $plainData;
    }

    /**
    * Create transaction and call momo init payment api
    * @param Illuminate\Http\Request $request
    * @return $response
    */
    public function initPayment(Request $request) {
        $data = $request->all();
        $billInfo = $this->createBill($data);
        if($billInfo['status'] == Response::HTTP_OK && !empty($billInfo['billInfo'])) {
            $momoResponse = $this->momoInitPaymentApi($billInfo['billInfo']);
            $response = [];
            $response["requestId"] = isset($momoResponse["requestId"]) ? $momoResponse["requestId"] : "";
            $response["referenceId"] = isset($momoResponse["referenceId"]) ? $momoResponse["referenceId"] : "";
            $response["resultCode"] = isset($momoResponse["resultCode"]) ? $momoResponse["resultCode"] : "";
            $response["message"] = isset($momoResponse["message"]) ? $momoResponse["message"] : "";
            $response["data"] = isset($momoResponse["data"]) ? $momoResponse["data"] : [];
            $response["status"] = isset($momoResponse["status"]) ? $momoResponse["status"] : "";
            $response["transactionId"] = isset($momoResponse["transactionId"]) ? $momoResponse["transactionId"] : "";
            return Response()->json($response);
        }

        $response = [];
        $response["requestId"] = "";
        $response["referenceId"] = "";
        $response["resultCode"] = "";
        $response["message"] = isset($billInfo["message"]) ? $billInfo["message"] : "";
        $response["data"] = [];
        $response["status"] = isset($billInfo["status"]) ? $billInfo["status"] : "";
        $response["transactionId"] = isset($billInfo['billInfo']["transactionId"]) ? $billInfo['billInfo']["transactionId"] : "";
        return Response()->json($response);
    }

    /**
    * Momo sends the payment results
    * @param Illuminate\Http\Request $request
    * @return $response
    */
    public function callback(Request $request) {
        $requestData = $request->input("data");
        Log::channel('momo')->info('callback data : ' . print_r($requestData, true));
        if(!$requestData) {
            return view('paymentgateway::appkh.callback-failed');
        }
        
        $decodeRequest = json_decode(base64_decode($requestData), true);
        Log::channel('momo')->info('decode request : ' . print_r($decodeRequest, true));
        $requestId = isset($decodeRequest["requestId"]) ? $decodeRequest["requestId"] : "";
        $reference1 = isset($decodeRequest["reference1"]) ? $decodeRequest["reference1"] : "";
        $reference2 = isset($decodeRequest["reference2"]) ? $decodeRequest["reference2"] : "";
        $resultCode = isset($decodeRequest["resultCode"]) ? $decodeRequest["resultCode"] : "";
        $paymentId = isset($decodeRequest["paymentId"]) ? $decodeRequest["paymentId"] : "";
        $amount = isset($decodeRequest["amount"]) ? $decodeRequest["amount"] : "";
        $creditAmount = isset($decodeRequest["creditAmount"]) ? $decodeRequest["creditAmount"] : "";
        $encryptedData = isset($decodeRequest["encryptedData"]) ? $decodeRequest["encryptedData"] : "";
        $uriIos = null;
        if ($reference2 == MoMoApp::CLIENT_CODE_IOS_APPKH) {
            $uriIos = config('paymentgateway.ios_uri');
        }

        $transaction = $this->momoAppRepository->find($reference1);
        if(!$transaction) {
            if ($resultCode == config('paymentgateway.momoAppkhResultCode.SUCCESS')) {
                return view('paymentgateway::appkh.callback-success', ["uriIos" => $uriIos]);
            } else {
                return view('paymentgateway::appkh.callback-failed', ["uriIos" => $uriIos]);
            }
        }
        $checksumKey = $transaction["checkSumKey"];
        Log::channel('momo')->info('checkSumKey : ' . print_r($transaction["checkSumKey"], true));
        $strData = $requestId.
            $reference1.
            $reference2.
            $resultCode.
            $paymentId.
            $amount.
            $creditAmount.
            $checksumKey;
        Log::channel('momo')->info('strData : ' . print_r($strData, true));
        $hash256 = hash('sha256', $strData);
        Log::channel('momo')->info('hash256 : ' . print_r($hash256, true));

        //check sum data
        if (
            strtoupper($hash256) === strtoupper($encryptedData) 
            && $resultCode == config('paymentgateway.momoAppkhResultCode.SUCCESS')
        ) {
            Log::channel('momo')->info('Checksum is valid!');
        } else {
            Log::channel('momo')->warning('Checksum is invalid!');
        }

        if ($resultCode == config('paymentgateway.momoAppkhResultCode.SUCCESS')) {
            return view('paymentgateway::appkh.callback-success', ["transaction" => $transaction, "uriIos" => $uriIos]);
        } else {
            return view('paymentgateway::appkh.callback-failed', ["transaction" => $transaction, "uriIos" => $uriIos]);
        }
    }

    /**
    * Momo sends the payment notify
    * @param Illuminate\Http\Request $request
    * @return $response
    */
    public function notify(Request $request) {
        Log::channel('momo')->info('notify requested!');
        $encryptData = $request->getContent();
        Log::channel('momo')->info('notify encrypt data : ' . print_r($encryptData, true));
        $decryptData = $this->momoDecrypt($encryptData);
        Log::channel('momo')->info('notify decrypt data: ' . print_r($decryptData, true));
        $requestData = json_decode($decryptData["data"], true);
        $requestId = isset($requestData['requestId']) ? $requestData['requestId']:"";
        $transactionId = isset($requestData['reference1']) ? $requestData['reference1']:""; // Tien ngay transaction id
        $transactionDate = isset($requestData['paymentDate']) ? $requestData['paymentDate']:"";
        $momoTransactionId = isset($requestData['paymentId']) ? $requestData['paymentId']:"";
        $totalAmount = isset($requestData['totalAmount']) ? $requestData['totalAmount']:0;
        if (isset($requestData["resultCode"]) 
            && $requestData["resultCode"] !== config('paymentgateway.momoAppkhResultCode.SUCCESS')
        ) {
            $response = [
                'requestId' => $requestId,
                'transactionId' => $transactionId,
                'resultCode' => $requestData["resultCode"],
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Error",
            ];
            Log::channel('momo')->info('momo notify payment -> response: ' . print_r($response, true));
            if (config('paymentgateway.momoCrypto')) {
                $response = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                return $this->momoEncrypt($response);
            } else {
                return response()->json($response);
            }
        }
        $date = new DateTime($transactionDate);

        $transaction = $this->momoAppRepository->find($transactionId);
        if(!$transaction) {
            $response = [
                'requestId' => $requestId,
                'transactionId' => $transactionId,
                'resultCode' => config('paymentgateway.momoAppkhResultCode.TRANSACTION_NOT_FOUND'),
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Error",
            ];
            Log::channel('momo')->info('momo notify payment -> response: ' . print_r($response, true));
            if (config('paymentgateway.momoCrypto')) {
                $response = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                return $this->momoEncrypt($response);
            } else {
                return response()->json($response);
            }
        }
        Log::channel('momo')->info('begin update transaction : ' . print_r($transaction, true));
        $attributes = [];
        $attributes['requestId'] = $requestId;
        $attributes['transactionId'] = (int) $momoTransactionId; // MoMo transaction id
        $attributes['amount'] = $totalAmount;
        $attributes['date'] = $date->format('Y-m-d H:i:s');
        $attributes['transaction_fee'] = $this->transactionFee($totalAmount);
        // update transaction
        $update = $this->momoAppRepository->update($attributes, $transactionId);


        if (
            $update && (
            $update["payment_option"] == config('paymentgateway.PAYMENT_TERM') ||
            $update["payment_option"] == config('paymentgateway.FINAL_SETTLEMENT')
            )
        ) {
            if ($update["payment_option"] == config('paymentgateway.PAYMENT_TERM')) {
                $resultCallPaymentApi = $this->callApiPaymentContract($update);
            } else {
                $resultCallPaymentApi = $this->callApiPaymentFinalSettlement($update);
            }
            $this->callApiRefreshContractInfo($update["contract_id"]);
            Log::channel('momo')->info('api.tienngay create transaction_id: ' . print_r($resultCallPaymentApi->json(), true));
            if(!empty($resultCallPaymentApi) && $resultCallPaymentApi['status'] == Response::HTTP_OK) {

                $resultApi['contract_transaction_id'] = $resultCallPaymentApi['transaction_id']['$oid'];
                $resultApi['contract_status'] = config('paymentgateway.CONTRACT_STATUS_SUCCESS');
                // update contract_transaction_id;
                $update = $this->momoAppRepository->updateContractTransactionId($resultApi, $transactionId);
            } else {

                // gạch nợ thất bại
                $resultApi['contract_transaction_id'] = !empty($resultCallPaymentApi['transaction_id']) ? $resultCallPaymentApi['transaction_id']['$oid'] : "";
                if (empty($resultCallPaymentApi['transaction_id'])) {
                    $resultApi['contract_status'] = config('paymentgateway.CONTRACT_STATUS_FAILED');
                } else {
                    // Trạng thái chờ duyệt
                    $resultApi['contract_status'] = config('paymentgateway.CONTRACT_STATUS_PENDING');
                }
                
                $update = $this->momoAppRepository->updateContractTransactionId($resultApi, $transactionId);
            }

            if ($update["payment_option"] == config('paymentgateway.PAYMENT_TERM')) {
                $message = __('PaymentGateway::messages.payment_term_success');
            } else {
                $message = __('PaymentGateway::messages.payment_final_settlement_success');
            }
            $this->callApiPushNotifyApp($transactionId);
            $response = [
                'requestId' => $requestId,
                'referenceId' => $transactionId,
                'resultCode' => config('paymentgateway.momoAppkhResultCode.SUCCESS'),
                'message' => $message,
            ];
            Log::channel('momo')->info('momo notify payment -> response: ' . print_r($response, true));
            if (config('paymentgateway.momoCrypto')) {
                $response = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                return $this->momoEncrypt($response);
            } else {
                return response()->json($response);
            }
        } else {
            $response = [
                'requestId' => $requestId,
                'transactionId' => $transactionId,
                'resultCode' => config('paymentgateway.momoAppkhResultCode.TRANSACTION_NOT_FOUND'),
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Error",
            ];
            Log::channel('momo')->info('momo notify payment -> response: ' . print_r($response, true));
            if (config('paymentgateway.momoCrypto')) {
                $response = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                return $this->momoEncrypt($response);
            } else {
                return response()->json($response);
            }
        }
    }

    /**
    * Create MoMo bill and save transaction info
    * @param Array $data
    * @param String $clientCode
    * @return Array $results
    */
    protected function createBill($data) {
        Log::channel('momo')->info('createBill start!');
        Log::channel('momo')->info('data : ' . print_r($data, true));
        $validator = Validator::make($data, [
            'id'             => 'required|string|max:50',
            'totalAmount'    => 'required|numeric',
            'payment_option' => 'required|in:'.MoMoApp::PAYMENT_OPTION_TERM.','
                                              .MoMoApp::PAYMENT_OPTION_FINAL.',',
            'client_code'    => 'required|in:'.MoMoApp::CLIENT_CODE_IOS_APPKH.','
                                              .MoMoApp::CLIENT_CODE_ANDROID_APPKH.','
                                              .MoMoApp::CLIENT_CODE_WEB_APPKH,
        ]);
        if ($validator->fails()) {
            Log::channel('momo')->info('validate error: ' . print_r($validator->errors(), true));
            $results = [
                'billInfo' => [],
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
            ];
            Log::channel('momo')->info('createBill : ' . print_r($results, true));
            return $results;
        }

        $contract = $this->contractRepository->find($data["id"]);
        Log::channel('momo')->info('createBill contractInfo: ' . print_r($contract, true));
        if (!$contract) {
            $results = [
                'billInfo' => [],
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('PaymentGateway::messages.illegal_final_settlement_amount'),
            ];
            Log::channel('momo')->info('createBill : ' . print_r($results, true));
            return $results;
        }

        if(
            $data['payment_option'] == MoMoApp::PAYMENT_OPTION_FINAL 
            && !$this->checkLegalFinalSettlementAmount($data['id'], $data["totalAmount"])
        ) {
            $results = [
                'billInfo' => [],
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('PaymentGateway::messages.illegal_final_settlement_amount'),
            ];
            Log::channel('momo')->info('createBill : ' . print_r($results, true));
            return $results;
        }

        if($data['payment_option'] == MoMoApp::PAYMENT_OPTION_TERM && (
            $this->greaterThanFinalSettlementAmount($data['id'], $data["totalAmount"])
            ||
            $contract["isLastTerm"]
        )) {
            $results = [
                'billInfo' => [],
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('PaymentGateway::messages.should_be_use_final_settlement_payment_method'),
            ];
            Log::channel('momo')->info('createBill : ' . print_r($results, true));
            return $results;
        }

        $clientCode = $data['client_code'];
        $requestId = md5(uniqid(rand(), true));
        $dataSave = [];
        $dataSave[MoMoApp::REQUEST_CHECK_BILL] = $requestId;
        $dataSave[MoMoApp::CONTRACT_ID] = $data['id'];
        $dataSave[MoMoApp::CONTRACT_CODE] = $contract["code_contract"];
        $dataSave[MoMoApp::CONTRACT_CODE_DISBURSEMENT] = $contract["code_contract_disbursement"];
        $dataSave[MoMoApp::CONTRACT_STORE_ID] = $contract["store"]["id"];
        $dataSave[MoMoApp::CONTRACT_STORE_NAME] = $contract["store"]["name"];
        $dataSave[MoMoApp::PAYMENT_OPTION] = $data['payment_option'];
        $dataSave[MoMoApp::TOTAL_AMOUNT] = $data["totalAmount"];
        $dataSave[MoMoApp::NAME] = $contract["customer_infor"]["customer_name"];
        $dataSave[MoMoApp::EMAIL] = $contract["customer_infor"]["customer_email"];
        $dataSave[MoMoApp::MOBILE] = $contract["customer_infor"]["customer_phone_number"];
        $dataSave[MoMoApp::IDENTITY_CARD] = $contract["customer_infor"]["customer_identify"];
        $dataSave[MoMoApp::CHECK_SUM_KEY] = md5(rand());
        $dataSave[MoMoApp::CLIENT_CODE] = $clientCode;

        Log::channel('momo')->info('create transaction : ' . print_r($dataSave, true));
        // Save Data
        $transactionSaved = $this->momoAppRepository->store($dataSave);
        if (!$transactionSaved) {
            $results = [
                'billInfo' => [],
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => __('PaymentGateway::messages.create_bill_failed'),
            ];
            Log::channel('momo')->info('createBill : ' . print_r($results, true));
            return $results;
        }
        if ($data['payment_option'] == MoMoApp::PAYMENT_OPTION_TERM) {
            $description = __('PaymentGateway::messages.payment_term');
        } else {
            $description = __('PaymentGateway::messages.payment_final_settlement');
        }
        $billInfo = [
            "requestId"                 => $requestId,
            "reference1"                => $this->getTNTransactionId($transactionSaved->id),
            "reference2"                => $clientCode,
            "callbackUrl"               => env('APPKH_DOMAIN').'MoMoAppKH/callback',
            "notifyUrl"                 => env('PW_BASE_URL').'/paymentgateway/momo/appKH/notify',
            "description"               => $description,
            "totalAmount"               => $transactionSaved->total_amount,
            "checksumKey"               => $transactionSaved->checkSumKey,
            "accountInfo"               => [
                "name"          => $transactionSaved->name
            ],
            "extras"                    => []
        ];
        $billInfo["billList"] = [];
        $bill = [
            "billId"      => $this->getTNTransactionId($transactionSaved->id),
            "totalAmount" => $transactionSaved->total_amount,
            "description" => $description,
            "extras"      => []
        ];
        $billInfo["billList"][] = $bill;
        switch ($clientCode) {
            case MoMoApp::CLIENT_CODE_ANDROID_APPKH:
                $billInfo["client"] = config('paymentgateway.MOMO_CLIENT_CODE.ANDROID');
                break;
            case MoMoApp::CLIENT_CODE_IOS_APPKH:
                $billInfo["client"] = config('paymentgateway.MOMO_CLIENT_CODE.IOS');
                break;
            case MoMoApp::CLIENT_CODE_WEB_APPKH:
                $billInfo["client"] = config('paymentgateway.MOMO_CLIENT_CODE.WEB');
                break;
            default:
                $billInfo["client"] = "";
                break;
        }
        $results = [
            'billInfo' => $billInfo,
            'status' => Response::HTTP_OK,
            'message' => __('PaymentGateway::messages.create_bill_success'),
        ];
        Log::channel('momo')->info('createBill : ' . print_r($results, true));
        return $results;
    }

    // Calculate momo fee 0.6% + 12000
    protected function transactionFee($paidAmount) {
        if (is_numeric($paidAmount) && $paidAmount > 0) {
            return ($paidAmount*0.006 + 12000);
        }
        return 0;
    }

    /**
     * payment contract request to Api server.
     *
     * @param  Array  $data
     * @return Colection
     */
    protected function callApiPaymentContract($data) {
        $url = $this->getApiUrl('transaction/auto_payment_contract');
        $note = "MoMoApp - Thanh toán lãi kỳ";
        if($data["client_code"] == MoMoApp::CLIENT_CODE_IOS_APPKH) {
            $note = "IOS_APPKH - Thanh toán lãi kỳ";
        } else if($data["client_code"] == MoMoApp::CLIENT_CODE_ANDROID_APPKH) {
            $note = "ANDROID_APPKH - Thanh toán lãi kỳ";
        } else if($data["client_code"] == MoMoApp::CLIENT_CODE_WEB_APPKH) {
            $note = "WEB_APPKH - Thanh toán lãi kỳ";
        }
        $dataPost = array(
            "amount_total" => $data['total_amount'],
            "valid_amount" => $data['total_amount'],
            "penalty_pay" => $data['late_fee'],
            "total" => $data['paid_amount'],
            "valid_amount" => $data['total_amount'],
            "type_payment" => config('paymentgateway.CONTRACT_TYPE_PAYMENT_TERM'), // 1: thanh toán lãi kỳ, 2: gia hạn, 3: cơ cấu, 4: thanh toán hợp đồng đã thanh lý tài sản.
            "note" => $note,
            "code_contract" => $data['contract_code'],
            "payment_method" => $data['epayment_code'],// 1:tiền mặt, 2: ck, 3: momoApp
            "type_pt" => config('paymentgateway.CONTRACT_TYPE_TERM'), //3 tat toan. 4 thanh toan ky lai. 5 gia han hop dong
            "date_pay" => $data['paid_date'],
            "created_by" => "MoMo",
            "code_transaction_bank" => $data['transactionId'],
        );
        Log::channel('momo')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::channel('momo')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return $result;
    }

    /**
     * payment final settlement contract request to Api server.
     *
     * @param  Array  $data
     * @return Colection
     */
    protected function callApiPaymentFinalSettlement($data) {
        $url = $this->getApiUrl('transaction/auto_payment_contract');
        $note = "MoMoApp - Tất toán HĐ";
        if($data["client_code"] == MoMoApp::CLIENT_CODE_IOS_APPKH) {
            $note = "IOS_APPKH - Tất toán HĐ";
        } else if($data["client_code"] == MoMoApp::CLIENT_CODE_ANDROID_APPKH) {
            $note = "ANDROID_APPKH - Tất toán HĐ";
        } else if($data["client_code"] == MoMoApp::CLIENT_CODE_WEB_APPKH) {
            $note = "WEB_APPKH - Tất toán HĐ";
        }
        $dataPost = array(
            "amount_total" => $data['total_amount'],
            "valid_amount" => $data['total_amount'],
            "penalty_pay" => $data['late_fee'],
            "total" => $data['paid_amount'],
            "valid_amount" => $data['total_amount'],
            "type_payment" => config('paymentgateway.CONTRACT_TYPE_PAYMENT_TERM'), // 1: thanh toán lãi kỳ, 2: gia hạn, 3: cơ cấu, 4: thanh toán hợp đồng đã thanh lý tài sản.
            "note" => $note,
            "code_contract" => $data['contract_code'],
            "payment_method" => $data['epayment_code'],// 1:tiền mặt, 2: ck, 3: momoApp
            "type_pt" => config('paymentgateway.CONTRACT_TYPE_FINAL_SETTLEMENT'), //3 tat toan. 4 thanh toan ky lai. 5 gia han hop dong
            "date_pay" => $data['paid_date'],
            "created_by" => "MoMo",
            "code_transaction_bank" => $data['transactionId'],
        );
        Log::channel('momo')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::channel('momo')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return $result;
    }

    /**
     * Get MoMo Transaction info
     * Use this api to get momo transaction's information
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/paymentgateway/momo/appKH/transactionInfo",
     *     tags={"paymentgateway"},
     *     operationId="search",
     *     summary="get Transaction info",
     *     description="Use this api to get MoMo transaction's information ",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/xml",
     *              @OA\Schema(
     *                  @OA\Property(property="transactionId",type="integer"),
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get data successfully",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="get data failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function transactionInfo(Request $request) {
        $requestData = $request->all();
        Log::channel('momo')->info('transactionInfo requested: ' . print_r($requestData, true));
        if (empty($requestData["transactionId"])) {  
        Log::channel('momo')->info('transactionInfo transactionId is empty');
            $response = [
                'transactionId' => '',
                'data'          => [],
                'status'        => Response::HTTP_NOT_FOUND,
                'message'       => __('PaymentGateway::messages.transaction_not_found')
            ];
            return response()->json($response);
        }
        $transactionId = $requestData["transactionId"];
        //call api
        $result = $this->momoAppRepository->find($transactionId);

        if (!$result) {
            Log::channel('momo')->info('transactionInfo TransactionId : ' .$requestData["transactionId"]. ' does not exist!');
            $response = [
                'transactionId' => $transactionId,
                'data'          => [],
                'status'        => Response::HTTP_NOT_FOUND,
                'message'       => __('PaymentGateway::messages.transaction_not_found')
            ];
            return response()->json($response);
        }

        //create response
        $response = [
            'transactionId' => $transactionId,
            'data'          => $result->toArray(),
            'status'        => Response::HTTP_OK,
            'message'       => __('PaymentGateway::messages.get_data_success')
        ];

        Log::channel('momo')->info('transactionInfo response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * Call Api to push notification to app
     *
     * @param  string  $transactionId
     * @return Response
     */
    protected function callApiPushNotifyApp($transactionId) {
        $transaction = $this->momoAppRepository->find($transactionId);
        
        $url = $this->getAppKHUrl('transaction/pushNotifyApp');

        if ($transaction["payment_option"] == MoMoApp::PAYMENT_OPTION_TERM) {
            $type = config('paymentgateway.CONTRACT_TYPE_TERM');
        } else {
            $type = config('paymentgateway.CONTRACT_TYPE_FINAL_SETTLEMENT');
        }
        $dataPost = array(
            'code_contract' => $transaction["contract_code"],
            'amount' => $transaction["paid_amount"],
            'type_payment' => $type,
            'order_code' => $transaction["contract_transaction_id"],
        );
        //call api
        Log::channel('momo')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));

        $response = Http::asForm()->post($url, $dataPost);

        Log::channel('momo')->info('Result Api: ' . $url . ' ' . print_r($response->json(), true));
        return $response;
    }
}
