<?php

namespace Modules\AppKhachHang\Http\Controllers;

use Modules\AppKhachHang\Service\Cvs;
use Modules\MongodbCore\Repositories\UserCpanelRepository;
use Modules\MongodbCore\Entities\UserCpanel;
use Modules\MongodbCore\Entities\AppkhEkycLog;

class AuthController extends BaseController
{
    private $userCpanelRepository;

    public function __construct(UserCpanelRepository $userCpanelRepository, Cvs $cvs)
    {
        $this->userCpanelRepository = $userCpanelRepository;
        $this->cvs = $cvs;
    }

    public function getUserWaitAuth()
    {
        $result = $this->userCpanelRepository->getUserWaitingAuth();
        return $result;
    }

    public function checkEkyc()
    {
        $user = $this->getUserWaitAuth();
        foreach ($user as $item) {
            $this->ekyc($item);
        }
        $responses = array(
            'status' => BaseController::HTTP_OK,
            'message' => "Success",
        );
        return response()->json($responses);
    }

    public function ekyc($user)
    {
        $data = [
            'front_card' => $user['front_facing_card'],
            'back_card' => $user['card_back'],
        ];
        $data1 = $this->cvs->ekyc_cards($data);
        $message = "";
        $userInfo = [];
        if ($data1) {
            if (isset($data1->errorCode) && $data1->errorCode == "0") {
                if (!empty($data1->data[0]) && !empty($data1->data[1])) {
                    if ($data1->data[0]->valid == "True" && $data1->data[1]->valid == "True") {

                        if (!empty($data1->data[1]->info->address)) {
                            $userInfo['address'] = $data1->data[1]->info->address;
                        }
//                        if (!empty($data1->data[1]->info->name)) {
//                            $userInfo['name'] = $data1->data[1]->info->name;
//                        }
//                        if (!empty($data1->data[1]->info->id)) {
//                            $userInfo['identify'] = $data1->data[1]->info->id;
//                        }
//                        if (!empty($data1->data[0]->info->issue_date)) {
//                            $date_range = $data1->data[0]->info->issue_date;
//                            if (str_contains($date_range, "-")) {
//                                $arr = explode('-', $date_range);
//                            } else {
//                                $arr = explode('/', $date_range);
//                            }
//                            $userInfo['date_range'] = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
//                        }
//                        if (!empty($data1->data[0]->info->issued_at)) {
//                            $userInfo['issued_by'] = $data1->data[0]->info->issued_at;
//                        }

                        $dataUpdate = [
                            UserCpanel::ADDRESS => $userInfo['address']
                        ];
                        $update = UserCpanel::where(UserCpanel::ID, $user['_id'])->update($dataUpdate);
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
            $user_new = $this->userCpanelRepository->verifiedUser($user['_id']);
            $dataLog = [
                AppkhEkycLog::USER_ID => $user['_id'],
                AppkhEkycLog::RESPONSE => $data1,
                AppkhEkycLog::TYPE => AppkhEkycLog::SUCCESS,
                AppkhEkycLog::CREATED_AT => time(),
            ];
            AppkhEkycLog::insert($dataLog);
        } else {
            $user_new = $this->userCpanelRepository->notVerifiedUser($user['_id']);
            $dataLog = [
                AppkhEkycLog::USER_ID => $user['_id'],
                AppkhEkycLog::RESPONSE => $data1,
                AppkhEkycLog::IMAGE => [
                    'front_card' => $user['front_facing_card'],
                    'back_card' => $user['card_back'],
                    'avatar' => $user['portrait']
                ],
                AppkhEkycLog::TYPE => AppkhEkycLog::FAILED,
                AppkhEkycLog::CREATED_AT => time(),
            ];
            AppkhEkycLog::insert($dataLog);
        }
        return $message;
    }

}
