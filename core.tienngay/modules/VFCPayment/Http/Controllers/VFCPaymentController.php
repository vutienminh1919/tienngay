<?php

namespace Modules\VFCPayment\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\VFCPayment\Service\ApiTienNgay;
use Modules\VFCPayment\Service\VPBService;
use Modules\VFCPayment\Service\VietQR;
use Modules\MysqlCore\Repositories\Interfaces\VPBankVANRepositoryInterface as VANRepository;
use Modules\MongodbCore\Repositories\Interfaces\ContractRepositoryInterface as ContractRepository;
use Modules\MongodbCore\Repositories\Interfaces\TemporaryPlanRepositoryInterface as TemporaryPlanRepository;
use Modules\MongodbCore\Entities\TemporaryPlanContract;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface as StoreRepository;

class VFCPaymentController extends BaseController
{
    /**
    * Modules\MysqlCore\Repositories\VANRepository
    */
    private $vanRepo;

    /**
    * Modules\MongodbCore\Repositories\ContractRepository
    */
    private $contractRepo;

    /**
    * Modules\MongodbCore\Repositories\TemporaryPlanRepository
    */
    private $tempoRepo;

    /**
    * Modules\MongodbCore\Repositories\StoreRepository
    */
    private $storeRepo;

   /**
     * @OA\Info(
     *     version="1.0",
     *     title="API VFCPayment"
     * )
     */
    public function __construct(
        VANRepository $vanRepository,
        ContractRepository $contractRepository,
        StoreRepository $storeRepository,
        TemporaryPlanRepository $temporaryPlanRepository
    ) {
        $this->vanRepo = $vanRepository;
        $this->contractRepo = $contractRepository;
        $this->tempoRepo = $temporaryPlanRepository;
        $this->storeRepo = $storeRepository;
    }

    /**
     * @OA\Post(
     *     path="/vfcpayment/getContractList",
     *     tags={"vfcpayment"},
     *     operationId="search",
     *     summary="search contract list by client info",
     *     description="get contract list from contract table by special condition",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                   @OA\Property(property="requestId",type="string"),
     *                   @OA\Property(property="reference1",type="string"),
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
    public function getContractList(Request $request) {
        $requestData = json_decode($request->getContent(), true);
        Log::channel('vfcpayment')->info('vfcpayment getContractList requested: ' . print_r($requestData, true));
        $requestId = !empty($requestData["requestId"]) ? $requestData["requestId"] : "";
        $customerInfo = !empty($requestData["reference1"]) ? $requestData["reference1"] : "";

        $validator = Validator::make($requestData, [
            'requestId' => 'required|string|max:50',
            'reference1' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            Log::channel('vfcpayment')->info('validate error: ' . print_r($validator->errors(), true));
            $response = [
                'requestId' => $requestId,
                'reference1' => $customerInfo,
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first()
            ];
            Log::channel('vfcpayment')->info('vfcpayment getContractList response: ' . print_r($response, true));
            return response()->json($response);
        }
        //search info
        $contractList = $this->searchInfo($customerInfo);
        if (empty($contractList)) {
            $response = [
                'requestId' => $requestId,
                'reference1' => $customerInfo,
                'status' => Response::HTTP_NOT_FOUND,
                'data' => [],
                'message' => __('VFCPayment::messages.not_found')
            ];
            Log::channel('vfcpayment')->info('vfcpayment getContractList response: ' . print_r($response, true));
            return response()->json($response);
        }
        $response = [
            'requestId' => $requestId,
            'reference1' => $customerInfo,
            'status' => Response::HTTP_OK,
            'data' => $contractList,
            'message' => __('VFCPayment::messages.get_data_success')
        ];
        Log::channel('vfcpayment')->info('vfcpayment getContractList response: ' . print_r($response, true));
        return response()->json($response);
        
    }

    /**
    *
    * Search Customer Info
    */
    public function searchInfo($cusInfo) {
        $contractByVan = $this->searchByVan($cusInfo);
        Log::channel('vfcpayment')->info('vfcpayment searchInfo by van: ' . print_r($contractByVan, true));
        if (!empty($contractByVan)) {
            return $contractByVan;
        }
        $contractByCode = $this->searchByCodeContract($cusInfo);
        Log::channel('vfcpayment')->info('vfcpayment searchInfo by code contract: ' . print_r($contractByCode, true));
        if (!empty($contractByCode)) {
            return $contractByCode;
        }
        $contractByIdentityCard = $this->searchByIdentityCard($cusInfo);
        Log::channel('vfcpayment')->info('vfcpayment searchInfo by identitycard: ' . print_r($contractByIdentityCard, true));
        if (!empty($contractByIdentityCard)) {
            return $contractByIdentityCard;
        }

        return [];
    }

