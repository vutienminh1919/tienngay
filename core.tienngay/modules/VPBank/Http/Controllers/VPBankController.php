<?php

namespace Modules\VPBank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\VPBank\Service\VPBankApi;
use Modules\VPBank\Service\ApiTienNgay;
use Modules\MysqlCore\Entities\VPBankTransaction;
use Modules\MysqlCore\Entities\CustomerContract;
use Modules\MysqlCore\Entities\VPBankVAN;
use Modules\MongodbCore\Entities\Transaction;
use Modules\MysqlCore\Repositories\Interfaces\VPBankTransactionRepositoryInterface as VPBTranRepository;
use Modules\MongodbCore\Repositories\Interfaces\ContractRepositoryInterface as ContractRepository;
use Modules\MongodbCore\Repositories\Interfaces\TemporaryPlanRepositoryInterface as TempoPlanRepository;
use Modules\MysqlCore\Repositories\Interfaces\CustomerContractRepositoryInterface as CustomerContractRepository;
use Modules\MysqlCore\Repositories\Interfaces\VPBankVANRepositoryInterface as VANRepository;
use Modules\MongodbCore\Repositories\Interfaces\RoleRepositoryInterface as RoleRepository;
use Modules\MysqlCore\Repositories\Interfaces\CustomerRepositoryInterface as CustomerRepository;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface as StoreRepository;
use Modules\MongodbCore\Repositories\Interfaces\TransactionRepositoryInterface as TransactionRepository;
use DateTime;
use Carbon\Carbon;
use Modules\VPBank\Service\PtiModule;

class VPBankController extends BaseController
{
    const TIEN_THIEU_CHO_PHEP = 12000;
    const CHENH_LECH = 50000;

    /**
    * Modules\MysqlCore\Repositories\VPBankTransactionRepository
    */
    private $vpbTranRepo;

    /**
    * Modules\MongodbCore\Repositories\ContractRepository
    */
    private $contractRepo;

    /**
    * Modules\MongodbCore\Repositories\TemporaryPlanRepository
    */
    private $tempoPlanRepo;

    /**
    * Modules\MysqlCore\Repositories\CustomerContractRepository
    */
    private $cusContractRepo;

    /**
    * Modules\MysqlCore\Repositories\VANRepository
    */
    private $vanRepo;

    /**
    * Modules\MongodbCore\Repositories\RoleRepository
    */
    private $roleRepo;

    /**
    * Modules\MysqlCore\Repositories\CustomerRepository
    */
    private $cusRepo;

    /**
    * Modules\MongodbCore\Repositories\RoleRepository
    */
    private $storeRepo;

    /**
    * Modules\MongodbCore\Repositories\RoleRepository
    */
    private $tranRepo;

    /**
     * @OA\Info(
     *     version="1.0",
     *     title="API VPBank"
     * )
     */
    public function __construct(
        VPBankApi $VPBankApi,
        VPBTranRepository $vpbTranRepository,
        ContractRepository $contractRepository,
        TempoPlanRepository $tempoPlanRepository,
        CustomerContractRepository $cusContractRepository,
        VANRepository $vanRepository,
        RoleRepository $roleRepository,
        CustomerRepository $customerRepository,
        StoreRepository $storeRepository,
        TransactionRepository $transactionRepository
    ) {
        $this->VPBankApi = $VPBankApi;
        $this->vpbTranRepo = $vpbTranRepository;
        $this->contractRepo = $contractRepository;
        $this->tempoPlanRepo = $tempoPlanRepository;
        $this->cusContractRepo = $cusContractRepository;
        $this->vanRepo = $vanRepository;
        $this->roleRepo = $roleRepository;
        $this->cusRepo = $customerRepository;
        $this->storeRepo = $storeRepository;
        $this->tranRepo = $transactionRepository;
    }

    public function securityToken() {
        $data = $this->VPBankApi->apiCreateVituarlAccount();
        if ($data != null) {
            if ( data_get($data, 'error') == null ) {
                return $this->responseSuccess($data);
            }
            return $this->responseVPBankError($data);
        }
        return $this->responseError(__('VPBank::messages.vpbank_system_error'));
    }

    public function createVirtualAccount($data) {
        Log::channel('vpbank')->info('(createVirtualAccount):'. print_r($data, true));
        $validator = Validator::make($data, [
            'virtualAccName' => 'required|string|max:70',
            //'virtualMobile' => 'string|max:35',
            'virtualGroup' => 'required|string|max:35',
            'storeCode' => 'required|string|max:35',
            'customer_id'   => 'required|string|max:25',
        ]);
        if ( $validator->failed() ) {
            Log::channel('vpbank')->info('(createVirtualAccount) validate failed:'. $validator->errors()->first());
            return false;
        }
        $storeCode = $data['storeCode'];
        $customerId = $data['customer_id'];
        $newId = $this->vanRepo->getNewId($storeCode);
        $partnerCode = substr($storeCode, 1, 4);
        //check store is tcv or tcvdb
        $tcvdb = $partnerCode == env('VPB_TCVDB_PARTNER_CODE');

        if ($tcvdb) {
            $data['mainCustomerNo'] = env('VPB_TCVDB_MAIN_CUSTOMER');
            $data['mainAcctNo'] = env('VPB_TCVDB_MAIN_ACCOUNT');
            $data['partner'] = env('VPB_TCVDB_PARTNER');
            $data['partnerCode'] = env('VPB_TCVDB_PARTNER_CODE');
        } else {
            $data['mainCustomerNo'] = env('VPB_TCV_MAIN_CUSTOMER');
            $data['mainAcctNo'] = env('VPB_TCV_MAIN_ACCOUNT');
            $data['partner'] = env('VPB_TCV_PARTNER');
            $data['partnerCode'] = env('VPB_TCV_PARTNER_CODE');
        }
        $data['virtualAccNo'] = $storeCode . $newId;
        $data['virtualAltKey'] = $storeCode;
        $data['virtualAccName'] = Str::upper(Str::slug($data['virtualAccName'], ' '));
        $data['openDate'] = date("Y-m-d");
        $data['valueDate'] = date("Y-m-d");
        $data['expiryDate'] = date('Y-m-d', strtotime('+99 year'));
        $data['status'] = VPBankVAN::STATUS_ACTIVE;
        if ($tcvdb) {
            $data[VPBankVAN::COMPANY_NAME] = VPBankVAN::TCVDB;
        } else {
            $data[VPBankVAN::COMPANY_NAME] = VPBankVAN::TCV;
        }
        //call api
        unset($data['storeCode']);
        unset($data['customer_id']);
        $result = $this->VPBankApi->apiCreateVituarlAccount($data, $tcvdb);

        // Case 1: create id success
        if (!empty($result["virtualAccId"])) {
            $data['virtualAccNo'] = $result["virtualAccId"];
            $data['storeCode'] = $storeCode;
            $data['customer_id'] = $customerId;
            Log::channel('vpbank')->info('(createVirtualAccount) success:'. print_r($data, true));
            $van = $this->vanRepo->store($data);
            if ($van) {
                Log::channel('vpbank')->info('(createVirtualAccount) save db success:'. print_r($van, true));
                return $van[VPBankVAN::VIRTUAL_ACC_NO];
            } else {
                Log::channel('vpbank')->info('(createVirtualAccount) save db failed:'. print_r($data, true));
                return false;
            }
        } else {
            // Case 2: the Id has been created
            // save created van to db
            // make new van with value increment 1
            // call api second time with the new van ( old van + 1)
            if (isset($result["error"]) && $result["error"] == config('vpbank.create_update_error.van_already_exists')) {
                Log::channel('vpbank')->info('(createVirtualAccount) the van has been existed:'. $data['virtualAccNo']);
                $oldData = $data;
                $oldData['virtualAccName'] = "";
                $oldData['storeCode'] = $storeCode;
                unset($oldData['customer_id']);
                $van = $this->vanRepo->store($oldData);

                $newId = $this->vanRepo->getNewId($storeCode); // newid + 1
                $data['virtualAccNo'] = $storeCode . $newId;
                Log::channel('vpbank')->info('(createVirtualAccount) save db success:'. print_r($van, true));
                //call second time
                unset($data['storeCode']);
                unset($data['customer_id']);
                $result = $this->VPBankApi->apiCreateVituarlAccount($data, $tcvdb);
                if (!empty($result["virtualAccId"])) {
                    $data['virtualAccNo'] = $result["virtualAccId"];
                    $data['storeCode'] = $storeCode;
                    $data['customer_id'] = $customerId;
                    Log::channel('vpbank')->info('(createVirtualAccount) success:'. print_r($data, true));
                    $van = $this->vanRepo->store($data);
                    if ($van) {
                        Log::channel('vpbank')->info('(createVirtualAccount) save db success:'. print_r($van, true));
                        return $van[VPBankVAN::VIRTUAL_ACC_NO];
                    }
                }
            }
            // Case 3: create van failed
            Log::channel('vpbank')->info('(createVirtualAccount) failed:'. print_r($result, true));
            return false;
        }
    }

