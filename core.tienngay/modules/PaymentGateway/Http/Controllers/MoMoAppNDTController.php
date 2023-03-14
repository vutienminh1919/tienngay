<?php

namespace Modules\PaymentGateway\Http\Controllers;

use Modules\PaymentGateway\Http\Controllers\MoMoAppKHController as BaseController;
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

class MoMoAppNDTController extends BaseController
{

    /**
     * @OA\Info(
     *     version="1.0",
     *     title="API Momo Payment on appNDT"
     * )
     */
    private $momoAppRepository;

    private $contractRepository;

    public function __construct(MoMoAppRepositoryInterface $momoAppRepository, ContractRepositoryInterface $contractRepository) {
       $this->momoAppRepository = $momoAppRepository;
       $this->contractRepository = $contractRepository;
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
        $requestData = json_decode($decryptData, true);

        $requestId = isset($requestData['requestId']) ? $requestData['requestId']:"";
        $transactionId = isset($requestData['reference1']) ? $requestData['reference1']:""; // Tien ngay transaction id
        $investorId = isset($requestData['reference2']) ? $requestData['reference2']:"";
        $transactionDate = isset($requestData['paymentDate']) ? $requestData['paymentDate']:"";
        $momoTransactionId = isset($requestData['paymentId']) ? $requestData['paymentId']:"";
        $totalAmount = isset($requestData['totalAmount']) ? $requestData['totalAmount']:0;
        $date = new DateTime($transactionDate);

        $transaction = $this->momoAppRepository->find($transactionId);
        $this->paymentNotify(
            $transaction["notifyUrl"], 
            array_merge(
                $requestData, 
                [
                    "contract_id" => $transaction["contract_id"], 
                    "investor_id" => $investorId
                ]
            )
        );
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


        if ($update) {
            $response = [
                'requestId' => $requestId,
                'referenceId' => $transactionId,
                'resultCode' => config('paymentgateway.momoAppkhResultCode.SUCCESS'),
                'message' => "Success",
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
            'payment_option' => 'required|in:'.MoMoApp::PAYMENT_OPTION_INVESTOR,
            'client_code'    => 'required|in:'.MoMoApp::CLIENT_CODE_IOS_APPKH.','
                                              .MoMoApp::CLIENT_CODE_ANDROID_APPKH.','
                                              .MoMoApp::CLIENT_CODE_WEB_APPKH,
            'code_contract_disbursement'            => 'required|string|max:50',
            'name'                                  => 'required|string|max:50',
            'phone_number'                          => 'required|string|max:11',
            'notifyUrl'                             => 'required|string',
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

        $clientCode = $data['client_code'];
        $requestId = md5(uniqid(rand(), true));
        $dataSave = [];
        $dataSave[MoMoApp::REQUEST_CHECK_BILL] = $requestId;
        $dataSave[MoMoApp::CONTRACT_ID] = $data['id'];
        $dataSave[MoMoApp::CONTRACT_CODE_DISBURSEMENT] = $data["code_contract_disbursement"];
        $dataSave[MoMoApp::PAYMENT_OPTION] = $data['payment_option'];
        $dataSave[MoMoApp::TOTAL_AMOUNT] = $data["totalAmount"];
        $dataSave[MoMoApp::NAME] = $data["name"];
        $dataSave[MoMoApp::EMAIL] = !empty($data["email"]) ? $data["email"] : "";
        $dataSave[MoMoApp::MOBILE] = $data["phone_number"];
        $dataSave[MoMoApp::IDENTITY_CARD] = !empty($data["identity_card"]) ? $data["identity_card"]:"";
        $dataSave[MoMoApp::CHECK_SUM_KEY] = md5(rand());
        $dataSave[MoMoApp::CLIENT_CODE] = $clientCode;
        $dataSave[MoMoApp::NOTIFYURL] = $data["notifyUrl"];
        $dataSave[MoMoApp::CONTRACT_STATUS] = NULL;

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
        $description = __('PaymentGateway::messages.invest_contract');
        $investorId = !empty($data["investor_id"]) ? $data["investor_id"]:"";
        $billInfo = [
            "requestId"                 => $requestId,
            "reference1"                => $this->getTNTransactionId($transactionSaved->id),
            "reference2"                => $investorId,
            "client"                    => $clientCode,
            "callbackUrl"               => env('PW_BASE_URL').'/paymentgateway/momo/appNDT/callback',
            "notifyUrl"                 => env('PW_BASE_URL').'/paymentgateway/momo/appNDT/notify',
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

    public function paymentNotify($url, $dataPost) {
        Log::channel('momo')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::channel('momo')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return $result;
    }
}