    /**
    * Search contract by van info
    * @param String $van
    * @return array
    */
    public function searchByVan($van) {
        $contractsByVan = $this->vanRepo->getContractsByVan($van);

        $contracts = $this->contractRepo->getContractsByContractCodes($contractsByVan);
        if (empty($contracts)) {
            return [];
        }
        foreach ($contracts as $key => $value) {
            $expiredDate = $this->tempoRepo->getCurrentDateOfPaymentTerm($value[TemporaryPlanContract::CODE_CONTRACT]);
            if ($expiredDate) {
                $contracts[$key]['expiredDate'] = date('d-m-Y',$expiredDate);
            } else {
                $contracts[$key]['expiredDate'] = NULL;
            }

            $contracts[$key]['customer_infor']['customer_phone_number'] = $this->hideNumberOfPhone($contracts[$key]['customer_infor']['customer_phone_number']);
            $contracts[$key]['customer_infor']['customer_identify'] = $this->hideNumberOfIdentityCard($contracts[$key]['customer_infor']['customer_identify']);
            
        }
        return $contracts;
    }

    /**
    * Search contract by van identity card
    * @param String $identityCard
    * @return array
    */
    public function searchByIdentityCard($identityCard) {
        $contractsByIdentityCard = $this->contractRepo->getContractByIdentityCard($identityCard);
        if (empty($contractsByIdentityCard)) {
            return [];
        }
        foreach ($contractsByIdentityCard as $key => $value) {
            $expiredDate = $this->tempoRepo->getCurrentDateOfPaymentTerm($value[TemporaryPlanContract::CODE_CONTRACT]);
            if ($expiredDate) {
                $contractsByIdentityCard[$key]['expiredDate'] = date('d-m-Y',$expiredDate);
            } else {
                $contractsByIdentityCard[$key]['expiredDate'] = NULL;
            }
            $contractsByIdentityCard[$key]['customer_infor']['customer_phone_number'] = $this->hideNumberOfPhone($contractsByIdentityCard[$key]['customer_infor']['customer_phone_number']);
            $contractsByIdentityCard[$key]['customer_infor']['customer_identify'] = $this->hideNumberOfIdentityCard($contractsByIdentityCard[$key]['customer_infor']['customer_identify']);
            
        }
        return $contractsByIdentityCard;
    }

    /**
    * Search contract by code contract
    * @param String $identityCard
    * @return array
    */
    public function searchByCodeContract($codeContract) {
        $contractByCode = $this->contractRepo->getContractByContractCode($codeContract);
        if (!$contractByCode) {
            $contractByCode = $this->contractRepo->getContractByContractCode("00000" . $codeContract);
        }
        if (!$contractByCode) {
            return [];
        }
        $expiredDate = $this->tempoRepo->getCurrentDateOfPaymentTerm($contractByCode[TemporaryPlanContract::CODE_CONTRACT]);
        if ($expiredDate) {
            $contractByCode['expiredDate'] = date('d-m-Y',$expiredDate);
        } else {
            $contractByCode['expiredDate'] = NULL;
        }
        $contractByCode['customer_infor']['customer_phone_number'] = $this->hideNumberOfPhone($contractByCode['customer_infor']['customer_phone_number']);
        $contractByCode['customer_infor']['customer_identify'] = $this->hideNumberOfIdentityCard($contractByCode['customer_infor']['customer_identify']);
        return [$contractByCode];

    }