    public function updateVirtualAccount(Request $request) {
        $requestData = json_decode($request->getContent(), true);
        Log::channel('vpbank')->info('(updateVirtualAccount) request:'. print_r($requestData, true));
        $validator = Validator::make($requestData, [
            'virtualAccName' => 'string|max:70',
            'virtualAccId' => 'required|string|max:20',
            'partner' => 'required|string|max:20',
            'virtualAltKey' => 'string|max:35',
            'valueDate' => 'string|max:35',
            'expiryDate' => 'string|max:35',
            'status' => 'in:ACTIVE|INACTIVE',
            'tcvdb' => 'in:1|0'
        ]);
        if ( $validator->failed() ) {
            return $this->responseError($validator->errors()->first());
        }
        // Call Api
        $data = $this->VPBankApi->apiUpdateVituarlAccount($requestData);
        Log::channel('vpbank')->info('(updateVirtualAccount) api res:'. print_r($data, true));
        if ($data != null) {
            if ( data_get($data, 'error') == null ) {
                return $this->responseSuccess($data);
            }
            return $this->responseVPBankError($data);
        }
        return $this->responseError(__('VPBank::messages.vpbank_system_error'));
    }

    public function getBankList() {
        Log::channel('vpbank')->info('(getBankList) request');
        // Api Call
        $data = $this->VPBankApi->apiGetBankList();
        Log::channel('vpbank')->info('(getBankList) api res:'. print_r($data, true));
        if ($data != null) {
            if ( data_get($data, 'error') == null ) {
                return $this->responseSuccess($data);
            }
            return $this->responseVPBankError($data);
        }
        return $this->responseError(__('VPBank::messages.vpbank_system_error'));
    }

    public function getBranchList(Request $request) {
        $validator = Validator::make($request->all(), [
            'BankNo' => 'required',
        ]);
        if ( $validator->failed() ) {
            return $this->responseError($validator->errors()->first());
        }
        Log::channel('vpbank')->info('(getBranchList) request:'. print_r($request->all(), true));
        // Api Call
        $data = $this->VPBankApi->apiGetBranchList($request->get('BankNo'));
        Log::channel('vpbank')->info('(getBranchList) api res:'. print_r($data, true));
        if ($data != null) {
            if ( data_get($data, 'error') == null ) {
                return $this->responseSuccess($data);
            }
            return $this->responseVPBankError($data);
        }
        return $this->responseError(__('VPBank::messages.vpbank_system_error'));
    }

    public function getBeneficiaryInfo(Request $request) {
        $validator = Validator::make($request->all(), [
            'bankId' => 'required',
            'benNumber' => 'required',
            'benType' => 'required',
        ]);
        if ( $validator->failed() ) {
            return $this->responseError($validator->errors()->first());
        }
        Log::channel('vpbank')->info('(getBeneficiaryInfo) request:'. print_r($request->all(), true));
        // Api Call
        $data = $this->VPBankApi->apiGetBeneficiaryInfo($request->all());
        Log::channel('vpbank')->info('(getBeneficiaryInfo) api res:'. print_r($data, true));
        if ($data != null) {
            if ( data_get($data, 'error') == null ) {
                return $this->responseSuccess($data);
            }
            return $this->responseVPBankError($data);
        }
        return $this->responseError(__('VPBank::messages.vpbank_system_error'));
    }

