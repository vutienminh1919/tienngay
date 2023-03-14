<?php


namespace App\Service;


use App\Models\Contract;
use App\Models\Pay;
use App\Repository\CommissionRepository;
use Carbon\Carbon;

class ToolService
{
    protected $interestService;
    protected $commissionRepository;

    public function __construct(InterestService $interestService,
                                CommissionRepository $commissionRepository)
    {
        $this->interestService = $interestService;
        $this->commissionRepository = $commissionRepository;
    }

    public function tool_calculator_interest($request)
    {
        $data = [];
        $so_ky_vay = !empty($request->number_day_loan) ? ($request->number_day_loan) : 12;
        $request->period = $so_ky_vay;
        $data_interest = $this->interestService->get_interest_for_app($request);

        $lai_suat_ndt = $data_interest['interest'] / 100;

        $tien_goc = $request->amount_money ?? 0;
        $start_date = !empty($request->created_at) ? strtotime($request->created_at) : time();
        $total_goc_lai_1ky = 0;
        $total_goc_1ky = 0;
        $total_lai_1ky = 0;
        if ($request->type_interest == Contract::DU_NO_GIAM_DAN) {
            $goc_lai_1_ky = -pmt($lai_suat_ndt, $so_ky_vay, $tien_goc);
            $tien_goc_con = $tien_goc;
            for ($i = 1; $i <= $so_ky_vay; $i++) {
                //kỳ trả
                $date_ky_tra = $this->periodDays(date('Y-m-d', $start_date), $i)['date'];
                $ky_tra = $i;
                //lãi
                $lai_ky = $lai_suat_ndt * $tien_goc_con;
                // goc da tra
                $tien_goc_1ky = $goc_lai_1_ky - $lai_ky;
                //tiền gốc còn lại
                $tien_goc_con = $tien_goc_con - $tien_goc_1ky;
                $data_1ky = array(
                    Pay::COLUMN_INTEREST => $data_interest['interest'],
                    Pay::COLUMN_KI_TRA => $ky_tra,
                    Pay::COLUMN_NGAY_KY_TRA => date('d/m/Y', $date_ky_tra),
                    Pay::COLUMN_GOC_LAI_1KY => number_format((float)($goc_lai_1_ky)),
                    Pay::COLUMN_TIEN_GOC_1KY => number_format((float)($tien_goc_1ky)),
                    Pay::COLUMN_LAI_KY => number_format((float)($lai_ky)),
                    Pay::COLUMN_TIEN_GOC_CON => number_format((float)($tien_goc_con)),
                    Pay::COLUMN_TIEN_GOC_1KY_PHAI_TRA => number_format((float)($tien_goc_1ky)),
                    Pay::COLUMN_TIEN_LAI_1KY_PHAI_TRA => number_format((float)($lai_ky)),
                );
                array_push($data, $data_1ky);
                $total_goc_lai_1ky += $goc_lai_1_ky;
                $total_goc_1ky += $tien_goc_1ky;
                $total_lai_1ky += $lai_ky;
            }
        } elseif ($request->type_interest == Contract::LAI_HANG_THANG_GOC_CUOI_KY) {
            for ($i = 1; $i <= $so_ky_vay; $i++) {
                //kỳ trả
                $date_ky_tra = $this->periodDays(date('Y-m-d', $start_date), $i)['date'];
                $ky_tra = $i;
                //lãi
                $lai_ky = round($lai_suat_ndt * $tien_goc);
                // goc da tra
                $tien_goc_1ky = $i == $so_ky_vay ? $tien_goc : 0;
                //tiền gốc còn lại
                $tien_goc_con = $i == $so_ky_vay ? 0 : $tien_goc;
                $data_1ky = array(
                    Pay::COLUMN_INTEREST => $data_interest['interest'],
                    Pay::COLUMN_KI_TRA => $ky_tra,
                    Pay::COLUMN_NGAY_KY_TRA => date('d/m/Y', $date_ky_tra),
                    Pay::COLUMN_GOC_LAI_1KY => number_format((float)($tien_goc_1ky) + (float)($lai_ky)),
                    Pay::COLUMN_TIEN_GOC_1KY => number_format((float)($tien_goc_1ky)),
                    Pay::COLUMN_TIEN_GOC_CON => number_format((float)($tien_goc_con)),
                    Pay::COLUMN_LAI_KY => number_format((float)($lai_ky)),
                    Pay::COLUMN_TIEN_GOC_1KY_PHAI_TRA => number_format((float)($tien_goc_1ky)),
                    Pay::COLUMN_TIEN_LAI_1KY_PHAI_TRA => number_format((float)($lai_ky)),
                );
                array_push($data, $data_1ky);
                $total_goc_lai_1ky += ($tien_goc_1ky + $lai_ky);
                $total_goc_1ky += $tien_goc_1ky;
                $total_lai_1ky += $lai_ky;
            }
        } elseif ($request->type_interest == Contract::GOC_LAI_CUOI_KY) {
            $date_ky_tra = $this->periodDays(date('Y-m-d', $start_date), $so_ky_vay)['date'];
            $lai_ky = round($lai_suat_ndt * $tien_goc);
            $data_1ky = array(
                Pay::COLUMN_INTEREST => $data_interest['interest'],
                Pay::COLUMN_KI_TRA => 1,
                Pay::COLUMN_NGAY_KY_TRA => date('d/m/Y', $date_ky_tra),
                Pay::COLUMN_GOC_LAI_1KY => number_format((float)($tien_goc) + (float)($lai_ky * $so_ky_vay)),
                Pay::COLUMN_TIEN_GOC_1KY => number_format((float)($tien_goc)),
                Pay::COLUMN_TIEN_GOC_CON => number_format((float)(0)),
                Pay::COLUMN_LAI_KY => number_format((float)($lai_ky * $so_ky_vay)),
                Pay::COLUMN_TIEN_GOC_1KY_PHAI_TRA => number_format((float)($tien_goc)),
                Pay::COLUMN_TIEN_LAI_1KY_PHAI_TRA => number_format((float)($lai_ky * $so_ky_vay)),
            );
            array_push($data, $data_1ky);
            $total_goc_lai_1ky += ($tien_goc + ($lai_ky * $so_ky_vay));
            $total_goc_1ky += $tien_goc;
            $total_lai_1ky += ($lai_ky * $so_ky_vay);
        }

        $data_total = [
            Pay::COLUMN_INTEREST => '',
            Pay::COLUMN_KI_TRA => 'Tổng',
            Pay::COLUMN_NGAY_KY_TRA => '',
            Pay::COLUMN_GOC_LAI_1KY => number_format($total_goc_lai_1ky),
            Pay::COLUMN_TIEN_GOC_1KY => number_format($total_goc_1ky),
            Pay::COLUMN_TIEN_GOC_CON => 0,
            Pay::COLUMN_LAI_KY => number_format($total_lai_1ky),
            Pay::COLUMN_TIEN_GOC_1KY_PHAI_TRA => number_format($total_goc_1ky),
            Pay::COLUMN_TIEN_LAI_1KY_PHAI_TRA => number_format($total_lai_1ky),
        ];
        array_push($data, $data_total);
        return $data;
    }

