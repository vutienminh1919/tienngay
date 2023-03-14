<?php

namespace Modules\PTI\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\PTI\Service\PTIApi;
use Modules\MongodbCore\Repositories\Interfaces\PtiBHTNRepositoryInterface as PtiBHTNRepository;
use Modules\MongodbCore\Repositories\Interfaces\TransactionRepositoryInterface as TransactionRepository;
use Modules\PTI\Service\VietQR;

use DateTime;

class PTIBaoHiemTaiNan extends BaseController
{

    /**
    * Modules\MongodbCore\Repositories\PtiBHTNRepository
    */
    private $ptiBHTNRepo;

    /**
    * Modules\MongodbCore\Repositories\Transaction
    */
    private $tranRepo;


    public function __construct(
        PtiBHTNRepository $ptiBHTNRepository,
        TransactionRepository $transactionRepository
    ) {
        $this->ptiBHTNRepo = $ptiBHTNRepository;
        $this->tranRepo = $transactionRepository;
    }

    /**
    * create new order PTI
    * @return Array $response
    */
    public function createOrder($requestData, $channel = "pti") {
        Log::channel($channel)->info('(createOrder) request: '. print_r($requestData, true));
        $currentTime = new DateTime("NOW");
        $today = (string)($currentTime->format('Y').$currentTime->format('m').$currentTime->format('d'));
        $ngayThanhToan = $currentTime->format('d/m/Y');
        $validator = Validator::make($requestData, [
            'so_id_kenh'    => 'required|numeric',
            'email'         => 'required|string|max:100',
            'goi'           => 'required|string|max:10',
            'ten'           => 'required|string|max:100',
            'dchi'          => 'required|string|max:300',
            'so_cmt'        => 'required|string|max:20',
            'phone'         => 'required|string|max:30',
            'ngay_sinh'     => 'required|string|date_format:Ymd',
            'tien_bh'       => 'required|numeric',
            'phi'           => 'required|numeric',
            'ttoan'         => 'required|numeric',
            'ngay_hl'       => 'required|string|date_format:d/m/Y',
            'ngay_kt'       => 'required|string|date_format:d/m/Y',
            "gio_hl"        => 'required|string|date_format:H:i',
            "gio_kt"        => 'required|string|date_format:H:i',
            "ngay_cap"      => 'required|string|date_format:Ymd',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => []
                
            ];
            Log::channel($channel)->info('(createOrder) response: '. print_r($response, true));
            return $response;
        }
        $requestData['dvi_sl'] = config('pti.BHTN_DVI_SL');
        $requestData['ma_cn'] = '';
        $requestData['ma_khoi'] = '';
        $requestData['ngay_ht'] = $today;
        $requestData['nv'] = config('pti.BHTN_NV');
        $requestData['so_hd'] = '';
        $requestData['kieu_hd'] = config('pti.BHTN_KIEU_HD');
        $requestData['ds_dk'] = config('pti.BHTN_DS_DK');
        $requestData['ds_tra'] = [
            [
                'ngay' => $ngayThanhToan,
                'tien' => $requestData['ttoan']
            ]
        ];
        $requestData['encrypt'] = config('pti.BHTN_ENCRYPT');
        $order = PTIApi::createOrderBHTN($requestData, $channel);

        if (isset($order['code']) && $order['code'] == config('pti.CODE_SUCCESS')) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('PTI::messages.success'),
                'data' => $order['data'] 
            ];
            $response['data']['process'] = 'new';
            $dataConfirm = [
                'dvi_sl' => config('pti.BHTN_DVI_SL'),
                'so_id' => $order['data']['so_id_pti'],
                'so_hd' => $order['data']['so_hd_pti'],
                'nv' => config('pti.BHTN_NV'),
            ];
            $confirm = $this->confirmOrder($dataConfirm, $channel);
            if (isset($confirm['code']) && $confirm['code'] == config('pti.CODE_SUCCESS')) {
                $response['data']['process'] = 'confirmed';
            }
            $signatureOrder = [
                'ma_bc' => config('pti.BHTN_MA_BC'),
                'nv' => config('pti.BHTN_NV'),
                'so_id' => $order['data']['so_id_pti'],
                'dvi_sl' => config('pti.BHTN_DVI_SL'),
                'so_id_dt' => config('pti.BHTN_SO_ID_DT'),
                'loai_in' => config('pti.BHTN_LOAI_IN'),
                'api' => env('PTI_REPORT_URL'),
            ];
            $signature = $this->signatureOrder($signatureOrder, $channel);
            if (isset($signature['code']) && $signature['code'] == config('pti.CODE_SUCCESS')) {
                $response['data']['process'] = 'done';
                $response['data']["data"] = $signature["data"];
                $response['data']["Total"] = $signature["Total"];
                $response['data']["chung_thuc"] = $order['data']['so_id_pti'];
                $response['data']["code"] = '000';
            }
            if ($response['data']['process'] == 'new') {
                $response['status'] = Response::HTTP_BAD_REQUEST;
                $response['message'] = __('PTI::messages.errors');
            }
            return $response;
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('PTI::messages.errors'),
                'data' => []
                
            ];
        }
        Log::channel($channel)->info('(createOrder) response: '. print_r($response, true));
        return $response;
    }

    /**
    * create new order PTI
    * @return json $response
    */
    public function orderByContract(Request $request) {
        $requestData = json_decode($request->getContent(), true);
        Log::channel('pti')->info('(orderByContract) request: '. print_r($requestData, true));
        $validator = Validator::make($requestData, [
            'code_contract'  => 'required|string|max:100',
            'ten'           => 'required|string|max:100',
            'dchi'          => 'required|string|max:300',
            'so_cmt'        => 'required|string|max:20',
            'phone'         => 'required|string|max:30',
            'ngay_sinh'     => 'required|string|date_format:d-m-Y',
            'tien_bh'       => 'required|numeric',
            'phi'           => 'required|numeric',
            'email'         => 'required|string|max:100',
            'ttoan'         => 'required|numeric',
            'ngay_hl'       => 'required|string|date_format:d-m-Y',
            'ngay_kt'       => 'required|string|date_format:d-m-Y',
            'goi'           => 'required|string|max:10'
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'data' => [
                    'message' => $validator->errors()->first(),
                ]
                
            ];
            Log::channel('pti')->info('(orderByContract) response: '. print_r($response, true));
            return response()->json($response);
        }
        $dateOfBirth = new DateTime($requestData['ngay_sinh']);
        $ngay_hl = new DateTime($requestData['ngay_hl']);
        $ngay_kt = new DateTime($requestData['ngay_kt']);
        $currentTime = new DateTime("NOW");
        $inputData = [
            'so_id_kenh'        => (int)($currentTime->format('ymd') . (int)$requestData['code_contract'] . $currentTime->format('His')),
            'ten'               => $requestData['ten'],
            'dchi'              => $requestData['dchi'],
            'so_cmt'            => $requestData['so_cmt'],
            'phone'             => $requestData['phone'],
            'ngay_sinh'         => $dateOfBirth->format('Ymd'),
            'tien_bh'           => $requestData['tien_bh'],
            'phi'               => $requestData['phi'],
            'email'             => $requestData['email'],
            'ttoan'             => $requestData['ttoan'],
            'ngay_hl'           => $ngay_hl->format('d/m/Y'),
            'ngay_kt'           => $ngay_kt->format('d/m/Y'),
            'gio_hl'            => '00:00',
            'gio_kt'            => '23:59',
            'goi'               => $requestData['goi'],
            'ngay_cap'          => $currentTime->format('Ymd')
        ];
        $response = $this->createOrder($inputData);
        if (isset($response['message'])) {
            $response["data"]["message"] = $response['message'];
        }
        if (isset($response['code'])) {
            $response["data"]["code"] = $response['code'];
        }
        $response["data"]["code_contract"] = $requestData['code_contract'];
        $response["data"]["so_id_kenh"] = $inputData['so_id_kenh'];
        $response["data"]["type"] = "HD";
        
        Log::channel('pti')->info('(orderByContract) response: '. print_r($response, true));
        return response()->json($response);
    }

    /**
    * Api lấy giấy chứng nhận pdf
    */
    public function apiGetPdfFile(Request $request) {
        $requestData = json_decode($request->getContent(), true);
        Log::channel('pti')->info('(apiGetPdfFile) request: '. print_r($requestData, true));
        $validator = Validator::make($requestData, [
            'so_id'             => 'required|numeric',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => []
                
            ];
            Log::channel('pti')->info('(apiGetPdfFile) response: '. print_r($response, true));
            return $response;
        }
        $signatureOrder = [
            'ma_bc' => config('pti.BHTN_MA_BC'),
            'nv' => config('pti.BHTN_NV'),
            'so_id' => $requestData['so_id'],
            'dvi_sl' => config('pti.BHTN_DVI_SL'),
            'so_id_dt' => config('pti.BHTN_SO_ID_DT'),
            'loai_in' => config('pti.BHTN_LOAI_IN'),
            'api' => env('PTI_REPORT_URL'),
        ];
        $signature = $this->signatureOrder($signatureOrder);
        if (isset($signature['code']) && $signature['code'] == config('pti.CODE_SUCCESS')) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('PTI::messages.success'),
                'data' => []
                
            ];
            $response['data']['process'] = 'done';
            $response['data']["data"] = $signature["data"];
            $response['data']["Total"] = $signature["Total"];
            $response['data']["chung_thuc"] = $signatureOrder['so_id'];
            $response['data']["code"] = '000';
            return response()->json($response);
        }
        $response = [
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => $validator->errors()->first(),
            'data' => []
            
        ];
        Log::channel('pti')->info('(apiGetPdfFile) response: '. print_r($response, true));
        return response()->json($response);
    }
    
    /**
    *
    * Signature order PTI
    * @param Array $data
    * @return Array $confirm
    */
    public function signatureOrder($data, $channel = "pti") {
        Log::channel($channel)->info('(signatureOrder) request: '. print_r($data, true));
        $signature = PTIApi::getBHTNGCN($data, $channel);
        Log::channel($channel)->info('(signatureOrder) response: '. print_r($signature, true));
        return $signature;
    }

    /**
    *
    * Confirm order PTI
    * @param Array $data
    * @return Array $confirm
    */
    public function confirmOrder($data, $channel = "pti") {
        Log::channel($channel)->info('(confirmOrder) request: '. print_r($data, true));
        $confirm = PTIApi::confirmBHTN($data, $channel);
        Log::channel($channel)->info('(confirmOrder) response: '. print_r($confirm, true));
        return $confirm;
    }

    /**
    * create new order PTI
    * @return json $response
    */
    public function orderBhtnBN(Request $request) {
        $requestData = json_decode($request->getContent(), true);
        Log::channel('pti')->info('(orderBhtnBN) request: '. print_r($requestData, true));
        $validator = Validator::make($requestData, [
            'ten'           => 'required|string|max:100',
            'dchi'          => 'required|string|max:300',
            'so_cmt'        => 'required|string|max:20',
            'phone'         => 'required|string|max:30',
            'ngay_sinh'     => 'required|string|date_format:d-m-Y',
            'tien_bh'       => 'required|numeric',
            'phi'           => 'required|numeric',
            'email'         => 'required|string|max:100',
            'goi'           => 'required|string|max:10',
            'dieuKhoan1'    => 'required|string',
            'dieuKhoan2'    => 'required|string',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'data' => [
                    'message' => $validator->errors()->first(),
                ]
                
            ];
            Log::channel('pti')->info('(orderBhtnBN) response: '. print_r($response, true));
            return response()->json($response);
        }
        $dateOfBirth = new DateTime($requestData['ngay_sinh']);
        $inputData = [
            'ten'               => $requestData['ten'],
            'dchi'              => $requestData['dchi'],
            'so_cmt'            => $requestData['so_cmt'],
            'phone'             => $requestData['phone'],
            'ngay_sinh'         => $dateOfBirth->format('Ymd'),
            'tien_bh'           => $requestData['tien_bh'],
            'phi'               => $requestData['phi'],
            'email'             => $requestData['email'],
            'ttoan'             => $requestData['phi'],
            'goi'               => $requestData['goi'],
            'dieuKhoan1'        => $requestData['dieuKhoan1'],
            'dieuKhoan2'        => $requestData['dieuKhoan2'],
        ];
        if (!empty($requestData['created_by'])) {
            $inputData['created_by'] = $requestData['created_by'];
        }
        if (!empty($requestData['pgdId']) && !empty($requestData['pgdName'])) {
            $inputData['pgdId'] = $requestData['pgdId'];
            $inputData['pgdName'] = $requestData['pgdName'];
        }
        $createOrder = $this->ptiBHTNRepo->createBN($inputData);
        if (isset($createOrder['_id'])) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('PTI::messages.success'),
                'data' => [
                    'id' => $createOrder['_id'],
                    'bankInfo' => VietQR::bankInfo(['amount' => $requestData['phi'], 'description' => $createOrder['bankRemark']])
                ]
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('PTI::messages.errors'),
                'data' => []
            ];
        }
        
        Log::channel('pti')->info('(orderBhtnBN) response: '. print_r($response, true));
        return response()->json($response);
    }

    /**
    * create new order PTI
    * @return json $response
    */
    public function callOrderBN($id, $channel = "pti") {
        Log::channel($channel)->info('(callOrderBN) request: '. $id);
        $ptiBHTN = $this->ptiBHTNRepo->getInfo($id);

        if (empty($ptiBHTN)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('PTI::messages.errors'),
                'data' => []
                
            ];
            Log::channel($channel)->info('(callOrderBN) id not found');
            Log::channel($channel)->info('(callOrderBN) response: '. print_r($response, true));
            return response()->json($response);
        }
        $ngayKtOld = $this->ptiBHTNRepo->findNgayKTByCCCD($ptiBHTN['pti_request']['so_cmt']);
        if ($ngayKtOld && strtotime($ngayKtOld) > strtotime(date("d-m-Y"))) {
            $ngayHL = date('d/m/Y', strtotime($ngayKtOld . ' +1 day'));
            $ngayKT = date("d/m/Y", strtotime($ngayKtOld . ' +1 year'));
            $ptiBHTN['pti_request']['ngay_hl'] = date("d-m-Y", strtotime($ngayKtOld . ' +1 day'));
            $ptiBHTN['pti_request']['ngay_kt'] = date("d-m-Y", strtotime($ngayKtOld . ' +1 year'));
        } else {
            $ngayHL = date("d/m/Y", strtotime("now +1 day"));
            $ngayKT = date("d/m/Y", strtotime("now +1 year"));
            $ptiBHTN['pti_request']['ngay_hl'] = date("d-m-Y", strtotime("now +1 day"));
            $ptiBHTN['pti_request']['ngay_kt'] = date("d-m-Y", strtotime("now +1 year"));
        }
        $currentTime = new DateTime();
        $inputData = [
            'so_id_kenh'        => (int)($currentTime->format('ymd') . $currentTime->format('His')),
            'ten'               => $ptiBHTN['pti_request']['ten'],
            'dchi'              => $ptiBHTN['pti_request']['dchi'],
            'so_cmt'            => $ptiBHTN['pti_request']['so_cmt'],
            'phone'             => $ptiBHTN['pti_request']['phone'],
            'ngay_sinh'         => $ptiBHTN['pti_request']['ngay_sinh'],
            'tien_bh'           => $ptiBHTN['pti_request']['tien_bh'],
            'phi'               => $ptiBHTN['pti_request']['phi'],
            'email'             => $ptiBHTN['pti_request']['email'],
            'ttoan'             => $ptiBHTN['pti_request']['ttoan'],
            'ngay_hl'           => $ngayHL,
            'ngay_kt'           => $ngayKT,
            'gio_hl'            => '00:00',
            'gio_kt'            => '23:59',
            'goi'               => $ptiBHTN['pti_request']['goi'],
            'ngay_cap'          => $currentTime->format('Ymd')
        ];
        $response = $this->createOrder($inputData, $channel);
        if (isset($response['message'])) {
            $response["data"]["message"] = $response['message'];
        }
        if (isset($response['code'])) {
            $response["data"]["code"] = $response['code'];
        }
        $response["data"]["so_id_kenh"] = $inputData['so_id_kenh'];
        $response["data"]["type"] = "BN";
        $saveOrder = $this->ptiBHTNRepo->saveBN(
            $id, 
            $response["data"], 
            $ptiBHTN['pti_request']
        );
        if ($response["data"]["process"] == "done" || $response["data"]["process"] == "confirmed") {
            $updateSuccess = $this->ptiBHTNRepo->updateSuccess($id);
        }
        Log::channel($channel)->info('(callOrderBN) response: '. print_r($response, true));
        return response()->json($response);
    }

    /**
    * KH thanh toán bảo hiểm
    * StartPoint: VPBank module
    */
    public function bhtnPayment(Request $request) {
        if ($request->getContent() == '') {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('PTI::messages.errors'),
                'data' => []
                
            ];
            Log::channel('pti')->info('(bhtnPayment) response: '. print_r($response, true));
            return response()->json($response);
        }
        $requestData = json_decode($request->getContent(), true);
        Log::channel('pti')->info('(bhtnPayment) request: '. print_r($requestData, true));
        $validator = Validator::make($requestData, [
            'masterAccountNumber'           => 'required|string',
            'amount'                        => 'required|numeric',
            'remark'                        => 'required|string',
            'transactionId'                 => 'required|string',
            'transactionDate'               => 'required|string',
            'bankName'                      => 'required|string',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => []
                
            ];
            Log::channel('pti')->info('(bhtnPayment) response: '. print_r($response, true));
            return response()->json($response);
        }
        if ($this->isExistedBankCode($requestData['transactionId'])) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "The transaction been used before",
                'data' => []
                
            ];
            Log::channel('pti')->info('(bhtnPayment) response: '. print_r($response, true));
            return response()->json($response);
        }
        $orderWaitPayment = $this->ptiBHTNRepo->getOrderWaitPayment();
        $remark = strtoupper(str_replace(' ', '', $requestData['remark']));
        $amount = $requestData['amount'];
        $transId = $requestData['transactionId'];
        $bankName = $requestData['bankName'];
        $orderInfo = null;
        foreach ($orderWaitPayment as $key => $order) {
            if (
                strpos($remark, $order['bankRemark']) !== false
                && $amount >= (int)$order['pti_request']["phi"] 
            ) {
                $orderInfo = $order;
                break;
            }
        }

        if ($orderInfo) {
            $this->ptiBHTNRepo->updatePaymentSuccess($orderInfo['_id'], $transId, $bankName);
            $transData = [
                'total'                 => $amount,
                'payment_method'        => $bankName,
                'customer_bill_name'    => !empty($orderInfo['pti_request']['ten']) ? $orderInfo['pti_request']['ten'] : "",
                'customer_bill_phone'   => !empty($orderInfo['pti_request']['phone']) ? $orderInfo['pti_request']['phone'] : "",
                'bank'                  => $bankName,
                'code_transaction_bank' => $transId,
                'goi'                   => !empty($orderInfo['pti_request']['goi']) ? $orderInfo['pti_request']['goi'] : "",
                'bhtnId'                => $orderInfo['_id'],
                'approve_note'          => "Thanh toán chuyển khoản",
                'store'                 => !empty($orderInfo['store']) ? $orderInfo['store'] : []
            ];
            $tnTransaction = $this->tranRepo->createBHTNTrans($transData);
            $tnTransactionId = '';
            $tnTransactionCode = '';
            if ($tnTransaction) {
                $tnTransactionId = $tnTransaction['_id'];
                $tnTransactionCode = $tnTransaction['code'];
            }
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('PTI::messages.success'),
                'data' => [
                    'bhtnId' => $orderInfo['_id'],
                    'transaction_id' => $tnTransactionId,
                    'transaction_code' => $tnTransactionCode
                ]
            ];
            Log::channel('pti')->info('(bhtnPayment) response: '. print_r($response, true));
            return response()->json($response);
        }

        $response = [
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => __('PTI::messages.not_found'),
            'data' => [
                'transaction_id' => '',
                'transaction_code' => ''
            ]
        ];
        Log::channel('pti')->info('(bhtnPayment) response: '. print_r($response, true));
        return response()->json($response);
    }

    /**
    * Check mã bank đã được sử dụng hay chưa
    * @param String $bankCode
    * @return boolean 
    */
    protected function isExistedBankCode($bankCode) {
        if (empty($bankCode)) {
            return false;
        }

        $transactions = $this->tranRepo->getTransByBankCode($bankCode);
        if ($transactions->count() > 0) {
            return true;
        } else {
            return false;
        }

    }

    /**
    * create new order PTI
    * @return json $response
    */
    public function reRunOrderHD($id, $channel = "pti") {
        Log::channel($channel)->info('(reRunOrderHD) request: '. $id);
        $ptiBHTN = $this->ptiBHTNRepo->getInfo($id);

        if (empty($ptiBHTN)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('PTI::messages.errors'),
                'data' => []
                
            ];
            Log::channel($channel)->info('(reRunOrderHD) id not found');
            Log::channel($channel)->info('(reRunOrderHD) response: '. print_r($response, true));
            return response()->json($response);
        }
        $ngayKtOld = $this->ptiBHTNRepo->findNgayKTByCCCD($ptiBHTN['pti_request']['so_cmt']);
        if ($ngayKtOld && strtotime($ngayKtOld) > strtotime(date("d-m-Y"))) {
            $ngayHL = date('d/m/Y', strtotime($ngayKtOld . ' +1 day'));
            $ngayKT = date("d/m/Y", strtotime($ngayKtOld . ' +1 year'));
            $ptiBHTN['pti_request']['ngay_hl'] = date("d-m-Y", strtotime($ngayKtOld . ' +1 day'));
            $ptiBHTN['pti_request']['ngay_kt'] = date("d-m-Y", strtotime($ngayKtOld . ' +1 year'));
        } else {
            $ngayHL = date("d/m/Y", strtotime("now +1 day"));
            $ngayKT = date("d/m/Y", strtotime("now +1 year"));
            $ptiBHTN['pti_request']['ngay_hl'] = date("d-m-Y", strtotime("now +1 day"));
            $ptiBHTN['pti_request']['ngay_kt'] = date("d-m-Y", strtotime("now +1 year"));
        }
        $dob = DateTime::createFromFormat('d-m-Y', $ptiBHTN['pti_request']['ngay_sinh']);
        $currentTime = new DateTime();
        $inputData = [
            'so_id_kenh'        => (int)($currentTime->format('ymd') . $currentTime->format('His')),
            'ten'               => $ptiBHTN['pti_request']['ten'],
            'dchi'              => $ptiBHTN['pti_request']['dchi'],
            'so_cmt'            => $ptiBHTN['pti_request']['so_cmt'],
            'phone'             => $ptiBHTN['pti_request']['phone'],
            'ngay_sinh'         => $dob->format('Ymd'),
            'tien_bh'           => $ptiBHTN['pti_request']['tien_bh'],
            'phi'               => $ptiBHTN['pti_request']['phi'],
            'email'             => $ptiBHTN['pti_request']['email'],
            'ttoan'             => $ptiBHTN['pti_request']['ttoan'],
            'ngay_hl'           => $ngayHL,
            'ngay_kt'           => $ngayKT,
            'gio_hl'            => '00:00',
            'gio_kt'            => '23:59',
            'goi'               => $ptiBHTN['pti_request']['goi'],
            'ngay_cap'          => $currentTime->format('Ymd')
        ];
        $response = $this->createOrder($inputData, $channel);
        if (isset($response['message'])) {
            $response["data"]["message"] = $response['message'];
        }
        if (isset($response['code'])) {
            $response["data"]["code"] = $response['code'];
        }
        $response["data"]["so_id_kenh"] = $inputData['so_id_kenh'];
        $response["data"]["type"] = "HD";
        $saveOrder = $this->ptiBHTNRepo->updateHD(
            $id, 
            $response["data"],
            $ptiBHTN['pti_request']
        );
        if (!empty($response["data"]["process"])) {
            if ($response["data"]["process"] == "done" || $response["data"]["process"] == "confirmed") {
                $updateSuccess = $this->ptiBHTNRepo->updateSuccess($id);
            } else {
                $updateError = $this->ptiBHTNRepo->updateErrors($id);
            }
        } else {
            $updateError = $this->ptiBHTNRepo->updateErrors($id);
        }

        Log::channel($channel)->info('(reRunOrderHD) response: '. print_r($response, true));
        return response()->json($response);
    }

}