    public function notification(Request $request) {
        $data = json_decode($request->getContent(), true);
        Log::channel('vpbank')->info('VPBank notification: ' . print_r($data, true));
        $auth = $request->header('Authorization');
        Log::channel('vpbank')->info('VPBank Auth: ' . $auth);
        $signature = $request->header('Signature');
        Log::channel('vpbank')->info('VPBank notification Signature: ' . $signature);
        $authDecode = base64_decode(substr($auth,6));
        if ($authDecode != env("VPB_ACCOUNT") . ':' . env("VPB_PASSWORD") ) {
            $response = [
                'status' => Response::HTTP_UNAUTHORIZED,
                'errorCode' => config('vpbank.errorCode.authen_failed'),
                'errorMessage' => __('VPBank::messages.auth_failed')
            ];
            Log::channel('vpbank')->info('VPBank notification response: ' . print_r($response, true));
            return response()->json($response);
        }
        $signatureData = $data["transactionId"] . $data["masterAccountNumber"] . $data["amount"] . $data["transactionDate"];
        Log::channel('vpbank')->info('VPBank notification Signature data: ' . $signatureData);
        $signature_verify = $this->VPBankApi->signature_verify($signatureData, $signature);
        if (!$signature_verify) {
            $response = [
                'status' => Response::HTTP_UNAUTHORIZED,
                'errorCode' => config('vpbank.errorCode.invalid_signature'),
                'errorMessage' => __('VPBank::messages.invalid_signature')
            ];
            Log::channel('vpbank')->info('VPBank notification response: ' . print_r($response, true));
            return response()->json($response);
        }
        $validator = Validator::make($data, [
            'masterAccountNumber'   => 'required',
            'amount'                => 'required|numeric',
            'transactionId'         => 'required',
            'transactionDate'       => 'required|string',
            'bookingDate'           => 'required|string',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'errorCode' => config('vpbank.errorCode.invalid_data'),
                'errorMessage' => __('VPBank::messages.invalid_data_format')
            ];
            Log::channel('vpbank')->info('VPBank notification response: ' . print_r($response, true));
            return response()->json($response);
        }

        //check retry case and response code success
        if ($this->vpbTranRepo->findByTranctionId($data['transactionId'])) {
            $response = [
                'status' => Response::HTTP_OK,
                'errorCode' => config('vpbank.errorCode.retry_success'),
                'errorMessage' => __('VPBank::messages.retry_success')
            ];
            Log::channel('vpbank')->info('VPBank notification response: ' . print_r($response, true));
            return response()->json($response);
        }
        $dataSave = [
            'masterAccountNumber'   => $data['masterAccountNumber'],
            'virtualAccountNumber'  => isset($data['virtualAccountNumber']) ? $data['virtualAccountNumber'] : NULL,
            'virtualName'           => isset($data['virtualName']) ? $data['virtualName'] : NULL,
            'amount'                => $data['amount'],
            'remark'                => isset($data['remark']) ? $data['remark'] : NULL,
            'transactionId'         => $data['transactionId'],
            'transactionDate'       => $data['transactionDate'],
            'bookingDate'           => $data['bookingDate'],
        ];

        try {
            if ($data['virtualAccountNumber']) {
                $van = $this->vanRepo->findByVan($data['virtualAccountNumber']);
                Log::channel('vpbank')->error('VPBank notification van info: ' . print_r($van, true));
                $dataSave['vitualAltKeyCode'] = !empty($van['virtualAltKey']) ? $van['virtualAltKey'] : '';
                $store = $this->storeRepo->findByVpbStoreCode($dataSave['vitualAltKeyCode']);
                Log::channel('vpbank')->error('VPBank notification store info: ' . print_r($store, true));
                $dataSave['vitualAltKeyName'] = !empty($store['name']) ? $store['name'] : '';
            }
            Log::channel('vpbank')->info('VPBank notification dataSave: ' . print_r($dataSave, true));
            $result = $this->vpbTranRepo->store($dataSave);
            if ($result) {
                $response = [
                    'status' => Response::HTTP_OK,
                    'errorCode' => config('vpbank.errorCode.success'),
                    'errorMessage' => __('VPBank::messages.success')
                ];
            } else {
                $response = [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'errorCode' => config('vpbank.errorCode.other'),
                    'errorMessage' => __('VPBank::messages.save_data_failed')
                ];
            }

        } catch (\Exception $e) {
            Log::channel('vpbank')->error('VPBank notification error: ' . print_r($e->getMessage(), true));
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'errorCode' => config('vpbank.errorCode.other'),
                'errorMessage' => __('VPBank::messages.save_data_failed')
            ];
        }

        // try {
        //     $this->processPayment($result->id);
        // } catch (\Exception $e) {
        //     Log::channel('vpbank')->error('VPBank notification processPayment error: ' . print_r($e->getMessage(), true));
        // }

        Log::channel('vpbank')->info('VPBank notification response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * @OA\Post(
     *     path="/vpbank/transaction/getListByMonth",
     *     tags={"vpbank"},
     *     operationId="getListByMonth",
     *     summary="get list data",
     *     description="get transaction list from vpbank_transactions table by range time",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="time",type="string"),
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
    public function listTransactionByMonth(Request $request) {
        $time = $request->input('time'); // Tien ngay transaction id
        $data =  $this->vpbTranRepo->getListByMonth($time);
        Log::channel('vpbank')->info('search transaction by month: ' . $time);
        return response()->json([
            'data' => $data,
            'status' => Response::HTTP_OK,
            'message' => __('VPBank::messages.get_data_success')
        ]);
        return response()->json($response);
    }

    /**
     * @OA\Post(
     *     path="/vpbank/transaction/searchTransactions",
     *     tags={"vpbank"},
     *     operationId="search",
     *     summary="search transaction",
     *     description="get transaction list from vpbank_transactions table by special condition",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                   @OA\Property(property="confirmed",type="number"),
     *                   @OA\Property(property="contract_code_disbursement",type="string"),
     *                   @OA\Property(property="contract_transaction_id",type="string"),
     *                   @OA\Property(property="transactionId",type="string"),
     *                   @OA\Property(property="start_date",type="string"),
     *                   @OA\Property(property="end_date",type="string"),
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
    public function searchTransactions(Request $request) {
        $conditions = $request->all();
        Log::channel('vpbank')->info('search searchTransactions: ' . print_r($conditions, true));
        $data =  $this->vpbTranRepo->searchByConditions($conditions);
        Log::channel('vpbank')->info('search searchTransactions result: ' . print_r($data, true));
        return response()->json([
            'data' => $data,
            'status' => Response::HTTP_OK,
            'message' => __('VPBank::messages.get_data_success')
        ]);
        return response()->json($response);
    }

    /**
    * Tiến hành gạch nợ tự động
    * @param Integer $transactionId: vpbank_transactions table's id
    *
    */
    protected function processPayment($transactionId, $chanel = 'vpbank') {
        Log::channel($chanel)->info('processPayment start : id ' . $transactionId);
        $transaction = $this->vpbTranRepo->find($transactionId);
        if ($transaction && $transaction[VPBankTransaction::VIRTUAL_ACCOUNT_NUMBER]) {
            $contractId = $this->getContractIdByVan($transaction, $chanel);
        } else {
            $contractId = $this->getContractId($transaction[VPBankTransaction::REMARK], $chanel);
        }
        if ($contractId) {
            $billPayment = ApiTienNgay::getPaymentInfo($contractId);
            Log::channel($chanel)->info('processPayment billPayment :' . print_r($billPayment, true));
            if ($billPayment && $billPayment["status"] == Response::HTTP_OK) {
                Log::channel($chanel)->info('billData start');
                $billData = [
                    "total_amount" => NULL,
                    "late_fee" => NULL,
                    "paid_amount" => $transaction["amount"],
                    "note" => "VPBank - Thanh Toán Chuyển Khoản",
                    "contract_code" => $billPayment['code_contract'],
                    "id_exemption" => $billPayment['id_exemption'],
                    "epayment_code" => "VPBank",
                    "paid_date" => $transaction["transactionDate"],
                    "created_by" => "VPBank",
                    'transactionId' => $transaction[VPBankTransaction::TRANSACTION_ID]
                ];
                if ($transaction["amount"] >= round($billPayment["tong_tien_tat_toan"])) {
                    $giamTruTatToan = !empty($billPayment['phi_tat_toan']["tien_giam_tru_tattoan"]) ? abs($billPayment['phi_tat_toan']["tien_giam_tru_tattoan"]) : 0;
                    $billData['discounted_fee'] = $giamTruTatToan;
                    $billData['total_deductible'] = $giamTruTatToan;
                    $paymentResult = ApiTienNgay::paymentFinalSettlement($billData, $chanel);
                } else {
                    $giamTruThanhToan = !empty($billPayment['phi_thanh_toan']["tien_giam_tru_thanhtoan"]) ? abs($billPayment['phi_thanh_toan']["tien_giam_tru_thanhtoan"]) : 0;
                    $billData['discounted_fee'] = $giamTruThanhToan;
                    $billData['total_deductible'] = $giamTruThanhToan;
                    $paymentResult = ApiTienNgay::paymentTerm($billData, $chanel);
                }
                ApiTienNgay::refreshContractInfo($contractId);

                $dataUpdate = [
                    VPBankTransaction::CONTRACT_ID => $contractId,
                    VPBankTransaction::CONTRACT_CODE => $billPayment['code_contract'],
                    VPBankTransaction::CONTRACT_CODE_DISBURSEMENT => $billPayment["contractDB"]['code_contract_disbursement'],
                    VPBankTransaction::NAME => data_get($billPayment["contractDB"]["customer_infor"], 'customer_name', ''),
                    VPBankTransaction::EMAIL => data_get($billPayment["contractDB"]["customer_infor"], 'customer_email', ''),
                    VPBankTransaction::MOBILE => data_get($billPayment["contractDB"]["customer_infor"], 'customer_phone_number', ''),
                    VPBankTransaction::IDENTITY_CARD => data_get($billPayment["contractDB"]["customer_infor"], 'customer_identify', ''),
                    VPBankTransaction::STORE_ID => data_get($billPayment["contractDB"]["store"], 'id', ''),
                    VPBankTransaction::STORE_NAME => data_get($billPayment["contractDB"]["store"], 'name', ''),
                    VPBankTransaction::STORE_ADDRESS => data_get($billPayment["contractDB"]["store"], 'address', ''),
                    VPBankTransaction::STORE_CODE_ADDRESS => data_get($billPayment["contractDB"]["store"], 'code_address', ''),
                ];
                if ($paymentResult && $paymentResult["status"] == Response::HTTP_OK) {
                    $dataUpdate[VPBankTransaction::TN_TRANSACTIONID] = $paymentResult["transaction_id"]['$oid'];
                    $dataUpdate[VPBankTransaction::TN_TRANCODE] = $paymentResult["transaction_code"];
                    $dataUpdate[VPBankTransaction::STATUS] = VPBankTransaction::STATUS_SUCCESS;
                } else {
                    if (isset($paymentResult["transaction_id"])) {
                        $dataUpdate[VPBankTransaction::TN_TRANSACTIONID] = $paymentResult["transaction_id"]['$oid'];
                        $dataUpdate[VPBankTransaction::TN_TRANCODE] = $paymentResult["transaction_code"];
                    }
                }
                Log::channel($chanel)->info('processPayment update start : id ' . $transactionId . ', data : ' . print_r($dataUpdate, true));
                $updateResult = $this->vpbTranRepo->update($transactionId, $dataUpdate);
                Log::channel($chanel)->info('processPayment update end');
            }
        }
        Log::channel($chanel)->info('processPayment done : id ' . $transactionId);
    }

