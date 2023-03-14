<?php

namespace Modules\Hcns\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Modules\MongodbCore\Repositories\HcnsRepository;
use Modules\MongodbCore\Repositories\Interfaces\HcnsRepositoryInterface as HcnsRepositoryInterface;
use Modules\MongodbCore\Entities\Hcns;
use Modules\Hcns\Service\HcnsApi;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Modules\MongodbCore\Repositories\RoleRepository;
use Modules\MongodbCore\Repositories\Interfaces\RoleRepositoryInterface as RoleRepositoryInterface;

class HcnsController extends BaseController
{
    private $hcnsRepository;
    private $roleRepository;
    /**
      * @OA\Info(
      *     version="1.0",
      * )
      */
    public function __construct(
        HcnsRepository $hcnsRepository,
        RoleRepository $roleRepository
    ) 
    {
        $this->hcnsRepo = $hcnsRepository;
        $this->roleRepo = $roleRepository;
    }

    /**
    * Create a new blacklist's record
    * @param Request $request
    * @return json
    */
    public function saveRecord(Request $request) {
        $data = $request->all();

        Log::channel('hcns')->info('request data create' . print_r($data, true));
        $validator = $this->validate($data);
        Log::channel('hcns')->info("validator ". $validator->fails());
        if($validator->fails()) {
            Log::channel('hcns')->info('createRecord validator' .$validator->errors()->first());
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validator->errors()->first(),
            ]);
        }
        $input = [
            Hcns::USER_NAME                  => $data['user_name'],
            Hcns::USER_PHONE                 => !empty($data['user_phone']) ? $data['user_phone'] : "" , 
            Hcns::USER_IDENTIFY              => $data['user_identify'],
            Hcns::USER_EMAIL                 => !empty($data['user_email']) ? $data['user_email'] : "" ,
            Hcns::DAY_OFF                    => !empty($data['day_off']) ? $data['day_off'] : "" ,
            Hcns::REASON_FOR_LEAVE           => !empty($data['reason_for_leave']) ? $data['reason_for_leave'] : "" ,
            Hcns::PATH                       => !empty($data['url']) ? $data['url'] : [],
            Hcns::CREATED_BY                 => !empty($data['created_by']) ? $data['created_by'] : '',
            Hcns::ROOM                       => !empty($data['room']) ? $data['room'] : "" ,
            Hcns::DAY_ON                     => !empty($data['day_on']) ? $data['day_on'] : "" ,
            Hcns::POSITION                   => !empty($data['position']) ? $data['position'] : "" ,
            Hcns::WORK_PLACE                 => !empty($data['work_place']) ? $data['work_place'] : "" ,
            Hcns::DATE_RANGE                 => !empty($data['date_range']) ? $data['date_range'] : "" ,
            Hcns::ISSUED_BY                  => !empty($data['issued_by']) ? $data['issued_by'] : "" ,
            Hcns::TEMPORARY_ADDRESS          => !empty($data['temporary_address']) ? $data['temporary_address'] : "" ,
            Hcns::PERMANENT_ADDRESS          => !empty($data['permanent_address']) ? $data['permanent_address'] : "" ,
            Hcns::USER_PASSPORT              => !empty($data['user_passport']) ? $data['user_passport'] : "" ,
        ];
        Log::channel('hcns')->info('input data' . print_r($input, true));
        $create =  $this->hcnsRepo->createRecord($input);
        Log::channel('hcns')->info('create data' . print_r($create, true));
        if (!$create) {
            $response = [
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => BaseController::ERROR,
                BaseController::DATA => $input
            ];
        } else {
            $response = [
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $create,

            ];
        }
        Log::channel('hcns')->info('create response' . print_r($response, true));
        return response()->json($response);
    }

    /**
    * update a blacklist's record
    * @param Request $request
    * @param blacklist_hcns collection's id
    * @return json
    */
    public function updateRecord(Request $request, $id) {
        $data = $request->all();
        Log::channel('hcns')->info('request data update' . print_r($data, true));
        $validator = $this->validate($data);
        Log::channel('hcns')->info("validator ". $validator->fails());
        if($validator->fails()) {
            Log::channel('hcns')->info('updateRecord validator' .$validator->errors()->first());
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validator->errors()->first(),
            ]);
        }
        $input = [
            Hcns::USER_NAME                  => $data['user_name'],
            Hcns::USER_PHONE                 => !empty($data['user_phone']) ? $data['user_phone'] : "" , 
            Hcns::USER_IDENTIFY              => $data['user_identify'],
            Hcns::USER_EMAIL                 => !empty($data['user_email']) ? $data['user_email'] : "" ,
            Hcns::DAY_OFF                    => !empty($data['day_off']) ? $data['day_off'] : "" ,
            Hcns::REASON_FOR_LEAVE           => !empty($data['reason_for_leave']) ? $data['reason_for_leave'] : "" ,
            Hcns::PATH                       => !empty($data['url']) ? $data['url'] : [],
            Hcns::CREATED_BY                 => !empty($data['created_by']) ? $data['created_by'] : '',
            Hcns::ROOM                       => !empty($data['room']) ? $data['room'] : "" ,
            Hcns::DAY_ON                     => !empty($data['day_on']) ? $data['day_on'] : "" ,
            Hcns::POSITION                   => !empty($data['position']) ? $data['position'] : "" ,
            Hcns::WORK_PLACE                 => !empty($data['work_place']) ? $data['work_place'] : "" ,
            Hcns::DATE_RANGE                 => !empty($data['date_range']) ? $data['date_range'] : "" ,
            Hcns::ISSUED_BY                  => !empty($data['issued_by']) ? $data['issued_by'] : "" ,
            Hcns::TEMPORARY_ADDRESS          => !empty($data['temporary_address']) ? $data['temporary_address'] : "" ,
            Hcns::PERMANENT_ADDRESS          => !empty($data['permanent_address']) ? $data['permanent_address'] : "" ,
            Hcns::USER_PASSPORT              => !empty($data['user_passport']) ? $data['user_passport'] : "" ,
        ];
        Log::channel('hcns')->info('updateRecord input data' . print_r($input, true));
        $update =  $this->hcnsRepo->updateRecord($input, $id);
        Log::channel('hcns')->info('updateRecord update data' . print_r($update, true));
        if (!$update) {
            $response = [
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => BaseController::ERROR,
                BaseController::DATA => $input
            ];
        } else {
            $response = [
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $update,

            ];
        }
        Log::channel('hcns')->info('updateRecord update response' . print_r($response, true));
        return response()->json($response);
    }

    /**
    * get blacklist's records
    * @return json
    */
    public function getAllRecord() {
        $listRecord = $this->hcnsRepo->getAllRecord();
        Log::channel('hcns')->info('All Record' . print_r($listRecord));
        if (!$listRecord) {
            $response = [
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => [],
            ];
        } else {
            $response = [
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $listRecord,
            ];
        }
        Log::channel('hcns')->info('response' . print_r($response, true));
        return response()->json($response);
    }

    /**
    * validate data
    * @param Array $dataPost
    * @return Validator object
    */
    public function validate($dataPost) {
        $validator = Validator::make($dataPost, [
            'user_name'         => 'required|max:50',
            'user_identify'     => 'required',
            'user_email'        => 'email:rfc,dns|nullable',
        ],
        [
            'user_name.required' => 'Tên nhân sự nghỉ việc không để trống',
            'user_identify.required'    => 'Số CMND/CCCD không được để trống',
            'user_identify.digits_between'    => 'Số CMND/CCCD không đúng định dạng',
            'user_email.email'    => 'Email không đúng định dạng',
        ]);
        $validator->after(function() use ($validator, $dataPost) {
            $identify = $dataPost['user_identify'];

            if (preg_match('/^\d{9}$/', $identify) || preg_match('/^\d{12}$/', $identify)) {
                //pass
            } else {
                $validator->errors()->add('user_identify', 'Số CMND/CCCD phải là 9 hoặc 12 chữ số');
            
            }
            if(isset($dataPost['user_phone'])) {
                $user_phone = $dataPost['user_phone'];
                if (preg_match('/^0[1-9][0-9]{8}$/', $user_phone)) {
                    //do nothing
                } else {
                    $validator->errors()->add('user_phone', 'Số điện thoại phải bắt đầu bằng số 0 và đủ 10 số');
                }
            }
            if(isset($dataPost['user_passport'])) {
                $user_passport = $dataPost['user_passport'];
                if (!preg_match('/^[A-Z][0-9]{7}$/', $user_passport)) {
                    $validator->errors()->add('user_passport', 'Số hộ chiếu bắt đầu bằng chữ in hoa và 7 số');
                }
            }
            if(!empty($dataPost['day_off']) && !empty($dataPost['day_on'])) {
                $day_off = strtotime($dataPost['day_off']);
                $day_on = strtotime($dataPost['day_on']);
                if ($day_on > $day_off) {
                    $validator->errors()->add('day_on', "Ngày bắt đầu không được lớn hơn ngày kết thúc");
                }
            }
        });
        return $validator;
    }

    /**
     * get all email hcns.
     * @param 
     * @return Response
     */
    public function getAllHcns() {
        $email = $this->roleRepo->getAllHcns();
        $response = [
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $email,
        ];
        return response()->json($response);
    }
}