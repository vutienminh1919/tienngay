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
use Modules\MongodbCore\Entities\Lead;

class UserController extends BaseController
{
    /**
     * @OA\Get (
     *     path="/ctv-tienngay/app/user/info",
     *     tags={"User"},
     *     summary="Info user",
     *     description="Info user",
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
    public function info(Request $request)
    {
        $user = $request->user_info;
        if ($user['password']) {
            $user['password'] = 'xxxxxx';
        }
        if (!empty($user['manager_id'])) {
            $manager = Collaborator::where('_id', $user['manager_id'])->first();
            if ($manager && $manager['ctv_company']) {
                $user['ctv_company'] = $manager['ctv_company'];
            }
        }
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $user);
    }

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/app/user/identity",
     *     tags={"User"},
     *     summary="Xác thực chứng từ",
     *     description="Xác thực chứng từ",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="image_cmt_mattruoc",type="string", description="image_cmt_mattruoc"),
     *                 @OA\Property(property="image_cmt_matsau",type="string", description="image_cmt_matsau"),
     *                 @OA\Property(property="photo",type="string", description="Ảnh chân dung"),
     *                  example={"image_cmt_mattruoc": "https://service.tienngay.vn/uploads/avatar/1647595332-e6c93f21bc776e414c9d2a333e0c7556.jpg","image_cmt_matsau": "https://service.tienngay.vn/uploads/avatar/1647595332-e6c93f21bc776e414c9d2a333e0c7556.jpg","photo": "https://service.tienngay.vn/uploads/avatar/1647595332-e6c93f21bc776e414c9d2a333e0c7556.jpg"}
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
    public function identity(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'image_cmt_matsau' => 'required',
            'image_cmt_mattruoc' => 'required',
            'photo' => 'required',
        ], [
            'image_cmt_matsau.required' => 'CMT mặt sau không được để trống',
            'image_cmt_mattruoc.required' => 'CMT mặt trước không được để trống',
            'photo.required' => 'Ảnh chân dung không để trống',
        ]);

        if ($validate->fails()) {
            return BaseController::send_response(self::HTTP_BAD_REQUEST, $validate->errors()->first());
        }

        if ($request->user_info->status_verified == Collaborator::VERIFIED) {
            return BaseController::send_response(self::HTTP_BAD_REQUEST, 'Tài khoản đã xác thực');
        }
        $update = [
            'image_cmt_matsau' => $request->image_cmt_matsau,
            'image_cmt_mattruoc' => $request->image_cmt_mattruoc,
            'photo' => $request->photo,
            'status_verified' => Collaborator::PENDING_VERIFY
        ];
        Collaborator::where('_id', $request->user_info->_id)->update($update);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS);
    }

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/app/user/add_bank_payment",
     *     tags={"User"},
     *     summary="Cập nhật tài khoản thanh toán",
     *     description="Cập nhật tài khoản thanh toán",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="account",type="string", description="Số Tài khoản ngân hàng"),
     *                 @OA\Property(property="account_name",type="string", description="Tên tài khoản ngân hàng"),
     *                 @OA\Property(property="bank_code",type="string", description="Mã ngân hàng"),
     *                  example={"account_name": "Nguyen van a","account": "111111111111","bank_code": "VPB"}
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
    public function add_bank_payment(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'account_name' => 'required',
            'account' => 'required|regex:/[0-9]/',
            'bank_code' => 'required',
        ], [
            'account_name.required' => 'Tên tài khoản không được để trống',
            'account.required' => 'Số tài khoản không được để trống',
            'account.regex' => 'Số tài khoản không đúng định dạng',
            'bank_code.required' => 'Mã ngân hàng không để trống',

        ]);

        if ($validate->fails()) {
            return BaseController::send_response(self::HTTP_BAD_REQUEST, $validate->errors()->first());
        }

        $list_bank = ConfigService::get_list_bank();
        $info_bank = "";
        foreach ($list_bank as $value) {
            if ($value->code == $request->bank_code) {
                $info_bank = $value;
            }
        }

        if (empty($info_bank)) {
            return BaseController::send_response(self::HTTP_BAD_REQUEST, "Không tìm thấy ngân hàng hợp lệ");
        }

        if (!empty($request->user_info->status_verified) && $request->user_info->status_verified == Collaborator::VERIFIED) {
            if (!empty($request->user_info->ctv_name)) {
                $user_name = $request->user_info->ctv_name;
                $account_name = $request->account_name;
                if (mb_strtolower(trim($user_name), 'UTF-8') !== mb_strtolower(trim($account_name), 'UTF-8')) {
                    return BaseController::send_response(self::HTTP_BAD_REQUEST, "Tên tài khoản không khớp với thông tin xác thực");
                }
            }
        }

        $user_tk = [
            "user_id" => $request->user_info->_id,
            "name_user" => $request->account_name,
            "stk_user" => $request->account,
            "bank" => $info_bank,
            'created_at' => time()
        ];

        $model = new AccountBank();
        $model->fill($user_tk)->save();
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS);
    }

    /**
     * @OA\Get (
     *     path="/ctv-tienngay/app/user/list_bank_user",
     *     tags={"User"},
     *     summary="Danh sách tài khoản thanh toán",
     *     description="Danh sách tài khoản thanh toán",
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
    public function get_list_bank_user(Request $request)
    {
        $data = AccountBank::where('user_id', $request->user_info->_id)
            ->orderBy('created_at', 'DESC')
            ->get();

        foreach ($data as $datum) {
            $datum['stk_user'] = ConfigService::hide_number($datum['stk_user']);
        }
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/app/user/update_info",
     *     tags={"User"},
     *     summary="Cập nhật user",
     *     description="Cập nhật user",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="full_name",type="string", description="Tên khách hàng"),
     *                 @OA\Property(property="birthday",type="string", description="Ngày sinh YYYY-mm-dd"),
     *                 @OA\Property(property="email",type="string", description="email"),
     *                 @OA\Property(property="gender",type="string", description="male , female"),
     *                 @OA\Property(property="ctv_company",type="string", description="ctv_company"),
     *                  example={"full_name": "Nguyen van a","birthday": "1992-06-10","email": "example@gmail.com" , "gender": "male", "ctv_company": "xxxxx"}
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
    public function update_info(Request $request)
    {

        if (!empty($request->email)) {
            if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                return BaseController::send_response(self::HTTP_BAD_REQUEST, 'Email không đúng định dạng');
            }
        }
        $update = [
            'ctv_name' => $request->full_name ?? $request->user_info->ctv_name,
            'ctv_DOB' => $request->birthday ?? $request->user_info->ctv_DOB,
            'email' => $request->email ?? $request->user_info->email,
            'ctv_gender' => $request->gender ?? $request->user_info->ctv_gender,
            'ctv_company' => $request->ctv_company ?? ""
        ];
        Collaborator::where('_id', $request->user_info->_id)->update($update);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS);
    }

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/app/user/update_avatar",
     *     tags={"User"},
     *     summary="Cập nhật avatar",
     *     description="Cập nhật avatar",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="avatar",type="string", description="avatar"),
     *                  example={"avatar": "https://xxxxxxxxxxxxxxxxxxx"}
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
    public function update_avatar(Request $request)
    {
        $update = [
            'avatar' => $request->avatar ?? $request->user_info->avatar,
        ];
        Collaborator::where('_id', $request->user_info->_id)->update($update);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS);
    }

    /**
     * @OA\Get(
     *     path="/ctv-tienngay/app/user/doi-nhom/member",
     *     tags={"User"},
     *     summary="Danh sach thanh vien doi nhom",
     *     description="Danh sach thanh vien doi nhom",
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
    public function member(Request $request)
    {
        $limit = !empty($request->limit) ? (int)$request->limit : 5;
        $offset = !empty($request->offset) ? (int)$request->offset : 0;

        $collaborators = Collaborator::where('manager_id', $request->user_info->_id)
            ->orderBy(Collaborator::CREATED_AT, 'DESC')
            ->limit($limit)
            ->offset($offset)
            ->get();

        $data = [];
        //get account_bank
        if (!empty($collaborators)) {
            foreach ($collaborators as $collaborator) {
                $data[] = [
                    'id' => $collaborator['_id'],
                    'name' => $collaborator['ctv_name'],
                    'vi_tri' => 'Nhân viên',
                    'thoi_gian' => date('d/m/Y', $collaborator['created_at']),
                    'status' => $collaborator['status'],
                ];
            }
        }
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/app/user/doi-nhom/status_member",
     *     tags={"User"},
     *     summary="Cập nhật trạng thái member",
     *     description="Cập nhật trạng thái member",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="id",type="string", description="id member"),
     *                  example={"id": "xxxxxxxxxxxxxxxxxxx"}
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
    public function update_status_member(Request $request)
    {
        if (empty($request->id)) {
            return BaseController::send_response(self::HTTP_BAD_REQUEST, 'Không tìm thấy thành viên');
        } else {
            $member = Collaborator::where('_id', $request->id)->first();
            if (!$member) {
                return BaseController::send_response(self::HTTP_BAD_REQUEST, 'Không tìm thấy thành viên');
            } else {
                if ($member['manager_id'] != $request->user_info->_id) {
                    return BaseController::send_response(self::HTTP_BAD_REQUEST, 'Không phải nhân viên bạn quản lý');
                } elseif ($request->id == $request->user_info->_id) {
                    return BaseController::send_response(self::HTTP_BAD_REQUEST, 'Bạn không thể cập nhật trạng thái chính mình');
                }
            }

            if ($member['status'] == Collaborator::STATUS_ACTIVE) {
                $status = 'deactivate';
            } else {
                $status = 'active';
            }
            Collaborator::where('_id', $request->id)
                ->update(['status' => $status]);
            return BaseController::send_response(self::HTTP_OK, self::SUCCESS);
        }
    }

    /**
     * @OA\Get(
     *     path="/ctv-tienngay/app/user/referral_link",
     *     tags={"User"},
     *     summary="Link gioi thieu",
     *     description="Link gioi thieu",
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
    public function referral_link(Request $request)
    {
        $data = [
            'link_referral_register' => env('WEB_CTV') . 'dang-ky?id=' . $request->user_info->_id . '&phone=' . $request->user_info->ctv_phone,
            'link_referral_loan' => env('WEB_CTV') . 'don-vay?id=' . $request->user_info->_id,
        ];
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/app/user/update_password",
     *     tags={"User"},
     *     summary="Đổi mk",
     *     description="Đổi mk",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="password_old",type="string", description="mk cũ"),
     *                 @OA\Property(property="password_new",type="string", description="mk mới"),
     *                  example={"password_old": "xxxxxxxxxxxxxxxxxxx", "password_new": "xxxxxxxxxxxxxxxxxxx"}
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
    public function update_password(Request $request)
    {
        if (empty($request->password_old)) {
            return BaseController::send_response(self::HTTP_BAD_REQUEST, 'Mật khẩu cũ đang trống');
        } else {
            if (md5($request->password_old) != $request->user_info->password) {
                return BaseController::send_response(self::HTTP_BAD_REQUEST, 'Mật khẩu cũ không đúng');
            }
        }

        if (empty($request->password_new)) {
            return BaseController::send_response(self::HTTP_BAD_REQUEST, 'Mật khẩu mới đang trống');
        } else {
            if (strlen($request->password_new) < 6) {
                return BaseController::send_response(self::HTTP_BAD_REQUEST, 'Mật khẩu mới tối thiểu 6 kí tự');
            }
        }

        Collaborator::where('_id', $request->user_info->_id)
            ->update(['password' => md5($request->password_new)]);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS);
    }

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/app/user/save_device_token_user",
     *     tags={"User"},
     *     summary="Lưu device token",
     *     description="Lưu device token",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="device_token",type="string", description="device"),
     *                  example={"device_token": "xxxxxxxxxxxxxxxxxxx"}
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
    public function save_device_token_user(Request $request)
    {
        if (!empty($request->device_token)) {
            Collaborator::where('_id', $request->user_info->_id)
                ->update(['device_token_app' => $request->device_token]);
        }
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS);
    }


    /**
     * @OA\Post(
     *     path="/ctv-tienngay/app/user/doi-nhom/add-member",
     *     tags={"User"},
     *     summary="Thêm thành viên",
     *     description="Thêm thành viên",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="collaborator_member_name",type="string", description="device"),
     *                 @OA\Property(property="collaborator_member_phone",type="string", description="device"),
     *                  example={"collaborator_member_name": "xxxxxxxxxxxxxxxxxxx", "collaborator_member_phone" : "xxxxxxxxxx"}
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
    public function create_member(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'collaborator_member_name' => 'required',
            'collaborator_member_phone' => 'required|regex:/^[0-9]{10}$/'
        ], [
            'collaborator_member_name.required' => 'Bạn chưa nhập tên thành viên!',
            'collaborator_member_phone.required' => 'Bạn chưa nhập số điện thoại thành viên!',
            'collaborator_member_phone.regex' => 'Số điện thoại thành viên không đúng định dạng!'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validate->errors()->first()
            ]);
        }

        $check_phone = Collaborator::where('ctv_phone', $request->collaborator_member_phone)->first();
        if (!empty($check_phone)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Thành viên đã tồn tại!"
            ];
            return response()->json($response);
        }

        // Save
        $data = [
            Collaborator::COLUMN_CTV_NAME => $request->get('collaborator_member_name'),
            Collaborator::COLUMN_CTV_PHONE => $request->get('collaborator_member_phone'),
            Collaborator::COLUMN_CTV_PASSWORD => md5('12345678'),
            Collaborator::COLUMN_STATUS => Collaborator::STATUS_ACTIVE,
            Collaborator::COLUMN_USER_ROLE => '3',
            'account_type' => '2', // 1: tai khoan truong nhom, 2: tai khoan thanh vien
            'manager_id' => $request->user_info->_id,
            'manager_phone' => $request->user_info->ctv_phone,
            Collaborator::COLUMN_FORM => Collaborator::FORM_USER_GROUP,
            Collaborator::COLUMN_TYPE => '3', // app ctv TienNgay
            Collaborator::COLUMN_USER_TYPE => Collaborator::TYPE_COLLABORATOR_GROUP,
            Collaborator::COLUMN_STATUS_VERIFIED => Collaborator::NOT_VERIFY, // chưa xác thực
            Collaborator::CREATED_AT => time(),
            Collaborator::COLUMN_CREATED_BY => $request->user_info->ctv_phone

        ];

        $model = new Collaborator();
        $model->fill($data)->save();
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => "Thêm mới thành viên thành công!",
        ]);
    }
}