    /**
    * Regex contract_code from message
    * @param String $message
    * @return String $contractId
    */
    protected function getContractId($message, $chanel = 'vpbank') {
        Log::channel($chanel)->info('getContractId regex message start');
        $string = strtoupper(str_replace(' ', '', $message));
        if ( preg_match('/VFC00000(\d+)/', $string, $matches) ) {
            if ( isset($matches[1]) && preg_match('/0*(\d+)/', $matches[1], $number) ) {
                if (isset($number[1])) {
                    return $this->getContractByContractCode($number[1], $chanel);
                }
            }
            //cmt
        } else if ( preg_match('/VFC([0-9]{12})/', $string, $matches) ) {
            if ( isset($matches[1]) ) {
                return $this->getContractByIdentityCard($matches[1], $chanel);
            }
            //old cmt
        } else if ( preg_match('/VFC([0-9]{9})/', $string, $matches) ) {
            if ( isset($matches[1]) ) {
                return $this->getContractByIdentityCard($matches[1], $chanel);
            }
        } else if ( preg_match('/VFC([0-9]{1,10})/', $string, $matches) ) {
            if ( isset($matches[1]) ) {
                if ( isset($matches[1]) && preg_match('/0*(\d+)/', $matches[1], $number) ) {
                    if (isset($number[1])) {
                        return $this->getContractByContractCode($number[1], $chanel);
                    }
                }
            }
        }
        Log::channel($chanel)->info('getContractId regex failed');
        return false;
    }

