<?php

namespace Modules\CtvTienNgay\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\MongodbCore\Entities\Collaborator;
use Modules\MongodbCore\Entities\Commission_setup;
use Modules\MongodbCore\Entities\Contract;
use Modules\MongodbCore\Entities\District;
use Illuminate\Http\Response;
use Modules\MongodbCore\Entities\Gic_plt_bn;
use Modules\MongodbCore\Entities\Lead;
use Modules\MongodbCore\Entities\Mic_tnds;
use Modules\MongodbCore\Entities\Province;
use Modules\MongodbCore\Entities\Pti_vta_bn;
use Modules\MongodbCore\Entities\Role;
use Modules\MongodbCore\Entities\User;
use Modules\MongodbCore\Entities\Vbi_sxh;
use Modules\MongodbCore\Entities\Vbi_utv;
use Modules\MongodbCore\Entities\Ward;
use Modules\MongodbCore\Entities\PtiBHTN;
use Modules\MongodbCore\Repositories\DonVayRepository;

class DonVayController extends Controller
{
    private $donvay_model;

    function __construct(DonVayRepository $donVayRepository)
    {
        $this->api = "http://127.0.0.1:8080/";
        $this->donvay_model = $donVayRepository;
    }

    /**
     * @OA\Post (
     *     path="/ctv-tienngay/get_province",
     *     tags={"Address"},
     *     summary="Ds tỉnh/ thành phố",
     *     description="Ds tỉnh/ thành phố",
     *     @OA\Response(
     *         response=200,
     *         description="successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="failed",
     *     ),
     * )
     */
    public function get_province()
    {
        $province = Province::all()->toArray();
        $result = [];
        foreach ($province as $key => $value) {
            if ($value['code'] == '01') {
                $result[] = $value;
                unset($province[$key]);
            }
            if ($value['code'] == '79') {
                $result[] = $value;
                unset($province[$key]);
            }
        }
        $responses = array(
            'status' => Response::HTTP_OK,
            'message' => "Thành công",
            'data' => array_merge($result, $province),
        );
        return response()->json($responses);
    }

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/get_district",
     *     tags={"Address"},
     *     summary="Danh sách quận huyện",
     *     description="Danh sách quận huyện",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="hk_province",type="string", description="code province"),
     *                  example={"hk_province": "89"}
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
     * )
     */
    public function get_district(Request $request)
    {
        $get_district = District::where('parent_code', $request->hk_province)->get();
        $responses = array(
            'status' => Response::HTTP_OK,
            'message' => "Thành công",
            'data' => $get_district,
        );
        return response()->json($responses);

    }

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/hk_ward",
     *     tags={"Address"},
     *     summary="Danh sách quận huyện",
     *     description="Danh sách quận huyện",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="hk_ward",type="string", description="code district"),
     *                  example={"hk_ward": "883"}
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
     * )
     */
    public function hk_ward(Request $request)
    {
        $hk_ward = Ward::where('parent_code', $request->hk_ward)->get();
        $responses = array(
            'status' => Response::HTTP_OK,
            'message' => "Thành công",
            'data' => $hk_ward,
        );
        return response()->json($responses);
    }

    public function submit_donvay(Request $request)
    {
        $check_ctv = Collaborator::where('_id', "$request->ctv_code")->first();
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
        ], [
            'fullname.required' => 'Tên không được để trống',
            'phone_number.regex' => 'Số điện thoại không đúng định dạng',
            'phone_number.required' => 'Số điện thoại không được để trống',
            'hk_province.required' => 'Tỉnh, thành phố không được để trống',
            'hk_district.required' => 'Quận, huyện không được để trống',
            'hk_ward.required' => 'Xã, phường không được để trống',
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
        $model->fill($request->all())->save();
        $responses = array(
            'status' => Response::HTTP_OK,
            'message' => "Tạo đơn vay thành công",
        );
        return response()->json($responses);


    }

    public function check_phone_introduce(Request $request)
    {
        $check_phone = User::where('phone_number', "$request->phone_introduce")->first();
        if (!empty($check_phone)) {
            $arr_store = $this->getStores_list($check_phone['id']);

            if (!empty($arr_store)) {
                $responses = array(
                    'status' => Response::HTTP_OK,
                    'data' => $arr_store[0],
                    'user' => $check_phone['email']
                );
                return response()->json($responses);
            }
        }
        return response()->json([
            'status' => Response::HTTP_BAD_REQUEST,
        ]);

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


    public function get_don_vay(Request $request)
    {
        //query
        $get_all = Lead::where('ctv_code', $request->id)->orderBy('created_at', 'desc');
        $total = $get_all->count();

        $per_page = 15;
        $page = !empty($request->page) ? $request->page : 1;

        $result = $get_all->offset(($page - 1) * $per_page)->limit($per_page)->get();
        //
        $this->insertDB_lead($result);
        if (!empty($result)) {
            $responses = array(
                'status' => Response::HTTP_OK,
                'message' => "Thành công",
                'data' => $result,
                'total' => $total,
                'per_page' => $per_page
            );
            return response()->json($responses);
        } else {
            $responses = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Không có dữ liệu",
            );
            return response()->json($responses);
        }


    }

    public static function insertDB_lead($result)
    {
        if (!empty($result)) {
            foreach ($result as $key => $value) {
                if ($value->type_finance == "10") {
                    $check_bh_pti = Pti_vta_bn::where('type_pti', 'BN')
                        ->where('customer_info.customer_phone', "$value->phone_number")
                        ->orderBy('created_at', 'desc')
                        ->select('status', 'price')
                        ->get();
                    if (!empty($check_bh_pti)) {
                        foreach ($check_bh_pti as $item) {
                            if ($item->status == 1) {
                                $value->status_web = "Thành công";
                            } elseif ($item->status == 3) {
                                $value->status_web = "Thất bại";
                            } else {
                                $value->status_web = "Đang xử lý";
                            }
                            $value->price = !empty($item->price) ? $item->price : 0;
                            $value->mahoahong = "pti-vung-tam-an";
                        }
                    }
                }
                if ($value->type_finance == "11") {

                    $check_bh_gic_plt = Gic_plt_bn::where('customer_info.customer_phone', "$value->phone_number")
                        ->select('status', 'price')
                        ->get();

                    if (!empty($check_bh_gic_plt)) {
                        foreach ($check_bh_gic_plt as $item) {
                            if ($item->status == 1) {
                                $value->status_web = "Thành công";
                            } elseif ($item->status == 3) {
                                $value->status_web = "Thất bại";
                            } else {
                                $value->status_web = "Đang xử lý";
                            }

                            $value->price = !empty($item->price) ? $item->price : 0;
                            $value->mahoahong = "bh-phuc-loc-tho";
                        }
                    }
                }

                if ($value->type_finance == "14") {
                    $check_TNDS = Mic_tnds::where('customer_info.customer_phone', "$value->phone_number")->orderBy('created_at', 'desc')->select('status', 'mic_fee')->get();
                    if (!empty($check_TNDS)) {
                        foreach ($check_TNDS as $item) {
                            if ($item->status == 1) {
                                $value->status_web = "Thành công";
                            } elseif ($item->status == 3) {
                                $value->status_web = "Thất bại";
                            } else {
                                $value->status_web = "Đang xử lý";
                            }
                            $value->price = !empty($item->mic_fee) ? $item->mic_fee : 0;
                            $value->mahoahong = "bh-tnds";
                        }
                    }
                }

                if ($value->type_finance == "12") {
                    $check_vbi_utv = Vbi_utv::where('customer_info.customer_phone', "$value->phone_number")->orderBy('created_at', 'desc')->select('status', 'fee')->get();
                    if (!empty($check_vbi_utv)) {
                        foreach ($check_vbi_utv as $item) {
                            if ($item->status == 1) {
                                $value->status_web = "Thành công";
                            } elseif ($item->status == 3) {
                                $value->status_web = "Thất bại";
                            } else {
                                $value->status_web = "Đang xử lý";
                            }

                            $value->price = !empty($item->fee) ? $item->fee : 0;
                            $value->mahoahong = "ung-thu-vu";
                        }
                    }
                }
                if ($value->type_finance == "13") {

                    $check_vbi_sxh = Vbi_sxh::where('customer_info.customer_phone', "$value->phone_number")->orderBy('created_at', 'desc')->select('status', 'fee')->get();

                    if (!empty($check_vbi_sxh)) {
                        foreach ($check_vbi_sxh as $item) {
                            if ($item->status == 1) {
                                $value->status_web = "Thành công";
                            } elseif ($item->status == 3) {
                                $value->status_web = "Thất bại";
                            } else {
                                $value->status_web = "Đang xử lý";
                            }

                            $value->price = !empty($item->fee) ? $item->fee : 0;
                            $value->mahoahong = "sot-xuat-huyet";
                        }


                    }
                }
                //COMMENT CODE KHI GOLIVE
//                if ($value->type_finance == "17") {
//                    $check_pti_bhtn = PtiBHTN::where(PtiBHTN::TYPE, PtiBHTN::TYPE_BN)
//                        ->where('pti_request.phone', "$value->phone_number")
//                        ->orderBy('created_at', 'desc')
//                        ->select('status','pti_request.phi')
//                        ->get();
//                    if (!empty($check_pti_bhtn)) {
//                        foreach ($check_pti_bhtn as $item) {
//                            if ($item->status == 'success') {
//                                $value->status_web = "Thành công";
//                            } elseif ($item->status == 'fail') {
//                                $value->status_web = "Thất bại";
//                            } else {
//                                $value->status_web = "Đang xử lý";
//                            }
//
//                            $value->price = !empty($item->pti_request['phi']) ? $item->pti_request['phi'] : 0;
//                            $value->mahoahong = "pti-tncn";
//                        }
//                    }
//                }
                //END COMMENT
                if (in_array($value->type_finance, Lead::TYPE_FINANCE_APPLY_COMMISSION_ARRAY)) {
                    $check_contract = Contract::where('customer_infor.customer_phone_number', $value->phone_number)
                        ->orderBy('created_at', 'desc')
                        ->select("status", 'loan_infor.amount_loan', 'loan_infor.type_loan', 'loan_infor.loan_product')
                        ->get();

                    if (!empty($check_contract)) {
                        foreach ($check_contract as $item) {
                            if ($item->status == 3) {
                                $value->status_web = "Thất bại";
                            } elseif ($item->status >= 17 && $item->status != 18 && $item->status != 35 && $item->status != 36) {
                                $value->status_web = "Thành công";
                            } else {
                                $value->status_web = "Đang xử lý";
                            }

                            $value->price = $item->loan_infor['amount_loan'];
                            $value->mahoahong = $item->loan_infor['type_loan']['text'];

                            if ($item->loan_infor['loan_product']['code'] == "16" || $item->loan_infor['loan_product']['code'] == "17") {
                                if ($item->loan_infor['amount_loan'] > 200000000) {
                                    $value->mahoahong = "nha-dat-2";
                                } else {
                                    $value->mahoahong = "nha-dat-1";
                                }
                            }

                        }
                    }
                }
                $tien_hoa_hong = 0;
                $log_commission_setup = "";
                if (!empty($value->mahoahong)) {
                    if ($value->mahoahong == "Cho vay" || $value->mahoahong == "Cầm cố" || $value->mahoahong == "nha-dat-2" || $value->mahoahong == "nha-dat-1") {
                        $commission_setup = Commission_setup::where('product_type.code', 'KV')->where('status', 'active')->get();
                        if ($value->mahoahong == "Cho vay") {
                            $tien_hoa_hong = $value->price * (!empty($commission_setup[0]->product_list[1]['percent']) ? $commission_setup[0]->product_list[1]['percent'] : 0) / 100;
                        }
                        if ($value->mahoahong == "Cầm cố") {
                            $tien_hoa_hong = $value->price * (!empty($commission_setup[0]->product_list[0]['percent']) ? $commission_setup[0]->product_list[0]['percent'] : 0) / 100;
                        }
                        if ($value->mahoahong == "nha-dat-1") {
                            $tien_hoa_hong = $value->price * (!empty($commission_setup[0]->product_list[2]['percent']) ? $commission_setup[0]->product_list[2]['percent'] : 0) / 100;
                        }
                        if ($value->mahoahong == "nha-dat-2") {
                            $tien_hoa_hong = $value->price * (!empty($commission_setup[0]->product_list[3]['percent']) ? $commission_setup[0]->product_list[3]['percent'] : 0) / 100;
                        }
                        $log_commission_setup = !empty($commission_setup[0]->_id) ? $commission_setup[0]->_id : "";

                    }
                    if ($value->mahoahong == "bh-phuc-loc-tho" || $value->mahoahong == "pti-vung-tam-an" || $value->mahoahong == "bh-tnds" || $value->mahoahong == "sot-xuat-huyet" || $value->mahoahong == "ung-thu-vu" || $value->mahoahong == "pti-tncn") {
                        $commission_setup = Commission_setup::where('product_type.code', 'BH')->where('status', 'active')->get();

                        if ($value->mahoahong == "pti-vung-tam-an") {
                            $tien_hoa_hong = $value->price * (!empty($commission_setup[0]->product_list[0]['percent']) ? $commission_setup[0]->product_list[0]['percent'] : 0) / 100;
                        }
                        if ($value->mahoahong == "sot-xuat-huyet") {
                            $tien_hoa_hong = $value->price * (!empty($commission_setup[0]->product_list[1]['percent']) ? $commission_setup[0]->product_list[1]['percent'] : 0) / 100;
                        }
                        if ($value->mahoahong == "bh-tnds") {
                            $tien_hoa_hong = $value->price * (!empty($commission_setup[0]->product_list[4]['percent']) ? $commission_setup[0]->product_list[4]['percent'] : 0) / 100;
                        }
                        if ($value->mahoahong == "ung-thu-vu") {
                            $tien_hoa_hong = $value->price * (!empty($commission_setup[0]->product_list[2]['percent']) ? $commission_setup[0]->product_list[2]['percent'] : 0) / 100;
                        }
                        if ($value->mahoahong == "bh-phuc-loc-tho") {
                            $tien_hoa_hong = $value->price * (!empty($commission_setup[0]->product_list[5]['percent']) ? $commission_setup[0]->product_list[5]['percent'] : 0) / 100;
                        }
//                        if ($value->mahoahong == "pti-tncn") {
//                            $tien_hoa_hong = $value->price * (!empty($commission_setup[0]->product_list[6]['percent']) ? $commission_setup[0]->product_list[6]['percent'] : 0)/100;
//                        }
                        $log_commission_setup = !empty($commission_setup[0]->_id) ? $commission_setup[0]->_id : "";
                    }

                }

                if (!empty($value->status_sale) && $value->status_sale == "19") {
                    $value->status_web = "Thất bại";
                }
                $dataUpdateLead = [
                    "status_web" => !empty($value->status_web) ? $value->status_web : "Đang xử lý",
                    'price' => !empty($value->price) ? $value->price : 0,
                    'tien_hoa_hong' => !empty($tien_hoa_hong) ? $tien_hoa_hong : 0,
                    'commission_setup_id' => !empty($log_commission_setup) ? $log_commission_setup : "",
                ];
                Lead::where('_id', $value->_id)->update($dataUpdateLead);
            }
        }
        return;

    }

    public function search_get_don_vay(Request $request)
    {
        //query
        $get_all = Lead::where('ctv_code', $request->id)->orderBy('created_at', 'desc')
            ->when(\request()->fullname, function ($query) {
                $query->where('fullname', 'LIKE', '%' . \request()->fullname . '%');
            })
            ->when(\request()->status, function ($query) {
                $query->where('status_web', request()->status);
            })
            ->when(\request()->datefrom, function ($query) {
                $query->where('created_at', ">=", request()->datefrom);
            })
            ->when(\request()->dateto, function ($query) {
                $query->where('created_at', "<=", request()->dateto);
            });

        $total = $get_all->count();

        $per_page = 15;
        $page = !empty($request->page) ? $request->page : 1;
        $result = $get_all->offset(($page - 1) * $per_page)->limit($per_page)->get();
        //
        if (!empty($result)) {
            $responses = array(
                'status' => Response::HTTP_OK,
                'message' => "Thành công",
                'data' => $result,
                'total' => $total,
                'per_page' => $per_page
            );

            return response()->json($responses);
        } else {
            $responses = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Không có dữ liệu",
            );
            return response()->json($responses);
        }
    }

    public function danh_sach_don_vay(Request $request)
    {
        //query
        $get_all = Lead::where('ctv_code', $request->id)
            ->whereIn('type_finance', ["1", "2", "3", "4", "5", "6", "7", "8", "9"])
            ->orderBy('created_at', 'desc');
        $total = $get_all->count();

        $per_page = 15;
        $page = !empty($request->page) ? $request->page : 1;
        $result = $get_all->offset(($page - 1) * $per_page)->limit($per_page)->get();
        //
        $this->insertDB_lead($result);
        if (!empty($result)) {
            $responses = array(
                'status' => Response::HTTP_OK,
                'message' => "Thành công",
                'data' => $result,
                'total' => $total,
                'per_page' => $per_page
            );
            return response()->json($responses);
        } else {
            $responses = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Không có dữ liệu",
            );
            return response()->json($responses);
        }
    }

    public function search_danhsachdonvay(Request $request)
    {
        //query
        $get_all = Lead::where('ctv_code', $request->id)
            ->whereIn('type_finance', ["1", "2", "3", "4", "5", "6", "7", "8", "9"])
            ->orderBy('created_at', 'desc')
            ->when(\request()->fullname, function ($query) {
                $query->where('fullname', 'LIKE', '%' . \request()->fullname . '%');
            })
            ->when(\request()->datefrom, function ($query) {
                $query->where('created_at', ">=", request()->datefrom);
            })
            ->when(\request()->dateto, function ($query) {
                $query->where('created_at', "<=", request()->dateto);
            });
        $total = $get_all->count();
        $per_page = 15;
        $page = !empty($request->page) ? $request->page : 1;
        $result = $get_all->offset(($page - 1) * $per_page)->limit($per_page)->get();
        //
        if (!empty($result)) {
            $responses = array(
                'status' => Response::HTTP_OK,
                'message' => "Thành công",
                'data' => $result,
                'total' => $total,
                'per_page' => $per_page
            );
            return response()->json($responses);
        } else {
            $responses = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Không có dữ liệu",
            );
            return response()->json($responses);
        }
    }

    public function danh_sach_bao_hiem(Request $request)
    {
        //query
        $get_all = Lead::where('ctv_code', $request->id)
            ->whereIn('type_finance', ["10", "12", "13", "14"])
            ->orderBy('created_at', 'desc');
        $total = $get_all->count();
        $per_page = 15;
        $page = !empty($request->page) ? $request->page : 1;
        $result = $get_all->offset(($page - 1) * $per_page)->limit($per_page)->get();
        //
        $this->insertDB_lead($result);
        if (!empty($result)) {
            $responses = array(
                'status' => Response::HTTP_OK,
                'message' => "Thành công",
                'data' => $result,
                'total' => $total,
                'per_page' => $per_page
            );
            return response()->json($responses);
        } else {
            $responses = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Không có dữ liệu",
            );
            return response()->json($responses);
        }
    }

    public function search_danhsachbaohiem(Request $request)
    {
        //query
        $get_all = Lead::where('ctv_code', $request->id)
            ->whereIn('type_finance', ["10", "12", "13", "14"])
            ->orderBy('created_at', 'desc')
            ->when(\request()->fullname, function ($query) {
                $query->where('fullname', 'LIKE', '%' . \request()->fullname . '%');
            })
            ->when(\request()->datefrom, function ($query) {
                $query->where('created_at', ">=", request()->datefrom);
            })
            ->when(\request()->dateto, function ($query) {
                $query->where('created_at', "<=", request()->dateto);
            });
        $total = $get_all->count();
        $per_page = 15;
        $page = !empty($request->page) ? $request->page : 1;
        $result = $get_all->offset(($page - 1) * $per_page)->limit($per_page)->get();
        //
        if (!empty($result)) {
            $responses = array(
                'status' => Response::HTTP_OK,
                'message' => "Thành công",
                'data' => $result,
                'total' => $total,
                'per_page' => $per_page
            );

            return response()->json($responses);
        } else {
            $responses = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Không có dữ liệu",
            );
            return response()->json($responses);
        }
    }

    public function get_all_order_loan(Request $request)
    {
        $filter = $request->only('datefrom', 'dateto', 'filter_many', 'status', 'page', 'manager_phone', 'ctv_code');
        $list_loan_order = $this->donvay_model->getAllLoanOrder($filter);
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Thành công!',
            'data' => $list_loan_order
        ]);
    }

    public function get_all_order_insurance(Request $request)
    {
        $filter = $request->only('datefrom', 'dateto', 'filter_many', 'status', 'page', 'manager_phone', 'ctv_code');
        $list_insurance_order = $this->donvay_model->getAllInsuranceOrder($filter);
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => "Thành công!",
            'data' => $list_insurance_order,
        ]);
    }

    public function get_baocao(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        //query

        if (!empty($request->chart_mm)) {
            $chart_mm = $request->chart_mm;
            $start_mm = strtotime(date("Y-$chart_mm-01") . ' 00:00:00');
            $end_mm = strtotime(date("Y-m-t 23:59:59", ($start_mm)));
        }

        if (!empty($request->chart_ds)) {
            $chart_ds = $request->chart_ds;
            $start_ds = strtotime(date("Y-$chart_ds-01") . ' 00:00:00');
            $end_ds = strtotime(date("Y-m-t 23:59:59", ($start_ds)));
        }
        if (!empty($request->chart_ns_cn)) {
            $chart_ns_cn = $request->chart_ns_cn;
            $start_ns_cn = strtotime(date("Y-$chart_ns_cn-01") . ' 00:00:00');
            $end_ns_cn = strtotime(date("Y-m-t 23:59:59", ($start_ns_cn)));
        }

        //Lấy ds ctv trong team
        $get_collaborator = Collaborator::where('manager_id', $request->id)
            ->orderBy('created_at', 'desc')->get();

        //Tổng số thành viên
        $tong_so_thanh_vien = Collaborator::where('manager_id', $request->id)->count();

        $tien_hoa_hong = 0;
        $so_tien_thanh_toan = 0;
        $tong_sp_da_tao = 0;
        $tong_sp_da_tao_thanh_cong = 0;
        $total_bh = 0;
        $total_giaingan = 0;
        $price_bh = 0;
        $price_giaingan = 0;
        $arr_bh = [];
        $arr_giaingan = [];
        $total0_gn = 0;
        $total1_gn = 0;
        $total2_gn = 0;
        $total3_gn = 0;
        $total4_gn = 0;
        $total5_gn = 0;
        $total6_gn = 0;
        $total7_gn = 0;
        $total8_gn = 0;
        $total9_gn = 0;
        $total10_gn = 0;
        $total11_gn = 0;
        $total0 = 0;
        $total1 = 0;
        $total2 = 0;
        $total3 = 0;
        $total4 = 0;
        $total5 = 0;
        $total6 = 0;
        $total7 = 0;
        $total8 = 0;
        $total9 = 0;
        $total10 = 0;
        $total11 = 0;
        $arr_canhan = [];
        if (!empty($get_collaborator)) {
            foreach ($get_collaborator as $key => $value) {

                $update = Lead::where('ctv_code', $value->_id)->get();
                $this->insertDB_lead($update);

                $query = Lead::where('ctv_code', $value->_id)->get();
                $tong_sp_da_tao += $query->count();
                $tong_sp_da_tao_thanh_cong += $query->where('status_web', 'Thành công')->count();
                $tien_hoa_hong += $query->where('status_web', 'Thành công')->sum('tien_hoa_hong');
                $so_tien_thanh_toan += $query->where('status_web', "Thành công")->where('date_pay', 'exists', true)->sum('tien_hoa_hong');


                //Tỉ lệ bán hàng theo tháng
                $query1 = $query;

                if (!empty($request->chart_mm)) {
                    $query1 = $query1->whereBetween('created_at', [$start_mm, $end_mm]);
                }

                $total_bh += $query1->whereIn('type_finance', ["5", "10", "11", "12", "13", "14"])->count();
                $total_giaingan += $query1->whereIn('type_finance', ["1", "2", "3", "4", "6", "7", "8", "9"])->count();

                //Doanh số bán hàng theo tháng
                $query2 = $query;
                if (!empty($request->chart_ds)) {
                    $query2 = $query2->whereBetween('created_at', [$start_ds, $end_ds]);
                }

                $price_bh += $query2->where('status_web', 'Thành công')->whereIn('type_finance', ["5", "10", "11", "12", "13", "14"])->sum('price');
                $price_giaingan += $query2->where('status_web', 'Thành công')->whereIn('type_finance', ["1", "2", "3", "4", "6", "7", "8", "9"])->sum('price');

                //Năng suất bán hàng năm

                $date = getdate();
                $year = $date['year'];

                for ($i = 0; $i < 12; $i++) {
                    $m = $i + 1;
                    $start = strtotime(date("$year-$m-01") . ' 00:00:00');
                    $end = strtotime(date("$year-$m-t 23:59:59", ($start)));

                    $m = $query;
                    $m = $m->whereBetween('created_at', [$start, $end]);

                    $price_bh_month = $m->where('status_web', 'Thành công')->whereIn('type_finance', ["5", "10", "11", "12", "13", "14"])->sum('price');
                    $price_giaingan_month = $m->where('status_web', 'Thành công')->whereIn('type_finance', ["1", "2", "3", "4", "6", "7", "8", "9"])->sum('price');

                    if ($i == 0) {
                        $total0 += $price_bh_month;
                        $total0_gn += $price_giaingan_month;
                    } elseif ($i == 1) {
                        $total1 += $price_bh_month;
                        $total1_gn += $price_giaingan_month;
                    } elseif ($i == 2) {
                        $total2 += $price_bh_month;
                        $total2_gn += $price_giaingan_month;
                    } elseif ($i == 3) {
                        $total3 += $price_bh_month;
                        $total3_gn += $price_giaingan_month;
                    } elseif ($i == 4) {
                        $total4 += $price_bh_month;
                        $total4_gn += $price_giaingan_month;
                    } elseif ($i == 5) {
                        $total5 += $price_bh_month;
                        $total5_gn += $price_giaingan_month;
                    } elseif ($i == 6) {
                        $total6 += $price_bh_month;
                        $total6_gn += $price_giaingan_month;
                    } elseif ($i == 7) {
                        $total7 += $price_bh_month;
                        $total7_gn += $price_giaingan_month;
                    } elseif ($i == 8) {
                        $total8 += $price_bh_month;
                        $total8_gn += $price_giaingan_month;
                    } elseif ($i == 9) {
                        $total9 += $price_bh_month;
                        $total9_gn += $price_giaingan_month;
                    } elseif ($i == 10) {
                        $total10 += $price_bh_month;
                        $total10_gn += $price_giaingan_month;
                    } elseif ($i == 11) {
                        $total11 += $price_bh_month;
                        $total11_gn += $price_giaingan_month;
                    }

                }

                //Doanh thu từng cá nhân
                $query3 = $query;
                $name = $value->ctv_name;

                if (!empty($request->chart_ns_cn)) {
                    $query3 = $query3->whereBetween('created_at', [$start_ns_cn, $end_ns_cn]);
                }

                $price_bh_cn = $query3->where('status_web', 'Thành công')->whereIn('type_finance', ["5", "10", "11", "12", "13", "14"])->sum('price');
                $price_giaingan_cn = $query3->where('status_web', 'Thành công')->whereIn('type_finance', ["1", "2", "3", "4", "6", "7", "8", "9"])->sum('price');

                $arr_canhan += ["$key" => [
                    "ten" => "$name",
                    "bao_hiem" => $price_bh_cn,
                    "giai_ngan" => $price_giaingan_cn,
                ]];

            }
        }

        $arr_bh = [$total0, $total1, $total2, $total3, $total4, $total5, $total6, $total7, $total8, $total9, $total10, $total11];
        $arr_giaingan = [$total0_gn, $total1_gn, $total2_gn, $total3_gn, $total4_gn, $total5_gn, $total6_gn, $total7_gn, $total8_gn, $total9_gn, $total10_gn, $total11_gn];
        if (!empty($get_collaborator)) {
            $responses = array(
                'status' => Response::HTTP_OK,
                'message' => "Thành công",
                'data' => $get_collaborator,
                'tong_sp_da_tao' => $tong_sp_da_tao,
                'tong_sp_da_tao_thanh_cong' => $tong_sp_da_tao_thanh_cong,
                'total_bh' => $total_bh,
                'total_giaingan' => $total_giaingan,
                'price_bh' => $price_bh,
                'price_giaingan' => $price_giaingan,
                'arr_bh' => $arr_bh,
                'arr_giaingan' => $arr_giaingan,
                'tien_hoa_hong' => $tien_hoa_hong,
                'so_tien_thanh_toan' => $so_tien_thanh_toan,
                'arr_canhan' => $arr_canhan,
                'tong_so_thanh_vien' => $tong_so_thanh_vien
            );
            return response()->json($responses);
        } else {
            $responses = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Không có dữ liệu",
            );
            return response()->json($responses);
        }

    }

    public function get_baocao_cannhan(Request $request)
    {

        $update_status = Lead::where('ctv_code', $request->id)->get();
        $this->insertDB_lead($update_status);
//        $query = Lead::where('ctv_code', $request->id)->get();
        $tong_sp_da_tao = 0;
        $tong_sp_da_tao_thanh_cong = 0;
        $so_tien_thanh_toan = 0;

        $tong_sp_da_tao += $update_status->count();
        $tong_sp_da_tao_thanh_cong += $update_status->where('status_web', 'Thành công')->count();
        $so_tien_thanh_toan += $update_status->where('status_web', "Thành công")->where('date_pay', 'exists', true)->sum('his_money');

        if (!empty($update_status)) {
            $responses = array(
                'status' => Response::HTTP_OK,
                'message' => "Thành công",
                'tong_sp_da_tao' => $tong_sp_da_tao,
                'tong_sp_da_tao_thanh_cong' => $tong_sp_da_tao_thanh_cong,
                'so_tien_thanh_toan' => $so_tien_thanh_toan,
            );
            return response()->json($responses);
        } else {
            $responses = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Không có dữ liệu",
            );
            return response()->json($responses);
        }
    }
}
