<?php


namespace App\Service;


use App\Models\LeadInvestor;
use App\Models\Log_vbee_ndt;
use App\Repository\CallRepository;
use App\Repository\LeadInvestorRepositoryInterface;
use App\Repository\LogVbeeNdtRepository;
use http\Client\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LeadInvestorService extends BaseService
{
    protected $leadInvestorRepository;
    protected $callRepository;
    protected $logVbeeNdtRepository;

    public function __construct(LeadInvestorRepositoryInterface $leadInvestorRepository,CallRepository $callRepository,
                                LogVbeeNdtRepository $logVbeeNdtRepository)
    {
        $this->leadInvestorRepository = $leadInvestorRepository;
        $this->callRepository = $callRepository;
        $this->logVbeeNdtRepository = $logVbeeNdtRepository;
    }

    public function validateImportInvestor($request)
    {
        $validate = Validator::make($request->all(), [
//            'name' => 'required',
            'phone' => 'required',
        ], [
//            'name.required' => 'Tên không để trống',
            'phone.required' => 'Số điện thoại không để trống',
        ]);
        return $validate;
    }

    public function import_create($request)
    {
        $phone_link = '';
        if (isset($request->phone_link)) {
            if (substr($request->phone_link, 0, 1) !== '0') {
                $phone_link = '0' . $request->phone_link;
            } else {
                $phone_link = $request->phone_link;
            }
        }
        $data = [
            LeadInvestor::COLUMN_NAME => $request->name,
            LeadInvestor::COLUMN_PHONE => $request->phone_number,
            LeadInvestor::COLUMN_PHONE_LINK => $phone_link,
            LeadInvestor::COLUMN_STATUS => $request->status,
            LeadInvestor::COLUMN_SOURCE => $request->source,
            LeadInvestor::COLUMN_CREATED_BY => current_user()->email,
            LeadInvestor::COLUMN_LEAD_STATUS => LeadInvestor::COLUMN_LEAD_STATUS_BLOCK
        ];
        $this->leadInvestorRepository->create($data);
    }

    public function validate_call_update($request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Tên nhà đầu tư không để trống',
        ]);
        return $validate;
    }

    public function call_update_investor($request)
    {
        $update = [
            LeadInvestor::COLUMN_EMAIL => $request->email,
            LeadInvestor::COLUMN_IDENTITY => $request->identity,
            LeadInvestor::COLUMN_NAME => $request->name,
            LeadInvestor::COLUMN_BIRTHDAY => $request->birthday,
            LeadInvestor::COLUMN_CITY => $request->city,
            LeadInvestor::COLUMN_STATUS_CALL => $request->status
        ];
        $data = $this->leadInvestorRepository->update($request->id, $update);
        return $data;
    }

    public function app_create_log($request, $data)
    {
        $this->logInvestorRepository->create([
            LogInvestor::COLUMN_REQUEST => json_encode($request),
            LogInvestor::COLUMN_RESPONSE => json_encode($data),
            LogInvestor::COLUMN_CREATED_BY => $data->phone_number,
            LogInvestor::COLUMN_TYPE => 'update'
        ]);
    }

    public function insert_lead_invest($request)
    {
        $data = [
            LeadInvestor::COLUMN_NAME => $request->name,
            LeadInvestor::COLUMN_PHONE => $request->phone,
            LeadInvestor::COLUMN_UTM_CAMPAIGN => $request->utm_campaign,
            LeadInvestor::COLUMN_UTM_LINK => $request->utm_link,
            LeadInvestor::COLUMN_UTM_SOURCE => $request->utm_source,
            LeadInvestor::COLUMN_SOURCE => $request->utm_source,
            LeadInvestor::COLUMN_LEAD_STATUS => LeadInvestor::COLUMN_LEAD_STATUS_BLOCK
        ];
        $insert_lead = $this->leadInvestorRepository->create($data);
        return $insert_lead;
    }

    public function validateInsertLeadInvest($request)
    {
        $validate = Validator::make($request->all(), [
            'phone' => 'required|unique:lead_investor',
        ], [
            'phone.required' => 'Số điện thoại không để trống',
            'phone.unique' => 'Bạn đã đăng kí, chúng tôi sẽ liên hệ trong thời gian sớm nhất. Xin cảm ơn.',
        ]);

        return $validate;
    }