    /**
    * find the contract which has been registed van.
    * @param Array $transaction
    * @return String $contractId
    */
    protected function getContractIdByVan($transaction, $chanel = 'vpbank') {
        $van = data_get($transaction, VPBankTransaction::VIRTUAL_ACCOUNT_NUMBER, '');
        $remark = data_get($transaction, VPBankTransaction::REMARK, '');
        $remark = strtoupper(str_replace(' ', '', $remark));
        $amount = data_get($transaction, VPBankTransaction::AMOUNT, 0);
        $customerId = $this->vanRepo->getCusIdByVan($van);
        $vanIsTCVDB = $this->vanRepo->isTCVDB($van);
        $tranDate = data_get($transaction, VPBankTransaction::TRANSACTION_DATE, '');
        if (!$customerId) {
            return false;
        }
        $contractCodes = $this->cusContractRepo->getContractCodesByCusId($customerId);
        Log::channel($chanel)->info('getContractIdByVan contract code: ' . print_r($contractCodes, true));
        //case1: check message have contractcode or check have tienngay transaction code
        if (!empty($remark)) {

            // Case 1.1: Check have tienngay transaction code
            // 1. Check if transaction which has paid by cash is exist and not confirmed yet
            // 2. Compare transaction's bank_remark with vpbank's remark
            // 3. Compare transaction's amount_total with vpbank's amount
            // 4. Update tienngay transaction
            $tnTransactions = $this->tranRepo->getCashTran($contractCodes);
            Log::channel($chanel)->info('getCashTran: ' .  print_r($tnTransactions, true));
            foreach ($tnTransactions as $value) {
                if (!empty($value[Transaction::BANK_REMARK])) {
                    if (
                        strpos($remark, $value[Transaction::BANK_REMARK]) !== false
                        && $value[Transaction::TOTAL] == $amount
                    ) {
                        Log::channel($chanel)->info('getContractIdByVan update cash transaction ->start: ' . $value[Transaction::CODE]);
                        $contract = $this->contractRepo->findContractByContractCode($value[Transaction::CODE_CONTRACT]);
                        $billData = [
                            'note' => "VPBank - Thanh Toán Chuyển Khoản",
                            'code_transaction_bank' => data_get($transaction, VPBankTransaction::TRANSACTION_ID, ''),
                            'bank' => "VPB"
                        ];
                        if ($value[Transaction::TYPE_PAYMENT] == Transaction::TYPE_PAYMENT_TERM) {

                            $billData['status'] = Transaction::STATUS_SUCCESS;
                        } else {
                            $sendEmail = array(
                                "transactionId" => $value[Transaction::CODE],
                                "customer_name" => data_get($contract["customer_infor"], 'customer_name', ''),
                                "paidAmount" => $value[Transaction::TOTAL],
                                "paidDate" => date('d-m-Y', $value[Transaction::DATE_PAY]),
                                "paymentMethod" => $value[Transaction::PAYMENT_METHOD],
                                "bank"          => $billData["bank"],
                                "code_transaction_bank" => $billData["code_transaction_bank"],
                            );
                            switch ($value[Transaction::TYPE_PAYMENT]) {
                                case Transaction::TYPE_PAYMENT_GH:
                                    $sendEmail["message"] = __('VPBank::messages.TYPE_PAYMENT_GH');
                                    break;

                                case Transaction::TYPE_PAYMENT_CC:
                                    $sendEmail["message"] = __('VPBank::messages.TYPE_PAYMENT_CC');
                                    break;

                                case Transaction::TYPE_PAYMENT_THANHLY_HD:
                                    $sendEmail["message"] = __('VPBank::messages.TYPE_PAYMENT_THANHLY_HD');
                                    break;

                                default:
                                    $sendEmail["message"] = __('VPBank::messages.TYPE_PAYMENT');
                                    break;
                            }
                            // Gửi email yêu cầu kế toán duyệt bằng tay
                            ApiTienNgay::sendEmailApproveTransaction($sendEmail);
                        }
                        $updateCashTran = $this->tranRepo->updateCashTran($value[Transaction::ID], $billData);
                        $contractId = data_get($contract, '_id', NULL);
                        $dataUpdate = [
                            VPBankTransaction::CONTRACT_ID => $contractId,
                            VPBankTransaction::CONTRACT_CODE => $contract['code_contract'],
                            VPBankTransaction::CONTRACT_CODE_DISBURSEMENT => $contract['code_contract_disbursement'],
                            VPBankTransaction::NAME => data_get($contract["customer_infor"], 'customer_name', ''),
                            VPBankTransaction::EMAIL => data_get($contract["customer_infor"], 'customer_email', ''),
                            VPBankTransaction::MOBILE => data_get($contract["customer_infor"], 'customer_phone_number', ''),
                            VPBankTransaction::IDENTITY_CARD => data_get($contract["customer_infor"], 'customer_identify', ''),
                            VPBankTransaction::STORE_ID => data_get($contract["store"], 'id', ''),
                            VPBankTransaction::STORE_NAME => data_get($contract["store"], 'name', ''),
                            VPBankTransaction::STORE_ADDRESS => data_get($contract["store"], 'address', ''),
                            VPBankTransaction::STORE_CODE_ADDRESS => data_get($contract["store"], 'code_address', ''),
                            VPBankTransaction::TN_TRANSACTIONID => $value[Transaction::ID],
                            VPBankTransaction::TN_TRANCODE => $value[Transaction::CODE],
                            VPBankTransaction::STATUS => VPBankTransaction::STATUS_SUCCESS
                        ];

                        $updateResult = $this->vpbTranRepo->update($transaction["id"], $dataUpdate);
                        Log::channel($chanel)->info('getContractIdByVan update cash transaction ->end');

                        ApiTienNgay::refreshContractInfo($contractId);
                        return NULL;
                    }
                }
            }
            $string = strtoupper(str_replace(' ', '', $remark)); //remove all space and uppercase string
            $contractCode = null;
            foreach ($contractCodes as $value) {
                preg_match('/VFC'. $value . '/', $string, $matches);
                //check $string contains a 'VFC00000xxxxx'
                if (isset($matches[0])) {
                    $contractCode = $value;
                    break;
                }
                //check $string contains a 'VFCxxxxx'
                preg_match('/VFC'. (int)$value . '/', $string, $matches);
                if (isset($matches[0])) {
                    $contractCode = $value;
                    break;
                }
                //check $string contains a 'xxxxx'
                preg_match('/'. (int)$value . '/', $string, $matches);
                if (isset($matches[0])) {
                    $contractCode = $value;
                    break;
                }
            }
            Log::channel($chanel)->info('getContractIdByVan contract code in remark: ' . $contractCode);
            if ($contractCode !== null && in_array($contractCode, $contractCodes)) {
                $contract = $this->contractRepo->findContractByContractCode($contractCode);
                // $isTCVDB = $this->roleRepo->isTCVDB(data_get($contract, 'store.id'));

                $storeCode = $this->storeRepo->getVpbStoreCode(data_get($contract, 'store.id'));
                if (!$storeCode) {
                    Log::channel($chanel)->info('getContractIdByVan storeCode is empty');
                    return false;
                }
                $partnerCode = substr($storeCode, 1, 4);
                //check store is tcv or tcvdb
                $isTCVDB = $partnerCode == env('VPB_TCVDB_PARTNER_CODE');

                Log::channel($chanel)->info('getContractIdByVan contract in remark: ' . print_r($contract, true));
                //check contract and van are same group TCV or TCVDB
                if (isset($contract["_id"]) && ($vanIsTCVDB == $isTCVDB)) {
                    return $contract["_id"];
                }
            }
        }

        //case2: check priority contract
        $contracts = $this->contractRepo->getContractsByMultipleContractCode($contractCodes);
        //check contract and van are same group TCV or TCVDB
        $arrContracts = [];
        $arrContractCodes = [];
        foreach ($contracts as $key => $value) {
            // $isTCVDB = $this->roleRepo->isTCVDB(data_get($value, 'store.id'));
            $storeCode = $this->storeRepo->getVpbStoreCode(data_get($value, 'store.id'));
            if (!$storeCode) {
                Log::channel($chanel)->info('getContractIdByVan storeCode is empty');
                continue;
            }
            $partnerCode = substr($storeCode, 1, 4);
            //check store is tcv or tcvdb
            $isTCVDB = $partnerCode == env('VPB_TCVDB_PARTNER_CODE');

            Log::channel($chanel)->info('getContractIdByVan contractCode: ' . $value["code_contract"]);
            if ($vanIsTCVDB == $isTCVDB) {
                $arrContracts[] = $value;
                $arrContractCodes[] = $value["code_contract"];
            }
        }
        //find priority contract
        if (empty($arrContracts)) {
            Log::channel($chanel)->info('getContractIdByVan arrContracts: is empty');
            return false;
        }

        if (count($arrContracts) == 1) {
            Log::channel($chanel)->info('getContractIdByVan contract code: ' . $arrContracts[0]["code_contract"]);
            return $arrContracts[0]["_id"];
        }

        $contractId = $this->getPriorityContract($arrContractCodes, $amount, $tranDate, $chanel);
        Log::channel($chanel)->info('getContractIdByVan contractId: ' . $contractId);
        if ($contractId) {
            return $contractId;
        }

        return false;
    }


