<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\MongodbCore\Repositories\HeyuStoreRepository;
use Modules\ViewCpanel\Http\Controllers\BaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Modules\MongodbCore\Repositories\Interfaces\RoleRepositoryInterface as RoleRepository;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface as StoreRepo;
use Modules\MongodbCore\Repositories\Interfaces\HeyuHandoverRepositoryInterface as HandoverRepo;
use CURLFile;

class HeyuHandoverController extends BaseController
{
    private $roleRepo;
    private $storeRepo;
    private $handoverRepo;

    public function __construct(
        RoleRepository      $roleRepository,
        StoreRepo           $storeRepo,
        HandoverRepo        $handoverRepo,
        HeyuStoreRepository $heyuStoreRepository
    )
    {
        $this->roleRepo = $roleRepository;
        $this->storeRepo = $storeRepo;
        $this->handoverRepo = $handoverRepo;
        $this->heyuStoreRepository = $heyuStoreRepository;
    }

    /**
     * Store new handover data into collection
     * @return Renderable
     */
    public function createBill()
    {
        Log::channel('cpanel')->info('HeyuHandover createBill');
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            echo "Bạn chưa đăng nhập";
            exit;
        }
        if (!$user['roles']['heyu']['create']) {
            echo 'Permission denied!';
            exit;
        }
        $userId = $user['_id'];
        $stores = $user['pgds'];
        $pgd_active = $this->storeRepo->getActiveList();
        $pgd_active = array_column($pgd_active->toArray(), "_id");