//update lead_invetor_priority
    public function missed_call($request)
    {
        Log::info('missed_call request : '. print_r($request->all(), true));
        $phone = isset($request->phone) ? $request->phone : NULL;
        Log::info('missed_call phone : '. $phone);
        $result = $this->leadInvestorRepository->find_phone($phone);
        if (!empty($result)) {
            $result_missed_call = [
                LeadInvestor::COLUMN_PRIORITY => LeadInvestor::COLUMN_PRIORITY_ONE,
            ];
            $result1 = $this->leadInvestorRepository->update_missed_call( $result[0]['phone'],$result_missed_call);
            Log::info('missed_call update : '. print_r($result_missed_call, true));
        } else {
            $data = [
                 LeadInvestor::COLUMN_PRIORITY => LeadInvestor::COLUMN_PRIORITY_ONE,
                 LeadInvestor::COLUMN_PHONE=> $phone,
                 LeadInvestor::COLUMN_SOURCE=> LeadInvestor::COLUMN_SOURCE_VBEE,
            ];
            $result1 = $this->leadInvestorRepository->create($data);
            Log::info('missed_call create : '. print_r($data, true));
        }
       return $result1;
    }

//import vbee invetor

    public function import_vbee()
    {
        $bool = false;
        $secret_key = env('SECRET_KEY_VBEE');
        $access_token = env('ACCESS_TOKEN_VBEE');
        $campaign_id = 21843;
        $count = 0;
		$data = [];
        $start = strtotime(trim(date('Y-m-d')) . ' 8:30:00');
		$end = strtotime(trim(date('Y-m-d')) . ' 17:30:00');
		$curentime = time();
        $curentDay =strtotime(trim(date("Y-m-d") . "00:00:00"));
        $data1 = [
            LeadInvestor::COLUMN_SCAN_DATE => $curentDay,
        ];
        if ($curentime > $start && $curentime < $end){
            $leadDataInvestor = $this->leadInvestorRepository->lead_import_vbee();
            Log::info('succes1 : ' . print_r($leadDataInvestor, true));
        }else{
            $leadDataInvestor = [];
            Log::info('error1 : ' . print_r($leadDataInvestor, true));
        }
        if (!empty($leadDataInvestor)){
            foreach ($leadDataInvestor as $value){
                if ($value['lead_status'] == "0" ){
                    $data[$count]['phone_number'] = $value['phone'];
                    $data[$count]['ho_ten'] = !empty($value['name']) ? $value['name'] : "";
                    $count++;
                }
                $c = $this->leadInvestorRepository->update($value['id'],$data1);
                Log::info('succes2 : ' . print_r($c, true));
            }
        }
        $data = json_encode($data);
         Log::info('data : ' . print_r($data, true));
        $response = $this->vbee_import($data, $campaign_id, $access_token);
        Log::info('response1 : ' . print_r($response, true));
        $response = json_decode($response);
        Log::info('response2 : ' . print_r($response, true));
        if (!empty($response->results) && $response->status == 1) {
            foreach ($response->results as $item) {
                if (!empty($item->phone_number)) {
                    $lead = $this->leadInvestorRepository->find_one_check_phone($item->phone_number);
                    if (!empty($lead) && empty($lead[0]['call_id']) && empty($lead[0]['day_call'])) {
                        $a = $this->leadInvestorRepository->update($lead[0]['id'], [LeadInvestor::COLUMN_CALL_ID => $item->call_id, LeadInvestor::COLUMN_DAY_CALL => 1]);
                        Log::info('succes3 : ' . print_r($a, true));
                        $bool = true;
                     }elseif(!empty($lead[0]['call_id']) && !empty($lead[0]['call_id']) && $lead[0]['day_call'] < 4) {
                        $day_call = $lead[0]['day_call'] + 1;
                       $b = $this->leadInvestorRepository->update(
                            $lead[0]['id'],
                            [LeadInvestor::COLUMN_CALL_ID => $item->call_id,
                                LeadInvestor::COLUMN_DAY_CALL => $day_call
                            ]);
                         Log::info('succes4 : ' . print_r($b, true));
                        $bool = true;
                    } else {
                        $bool = false;
                        Log::info('import error2 : ');
                    }
                }
            }
        }
        return $bool;
    }

    private function vbee_import($data, $campaign_id, $access_token)
    {
        Log::info('campaign_id : ' . print_r($campaign_id, true));
        Log::info('access_token : ' . print_r($access_token, true));
        Log::info('data : ' . print_r($data, true));
        $e =  "https://aicallcenter.vn/api/campaigns/$campaign_id/import?access_token=$access_token";
        Log::info('data : ' . print_r($e, true));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://aicallcenter.vn/api/campaigns/$campaign_id/import?access_token=$access_token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n    \"contacts\":  $data  \n}\t",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        Log::info('response_curl : ' . print_r($response, true));
        curl_close($curl);
        return $response;
    }

    public function webhook_vbee_ndt($request)
    {
        $bool = false;
        $data = ($request->all());
        $check_status_lead = $this->leadInvestorRepository->find_call_id([LeadInvestor::COLUMN_CALL_ID => $data['data']['call_id']]);
        if (!empty($data)) {
            $vbeeState = $data['data']['state'];
            $check_phone = !empty($data['data']['key_press']) ? (substr($data['data']['key_press'], 0, 1)) : null;
            $duration_vbee = !empty($data['data']['duration']) ? $data['data']['duration'] : null;
            $note = !empty($data['data']['note']) ? ($data['data']['note']) : null;
            if (!empty($check_status_lead) && ($vbeeState == 20 || $vbeeState == 50 || $vbeeState == 60 || $vbeeState == 40)) {
                //khách nghe máy và bấm phím
                if ($vbeeState == 40) {
                    if (!empty($check_phone)) {
                        //khách bấm phím 1
                        if (!empty($check_phone) && ($check_phone == 1)) {
                            $this->update_vbee($check_status_lead['id'], $vbeeState, LeadInvestor::COLUMN_PRIORITY_ONE, "", LeadInvestor::COLUMN_LEAD_STATUS_ACTIVE, "");
                            $bool = true;
                        } //khách bấm phím 2
                        elseif (!empty($check_phone) && $check_phone == 2) {
                            $this->update_vbee($check_status_lead['id'], $vbeeState, LeadInvestor::COLUMN_PRIORITY_TWO, "", LeadInvestor::COLUMN_LEAD_STATUS_ACTIVE, "");
                            $bool = true;
                        } //khách bấm phím 3
                        elseif (!empty($check_phone) && $check_phone == 3) {
                            $a =  $this->callRepository->checkCallVbee($check_status_lead['id'], $vbeeState,$check_phone);
                            $this->update_vbee($check_status_lead['id'], $vbeeState, LeadInvestor::COLUMN_PRIORITY_FOUR, 13, LeadInvestor::COLUMN_LEAD_STATUS_ACTIVE, "");
                            $bool = true;
                        }
                    }elseif(empty($check_phone) && $duration_vbee <= 10 && empty($note == 'VOICEMAIL_DETECTION')){
                        //khách nghe máy nhưng không bấm phím
                        if ($check_status_lead['lead_status'] == LeadInvestor::COLUMN_LEAD_STATUS_BLOCK && empty($check_status_lead['vbee_call'])) {
                            $this->update_vbee($check_status_lead['id'], $vbeeState, LeadInvestor::COLUMN_PRIORITY_THREE, "", "", 1);
                            $bool = true;
                        } elseif ($check_status_lead['day_call'] == 3 && $check_status_lead['vbee_call'] == 1) {
                            $vbee_call = $check_status_lead['vbee_call'] + 1;
                            $this->callRepository->checkCallVbee($check_status_lead['id'], $vbeeState,"");
                            $this->update_vbee($check_status_lead['id'], $vbeeState, LeadInvestor::COLUMN_PRIORITY_THREE, 13, LeadInvestor::COLUMN_LEAD_STATUS_ACTIVE, "");
                            $bool = true;
                        } else {
                            if ($check_status_lead['vbee_call'] == 1) {
                                $vbee_call = 0;
                                $this->leadInvestorRepository->update($check_status_lead['id'], [LeadInvestor::COLUMN_VBEE_CALL => $vbee_call]);
                            } else {
                                $vbee_call = $check_status_lead['vbee_call'] + 1;
                            }
                            $this->update_vbee($check_status_lead['id'], $vbeeState, LeadInvestor::COLUMN_PRIORITY_THREE, "", "", $vbee_call);
                            $bool = true;
                        }
                    } elseif (empty($check_phone) && $duration_vbee > 10 ) {
                        $this->update_vbee($check_status_lead['id'], $vbeeState, LeadInvestor::COLUMN_PRIORITY_TWO, "", LeadInvestor::COLUMN_LEAD_STATUS_ACTIVE, "");
                        $bool = true;
                    } elseif (empty($check_phone) && (!empty($note) && ($note == 'VOICEMAIL_DETECTION'))) {
                        $this->callRepository->checkCallVbee($check_status_lead['id'], $vbeeState, "");
                        $this->update_vbee($check_status_lead['id'], 40, LeadInvestor::COLUMN_PRIORITY_FOUR, 13, LeadInvestor::COLUMN_LEAD_STATUS_ACTIVE, "");
                        $bool = true;
                    }
                } //khách không nghe máy hoặc khách tắt máy
                elseif (($vbeeState == 50 || $vbeeState == 60) && empty($check_phone)) {
                    if ($check_status_lead['lead_status'] == LeadInvestor::COLUMN_LEAD_STATUS_BLOCK && empty($check_status_lead['vbee_call'])) {
                        $this->update_vbee($check_status_lead['id'], $vbeeState, LeadInvestor::COLUMN_PRIORITY_THREE, "", "", 1);
                        $bool = true;
                    } elseif ($check_status_lead['day_call'] == 3 && $check_status_lead['vbee_call'] == 1) {
                        $vbee_call = $check_status_lead['vbee_call'] + 1;
                        $this->callRepository->checkCallVbee($check_status_lead['id'], $vbeeState,"");
                        $this->update_vbee($check_status_lead['id'], $vbeeState, LeadInvestor::COLUMN_PRIORITY_THREE, 13, LeadInvestor::COLUMN_LEAD_STATUS_ACTIVE, "");
                        $bool = true;
                    } else {
                        if ($check_status_lead['vbee_call'] == 1) {
                            $vbee_call = 0;
                            $this->leadInvestorRepository->update($check_status_lead['id'], [LeadInvestor::COLUMN_VBEE_CALL => $vbee_call]);
                        } else {
                            $vbee_call = $check_status_lead['vbee_call'] + 1;
                        }
                        $this->update_vbee($check_status_lead['id'], $vbeeState, LeadInvestor::COLUMN_PRIORITY_THREE, "", "", $vbee_call);
                        $bool = true;
                    }
                } else {
                    $bool = false;
                }
            }
        }
        $data1 = [
            Log_vbee_ndt::COLUMN_CAMPAIGN_ID => $data['data']['campaign_id'] ?? null,
            Log_vbee_ndt::COLUMN_CALL_ID => $data['data']['call_id'] ?? null,
            Log_vbee_ndt::COLUMN_DUARATION => $data['data']['duration'] ?? null,
            Log_vbee_ndt::COLUMN_NOTE => $data['data']['note'] ?? null,
            Log_vbee_ndt::COLUMN_STATE => $data['data']['state'] ?? null,
            Log_vbee_ndt::COLUMN_END_CODE => $data['data']['end_code'] ?? null,
            Log_vbee_ndt::COLUMN_KEY_PRESS => $data['data']['key_press'] ?? null,
        ];
        $this->logVbeeNdtRepository->create($data1);
        return $bool;
    }

    public function update_vbee($id,$vbeeState,$priority,$statusCall = "",$lead_status = "",$vbee_call)
    {
        $data = [
            LeadInvestor::COLUMN_STATE => $vbeeState ?? null,
            LeadInvestor::COLUMN_PRIORITY => $priority ?? null,
        ];
        if ($statusCall){
            $data[ LeadInvestor::COLUMN_STATUS_CALL] = $statusCall;
        }
        if ($lead_status){
            $data[LeadInvestor::COLUMN_LEAD_STATUS] = $lead_status;
        }
        if ($vbee_call){
            $data[LeadInvestor::COLUMN_VBEE_CALL] = $vbee_call;
        }
        $this->leadInvestorRepository->update($id,$data);
        return ;
    }

}