    /**
    * find the contract which is priority.
    * @param Array $contractCodes
    * @param String $targetAmount
    * @param String $tranDate
    * @return String $codeContract
    */
    public function getPriorityContract($contractCodes, $targetAmount, $tranDate, $chanel = 'vpbank') {
        $arrTatToan = [];
        $arrTienKy = [];
        $arrTienKy2 = [];
        $arrTienKy3 = [];
        $arrContracts = [];
        $datePay = Carbon::createFromFormat('Y-m-d H:i:s', $tranDate)->format('Y-m-d');
        $currentDate = strtotime($datePay);
        foreach ($contractCodes as $key => $value) {
            $paymentInfo = ApiTienNgay::getPayment($value, $datePay);
            Log::channel($chanel)->info('getPriorityContract paymentInfo' . print_r($paymentInfo, true));
            if ($paymentInfo && $paymentInfo["status"] == Response::HTTP_OK) {
                Log::channel($chanel)->info('getPriorityContract paymentInfo OK');
                $dateOfPaymentTerm = $this->tempoPlanRepo->getCurrentDateOfPaymentTerm($value);
                $amountOfPaymentTerm = $this->tempoPlanRepo->getAmountOfPaymentTerm($value);
                $paymentInfo["dateOfPaymentTerm"] = $dateOfPaymentTerm;
                $paymentInfo["latePaymentDays"] = ($dateOfPaymentTerm - $currentDate)/(3600*24);
                $paymentInfo["amountOfPaymentTerm"] = $amountOfPaymentTerm; // Tiền trả 1 kỳ
            } else {
                continue;
            }
            Log::channel($chanel)->info('getPriorityContract paymentInfo' . print_r($paymentInfo, true));
            Log::channel($chanel)->info('getPriorityContract targetAmount ' . $targetAmount);
            // Lấy HĐ đủ điều kiện tất toán
            if (
                $targetAmount >= $paymentInfo["tong_tien_tat_toan"]
                && $targetAmount < $paymentInfo["tong_tien_tat_toan"] + self::CHENH_LECH
            ) {
                Log::channel($chanel)->info('getPriorityContract du dieu kien tat toan ' . $paymentInfo["code_contract"]);
                $arrTatToan[] = $paymentInfo;
            }

            $minAmount = $paymentInfo["tong_tien_thanh_toan"]
                            - $paymentInfo["phi_thanh_toan"]["phi_phat_cham_tra"]
                            - self::TIEN_THIEU_CHO_PHEP;
            // Lấy HĐ đủ điều kiện thanh toán
            // ngày đến kỳ trong khoảng -3 -> 5 ngày.
            if (
                $targetAmount >= $minAmount
                && $targetAmount < $paymentInfo["tong_tien_thanh_toan"] + self::CHENH_LECH
                && $paymentInfo["latePaymentDays"] > -4
                && $paymentInfo["latePaymentDays"] < 5
            ) {
                Log::channel($chanel)->info('getPriorityContract du dieu kien thanh toan 1 ' . $paymentInfo["code_contract"]);
                $arrTienKy[] = $paymentInfo;
            }

            // Lấy HĐ đủ điều kiện thanh toán
            if (
                $targetAmount >= $minAmount
                && $targetAmount < $paymentInfo["tong_tien_thanh_toan"] + self::CHENH_LECH
            ) {
                Log::channel($chanel)->info('getPriorityContract du dieu kien thanh toan 2 ' . $paymentInfo["code_contract"]);
                $arrTienKy2[] = $paymentInfo;
            }

            // Lấy HĐ đủ điều kiện thanh toán cho 1 kỳ
            $minAmount2 = $paymentInfo["amountOfPaymentTerm"]
                            - self::TIEN_THIEU_CHO_PHEP;
            if (
                $targetAmount >= $minAmount2
                && $targetAmount < ($minAmount2 + self::CHENH_LECH + $paymentInfo["phi_thanh_toan"]["phi_phat_cham_tra"])
            ) {
                Log::channel($chanel)->info('getPriorityContract du dieu kien thanh toan 3 ' . $paymentInfo["code_contract"]);
                $arrTienKy3[] = $paymentInfo;
            }

            // lấy hết thông tin thanh toán
            $arrContracts[] = $paymentInfo;
        }

        //find priority contract
        if (empty($arrContracts)) {
            Log::channel($chanel)->info('getPriorityContract arrContracts: is empty');
            return false;
        }
        // TH1, Đủ điều kiện tất toán và không có hợp đồng nào đủ điều kiện thanh toán kỳ.
        if (!empty($arrTatToan) && empty($arrTienKy)) {
            Log::channel($chanel)->info('getPriorityContract TH1' . print_r($arrTatToan, true));
            $id = $arrTatToan[0]["id"];
            $compareAmount = $targetAmount - $arrTatToan[0]["tong_tien_tat_toan"];
            // Lấy HĐ có hiệu số giữa tiền KH thanh toán và tiền KH phải tất toán là nhỏ nhất
            foreach ($arrTatToan as $key => $value) {
                $diffAmount = $targetAmount - $value["tong_tien_tat_toan"];
                Log::channel($chanel)->info('getPriorityContract TH1 ' . $value["code_contract"] . ' diff amount: ' . $diffAmount);
                if ($diffAmount < $compareAmount) {
                    $compareAmount = $diffAmount;
                    $id = $value["id"];
                }
            }
            return $id;
        }
        // TH2, Đủ điều kiện thanh toán kỳ. lấy hợp đồng có số ngày chậm trả bé nhất trong khoảng -3 -> 5 ngày
        if (!empty($arrTienKy)) {
            Log::channel($chanel)->info('getPriorityContract TH2' . print_r($arrTienKy, true));
            $id = $arrTienKy[0]["id"];
            $date = $arrTienKy[0]["latePaymentDays"];
            // Lấy HĐ có ngày thanh toán kỳ gần nhất để tránh phát sinh phí chậm trả
            foreach ($arrTienKy as $key => $value) {
                $date2 = $value["latePaymentDays"];
                Log::channel($chanel)->info('getPriorityContract TH2 ' . $value["code_contract"] .  ' date2: ' . $date2);
                if ($date2 < $date) {
                    $id = $value["id"];
                    $date = $date2;
                }
            }
            return $id;
        }

        // TH3, Đủ điều kiện thanh toán kỳ. lấy hợp đồng có số ngày chậm trả bé nhất
        if (!empty($arrTienKy2)) {
            Log::channel($chanel)->info('getPriorityContract TH3' . print_r($arrTienKy2, true));
            $id = $arrTienKy2[0]["id"];
            $date = abs($arrTienKy2[0]["latePaymentDays"]);
            // Lấy HĐ có ngày thanh toán kỳ gần nhất để tránh phát sinh phí chậm trả
            foreach ($arrTienKy2 as $key => $value) {
                $date2 = abs($value["latePaymentDays"]);
                Log::channel($chanel)->info('getPriorityContract TH3 ' . $value["code_contract"] .  ' date2: ' . $date2);
                if ($date2 < $date) {
                    $id = $value["id"];
                    $date = $date2;
                }
            }
            return $id;
        }

        // TH3, Đủ điều kiện thanh toán cho 1 kỳ. lấy hợp đồng có số ngày chậm trả bé nhất
        if (!empty($arrTienKy3)) {
            Log::channel($chanel)->info('getPriorityContract TH4' . print_r($arrTienKy3, true));
            $id = $arrTienKy3[0]["id"];
            $date = $arrTienKy3[0]["latePaymentDays"];
            // Lấy HĐ có ngày thanh toán kỳ có số ngày chậm trả lớn nhất
            foreach ($arrTienKy3 as $key => $value) {
                $date2 = $value["latePaymentDays"];
                Log::channel($chanel)->info('getPriorityContract TH4 ' . $value["code_contract"] .  ' date2: ' . $date2);
                if ($date2 < $date) {
                    $id = $value["id"];
                    $date = $date2;
                }
            }
            return $id;
        }

        // TH4, Không đủ điều kiện TH1, TH2, TH3
        // lấy hợp đồng có số ngày chậm trả bé nhất
        if (!empty($arrContracts)) {
            Log::channel($chanel)->info('getPriorityContract TH5' . print_r($arrContracts, true));
            $id = $arrContracts[0]["id"];
            $date = abs($arrContracts[0]["latePaymentDays"]);
            // Lấy HĐ có ngày thanh toán kỳ gần nhất để tránh phát sinh phí chậm trả
            foreach ($arrContracts as $key => $value) {
                $date2 = abs($value["latePaymentDays"]);
                Log::channel($chanel)->info('getPriorityContract TH5 ' . $value["code_contract"] .  ' date2: ' . $date2);
                if ($date2 < $date) {
                    $id = $value["id"];
                    $date = $date2;
                }
            }
            return $id;
        }

        // Không tìm thấy hđ phù hợp
        return false;
    }