        return view('viewcpanel::heyuHandover.createBill', [
            'createBill' => route('viewcpanel::heyu.handover.storeBill'),
            'stores' => $stores,
            'findDriverInfoUrl' => route('viewcpanel::heyu.driverInfo'),
            'urlUpload' => route('viewcpanel::heyu.uploadImage'),
            'cpanelPath' => env('CPANEL_TN_PATH'),
            'cancelPath' => env('CPANEL_TN_PATH').'/heyU/storage',
            'pgd_active' => $pgd_active,
        ]);
    }

    /**
     * handover bill's detail
     * @return Renderable
     */
    public function detailBill($id)
    {
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            echo "Bạn chưa đăng nhập";
            exit;
        }
        $stores = array_column($user['pgds'], "_id");
        Log::channel('cpanel')->info('HeyuHandover detailBill');
        $bill = $this->handoverRepo->detail($id);
        if (!$bill) {
            abort(404);
        }
        if (!$user['roles']['heyu']['view'] || ($bill && !in_array($bill['store_id'], $stores))) {
            echo 'Permission denied!';
            exit;
        }
        $roleApprove = isset($user['roles']['heyu']['handoverApprove']) ? $user['roles']['heyu']['handoverApprove'] : false;
        $roleCancel = isset($user['roles']['heyu']['handoverCancel']) ? $user['roles']['heyu']['handoverCancel'] : false;
        return view('viewcpanel::heyuHandover.detail', [
            'detail' => $bill,
            'approve' => route('viewcpanel::heyu.handover.approve'),
            'cancel' => route('viewcpanel::heyu.handover.cancel'),
            'roleApprove' => $roleApprove,
            'roleCancel' => $roleCancel,
            'cpanelPath' => env('CPANEL_TN_PATH'),
            'handoverPath' => env('CPANEL_TN_PATH').'/heyU/handover',
        ]);
    }

    /**
     * Store new handover data into collection
     * @return Renderable
     */
    public function storeBill(Request $request)
    {
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Bạn chưa đăng nhập!"
            ];
            Log::channel('cpanel')->info('HeyuHandover storeBill response: ' . print_r($response, true));
            return response()->json($response);
        }
        if (!$user['roles']['heyu']['create']) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Bạn không có quyền tạo."
            ];
            Log::channel('cpanel')->info('HeyuHandover storeBill response: ' . print_r($response, true));
            return response()->json($response);
        }
        $data = $request->all();
        Log::channel('cpanel')->info('HeyuHandover storeBill ' . print_r($data, true));
        $messages = [
            'pgd.required' => 'Phòng giao dịch không được để trống',
            'driver_code.required' => 'Mã tài xế không được để trống',
            'driver_name.required' => 'Tên tài xế không được để trống',
            'coat.required' => 'Chưa chọn size áo khoác',
            'shirt.required' => 'Chưa chọn size áo phông',
            'url.required' => 'Chứng từ chưa được upload',
        ];

        $validator = Validator::make($data, [
            'pgd' => 'required',
            'driver_code' => 'required',
            'driver_name' => 'required',
            'coat' => 'required',
            'shirt' => 'required',
            'url' => 'required'
        ], $messages);
        if ($validator->fails()) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first()
            ];
            Log::channel('cpanel')->info('HeyuHandover storeBill response: ' . print_r($response, true));
            return response()->json($response);
        }
        $dataPost = [
            "store_id" => $data["pgd"],
            "store_name" => $this->storeRepo->getStoreName($data["pgd"]),
            "driver_code" => $data["driver_code"],
            "driver_name" => $data["driver_name"],
            "coat" => [$data["coat"] => "1"],
            "shirt" => [$data["shirt"] => "1"],
            "created_by" => $userEmail,
            "evidence" => $data["url"]
        ];
        $url = config('routes.heyu.handover.store');
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::withBody(json_encode($dataPost), 'application/json')->post($url, $dataPost);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['data']['_id'])) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('ViewCpanel::message.success'),
                'targetUrl' => route('viewcpanel::heyu.handover.detailBill', ['id' => $result->json()['data']['_id']])
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => !empty($result->json()['message']) ? $result->json()['message'] : __('ViewCpanel::message.something_errors')
            ];
        }
        Log::channel('cpanel')->info('HeyuHandover storeBill response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * Find driver's information by driver code
     * @return Renderable
     */
    public function driverInfo(Request $request)
    {
        $url = config('routes.heyu.getStatus');
        $requestData = $request->all();
        Log::channel('cpanel')->info('HeyuHandover driverInfo: ' . print_r($requestData, true));
        $validator = Validator::make($requestData, [
            'code' => 'required|string'
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'data' => [
                    'message' => $validator->errors()->first(),
                ]
            ];
            Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
            return response()->json($response);
        }
        $inputData = [
            'code' => $requestData['code'],
        ];
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($inputData, true));
        //call api
        $result = Http::withBody(json_encode($inputData), 'application/json')->post($url, $inputData);
        $data = $result->json();
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($data, true));
        if (
            !empty($data['status']) &&
            $data['status'] == Response::HTTP_OK &&
            !empty($data['handoverStatus'])
        ) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('ViewCpanel::message.success'),
                'data' => [
                    'name' => $data['data']['name']
                ]
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => !empty($result->json()['message']) ? $result->json()['message'] : __('ViewCpanel::message.something_errors'),
                'data' => [
                    'name' => !empty($data['data']['name']) ? $data['data']['name'] : ""
                ]
            ];
        }
        Log::channel('cpanel')->info('Return Response Api: ' . $url . ' ' . print_r($response, true));
        return response()->json($response);
    }

    public function uploadImage(Request $request)
    {
        $data = $request->all();
        if ($_FILES['file']['size'] > 10000000) {
            $response = array(
                'code' => 201,
                "msg" => 'Kích thước file không vượt quá 10MB',
            );
            echo json_encode($response);
            return;
        }
        $serviceUpload = env("URL_SERVICE_UPLOAD");
        $cfile = new CURLFile($_FILES['file']["tmp_name"], $_FILES['file']["type"], $_FILES['file']["name"]);
        $post = array('avatar' => $cfile);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $serviceUpload);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result1 = json_decode($result);
        $random = sha1(substr(md5(rand()), 0, 8));
        $data_con = array();
        if ($result1->path) {
            $data_con['url'] = $result1->path;
            $response = array(
                'code' => 200,
                "msg" => "success",
                'path' => $result1->path,
                'key' => $random,
                'raw_name' => $_FILES['file']['name']
            );
            echo json_encode($response);
            return;
        } else {
            $response = array(
                'code' => 201,
                "msg" => 'Upload không thành công hoặc định dạng không hợp lệ'
            );
            echo json_encode($response);
            return;
        }
    }

    /**
     * Update handover bill's status to approved
     * @return Renderable
     */
    public function approve(Request $request)
    {
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Bạn chưa đăng nhập!"
            ];
            Log::channel('cpanel')->info('HeyuHandover approve response: ' . print_r($response, true));
            return response()->json($response);
        }
        if (!$user['roles']['heyu']['handoverApprove']) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Bạn không có quyền xác nhận."
            ];
            Log::channel('cpanel')->info('HeyuHandover storeBill response: ' . print_r($response, true));
            return response()->json($response);
        }
        $data = $request->all();
        Log::channel('cpanel')->info('HeyuHandover approve ' . print_r($data, true));
        $validator = Validator::make($data, [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.something_errors'),
            ];
            Log::channel('cpanel')->info('HeyuHandover approve response: ' . print_r($response, true));
            return response()->json($response);
        }
        $dataPost = [
            "id" => $data["id"],
            "approvedBy" => $userEmail,
        ];
        $url = config('routes.heyu.handover.approve');
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::withBody(json_encode($dataPost), 'application/json')->post($url, $dataPost);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == 200) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('ViewCpanel::message.success'),
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => !empty($result->json()['message']) ? $result->json()['message'] : __('ViewCpanel::message.something_errors')
            ];
        }
        Log::channel('cpanel')->info('HeyuHandover approve response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * Update handover bill's status to cancel
     * @return Renderable
     */
    public function cancel(Request $request)
    {
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Bạn chưa đăng nhập!"
            ];
            Log::channel('cpanel')->info('HeyuHandover cancel response: ' . print_r($response, true));
            return response()->json($response);
        }
        if (!$user['roles']['heyu']['handoverCancel']) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Bạn không có quyền hủy."
            ];
            Log::channel('cpanel')->info('HeyuHandover storeBill response: ' . print_r($response, true));
            return response()->json($response);
        }
        $data = $request->all();
        Log::channel('cpanel')->info('HeyuHandover cancel ' . print_r($data, true));
        $validator = Validator::make($data, [
            'id' => 'required',
            'cancleNote' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.something_errors'),
            ];
            Log::channel('cpanel')->info('HeyuHandover cancel response: ' . print_r($response, true));
            return response()->json($response);
        }
        $dataPost = [
            "id" => $data["id"],
            "approvedBy" => $userEmail,
            "cancleNote" => $data["cancleNote"]
        ];
        $url = config('routes.heyu.handover.cancel');
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::withBody(json_encode($dataPost), 'application/json')->post($url, $dataPost);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == 200) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('ViewCpanel::message.success'),
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => !empty($result->json()['message']) ? $result->json()['message'] : __('ViewCpanel::message.something_errors')
            ];
        }
        Log::channel('cpanel')->info('HeyuHandover cancel response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * Show all handover data into collection
     * @param $request Illuminate\Http\Request
     * @return Renderable
     */

    public function index(Request $request)
    {
        $user = session('user');
        if(empty($user['pgds'])){
            echo "Permission denied !";
            exit;
        }
        $dataSearch = $request->all();
        if (empty($dataSearch['store'])) {
            $dataSearch['store'] = array_column($user['pgds'], "_id");
        } else {
            $dataSearch['store'] = [$dataSearch['store']];
        }
        $records = $this->handoverRepo->getAll($dataSearch);
        if($records) {
            $array = $records->toArray();
            $page = $array['current_page'];
            $perPage = $array['per_page'];
            $perPage = ($page - 1) * $perPage;
            $export = true;
            $records_all = $this->handoverRepo->getAll($dataSearch, $export);
            $pgd_active = $this->storeRepo->getActiveList();
            $pgd_active = array_column($pgd_active->toArray(), "_id");
            $detailStore = [];
            foreach ($dataSearch['store'] as $item) {
                $detailStore[] = $this->heyuStoreRepository->detailByStoreId($item);
            }
            $coat_s = 0;
            $coat_m = 0;
            $coat_l = 0;
            $coat_xl = 0;
            $coat_xxl = 0;
            $coat_xxxl = 0;

            $shirt_s = 0;
            $shirt_m = 0;
            $shirt_l = 0;
            $shirt_xl = 0;
            $shirt_xxl = 0;
            $shirt_xxxl = 0;
            foreach ($detailStore as $item) {
                if (empty($item)) {
                    continue;
                }
                $coat_s += $item['detail']['coat']['s'];
                $coat_m += $item['detail']['coat']['m'];
                $coat_l += $item['detail']['coat']['l'];
                $coat_xl += $item['detail']['coat']['xl'];
                $coat_xxl += $item['detail']['coat']['xxl'];
                $coat_xxxl += $item['detail']['coat']['xxxl'];
                $shirt_s += $item['detail']['shirt']['s'];
                $shirt_m += $item['detail']['shirt']['m'];
                $shirt_l += $item['detail']['shirt']['l'];
                $shirt_xl += $item['detail']['shirt']['xl'];
                $shirt_xxl += $item['detail']['shirt']['xxl'];
                $shirt_xxxl += $item['detail']['shirt']['xxxl'];
            }
            $detail = [
                'detail' => [
                    'coat' => [
                        's' => $coat_s,
                        'm' => $coat_m,
                        'l' => $coat_l,
                        'xl' => $coat_xl,
                        'xxl' => $coat_xxl,
                        'xxxl' => $coat_xxxl,
                    ],
                    'shirt' => [
                        's' => $shirt_s,
                        'm' => $shirt_m,
                        'l' => $shirt_l,
                        'xl' => $shirt_xl,
                        'xxl' => $shirt_xxl,
                        'xxxl' => $shirt_xxxl,
                    ]
                ]
            ];
            $detailHandover = [];
            $detailHandover = $this->handoverRepo->getHandoverByIdStore($dataSearch['store']);
            $coat_handover_s = 0;
            $coat_handover_m = 0;
            $coat_handover_l = 0;
            $coat_handover_xl = 0;
            $coat_handover_xxl = 0;
            $coat_handover_xxxl = 0;

            $shirt_handover_s = 0;
            $shirt_handover_m = 0;
            $shirt_handover_l = 0;
            $shirt_handover_xl = 0;
            $shirt_handover_xxl = 0;
            $shirt_handover_xxxl = 0;
            foreach ($detailHandover->toArray() as $item) {
                $coat_handover_s += $item['coat']['s'];
                $coat_handover_m += $item['coat']['m'];
                $coat_handover_l += $item['coat']['l'];
                $coat_handover_xl += $item['coat']['xl'];
                $coat_handover_xxl += $item['coat']['xxl'];
                $coat_handover_xxxl += $item['coat']['xxxl'];
                $shirt_handover_s += $item['shirt']['s'];
                $shirt_handover_m += $item['shirt']['m'];
                $shirt_handover_l += $item['shirt']['l'];
                $shirt_handover_xl += $item['shirt']['xl'];
                $shirt_handover_xxl += $item['shirt']['xxl'];
                $shirt_handover_xxxl += $item['shirt']['xxxl'];
            }
            $detailExport = [
                'coat' => [
                    's' => $coat_handover_s,
                    'm' => $coat_handover_m,
                    'l' => $coat_handover_l,
                    'xl' => $coat_handover_xl,
                    'xxl' => $coat_handover_xxl,
                    'xxxl' => $coat_handover_xxxl,
                ],
                'shirt' => [
                    's' => $shirt_handover_s,
                    'm' => $shirt_handover_m,
                    'l' => $shirt_handover_l,
                    'xl' => $shirt_handover_xl,
                    'xxl' => $shirt_handover_xxl,
                    'xxxl' => $shirt_handover_xxxl,
                ]
            ];
        }
        return view('viewcpanel::heyuHandover.list', [
            'searchUrl' => route("viewcpanel::heyu.handover.index"),
            'records' => $records,
            'dataSearch' => $dataSearch,
            'pgd' => $user['pgds'],
            'detail' => $detail,
            'detailExport' => $detailExport,
            'exportPath' => env('CPANEL_TN_PATH').'/heyU/handoverCreateBill',
            'storagePath' => env('CPANEL_TN_PATH').'/heyU/storage',
            'cpanelPath' => env('CPANEL_TN_PATH'),
            'cpanelURL' => env('CPANEL_TN_PATH') . '/heyU/storage?target_url=',
            'pgd_active' => $pgd_active,
            'records_all' => $records_all,
            'detailPath' => env('CPANEL_TN_PATH').'/heyU/handoverDetailBill/',
            'pgd_active' => $pgd_active,
            'perPage' => $perPage,
            'showStore' => $user['roles']['heyu']['showStore'],
            'showHandover' => $user['roles']['heyu']['showHandover'],

        ]);
    }
}
