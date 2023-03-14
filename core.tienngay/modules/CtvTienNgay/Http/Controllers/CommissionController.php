<?php


namespace Modules\CtvTienNgay\Http\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\MongodbCore\Entities\Collaborator;
use Illuminate\Http\Response;
use Modules\MongodbCore\Repositories\DonVayRepository;
use Modules\MongodbCore\Repositories\CommissionSetupRepository;
use Modules\MongodbCore\Repositories\MainCommissionRepository;
use Modules\MongodbCore\Repositories\UserRepository;

class CommissionController extends Controller
{
    private $commission_setup_model;
    private $main_commission_model;
    private $user_model;

    function __construct(
        CommissionSetupRepository $commissionSetupRepository,
        MainCommissionRepository $mainCommissionRepository,
        UserRepository $userRepository
    )
    {
        $this->commission_setup_model = $commissionSetupRepository;
        $this->main_commission_model = $mainCommissionRepository;
        $this->user_model = $userRepository;
    }

    public function getMainProduct()
    {
        $product_main = $this->main_commission_model->getMainProduct();
        $group_ctv = $this->user_model->getGroupCtv();
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => "Thành công!",
            'product_main' => $product_main,
            'group_ctv' => $group_ctv,
        ]);
    }

    public function getListProduct(Request $request)
    {
        $id_product_main = $request->only('id');
        $product_list = $this->main_commission_model->getProduct($id_product_main);
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => "Thành công!",
            'product_list' => $product_list,
        ]);
    }

    public function createCommission(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title_commission' => 'required',
            'group_ctv' => 'required',
            'start_date' => 'required',

        ], [
            'title_commission.required' => "Tiêu đề không được để trống!",
            'group_ctv.required' => "Công ty áp dụng không được để trống!",
            'start_date.required' => "Thời gian bắt đầu không được để trống!",
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validate->errors()->first(),
            ]);
        }
        if (!empty($request->product_list)) {
            foreach ($request->product_list as $product) {
                if (empty($product['percent'])) {
                    $response = array(
                        'status' => Response::HTTP_BAD_REQUEST,
                        'message' => "Tỷ lệ phần trăm không được để trống!",
                    );
                    return response()->json($response);
                }
            }
        }
        $product_type_id = $request->product_type['id'];
        $count = $this->commission_setup_model->countProduct($product_type_id);
        if ($count > 0) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Tên loại hình hoa hồng đã tồn tại, cần block trước khi tạo mới!",
            ];
            return response()->json($response);
        }
        $data = $this->commission_setup_model->create($request->all());
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => "Cài đặt hoa hồng thành công!",
            'data' => $product_type_id
        ]);
    }

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/get_list_commission",
     *     tags={"Commission"},
     *     summary="Danh sách hoa hồng",
     *     description="Danh sách hoa hồng",
     *     @OA\Response(
     *         response=401,
     *         description="failed",
     *     ),
     * )
     */
    public function getAllCommission(Request $request)
    {
        $commission = $this->commission_setup_model->getAllCommission();
        return BaseController::send_response(BaseController::HTTP_OK, BaseController::SUCCESS, $commission);
    }
}
