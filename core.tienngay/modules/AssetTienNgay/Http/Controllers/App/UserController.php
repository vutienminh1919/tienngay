<?php


namespace Modules\AssetTienNgay\Http\Controllers\App;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\AssetTienNgay\Http\Controllers\BaseController;
use Modules\AssetTienNgay\Http\Service\DeviceService;
use Modules\AssetTienNgay\Http\Service\GenerateQrCode;
use Modules\AssetTienNgay\Http\Service\GroupRoleService;
use Modules\AssetTienNgay\Http\Service\NotificationService;
use Modules\AssetTienNgay\Http\Service\UserService;
use Modules\AssetTienNgay\Model\DeviceAsset;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserController extends BaseController
{
    protected $userService;
    protected $deviceService;
    protected $notificationService;
    protected $groupRoleService;

    public function __construct(UserService $userService,
                                DeviceService $deviceService,
                                NotificationService $notificationService,
                                GroupRoleService $groupRoleService)
    {
        $this->userService = $userService;
        $this->deviceService = $deviceService;
        $this->notificationService = $notificationService;
        $this->groupRoleService = $groupRoleService;
    }

    /**
     * @OA\Post(
     *     path="/asset/app/login",
     *     tags={"User"},
     *     summary="Đăng nhập",
     *     description="Đăng nhập",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="email",type="string"),
     *                 @OA\Property(property="password",type="string"),
     *                 @OA\Property(property="type",type="string"),
     *                  example={"email": "thangbm@tienngay.vn", "password": "12345678", "type": "2"}
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
     *     )
     * )
     */
    public function login(Request $request)
    {
        $validate = $this->userService->validate_login($request);
        if ($validate->fails()) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validate->errors()->first()
            ]);
        }

        $data = $this->userService->check_login($request);
        if (isset($data['message'])) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $data['message']
            ]);
        } else {
            $token = $this->userService->login($data['user'], $request);
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                'token' => $token
            ]);
        }
    }


    /**
     * @OA\Post(
     *     path="/asset/app/register",
     *     tags={"User"},
     *     summary="Đăng kí",
     *     description="Đăng kí",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="email",type="string"),
     *                 @OA\Property(property="password",type="string"),
     *                 @OA\Property(property="re_password",type="string"),
     *                 @OA\Property(property="full_name",type="string"),
     *                 @OA\Property(property="phone_number",type="string"),
     *                 @OA\Property(property="type",type="string"),
     *                  example={"email": "thangbm@tienngay.vn", "password": "12345678", "re_password": "12345678","full_name": "Bùi Mạnh Thắng", "phone_number": "0359908532","type": "2"}
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
     *     )
     * )
     */
    public function register(Request $request)
    {
        $validate = $this->userService->validate_register($request);
        if ($validate->fails()) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validate->errors()->first()
            ]);
        }

        $data = $this->userService->check_register($request);
        if (isset($data['message'])) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $data['message']
            ]);
        } else {
            $token = $this->userService->register($request);
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                'token' => $token
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/asset/app/user/info",
     *     tags={"User"},
     *     summary="Info",
     *     description="Info",
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
        $user_info = $request->user_info;
        if ($user_info) {
            $user_info['password'] = !empty($user_info['password']) ? "xxxxxxxxxx" : '';
            $user_info['token_web'] = !empty($user_info['token_web']) ? "xxxxxxxxxx" : '';
            $group_role = $this->groupRoleService->getGroupRole($user_info['_id']);
            $user_info['action_ekyc'] = false;
            if (count($group_role) > 0) {
                if (in_array('van-hanh', $group_role)) {
                    $user_info['action_ekyc'] = true;
                }
            }
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $user_info
            ]);
        } else {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => BaseController::NO_DATA,
            ]);
        }
    }


    /**
     * @OA\Post(
     *     path="/asset/app/user/device",
     *     tags={"User"},
     *     summary="Gửi device thiết bị",
     *     description="Gửi device thiết bị",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="device",type="string"),
     *                  example={"device": "eEDFa5fQSfWqiEeUl7mf3c:APA91bG1npNMeb1O7vcNONnev5k89woO7sF6BkjgvSlN6CWX4hb6lg7RbIEjDSDDlb5dlflOrKGc2cgjB1352u6rKqVs6KEXkN_k-7brS951C59WcWljsGcaSP3v9dqK9ryfAac3bdGx"}
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
    public function device(Request $request)
    {
        $this->deviceService->device($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/asset/app/user/badge",
     *     tags={"User"},
     *     summary="Lấy số lượng thông báo chưa đọc",
     *     description="Gửi device thiết bị",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
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
    public function badge(Request $request)
    {
        $data = $this->notificationService->badge($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    /**
     * @OA\Post(
     *     path="/asset/app/user/notification",
     *     tags={"User"},
     *     summary="Lấy ds thông báo",
     *     description="Lấy ds thông báo",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="limit",type="number"),
     *                 @OA\Property(property="offset",type="number"),
     *                  example={"limit": "5", "offset": "0"}
     *             )
     *         ),
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
    public function notification(Request $request)
    {
        $data = $this->notificationService->notification($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    /**
     * @OA\Post(
     *     path="/asset/app/user/read_notification",
     *     tags={"User"},
     *     summary="Đọc thông báo, cập nhật trạng thái",
     *     description="Đọc thông báo",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="id",type="string",description="id thong bao"),
     *                  example={"id": "60a4d8540109d06b9f6f521a"}
     *             )
     *         ),
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
    public function read_notification(Request $request)
    {
        $this->notificationService->read_notification($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }
}
