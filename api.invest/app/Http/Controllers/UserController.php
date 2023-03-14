<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Rate;
use App\Repository\ActionRepositoryInterface;
use App\Repository\InvestorRepositoryInterface;
use App\Service\InvestorService;
use App\Service\RateService;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Repository\UserRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use App\Models\User;

class UserController extends Controller
{

    public function __construct(
        UserRepositoryInterface $user,
        InvestorRepositoryInterface $investor,
        RoleRepositoryInterface $role,
        UserService $userService,
        ActionRepositoryInterface $action,
        InvestorService $investorService,
        RateService $rateService
    )
    {
        $this->user_model = $user;
        $this->investor_model = $investor;
        $this->role_model = $role;
        $this->userService = $userService;
        $this->action_model = $action;
        $this->investorService = $investorService;
        $this->rateService = $rateService;

    }

    public function createUser(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:user',
            'phone' => 'required|regex:/[0-9]{10}/|unique:user',
            'password' => 'required|min:8|max:30',
            'full_name' => 'required',
        ], [
            'email.required' => 'Bạn chưa nhập username',
            'email.email' => 'Định dạng bạn nhập không phải email',
            'email.max' => 'Tối đa 255 ký tự',
            'email.unique' => 'Tên email đã tồn tại',
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'phone.regex' => 'Số điện thoại không đúng định dạng',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            'password.min' => 'Mật khẩu có tối thiểu 8 ký tự',
            'password.max' => 'Mật khẩu có tối đa 30 ký tự',
            'full_name.required' => 'Bạn chưa nhập tên đầy đủ'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()
            ]);
        }
        // Save
        $data = $this->user_model->create([
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'password' => Hash::make($request->get('password')),
            'full_name' => $request->get('full_name'),
            'status' => 'deactive',
            'type' => User::TYPE_NHAN_VIEN,
            'created_by' => current_user()->email ?? ''
        ]);
        // Res
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $data
        ]);
    }

    public function app_register(Request $request)
    {
        $user = $this->user_model->findPhoneUser($request->phone);
        if (!empty($user)) {
            if ($user->status == 'active') {
                return response()->json([
                    'status' => Controller::HTTP_BAD_REQUEST,
                    'message' => 'Tài khoản đã tồn tại'
                ], Controller::HTTP_OK);
            } else {
                $userEmail = $this->user_model->findEmailUser($request->email);
                if (!empty($userEmail)) {
                    return response()->json([
                        'status' => Controller::HTTP_BAD_REQUEST,
                        'message' => 'Email đã tồn tại'
                    ], Controller::HTTP_OK);
                } else {
                    $validate = $this->userService->validate_create_user_old($request);
                    if ($validate->fails()) {
                        return response()->json([
                            'status' => Controller::HTTP_BAD_REQUEST,
                            'message' => $validate->errors()->first()
                        ], Controller::HTTP_OK);
                    } else {
                        $this->userService->update_user_investor_old($user->id, $request);
                        return response()->json([
                            'status' => Controller::HTTP_OK,
                            'message' => "Tạo tài khoản thành công"
                        ], Controller::HTTP_OK);
                    }
                }
            }
        } else {
            $validate = $this->userService->validate_create_user_new($request);
            if ($validate->fails()) {
                return response()->json([
                    'status' => Controller::HTTP_BAD_REQUEST,
                    'message' => $validate->errors()->first()
                ], Controller::HTTP_OK);
            } else {
                // Save
                $data = $this->userService->create_user_investor_new($request);
                return response()->json([
                    'status' => Controller::HTTP_OK,
                    'message' => "Tạo tài khoản thành công"
                ], Controller::HTTP_OK);
            }
        }
    }

    public function addRole(Request $request)
    {
        $id = $request->id;
        $validate = Validator::make($request->all(), [
            'role_list' => 'required',
        ], [
            'role_list.required' => 'Bạn chưa nhập role',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()
            ]);
        }
        // Add
        $user = $this->user_model->find($id);
        if ($user) {
            $arr_attach = [];
            $arr_role = explode(',', $request->get('role_list'));
            foreach ($arr_role as $role_id) {
                $role_data = $this->role_model->find($role_id);
                if ($role_data) {
                    array_push($arr_attach, $role_data->id);
                }
            }
            $attach = $user->role()->sync($arr_attach);
            if ($attach) {
                return response()->json([
                    'status' => Controller::HTTP_OK,
                    'message' => 'Thành công'
                ]);
            }
        }
        // Not find
        return response()->json([
            'status' => Controller::HTTP_BAD_REQUEST,
            'message' => 'Không tìm thấy dữ liệu'
        ]);
    }

    public function addMenu(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'menu_list' => 'required',
        ], [
            'menu_list.required' => 'Bạn chưa nhập menu',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()
            ]);
        }
        // Add
        $user = $this->user_model->find($request->id);
        if ($user) {
            $arr_menu = json_decode($request->get('menu_list'), true);
            $data_insert = [];
            foreach ($arr_menu as $menu_item) {
                $data_insert[$menu_item['menu']]['action'] = implode(',', $menu_item['action']);
                $data_insert[$menu_item['menu']]['created_at'] = date('Y-m-d H:i:s');
                $data_insert[$menu_item['menu']]['updated_at'] = date('Y-m-d H:i:s');
            }
            $attach = $user->menu()->sync($data_insert);
            if ($attach) {
                return response()->json([
                    'status' => Controller::HTTP_OK,
                    'message' => 'Thành công'
                ]);
            }
        }
    }

    public function getInfoUserApp(Request $request)
    {
        $user = $this->user_model->find($request->id);
        $investor_user = $user->investor;
        $rate = $this->rateService->rate_user($request->id);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'user' => !empty($user) ? $user : '',
            'investor' => !empty($investor_user) ? $investor_user : '',
            'rate' => !empty($rate) ? $rate : ''
        ], Controller::HTTP_OK);
    }

    public function userList(Request $request)
    {
        $filter = $request->only('email', 'phone', 'role');
        $user_list = $this->user_model->getListTypeNhanVien($filter);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $user_list
        ]);
    }

    public function allUser(Request $request)
    {
        $user = $this->user_model->getAllTypeNhanVien();
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $user
        ]);
    }

    public function toggleActive(Request $request)
    {
        $data = $this->user_model->toggleActive($request->get('id'));
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $data
        ]);
    }

    public function detailUser(Request $request)
    {
        $user = $this->user_model->find($request->id);
        $temp_menu = $user->menu()->with('action')->get();
        $user['menu'] = $temp_menu;
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $user
        ]);
    }

    public function updateUser(Request $request)
    {
        $id = $request->id;
        $user = $this->user_model->find($request->id);
        if ($user) {
            $data = $this->user_model->update($id, [
                'status' => ($request->get('status') == 'active') ? 'active' : 'deactive'
            ]);
            return response()->json([
                'status' => Controller::HTTP_OK,
                'data' => $data
            ]);
        }
        return response()->json([
            'status' => Controller::HTTP_BAD_REQUEST,
            'data' => 'Dữ liệu không tồn tại'
        ]);
    }

    public function findUserByPhone(Request $request)
    {
        $user = $this->user_model->findOne(['phone' => $request->phone, 'status' => 'active']);
        if ($user) {
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => 'Thành công',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'status' => Controller::HTTP_UNAUTHORIZED,
                'message' => 'Số điện thoại không tồn tại hoặc chưa được kích hoạt',
            ]);
        }

    }

    public function updateOtpResetPass(Request $request)
    {
        $data = $this->user_model->update($request->id, [
            'token_reset_password' => $request->otp,
            'time_token_exprired_reset_password' => $request->time,
        ]);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $data
        ]);
    }

    public function resend_token(Request $request)
    {
        $user = $this->user_model->findPhoneUser($request->phone);
        $this->user_model->update($user->id, [
            'token_active' => $request->token_active,
            'timeExpried_active' => $request->timeExpried_active
        ]);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'success'
        ]);
    }

    public function update_info_user(Request $request)
    {
        $data = $this->user_model->update($request->id, [
            'avatar' => $request->avatar,
            'full_name' => $request->full_name,
            'gender' => $request->gender,
            'address' => $request->address,
        ]);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $data,
            'message' => 'success'
        ]);
    }

    public function get_action_user(Request $request)
    {
        $user = $this->user_model->find($request->id);
        $action = [];
        if (isset($user->menu)) {
            foreach ($user->menu as $key => $menu) {
                if ($menu->url != '') {
                    array_push($action, $menu->url);
                }
                $arr = explode(',', $menu->pivot->action);
                foreach ($arr as $value) {
                    if ($value != 0) {
                        $url_action = $this->action_model->find($value);
                        array_push($action, $url_action->url);
                    }
                }
            }
            if (in_array($request->uri, $action)) {
                $check = true;
            } else {
                $check = false;
            }
        } else {
            $check = false;
        }

        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $action,
            'check' => $check,
            'is_admin' => $user['is_admin'],
            'message' => 'success'
        ]);
    }

    public function get_action_login(Request $request)
    {
        $user = $this->user_model->find($request->id);
        $action = [];
        if (isset($user->menu)) {
            foreach ($user->menu as $key => $menu) {
                if ($menu->url != '') {
                    array_push($action, $menu->url);
                }
                $arr = explode(',', $menu->pivot->action);
                foreach ($arr as $value) {
                    if ($value != 0) {
                        $url_action = $this->action_model->find($value);
                        array_push($action, $url_action->url);
                    }
                }
            }
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $action,
            'is_admin' => $user['is_admin'],
            'message' => 'success'
        ]);
    }

    public function import_user_ndt_uy_quyen(Request $request)
    {
        $validate = $this->userService->validate_create_user_ndt_uy_quyen($request);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_OK,
                "message" => $validate->errors()->first(),
                'data' => $request->key
            ]);
        } else {
            $user = $this->userService->create_user_ndt_uy_quyen($request);
            $this->investorService->create_investor_uy_quyen($request, $user->id);
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => 'success'
            ]);
        }
    }

    public function tao_moi_ndt_uy_quyen(Request $request)
    {
        $validate = $this->userService->validate_create_user_ndt_uy_quyen($request);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
            ]);
        } else {
            $user = $this->userService->create_user_ndt_uy_quyen($request);
            $this->investorService->create_investor_uy_quyen($request, $user->id);
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => 'success'
            ]);
        }
    }

    public function change_password(Request $request)
    {
        $message = $this->userService->validate_change_password($request);
        if (count($message) > 0) {
            return response()->json([
                Controller::STATUS => Controller::HTTP_BAD_REQUEST,
                Controller::MESSAGE => $message[0]
            ]);
        } else {
            $data = $this->userService->change_password($request);
            return response()->json([
                Controller::STATUS => Controller::HTTP_OK,
                Controller::MESSAGE => Controller::SUCCESS,
                Controller::DATA => $data
            ]);
        }
    }

    public function link_social(Request $request)
    {
        $message = $this->userService->validate_login_social($request);
        if (count($message) > 0) {
            return response()->json([
                Controller::STATUS => Controller::HTTP_BAD_REQUEST,
                Controller::MESSAGE => $message[0]
            ]);
        }

        $data = $this->userService->login_social($request);
        if (!empty($data['message'])) {
            return response()->json([
                Controller::STATUS => Controller::HTTP_BAD_REQUEST,
                Controller::MESSAGE => $data['message']
            ]);
        } else {
            return response()->json([
                Controller::STATUS => Controller::HTTP_OK,
                Controller::MESSAGE => Controller::SUCCESS,
                Controller::DATA => $data
            ]);
        }
    }

    public function phone_number_login_social(Request $request)
    {
        $message = $this->userService->validate_phone_number_login_social($request);
        if (count($message) > 0) {
            return response()->json([
                Controller::STATUS => Controller::HTTP_BAD_REQUEST,
                Controller::MESSAGE => $message[0]
            ]);
        }

        $check = $this->userService->check_referral_code($request);
        if (count($check) > 0) {
            return response()->json([
                Controller::STATUS => Controller::HTTP_BAD_REQUEST,
                Controller::MESSAGE => $check[0]
            ], Controller::HTTP_OK);
        }

        $result = $this->userService->phone_number_login_social($request);
        if (isset($result['otp']->sendError) && $result['otp']->sendError == false) {
            return response()->json([
                Controller::STATUS => Controller::HTTP_OK,
                Controller::MESSAGE => 'Mã xác thực sẽ được cung cấp thông qua cuộc gọi',
                Controller::DATA => [
                    'id' => $result['id'],
                    'checksum' => $result['checksum']
                ]
            ]);
        } else {
            return response()->json([
                Controller::STATUS => Controller::HTTP_BAD_REQUEST,
                Controller::MESSAGE => isset($result['otp']->sendErrorMsg) ? $result['otp']->sendErrorMsg : 'Gửi OTP thất bại'
            ]);
        }
    }

    public function active_phone_social(Request $request)
    {
        $message = $this->userService->validate_active_phone_social($request);
        if (count($message) > 0) {
            return response()->json([
                Controller::STATUS => Controller::HTTP_BAD_REQUEST,
                Controller::MESSAGE => $message[0]
            ]);
        }

        $data = $this->userService->active_phone_social($request);
        return response()->json([
            Controller::STATUS => Controller::HTTP_OK,
            Controller::MESSAGE => Controller::SUCCESS,
            Controller::DATA => $data
        ]);
    }

    public function link_account_social(Request $request)
    {
        $message = $this->userService->validate_link_social($request);
        if (count($message) > 0) {
            return response()->json([
                Controller::STATUS => Controller::HTTP_BAD_REQUEST,
                Controller::MESSAGE => $message[0]
            ]);
        }

        $data = $this->userService->link_social($request);
        return response()->json([
            Controller::STATUS => Controller::HTTP_OK,
            Controller::MESSAGE => Controller::SUCCESS,
            Controller::DATA => $data
        ]);
    }

    public function rate_app(Request $request)
    {
        $this->rateService->create($request);
        return response()->json([
            Controller::STATUS => Controller::HTTP_OK,
            Controller::MESSAGE => Controller::SUCCESS,
        ]);
    }

    public function find_user_by_event(Request $request)
    {
        $users = $this->user_model->find_user_by_event($request->only('object'));
        dd($users);
        foreach ($users as $user) {
            $device = Device::whereIn('user_id', $user)->pluck('device_token')->toArray();
            if (count($device) > 0) {
                echo "<pre>";
                print_r($device);
                echo "</pre>";
            }
        }
        return response()->json([
            Controller::STATUS => Controller::HTTP_OK,
            Controller::MESSAGE => Controller::SUCCESS,
            Controller::DATA => $users
        ]);
    }


}