    /**
    * get contractId by contract_code
    * @param String $code
    * @return String $contractId
    */
    public function getContractByContractCode($code, $chanel = 'vpbank') {
        Log::channel($chanel)->info('getContractByContractCode start: ' . $code);
        $contractCode = '00000'.$code;
        $contract = $this->contractRepo->findContractByContractCode($contractCode);
        Log::channel($chanel)->info('getContractByContractCode contract: ' . print_r($contract, true));
        if ($contract) {
            return $contract["_id"];
        }
        return false;
    }

    /**
    * get contractId by identity card number
    * @param String $identityCard
    * @return String $contractId
    */
    public function getContractByIdentityCard($identityCard, $chanel = 'vpbank') {
        Log::channel($chanel)->info('getContractByIdentityCard start: ' . $identityCard);
        $contracts = $this->contractRepo->findContractByIdentityCard($identityCard);
        Log::channel($chanel)->info('getContractByIdentityCard contract list: ' . print_r($contracts->count(), true));
        if ($contracts->isEmpty()) {
            return false;
        }
        $contractId = $contracts->first()["_id"];
        $date = $this->tempoPlanRepo->getCurrentDateOfPaymentTerm($contracts->first()["code_contract"]);
        foreach ($contracts as $key => $value) {
            $date2 = $this->tempoPlanRepo->getCurrentDateOfPaymentTerm($value["code_contract"]);
            Log::channel($chanel)->info('getContractByIdentityCard contract code: ' . $value["code_contract"]);
            Log::channel($chanel)->info('getContractByIdentityCard contract date2: ' . $date2);
            if ($date2 < $date) {
                $contractId = $value["_id"];
                $date = $date2;
            }
        }
        Log::channel($chanel)->info('getContractByIdentityCard contractId: ' . $contractId);
        if ($contractId) {
            return $contractId;
        }
        return false;
    }

