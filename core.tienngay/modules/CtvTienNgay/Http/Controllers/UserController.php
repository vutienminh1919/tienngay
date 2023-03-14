<?php

namespace Modules\CtvTienNgay\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Modules\CtvTienNgay\Service\Authorization;
use Modules\CtvTienNgay\Service\Cvs;
use Modules\MongodbCore\Entities\AccountBank;
use Modules\MongodbCore\Entities\Collaborator;
use Modules\MongodbCore\Entities\Handbook;
use Modules\MongodbCore\Entities\JavaReport;
use Illuminate\Http\Response;
use Modules\MongodbCore\Entities\Notification;
use Modules\MongodbCore\Entities\User;
use Modules\MongodbCore\Repositories\UserRepository;


class UserController extends Controller
{
    private $user_model;

    function __construct(UserRepository $userRepository, Cvs $cvsService)
    {
        $this->api = "http://127.0.0.1:8080/";
        $this->user_model = $userRepository;
        $this->cvs = $cvsService;
    }

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/register_store",
     *     tags={"Auth"},
     *     summary="Đăng ký",
     *     description="Đăng ký",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="phone_user",type="string", description="Số điện thọai đăng ký"),
     *                 @OA\Property(property="password_user",type="string", description="Mật khẩu"),
     *                 @OA\Property(property="password_user_retype",type="string", description="Mật khẩu nhập lại"),
     *                 @OA\Property(property="form",type="string", description="1: cá nhân, 2: đội nhóm"),
     *                 @OA\Property(property="phone_introduce",type="string", description="Số điện thoại người giới thiệu"),
     *                 @OA\Property(property="email_user",type="string", description="email"),
     *                 @OA\Property(property="reference_id",type="string", description="reference_id"),
     *                 @OA\Property(property="ctv_company",type="string", description="ctv_company"),
     *                  example={"phone_user": "0359908532","password_user": "12345678","password_user_retype":"12345678","form":"1","phone_introduce":"0359908531", "email_user":"thangbm@tienngay.vn","reference_id": "", "ctv_company": "Cty VFC"}
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
    public function register_store(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $data = $request->all();

        $validate = Validator::make($request->all(), [
            'phone_user' => 'required|regex:/^[0-9]{10}$/',
            'password_user' => 'required|regex:/^.{6,16}$/',
            'password_user_retype' => 'required|regex:/^.{6,16}$/',
            'form' => 'required',

        ], [
            'phone_user.required' => 'Số điện thoại không được để trống',
            'phone_user.regex' => 'Số điện thoại không đúng định dạng',
            'password_user.required' => 'Mật khẩu không được để trống',
            'password_user_retype.required' => 'Nhập lại mật khẩu không được để trống',
            'password_user.regex' => 'Password không đúng định dạng (6-16 ký tự) ',
            'password_user_retype.regex' => 'Password nhập lại không đúng định dạng (6-16 ký tự)',
            'form.required' => 'Hình thức không được để trống',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
            ]);
        }

        $user = Collaborator::where('ctv_phone', "$request->phone_user")
            ->where('status', '=', 'active')
            ->first();

        if (!empty($user)) {
            $response = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Cộng tác viên đã có trong hệ thống"
            );
            return response()->json($response);
        }
        if ($data['password_user'] != $data['password_user_retype']) {
            $response = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Mật khẩu không khớp"
            );
            return response()->json($response);
        }
        if (!empty($data['phone_introduce'])) {
            if ($data['phone_user'] == $data['phone_introduce']) {
                $response = array(
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => "Số điện thoại và số điện thoại người giới thiệu trùng nhau"
                );
                return response()->json($response);
            }

            $user_phone_introduce = User::where('phone_number', $data['phone_introduce'])
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->first();
            $user_phone_introduce_ctv = Collaborator::where('ctv_phone', $data['phone_introduce'])
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->first();

            if ($data['form'] == 1) {
                if (!$user_phone_introduce && !$user_phone_introduce_ctv) {
                    $response = array(
                        'status' => Response::HTTP_BAD_REQUEST,
                        'message' => "Số điện thoại người giới thiệu không tồn tại"
                    );
                    return response()->json($response);
                }
            } else {
                if (!$user_phone_introduce_ctv) {
                    $response = array(
                        'status' => Response::HTTP_BAD_REQUEST,
                        'message' => "Số điện thoại người giới thiệu không tồn tại"
                    );
                    return response()->json($response);
                } else {
                    if ($user_phone_introduce_ctv['form'] == 1) {
                        $response = array(
                            'status' => Response::HTTP_BAD_REQUEST,
                            'message' => "Số điện thoại người giới thiệu không phải đội nhóm"
                        );
                        return response()->json($response);
                    }
                }
            }

        }

        if (!empty($data['reference_id'])) {
            if (empty($data['phone_introduce'])) {
                $response = array(
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => "Số điện thoại người giới thiệu không được để trống!"
                );
                return response()->json($response);
            } else {
                if ($data['phone_user'] == $data['phone_introduce']) {
                    $response = array(
                        'status' => Response::HTTP_BAD_REQUEST,
                        'message' => "Số điện thoại và số điện thoại người giới thiệu trùng nhau"
                    );
                    return response()->json($response);
                }
            }
        }


        //create

        $otp = rand(100000, 999999);
        $timeExpried = time() + 2 * 60;
        $time_gui_lai_otp = time() + 60;

        $send = [
            'otp' => (string)$otp,
            'ctv_phone' => $data['phone_user']
        ];

        $this->call_otp($send);

        if (empty($data['phone_introduce'])) {
            if ($data['form'] == 1) {
                $saveData = [
                    'ctv_phone' => $data['phone_user'],
                    'password' => md5($data['password_user']),
                    'email' => !empty($data['email_user']) ? $data['email_user'] : '',
                    'status' => 'new',
                    'token_active' => $otp,
                    'timeExpried_active' => $timeExpried,
                    'time_gui_lai_otp' => $time_gui_lai_otp,
                    'account_type' => '1',
                    'phone_introduce' => !empty($data['phone_introduce']) ? $data['phone_introduce'] : "",
                    'form' => $data['form'],
                    'type' => "2",
                    Collaborator::COLUMN_STATUS_VERIFIED => Collaborator::NOT_VERIFY, // chưa xác thực
                    'created_at' => time(),
                    'created_by' => $data['phone_user']
                ];
            } else {
                $saveData = [
                    'ctv_phone' => $data['phone_user'],
                    'ctv_company' => $data['ctv_company'] ?? '',
                    'password' => md5($data['password_user']),
                    'email' => !empty($data['email_user']) ? $data['email_user'] : '',
                    'status' => 'new',
                    'token_active' => $otp,
                    'timeExpried_active' => $timeExpried,
                    'time_gui_lai_otp' => $time_gui_lai_otp,
                    'account_type' => '1',
                    'phone_introduce' => !empty($data['phone_introduce']) ? $data['phone_introduce'] : "",
                    'form' => $data['form'],
                    'manager_phone' => $data['phone_user'],
                    'type' => "2",
                    Collaborator::COLUMN_STATUS_VERIFIED => Collaborator::NOT_VERIFY, // chưa xác thực
                    'created_at' => time(),
                    'created_by' => $data['phone_user']
                ];
            }
        } else {
            $introducer_id = '';
            if (!empty($data['reference_id'])) {
                $introducer_id = $data['reference_id'];
            } else {
                if ($data['form'] == 1) {
                    if (!empty($user_phone_introduce) && !empty($user_phone_introduce_ctv)) {
                        $introducer_id = $user_phone_introduce['_id'];
                    } elseif (!empty($user_phone_introduce)) {
                        $introducer_id = $user_phone_introduce['_id'];
                    } elseif (!empty($user_phone_introduce_ctv)) {
                        $introducer_id = $user_phone_introduce_ctv['_id'];
                    }
                } else {
                    if (!empty($user_phone_introduce_ctv)) {
                        $introducer_id = $user_phone_introduce_ctv['_id'];
                    }
                }
            }
            $saveData = [
                'ctv_phone' => $data['phone_user'],
                'password' => md5($data['password_user']),
                'email' => !empty($data['email_user']) ? $data['email_user'] : '',
                'status' => 'new',
                'token_active' => $otp,
                'timeExpried_active' => $timeExpried,
                'time_gui_lai_otp' => $time_gui_lai_otp,
                'introducer_id' => $introducer_id,
                'account_type' => '2',
                'phone_introduce' => !empty($data['phone_introduce']) ? $data['phone_introduce'] : "",
                'form' => $data['form'],
                'type' => "2",
                'user_type' => "1",
                Collaborator::COLUMN_STATUS_VERIFIED => Collaborator::NOT_VERIFY, // chưa xác thực
                'created_at' => time(),
                'created_by' => $data['phone_user']
            ];

            if ($data['form'] == 2) {
                $saveData['manager_id'] = $user_phone_introduce_ctv['account_type'] == '1' ? $user_phone_introduce_ctv['_id'] : $user_phone_introduce_ctv['manager_id'];
                $saveData['manager_phone'] = $user_phone_introduce_ctv['account_type'] == '1' ? $user_phone_introduce_ctv['ctv_phone'] : $user_phone_introduce_ctv['manager_phone'];
            }
        }


        $model = new Collaborator;
        $model->fill($saveData)->save();

        $user_id = Collaborator::where('ctv_phone', "$request->phone_user")->orderBy('created_at', 'desc')->first();

        if (!empty($user_phone_introduce)) {
            $data_notification = [
                'action_id' => "",
                'action' => 'CTV_New',
                'title' => 'Website Cộng Tác Viên',
                'detail' => "collaborator/index_collaborator",
                'note' => "Cộng tác viên mới đăng ký",
                'user_id' => (string)$user_phone_introduce['_id'],
                'status' => 1, //1: new, 2 : read, 3: block,
                'contract_status' => "",
                'created_at' => time(),
                "created_by" => "admin"
            ];
            $notification = new Notification();
            $notification->fill($data_notification)->save();
        }


        $responses = array(
            'status' => Response::HTTP_OK,
            'message' => "Thành công",
            'user_id' => !empty($user_id['_id']) ? (string)$user_id['_id'] : "",
        );

        return response()->json($responses);
    }

    public function call_otp($data)
    {

//        $client = new \GuzzleHttp\Client(['base_uri' => 'https://sandboxapi.tienngay.vn']);
        $client = new \GuzzleHttp\Client(['base_uri' => env('API_TIENNGAY')]);

        $response = $client->request('POST', '/ladipage_lead/apiOtpCore_v2', [
            'form_params' => $data
        ]);

    }

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/check_otp_register",
     *     tags={"Auth"},
     *     summary="Check otp",
     *     description="Check otp",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="user_id",type="string", description="user_id"),
     *                 @OA\Property(property="otp_check",type="string", description="otp"),
     *                  example={"user_id": "636dfc1cc31c00007b0042a5","otp_check": "123456"}
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
    public function check_otp_register(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'otp_check' => 'required|regex:/^[0-9]{6}$/',
        ], [
            'otp_check.required' => 'Mã OTP không được để trống',
            'otp_check.regex' => 'Mã OTP không đúng định dạng',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
            ]);
        }

        $user = Collaborator::where('_id', "$request->user_id")
            ->first();

        if ((int)$request->otp_check != $user['token_active']) {
            $response = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Mã OTP nhập không chính xác"
            );
            return response()->json($response);
        }

        $encode = [
            'id' => (string)$user['_id'],
            'email' => $user['ctv_phone'],
            'full_name' => $user['ctv_name'],
            'time' => time(),
        ];
        $token = Authorization::generateToken($encode);

        Collaborator::where('_id', "$request->user_id")->update([
            "status" => "active",
            "ctv_code" => $request->user_id,
            'token_app' => $token
        ]);

        $user_new = Collaborator::where('_id', $user['_id'])
            ->first();
        $user_new['password'] = !empty($user_new['password']) ? 'xxxxxxxxx' : '';
        $response = array(
            'status' => Response::HTTP_OK,
            'message' => "Tạo tài khoản CTV thành công",
            'data' => $user_new
        );
        return response()->json($response);

    }

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/gui_lai_otp",
     *     tags={"Auth"},
     *     summary="Gửi lại otp",
     *     description="Gửi lại otp",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="user_id",type="string", description="user_id"),
     *                  example={"user_id": "636dfc1cc31c00007b0042a5"}
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
    public function gui_lai_otp(Request $request)
    {

        $user = Collaborator::where('_id', "$request->user_id")
            ->first();

        if (!empty($user)) {

            if (!empty($user['time_gui_lai_otp']) && $user['time_gui_lai_otp'] > time()) {
                $response = array(
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => "Vui lòng gửi lại OTP sau 1 phút"
                );
                return response()->json($response);
            }

            $send = [
                'otp' => (string)$user['token_active'],
                'ctv_phone' => $user['ctv_phone']
            ];

            $this->call_otp($send);

            $response = array(
                'status' => Response::HTTP_OK,
                'message' => "Gửi thành công"
            );
            return response()->json($response);
        }
    }

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/gui_lai_otp_qmk",
     *     tags={"Auth"},
     *     summary="Gửi lại otp qmk",
     *     description="Gửi lại otp qmk",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="user_id",type="string", description="user_id"),
     *                  example={"user_id": "636dfc1cc31c00007b0042a5"}
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
    public function gui_lai_otp_qmk(Request $request)
    {

        $user = Collaborator::where('_id', "$request->user_id")
            ->first();

        if (!empty($user)) {
            $send = [
                'otp' => (string)$user['otp_qmk'],
                'ctv_phone' => $user['ctv_phone']
            ];

            $this->call_otp($send);

            $response = array(
                'status' => Response::HTTP_OK,
                'message' => "Gửi thành công"
            );
            return response()->json($response);
        }


    }

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/login",
     *     tags={"Auth"},
     *     summary="Đăng nhập",
     *     description="Đăng nhập",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="phone_login",type="string", description="phone_login"),
     *                 @OA\Property(property="password_login",type="string", description="password_login"),
     *                  example={"phone_login": "0359908532","password_login": "12345678"}
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
    public function login(Request $request)
    {

        $data = $request->all();
        $validate = Validator::make($request->all(), [
            'phone_login' => 'required',
            'password_login' => 'required',

        ], [
            'phone_login.required' => 'Số điện thoại không được để trống',
            'password_login.required' => 'Password không được để trống',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
            ]);
        }

        $password_check = md5($request->password_login);

        $user = Collaborator::where('ctv_phone', "$request->phone_login")
            ->where('password', '=', "$password_check")
            ->where('status', '=', "active")
            ->first();

        if (!empty($user)) {
            if (!empty($user['password'])) {
                $user['password'] = "xxxxxxxx";
            }
            $encode = [
                'id' => (string)$user['_id'],
                'email' => $user['ctv_phone'],
                'full_name' => $user['ctv_name'],
                'time' => time(),
            ];
            $token = Authorization::generateToken($encode);

            Collaborator::where('_id', $user['_id'])
                ->update(['token_app' => $token]);
            $user_new = Collaborator::where('_id', $user['_id'])
                ->first();
            $response = array(
                'status' => Response::HTTP_OK,
                'message' => "Đăng nhập thành công",
                'user' => $user_new,
            );
            return response()->json($response);
        } else {
            $response = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Tài khoản không chính xác"
            );
            return response()->json($response);
        }
    }

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/quen_mat_khau",
     *     tags={"Auth"},
     *     summary="Quên mật khẩu",
     *     description="Quên mật khẩu",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="qmt_phone",type="string", description="Số điện thoại"),
     *                  example={"qmt_phone": "0359908532"}
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
    public function quen_mat_khau(Request $request)
    {

        $data = $request->all();
        $validate = Validator::make($request->all(), [
            'qmt_phone' => 'required|regex:/^[0-9]{10}$/',

        ], [
            'qmt_phone.required' => 'Số điện thoại không được để trống',
            'qmt_phone.regex' => 'Số điện thoại không đúng định dạng',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
            ]);
        }

        $user = Collaborator::where('ctv_phone', "$request->qmt_phone")
            ->where('status', '=', "active")
            ->first();


        if (empty($user)) {
            $response = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Cộng tác viên không tồn tại trong hệ thống"
            );
            return response()->json($response);
        } else {

            $otp = rand(100000, 999999);
            $timeExpried_quenmatkhau = time() + 3 * 60;

            $send = [
                'otp' => (string)$otp,
                'ctv_phone' => $request->qmt_phone
            ];

            $this->call_otp($send);

            Collaborator::where('ctv_phone', "$request->qmt_phone")
                ->where('status', '=', "active")->update(['timeExpried_quenmatkhau' => $timeExpried_quenmatkhau, 'otp_qmk' => $otp, "updated_at" => time()]);

            $responses = array(
                'status' => Response::HTTP_OK,
                'message' => "Thành công",
                'user_id' => !empty($user['_id']) ? (string)$user['_id'] : "",
            );

            return response()->json($responses);

        }
    }

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/check_otp_qmk",
     *     tags={"Auth"},
     *     summary="Check otp qmk",
     *     description="Check qmk",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="user_id",type="string", description="user_id"),
     *                 @OA\Property(property="otp",type="string", description="otp"),
     *                  example={"user_id": "636dfc1cc31c00007b0042a5","otp": "123456"}
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
    public function check_otp_qmk(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'otp' => 'required|regex:/^[0-9]{6}$/',
        ], [
            'otp.required' => 'Mã OTP không được để trống',
            'otp.regex' => 'Mã OTP không đúng định dạng',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
            ]);
        }

        $user = Collaborator::where('_id', "$request->user_id")
            ->first();

        if ((int)$request->otp != $user['otp_qmk']) {
            $response = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Mã OTP nhập không chính xác"
            );
            return response()->json($response);
        }

        if (time() > $user['timeExpried_quenmatkhau']) {
            $response = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Mã OTP hết hạn vui lòng thử lại"
            );
            return response()->json($response);
        }

        $response = array(
            'status' => Response::HTTP_OK,
            'message' => "Thành công"
        );
        return response()->json($response);


    }


    /**
     * @OA\Post(
     *     path="/ctv-tienngay/register_new_password",
     *     tags={"Auth"},
     *     summary="Quên mk đổi mk mới",
     *     description="Quên mk đổi mk mới",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="new_pass",type="string", description="mật khẩu"),
     *                 @OA\Property(property="new_pass_current",type="string", description="mật khẩu nhập lại"),
     *                 @OA\Property(property="user_id",type="string", description="user_id"),
     *                  example={"new_pass": "12345678","new_pass_current": "12345678", "user_id": "xxxxxxxx"}
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
    public function register_new_password(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'new_pass' => 'required|regex:/^.{6,16}$/',
            'new_pass_current' => 'required|regex:/^.{6,16}$/',
        ], [
            'new_pass.required' => 'Mật khẩu không được để trống',
            'new_pass.regex' => 'Mật khẩu từ 6-16 ký tự',
            'new_pass_current.required' => 'Mật khẩu không được để trống',
            'new_pass_current.regex' => 'Mật khẩu từ 6-16 ký tự',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
            ]);
        }

        if ($request->new_pass != $request->new_pass_current) {
            $response = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Mật khẩu không khớp nhau"
            );
            return response()->json($response);
        }

        $user = Collaborator::where('_id', "$request->user_id")->first();

        if (!empty($user)) {

            $newPassword = md5($request->new_pass);

            Collaborator::where('_id', "$request->user_id")
                ->where('status', '=', "active")->update(["password" => $newPassword, "updated_at" => time()]);

        }

        $response = array(
            'status' => Response::HTTP_OK,
            'message' => "Thành công"
        );
        return response()->json($response);

    }

    public function detail_user(Request $request)
    {

        $user = Collaborator::where('_id', "$request->id")->first();

        if (!empty($user)) {

            $responses = array(
                'status' => Response::HTTP_OK,
                'message' => "Thành công",
                'data' => $user,
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

    public function store_thongtintaikhoan(Request $request)
    {

        $data = $request->all();

        if (!empty($data['ctv_phone'])) {
            if (!preg_match("/^[0-9]{10}$/", $data['ctv_phone'])) {

                Collaborator::where('_id', "$request->id")->update(
                    [
                        "ctv_name" => !empty($data['ctv_name']) ? $data['ctv_name'] : "",
                        "ctv_DOB" => !empty($data['ctv_DOB']) ? $data['ctv_DOB'] : "",
                        "ctv_address" => !empty($data['ctv_address']) ? $data['ctv_address'] : "",
                        "ctv_cmt" => !empty($data['ctv_cmt']) ? $data['ctv_cmt'] : "",
                        "ctv_ngaycap" => !empty($data['ctv_ngaycap']) ? $data['ctv_ngaycap'] : "",
                        "ctv_noicap" => !empty($data['ctv_noicap']) ? $data['ctv_noicap'] : "",
                        "email" => !empty($data['email']) ? $data['email'] : "",
                    ]);

                $responses = array(
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => "Số điện thoại không đúng định dạng"
                );
                return response()->json($responses);
            }
        }

        if (!empty($data['ctv_cmt'])) {
            if (!preg_match("/^[0-9]{9,12}$/", $data['ctv_cmt'])) {

                Collaborator::where('_id', "$request->id")->update(
                    [
                        "ctv_name" => !empty($data['ctv_name']) ? $data['ctv_name'] : "",
                        "ctv_DOB" => !empty($data['ctv_DOB']) ? $data['ctv_DOB'] : "",
                        "ctv_phone" => !empty($data['ctv_phone']) ? $data['ctv_phone'] : "",
                        "ctv_address" => !empty($data['ctv_address']) ? $data['ctv_address'] : "",
                        "ctv_ngaycap" => !empty($data['ctv_ngaycap']) ? $data['ctv_ngaycap'] : "",
                        "ctv_noicap" => !empty($data['ctv_noicap']) ? $data['ctv_noicap'] : "",
                        "email" => !empty($data['email']) ? $data['email'] : "",
                    ]);

                $responses = array(
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => "Số cmt không đúng định dạng"
                );
                return response()->json($responses);
            }
        }


        Collaborator::where('_id', "$request->id")->update(
            [
                "ctv_name" => !empty($data['ctv_name']) ? $data['ctv_name'] : "",
                "ctv_DOB" => !empty($data['ctv_DOB']) ? $data['ctv_DOB'] : "",
                "ctv_phone" => !empty($data['ctv_phone']) ? $data['ctv_phone'] : "",
                "ctv_address" => !empty($data['ctv_address']) ? $data['ctv_address'] : "",
                "ctv_cmt" => !empty($data['ctv_cmt']) ? $data['ctv_cmt'] : "",
                "ctv_ngaycap" => !empty($data['ctv_ngaycap']) ? $data['ctv_ngaycap'] : "",
                "ctv_noicap" => !empty($data['ctv_noicap']) ? $data['ctv_noicap'] : "",
                "email" => !empty($data['email']) ? $data['email'] : "",
            ]);


        $responses = array(
            'status' => Response::HTTP_OK,
            'message' => "Thành công",
        );
        return response()->json($responses);


    }

    public function doi_mat_khau(Request $request)
    {

        $data = $request->all();

        $validate = Validator::make($request->all(), [
            'pass_user' => 'required|regex:/^.{6,16}$/',
            'newpass_user' => 'required|regex:/^.{6,16}$/',
            'newpasscurrent_user' => 'required|regex:/^.{6,16}$/',
        ], [
            'pass_user.required' => 'Mật khẩu cũ không được để trống',
            'newpass_user.required' => 'Mật khẩu mới không được để trống',
            'newpasscurrent_user.required' => 'Nhập lại mật khẩu mới không được để trống',
            'pass_user.regex' => 'Mật khẩu cũ không đúng định dạng',
            'newpass_user.regex' => 'Mật khẩu mới không đúng định dạng',
            'newpasscurrent_user.regex' => 'Nhập lại mật khẩu mới không đúng định dạng',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
            ]);
        }

        $user = Collaborator::where('_id', "$request->id")->first();

        if ($user->password != md5($request->pass_user)) {
            $responses = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Mật khẩu nhập không chính xác"
            );
            return response()->json($responses);
        }

        if ($request->newpass_user != $request->newpasscurrent_user) {
            $responses = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Mật khẩu mới và mật khẩu nhập lại không khớp"
            );
            return response()->json($responses);
        }

        $newPassword = md5($request->newpass_user);

        Collaborator::where('_id', "$request->id")->update(["password" => $newPassword]);

        $responses = array(
            'status' => Response::HTTP_OK,
            'message' => "Đổi mật khẩu thành công",
        );
        return response()->json($responses);

    }

    public function them_tai_khoan(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'name_user' => 'required',
            'phone_user' => 'required|regex:/[0-9]/',
        ], [
            'name_user.required' => 'Tên tài khoản không được để trống',
            'phone_user.required' => 'Số tài khoản không được để trống',
            'phone_user.regex' => 'Số tài khoản không đúng định dạng',

        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
            ]);
        }


        $user = $this->user_model->findMyUser($request->id);
        if (!empty($user['status_verified']) && $user['status_verified'] == Collaborator::VERIFIED) {
            if (!empty($user['ctv_name'])) {
                $user_name = $user['ctv_name'];
                $account_name = $request->name_user;
                if (mb_strtolower(trim($user_name), 'UTF-8') !== mb_strtolower(trim($account_name), 'UTF-8')) {
                    return response()->json([
                        'status' => Response::HTTP_BAD_REQUEST,
                        "message" => 'Tên tài khoản không khớp với thông tin xác thực',
                    ]);
                }
            }
        }

        $user_tk = [
            "user_id" => $request->id,
            "name_user" => $request->name_user,
            "stk_user" => $request->phone_user,
            "bank" => $request->bank,
            'created_at' => time()
        ];


        $model = new AccountBank();
        $model->fill($user_tk)->save();


        $responses = array(
            'status' => Response::HTTP_OK,
            'message' => "Thành công",
        );
        return response()->json($responses);

    }

    public function list_stk_user(Request $request)
    {

        $list = AccountBank::where('user_id', "$request->id")->orderBy('created_at', 'desc')->get();

        $responses = array(
            'status' => Response::HTTP_OK,
            'message' => "Thành công",
            'data' => !empty($list) ? $list : []
        );
        return response()->json($responses);

    }

    public function xoa_tai_khoan(Request $request)
    {

        AccountBank::where('_id', "$request->id")->delete();

        $responses = array(
            'status' => Response::HTTP_OK,
            'message' => "Thành công",
        );
        return response()->json($responses);

    }

    public function upload_image_cmt(Request $request)
    {
        $img_front = !empty($request->image_cmt_mattruoc) ? $request->image_cmt_mattruoc : "";
        $img_back = !empty($request->image_cmt_matsau) ? $request->image_cmt_matsau : "";

        if ($img_front && $img_back) {
            Collaborator::where('_id', "$request->id")->update([Collaborator::COLUMN_STATUS_VERIFIED => Collaborator::PENDING_VERIFY]);
        }
        Collaborator::where('_id', "$request->id")->update(
            ["image_cmt_mattruoc" => !empty($request->image_cmt_mattruoc) ? $request->image_cmt_mattruoc : "",
                "image_cmt_matsau" => !empty($request->image_cmt_matsau) ? $request->image_cmt_matsau : ""
            ]
        );

        $responses = array(
            'status' => Response::HTTP_OK,
            'message' => "Thành công",
        );
        return response()->json($responses);
    }

    public function get_all_user_introduce_by_my_self(Request $request)
    {
        $phone_intro = $request->get('phone');
        $userWasIntroduced = $this->user_model->get_list_user_by_my_self($phone_intro);
        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => $userWasIntroduced
        ]);
    }

    public function get_user_info(Request $request)
    {
        $id = $request->get('id');
        $userInfo = $this->user_model->get_user_info($id);
        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => $userInfo
        ]);
    }

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

        $check_phone = $this->user_model->findOneByPhone($request->get('collaborator_member_phone'));
        if (!empty($check_phone)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Thành viên đã tồn tại!"
            ];
            return response()->json($response);
        }

        // Save
        $data = $this->user_model->create([
            Collaborator::COLUMN_CTV_NAME => $request->get('collaborator_member_name'),
            Collaborator::COLUMN_CTV_PHONE => $request->get('collaborator_member_phone'),
            Collaborator::COLUMN_CTV_PASSWORD => md5('12345678'),
            Collaborator::COLUMN_STATUS => Collaborator::STATUS_ACTIVE,
            Collaborator::COLUMN_USER_ROLE => $request->get('collaborator_member_role'),
            'account_type' => '2', // 1: tai khoan truong nhom, 2: tai khoan thanh vien
            'manager_id' => $request->get('manager_id'),
            'manager_phone' => $request->get('manager_phone'),
            Collaborator::COLUMN_FORM => Collaborator::FORM_USER_GROUP,
            Collaborator::COLUMN_TYPE => '2', // website ctv TienNgay
            Collaborator::COLUMN_USER_TYPE => Collaborator::TYPE_COLLABORATOR_GROUP,
            Collaborator::COLUMN_STATUS_VERIFIED => Collaborator::NOT_VERIFY, // chưa xác thực
            Collaborator::CREATED_AT => time(),
            Collaborator::COLUMN_CREATED_BY => $request->get('manager_phone')

        ]);

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => "Thêm mới thành viên thành công!",
            'data' => $data
        ]);
    }

    public function getAllMember(Request $request)
    {
        $filter = $request->only('datefrom', 'dateto', 'filter_many', 'page', 'id');
        $list_user_members = $this->user_model->getAllUserMember($filter);
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Thành công',
            'data' => $list_user_members
        ]);
    }

    public function update_user_status(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required'
        ], [
            'id.required' => 'Id của người dùng đang trống!',
            'status.required' => 'Status của người dùng đang trống!'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validate->errors()->first()
            ]);
        }
        $result = $this->user_model->update($request->id, [
            'status' => $request->status
        ]);
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Cập nhật thành công!',
            'data' => $result
        ]);
    }

    // get user that not verified yet
    public function getUserNotAuth()
    {
        $result = Collaborator::where(Collaborator::COLUMN_STATUS_VERIFIED, Collaborator::PENDING_VERIFY)->get();
//        $result = Collaborator::where(Collaborator::COLUMN_CTV_PHONE, "0930000000")->get();
        return $result->toArray();
    }

    // main cron function
    public function checkEkyc()
    {
        $user = $this->getUserNotAuth();
        foreach ($user as $item) {
            $this->ekyc($item);
        }

    }

    // ekyc user
    public function ekyc($user)
    {
        $data = [
            'front_card' => $user['image_cmt_mattruoc'],
            'back_card' => $user['image_cmt_matsau'],
        ];
        $data1 = $this->cvs->ekyc_cards($data);
        $message = "";
        $userInfo = [];
        if ($data1) {
            if (isset($data1->errorCode) && $data1->errorCode == "0") {
                if (!empty($data1->data[0]) && !empty($data1->data[1])) {
                    if ($data1->data[0]->valid == "True" && $data1->data[1]->valid == "True") {
                        if (!empty($data1->data[1]->info->dob)) {
                            $dob = $data1->data[1]->info->dob;
                            if (str_contains($dob, "/")) {
                                $arr_birthday = explode('/', $dob);
                                $userInfo['birthday'] = $arr_birthday[2] . '-' . $arr_birthday[1] . '-' . $arr_birthday[0];
                            } elseif (str_contains($dob, "-")) {
                                $arr_birthday = explode('-', $dob);
                                $userInfo['birthday'] = $arr_birthday[2] . '-' . $arr_birthday[1] . '-' . $arr_birthday[0];
                            } else {
                                $userInfo['birthday'] = $dob;
                            }
                        }
                        if (!empty($data1->data[1]->info->address)) {
                            $userInfo['address'] = $data1->data[1]->info->address;
                        }
                        if (!empty($data1->data[1]->info->name)) {
                            $userInfo['name'] = $data1->data[1]->info->name;
                        }
                        if (!empty($data1->data[1]->info->id)) {
                            $userInfo['identify'] = $data1->data[1]->info->id;
                        }
                        if (!empty($data1->data[0]->info->issue_date)) {
                            $date_range = $data1->data[0]->info->issue_date;
                            if (str_contains($date_range, "-")) {
                                $arr = explode('-', $date_range);
                            } else {
                                $arr = explode('/', $date_range);
                            }
                            $userInfo['date_range'] = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
                        }
                        if (!empty($data1->data[0]->info->issued_at)) {
                            $userInfo['issued_by'] = $data1->data[0]->info->issued_at;
                        }

                        $userInfo['gender'] = '';
                        if (!empty($data1->data[0]->info->sex)) {
                            $userInfo['gender'] = slugify($data1->data[0]->info->sex);
                        } elseif (!empty($data1->data[0]->info->gender)) {
                            $userInfo['gender'] = slugify($data1->data[0]->info->gender);
                        }
                        $userGroup = Collaborator::where(Collaborator::COLUMN_FORM, Collaborator::FORM_USER_GROUP)->where(Collaborator::COLUMN_USER_TYPE, Collaborator::TYPE_ACCOUNT_PARENT)->where(Collaborator::COLUMN_ID, $user['_id'])->first();
                        if ($userGroup) {
                            $dataUpdate = [
                                Collaborator::COLUMN_CTV_DOB => $userInfo['birthday'],
                                Collaborator::COLUMN_CTV_CMT => $userInfo['identify'],
                                Collaborator::COLUMN_CTV_ADDRESS => $userInfo['address'],
                                Collaborator::COLUMN_CTV_DATE_RANGE => $userInfo['date_range'],
                                Collaborator::COLUMN_CTV_ISSUED_BY => $userInfo['issued_by'],
                                'ctv_gender' => $userInfo['gender'],
                            ];
                        } else {
                            $dataUpdate = [
                                Collaborator::COLUMN_CTV_DOB => $userInfo['birthday'],
                                Collaborator::COLUMN_CTV_CMT => $userInfo['identify'],
                                Collaborator::COLUMN_CTV_ADDRESS => $userInfo['address'],
                                Collaborator::COLUMN_CTV_DATE_RANGE => $userInfo['date_range'],
                                Collaborator::COLUMN_CTV_ISSUED_BY => $userInfo['issued_by'],
                                Collaborator::COLUMN_CTV_NAME => $userInfo['name'],
                                'ctv_gender' => $userInfo['gender'],
                            ];
                        }
                        $update = Collaborator::where(Collaborator::COLUMN_ID, $user['_id'])->update($dataUpdate);
                        $message = 'Xác thực thành công';
                        $ekyc = true;
                    } else {
                        $message = 'Thông tin xác thực không đúng. Quý khách vui lòng xác thực lại. Xin cảm ơn';
                        $ekyc = false;
                    }
                } else {
                    $message = 'Thông tin xác thực không đúng. Quý khách vui lòng xác thực lại. Xin cảm ơn';
                    $ekyc = false;
                }
            } else {
                $message = 'Thông tin xác thực không đúng. Quý khách vui lòng xác thực lại. Xin cảm ơn';
                $ekyc = false;
            }

        } else {
            $message = 'Thông tin xác thực không đúng. Quý khách vui lòng xác thực lại. Xin cảm ơn';
            $ekyc = false;
        }
        if ($ekyc == true) {
            $user_new = $this->user_model->verifiedUser($user['_id']);
        } else {
            $user_new = $this->user_model->notVerifiedUser($user['_id']);
        }
        return $message;

    }

    //update old user
    public function updateVerifiedUSer()
    {
        $user = $this->user_model->getUserNotVerified();
        foreach ($user as $item) {
            if (isset($item['image_cmt_mattruoc']) && isset($item['image_cmt_matsau'])) {
                if (str_contains($item['image_cmt_mattruoc'], 'xls') || str_contains($item['image_cmt_matsau'], 'xls')) {
                    $unset = Collaborator::where(Collaborator::COLUMN_ID, $item['_id'])->unset([Collaborator::COLUMN_FRONT_CARD, Collaborator::COLUMN_BACK_CARD]);
                    $update = Collaborator::where(Collaborator::COLUMN_ID, $item['_id'])->update([Collaborator::COLUMN_STATUS_VERIFIED => Collaborator::NOT_VERIFY]);
                } else {
                    $update = Collaborator::where(Collaborator::COLUMN_ID, $item['_id'])->update([Collaborator::COLUMN_STATUS_VERIFIED => Collaborator::PENDING_VERIFY]);
                }
            } else {
                $update = Collaborator::where(Collaborator::COLUMN_ID, $item['_id'])->update([Collaborator::COLUMN_STATUS_VERIFIED => Collaborator::NOT_VERIFY]);
            }

        }
        return $update;
    }

    public function save_token_device(Request $request)
    {
        $user_id = $request->user_id;
        $device_token = $request->device_token;
        $userInfo = $this->user_model->get_user_info($user_id);
        if (!empty($userInfo)) {
            $this->user_model->update($userInfo['id'], ['device_token' => $device_token]);
        }
        $response = [
            'status' => Response::HTTP_OK,
            'message' => 'Save device_token success!'
        ];
        return response()->json($response);
    }


}
