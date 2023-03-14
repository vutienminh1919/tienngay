<?php


namespace App\Service;


use App\Models\Contract;
use App\Models\Pay;
use App\Models\Transaction;
use App\Repository\PayRepository;
use App\Repository\PayRepositoryInterface;
use App\Repository\TransactionRepositoryInterface;
use Carbon\Carbon;

class PayService extends BaseService
{
    protected $payRepository;
    protected $transactionRepository;
    protected $transactionService;

    public function __construct(PayRepositoryInterface $payRepository,
                                TransactionRepositoryInterface $transactionRepository,
                                TransactionService $transactionService)
    {
        $this->payRepository = $payRepository;
        $this->transactionRepository = $transactionRepository;
        $this->transactionService = $transactionService;
    }

    public function overView($condition)
    {
        $data = [];
        $data['total_pay'] = $this->payRepository->total_pay($condition);
        $data['total_money_pay'] = $this->payRepository->total_money_pay($condition);
        $data['tong_ky_chua_tra'] = $this->payRepository->tong_ky_chua_tra($condition);
        $data['tong_tien_ki_chua_tra'] = $this->payRepository->tong_tien_ki_chua_tra($condition);
        $data['tong_ky_da_tra'] = $this->payRepository->tong_ky_da_tra($condition);
        $data['tong_tien_ki_da_tra'] = $this->payRepository->tong_tien_ki_da_tra($condition);
        $data['tong_ky_den_han_tra'] = $this->payRepository->tong_ky_den_han_tra($condition);
        $data['tong_tien_ky_den_han_tra'] = $this->payRepository->tong_tien_ky_den_han_tra($condition);
        return $data;
    }

    public function create($request)
    {
        $data = [
            Pay::COLUMN_CODE_CONTRACT => $request->code_contract,
            Pay::COLUMN_INVESTOR_CODE => $request->investor_code,
            Pay::COLUMN_INTEREST => $request->interest,
            Pay::COLUMN_TYPE => $request->type,
            Pay::COLUMN_KI_TRA => $request->ky_tra,
            Pay::COLUMN_NGAY_KY_TRA => $request->ngay_ky_tra,
            Pay::COLUMN_GOC_LAI_1KY => $request->goc_lai_1ky,
            Pay::COLUMN_TIEN_GOC_1KY => $request->tien_goc_1ky,
            Pay::COLUMN_LAI_KY => $request->lai_ky,
            Pay::COLUMN_TIEN_GOC_CON => $request->tien_goc_con,
            Pay::COLUMN_STATUS => $request->status,
            Pay::COLUMN_TIEN_GOC_1KY_PHAI_TRA => $request->tien_goc_1ky_phai_tra,
            Pay::COLUMN_TIEN_LAI_1KY_PHAI_TRA => $request->tien_lai_1ky_phai_tra,
            Pay::COLUMN_CONTRACT_ID => $request->contract_id,
            Pay::COLUMN_CREATED_BY => $request->created_by

        ];
        if (!empty($request->created_at)) {
            $data[Pay::COLUMN_CREATED_AT] = $request->created_at;
        }
        $this->payRepository->create($data);
    }

