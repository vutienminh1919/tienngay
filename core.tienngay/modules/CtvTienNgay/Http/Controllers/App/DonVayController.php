<?php


namespace Modules\CtvTienNgay\Http\Controllers\App;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Modules\CtvTienNgay\Http\Controllers\BaseController;
use Modules\CtvTienNgay\Service\ConfigService;
use Modules\MongodbCore\Entities\AccountBank;
use Modules\MongodbCore\Entities\Collaborator;
use Modules\MongodbCore\Entities\Contract;
use Modules\MongodbCore\Entities\Lead;
use Modules\MongodbCore\Entities\Role;
use Modules\MongodbCore\Entities\User;

class DonVayController extends BaseController
{

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/app/don-vay/create",
     *     tags={"Loan"},
     *     summary="Tạo đơn vay",
     *     description="Tạo đơn vay",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="fullname",type="string", description="Họ và tên"),
     *                 @OA\Property(property="phone_number",type="string", description="Số điện thoại"),
     *                 @OA\Property(property="type_finance",type="string", description="Hình thức vay"),
     *                 @OA\Property(property="hk_province",type="string", description="Tỉnh thành phố"),
     *                 @OA\Property(property="hk_district",type="string", description="Quận huyện"),
     *                 @OA\Property(property="hk_ward",type="string", description="Xã phường"),
     *                  example={"fullname": "Nguyen Van A","phone_number": "0359908931","type_finance": "3","hk_province": "62","hk_district": "613","hk_ward": "23458"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function create_donvay(Request $request)
    {
        $check_ctv = $request->user_info;
        if (!empty($check_ctv)) {
            if (empty($check_ctv['status_verified']) || $check_ctv['status_verified'] != 3) {
                return response()->json([
                    'status' => Response::HTTP_BAD_REQUEST,
                    "message" => 'Vui lòng xác thực thông tin trong thông tin tài khoản!',
                ]);
            }
        }
        $validate = Validator::make($request->all(), [
            'fullname' => 'required',
            'phone_number' => 'required|regex:/^[0-9]{10}$/',
            'hk_province' => 'required',
            'hk_district' => 'required',
            'hk_ward' => 'required',
            'type_finance' => 'required',
        ], [
            'fullname.required' => 'Tên không được để trống',
            'phone_number.regex' => 'Số điện thoại không đúng định dạng',
            'phone_number.required' => 'Số điện thoại không được để trống',
            'hk_province.required' => 'Tỉnh, thành phố không được để trống',
            'hk_district.required' => 'Quận, huyện không được để trống',
            'hk_ward.required' => 'Xã, phường không được để trống',
            'type_finance.required' => 'Loại tài sản không được để trống',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
            ]);
        }
        $check_phone = Lead::where('phone_number', "$request->phone_number")->first();
        $check_phone_contract = Contract::where('customer_infor.customer_phone_number', "$request->phone_number")->first();

        if (!empty($check_phone) || !empty($check_phone_contract)) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => "Khách hàng đã có trên hệ thống",
            ]);
        }

        $model = new Lead();
        $dataCreateLead = [
            'ctv_code' => $request->user_info->_id,
            'ctv_phone' => $request->user_info->ctv_phone,
            'ctv_name' => $request->user_info->ctv_name,
            'account_type' => $request->user_info->account_type,
            'ctv_type' => $request->user_info->form,
            'fullname' => $request->fullname,
            'phone_number' => $request->phone_number,
            'type_finance' => $request->type_finance,
            'hk_province' => $request->hk_province,
            'hk_district' => $request->hk_district,
            'hk_ward' => $request->hk_ward,
            'source' => '1',
            'lead_type' => '1', // website CTV TienNgay
            'created_at' => time(),
            'status_web' => 'Đang xử lý'
        ];

        if (!empty($request->user_info->phone_introduce)) {
            $check_phone = User::where('phone_number', "$request->phone_introduce")->first();
            if (!empty($check_phone)) {
                //Check có tồn tại user của CVKD theo SĐT trên LMS để lấy id PGD và email CVKD
                $arr_store = $this->getStores_list($check_phone['id']);
                $dataCreateLead['status_sale'] = '30';
                $dataCreateLead['type'] = '1';
                $dataCreateLead['utm_source'] = "App_CTV";
                $dataCreateLead['office_at'] = time();
                $dataCreateLead['cvkd'] = $check_phone['email'];
                $dataCreateLead['id_PDG'] = $arr_store[0];

            } else {
                //Check không tồn tại user của CVKD theo SĐT trên LMS để lấy id PGD và email CVKD
                $dataCreateLead['status_sale'] = '1';
                $dataCreateLead['status'] = '1';
                $dataCreateLead['utm_source'] = "App_CTV";

            }
        } else {
            //Không có SĐT người giới thiệu
            $dataCreateLead['status_sale'] = '1';
            $dataCreateLead['status'] = '1';
            $dataCreateLead['utm_source'] = "App_CTV";
        }
        $model->fill($dataCreateLead)->save();
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS);
    }

    private function getStores_list($userId)
    {
        $roles = Role::where(array("status" => "active"))->get();
        $roleStores = array();
        if (count($roles) > 0) {
            foreach ($roles as $role) {
                if (!empty($role['users']) && count($role['users']) > 0) {
                    $arrUsers = array();
                    foreach ($role['users'] as $item) {
                        array_push($arrUsers, key($item));
                    }
                    //Check userId in list key of $users
                    if (in_array($userId, $arrUsers) == TRUE) {
                        if (!empty($role['stores'])) {
                            //Push store
                            foreach ($role['stores'] as $key => $item) {
                                array_push($roleStores, key($item));
                            }
                        }
                    }
                }
            }
        }
        return $roleStores;
    }

    /**
     * @OA\Get (
     *     path="/ctv-tienngay/app/don-vay/list",
     *     tags={"Loan"},
     *     summary="Danh sách đơn vay",
     *     description="Danh sách đơn vay",
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit",
     *         required=false,
     *         @OA\Schema(
     *             type="int",
     *             format="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="offset",
     *         required=false,
     *         @OA\Schema(
     *             type="int",
     *             format="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="option",
     *         in="query",
     *         description="1:Đang xử lý, 2:Thành công, 3: Thất bại",
     *         required=false,
     *         @OA\Schema(
     *             type="int",
     *             format="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         description="Ngày bắt đầu",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="YYYY-mm-dd"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         description="Ngày kết thúc",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="YYYY-mm-dd"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="type_finance",
     *         in="query",
     *         description="Sản phẩm / dịch vụ",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="text",
     *         in="query",
     *         description="Tên hoặc số diện thoại",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function get_don_vay(Request $request)
    {
        //query
        $limit = !empty($request->limit) ? (int)$request->limit : 5;
        $offset = !empty($request->offset) ? (int)$request->offset : 0;
        $option = !empty($request->option) ? (int)$request->option : 1;
        $start_date = !empty($request->start_date) ? strtotime($request->start_date . ' 00:00:00') : 1;
        $end_date = !empty($request->end_date) ? strtotime($request->end_date . ' 23:59:59') : time();
        $get_all = Lead::where('ctv_code', $request->user_info->_id)
            ->where('status_web', ConfigService::lead_status_web($option))
            ->whereBetween('created_at', [$start_date, $end_date]);

        if (!empty($request->type_finance)) {
            $get_all = $get_all->where('type_finance', $request->type_finance);
        }

        if (!empty($request->text)) {
            $text = $request->text;
            $get_all = $get_all->where(function ($query) use ($text) {
                return $query->where('phone_number', 'LIKE', "%$text%")
                    ->orWhere('fullname', 'LIKE', "%$text%");
            });
        }
        $get_all = $get_all
            ->orderBy(Lead::CREATED_AT, "DESC")
            ->limit($limit)
            ->offset($offset)
            ->get();
        $data = [];
        foreach ($get_all as $value) {
            $data[] = [
                [
                    'key' => 'Họ và tên',
                    'value' => $value['fullname'] ?? "",
                ],
                [
                    'key' => 'Số điện thoại',
                    'value' => $value['phone_number'] ?? "",
                ],
                [
                    'key' => 'Thời gian',
                    'value' => date('d/m/Y', $value['created_at']),
                ],
                [
                    'key' => 'Dịch vụ sản phẩm',
                    'value' => ConfigService::lead_type_finance($value['type_finance']),
                ],
                [
                    'key' => 'Số tiền',
                    'value' => number_format($value['price'] ?? 0, 0, ',', '.'),
                    'color' => 'green'
                ],
                [
                    'key' => 'Tiền hoa hồng',
                    'value' => number_format($value['tien_hoa_hong'] ?? 0, 0, ',', '.'),
                    'color' => 'red'
                ],
            ];
        }

        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    /**
     * @OA\Get (
     *     path="/ctv-tienngay/app/don-vay/transaction",
     *     tags={"Loan"},
     *     summary="Danh sách lịch sử thanh toán",
     *     description="Danh sách lịch sử thanh toán",
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit",
     *         required=false,
     *         @OA\Schema(
     *             type="int",
     *             format="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="offset",
     *         required=false,
     *         @OA\Schema(
     *             type="int",
     *             format="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="datefrom",
     *         in="query",
     *         description="Ngày bắt đầu",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="YYYY-mm-dd"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="dateto",
     *         in="query",
     *         description="Ngày kết thúc",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="YYYY-mm-dd"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="text",
     *         in="query",
     *         description="text",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function history_payment(Request $request)
    {
        $limit = !empty($request->limit) ? (int)$request->limit : 5;
        $offset = !empty($request->offset) ? (int)$request->offset : 0;
        $datefrom = !empty($request->datefrom) ? strtotime($request->datefrom) : 1;
        $dateto = !empty($request->dateto) ? strtotime($request->dateto) : Carbon::now()->unix();

        $get_all = Lead::where('ctv_code', $request->user_info->_id)
            ->whereNotNull('date_pay')
            ->whereBetween('date_pay', [$datefrom, $dateto])
//            ->whereNotNull('transaction_code')
            ->orderBy('date_pay', 'DESC')
            ->limit($limit)
            ->offset($offset)
            ->get();

        $data = [];
        //get account_bank
        if (!empty($get_all)) {
            foreach ($get_all as $lead) {
                $data[] = [
                    [
                        'key' => 'Ngân hàng',
                        'value' => !empty($lead['bank_name']) ? $lead['bank_name'] : ""
                    ],
                    [
                        'key' => 'Tài khoản',
                        'value' => !empty($lead['bank_username']) ? $lead['bank_username'] : ""
                    ],
                    [
                        'key' => 'Số tài khoản',
                        'value' => !empty($lead['bank_account']) ? ConfigService::hide_number($lead['bank_account']) : ""
                    ],
                    [
                        'key' => 'Số tiền',
                        'value' => !empty($lead['his_money']) ? number_format($lead['his_money'], 0, ',', '.') : ""
                    ],
                    [
                        'key' => 'Nội dung',
                        'value' => 'Thanh toán tiền giới thiệu ' . ConfigService::lead_type_finance($lead['type_finance']) . ' của Khách hàng ' . $lead['fullname'] . ' - ' . $lead['phone_number']
                    ],
                    [
                        'key' => 'Thời gian',
                        'value' => !empty($lead['date_pay']) ? date('d/m/Y', $lead['date_pay']) : ""
                    ],
                ];
            }
        }
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    /**
     * @OA\Get (
     *     path="/ctv-tienngay/app/don-vay/doi-nhom/don_vay_member",
     *     tags={"Loan"},
     *     summary="Danh sách đơn vay thành viên",
     *     description="Danh sách đơn vay thành viên",
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit",
     *         required=false,
     *         @OA\Schema(
     *             type="int",
     *             format="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="offset",
     *         required=false,
     *         @OA\Schema(
     *             type="int",
     *             format="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="option",
     *         in="query",
     *         description="1:Đang xử lý, 2:Thành công, 3: Thất bại",
     *         required=false,
     *         @OA\Schema(
     *             type="int",
     *             format="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         description="Ngày bắt đầu",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="YYYY-mm-dd"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         description="Ngày kết thúc",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="YYYY-mm-dd"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="type_finance",
     *         in="query",
     *         description="Sản phẩm / dịch vụ",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="text",
     *         in="query",
     *         description="Tên hoặc số diện thoại",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function get_don_vay_member(Request $request)
    {
        //query
        $limit = !empty($request->limit) ? (int)$request->limit : 5;
        $offset = !empty($request->offset) ? (int)$request->offset : 0;
        $option = !empty($request->option) ? (int)$request->option : 1;
        $start_date = !empty($request->start_date) ? strtotime($request->start_date . ' 00:00:00') : 1;
        $end_date = !empty($request->end_date) ? strtotime($request->end_date . ' 23:59:59') : time();
        $arr_member_id = Collaborator::where('manager_id', $request->user_info->_id)->pluck('_id');

        $get_all = Lead::whereIn('ctv_code', $arr_member_id)
            ->where('status_web', ConfigService::lead_status_web($option))
            ->whereBetween('created_at', [$start_date, $end_date]);

        if (!empty($request->type_finance)) {
            $get_all = $get_all->where('type_finance', $request->type_finance);
        }
        if (!empty($request->text)) {
            $text = $request->text;
            $get_all = $get_all->where(function ($query) use ($text) {
                return $query->where('phone_number', 'LIKE', "%$text%")
                    ->orWhere('fullname', 'LIKE', "%$text%");
            });
        }
        $get_all = $get_all
            ->orderby('created_at', 'DESC')
            ->limit($limit)
            ->offset($offset)
            ->get();

        $data = [];
        foreach ($get_all as $value) {
            $data[] = [
                [
                    'key' => 'Họ và tên',
                    'value' => $value['fullname'] ?? "",
                ],
                [
                    'key' => 'Số điện thoại',
                    'value' => $value['phone_number'] ?? "",
                ],
                [
                    'key' => 'Thời gian',
                    'value' => date('d/m/Y', $value['created_at']),
                ],
                [
                    'key' => 'Dịch vụ/Sản phẩm',
                    'value' => ConfigService::lead_type_finance($value['type_finance']),
                ],
                [
                    'key' => 'Số tiền',
                    'value' => number_format($value['price'] ?? 0, 0, ',', '.'),
                    'color' => 'green'
                ],
                [
                    'key' => 'Tiền hoa hồng',
                    'value' => number_format($value['tien_hoa_hong'] ?? 0, 0, ',', '.'),
                    'color' => 'red'
                ],
            ];
        }

        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    /**
     * @OA\Get(
     *     path="/ctv-tienngay/app/don-vay/doi-nhom/report_group_general",
     *     tags={"Report group"},
     *     summary="Báo cáo doi nhom chung",
     *     description="Báo cáo doi nhom chung",
     *     @OA\Response(
     *         response=200,
     *         description="successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function report_group_general(Request $request)
    {
        $arr_member_id = Collaborator::where('manager_id', $request->user_info->_id)->pluck('_id');
        $data = [];
        $data['tong_tien_thanh_toan'] = ConfigService::number_format_vn(Lead::whereIn('ctv_code', $arr_member_id)
            ->where('status_web', "Thành công")
            ->whereNotNull('date_pay')
            ->sum('tien_hoa_hong'));

        $data['tong_hoa_hong'] = ConfigService::number_format_vn(Lead::whereIn('ctv_code', $arr_member_id)
            ->where('status_web', "Thành công")
            ->sum('tien_hoa_hong'));

        $data['san_pham_da_tao'] = ConfigService::number_format_vn(Lead::whereIn('ctv_code', $arr_member_id)->count());
        $data['san_pham_da_tao_thanh_cong'] = ConfigService::number_format_vn(Lead::whereIn('ctv_code', $arr_member_id)->where('status_web', 'Thành công')->count());

        $data['tong_so_thanh_vien'] = ConfigService::number_format_vn(Collaborator::where('manager_id', $request->user_info->_id)->count());
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    /**
     * @OA\Get(
     *     path="/ctv-tienngay/app/don-vay/doi-nhom/report_by_year",
     *     tags={"Report group"},
     *     summary="Báo cáo năng suất năm",
     *     description="Báo cáo năng suất năm",
     *     @OA\Response(
     *         response=200,
     *         description="successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function report_by_year(Request $request)
    {
        $arr_member_id = Collaborator::where('manager_id', $request->user_info->_id)->pluck('_id');
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[$i]['month'] = 'T' . $i;
            $data[$i]['price_bh_month'] = 0;
            $data[$i]['price_giaingan_month'] = 0;
            $date = date('Y-' . $i . '-01');
            $start = strtotime(Carbon::parse($date)->firstOfMonth()->format('Y-m-d 00:00:00'));
            $end = strtotime(Carbon::parse($date)->lastOfMonth()->format('Y-m-d 23:59:59'));

            $lead = Lead::whereIn('ctv_code', $arr_member_id)
                ->whereBetween('created_at', [$start, $end])
                ->where('status_web', 'Thành công')
                ->select('price', 'type_finance')
                ->get();

            if (!$lead) continue;

            $data[$i]['price_bh_month'] = $lead
                ->whereIn('type_finance', ["5", "10", "11", "12", "13", "14"])
                ->sum('price');

            $data[$i]['price_giaingan_month'] = $lead
                ->whereIn('type_finance', ["1", "2", "3", "4", "6", "7", "8", "9"])
                ->sum('price');
        }
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    /**
     * @OA\Get(
     *     path="/ctv-tienngay/app/don-vay/doi-nhom/report_rate_by_month",
     *     tags={"Report group"},
     *     summary="Báo cáo tỉ lệ theo tháng",
     *     description="Báo cáo tỉ lệ theo tháng",
     *     @OA\Parameter(
     *         name="month",
     *         in="query",
     *         description="month",
     *         required=false,
     *         @OA\Schema(
     *             type="int",
     *             format="int"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function report_rate_by_month(Request $request)
    {
        $month = $request->month ?? date('m');
        $arr_member_id = Collaborator::where('manager_id', $request->user_info->_id)->pluck('_id');
        $data = [];

        $data['price_bh_month'] = 0;
        $data['price_giaingan_month'] = 0;
        $date = date('Y-' . $month . '-01');
        $start = strtotime(Carbon::parse($date)->firstOfMonth()->format('Y-m-d 00:00:00'));
        $end = strtotime(Carbon::parse($date)->lastOfMonth()->format('Y-m-d 23:59:59'));

        $lead = Lead::whereIn('ctv_code', $arr_member_id)
            ->whereBetween('created_at', [$start, $end])
            ->where('status_web', 'Thành công')
            ->select('price', 'type_finance')
            ->get();

        $data['price_bh_month'] = $lead
            ->whereIn('type_finance', ["5", "10", "11", "12", "13", "14"])
            ->sum('price');

        $data['price_giaingan_month'] = $lead
            ->whereIn('type_finance', ["1", "2", "3", "4", "6", "7", "8", "9"])
            ->sum('price');

        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    /**
     * @OA\Get(
     *     path="/ctv-tienngay/app/don-vay/doi-nhom/report_rate_month_by_member",
     *     tags={"Report group"},
     *     summary="Báo cáo năng suất thành viên",
     *     description="Báo cáo năng suất thành viên",
     *     @OA\Parameter(
     *         name="month",
     *         in="query",
     *         description="month",
     *         required=false,
     *         @OA\Schema(
     *             type="int",
     *             format="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit",
     *         required=false,
     *         @OA\Schema(
     *             type="int",
     *             format="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="offset",
     *         required=false,
     *         @OA\Schema(
     *             type="int",
     *             format="int"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function report_rate_month_by_member(Request $request)
    {
        $month = $request->month ?? date('m');
        $limit = !empty($request->limit) ? (int)$request->limit : 5;
        $offset = !empty($request->offset) ? (int)$request->offset : 0;

        $members = Collaborator::where('manager_id', $request->user_info->_id)
            ->orderBy(Collaborator::CREATED_AT, 'DESC')
            ->limit($limit)
            ->offset($offset)
            ->get();
        $date = date('Y-' . $month . '-01');
        $start = strtotime(Carbon::parse($date)->firstOfMonth()->format('Y-m-d 00:00:00'));
        $end = strtotime(Carbon::parse($date)->lastOfMonth()->format('Y-m-d 23:59:59'));
        $data = [];
        foreach ($members as $k => $member) {
            $data[$k]['id'] = $member['_id'];
            $data[$k]['name'] = $member['ctv_name'] ?? $member['ctv_phone'];
            $data[$k]['price_bh_month'] = 0;
            $data[$k]['price_giaingan_month'] = 0;
            $lead = Lead::where('ctv_code', $member['_id'])
                ->whereBetween('created_at', [$start, $end])
                ->where('status_web', 'Thành công')
                ->select('price', 'type_finance')
                ->get();

            if (!$lead) continue;
            $data[$k]['price_bh_month'] = $lead
                ->whereIn('type_finance', ["5", "10", "11", "12", "13", "14"])
                ->sum('price');

            $data[$k]['price_giaingan_month'] = $lead
                ->whereIn('type_finance', ["1", "2", "3", "4", "6", "7", "8", "9"])
                ->sum('price');
        }

        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    /**
     * @OA\Get(
     *     path="/ctv-tienngay/app/don-vay/report_general_by_user",
     *     tags={"Report"},
     *     summary="Báo cáo cá nhân",
     *     description="Báo cáo cá nhân",
     *     @OA\Response(
     *         response=200,
     *         description="successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function report_general_by_user(Request $request)
    {
        $data = [];
        $data['tong_tien_thanh_toan'] = ConfigService::number_format_vn(Lead::where('ctv_code', $request->user_info->_id)
            ->where('status_web', "Thành công")
            ->whereNotNull('date_pay')
            ->sum('tien_hoa_hong'));

        $data['tong_hoa_hong'] = ConfigService::number_format_vn(Lead::where('ctv_code', $request->user_info->_id)
            ->where('status_web', "Thành công")
            ->sum('tien_hoa_hong'));

        $data['san_pham_da_tao'] = ConfigService::number_format_vn(Lead::where('ctv_code', $request->user_info->_id)->count());
        $data['san_pham_da_tao_thanh_cong'] = ConfigService::number_format_vn(Lead::where('ctv_code', $request->user_info->_id)->where('status_web', 'Thành công')->count());

        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    /**
     * @OA\Get(
     *     path="/ctv-tienngay/app/don-vay/doi-nhom/total_member",
     *     tags={"Report group"},
     *     summary="Tổng số thành viên",
     *     description="Tổng số thành viên",
     *     @OA\Response(
     *         response=200,
     *         description="successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function total_member(Request $request)
    {

        $members = Collaborator::where('manager_id', $request->user_info->_id)
            ->count();

        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $members);
    }
}
