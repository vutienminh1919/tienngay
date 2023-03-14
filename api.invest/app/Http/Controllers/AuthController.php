<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\User;
use App\Repository\ActionRepositoryInterface;
use App\Repository\InvestorRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Service\Auth\Authorization;
use Illuminate\Support\Facades\Validator;
use App\Repository\UserRepositoryInterface;

class AuthController extends Controller
{

    /**
     * @OA\Info(
     *     version="1.0",
     *     title="API Nhà đầu tư"
     * )
     */

    /**
     * @OA\SecurityScheme(
     *   securityScheme="api_key",
     *   type="apiKey",
     *   in="header",
     *   name="Authorization"
     * )
     */
    public function __construct(
        UserRepositoryInterface $user,
        ActionRepositoryInterface $action,
        InvestorRepositoryInterface $investor
    )
    {
        $this->user_model = $user;
        $this->action_model = $action;
        $this->investor_model = $investor;
    }

    /**
     * @OA\Post(path="/auth/signin",
     *   tags={"auth"},
     *   summary="Đăng nhập",
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="email",type="string"),
     *                 @OA\Property(property="password",type="string"),
     *                  example={"email": "tungbt@tienngay.vn", "password": "12345678"}
     *             )
     *         )
     *   ),
     *   @OA\Response(response=200, description="successful operation")
     * )
     */
    public function signin(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Bạn chưa nhập email',
            'password.required' => 'Bạn chưa nhập mật khẩu',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()
            ]);
        }

        $user = $this->user_model->findOneByEmailOrPhone($request->get('email'));
        if (!$user) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Tài khoản bạn nhập không chính xác"
            ]);
        }
        if (!Hash::check($request->get('password'), $user->password)) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Tài khoản bạn nhập không chính xác"
            ]);
        }
        $info = [
            'id' => $user->id,
            'email' => $user->email,
            'phone' => $user->phone,
            'full_name' => $user->full_name,
            'email' => $user->email,
            'time' => strtotime(date("Y-m-d H:i:s"))
        ];
        $token = Authorization::generateToken($info);
        $user = $this->user_model->update($user->id, [
            'token_web' => $token
        ]);
        $response = [
            'status' => Controller::HTTP_OK,
            'message' => "Đăng nhập thành công",
            'token' => $token,
            'data' => $user,
        ];
        return response()->json($response);
    }

    public function signin_app(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required',
        ], [
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'password.required' => 'Bạn chưa nhập mật khẩu',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_UNAUTHORIZED,
                'message' => $validate->errors()->first()
            ]);
        }
        $user = $this->user_model->findOne(['phone' => $request->phone, 'status' => 'active']);
        if (!$user) {
            return response()->json([
                'status' => Controller::HTTP_UNAUTHORIZED,
                'message' => "Tài khoản bạn nhập không chính xác"
            ]);
        } else {
            if (Hash::check(($request->password), $user->password)) {
                $info = [
                    'phone' => $user->phone,
                    'full_name' => $user->full_name,
                    'time' => strtotime(date("Y-m-d H:i:s"))
                ];
                $token = Authorization::generateToken($info);
                $user = $this->user_model->update($user->id, [
                    'token_app' => $token,
                    'last_login' => date('Y-m-d H:i:s')
                ]);
                $user['password'] = !empty($user['password']) ? 'xxxxxx' : '';
                $response = [
                    'status' => Controller::HTTP_OK,
                    'message' => "Đăng nhập thành công",
                    'token' => $token,
                    'data' => $user
                ];
                return response()->json($response);
            } else {
                return response()->json([
                    'status' => Controller::HTTP_UNAUTHORIZED,
                    'message' => "Mật khẩu không chính xác"
                ]);
            }
        }
    }

    public function checkLoginApp(Request $request)
    {
        $user = $this->user_model->findOne([
            'phone' => $request->phone,
            'token_app' => $request->token_app,
            'status' => User::STATUS_ACTIVE
        ]);
        if (empty($user)) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Faild!",
            ], Controller::HTTP_OK);
        } else {
            $investor = $this->investor_model->findOne([Investor::COLUMN_USER_ID => $user->id]);
            if (!$investor) {
                return response()->json([
                    'status' => Controller::HTTP_BAD_REQUEST,
                    'message' => "Faild!",
                ], Controller::HTTP_OK);
            } else {
                return response()->json([
                    'status' => Controller::HTTP_OK,
                    'data' => $user,
                    'investor' => $investor
                ], Controller::HTTP_OK);
            }
        }
    }

    public function getProfile(Request $request)
    {
        $data = current_user();
        $data['role'] = $data->role()->get();
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $data,
        ]);
    }

    public function changePass(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password_old' => 'required',
            'password_new' => 'required|min:8|max:30',
            'password_re' => 'same:password_new'
        ], [
            'password_old.required' => 'Bạn chưa nhập mật khẩu cũ',
            'password_new.required' => 'Bạn chưa nhập mật khẩu mới',
            'password_new.min' => 'Mật khẩu có tối thiểu 8 ký tự',
            'password_new.max' => 'Mật khẩu có tối đa 30 ký tự',
            'password_re.same' => 'Mật khẩu nhập lại chưa chính xác'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()
            ]);
        }
        $data = current_user();
        if (Hash::check($request->get('password_old'), $data->password)) {
            $result = $this->user_model->update($data->id, [
                'password' => Hash::make($request->get('password_new'))
            ]);
            return response()->json([
                'status' => Controller::HTTP_OK,
                'data' => $data,
                'message' => "Cập nhật mật khẩu thành công"
            ]);
        }
        return response()->json([
            'status' => Controller::HTTP_BAD_REQUEST,
            'message' => [
                'password_old' => ['Bạn nhập mật khẩu chưa đúng']
            ]
        ]);
    }

    public function checkOtpApp(Request $request)
    {
        $user = $this->user_model->checkOtp($request->otp, $request->phone);
        if (!$user) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "OTP không đúng",
            ], Controller::HTTP_OK);
        } else {
            return response()->json([
                'status' => Controller::HTTP_OK,
                'data' => $user,
            ], Controller::HTTP_OK);
        }
    }

    public function activeUserApp(Request $request)
    {
        $user = $this->user_model->find($request->id);
        $info = [
            'phone' => $user->phone,
            'full_name' => $user->full_name,
            'time' => strtotime(date("Y-m-d H:i:s"))
        ];
        $token = Authorization::generateToken($info);
        $user = $this->user_model->update($request->id, [
            'token_active' => '',
            'timeExpried_active' => '',
            'status' => 'active',
            'token_app' => $token,
            'last_login' => date('Y-m-d H:i:s')
        ]);
        $response = [
            'status' => Controller::HTTP_OK,
            'message' => 'Kích hoạt thành công',
            'token' => $token
        ];
        return response()->json($response);
    }

    public function checkOtpResetPassApp(Request $request)
    {
        $user = $this->user_model->checkOtpResetPassApp($request->otp, $request->phone);
        if (!$user) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "OTP không đúng",
            ], Controller::HTTP_OK);
        } else {
            return response()->json([
                'status' => Controller::HTTP_OK,
                'data' => $user,
            ], Controller::HTTP_OK);
        }
    }

    public function update_password(Request $request)
    {
        $data = [
            'password' => Hash::make($request->password),
            'token_reset_password' => '',
            'time_token_exprired_reset_password' => '',
        ];
        $this->user_model->update($request->id, $data);
        $response = [
            'status' => Controller::HTTP_OK,
            'message' => 'Đổi mật khẩu thành công'
        ];
        return response()->json($response);
    }

    public function test()
    {
        $response = [
            'status' => Controller::HTTP_OK,
            'message' => 'success'
        ];
        return response()->json($response);
    }

}
