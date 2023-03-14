<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Modules\MongodbCore\Repositories\HeyuHandoverRepository;
use Modules\MongodbCore\Repositories\HeyuStoreRepository;
use Modules\MongodbCore\Repositories\RoleRepository;
use Modules\MongodbCore\Repositories\StoreRepository;
use Modules\ViewCpanel\Http\Controllers\BaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class HeyuStoreController extends BaseController
{
    public function __construct(HeyuStoreRepository    $heyuStoreRepository,
                                RoleRepository         $roleRepository,
                                StoreRepository        $storeRepository,
                                HeyuHandoverRepository $heyuHandoverRepository)
    {
        $this->heyuStoreRepository = $heyuStoreRepository;
        $this->roleRepository = $roleRepository;
        $this->storeRepository = $storeRepository;
        $this->heyuHandoverRepository = $heyuHandoverRepository;
    }

     /**
    * Màn tất cả đồng phục
    * @param $request Illuminate\Http\Request
    * @return Renderable
    */

    public function index(Request $request)
    {
        $user = session('user');
        $userId = $user['_id'];
        $data = [];
        $dataSearch = $request->all();
        if (empty($dataSearch['store'])) {
            $dataSearch['store'] = array_column($user['pgds'], "_id");
        } else {
            $dataSearch['store'] = [$dataSearch['store']];
        }
        if(empty($user['pgds'])){
            echo "Permission denied";
            exit;
        }
        $result = $this->heyuStoreRepository->getAll($dataSearch);
        $heyu = $this->searchUniformHeyu($dataSearch['store']);
        $heyuStore = [];
        foreach ($heyu as $value) {
            $heyuStore[$value['id']] = $value;
        };
        $data['total'] = count($result);
        $data['records'] = [];
        if (!empty($result)) {
            foreach ($result->toArray() as $key => $item) {
                $data['records'][$key]['vfc'] = $item;
                $data['records'][$key]['heyu'] = isset($heyuStore[$item['store']['id']]) ? $heyuStore[$item['store']['id']] : [];
            }
            $data['records_all'] = $data['records'];
            $data['records'] = collect($data['records']);
            $data['records'] = $this->paginate($data['records']);
            $data['records']->withPath('');
            $detailHandover = [];
            $detail = [];
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
            foreach ($result as $item) {
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
            $detailHandover = [];
            $detailHandover = $this->heyuHandoverRepository->getHandoverByIdStore($dataSearch['store']);
            foreach ($detailHandover as $item) {
                if (empty($item)) {
                    continue;
                }
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
            $data['detail'] = $detail;
            $data['detailExport'] = $detailExport;
        }
        $data['searchUrl'] = route('viewcpanel::heyu.index');
        $data['cpanelURL'] = env('CPANEL_TN_PATH') . '/heyU/storage?target_url=';
        $data['cURL'] = env('CPANEL_TN_PATH');
        $data['userId'] = $user['_id'];
        $data['detailUrl'] = route('viewcpanel::heyu.detailById');
        $data['pgd'] = $user['pgds'];
        $data['exportPath'] = env('CPANEL_TN_PATH') . '/heyU/handoverCreateBill';
        $data['handoverPath'] = env('CPANEL_TN_PATH') . '/heyU/handover';
        $data['storePath'] = env('CPANEL_TN_PATH') . '/heyU/storage';
        $data['cpanelPath'] = env('CPANEL_TN_PATH');
        $data['pgd_active'] = $this->storeRepository->getActiveList();
        $data['pgd_active'] = array_column($data['pgd_active']->toArray(), "_id");
        $data['showEdit'] = $user['roles']['heyu']['showEdit'];
        $data['showStore'] = $user['roles']['heyu']['showStore'];
        $data['showHandover'] = $user['roles']['heyu']['showHandover'];
        return view('viewcpanel::heyu.store.list', $data);
    }

    /**
    * Paginate
    * @param $item, $perPage, $page, $option = []
    * @return Renderable
    */

    public function paginate($items, $perPage = 2, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /**
    * Màn tra cứu đồng phục tài xế HeyU
    * @param
    * @return Renderable
    */

    public function searchDriver()
    {

        return view('viewcpanel::heyu.store.searchDriver', [
            'getStatusHeyu' => route('viewcpanel::heyu.getStatusHeyu'),
            'cpanelPath' => env('CPANEL_TN_PATH'),
            'storagePath' => env('CPANEL_TN_PATH').'/heyU/storage',
        ]);
    }

    /**
    * Lấy thông tin tài xế heyU
    * @param $request Illuminate\Http\Request
    * @return Renderable
    */

    public function getStatusHeyu(Request $request)
    {
        $user = session('user');
        $email = $user['email'];
        $data = $request->all();
        $code = $data['code'] ?? "";
        $dataPost = [
            'code' => $code,
        ];
        $url = config('routes.heyu.store.getStatus');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        $result = Http::post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == "200") {
            return response()->json([
                "status" => BaseController::HTTP_OK,
                "message" => $result->json()['message'],
                "data" => $result->json()['data']
            ]);
        } else {
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $result->json()['message'] ?? "Thất bại",
                "data" => []
            ]);
        }
    }

    /**
    * Tra cứu thông tin đồng phục ben HeyU
    * @param $storeId = []
    * @return Renderable
    */

    public function searchUniformHeyu($storeId)
    {
        $dataPost = [
            'storeIds' => $storeId,
        ];
        $url = config('routes.heyu.store.inventory');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        $result = Http::post($url, $dataPost);
        return !empty($result->json()['data']['detailById']) ? $result->json()['data']['detailById'] : [];
    }

    /**
    * Tra cứu thông tin tài xế heyU
    * @param $request Illuminate\Http\Request
    * @return Renderable
    */

    public function inventoryHeyu(Request $request)
    {
        $data = $request->all();
        $store_id = $data['store_id'] ?? [];
        $arrStoreId = explode(',', $store_id);
        $dataPost = [
            'storeIds' => $arrStoreId,
        ];
        $url = config('routes.heyu.store.inventory');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        $result = Http::post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == "200") {
            return response()->json([
                "status" => BaseController::HTTP_OK,
                "message" => 'OK',
                "data" => $result->json()['data']
            ]);
        } elseif (!empty($result->json()['status']) && $result->json()['status'] == "300") {
            return response()->json([
                "status" => BaseController::HTTP_MULTIPLE_CHOICES,
                "message" => $result->json()['message'] ?? 'Thất bại',
                "data" => []
            ]);
        } else {
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => 'Lấy dữ liệu không thành công!',
                "data" => []
            ]);
        }
    }

    /**
    * Màn nhập kho
    * @param
    * @return Renderable
    */

    public function update()
    {
        $user = session('user');
        $userId = $user['_id'];
        if(!$user['roles']['heyu']['importHeyu']){
            echo 'Permission denied!';
            exit;
        }
        $pgd_active = $this->storeRepository->getActiveList();
        $pgd_active = array_column($pgd_active->toArray(), "_id");

        $url = route('viewcpanel::heyu.updateUniformTienngay');
        $urlHome = route('viewcpanel::heyu.index');
        return view('viewcpanel::heyu.store.update', [
            'pgd' => $user['pgds'],
            'update' => $url,
            'urlHome' => $urlHome,
            'pgd_active' => $pgd_active,
        ]);
    }

    /**
    * Nhập kho pgd Tienngay
    * @param $request Illuminate\Http\Request
    * @return Renderable
    */

    public function updateUniformTienngay(Request $request)
    {
        $user = session('user');
        $email = $user['email'];
        $data = $request->all();
        $store = $data['store_id'];
        $arrStore = explode(',', $store);
        $storeArr = [
            'id' => $arrStore[0],
            'name' => $arrStore[1]
        ];
        $coatDetail = [
            's' => $data['coat_s'] ?? 0,
            'm' => $data['coat_m'] ?? 0,
            'l' => $data['coat_l'] ?? 0,
            'xl' => $data['coat_xl'] ?? 0,
            'xxl' => $data['coat_xxl'] ?? 0,
            'xxxl' => $data['coat_xxxl'] ?? 0,
        ];
        $shirtDetail = [
            's' => $data['shirt_s'] ?? 0,
            'm' => $data['shirt_m'] ?? 0,
            'l' => $data['shirt_l'] ?? 0,
            'xl' => $data['shirt_xl'] ?? 0,
            'xxl' => $data['shirt_xxl'] ?? 0,
            'xxxl' => $data['shirt_xxxl'] ?? 0,
        ];
        $validate = Validator::make($coatDetail, [
            's' => 'regex:/^\d+$/',
            'm' => 'regex:/^\d+$/',
            'l' => 'regex:/^\d+$/',
            'xl' => 'regex:/^\d+$/',
            'xxl' => 'regex:/^\d+$/',
            'xxxl' => 'regex:/^\d+$/',
        ],
            [
                's.regex' => "Kích cỡ áo phải là số nguyên dương",
                'm.regex' => "Kích cỡ áo phải là số nguyên dương",
                'l.regex' => "Kích cỡ áo phải là số nguyên dương",
                'xl.regex' => "Kích cỡ áo phải là số nguyên dương",
                'xxl.regex' => "Kích cỡ áo phải là số nguyên dương",
                'xxxl.regex' => "Kích cỡ áo phải là số nguyên dương",

            ]);
        $validateShirt = Validator::make($shirtDetail, [
            's' => 'regex:/^\d+$/',
            'm' => 'regex:/^\d+$/',
            'l' => 'regex:/^\d+$/',
            'xl' => 'regex:/^\d+$/',
            'xxl' => 'regex:/^\d+$/',
            'xxxl' => 'regex:/^\d+$/',
        ],
            [
                's.regex' => "Kích cỡ áo phải là số nguyên dương",
                'm.regex' => "Kích cỡ áo phải là số nguyên dương",
                'l.regex' => "Kích cỡ áo phải là số nguyên dương",
                'xl.regex' => "Kích cỡ áo phải là số nguyên dương",
                'xxl.regex' => "Kích cỡ áo phải là số nguyên dương",
                'xxxl.regex' => "Kích cỡ áo phải là số nguyên dương",
            ]);




        if ($validate->fails() || $validateShirt->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first() ?? $validateShirt->errors()->first(),
            ]);
        }
        $dataPost = [
            'store' => $storeArr,
            'helmet' => $data['helmet'] ?? 0,
            'coat' => $coatDetail,
            'total_coat' => (int)$data['total_coat'],
            'shirt' => $shirtDetail,
            'total_shirt' => (int)$data['total_shirt'],
            'created_by' => $email,
            'updated_by' => $email
        ];
        $url = config('routes.heyu.store.update');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        $result = Http::post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == "200") {
            return response()->json([
                "status" => BaseController::HTTP_OK,
                "message" => 'OK',
                "data" => $result->json()['data']
            ]);
        } else {
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => 'Có lỗi xảy ra, vui lòng thử lại sau!',
                "data" => []
            ]);
        }
    }

    /**
    * Lịch sử nhập kho pgd Tienngay
    * @param $id,  $request Illuminate\Http\Request,
    * @return Renderable
    */

    public function history(Request $request, $id)
    {
        $user = session('user');
        $userId = $user['_id'];
         if(!$user['roles']['heyu']['viewHistory']){
            echo 'Permission denied!';
            exit;
        }
        $dataRequest = $request->all();
        $dataSearch = [
            'start_date' => !empty($dataRequest['start_date']) ? strtotime($dataRequest['start_date'] . "0:00:00") : "",
            'end_date' => !empty($dataRequest['end_date']) ? strtotime($dataRequest['end_date'] . "23:59:00") : "",
        ];

        $history = $this->heyuStoreRepository->getHistory($id);
        $detailHandover = $this->heyuHandoverRepository->getHandoverByIdStore([$history['store']['id']]);
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
        if ($detailHandover) {
            foreach ($detailHandover as $item) {
                $coat_s += $item['coat']['s'];
                $coat_m += $item['coat']['m'];
                $coat_l += $item['coat']['l'];
                $coat_xl += $item['coat']['xl'];
                $coat_xxl += $item['coat']['xxl'];
                $coat_xxxl += $item['coat']['xxxl'];

                $shirt_s += $item['shirt']['s'];
                $shirt_m += $item['shirt']['m'];
                $shirt_l += $item['shirt']['l'];
                $shirt_xl += $item['shirt']['xl'];
                $shirt_xxl += $item['shirt']['xxl'];
                $shirt_xxxl += $item['shirt']['xxxl'];
            }
        }
        $detailExport = [
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
        ];
//        $data['exportUrl'] = route('viewcpanel::hcns.exportExcel');
        $detail = $this->heyuStoreRepository->detailById($id);
        for ($i = count($history['logs']) - 1; $i >= 0; $i--) {
            if (!empty($dataSearch['start_date']) && !empty($dataSearch['start_date'])) {
                if (($history['logs'][$i]['created_at'] > $dataSearch['start_date']) && ($history['logs'][$i]['created_at'] < $dataSearch['end_date'])) {
                    // do nothing
                } else {
                    array_splice($history['logs'], $i, 1);
                }
            }
        }
        $store = $this->roleRepository->getStoreByUserId($userId);
        return view('viewcpanel::heyu.store.historyUniform', [
                'history' => $history['logs'] ?? [],
                'pgd' => $history['store']['name'],
                'detail' => $detail,
                'detailExport' => $detailExport,
                'searchUrl' => route('viewcpanel::heyu.history', ['id' => $id]),
            ]
        );
    }

    /**
    * Màn chỉnh sửa
    * @param $id (string)
    * @return Renderable
    */


    public function edit($id)
    {
        $user = session('user');
        if (!$user['roles']['heyu']['editHeyuStore']) {
            echo 'Permission denied!';
            exit;
        }
        $detail = $this->heyuStoreRepository->detailById($id);
        $editUrl = route('viewcpanel::heyu.editUniformTienngay');
        $urlHome = route('viewcpanel::heyu.index');
        $storagePath = env('CPANEL_TN_PATH') . '/heyU/storage';
        $cpanelPath = env('CPANEL_TN_PATH');
        return view('viewcpanel::heyu.store.edit', [
            'detail' => $detail,
            'editUrl' => $editUrl,
            'urlHome' => $urlHome,
            'storagePath' => $storagePath,
            'cpanelPath' => $cpanelPath,
        ]);
    }

     /**
    * Màn chỉnh sửa
    * @param $request Illuminate\Http\Request
    * @return Renderable
    */

    public function editUniformTienngay(Request $request)
    {
        $user = session('user');
        $email = $user['email'];
        $data = $request->all();
        $a = explode(',', $data['store_id']);
        $store_id = [
            'id' => $a[0],
            'name' => $a[1],
        ];
        $coatDetail = [
            's' => $data['coat_s'] ?? 0,
            'm' => $data['coat_m'] ?? 0,
            'l' => $data['coat_l'] ?? 0,
            'xl' => $data['coat_xl'] ?? 0,
            'xxl' => $data['coat_xxl'] ?? 0,
            'xxxl' => $data['coat_xxxl'] ?? 0,
        ];
        $shirtDetail = [
            's' => $data['shirt_s'] ?? 0,
            'm' => $data['shirt_m'] ?? 0,
            'l' => $data['shirt_l'] ?? 0,
            'xl' => $data['shirt_xl'] ?? 0,
            'xxl' => $data['shirt_xxl'] ?? 0,
            'xxxl' => $data['shirt_xxxl'] ?? 0,
        ];
        $validate = Validator::make($coatDetail, [
            's' => 'regex:/^\d+$/',
            'm' => 'regex:/^\d+$/',
            'l' => 'regex:/^\d+$/',
            'xl' => 'regex:/^\d+$/',
            'xxl' => 'regex:/^\d+$/',
            'xxxl' => 'regex:/^\d+$/',
        ],
            [
                's.regex' => "Kích cỡ áo phải là số nguyên dương",
                'm.regex' => "Kích cỡ áo phải là số nguyên dương",
                'l.regex' => "Kích cỡ áo phải là số nguyên dương",
                'xl.regex' => "Kích cỡ áo phải là số nguyên dương",
                'xxl.regex' => "Kích cỡ áo phải là số nguyên dương",
                'xxxl.regex' => "Kích cỡ áo phải là số nguyên dương",

            ]);
        $validateShirt = Validator::make($shirtDetail, [
            's' => 'regex:/^\d+$/',
            'm' => 'regex:/^\d+$/',
            'l' => 'regex:/^\d+$/',
            'xl' => 'regex:/^\d+$/',
            'xxl' => 'regex:/^\d+$/',
            'xxxl' => 'regex:/^\d+$/',
        ],
            [
                's.regex' => "Kích cỡ áo phải là số nguyên dương",
                'm.regex' => "Kích cỡ áo phải là số nguyên dương",
                'l.regex' => "Kích cỡ áo phải là số nguyên dương",
                'xl.regex' => "Kích cỡ áo phải là số nguyên dương",
                'xxl.regex' => "Kích cỡ áo phải là số nguyên dương",
                'xxxl.regex' => "Kích cỡ áo phải là số nguyên dương",
            ]);


        if ($validate->fails() || $validateShirt->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first() ?? $validateShirt->errors()->first(),
            ]);
        }
        $dataPost = [
            'id' => $data['id'],
            'store' => $store_id,
            'helmet' => $data['helmet'] ?? 0,
            'coat' => $coatDetail,
            'total_coat' => (int)$data['total_coat'],
            'shirt' => $shirtDetail,
            'total_shirt' => (int)$data['total_shirt'],
//            'created_by' => $email,
            'updated_by' => $email
        ];
        $url = config('routes.heyu.store.edit');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        $result = Http::post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == "200") {
            return response()->json([
                "status" => BaseController::HTTP_OK,
                "message" => 'OK',
                "data" => $result->json()['data']
            ]);
        } else {
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => 'Có lỗi xảy ra, vui lòng thử lại sau!',
                "data" => []
            ]);
        }

    }


}
