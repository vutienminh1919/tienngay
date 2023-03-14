<?php

namespace Modules\PTI\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\PTI\Service\PTIApi;
use Modules\MongodbCore\Repositories\Interfaces\PTIRepositoryInterface as PTIRepository;

use DateTime;

class PTIController extends BaseController
{

    /**
    * Modules\MongodbCore\Repositories\PTIRepository
    */
    private $ptiRepo;

    /**
     * @OA\Info(
     *     version="1.0",
     *     title="API PTI"
     * )
     */
    public function __construct(
        PTIRepository $ptiRepository
    ) {
        $this->ptiRepo = $ptiRepository;
    }

    /**
    * Get form input info
    * @return json $form
    */
    public function createForm() {
        Log::channel('pti')->info('(createForm) requested');
        $form = PTIApi::createForm();
        if (isset($form['code']) && $form['code'] == config('pti.CODE_SUCCESS')) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('PTI::messages.success'),
                'data' => $form['data']
                
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('PTI::messages.error'),
                'data' => []
                
            ];
        }
        Log::channel('pti')->info('(createForm) response: '. print_r($response, true));
        return response()->json($response);
    }

    /**
    * create new order PTI
    * @return json $response
    */
    public function orderByContract(Request $request) {
        $requestData = json_decode($request->getContent(), true);
        Log::channel('pti')->info('(orderByContract) request: '. print_r($requestData, true));
        $currentTime = new DateTime("NOW");
        $today = (int)($currentTime->format('Y').$currentTime->format('m').$currentTime->format('d'));
        $validator = Validator::make($requestData, [
            'btendn'        => 'required|string|max:400',
            'bdiachidn'     => 'required|string|max:400',
            'bemaildn'      => 'required|string|max:100',
            'bphonedn'      => 'required|string|max:20',
            'quan_he'       => 'required|string|max:10',
            'ten'           => 'required|string|max:100',
            'ngay_sinh'     => 'required|string|date_format:d-m-Y',
            'so_cmt'        => 'required|string|max:20',
            'email'         => 'required|string|max:100',
            'phone'         => 'required|string|max:30',
            'gioi'          => 'required|string|max:5',
            'phi_bh'        => 'required|numeric',
            'so_thang_bh'   => 'required|integer',
            'ngay_hl'       => 'required|string|date_format:d-m-Y',
            'ngay_kt'       => 'required|string|date_format:d-m-Y',
            'goi'           => 'required|string|max:10'
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => []
                
            ];
            Log::channel('pti')->info('(orderByContract) response: '. print_r($response, true));
            return response()->json($response);
        }
        $dateOfBirth = new DateTime($requestData['ngay_sinh']);
        $ngay_hl = new DateTime($requestData['ngay_hl']);
        $inputData = [
            'ten'               => $requestData['ten'],
            'dchi'              => $requestData['bdiachidn'],
            'gioi'              => $requestData['gioi'],
            'ngay_sinh'         => $dateOfBirth->format('d/m/Y'),
            'so_cmt'            => $requestData['so_cmt'],
            'phone'             => $requestData['bphonedn'],
            'email'             => $requestData['email'],
            'ngay_hl'           => $ngay_hl->format('d/m/Y'),
            'goi'               => $requestData['goi'],
            'suc_khoe'          => config('pti.SUC_KHOE'),
            'so_thang_bh'       => $requestData['so_thang_bh'],
            'qhe'               => $requestData['quan_he'],
            'ttoan'             => $requestData['phi_bh'],
            'ten_dn'            => $requestData['ten'],
            'phone_dn'          => $requestData['bphonedn'],
            'dchi_dn'           => $requestData['bdiachidn'],
            'kieu_hd'           => config('pti.KIEU_HD_G'),
            'so_hd_g'           => "",
            'ttrang'            => config('pti.TTRANG_T'),
            'so_hd'             => "",
            'so_id'             => 0,
            'so_id_d'           => "0",
            'ma_thue'           => $requestData['so_cmt'],
            'email_dn'          => $requestData['email']
        ];
        $response = $this->createOrder($inputData);
        if (isset($requestData['code_contract'])) {
            $response["data"]["code_contract"] = $requestData['code_contract'];
        }

        Log::channel('pti')->info('(orderByContract) response: '. print_r($response, true));
        return response()->json($response);
    }

    /**
    * create new order PTI
    * @return Array $response
    */
    public function createOrder($requestData) {
        Log::channel('pti')->info('(createOrder) request: '. print_r($requestData, true));
        $currentTime = new DateTime("NOW");
        $today = (int)($currentTime->format('Y').$currentTime->format('m').$currentTime->format('d'));
        $validator = Validator::make($requestData, [
            'ten'               => 'required|string|max:100',
            'dchi'              => 'required|string|max:400',
            'gioi'              => 'required|string|max:5',
            'ngay_sinh'         => 'required|string|date_format:d/m/Y',
            'so_cmt'            => 'required|string|max:20',
            'phone'             => 'required|string|max:20',
            'email'             => 'required|string|max:100',
            'ngay_hl'           => 'required|string|max:10|date_format:d/m/Y|after_or_equal:today',
            'goi'               => 'required|string|max:10',
            'suc_khoe'          => 'required|string|max:1',
            'so_thang_bh'       => 'required|integer',
            'qhe'               => 'required|string|max:10',
            'ttoan'             => 'required|numeric',
            'ten_dn'            => 'required|string|max:400',
            'ma_thue'           => 'nullable|string|max:20',
            'phone_dn'          => 'required|string|max:30',
            'dchi_dn'           => 'required|string|max:400',
            'kieu_hd'           => 'required|string|max:1',
            'so_hd_g'           => 'nullable|string|max:50',
            'ttrang'            => 'required|string|max:1',
            'so_hd'             => 'nullable|string|max:50',
            'ma_kt'             => 'string|max:30',
            'cb_ql'             => 'string|max:30',
            'so_id'             => 'required|numeric',
            'so_id_d'           => 'required|string|max:22',
            'ma_thue'           => 'required|string|max:20',
            'email_dn'          => 'required|string|max:100',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => []
                
            ];
            Log::channel('pti')->info('(createOrder) response: '. print_r($response, true));
            return $response;
        }
        $requestData['ngay_ht'] = $today;
        $requestData['nv'] = config('pti.NV');
        $requestData['dvi_sl'] = config('pti.DVI_SL');
        $order = PTIApi::createOrder($requestData);
        if (isset($order['code']) && $order['code'] == config('pti.CODE_SUCCESS')) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('PTI::messages.success'),
                'data' => $order['data'] 
            ];
            $response['data']['process'] = 'new';
            $dataConfirm = [
                'dvi_sl' => config('pti.DVI_SL'),
                'so_id' => $order['data']['so_id'],
                'so_hd' => $order['data']['so_hd'],
                'nv' => config('pti.NV')
            ];
            $confirm = $this->confirmOrder($dataConfirm);
            if (isset($confirm['code']) && $confirm['code'] == config('pti.CODE_SUCCESS')) {
                $response['data']['process'] = 'confirmed';
            }
            $signatureOrder = [
                'ma_bc' => env('PTI_MA_BC'),
                'nv' => config('pti.NV'),
                'so_id' => $order['data']['so_id'],
                'dvi_sl' => config('pti.DVI_SL'),
                'so_id_dt' => config('pti.SO_ID_DT'),
                'loai_in' => config('pti.LOAI_IN'),
                'api' => env('PTI_REPORT_URL'),

            ];
            $signature = $this->signatureOrder($signatureOrder);
            if (isset($signature['code']) && $signature['code'] == config('pti.CODE_SUCCESS')) {
                $response['data']['process'] = 'done';
                $response['data']["data"] = $signature["data"];
                $response['data']["Total"] = $signature["Total"];
                $response['data']["chung_thuc"] = $order['data']['so_id'];
                $response['data']["code"] = '000';
            }
            if ($response['data']['process'] !== 'done') {
                $response['status'] = Response::HTTP_BAD_REQUEST;
                $response['message'] = __('PTI::messages.error');
            }
            return $response;
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('PTI::messages.error'),
                'data' => []
                
            ];
        }
        Log::channel('pti')->info('(createOrder) response: '. print_r($response, true));
        return $response;
    }

    /**
    *
    * Confirm order PTI
    * @param Array $data
    * @return Array $confirm
    */
    public function confirmOrder($data) {
        Log::channel('pti')->info('(confirmOrder) request: '. print_r($data, true));
        $confirm = PTIApi::confirmOrder($data);
        Log::channel('pti')->info('(confirmOrder) response: '. print_r($confirm, true));
        return $confirm;
    }

    /**
    *
    * Signature order PTI
    * @param Array $data
    * @return Array $confirm
    */
    public function signatureOrder($data) {
        Log::channel('pti')->info('(signatureOrder) request: '. print_r($data, true));
        $signature = PTIApi::signatureOrder($data);
        Log::channel('pti')->info('(signatureOrder) response: '. print_r($signature, true));
        return $signature;
    }

    /**
    * create new order PTI
    * @return json $response
    */
    public function apiCreateOrder(Request $request) {
        $requestData = json_decode($request->getContent(), true);
        $response = $this->createOrder($requestData);
        Log::channel('pti')->info('(orderByContract) response: '. print_r($response, true));
        return response()->json($response);
    }


    /**
    * Api ký số và lấy giấy chứng nhận pdf
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
            'ma_bc' => env('PTI_MA_BC'),
            'nv' => config('pti.NV'),
            'so_id' => $requestData['so_id'],
            'dvi_sl' => config('pti.DVI_SL'),
            'so_id_dt' => config('pti.SO_ID_DT'),
            'loai_in' => config('pti.LOAI_IN'),
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
        return $response;
    }

    /**
    * create new order PTI
    * @return json $response
    */
    public function orderByBN(Request $request) {
        $requestData = json_decode($request->getContent(), true);
        Log::channel('pti')->info('(orderByContract) request: '. print_r($requestData, true));
        $currentTime = new DateTime("NOW");
        $today = (int)($currentTime->format('Y').$currentTime->format('m').$currentTime->format('d'));
        $validator = Validator::make($requestData, [
            'btendn'        => 'required|string|max:400',
            'bdiachidn'     => 'required|string|max:400',
            'bemaildn'      => 'required|string|max:100',
            'bphonedn'      => 'required|string|max:20',
            'quan_he'       => 'required|string|max:10',
            'ten'           => 'required|string|max:100',
            'ngay_sinh'     => 'required|string|date_format:d-m-Y',
            'so_cmt'        => 'required|string|max:20',
            'email'         => 'required|string|max:100',
            'phone'         => 'required|string|max:30',
            'gioi'          => 'required|string|max:5',
            'phi_bh'        => 'required|numeric',
            'so_thang_bh'   => 'required|integer',
            'ngay_hl'       => 'required|string|date_format:d-m-Y',
            'ngay_kt'       => 'required|string|date_format:d-m-Y',
            'goi'           => 'required|string|max:10'
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => []
                
            ];
            Log::channel('pti')->info('(orderByContract) response: '. print_r($response, true));
            return response()->json($response);
        }
        $dateOfBirth = new DateTime($requestData['ngay_sinh']);
        $ngay_hl = new DateTime($requestData['ngay_hl']);
        $inputData = [
            'ten'               => $requestData['ten'],
            'dchi'              => $requestData['bdiachidn'],
            'gioi'              => $requestData['gioi'],
            'ngay_sinh'         => $dateOfBirth->format('d/m/Y'),
            'so_cmt'            => $requestData['so_cmt'],
            'phone'             => $requestData['phone'],
            'email'             => $requestData['email'],
            'ngay_hl'           => $ngay_hl->format('d/m/Y'),
            'goi'               => $requestData['goi'],
            'suc_khoe'          => config('pti.SUC_KHOE'),
            'so_thang_bh'       => $requestData['so_thang_bh'],
            'qhe'               => $requestData['quan_he'],
            'ttoan'             => $requestData['phi_bh'],
            'ten_dn'            => $requestData['btendn'],
            'phone_dn'          => $requestData['bphonedn'],
            'dchi_dn'           => $requestData['bdiachidn'],
            'kieu_hd'           => config('pti.KIEU_HD_G'),
            'so_hd_g'           => "",
            'ttrang'            => config('pti.TTRANG_T'),
            'so_hd'             => "",
            'so_id'             => 0,
            'so_id_d'           => "0",
            'ma_thue'           => isset($requestData['bmathue']) ? $requestData['bmathue'] : $requestData['so_cmt'],
            'email_dn'          => $requestData['bemaildn']
        ];
        $response = $this->createOrder($inputData);
        if (isset($requestData['code_contract'])) {
            $response["data"]["code_contract"] = $requestData['code_contract'];
        }
        Log::channel('pti')->info('(orderByContract) response: '. print_r($response, true));
        return response()->json($response);
    }

}
