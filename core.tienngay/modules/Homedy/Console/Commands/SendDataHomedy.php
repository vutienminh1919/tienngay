<?php

namespace Modules\Homedy\Console\Commands;

use Illuminate\Console\Command;
use Modules\MongodbCore\Entities\Contract;
use Modules\MongodbCore\Entities\Lead;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendDataHomedy extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'homedy:sendData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gửi thông tin cho đối tác Homedy';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data_send = [];
        // Lấy danh sách Lead
        $lead = Lead::where(Lead::COLUMN_SOURCE, "Homedy")->where(Lead::COLUMN_HOMEDY_DISABLE, '!=', '1')->get();

        foreach ($lead as $item) {
            // Hợp đồng thành công
            $contractList = Contract::whereIn(
                Contract::STATUS,
                Contract::list_array_trang_thai_dang_vay()
            )->where(
                Contract::CUSTOMER_PHONE_NUMBER,
                $item->phone_number
            )->get();
            foreach ($contractList as $contract) {
                if ( $contract->disbursement_date > $item->created_at ) {
                    $array_contract_exist = collect([]);
                    if ($item->homedy_log) {
                        $array_contract_exist = collect($item->homedy_log)->map(function($lead_check) {
                            return $lead_check['code_contract'];
                        });
                    }
                    if ( !in_array($contract->code_contract, $array_contract_exist->toArray()) ) {
                        // Homedy Log
                        $homedy_log = isset($item->homedy_log) ? collect($item->homedy_log) : collect([]);
                        $homedy_log = $homedy_log->add([
                            'code_contract' => $contract->code_contract,
                            'amount_money' => (int) $contract->loan_infor['amount_money'],
                            'disbursement_date' => Carbon::createFromTimestamp($contract->disbursement_date)->format('d/m/Y'),
                            'note' => 'Giải ngân thành công',
                            'name' => $item->fullname,
                            'phone' => $item->phone_number,
                            'loan_money' => (int) $item->loan_amount,
                            'loan_time' => (int) $contract->loan_infor['number_day_loan'] / 30,
                            'property_district' => (int) $item->ns_district,
                            'property_province' => (int) $item->ns_province,
                            'address_district' => (int) $item->hk_district,
                            'address_province' => (int) $item->hk_province,
                            'homedy_id' => ($homedy_log->count() == 0) ? (int) $item->homedy_id : null,
                            'homedy_status' => (int) '2'
                        ]);
                        // Update DB
                        $data_update = [
                            'homedy_status' => ($item->homedy_status == '1' || $item->homedy_status == '3') ? '2' : $item->homedy_status,
                            'homedy_log' => $homedy_log->toArray(),
                            'homedy_success_time' => isset($item->homedy_success_time) ? (int) $item->homedy_success_time++ : 1
                        ];
                        $update = Lead::where(Lead::COLUMN_ID, $item->_id)->first();
                        $result_update = $update->update($data_update);
                        if ($result_update == 1) {
                            $data_send[$item->homedy_id] = $update->toArray();
                        }
                    }
                }
            }

            // Hợp đồng Thất bại
            $contractList = Contract::where(
                Contract::STATUS, 3
            )->where(
                Contract::CUSTOMER_PHONE_NUMBER,
                $item->phone_number
            )->get();
            foreach ($contractList as $contract) {
                if ( $contract->created_at > $item->created_at ) {
                    $array_contract_exist = collect([]);
                    if ($item->homedy_log) {
                        $array_contract_exist = collect($item->homedy_log)->map(function($lead_check) {
                            return $lead_check['code_contract'];
                        });
                    }
                    if ( !in_array($contract->code_contract, $array_contract_exist->toArray()) ) {
                        // Homedy Log
                        $homedy_log = isset($item->homedy_log) ? collect($item->homedy_log) : collect([]);
                        $homedy_log = $homedy_log->add([
                            'code_contract' => $contract->code_contract,
                            'note' => 'Không duyệt hợp đồng',
                            'amount_money' => null,
                            'disbursement_date' => null,
                            'name' => $item->fullname,
                            'phone' => $item->phone_number,
                            'loan_money' => (int) $item->loan_amount,
                            'loan_time' => (int) $contract->loan_infor['number_day_loan'] / 30,
                            'property_district' => (int) $item->ns_district,
                            'property_province' => (int) $item->ns_province,
                            'address_district' => (int) $item->hk_district,
                            'address_province' => (int) $item->hk_province,
                            'homedy_id' => ($homedy_log->count() == 0) ? (int) $item->homedy_id : null,
                            'homedy_status' => (int) '3'
                        ]);
                        // Update DB
                        $data_update = [
                            'homedy_status_old' => $item->homedy_status,
                            'homedy_status' => $item->homedy_status == '1' ? '3' : $item->homedy_status,
                            'homedy_log' => $homedy_log->toArray()
                        ];
                        $update = Lead::where(Lead::COLUMN_ID, $item->_id)->first();
                        $result_update = $update->update($data_update);
                        if ($result_update == 1) {
                            $data_send[$item->homedy_id] = $update->toArray();
                        }
                    }
                }
            }

            // Lead Thất bại
            if ($item->status_sale == 19 && $item->homedy_sended != 1) {
                $homedy_log = isset($item->homedy_log) ? collect($item->homedy_log) : collect([]);
                $homedy_log = $homedy_log->add([
                    'code_contract' => null,
                    'note' => 'Lead thất bại',
                    'amount_money' => null,
                    'disbursement_date' => null,
                    'name' => $item->fullname,
                    'phone' => $item->phone_number,
                    'loan_money' => 0,
                    'loan_time' => 0,
                    'property_district' => (int) $item->ns_district,
                    'property_province' => (int) $item->ns_province,
                    'address_district' => (int) $item->hk_district,
                    'address_province' => (int) $item->hk_province,
                    'homedy_id' => ($homedy_log->count() == 0) ? (int) $item->homedy_id : null,
                    'homedy_status' => (int) '3'
                ]);
                $data_update = [
                    'homedy_status_old' => '1',
                    'homedy_status' => '3',
                    'homedy_sended' => 1,
                    'homedy_log' => $homedy_log->toArray()
                ];
                $update = Lead::where(Lead::COLUMN_ID, $item->_id)->first();
                $result_update = $update->update($data_update);
                $data_send[$item->homedy_id] = $update->toArray();
            }
        }

        if ( count($data_send) > 0 ) {
            $data_send = collect($data_send)->map(function($item) {
                $result['id'] = $item[Lead::COLUMN_ID] ?? '';
                $result['name'] = $item[Lead::COLUMN_FULL_NAME] ?? '';
                $result['phone'] = $item[Lead::COLUMN_PHONE_NUMBER] ?? '';
                if ( isset($item[Lead::COLUMN_HK_DISTRICT]) ) {
                    $result['address_district'] = (int) $item[Lead::COLUMN_HK_DISTRICT] ?? '';
                }
                if ( isset($item[Lead::COLUMN_HK_PROVINCE]) ) {
                    $result['address_province'] = (int) $item[Lead::COLUMN_HK_PROVINCE] ?? '';
                }
                if ( isset($item[Lead::COLUMN_NS_DISTRICT]) ) {
                    $result['property_district'] = (int) $item[Lead::COLUMN_NS_DISTRICT] ?? '';
                }
                if ( isset($item[Lead::COLUMN_NS_PROVINCE]) ) {
                    $result['property_province'] = (int) $item[Lead::COLUMN_NS_PROVINCE] ?? '';
                }
                if ( isset($item[Lead::COLUMN_LOAN_AMOUNT]) ) {
                    $result['loan_money'] = isset($item[Lead::COLUMN_HOMEDY_LOG]) ? collect($item[Lead::COLUMN_HOMEDY_LOG])->sum('loan_money') : 0;
                }
                if ( isset($item[Lead::COLUMN_LOAN_TIME]) ) {
                    $result['loan_time'] = (int) $item[Lead::COLUMN_LOAN_TIME] ?? '';
                }
                if ( isset($item[Lead::COLUMN_HOMEDY_AMOUNT]) ) {
                    $result['loan_amount'] = isset($item[Lead::COLUMN_HOMEDY_LOG]) ? collect($item[Lead::COLUMN_HOMEDY_LOG])->sum('amount_money') : 0;
                }
                $result['homedy_id'] = (int) $item[Lead::COLUMN_HOMEDY_ID] ?? '';
                $result['status'] = (int) $item[Lead::COLUMN_HOMEDY_STATUS] ?? '1';
                $result['status_old'] = (int) 1;
                $result['homedy_success_time'] = $item[Lead::COLUMN_HOMEDY_SUCCESS_TIME] ?? 0;
                $result['homedy_log'] = $item[Lead::COLUMN_HOMEDY_LOG] ?? null;
                return $result;
            })->values()->all();
            Log::channel('homedy')->info('(webhook_send): '. print_r($data_send, true));
            Log::channel('homedy')->info('(webhook_send): '. json_encode($data_send));
            dump($data_send);
            //echo json_encode($data_send);
            $response = Http::withHeaders([
                'Authorization' => config('homedy.homedy_secret')
            ])->post(config('homedy.homedy_hook'), $data_send);
            if ($response->ok()) {
                $response_body = $response->body();
                Log::channel('homedy')->info('(webhook_send_body): '. print_r($response_body, true));
            } else {
                $response_body = $response->body();
                Log::channel('homedy')->info('(webhook_send_body_false): '. print_r($response_body, true));
            }
        }

    }
}