    /**
     * @OA\Post(
     *     path="/vfcpayment/getContractList",
     *     tags={"vfcpayment"},
     *     operationId="search",
     *     summary="search contract list by client info",
     *     description="get contract list from contract table by special condition",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                   @OA\Property(property="requestId",type="string"),
     *                   @OA\Property(property="reference1",type="string"),
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
    public function getPayment(Request $request) {
        $requestData = json_decode($request->getContent(), true);
        Log::channel('vfcpayment')->info('vfcpayment getPayment requested: ' . print_r($requestData, true));
        $requestId = !empty($requestData["requestId"]) ? $requestData["requestId"] : "";
        $contractCode = !empty($requestData["reference1"]) ? $requestData["reference1"] : "";

        $validator = Validator::make($requestData, [
            'requestId' => 'required|string|max:50',
            'reference1' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            Log::channel('vfcpayment')->info('validate error: ' . print_r($validator->errors(), true));
            $response = [
                'requestId' => $requestId,
                'reference1' => $contractId,
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first()
            ];
            Log::channel('vfcpayment')->info('vfcpayment getPayment response: ' . print_r($response, true));
            return response()->json($response);
        }
        //get payment info
        $contract = $this->contractRepo->findContractByContractCode($contractCode);
        if ($contract) {
            $storeCode = $this->storeRepo->getVpbStoreCode(data_get($contract, 'store.id'));
            if (!$storeCode) {
                Log::channel('vfcpayment')->info('getContractIdByVan storeCode is empty');
                $response = [
                    'requestId' => $requestId,
                    'reference1' => $contractCode,
                    'status' => Response::HTTP_NOT_FOUND,
                    'data' => [],
                    'message' => __('VFCPayment::messages.not_found')
                ];
                Log::channel('vfcpayment')->info('vfcpayment getPayment response: ' . print_r($response, true));
                return response()->json($response);
            }
            $partnerCode = substr($storeCode, 1, 4);
            //check store is tcv or tcvdb
            $isTCVDB = $partnerCode == env('VPB_TCVDB_PARTNER_CODE');
            $paymentInfo = false;
            $paymentInfo = $this->getBillInfo($contract['_id'], $isTCVDB);
        }
        if (!$paymentInfo) {
            $response = [
                'requestId' => $requestId,
                'reference1' => $contractCode,
                'status' => Response::HTTP_NOT_FOUND,
                'data' => [],
                'message' => __('VFCPayment::messages.not_found')
            ];
            Log::channel('vfcpayment')->info('vfcpayment getPayment response: ' . print_r($response, true));
            return response()->json($response);
        }

        $response = [
            'requestId' => $requestId,
            'reference1' => $contractCode,
            'status' => Response::HTTP_OK,
            'data' => $paymentInfo,
            'message' => __('VFCPayment::messages.get_data_success')
        ];
        Log::channel('vfcpayment')->info('vfcpayment getPayment response: ' . print_r($response, true));
        return response()->json($response);
        
    }

    public function getBillInfo($contractId, $isTCVDB = false) {
        $callApiPayment = ApiTienNgay::getPaymentInfo($contractId);
        if ($callApiPayment['status'] !== Response::HTTP_OK) {
            return NULL;
        }
        $name = data_get($callApiPayment, "contractDB.customer_infor.customer_name", "");
        $phone = data_get($callApiPayment, "contractDB.customer_infor.customer_phone_number", "");
        $identityCard = data_get($callApiPayment, "contractDB.customer_infor.customer_identify", "");
        $codeContract = data_get($callApiPayment, "contractDB.code_contract", "");
        $expiredDate = $this->tempoRepo->getCurrentDateOfPaymentTerm(data_get($callApiPayment,"contractDB.code_contract", ""));
        if ($expiredDate) {
            $expiredDate = date('d-m-Y',$expiredDate);
        } else {
            $expiredDate = NULL;
        }
        $paymentTerm = ceil(data_get($callApiPayment, "tong_tien_thanh_toan", 0));
        $paymentFinalSettlement = ceil(data_get($callApiPayment, "tong_tien_tat_toan", 0));
        $van = $this->vanRepo->getVanByCodeContract($codeContract, $isTCVDB);
        if (!$van) {
            $van = VPBService::assignVan($codeContract);
        }
        if (!$van) {
            Log::channel('vfcpayment')->info('vfcpayment getBillInfo van is empty');
            return [];
        }
        $description = 'VFC' . $codeContract;
        $paymentTermQRData = [
            'van' => $van,
            'amount' => $paymentTerm,
            'description' => $description
        ];
        $paymentTermQRLink = VietQR::getlink($paymentTermQRData);
        $paymentFinalSettlementQRData = [
            'van' => $van,
            'amount' => $paymentFinalSettlement,
            'description' => $description
        ];
        $paymentFinalSettlementQRLink = VietQR::getlink($paymentFinalSettlementQRData);
        $billInfo = [
            "_id" => $callApiPayment["contractDB"]["_id"]['$oid'],
            "customer_infor" => [
                "name" => $name,
                "phone" => $this->hideNumberOfPhone($phone),
                "identity_card" =>  $this->hideNumberOfIdentityCard($identityCard)
            ],
            "code_contract_disbursement" => data_get($callApiPayment, "contractDB.code_contract_disbursement", ""),
            "code_contract" => $codeContract,
            "expiredDate" => $expiredDate,
            "paymentTerm" => $paymentTerm,
            "paymentTermQRLink" => $paymentTermQRLink,
            "paymentFinalSettlement" => $paymentFinalSettlement,
            "paymentFinalSettlementQRLink" => $paymentFinalSettlementQRLink,
            "vpbankVan" => $van,
            "description" => $description,
            "accountName" => VietQR::ACCOUNT_NAME
        ];
        Log::channel('vfcpayment')->info('vfcpayment getBillInfo: ' . print_r($billInfo, true));
        return $billInfo;
    }
    //get Contracts by VAN
    public function getAllContractsbyVan(Request $request) {
        $requestData = json_decode($request->getContent(), true);
        Log::channel('vfcpayment')->info('vfcpayment getAllContracts by Van: ' . print_r($requestData, true));
        $requestId = !empty($requestData['requestId']) ? $requestData['requestId'] : "";
        $customerInfo = !empty($requestData['reference1']) ? $requestData['reference1'] : "";
        $validator = Validator::make($requestData, [
            'requestId' => 'required|string|max:50',
            'reference1' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            Log::channel('vfcpayment')->info('validator error:' . print_r($validator, true));
            $response = [
                'requestId' => $requestId,
                'reference1' => $customerInfo,
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
            ];
            Log::channel('vfcpayment')->info('vfcpayment getContracts response:' . print_r($response, true));
            return response()->json($response);
        }
        //get Contracts list
        $contractsList =  $this->vanRepo->getContractsByVan($customerInfo);
        if (empty($contractsList)) {           
            $response = [
                'requestId' => $requestId,
                'reference1' => $customerInfo,
                'status' => Response::HTTP_NOT_FOUND,
                'data' => [],
                'message' => __('VFCPayment::messages.not_found'),
            ];
            Log::channel('vfcpayment')->info('vfcpayment getcontracsList response error:' . print_r($response, true));
            return response()->json($response);
        }
        else {
            $response = [
                'requiredId' => $requestId,
                'reference1' => $customerInfo,
                'status' => Response::HTTP_OK,
                'data' => $contractsList,
                'message' => __('VFCPayment::messages.get_data_success'),
            ];
            Log::channel('vfcpayment')->info('vfcpayment getcontractsList respones:' . print_r($response, true));
            return response()->json($response);
        }
    }

    /**
    * get QrCode 
    * @param Illuminate\Http\Request;
    * @return Json;
    */
    public function getQrCode(Request $request) {
        $data = $request->all();
        $getQr = VietQr::getlink($data);
        Log::channel('vfcpayment')->info('vfcpayment getQrCode: ' . print_r($getQr, true));
        $response = [
            'status' => Response::HTTP_OK,
            'data' => $getQr,
        ];
        return response()->json($response);
    }
}
