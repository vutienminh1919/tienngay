<?php


namespace App\Service;


use App\Models\InfoCommission;
use App\Models\Investor;
use App\Models\User;
use App\Repository\CommissionRepository;
use App\Repository\ContractRepositoryInterface;
use App\Repository\InfoCommissionRepository;
use App\Repository\InterestRepository;
use App\Repository\InvestorRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\Auth\Authorization;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Psr7\str;

class UserService extends BaseService
{
    protected $userRepository;
    protected $voice_otp;
    protected $investorRepository;
    protected $contractRepository;
    protected $commissionRepository;
    protected $infoCommissionRepository;

    public function __construct(UserRepositoryInterface $userRepository,
                                VoiceOtp $voice_otp,
                                InvestorRepositoryInterface $investorRepository,
                                ContractRepositoryInterface $contractRepository,
                                CommissionRepository $commissionRepository,
                                InfoCommissionRepository $infoCommissionRepository)
    {
        $this->userRepository = $userRepository;
        $this->voice_otp = $voice_otp;
        $this->investorRepository = $investorRepository;
        $this->contractRepository = $contractRepository;
        $this->commissionRepository = $commissionRepository;
        $this->infoCommissionRepository = $infoCommissionRepository;
    }

    public function validate_create_user_new($request)
    {
        $validate = Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'required|email|max:255|unique:user',
            'phone' => 'required|regex:/[0-9]{10}/|unique:user',
            'password' => 'required|min:6',
            're_password' => 'required|min:6',
            'channels' => 'required',
        ], [
            'email.required' => 'Tên không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.max' => 'Tối đa 255 ký tự',
            'email.unique' => 'Email đã tồn tại',
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'phone.regex' => 'Số điện thoại không đúng định dạng',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            'password.min' => 'Mật khẩu tối thiếu 6 kí tự',
            're_password.required' => 'Bạn chưa nhập mật khẩu',
            're_password.min' => 'Mật khẩu tối thiếu 6 kí tự',
            'full_name.required' => 'Bạn chưa nhập tên đầy đủ',
            'channels.required' => 'Kênh không để trống'
        ]);
        return $validate;
    }

    public function create_user_investor_new($request)
    {
        $data = [
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'full_name' => $request->full_name,
            'status' => 'deactive',
            'channels' => $request->channels,
            'token_active' => $request->token_active,
            'timeExpried_active' => $request->timeExpried_active,
            'type' => User::TYPE_NHA_DAU_TU_APP,
            'source' => $request->source,
            'data_source' => $request->data_source,
            'referral_code' => $request->referral_code,
            'created_by' => "app_vfc@tienngay.vn"
        ];
        $this->userRepository->create($data);
    }

    public function validate_create_user_old($request)
    {
        $validate = Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/[0-9]{10}/',
            'password' => 'required|min:6',
            're_password' => 'required|min:6',
            'channels' => 'required',
        ], [
            'email.required' => 'Tên không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.max' => 'Tối đa 255 ký tự',
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'phone.regex' => 'Số điện thoại không đúng định dạng',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            'password.min' => 'Mật khẩu tối thiếu 6 kí tự',
            're_password.required' => 'Bạn chưa nhập mật khẩu',
            're_password.min' => 'Mật khẩu tối thiếu 6 kí tự',
            'full_name.required' => 'Bạn chưa nhập tên đầy đủ',
            'channels.required' => 'Kênh không để trống'
        ]);
        return $validate;
    }

    public function update_user_investor_old($id, $request)
    {
        $data = [
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'full_name' => $request->full_name,
            'status' => 'deactive',
            'channels' => $request->channels,
            'token_active' => $request->token_active,
            'timeExpried_active' => $request->timeExpried_active,
            'type' => User::TYPE_NHA_DAU_TU_APP,
            'source' => $request->source,
            'data_source' => $request->data_source,
            'referral_code' => $request->referral_code,
            'created_by' => "app_vfc@tienngay.vn"
        ];
        $this->userRepository->update($id, $data);
    }

    public function generateRandomPassword($length)
    {
        $alphabets = range('A', 'Z');
        $numbers = range('0', '9');
        $final_array = array_merge($alphabets, $numbers);
        $password = '';
        while ($length--) {
            $key = array_rand($final_array);
            $password .= $final_array[$key];
        }
        return $password;
    }

    public function create_user_ndt_uy_quyen($request)
    {
        $data = [
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($this->generateRandomPassword(6)),
            'full_name' => $request->full_name,
            'status' => 'active',
            'type' => User::TYPE_NHA_DAU_TU_UY_QUYEN,
            'created_by' => current_user()->email
        ];
        $user = $this->userRepository->create($data);
        return $user;
    }

    public function validate_create_user_ndt_uy_quyen($request)
    {
        $validate = Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'required|email|max:255|unique:user',
            'phone' => 'required|regex:/[0-9]{10}/|unique:user',
            'cmt' => 'required|unique:investor,identity',
        ], [
            'email.required' => 'Tên không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.max' => 'Tối đa 255 ký tự',
            'email.unique' => 'Email đã tồn tại',
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'phone.regex' => 'Số điện thoại không đúng định dạng',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'full_name.required' => 'Bạn chưa nhập tên đầy đủ',
            'cmt.required' => 'CMT/CCCD không để trống',
            'cmt.unique' => 'CMT/CCCD đã tồn tại',
        ]);
        return $validate;
    }

    public function validate_change_password($request)
    {
        $message = [];
        if (empty(($request->id))) {
            $message[] = 'ID không để trống';
        }

        if (empty(($request->password_new))) {
            $message[] = 'Mật khẩu mới không để trống';
        }

        $user = $this->userRepository->find($request->id);
        if (!empty($user['password'])) {
            if (empty(($request->password_old))) {
                $message[] = 'Mật khẩu hiện tại không để trống';
            }

            if (!Hash::check(($request->password_old), $user['password'])) {
                $message[] = 'Mật khẩu hiện tại không đúng';
            }

            if (Hash::check(($request->password_new), $user['password'])) {
                $message[] = 'Mật khẩu mới trùng mật khẩu cũ';
            }
        }

        return $message;
    }

    public function change_password($request)
    {
        $data = [
            "password" => Hash::make($request->password_new)
        ];
        $user = $this->userRepository->update($request->id, $data);
        return $user;
    }

    public function validate_link_social($request)
    {
        $message = [];

        if (empty($request->type_social)) {
            $message[] = "Type social không để trống";
        }

        if (!in_array($request->type_social, [User::FACEBOOK, User::APPLE, User::GOOGLE])) {
            $message[] = "Type Social không hợp lệ";
        }

        if (empty($request->provider_id)) {
            $message[] = "Tài khoản Social không để trống";
        }

        if ($request->type_social == User::APPLE) {
            $user_apple = $this->userRepository->findOne([User::ID_APPLE => $request->provider_id]);
            if ($user_apple) {
                if ($user_apple['id'] != $request->id) {
                    if ($user_apple['status'] == User::STATUS_ACTIVE) {
                        $message[] = "Tài khoản Apple đã tồn tại trong tài khoản khác";
                    } else {
                        $this->userRepository->delete($user_apple['id']);
                    }
                }
                if ($user_apple['id'] == $request->id) {
                    $message[] = "Tài khoản Apple đã liên kết";
                }
            }

        } elseif ($request->type_social == User::FACEBOOK) {
            $user_facebook = $this->userRepository->findOne([User::ID_FACEBOOK => $request->provider_id]);
            if ($user_facebook) {
                if ($user_facebook['id'] != $request->id) {
                    if ($user_facebook['status'] == User::STATUS_ACTIVE) {
                        $message[] = "Tài khoản Facebook đã tồn tại trong tài khoản khác";
                    } else {
                        $this->userRepository->delete($user_apple['id']);
                    }
                }
                if ($user_facebook['id'] == $request->id) {
                    $message[] = "Tài khoản Facebook đã liên kết";
                }
            }
        } elseif ($request->type_social == User::GOOGLE) {
            $user_google = $this->userRepository->findOne([User::ID_GOOGLE => $request->provider_id]);
            if ($user_google) {
                if ($user_google['id'] != $request->id) {
                    if ($user_google['status'] == User::STATUS_ACTIVE) {
                        $message[] = "Tài khoản Google đã tồn tại trong tài khoản khác";
                    } else {
                        $this->userRepository->delete($user_google['id']);
                    }
                }
                if ($user_google['id'] == $request->id) {
                    $message[] = "Tài khoản Google đã liên kết";
                }
            }
        }

        return $message;
    }

    public function login_social($request)
    {
        if ($request->type_social == User::APPLE) {
            $user = $this->userRepository->findOne([User::ID_APPLE => $request->provider_id]);
        } elseif ($request->type_social == User::FACEBOOK) {
            $user = $this->userRepository->findOne([User::ID_FACEBOOK => $request->provider_id]);
        } elseif ($request->type_social == User::GOOGLE) {
            $user = $this->userRepository->findOne([User::ID_GOOGLE => $request->provider_id]);
        }
        $data = [];
        if ($user) {
            if ($user['status'] == User::STATUS_ACTIVE) {
                $data = [
                    'phone' => $user['phone'],
                    'time' => time(),
                    'string' => uniqid()
                ];
                $token = Authorization::generateToken($data);
                $this->userRepository->update($user['id'], [User::TOKEN_APP => $token, User::LAST_LOGIN => Carbon::now()]);
                $data['token'] = $token;
            } else {
                $data['id'] = $user['id'];
                $data['checksum'] = hash_hmac('SHA256', $user['id'], $user['id']);
            }
        } else {
            $user_email = $this->userRepository->findOne([User::EMAIL => $request->email]);
            if ($user_email) {
                if ($user_email['status'] == User::STATUS_ACTIVE) {
                    $data['message'] = "Tài khoản Email đã tồn tại";
                } elseif ($user_email['status'] == User::STATUS_BLOCK) {
                    $data['message'] = "Tài khoản Email đang bị khóa";
                } elseif ($user_email['status'] == User::STATUS_DEACTIVE) {
                    $data['message'] = "Tài khoản Email đang bị khóa";
                } else {
                    $data = [
                        User::STATUS => User::STATUS_NEW,
                        User::TYPE => User::TYPE_NHA_DAU_TU_APP,
                        User::COLUMN_CREATED_BY => "app",
                        User::FULL_NAME => $request->name
                    ];
                    if ($request->type_social == User::APPLE) {
                        $data['id_apple'] = $request->provider_id;
                    } elseif ($request->type_social == User::GOOGLE) {
                        $data['id_google'] = $request->provider_id;
                    } elseif ($request->type_social == User::FACEBOOK) {
                        $data['id_facebook'] = $request->provider_id;
                    }
                    $user_new = $this->userRepository->update($user_email['id'], $data);
                    $data['id'] = $user_new['id'];
                    $data['checksum'] = hash_hmac('SHA256', $user_new['id'], $user_new['id']);
                }
            } else {
                $data = [
                    User::STATUS => User::STATUS_NEW,
                    User::TYPE => User::TYPE_NHA_DAU_TU_APP,
                    User::COLUMN_CREATED_BY => "app",
                    User::EMAIL => $request->email,
                    User::FULL_NAME => $request->name
                ];
                if ($request->type_social == User::APPLE) {
                    $data['id_apple'] = $request->provider_id;
                } elseif ($request->type_social == User::GOOGLE) {
                    $data['id_google'] = $request->provider_id;
                } elseif ($request->type_social == User::FACEBOOK) {
                    $data['id_facebook'] = $request->provider_id;
                }
                $user_new = $this->userRepository->create($data);
                $data['id'] = $user_new['id'];
                $data['checksum'] = hash_hmac('SHA256', $user_new['id'], $user_new['id']);
            }
        }
        return $data;
    }

    public function validate_login_social($request)
    {
        $message = [];

        if (empty($request->type_social)) {
            $message[] = "Type login không để trống";
        }

        if (!in_array($request->type_social, [User::FACEBOOK, User::APPLE, User::GOOGLE])) {
            $message[] = "Type Social không hợp lệ";
        }

        if (empty($request->provider_id)) {
            $message[] = "Tài khoản Social không để trống";
        }

        if (empty($request->email)) {
            $message[] = "Email đang trống";
        }

        if (empty($request->name)) {
            $message[] = "Tên không để trống";
        }

        return $message;
    }

    public function validate_phone_number_login_social($request)
    {
        $message = [];

        if (empty($request->id)) {
            $message[] = "Không tìm thấy tài khoản";
            return $message;
        } else {
            $user = $this->userRepository->find($request->id);
            if (!$user) {
                $message[] = "Không tìm thấy tài khoản";
                return $message;
            }
        }

        if (empty($request->checksum)) {
            $message[] = "Checksum không để trống";
        } else {
            $checksum = hash_hmac('SHA256', $request->id, $request->id);
            if ($request->checksum != $checksum) {
                $message[] = "Yêu cầu không hợp lệ";
            }
        }

        if (empty($request->phone_number)) {
            $message[] = "Số điện thoại không để trống";
        }

        $user_phone = $this->userRepository->findOne([User::PHONE => $request->phone_number]);
        if ($user_phone && $user_phone['id'] != $request->id) {
            if (in_array($user_phone['status'], [User::STATUS_NEW, User::STATUS_DEACTIVE])) {
                $this->userRepository->delete($user_phone['id']);
            } else {
                $message[] = "Số điện thoại đã tồn tại trong tài khoản khác, vui lòng đăng nhập và liên kết";
                if (in_array($user['status'], [User::STATUS_NEW, User::STATUS_DEACTIVE])) {
                    $this->userRepository->delete($user['id']);
                }
            }
        }
        return $message;
    }

    public function phone_number_login_social($request)
    {
        $result = [];
        $otp = rand(100000, 999999);
        $time_otp = Carbon::now()->addMinutes(2)->format('Y-m-d H:i:s');
        $user_referral = $this->userRepository->findOne([User::PHONE => $request->referral_code, User::STATUS => User::STATUS_ACTIVE]);
        $data = [
            User::PHONE => $request->phone_number,
            User::TOKEN_ACTIVE => $otp,
            User::TIME_EXPRIED_ACTIVE => $time_otp,
            User::REFERRAL_CODE => !empty($user_referral) ? $user_referral['phone'] : null,
            User::REFERRAL_ID => !empty($user_referral) ? $user_referral['id'] : null,
            User::REFERRAL_DATE => !empty($user_referral) ? Carbon::now() : null,
            User::SOURCE => $request->source,
            User::CHANNELS => $request->channels,
            User::IS_NEXTTECH => !empty($request->is_nexttech) ? (int)$request->is_nexttech : 0,

        ];
        $user = $this->userRepository->update($request->id, $data);
        $send_otp = $this->voice_otp->send_sms_voice_otp_v2($request->phone_number, $otp);
        $result['id'] = $user['id'];
        $result['otp'] = $send_otp;
        $string = (string)$user['id'] . "+" . (string)$otp;
        $result['checksum'] = hash_hmac("SHA256", $string, (string)$otp);
        return $result;
    }

    public function validate_active_phone_social($request)
    {
        $message = [];
        if (empty($request->otp)) {
            $message[] = "OTP không để trống";
            return $message;
        }
        if (empty($request->checksum)) {
            $message[] = "checksum không để trống";
            return $message;
        }
        if (empty($request->id)) {
            $message[] = "Không tìm thấy tài khoản";
            return $message;
        } else {
            $user = $this->userRepository->find($request->id);
            if (!$user) {
                $message[] = "Không tìm thấy tài khoản";
                return $message;
            } else {
//                $string = (string)$user['id'] . "+" . (string)$user['token_active'];
//                $hash = hash_hmac('SHA256', $string, (string)$user['token_active']);
//                if ($hash != $request->checksum) {
//                    $message[] = "Yêu cầu không hợp lệ";
//                }

                if ($user['token_active'] != $request->otp) {
                    $message[] = "OTP không chính xác";
                }
            }
        }
        return $message;
    }

    public function active_phone_social($request)
    {
        $user = $this->userRepository->findOne([User::COLUMN_ID => $request->id, User::TOKEN_ACTIVE => $request->otp]);
        $info = [
            'phone' => $user['phone'],
            'time' => time(),
            'string' => uniqid()
        ];
        $token = Authorization::generateToken($info);
        $user_new = $this->userRepository->update($request->id, [
            User::STATUS => User::STATUS_ACTIVE,
            User::TOKEN_ACTIVE => null,
            User::TIME_EXPRIED_ACTIVE => null,
            User::TOKEN_APP => $token,
            User::LAST_LOGIN => Carbon::now()
        ]);

        $data = [
            Investor::COLUMN_CODE => $user['phone'],
            Investor::COLUMN_PHONE_NUMBER => $user['phone'],
            Investor::COLUMN_STATUS => Investor::STATUS_NEW,
            Investor::COLUMN_EMAIL => $user['email'],
            Investor::COLUMN_USER_ID => $user['id'],
            Investor::COLUMN_NAME => $user['full_name'],
        ];
        $this->investorRepository->create($data);
        return $token;
    }

    public function link_social($request)
    {
        $data = [];
        if ($request->type_social == User::APPLE) {
            $data['id_apple'] = $request->provider_id;
        } elseif ($request->type_social == User::GOOGLE) {
            $data['id_google'] = $request->provider_id;
        } elseif ($request->type_social == User::FACEBOOK) {
            $data['id_facebook'] = $request->provider_id;
        }

        $user_new = $this->userRepository->update($request->id, $data);
        return $user_new;
    }

    public function app_register($request)
    {
        $data = [];
        $request->otp = rand(100000, 999999);
        $request->time = Carbon::now()->addMinutes(3);
        $user_old = $this->userRepository->findOne([User::PHONE => $request->phone, User::EMAIL => $request->email, User::STATUS => User::STATUS_ACTIVE]);
        if ($user_old) {
            $data['message'] = "Tài khoản đã tồn tại";
        } else {
            $user_phone = $this->userRepository->findOne([User::PHONE => $request->phone]);
            if ($user_phone) {
                if ($user_phone['status'] == User::STATUS_ACTIVE) {
                    $data['message'] = "Số điện thoại đã tồn tại";
                } elseif ($user_phone['status'] == User::STATUS_BLOCK) {
                    $data['message'] = "Tài khoản Số điện thoại đang bị khóa";
                } else {
                    $user_email = $this->userRepository->findOne([User::EMAIL => $request->email]);
                    if ($user_email) {
                        if ($user_phone['id'] != $user_email['id']) {
                            $data['message'] = "Email đã tồn tại trong tài khoản khác";
                        } else {
                            $user_new = $this->update_app_register_by_phone($user_phone['id'], $request);
                            $data['id'] = $user_phone['id'];
                            $send_otp = $this->voice_otp->send_sms_voice_otp_v2($request->phone, $request->otp);
                            $data['otp'] = $send_otp;
                        }
                    } else {
                        $user_new = $this->update_app_register_by_email($user_phone['id'], $request);
                        $data['id'] = $user_phone['id'];
                        $send_otp = $this->voice_otp->send_sms_voice_otp_v2($request->phone, $request->otp);
                        $data['otp'] = $send_otp;
                    }
                }
            } else {
                $user_email = $this->userRepository->findOne([User::EMAIL => $request->email]);
                if ($user_email) {
                    $data['message'] = "Email đã tồn tại trong tài khoản khác";
                } else {
                    $user_new = $this->create_app_register_by_email($request);
                    $data['id'] = $user_email['id'];
                    $send_otp = $this->voice_otp->send_sms_voice_otp_v2($request->phone, $request->otp);
                    $data['otp'] = $send_otp;
                }
            }
        }
        return $data;
    }

    public function update_app_register_by_email($id, $request)
    {
        $user_referral = $this->userRepository->findOne([User::PHONE => $request->referral_code, User::STATUS => User::STATUS_ACTIVE]);
        $data = [
            User::PASSWORD => Hash::make($request->password),
            User::FULL_NAME => $request->full_name,
            User::STATUS => User::STATUS_NEW,
            User::CHANNELS => $request->channels ?? null,
            User::TOKEN_ACTIVE => $request->otp,
            User::TIME_EXPRIED_ACTIVE => $request->time,
            User::TYPE => User::TYPE_NHA_DAU_TU_APP,
            User::SOURCE => $request->source,
            User::DATA_SOURCE => $request->data_source,
            User::REFERRAL_CODE => $request->referral_code ?? null,
            User::COLUMN_CREATED_BY => "app_vfc@tienngay.vn",
            User::EMAIL => $request->email,
            User::REFERRAL_ID => !empty($user_referral) ? $user_referral['id'] : null,
            User::REFERRAL_DATE => !empty($user_referral) ? Carbon::now() : null,
            User::IS_NEXTTECH => !empty($request->is_nexttech) ? (int)$request->is_nexttech : 0,
        ];

        $user = $this->userRepository->update($id, $data);
        return $user;
    }

    public function create_app_register_by_email($request)
    {
        $user_referral = $this->userRepository->findOne([User::PHONE => $request->referral_code, User::STATUS => User::STATUS_ACTIVE]);
        $data = [
            User::PASSWORD => Hash::make($request->password),
            User::PHONE => $request->phone,
            User::EMAIL => $request->email,
            User::FULL_NAME => $request->full_name,
            User::STATUS => User::STATUS_NEW,
            User::CHANNELS => $request->channels ?? null,
            User::TOKEN_ACTIVE => $request->otp,
            User::TIME_EXPRIED_ACTIVE => $request->time,
            User::TYPE => User::TYPE_NHA_DAU_TU_APP,
            User::SOURCE => $request->source,
            User::DATA_SOURCE => $request->data_source,
            User::REFERRAL_CODE => $request->referral_code ?? null,
            User::COLUMN_CREATED_BY => "app_vfc@tienngay.vn",
            User::REFERRAL_ID => !empty($user_referral) ? $user_referral['id'] : null,
            User::REFERRAL_DATE => !empty($user_referral) ? Carbon::now() : null,
            User::IS_NEXTTECH => !empty($request->is_nexttech) ? (int)$request->is_nexttech : 0,
        ];
        $user = $this->userRepository->create($data);
        return $user;
    }

    public function validate_app_register($request)
    {
        $validate = Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/[0-9]{10}/',
            'password' => 'required|min:6',
            're_password' => 'required|min:6',
            'channels' => 'required',
        ], [
            'email.required' => 'Tên không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.max' => 'Tối đa 255 ký tự',
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'phone.regex' => 'Số điện thoại không đúng định dạng',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            'password.min' => 'Mật khẩu tối thiếu 6 kí tự',
            're_password.required' => 'Bạn chưa nhập mật khẩu',
            're_password.min' => 'Mật khẩu tối thiếu 6 kí tự',
            'full_name.required' => 'Bạn chưa nhập tên đầy đủ',
            'channels.required' => 'Kênh không để trống'
        ]);
        return $validate;
    }

    public function update_app_register_by_phone($id, $request)
    {
        $user_referral = $this->userRepository->findOne([User::PHONE => $request->referral_code, User::STATUS => User::STATUS_ACTIVE]);
        $data = [
            User::PASSWORD => Hash::make($request->password),
            User::FULL_NAME => $request->full_name,
            User::STATUS => User::STATUS_NEW,
            User::CHANNELS => $request->channels ?? null,
            User::TOKEN_ACTIVE => $request->otp,
            User::TIME_EXPRIED_ACTIVE => $request->time,
            User::TYPE => User::TYPE_NHA_DAU_TU_APP,
            User::SOURCE => $request->source,
            User::DATA_SOURCE => $request->data_source,
            User::REFERRAL_CODE => $request->referral_code ?? null,
            User::COLUMN_CREATED_BY => "app_vfc@tienngay.vn",
            User::REFERRAL_ID => !empty($user_referral) ? $user_referral['id'] : null,
            User::REFERRAL_DATE => !empty($user_referral) ? Carbon::now() : null,
            User::IS_NEXTTECH => !empty($request->is_nexttech) ? (int)$request->is_nexttech : 0,
        ];

        $user = $this->userRepository->update($id, $data);
        return $user;
    }

    public function block_account($request)
    {
        $result = [];
        $otp = rand(1000, 9999);
        $time_otp = Carbon::now()->addMinutes(5)->format('Y-m-d H:i:s');
        $data = [
            User::BLOCK_OTP => $otp,
            User::TIME_BLOCK_OTP => $time_otp,
        ];
        $user = $this->userRepository->update($request->id, $data);
        $send_otp = $this->voice_otp->send_sms_voice_otp_v2($user['phone'], $otp);
        $result['user'] = $user;
        $string = $user['id'] . '+' . $user['block_otp'];
        $result['checksum'] = hash_hmac('SHA256', $string, $user['block_otp']);
        $result['otp'] = $send_otp;
        return $result;
    }

    public function validate_confirm_block_account($request)
    {
        $message = [];
        if (empty($request->id)) {
            $message[] = "Không tìm thấy người dùng";
            return $message;
        }

        if (empty($request->otp)) {
            $message[] = "Mã xác thực không để trống";
            return $message;
        }

        $user = $this->userRepository->find($request->id);
        if (!$user) {
            $message[] = "Người dùng không hợp lệ";
            return $message;
        } else {
            if ($request->otp != $user['block_otp']) {
                $message[] = "Mã xác thực không đúng";
                return $message;
            }
        }

        if (empty($request->checksum)) {
            $message[] = "Checksum không để trống";
            return $message;
        }

        $string = $user['id'] . '+' . $user['block_otp'];
        $hash = hash_hmac('SHA256', $string, $user['block_otp']);
        if ($hash != $request->checksum) {
            $message[] = "Yêu cầu không hợp lệ";
            return $message;
        }

        if (strtotime(Carbon::now()) > strtotime($user['time_block_otp'])) {
            $message[] = "Hết thời gian chờ ";
            return $message;
        }

        return $message;
    }

    public function confirm_block_account($request)
    {
        $user = $this->userRepository->update($request->id, [
            User::BLOCK_OTP => null,
            User::TIME_BLOCK_OTP => null,
            User::STATUS => User::STATUS_BLOCK,
            User::BLOCK_AT => Carbon::now(),
        ]);
        return $user;
    }

    public function validate_block_account($request)
    {
        $message = [];
        if (empty($request->id)) {
            $message[] = "Không tìm thấy người dùng";
            return $message;
        }
        return $message;
    }

    public function check_referral_code($request)
    {
        $message = [];
        if (!empty($request->referral_code)) {
            $user_referral = $this->userRepository->findOne([User::PHONE => $request->referral_code, User::STATUS => User::STATUS_ACTIVE]);
            if (!$user_referral) {
                $message[] = "Mã giới thiệu không tồn tại";
                return $message;
            }
        }
        return $message;
    }

    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    public function commission_investor($user, $request)
    {
        $year = $request->year ?? date('Y');
        $month = $request->month ?? date('m');
        $timeline = $year . '-' . $month;
        $info = $this->infoCommissionRepository->findOne([InfoCommission::TIME => $timeline, InfoCommission::USER_ID => $user['id'], InfoCommission::DETAIL_ID => null]);
        $data = [];
        $data['total'] = [];
        $data['detail'] = [];
        if ($info) {
            $data['total'] = [
                'total_money' => number_format_vn($info['total_money']) . ' VND',
                'commission' => $info['commission'],
                'money_commission' => number_format_vn($info['money_commission']) . ' VND',
                'total_money_number' => $info['total_money'],
                'money_commission_number' => $info['money_commission']
            ];
            $detail = $this->infoCommissionRepository->commission_investor_group($info['id']);
            foreach ($detail as $de) {
                $referral = $this->userRepository->find($de->user_id);
                $data['detail'][] = [
                    'name' => $referral['full_name'],
                    'total_money' => number_format_vn($de->total_money) . ' VND',
                    'money_commission' => number_format_vn($de->money_commission) . ' VND',
                    'total_money_number' => $de->total_money,
                    'money_commission_number' => $de->money_commission

                ];
            }
        }


        return $data;
    }

    public function get_all_commission($request)
    {
        $info_commission = $this->infoCommissionRepository->get_all_commission($request);
        return $info_commission;
    }

    public function detail_commission_investor($user, $request)
    {
        $data = [];
        $data['total'] = [];
        $data['detail'] = [];
        $request->user_id = $user['id'];
        $user_referral = $this->infoCommissionRepository->commission_investor($request);
        if ($user_referral) {
            $data['total'] = [
                'month' => $request->month ?? date('Y-m'),
                'total_money' => $user_referral->total_money,
                'commission' => $user_referral->commission,
                'money_commission' => $user_referral->money_commission,
                'full_name' => $user_referral->full_name,
                'phone' => $user_referral->phone
            ];
            $request->detail_id = $user_referral->id;
            $detail = $this->infoCommissionRepository->detail_commission_investor($request);
            foreach ($detail as $item) {
                $contract = $this->contractRepository->find($item->contract_id);
                $data['detail'][] = [
                    'nha_dau_tu' => $item->full_name,
                    'ma_hop_dong' => $contract['code_contract_disbursement'],
                    'so_tien' => $item->total_money,
                    'ngay_giao_dich' => $contract['created_at'],
                    'thoi_gian' => $contract['number_day_loan'] / 30,
                    'hinh_thuc' => $contract['type_interest'] == 1 ? 'Dư nợ giảm dần' : 'Lãi hàng tháng, gốc cuối kỳ',
                    'ti_le_thuong' => $item->commission,
                    'tien_thuong' => $item->money_commission,
                    'so_tien_dau_tu' => $contract['amount_money']
                ];
            }
        }
        return $data;
    }

    public function excel_all_commission($request)
    {
        $info_commission = $this->infoCommissionRepository->excel_all_commission($request);
        foreach ($info_commission as $item) {
            $parent = $this->infoCommissionRepository->find($item->detail_id);
            $item->ref = $parent->user()->select('full_name', 'id')->first();
            $investor = $this->investorRepository->findOne([Investor::COLUMN_USER_ID => $item->ref->id]);
            $call = $this->userRepository->find($investor['assign_call']);
            $item->call = $call['email'];
        }
        return $info_commission;
    }

    public function validate_import_commission($request)
    {
        $message = [];
        if (empty($request->investor_code)) {
            $message[] = "Mã người giới thiệu đang trống";
            return $message;
        }

        if (empty($request->refferral_code)) {
            $message[] = "Mã người được giới thiệu đang trống";
            return $message;
        }

        $user_investor_code = $this->userRepository->findOne([User::PHONE => $request->investor_code, User::STATUS => User::STATUS_ACTIVE]);
        if (!$user_investor_code) {
            $message[] = "Mã người giới thiệu không tồn tại";
        }

        $user_refferral_code = $this->userRepository->findOne([User::PHONE => $request->refferral_code, User::STATUS => User::STATUS_ACTIVE]);
        if (!$user_refferral_code) {
            $message[] = "Mã người được giới thiệu không tồn tại";
        } else {
            if (!empty($user_refferral_code['referral_id'])) {
                $message[] = "Mã người được giới thiệu đã tồn tại người giói thiệu";
            }
        }

        if (empty($request->date)) {
            $message[] = "Ngày giới thiệu đang trống";
        }

        return $message;
    }

    public function import_commission($request)
    {
        $user_investor_code = $this->userRepository->findOne([User::PHONE => $request->investor_code, User::STATUS => User::STATUS_ACTIVE]);
        $user_refferral_code = $this->userRepository->findOne([User::PHONE => $request->refferral_code, User::STATUS => User::STATUS_ACTIVE]);

        $user_refferral_code_new = $this->userRepository->update($user_refferral_code['id'], [
            User::REFERRAL_ID => $user_investor_code['id'],
            User::REFERRAL_DATE => $request->date,
            User::REFERRAL_CODE => $request->investor_code
        ]);
        return $user_refferral_code_new;
    }

    public function commission_group_cvkd($request)
    {
        $data = [];
        $year = $request->year ?? date('Y');
        $month = $request->month ?? date('m');
        $timeline = $year . '-' . $month;
        $data['total'] = 0;
        $data['commission'] = 0;
        $phones = explode(',', $request->phone);
        $users_id = $this->userRepository->findGroupUserPhone($phones);
        if ($users_id) {
            $result = $this->infoCommissionRepository->commission_investor_group_many($users_id, $timeline);
            if ($result) {
                $data['total'] = $result->total_money;
                $data['commission'] = $result->money_commission;
            }
        }
        return $data;
    }

    public function commission_v1($user, $request)
    {
        $data = [];
        $data['total'] = [];
        $data['detail'] = [];
        $date = get_created_at_with_year($request->month ?? date('m'), $request->year ?? date('Y'));
        $request->fdate = $date['start'];
        $request->tdate = $date['end'];
        $user_referral = $this->userRepository->findMany([User::REFERRAL_ID => $user['id'], User::STATUS => User::STATUS_ACTIVE]);
        $total_all_invest = $this->contractRepository->get_all_contract_by_referral($request, $user['id'])->total_invest;
        if ($total_all_invest) {
            $type_referral = !empty($user['type_referral']) ? $user['type_referral'] : 'app';
            $commission = $this->commissionRepository->findCommission((int)$total_all_invest, $type_referral, $request);
            $data['total'] = [
                'total_money' => number_format_vn($total_all_invest) . ' VND',
                'commission' => $commission['commission'],
                'money_commission' => number_format_vn($total_all_invest * $commission['commission'] / 100) . ' VND',
                'total_money_number' => $total_all_invest,
                'money_commission_number' => $total_all_invest * $commission['commission'] / 100
            ];
            foreach ($user_referral as $item) {
                $investor = $item->investor()->where(Investor::COLUMN_STATUS, Investor::STATUS_ACTIVE)->first();
                $total_invest = $this->contractRepository->get_contract_by_referral($request, $investor['id'])->total_invest;
                if ($total_invest) {
                    $data['detail'][] = [
                        'name' => $investor['name'],
                        'total_money' => number_format_vn($total_invest) . ' VND',
                        'money_commission' => number_format_vn($total_invest * $commission['commission'] / 100) . ' VND',
                        'total_money_number' => $total_invest,
                        'money_commission_number' => $total_invest * $commission['commission'] / 100,

                    ];
                }
            }
        }
        return $data;
    }

    public function lay_ngay_trong_ky_chi_tra($contract, $request, $date)
    {
        $start_date_contract = date('Y-m', $contract->start_date);
        $due_date_contract = date('Y-m', $contract->due_date);
        $daysInMonth = Carbon::parse($date)->daysInMonth;
        if (strtotime($start_date_contract) == strtotime($date)) {
            $day = $daysInMonth - date('d', $contract->start_date);
        } elseif (strtotime($start_date_contract) < strtotime($date) && strtotime($due_date_contract) > strtotime($date)) {
            $day = $daysInMonth;
        } else {
            $day = (int)date('d', $contract->due_date);
        }
        return $day;
    }

    public function check_month($month)
    {
        if (!empty($month)) {
            if (strlen($month) < 2) {
                $m = '0' . $month;
            } else {
                $m = $month;
            }
        } else {
            $m = date('m');
        }
        return $m;
    }

    public function commission_contract_v2($contract, $request, $current_date, $commission, $user_id)
    {
        $nguoi_gioi_thieu = $this->userRepository->findOne(['id' => $user_id]);
        $ti_le_hoa_hong = $commission['commission'];
        $so_ngay_trong_ky = $this->lay_ngay_trong_ky_chi_tra($contract, $request, $current_date);
        $so_tien_tinh_hoa_hong_thuc_te = round($contract->amount_money * $so_ngay_trong_ky / Carbon::parse($current_date)->daysInMonth);
        $hoa_hong = round($so_tien_tinh_hoa_hong_thuc_te * $so_ngay_trong_ky / 365 * $commission['commission'] / 100);
        if ($nguoi_gioi_thieu['is_nexttech'] == User::NEXTER) {
            if ($contract->start_date >= strtotime("2023-02-01")) {
                $hoa_hong = round($hoa_hong / 2);
                $ti_le_hoa_hong = $ti_le_hoa_hong / 2;
            }
        }
        $data = [
            'name' => $contract->name,
            'total_money' => number_format_vn($so_tien_tinh_hoa_hong_thuc_te) . ' VND',
            'money_commission' => number_format_vn($hoa_hong) . ' VND',
            'total_money_number' => $so_tien_tinh_hoa_hong_thuc_te,
            'money_commission_number' => $hoa_hong,
            'so_ngay' => $so_ngay_trong_ky,
            'commission' => $ti_le_hoa_hong
        ];

        return $data;
    }
}
