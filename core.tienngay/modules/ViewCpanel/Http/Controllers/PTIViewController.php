<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Illuminate\Http\Request;
use Modules\ViewCpanel\Http\Controllers\BaseController;
use Exception;
use Illuminate\Http\Response;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Modules\MongodbCore\Repositories\Interfaces\PtiBHTNRepositoryInterface as PtiBHTNRepository;
use Modules\MongodbCore\Repositories\Interfaces\RoleRepositoryInterface as RoleRepository;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface as StoreRepository;
use Illuminate\Support\Facades\Validator;
use Modules\ViewCpanel\Service\VietQR;

class PTIViewController extends BaseController
{

    /**
    * Modules\MongodbCore\Repositories\PtiBHTNRepository
    */
    private $ptiBHTNRepository;

    /**
    * Modules\MongodbCore\Repositories\RoleRepository
    */
    private $roleRepository;

    /**
    * Modules\MongodbCore\Repositories\StoreRepository
    */
    private $storeRepo;


    public function __construct(
        PtiBHTNRepository $ptiBHTNRepository,
        StoreRepository $storeRepository,
        RoleRepository $roleRepository
    ) {
        // $this->middleware('tokenIsValid');
        $this->ptiBHTNRepository = $ptiBHTNRepository;
        $this->roleRepository = $roleRepository;
        $this->storeRepo = $storeRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function bhtnIndex()
    {   $currentTime = new DateTime('NOW');
        $results = $this->ptiBHTNRepository->getList('HD');
        $tcvStores = $this->storeRepo->getTcvStores();
        $tcvDbStores = $this->storeRepo->getTcvDbStores();
        $tcvHcmStores = $this->storeRepo->getTcvHcmStores();
        return view('viewcpanel::pti.bhtn.index', [
            'results' => $results,
            'currentTime' => $currentTime->format("Y-m"),
            'filterUrl' => route('ViewCpanel::pti.bhtn.search'),
            'exportGCN' => route('ViewCpanel::pti.bhtn.exportGCN'),
            'bn' => false,
            'hd' => true,
            'export' => false,
            'tcvStores' => $tcvStores,
            'tcvDbStores' => $tcvDbStores,
            'tcvHcmStores' => $tcvHcmStores,
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function bnIndex()
    {   $currentTime = new DateTime('NOW');
        $results = $this->ptiBHTNRepository->getList('BN');
        $tcvStores = $this->storeRepo->getTcvStores();
        $tcvDbStores = $this->storeRepo->getTcvDbStores();
        $tcvHcmStores = $this->storeRepo->getTcvHcmStores();
        return view('viewcpanel::pti.bhtn.index', [
            'results' => $results,
            'currentTime' => $currentTime->format("Y-m"),
            'filterUrl' => route('ViewCpanel::pti.bhtn.search'),
            'exportGCN' => route('ViewCpanel::pti.bhtn.exportGCN'),
            'bn' => true,
            'hd' => false,
            'export' => false,
            'createLink' => env('CPANEL_TN_PATH') . '/BaoHiemPTI/bhtnOrder',
            'tcvStores' => $tcvStores,
            'tcvDbStores' => $tcvDbStores,
            'tcvHcmStores' => $tcvHcmStores,
        ]);
    }

    /**
     * Màn đối soát
     * @return Renderable
     */
    public function doiSoatIndex()
    {
        $currentTime = new DateTime();
        $results = $this->ptiBHTNRepository->getListByMonth($currentTime->format("Y-m-d"));
        $tcvStores = $this->storeRepo->getTcvStores();
        $tcvDbStores = $this->storeRepo->getTcvDbStores();
        $tcvHcmStores = $this->storeRepo->getTcvHcmStores();
        return view('viewcpanel::pti.bhtn.index', [
            'results' => $results,
            'currentTime' => $currentTime->format("Y-m"),
            'filterUrl' => route('ViewCpanel::pti.bhtn.search'),
            'exportGCN' => route('ViewCpanel::pti.bhtn.exportGCN'),
            'bn' => false,
            'hd' => false,
            'export' => true,
            'createLink' => env('CPANEL_TN_PATH') . '/BaoHiemPTI/bhtnOrder',
            'tcvStores' => $tcvStores,
            'tcvDbStores' => $tcvDbStores,
            'tcvHcmStores' => $tcvHcmStores,
        ]);
    }

    public function search(Request $request) {
        $dataPost = $request->all();
        unset($dataPost['_token']);
        $arrSearch = [];
        foreach ($dataPost as $key => $value) {
            if ($value) {
                $arrSearch[$key] = $value;
            }
        }
        if (empty($arrSearch)) {
            $currentTime = new DateTime('NOW');
            $results = $this->ptiBHTNRepository->getListByMonth($currentTime->format("Y-m-d"));
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('ViewCpanel::message.success'),
                'data' => $results
                
            ];
            return response()->json($response);
        }
        $results = $this->ptiBHTNRepository->search($arrSearch);
        $response = [
            'status' => Response::HTTP_OK,
            'message' => __('ViewCpanel::message.success'),
            'data' => $results
            
        ];
        return response()->json($response);
    }


    public function exportGCN(Request $request) {
        $so_id = $request->input('so_id_pti');
        if ($so_id) {
            $dataPost['so_id'] = $so_id;
            $url = config('routes.pti.bhtn.apiGetPdfFile');
            Log::info('Call Api: ' . $url . ' ' . print_r([], true));
            //call api
            $result = Http::withBody( json_encode($dataPost), 'application/json')->post($url, $dataPost);

            Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));

            $targetUrl = !empty($result->json()['data']['data']) ? $result->json()['data']['data'] : NULL;
            if ($targetUrl) {
                header("Location: $targetUrl"); exit();
            }
        }
        abort(404);
    }

    /**
     * Bảo Hiểm Tai Nạn Con Người - Bán Ngoài
     * @return Renderable
     */
    public function bhtnBN(Request $request)
    {
        $id = $request->input('id');
        $order = [];
        $bankInfo = [];
        $payment = false;
        if ($id) {
            $order = $this->ptiBHTNRepository->getInfo($id);
            if (empty($order)) {
                abort(404);
            }
            $bankInfo = VietQR::bankInfo(['amount' => $order['pti_request']['phi'], 'description' => $order['bankRemark']]);
            $payment = $this->ptiBHTNRepository->checkPayment($id);
        }
        return view('viewcpanel::pti.bhtn.formbn', [
            'orderBhtnBN' => route('ViewCpanel::pti.bhtn.orderBhtnBN'),
            'order' => $order,
            'bankInfo' => $bankInfo,
            'payment' => ($payment === true) ? 'success' : 'errors',
            'checkPaymentUrl' => route('ViewCpanel::pti.bhtn.checkPayment'),
            'stores' => NULL,
            'creNewOrderUrl' => route('ViewCpanel::pti.bhtn.orderBn')
        ]);
    }

    public function orderBhtnBN(Request $request) {

        $url = config('routes.pti.bhtn.orderBhtnBN');
        $requestData = $request->all();
        Log::info('orderBhtnBN: ' . print_r($requestData, true));
        $validator = Validator::make($requestData, [
            'name'              => 'required|string|max:100',
            'address'           => 'required|string|max:300',
            'identity'          => 'required|string|max:20',
            'phone'             => 'required|string|max:30',
            'dob'               => 'required|string|date_format:Y-m-d',
            'price'             => 'required|numeric',
            'phi'               => 'required|numeric',
            'email'             => 'required|string|max:100',
            'goi'               => 'required|string|max:10',
            'dieuKhoan1'        => 'required|string',
            'dieuKhoan2'        => 'required|string',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'data' => [
                    'message' => $validator->errors()->first(),
                ]
                
            ];
            Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
            return response()->json($response);
        }
        $dateOfBirth = new DateTime($requestData['dob']);
        $inputData = [
            'ten'               => $requestData['name'],
            'dchi'              => $requestData['address'],
            'so_cmt'            => $requestData['identity'],
            'phone'             => $requestData['phone'],
            'ngay_sinh'         => $dateOfBirth->format('d-m-Y'),
            'tien_bh'           => $requestData['price'],
            'phi'               => $requestData['phi'],
            'email'             => $requestData['email'],
            'goi'               => $requestData['goi'],
            'dieuKhoan1'        => $requestData['dieuKhoan1'],
            'dieuKhoan2'        => $requestData['dieuKhoan2'],
        ];

        Log::info('Call Api: ' . $url . ' ' . print_r($inputData, true));
        //call api
        $result = Http::withBody( json_encode($inputData), 'application/json')->post($url, $inputData);

        $data = $result->json();
        if (!empty($data['data']['id'])) {
            $data['data']['targetUrl'] = route('ViewCpanel::pti.bhtn.orderBn') . '?id=' . $data['data']['id'];
        }
        Log::info('Result Api: ' . $url . ' ' . print_r($data, true));
        return response()->json($data);
    }

    public function bhtnCheckPayment(Request $request) {
        $id = $request->input('id');
        if ($id) {
            $payment = $this->ptiBHTNRepository->checkPayment($id);
            if ($payment) {
                $response = [
                    'status' => Response::HTTP_OK,
                    'payment' => 'success',
                    'id' => $id
                ];
                return response()->json($response);
            }
        }
        $response = [
            'status' => Response::HTTP_BAD_REQUEST,
            'payment' => 'errors',
            'id' => $id
            
        ];
        return response()->json($response);
    }

    /**
     * Bảo Hiểm Tai Nạn Con Người - PGD Bán Ngoài
     * @return Renderable
     */
    public function pgdBN(Request $request)
    {
        $user = session('user');
        $userId = $user['_id'];
        $id = $request->input('id');
        $order = [];
        $bankInfo = [];
        $payment = false;
        if ($id) {
            $order = $this->ptiBHTNRepository->getInfo($id);
            if (empty($order)) {
                abort(404);
            }
            $bankInfo = VietQR::bankInfo(['amount' => $order['pti_request']['phi'], 'description' => $order['bankRemark']]);
            $payment = $this->ptiBHTNRepository->checkPayment($id);
        }
        $stores = $this->roleRepository->getStoreByUserId($userId);
        return view('viewcpanel::pti.bhtn.formbn', [
            'orderBhtnBN' => route('ViewCpanel::pti.bhtn.pgdOrderBhtnBN'),
            'order' => $order,
            'bankInfo' => $bankInfo,
            'payment' => ($payment === true) ? 'success' : 'errors',
            'checkPaymentUrl' => route('ViewCpanel::pti.bhtn.checkPayment'),
            'stores' => $stores,
            'creNewOrderUrl' => route('ViewCpanel::pti.bhtn.pgdBN')
        ]);
    }

    public function pgdOrderBhtnBN(Request $request) {
        $user = session('user');
        $url = config('routes.pti.bhtn.orderBhtnBN');
        $requestData = $request->all();
        Log::info('orderBhtnBN: ' . print_r($requestData, true));
        $validator = Validator::make($requestData, [
            'name'              => 'required|string|max:100',
            'address'           => 'required|string|max:300',
            'identity'          => 'required|string|max:20',
            'phone'             => 'required|string|max:30',
            'dob'               => 'required|string|date_format:Y-m-d',
            'price'             => 'required|numeric',
            'phi'               => 'required|numeric',
            'email'             => 'required|string|max:100',
            'goi'               => 'required|string|max:10',
            'dieuKhoan1'        => 'required|string',
            'dieuKhoan2'        => 'required|string',
            'pgdId'             => 'required|string',
            'pgdName'           => 'required|string',
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'data' => [
                    'message' => $validator->errors()->first(),
                ]
                
            ];
            Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
            return response()->json($response);
        }
        $dateOfBirth = new DateTime($requestData['dob']);
        $inputData = [
            'ten'               => $requestData['name'],
            'dchi'              => $requestData['address'],
            'so_cmt'            => $requestData['identity'],
            'phone'             => $requestData['phone'],
            'ngay_sinh'         => $dateOfBirth->format('d-m-Y'),
            'tien_bh'           => $requestData['price'],
            'phi'               => $requestData['phi'],
            'email'             => $requestData['email'],
            'goi'               => $requestData['goi'],
            'dieuKhoan1'        => $requestData['dieuKhoan1'],
            'dieuKhoan2'        => $requestData['dieuKhoan2'],
            'pgdId'             => $requestData['pgdId'],
            'pgdName'           => $requestData['pgdName'],
            'created_by'        => $user['email']
        ];
        Log::info('Call Api: ' . $url . ' ' . print_r($inputData, true));
        //call api
        $result = Http::withBody( json_encode($inputData), 'application/json')->post($url, $inputData);

        $data = $result->json();
        if (!empty($data['data']['id'])) {
            $data['data']['targetUrl'] = route('ViewCpanel::pti.bhtn.pgdBN') . '?id=' . $data['data']['id'];
        }
        Log::info('Result Api: ' . $url . ' ' . print_r($data, true));
        return response()->json($data);
    }

}