    public function create_pay_uy_quyen($request, $contract_id)
    {
        $url = 'contract/get_bang_tra_lai_ndt';
        $data = [
            'type' => '3',
            'tien_goc' => $request->amount_money,
            'so_ky_vay' => $request->number_day_loan / 30,
            'lai_suat' => $request->interest,
            'type_interest' => 2,
            'code_contract' => $request->code_contract,
            'investor_code' => $request->investor_code,
            'start_date' => strtotime($request->created_at . " +1 day"),
            'contract_id' => $contract_id
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('URL_APP_NDT') . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }

    public function gach_no_ndt_uy_quyen($contract)
    {
        $month = date('m');
        $year = date('Y');
        $date = $this->get_date_month($month);
        $time = "$year-$month-$date";
        $pays = $this->payRepository->findPayTimeToNow($contract->id, $time);
        if (count($pays) > 0) {
            if ($contract->note == Contract::NOTE_LAI_HANG_THANG_GOC_CUOI_KI) {
                foreach ($pays as $key => $pay) {
                    if ($key == (count($pays) - 1) && date('d') <= date('d', $pay->ngay_ky_tra)) continue;
                    $this->transactionService->transaction_pay_ndt_uy_quyen($contract, $pay);
                }
            } elseif ($contract->note == Contract::NOTE_LAI_GOC_CUOI_KI) {
                if (count($contract->pays) == count($pays) && strtotime(date('Y-m-d') . ' 23:59:59') >= $pays[count($pays) - 1]->ngay_ki_tra) {
                    foreach ($pays as $pay) {
                        $this->transactionService->transaction_pay_ndt_uy_quyen($contract, $pay);
                    }
                }
            } elseif ($contract->note == Contract::NOTE_LAI_3_THANG_GOC_CUOI_KI) {
                $ki_tra = [];
                foreach ($pays as $key => $pay) {
                    if (($key + 1) % 3 == 0) {
                        if (strtotime(date('Y-m-d') . ' 23:59:59') >= $pay->ngay_ky_tra) {
                            array_push($ki_tra, $key - 2);
                            array_push($ki_tra, $key - 1);
                            array_push($ki_tra, $key);
                        }
                    }
                }
                foreach ($ki_tra as $value) {
                    $this->transactionService->transaction_pay_ndt_uy_quyen($contract, $pays[$value]);
                }
            }
        }

    }

    public function get_date_month($month)
    {
        $day = '';
        switch ($month) {
            case '01':
                $day = "31";
                break;
            case '02':
                $day = "28";
                break;
            case '03':
                $day = "31";
                break;
            case '04':
                $day = "30";
                break;
            case '05':
                $day = "31";
                break;
            case '06':
                $day = "30";
                break;
            case '07':
                $day = "31";
                break;
            case '08':
                $day = "31";
                break;
            case '09':
                $day = "30";
                break;
            case '10':
                $day = "31";
                break;
            case '11':
                $day = "30";
                break;
            case '12':
                $day = "31";
                break;
        }
        return $day;
    }

    public function create_pay_ndt_uy_quyen($request, $contract, $investor)
    {
        $tien_goc = $request->amount_money;
        $so_ky_vay = $request->number_day_loan / 30;
        $lai_suat = $request->interest;
        $type = $request->type_interest;
        $code_contract = $contract->code_contract;
        $investor_code = $investor->code;
        $created_at = explode('-', $request->created_at);
        $contract_id = $contract->id;
        $date_pay = $request->date_pay;
        $investment_cycle = $request->investment_cycle;
        $lai_suat_nam = $lai_suat / 100;
        $lai_1_ky = $tien_goc * $lai_suat_nam / 12;
        $lai_ky = 0;
        $j = 1;
        for ($i = 1; $i <= $so_ky_vay; $i++) {
            $start_date = Carbon::create($created_at[0], $created_at[1], $created_at[2]);
            $tien_goc_1ky = $i == $so_ky_vay ? $tien_goc : 0;
            $tien_goc_con = $i == $so_ky_vay ? 0 : $tien_goc;
            if ($type == Contract::LAI_HANG_THANG_GOC_CUOI_KY) {
                $ky_tra = $i;
                $lai_ky = $lai_1_ky;

                $ki_thanh_toan = $this->periodDays(date('Y-m-d', strtotime($start_date)), $i)['date'];
                if (empty($date_pay)) {
                    $time_ki_tra = $this->periodDays(date('Y-m-d', strtotime($start_date)), $i)['date'];
                } else {
                    $new_start_date = Carbon::create($created_at[0], $created_at[1], $date_pay);
                    $time_ki_tra = $i == $so_ky_vay ? $ki_thanh_toan : $this->periodDays(date('Y-m-d', strtotime($new_start_date)), $i)['date'];;
                }
            } elseif ($type == Contract::LAI_3THANG_GOC_CUOI_KY) {
                if ($i % 3 == 0) {
                    $ky_tra = $j;
                    $lai_ky = $lai_1_ky * 3;

                    $ki_thanh_toan = $this->periodDays(date('Y-m-d', strtotime($start_date)), $i)['date'];
                    $time_ki_tra = $this->periodDays(date('Y-m-d', strtotime($start_date)), $i)['date'];
                    $j++;
                }
            } elseif ($type == Contract::GOC_LAI_CUOI_KY) {
                $ky_tra = 1;
                $lai_ky += $lai_1_ky;

                $ki_thanh_toan = $this->periodDays(date('Y-m-d', strtotime($start_date)), $so_ky_vay)['date'];
                $time_ki_tra = $this->periodDays(date('Y-m-d', strtotime($start_date)), $i)['date'];
            } elseif ($type == Contract::LAI_CUOI_THANG) {
                $ky_tra = $i;
                $lai_ky = $lai_1_ky;

                $ki_thanh_toan = $this->periodDays(date('Y-m-d', strtotime($start_date)), $i)['date'];

                $arr_date = explode('-', date('Y-m-d', $ki_thanh_toan));
                $date = Carbon::create($arr_date[0], $arr_date[1], $arr_date[2]);
                $day_last_month = strtotime($date->endOfMonth());

                $time_ki_tra = $i == $so_ky_vay ? $ki_thanh_toan : $day_last_month;
            }

            if ($type == Contract::GOC_LAI_CUOI_KY && $i != $so_ky_vay || $type == Contract::LAI_3THANG_GOC_CUOI_KY && $i % 3 != 0) {
                continue;
            }
            $data_1ky = [
                Pay::COLUMN_CODE_CONTRACT => $code_contract,
                Pay::COLUMN_INVESTOR_CODE => $investor_code,
                Pay::COLUMN_INTEREST => (float)$lai_suat / 12,
                Pay::COLUMN_TYPE => $type,
                Pay::COLUMN_KI_TRA => $ky_tra,
                Pay::COLUMN_NGAY_KY_TRA => ($time_ki_tra),
                Pay::COLUMN_GOC_LAI_1KY => $tien_goc_1ky + $lai_ky,
                Pay::COLUMN_TIEN_GOC_1KY => $tien_goc_1ky,
                Pay::COLUMN_TIEN_GOC_CON => $tien_goc_con,
                Pay::COLUMN_LAI_KY => $lai_ky,
                Pay::COLUMN_STATUS => Pay::CHUA_THANH_TOAN,  // 1: sap toi, 2: da dong, 3: qua han
                Pay::COLUMN_TIEN_GOC_1KY_PHAI_TRA => $tien_goc_1ky,
                Pay::COLUMN_TIEN_LAI_1KY_PHAI_TRA => $lai_ky,
                Pay::COLUMN_CONTRACT_ID => $contract_id,
                Pay::COLUMN_CREATED_BY => current_user()->email,
                Pay::COLUMN_INTEREST_PERIOD => ($ki_thanh_toan)
            ];
            $this->payRepository->create($data_1ky);
        }
    }

    public function app_create_pay_v2($contract)
    {
        $lai_suat_ndt = data_get(json_decode($contract->interest, true), 'interest') / 100;
        $so_ky_vay = $contract->number_day_loan / 30;
        $tien_goc = $contract->amount_money;
        $start_date = strtotime($contract['created_at']);
        if ($contract->type_interest == Contract::DU_NO_GIAM_DAN) {
            $goc_lai_1_ky = -pmt($lai_suat_ndt, $so_ky_vay, $tien_goc);
            $tien_goc_con = $tien_goc;
            for ($i = 1; $i <= $so_ky_vay; $i++) {
                //kỳ trả
//                $date_ky_tra = strtotime($contract['created_at'] . " +$i month");
                $date_ky_tra = $this->periodDays(date('Y-m-d', $start_date), $i)['date'];
                $ky_tra = $i;
                //lãi
                $lai_ky = $lai_suat_ndt * $tien_goc_con;
                // goc da tra
                $tien_goc_1ky = $goc_lai_1_ky - $lai_ky;
                //tiền gốc còn lại
                $tien_goc_con = $tien_goc_con - $tien_goc_1ky;
                $data_1ky = array(
                    Pay::COLUMN_CODE_CONTRACT => $contract->code_contract,
                    Pay::COLUMN_INVESTOR_CODE => $contract->investor_code,
                    Pay::COLUMN_INTEREST => data_get(json_decode($contract->interest, true), 'interest'),
                    Pay::COLUMN_TYPE => $contract->type_interest,
                    Pay::COLUMN_KI_TRA => $ky_tra,
                    Pay::COLUMN_NGAY_KY_TRA => $date_ky_tra,
                    Pay::COLUMN_GOC_LAI_1KY => (float)$goc_lai_1_ky,
                    Pay::COLUMN_TIEN_GOC_1KY => (float)$tien_goc_1ky,
                    Pay::COLUMN_LAI_KY => (float)$lai_ky,
                    Pay::COLUMN_TIEN_GOC_CON => (float)$tien_goc_con,
                    Pay::COLUMN_STATUS => Pay::CHUA_THANH_TOAN, // 1: sap toi, 2: da dong, 3: qua han
                    Pay::COLUMN_TIEN_GOC_1KY_PHAI_TRA => (float)$tien_goc_1ky,
                    Pay::COLUMN_TIEN_LAI_1KY_PHAI_TRA => (float)$lai_ky,
                    Pay::COLUMN_CONTRACT_ID => $contract->id,
                    Pay::COLUMN_CREATED_BY => $contract->created_by,
                );
                $this->payRepository->create($data_1ky);
            }
        } elseif ($contract->type_interest == Contract::LAI_HANG_THANG_GOC_CUOI_KY) {
            for ($i = 1; $i <= $so_ky_vay; $i++) {
                //kỳ trả
//                $date_ky_tra = strtotime($contract['created_at'] . " +$i month");
                $date_ky_tra = $this->periodDays(date('Y-m-d', $start_date), $i)['date'];
                $ky_tra = $i;
                //lãi
                $lai_ky = round($lai_suat_ndt * $tien_goc);
                // goc da tra
                $tien_goc_1ky = $i == $so_ky_vay ? $tien_goc : 0;
                //tiền gốc còn lại
                $tien_goc_con = $i == $so_ky_vay ? 0 : $tien_goc;
                $data_1ky = array(
                    Pay::COLUMN_CODE_CONTRACT => $contract->code_contract,
                    Pay::COLUMN_INVESTOR_CODE => $contract->investor_code,
                    Pay::COLUMN_INTEREST => data_get(json_decode($contract->interest, true), 'interest'),
                    Pay::COLUMN_TYPE => $contract->type_interest,
                    Pay::COLUMN_KI_TRA => $ky_tra,
                    Pay::COLUMN_NGAY_KY_TRA => $date_ky_tra,
                    Pay::COLUMN_GOC_LAI_1KY => (float)$tien_goc_1ky + (float)$lai_ky,
                    Pay::COLUMN_TIEN_GOC_1KY => (float)$tien_goc_1ky,
                    Pay::COLUMN_TIEN_GOC_CON => (float)$tien_goc_con,
                    Pay::COLUMN_LAI_KY => (float)$lai_ky,
                    Pay::COLUMN_STATUS => Pay::CHUA_THANH_TOAN,  // 1: sap toi, 2: da dong, 3: qua han
                    Pay::COLUMN_TIEN_GOC_1KY_PHAI_TRA => (float)$tien_goc_1ky,
                    Pay::COLUMN_TIEN_LAI_1KY_PHAI_TRA => (float)$lai_ky,
                    Pay::COLUMN_CONTRACT_ID => $contract->id,
                    Pay::COLUMN_CREATED_BY => $contract->created_by,
                );
                $this->payRepository->create($data_1ky);
            }
        } elseif ($contract->type_interest == Contract::GOC_LAI_CUOI_KY) {
            $date_ky_tra = $this->periodDays(date('Y-m-d', $start_date), $so_ky_vay)['date'];
            $lai_ky = round($lai_suat_ndt * $tien_goc);
            $data_1ky = array(
                Pay::COLUMN_CODE_CONTRACT => $contract->code_contract,
                Pay::COLUMN_INVESTOR_CODE => $contract->investor_code,
                Pay::COLUMN_INTEREST => data_get(json_decode($contract->interest, true), 'interest'),
                Pay::COLUMN_TYPE => $contract->type_interest,
                Pay::COLUMN_KI_TRA => 1,
                Pay::COLUMN_NGAY_KY_TRA => $date_ky_tra,
                Pay::COLUMN_GOC_LAI_1KY => (float)$tien_goc + (float)($lai_ky * $so_ky_vay),
                Pay::COLUMN_TIEN_GOC_1KY => (float)$tien_goc,
                Pay::COLUMN_TIEN_GOC_CON => 0,
                Pay::COLUMN_LAI_KY => (float)($lai_ky * $so_ky_vay),
                Pay::COLUMN_STATUS => Pay::CHUA_THANH_TOAN,  // 1: sap toi, 2: da dong, 3: qua han
                Pay::COLUMN_TIEN_GOC_1KY_PHAI_TRA => (float)$tien_goc,
                Pay::COLUMN_TIEN_LAI_1KY_PHAI_TRA => (float)($lai_ky * $so_ky_vay),
                Pay::COLUMN_CONTRACT_ID => $contract->id,
                Pay::COLUMN_CREATED_BY => $contract->created_by,
            );
            $this->payRepository->create($data_1ky);
        }
    }

    public function periodDays($start_date, $per)
    {
        $from = new \DateTime($start_date);
        $day = $from->format('j');
        $from->modify('first day of this month');
        $period = new \DatePeriod($from, new \DateInterval('P1M'), $per);
        $arr_date = [];
        foreach ($period as $date) {
            $lastDay = clone $date;
            $lastDay->modify('last day of this month');
            $date->setDate($date->format('Y'), $date->format('n'), $day);
            if ($date > $lastDay) {
                $date = $lastDay;
            }
            $arr_date[] = $date->format('Y-m-d');
        }
        $datetime1 = new \DateTime($arr_date[$per - 1]);
        $datetime2 = new \DateTime($arr_date[$per]);
        $difference = $datetime1->diff($datetime2);
        return array('date' => strtotime($arr_date[$per]), 'days' => $difference->days);
    }
}