    private function periodDays($start_date, $per)
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

    public function tool_calculator_commission($request)
    {
        $start_date = $request->start_date ?? date('Y-m-d');
        $so_ky_vay = !empty($request->period) ? ($request->period) : 12;
        $amount = !empty($request->amount) ? ($request->amount) : 10000000;
        $end_date = $this->periodDays($start_date, $so_ky_vay)['date'];
        $data = [];
        $total_hh = 0;
        for ($i = 0; $i <= $so_ky_vay; $i++) {
            $ky = $i;
            $data[$i]['ky'] = $ky += 1;
            if ($i == 0) {
                $current_date = strtotime($start_date);
            } else {
                $current_date = $this->periodDays($start_date, $i)['date'];
            }
            $so_ngay_trong_ky = $this->lay_ngay_trong_ky_chi_tra($start_date, $end_date, date('Y-m', $current_date));
            $data[$i]['so_ngay'] = $so_ngay_trong_ky;
            $so_tien_tinh_hoa_hong_thuc_te = round($amount * $so_ngay_trong_ky / Carbon::parse(date('Y-m-d',$current_date ))->daysInMonth);
            $data[$i]['so_tien_tinh_hoa_hong_thuc_te'] = number_format($so_tien_tinh_hoa_hong_thuc_te);

            $year_month = date('Y-m', $current_date);
            $year = !empty($year_month) ? explode('-', $year_month)[0] : date('Y');
            $month = !empty($year_month) ? explode('-', $year_month)[1] : date('m');
            $date = get_created_at_with_year($month, $year);
            $request->fdate = $date['start'];
            $request->tdate = $date['end'];
            $commission = $this->commissionRepository->findCommission($so_tien_tinh_hoa_hong_thuc_te, 'app', $request);
            $hoa_hong = round($so_tien_tinh_hoa_hong_thuc_te * $so_ngay_trong_ky / 365 * $commission['commission'] / 100);
            $data[$i]['hoa_hong'] = number_format($hoa_hong);
            $data[$i]['ti_le'] = $commission['commission'] ?? 0;
            $data[$i]['thang'] = date('Y-m', $current_date);
            $total_hh += $hoa_hong;
        }

        $data_total = [
            'ky' => 'Tổng',
            'so_ngay' => '',
            'so_tien_tinh_hoa_hong_thuc_te' => '',
            'hoa_hong' => number_format($total_hh),
            'ti_le' => '',
            'thang' => ''
        ];
        array_push($data, $data_total);
        return $data;
    }

    public function lay_ngay_trong_ky_chi_tra($start_date, $end_date, $date)
    {
        $start_date_contract = date('Y-m', strtotime($start_date));
        $due_date_contract = date('Y-m', $end_date);
        $daysInMonth = Carbon::parse($date)->daysInMonth;
        if (strtotime($start_date_contract) == strtotime($date)) {
            $day = $daysInMonth - date('d', strtotime($start_date));
        } elseif (strtotime($start_date_contract) < strtotime($date) && strtotime($due_date_contract) > strtotime($date)) {
            $day = $daysInMonth;
        } else {
            $day = (int)date('d', $end_date);
        }
        return $day;
    }
}
