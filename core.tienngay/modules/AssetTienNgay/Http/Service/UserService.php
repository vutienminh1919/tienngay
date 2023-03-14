<?php


namespace Modules\AssetTienNgay\Http\Service;


use Illuminate\Support\Facades\Validator;
use Modules\AssetTienNgay\Http\Repository\UserRepository;
use Modules\AssetTienNgay\Http\Service\BaseService;
use Modules\AssetTienNgay\Model\User;

class UserService extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validate_login($request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'type' => 'required'
        ], [
            'email.required' => 'Email không để trống',
            'password.required' => 'Mật khẩu không để trống',
            'type.required' => 'Type login không để trống',
        ]);
        return $validate;
    }

    public function check_login($request)
    {
        $data = [];
        $user = $this->userRepository->findOne([
            User::EMAIL => $request->email,
            User::STATUS => User::ACTIVE,
            User::TYPE => User::NHAN_VIEN
        ]);
        if (!isset($user)) {
            $data['message'] = 'Tài khoản email không đúng hoặc đang bị khóa';
        } else {
            if (!password_verify($request->password, $user['password'])) {
                $data['message'] = 'Mật khẩu không chính xác';
            } else {
                $data['user'] = $user;
            }
        }
        return $data;
    }

    public function login($user, $request)
    {
        $data = [
            'id' => (string)$user['_id'],
            'email' => $user['email'],
            'full_name' => $user['full_name'],
            'time' => time(),
        ];
        $token = Authorization::generateToken($data);
        if ($request->type == 1) {
            $this->userRepository->update($user['_id'], [User::TOKEN_WEB => $token]);
        } else {
            $this->userRepository->update($user['_id'], [User::TOKEN_APP => $token]);
        }
        return $token;
    }

    public function validate_register($request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required',
            'phone_number' => 'required',
            'password' => 'required',
            're_password' => 'required',
            'full_name' => 'required',
            'type' => 'required'
        ], [
            'email.required' => 'Email không để trống',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không để trống',
            're_password.required' => 'Mật khẩu không để trống',
            'phone_number.required' => 'Số điện thoại không để trống',
            'phone_number.unique' => 'Số điện thoại đã tồn tại',
            'full_name.required' => 'Tên không để trống không để trống',
            'type.required' => 'Type register không để trống',
        ]);
        return $validate;
    }

    public function check_register($request)
    {
        $data = [];
        $userEmail = $this->userRepository->findOne([
            User::EMAIL => $request->email,
            User::TYPE => User::NHAN_VIEN
        ]);
        if (isset($userEmail)) {
            $data['message'] = 'Email đã tồn tại';
        }

        $userPhone = $this->userRepository->findOne([
            User::PHONE_NUMBER => $request->phone_number,
            User::TYPE => User::NHAN_VIEN
        ]);
        if (isset($userPhone)) {
            $data['message'] = 'Số điện thoại đã tồn tại';
        }

        if ($request->password != $request->re_password) {
            $data['message'] = 'Mật khẩu không khớp';
        }
        return $data;
    }

    public function register($request)
    {
        $data = [
            User::EMAIL => $request->email,
            User::PASSWORD => password_hash($request->password, PASSWORD_BCRYPT),
            User::PHONE_NUMBER => $request->phone_number,
            User::FULL_NAME => $request->full_name,
            User::CREATED_AT => time(),
            User::STATUS => User::ACTIVE,
            User::TYPE => User::NHAN_VIEN,
            User::CREATED_AT => time()
        ];
        $user = $this->userRepository->create($data);
        $token = Authorization::generateToken([
            'id' => (string)$user['_id'],
            'email' => $user['email'],
            'full_name' => $user['full_name'],
            'time' => time(),
        ]);
        if ($request->type == 1) {
            $this->userRepository->update($user['_id'], [User::TOKEN_WEB => $token]);
        } else {
            $this->userRepository->update($user['_id'], [User::TOKEN_APP => $token]);
        }
        return $token;
    }

    public function get_user($request)
    {
        $users = $this->userRepository->findManySortColumn(
            [User::TYPE => '1', User::STATUS => 'active'],
            User::CREATED_AT,
            self::ASC
        );
        $data = [];
        foreach ($users as $user) {
            if (!empty($user->email)) {
                array_push($data, $user);
            }
        }
        return $data;
    }

    public function get_user_add_role($request)
    {
        $user_ids = $request->user_ids;
        if (isset($user_ids) && count($user_ids) > 0) {
            $users = $this->userRepository->get_user_add_role($user_ids);
        }else{
            $users = $this->userRepository->get_all_user_add_role($user_ids);
        }
        $data = [];
        foreach ($users as $user) {
            if (!empty($user->email)) {
                array_push($data, $user);
            }
        }
        return $data;
    }
}