    /**
     * @OA\Post(
     *     path="/vpbank/getVan",
     *     tags={"vpbank"},
     *     operationId="get",
     *     summary="get vitual account",
     *     description="get vitual account number of contract",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                   @OA\Property(property="contract_code",type="string"),
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get data successfully",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="get data failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function getVitualAccountNumber(Request $request) {
        $data = $request->all();
        Log::channel('vpbank')->info('VPBank getVitualAccountNumber requested: ' . print_r($data, true));
        $validator = Validator::make($data, [
            'contract_code'   => 'required|string|max:20',
        ]);

        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('VPBank::messages.error_contract_code'),
                'data' => [],
            ];
            Log::channel('vpbank')->info('VPBank getVitualAccountNumber response: ' . print_r($response, true));
            return response()->json($response);
        }
        $contract = $this->contractRepo->findContractByContractCodeWithNoStatus($data['contract_code']);
        if (!$contract) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('VPBank::messages.contract_does_not_exists'),
                'data' => [],
            ];
            Log::channel('vpbank')->info('VPBank getVitualAccountNumber response: ' . print_r($response, true));
            return response()->json($response);
        }

        $result = $this->cusContractRepo->existsContractCode($data['contract_code']);
        // if contract code does not exists in customer_contracts table

        if (!$result) {
            //if closed contract and havent van yet => do not register new van.
            $isClosedContract = $this->contractRepo->closedContract($data['contract_code']);
            Log::channel('vpbank')->info('VPBank getVitualAccountNumber isClosedContract: ' . $isClosedContract);
            if ($isClosedContract) {
                $response = [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => __('VPBank::messages.create_van_failed'),
                    'data' => [],
                ];
                Log::channel('vpbank')->info('VPBank getVitualAccountNumber response: ' . print_r($response, true));
                return response()->json($response);
            }

            // Find or Create customer info
            $customer = $this->createCustomer($data['contract_code']);
            if (!$customer) {
                $response = [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => __('VPBank::messages.create_customer_failed'),
                    'data' => [],
                ];
                Log::channel('vpbank')->info('VPBank getVitualAccountNumber response: ' . print_r($response, true));
                return response()->json($response);
            }
            $dataSave = [
                CustomerContract::CUSTOMER_ID      => $customer["id"],
                CustomerContract::CONTRACT_CODE    => $data['contract_code'],
            ];
            Log::channel('vpbank')->info('VPBank getVitualAccountNumber linking customer_id with contract_code: ' . print_r($dataSave, true));
            $cusContract = $this->cusContractRepo->store($dataSave);
        } else {
            $customer = $this->cusRepo->find($result[CustomerContract::CUSTOMER_ID]);
            Log::channel('vpbank')->info('VPBank getVitualAccountNumber customer existed: ' . print_r($customer, true));
        }

        // if contract is VFC Đông Bắc
        // $isTCVDB = $this->roleRepo->isTCVDB(data_get($contract, 'store.id'));
        $storeCode = $this->storeRepo->getVpbStoreCode(data_get($contract, 'store.id'));
        if (!$storeCode) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('VPBank::messages.create_van_failed'),
                'data' => [],
            ];
            Log::channel('vpbank')->info('VPBank getVitualAccountNumber response: ' . print_r($response, true));
            return response()->json($response);
        }
        $partnerCode = substr($storeCode, 1, 4);
        //check store is tcv or tcvdb
        $isTCVDB = $partnerCode == env('VPB_TCVDB_PARTNER_CODE');

        $van = $this->vanRepo->getVanByCusId($customer["id"], $isTCVDB);
        
        Log::channel('vpbank')->info('VPBank getVitualAccountNumber van: ' . $van);
        Log::channel('vpbank')->info('VPBank getVitualAccountNumber storeCode: ' . $storeCode);
        if (!$van) {
            

            // create new van
            $dataVan = [
                'virtualAccName'    => $customer["name"],
                'virtualGroup'      => '',
                'storeCode'         => $storeCode,
                'customer_id'       => $customer["id"],
            ];
            $van = $this->createVirtualAccount($dataVan);
            if (!$van) {
                $response = [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => __('VPBank::messages.create_van_failed'),
                    'data' => [],
                ];
                Log::channel('vpbank')->info('VPBank getVitualAccountNumber response: ' . print_r($response, true));
                return response()->json($response);
            }
        }
        $response = [
            'status' => Response::HTTP_OK,
            'message' => __('VPBank::messages.success'),
            'data' => [
                'bankName' => __('VPBank::messages.vpbank_name'),
                'masterAccountName' => __('VPBank::messages.vpbank_master_account_name'),
                'van' => $van,
                'contract_code' => $data['contract_code'],
            ],
        ];
        Log::channel('vpbank')->info('VPBank getVitualAccountNumber response: ' . print_r($response, true));
        return response()->json($response);
    }

    public function createCustomer($contract_code) {
        Log::channel('vpbank')->info('VPBank createCustomer requested: ' . $contract_code);
        $customerInfo = $this->contractRepo->getCustomerInfoByContractCode($contract_code);
        Log::channel('vpbank')->info('VPBank createCustomer customerInfo: ' . print_r($customerInfo, true));
        if (empty($customerInfo)) {
            Log::channel('vpbank')->info('VPBank createCustomer: customer infomation is empty');
            return false;
        }

        $customer = $this->cusRepo->store($customerInfo);
        return $customer->toArray();
    }

    // import giao dich bang tay
    public function notifiAPIHandle(Request $request) {
        $data = json_decode($request->getContent(), true);
        Log::channel('vpbank')->info('notifiAPIHandle: ' . print_r($data, true));
        $signature_verify = isset($data['handle']) && ($data['handle'] == env("PASS_LOG"));
        if (!$signature_verify) {
            $response = [
                'status' => Response::HTTP_UNAUTHORIZED,
                'errorCode' => config('vpbank.errorCode.invalid_signature'),
                'errorMessage' => __('VPBank::messages.invalid_signature')
            ];
            Log::channel('vpbank')->info('VPBank notification response: ' . print_r($response, true));
            return response()->json($response);
        }

        $validator = Validator::make($data, [
            'masterAccountNumber'   => 'required',
            'amount'                => 'required|numeric',
            'transactionId'         => 'required',
            'transactionDate'       => 'required|string',
            'bookingDate'           => 'required|string',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'errorCode' => config('vpbank.errorCode.invalid_data'),
                'errorMessage' => __('VPBank::messages.invalid_data_format')
            ];
            Log::channel('vpbank')->info('VPBank notification response: ' . print_r($response, true));
            return response()->json($response);
        }

        //check retry case and response code success
        if ($this->vpbTranRepo->findByTranctionId($data['transactionId'])) {
            $response = [
                'status' => Response::HTTP_OK,
                'errorCode' => config('vpbank.errorCode.retry_success'),
                'errorMessage' => __('VPBank::messages.retry_success')
            ];
            Log::channel('vpbank')->info('VPBank notification response: ' . print_r($response, true));
            return response()->json($response);
        }
        $dataSave = [
            'masterAccountNumber'   => $data['masterAccountNumber'],
            'virtualAccountNumber'  => isset($data['virtualAccountNumber']) ? $data['virtualAccountNumber'] : NULL,
            'virtualName'           => isset($data['virtualName']) ? $data['virtualName'] : NULL,
            'amount'                => $data['amount'],
            'remark'                => isset($data['remark']) ? $data['remark'] : NULL,
            'transactionId'         => $data['transactionId'],
            'transactionDate'       => $data['transactionDate'],
            'bookingDate'           => $data['bookingDate'],
        ];

        try {
            if ($data['virtualAccountNumber']) {
                $van = $this->vanRepo->findByVan($data['virtualAccountNumber']);
                Log::channel('vpbank')->error('VPBank notification van info: ' . print_r($van, true));
                $dataSave['vitualAltKeyCode'] = !empty($van['virtualAltKey']) ? $van['virtualAltKey'] : '';
                $store = $this->storeRepo->findByVpbStoreCode($dataSave['vitualAltKeyCode']);
                Log::channel('vpbank')->error('VPBank notification store info: ' . print_r($store, true));
                $dataSave['vitualAltKeyName'] = !empty($store['name']) ? $store['name'] : '';
            }
            Log::channel('vpbank')->info('VPBank notification dataSave: ' . print_r($dataSave, true));
            $result = $this->vpbTranRepo->store($dataSave);
            if ($result) {
                $response = [
                    'status' => Response::HTTP_OK,
                    'errorCode' => config('vpbank.errorCode.success'),
                    'errorMessage' => __('VPBank::messages.success')
                ];
            } else {
                $response = [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'errorCode' => config('vpbank.errorCode.other'),
                    'errorMessage' => __('VPBank::messages.save_data_failed')
                ];
            }

        } catch (\Exception $e) {
            Log::channel('vpbank')->error('VPBank notification error: ' . print_r($e->getMessage(), true));
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'errorCode' => config('vpbank.errorCode.other'),
                'errorMessage' => __('VPBank::messages.save_data_failed')
            ];
        }

        // try {
        //     $this->processPayment($result->id);
        // } catch (\Exception $e) {
        //     Log::channel('vpbank')->error('VPBank notification processPayment error: ' . print_r($e->getMessage(), true));
        // }

        Log::channel('vpbank')->info('VPBank notification response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
    * Tiến hành gạch nợ tự động cho các luồng thanh toán không qua tài khoản VAN
    * @param Integer $transactionId: vpbank_transactions table's id
    *
    */
    protected function masterPaymentProcess($transactionId, $channel = 'vpbank') {
        Log::channel($channel)->info('masterPaymentProcess start : id ' . $transactionId);
        $transaction = $this->vpbTranRepo->find($transactionId);

        if ($transaction && empty($transaction[VPBankTransaction::VIRTUAL_ACCOUNT_NUMBER]) && $transaction[VPBankTransaction::REMARK]) {
            $paymentResult = null;
            $tranData = [
                'masterAccountNumber'   => $transaction[VPBankTransaction::MASTER_ACCOUNT_NUMBER],
                'amount'                => $transaction[VPBankTransaction::AMOUNT],
                'remark'                => $transaction[VPBankTransaction::REMARK],
                'transactionId'         => $transaction[VPBankTransaction::TRANSACTION_ID],
                'transactionDate'       => $transaction[VPBankTransaction::TRANSACTION_DATE],
            ];
            if ($this->regexBHTN($transaction[VPBankTransaction::REMARK], $channel)) {
                // Thanh Toán PTI BHTN
                $paymentResult = PtiModule::bhtnPayment($tranData, $channel);
                if ($paymentResult && $paymentResult["status"] == Response::HTTP_OK) {
                    $dataUpdate[VPBankTransaction::TN_TRANSACTIONID] = $paymentResult['data']["transaction_id"];
                    $dataUpdate[VPBankTransaction::TN_TRANCODE] = $paymentResult['data']["transaction_code"];
                    $dataUpdate[VPBankTransaction::STATUS] = VPBankTransaction::STATUS_SUCCESS;
                    Log::channel($channel)->info('masterPaymentProcess update start : id ' . $transactionId . ', data : ' . print_r($dataUpdate, true));
                    $updateResult = $this->vpbTranRepo->update($transactionId, $dataUpdate);
                    Log::channel($channel)->info('masterPaymentProcess update end');
                }
            }
        }
        Log::channel($channel)->info('masterPaymentProcess done : id ' . $transactionId);
    }

    /**
    * Regex pti bảo hiểm tai nạn from message
    * @param String $message
    * @return String $contractId
    */
    protected function regexBHTN($message, $channel = 'vpbank') {
        Log::channel($channel)->info('regexBHTN regex message start');
        $string = strtoupper(str_replace(' ', '', $message));
        if ( preg_match('/BHTNGOI(\d+)/', $string, $matches) ) {
            if ( isset($matches[1]) && preg_match('/0*(\d+)/', $matches[1], $number) ) {
                if (isset($number[1])) {
                    Log::channel($channel)->info('regex success ' . $number[1]);
                    return true;
                }
            }
            //cmt
        }
        Log::channel($channel)->info('regexBHTN failed');
        return false;
    }
}
