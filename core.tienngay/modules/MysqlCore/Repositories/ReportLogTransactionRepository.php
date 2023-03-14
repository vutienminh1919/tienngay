<?php

namespace Modules\MysqlCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MysqlCore\Entities\ReportLogTransaction as LogModel;
use Modules\MysqlCore\Repositories\Interfaces\ReportLogTransactionRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Str;

class ReportLogTransactionRepository implements ReportLogTransactionRepositoryInterface
{

    /**      
     * @var Model
     */     
     protected $logModel;

    /**
     * ReportLogTransactionRepository constructor.
     *
     * @param ReportLogTransaction $logModel
     */
    public function __construct(LogModel $logModel) {
        $this->logModel = $logModel;
    }

    /**
     * @param $time fomat yyyy-mm-dd
     * get transaction by month
     * @return collection
     */
    public function getListByMonth($time) {
        // First day of the month.
        $startDate =  date('Y-m-01 00:00:00', strtotime($time));
        // Last day of the month.
        $endDate = date('Y-m-t 23:59:59', strtotime($time));
        $result = $this->logModel::select(DB::raw('*, ' 
            . $this->queryCase(). ', ' 
            . $this->loaiThanhToan()
        ))->whereBetween(
            $this->logModel::REQUEST_TIME, [strtotime($startDate), strtotime($endDate)]
        )
        ->orderBy($this->logModel::REQUEST_TIME, 'DESC')
        ->get();

        //BÁO CÁO THEO DÕI TIẾN ĐỘ XỬ LÝ PHIẾU THU
        $report1 = $this->logModel::select(DB::raw($this->queryReport1()))
        ->whereBetween(
            $this->logModel::REQUEST_TIME, [strtotime($startDate), strtotime($endDate)]
        )
        ->where($this->logModel::APPROVE_TIME, '>', 0)
        ->where($this->logModel::APPROVE_BY, '!=', 'System')
        ->groupBy($this->logModel::APPROVE_BY)
        ->get();

        //TỔNG HỢP LỆNH PGD GỬI DUYỆT
        $report2 = $this->logModel::select(DB::raw($this->queryReport2()))
        ->whereBetween(
            $this->logModel::REQUEST_TIME, [strtotime($startDate), strtotime($endDate)]
        )
        ->groupBy($this->logModel::STORE_NAME)
        ->get();

        //CHI TIẾT LỖI PGD THƯỜNG GẶP
        $report3 = $this->logModel::select(DB::raw($this->queryReport3()))
        ->whereBetween(
            $this->logModel::REQUEST_TIME, [strtotime($startDate), strtotime($endDate)]
        )
        ->groupBy($this->logModel::STORE_NAME)
        ->get();

        return [
            'result' => $result,
            'report1' => $report1,
            'report2' => $report2,
            'report3' => $report3
        ];

    }

    /**
     * Search item by conditions
     * @param $conditions 
     * @return collection
     */
    public function searchByConditions($conditions) {
        $searchArr = [];
        $searchEmptyTrans = [];
        if(!empty($conditions['range_time'])) {
            $startDate =  date('Y-m-01 00:00:00', strtotime($conditions['range_time']));
            // Last day of the month.
            $endDate = date('Y-m-t 23:59:59', strtotime($conditions['range_time']));
            $searchArr[] = [$this->logModel::REQUEST_TIME, '>=', strtotime($startDate)];
            $searchArr[] = [$this->logModel::REQUEST_TIME, '<=', strtotime($endDate)];
        }
        if(!empty($conditions['request_by'])) {
            $searchArr[] = [$this->logModel::REQUEST_BY, '=', trim($conditions['request_by'])];
        }
        if(!empty($conditions['approve_by'])) {
            $searchArr[] = [$this->logModel::APPROVE_BY, '=', trim($conditions['approve_by'])];
        }
        if(!empty($conditions['code_contract_disbursement'])) {
            $searchArr[] = [$this->logModel::CODE_CONTRACT_DISBURSEMENT, '=', trim($conditions['code_contract_disbursement'])];
        }
        if(!empty($conditions['trancode'])) {
            $searchArr[] = [$this->logModel::TRANCODE, '=', trim($conditions['trancode'])];
        }

        $result = $this->logModel::select(DB::raw('*, ' 
            . $this->queryCase(). ', ' 
            . $this->loaiThanhToan()
        ))
        ->where($searchArr)
        ->orderBy($this->logModel::REQUEST_TIME, 'DESC')
        ->limit(5000)
        ->get();

        //BÁO CÁO THEO DÕI TIẾN ĐỘ XỬ LÝ PHIẾU THU
        $report1 = $this->logModel::select(DB::raw($this->queryReport1()))
        ->where($searchArr)
        ->where($this->logModel::APPROVE_TIME, '>', 0)
        ->where($this->logModel::APPROVE_BY, '!=', 'System')
        ->groupBy($this->logModel::APPROVE_BY)
        ->get();

        //TỔNG HỢP LỆNH PGD GỬI DUYỆT
        $report2 = $this->logModel::select(DB::raw($this->queryReport2()))
        ->where($searchArr)
        ->groupBy($this->logModel::STORE_NAME)
        ->get();

        //CHI TIẾT LỖI PGD THƯỜNG GẶP
        $report3 = $this->logModel::select(DB::raw($this->queryReport3()))
        ->where($searchArr)
        ->groupBy($this->logModel::STORE_NAME)
        ->get();

        return [
            'result' => $result,
            'report1' => $report1,
            'report2' => $report2,
            'report3' => $report3
        ];
    }

    protected function queryCase() {
        $select = "(CASE 
                WHEN ".$this->logModel::ACTION_NAME." = '".$this->logModel::ACTION_DUYET."' THEN ".$this->logModel::APPROVE_TIME."
            END) AS ".$this->logModel::ACTION_DUYET_TIME;
        $select .= " ,(CASE 
                WHEN ".$this->logModel::ACTION_NAME." = '".$this->logModel::ACTION_TRA_VE."' THEN ".$this->logModel::APPROVE_TIME."
            END) AS ".$this->logModel::ACTION_TRA_VE_TIME;
        $select .= " ,(CASE 
                WHEN ".$this->logModel::ACTION_NAME." = '".$this->logModel::ACTION_HUY."' THEN ".$this->logModel::APPROVE_TIME."
            END) AS ".$this->logModel::ACTION_HUY_TIME;

        $select .= " ,(CASE 
                WHEN ".$this->logModel::ACTION_NAME." = '".$this->logModel::ACTION_GUI_DUYET."' AND ".$this->logModel::FIRST_CLICK_TIME ." > 0 THEN '".$this->logModel::STATUS_PROGRESSING."' 
                WHEN ".$this->logModel::ACTION_NAME." = '".$this->logModel::ACTION_DUYET."' OR ".$this->logModel::ACTION_NAME." = '".$this->logModel::ACTION_HUY."' OR ".$this->logModel::ACTION_NAME." = '".$this->logModel::ACTION_TRA_VE."' 
                    THEN '".$this->logModel::STATUS_DONE."' ELSE '".$this->logModel::STATUS_WAITING."'
            END) AS progress_text";    
        return $select;
    }

    protected function loaiThanhToan() {
        $select = "(CASE 
               WHEN ".$this->logModel::TYPE_PAYMENT." = '".$this->logModel::TYPE_PAYMENT_GH."' THEN '".$this->logModel::LOAI_THANH_TOAN_GH . "'"
            ." WHEN ".$this->logModel::TYPE_PAYMENT." = '".$this->logModel::TYPE_PAYMENT_CC."' THEN '".$this->logModel::LOAI_THANH_TOAN_CC. "'"
            ." WHEN ".$this->logModel::TYPE_PAYMENT." = '".$this->logModel::TYPE_PAYMENT_NORMAL."' 
                    AND ".$this->logModel::TYPE . " = '" .$this->logModel::TYPE_TAT_TOAN."' THEN '".$this->logModel::LOAI_THANH_TOAN_TT. "'"
            ." WHEN ".$this->logModel::TYPE_PAYMENT." = '".$this->logModel::TYPE_PAYMENT_NORMAL."' 
                    AND ".$this->logModel::TYPE . " = '" .$this->logModel::TYPE_THANH_TOAN."' THEN '".$this->logModel::LOAI_THANH_TOAN. "'"
            ." WHEN ".$this->logModel::TYPE." = '".$this->logModel::TYPE_HEYU."' 
                 THEN '".$this->logModel::LOAI_THANH_TOAN_HEYU. "'"
            ." WHEN ".$this->logModel::TYPE_PAYMENT." = '".$this->logModel::TYPE_PAYMENT_TLTS."' 
                 THEN '".$this->logModel::LOAI_THANH_LY_TAI_SAN. "'"
            ." ELSE '".$this->logModel::LOAI_THANH_TOAN_KHAC. "'"
            ." END) AS ".$this->logModel::TRANSACTION_TYPE;
        return $select;
    }

    /**
     * Báo cáo theo dõi tiến độ xử lý phiếu thu
     * @return string
     * */
    protected function queryReport1() {
        $select = $this->logModel::APPROVE_BY. ','
            // Tổng số lệnh đã xử lý
            .'SUM(CASE '
                .'WHEN '.$this->logModel::APPROVE_BY.' = "System" THEN 0 '
                .'ELSE 1 '
            .'END) as total_approved, '

            // Tổng số lệnh xử lý trong giờ hành chính 8h30-17h30.
            .'SUM(CASE '
                .'WHEN '.$this->logModel::APPROVE_HOUR.' > 8 AND '.$this->logModel::APPROVE_HOUR.' < 17 AND '.$this->logModel::APPROVE_DAY_OF_WEEK.' > 0 THEN 1 '
                .'WHEN '.$this->logModel::APPROVE_HOUR.' = 8 AND '.$this->logModel::APPROVE_MINUTE.' > 29 AND '.$this->logModel::APPROVE_DAY_OF_WEEK.' > 0 THEN 1 '
                .'WHEN '.$this->logModel::APPROVE_HOUR.' = 17 AND '.$this->logModel::APPROVE_MINUTE.' < 31 AND '.$this->logModel::APPROVE_DAY_OF_WEEK.' > 0 THEN 1 '
                .'ELSE 0 '
            .'END) as total_approved_office_hour, '

            // Tổng số lệnh xử lý trong giờ hành chính 10-11h.
            .'SUM(CASE '
                .'WHEN '.$this->logModel::APPROVE_HOUR.' = 10 AND '.$this->logModel::APPROVE_DAY_OF_WEEK.' > 0 THEN 1 ELSE 0 '
            .'END) as total_approved_10_11h, '

            // Tổng số lệnh xử lý trong giờ hành chính 14-15h.
            .'SUM(CASE '
                .'WHEN '.$this->logModel::APPROVE_HOUR.' = 14 AND '.$this->logModel::APPROVE_DAY_OF_WEEK.' > 0 THEN 1 ELSE 0 '
            .'END) as total_approved_14_15h, '

            // Tổng số lệnh xử lý trong giờ hành chính 16h30-17h30.
            .'SUM(CASE '
                .'WHEN '.$this->logModel::APPROVE_HOUR.' = 16 AND '.$this->logModel::APPROVE_MINUTE.' > 29 AND '.$this->logModel::APPROVE_DAY_OF_WEEK.' > 0 THEN 1 '
                .'WHEN '.$this->logModel::APPROVE_HOUR.' = 17 AND '.$this->logModel::APPROVE_MINUTE.' < 31 AND '.$this->logModel::APPROVE_DAY_OF_WEEK.' > 0 THEN 1 '
                .'ELSE 0 '
            .'END) as total_approved_16h30_17h30, '
            // Tổng số lệnh xử lý ngoài giờ hành chính
            .'SUM(CASE '
                .'WHEN ('.$this->logModel::APPROVE_HOUR.' < 8 OR '.$this->logModel::APPROVE_HOUR.' > 17) AND '.$this->logModel::APPROVE_DAY_OF_WEEK.' > 0 THEN 1 '
                .'WHEN '.$this->logModel::APPROVE_HOUR.' = 8 AND '.$this->logModel::APPROVE_MINUTE.' < 30 AND '.$this->logModel::APPROVE_DAY_OF_WEEK.' > 0 THEN 1 '
                .'WHEN '.$this->logModel::APPROVE_HOUR.' = 17 AND '.$this->logModel::APPROVE_MINUTE.' > 30 AND '.$this->logModel::APPROVE_DAY_OF_WEEK.' > 0 THEN 1 '
                .'WHEN '.$this->logModel::APPROVE_DAY_OF_WEEK.' = 0 THEN 1 '
                .'ELSE 0 '
            .'END) as total_approved_out_office_hour, '
            // Tổng số lệnh tất toán xử lý ngoài giờ hành chính
            .'SUM(CASE '
                .'WHEN ('.$this->logModel::APPROVE_HOUR.' < 8 OR '.$this->logModel::APPROVE_HOUR.' > 17) AND '.$this->logModel::APPROVE_DAY_OF_WEEK.' > 0 AND '.$this->logModel::TYPE.' = '.$this->logModel::TYPE_TAT_TOAN. ' AND '.$this->logModel::APPROVE_OVER_TIME.' <= 0 THEN 1 '
                .'WHEN '.$this->logModel::APPROVE_HOUR.' = 8 AND '.$this->logModel::APPROVE_MINUTE.' < 30 AND '.$this->logModel::APPROVE_DAY_OF_WEEK.' > 0 AND '.$this->logModel::TYPE.' = '.$this->logModel::TYPE_TAT_TOAN. ' AND '.$this->logModel::APPROVE_OVER_TIME.' <= 0 THEN 1 '
                .'WHEN '.$this->logModel::APPROVE_HOUR.' = 17 AND '.$this->logModel::APPROVE_MINUTE.' > 30 AND '.$this->logModel::APPROVE_DAY_OF_WEEK.' > 0 AND '.$this->logModel::TYPE.' = '.$this->logModel::TYPE_TAT_TOAN. ' AND '.$this->logModel::APPROVE_OVER_TIME.' <= 0 THEN 1 '
                .'WHEN '.$this->logModel::APPROVE_DAY_OF_WEEK.' = 0 AND '.$this->logModel::TYPE.' = '.$this->logModel::TYPE_TAT_TOAN. ' AND '.$this->logModel::APPROVE_OVER_TIME.' <= 0 THEN 1 ' 
                .'ELSE 0 '
            .'END) as total_approved_out_office_hour_type_tat_toan, '
            //Tổng thời gian xử lý lệnh tất toán ngoài giờ hành chính
            .'SUM(CASE '
                .'WHEN ('.$this->logModel::APPROVE_HOUR.' < 8 OR '.$this->logModel::APPROVE_HOUR.' > 17) AND '.$this->logModel::APPROVE_DAY_OF_WEEK.' > 0 AND '.$this->logModel::TYPE.' = '.$this->logModel::TYPE_TAT_TOAN. ' THEN '.$this->logModel::PROCESS_MINUTES_TIME . ' '
                .'WHEN '.$this->logModel::APPROVE_HOUR.' = 8 AND '.$this->logModel::APPROVE_MINUTE.' < 30 AND '.$this->logModel::APPROVE_DAY_OF_WEEK.' > 0 AND '.$this->logModel::TYPE.' = '.$this->logModel::TYPE_TAT_TOAN. ' THEN '.$this->logModel::PROCESS_MINUTES_TIME . ' '
                .'WHEN '.$this->logModel::APPROVE_HOUR.' = 17 AND '.$this->logModel::APPROVE_MINUTE.' > 30 AND '.$this->logModel::APPROVE_DAY_OF_WEEK.' > 0 AND '.$this->logModel::TYPE.' = '.$this->logModel::TYPE_TAT_TOAN. ' THEN '.$this->logModel::PROCESS_MINUTES_TIME . ' '
                .'WHEN '.$this->logModel::APPROVE_DAY_OF_WEEK.' = 0 AND '.$this->logModel::TYPE.' = '.$this->logModel::TYPE_TAT_TOAN. ' THEN '.$this->logModel::PROCESS_MINUTES_TIME . ' '
                .'ELSE 0 '
            .'END) as total_time_approved_out_office_hour_type_tat_toan, '
            //Thời gian bộ phận kế toán xử lý trung bình (phút)
            .'AVG('.$this->logModel::PROCESS_MINUTES_TIME.') AS avg_process_minutes_time, '
            //Thời gian chờ xử lý trung bình (giờ)
            .'AVG('.$this->logModel::PROCESS_HOUR_TIME.') AS avg_process_hour_time, '
            //Số lệnh xử lý vượt quá khung thời gian quy định
            .'SUM(CASE '
                .'WHEN '.$this->logModel::APPROVE_OVER_TIME.' > 0 THEN 1 ELSE 0 '
            .'END) as total_approved_over_time ';

            return $select;
    }

    /**
     * TỔNG HỢP LỆNH PGD GỬI DUYỆT
     * @return string
     * */
    protected function queryReport2() {
        $select = $this->logModel::STORE_NAME. ','
            // Tổng số lần kế toán xử lý
            .'SUM(CASE '
                .'WHEN '.$this->logModel::APPROVE_BY.' = "System" THEN 0 '
                .'ELSE 1 '
            .'END) as total_approved, '

            // Số lần xử lý trả về
            .'SUM(CASE '
                .'WHEN '.$this->logModel::ACTION_NAME.' = "'.$this->logModel::ACTION_TRA_VE.'" THEN 1 ELSE 0 '
            .'END) as total_tra_ve, '

            // Số lần xử lý huỷ
            .'SUM(CASE '
                .'WHEN '.$this->logModel::ACTION_NAME.' = "'.$this->logModel::ACTION_HUY.'" THEN 1 ELSE 0 '
            .'END) as total_huy, '
            // Khoảng thời gian từ ngày khách hàng thanh toán đến thời điểm PGD gửi duyệt lệnh trung bình
            .'AVG(CASE '
                ."WHEN ".$this->logModel::ACTION_NAME." = '".$this->logModel::ACTION_HUY."' OR (".$this->logModel::FIRST_REQUEST_TIME." - ".$this->logModel::BANK_DATE.") <= 0
                THEN NULL ELSE (".$this->logModel::FIRST_REQUEST_TIME.' - '.$this->logModel::BANK_DATE.")"
            .'END) as avg_request_delay_time, '
            //Thời gian PGD xử lý phiếu thu trung bình
            .'AVG('.$this->logModel::RESEND_REQUEST_TIME.') AS avg_resend_request_time, '
            //Thời gian PGD xử lý phiếu thu tất toán trung bình
            .'AVG(CASE '
                .'WHEN '.$this->logModel::TYPE.' = '.$this->logModel::TYPE_TAT_TOAN.' THEN '.$this->logModel::RESEND_REQUEST_TIME .' ELSE 0 '
            .'END) as avg_request_delay_time_tat_toan, '

            // Tổng thời gian PGD xử lý phiếu thu tất toán có miễn giảm trung bình
            .'AVG(CASE '
                .'WHEN '.$this->logModel::TOTAL_DEDUCTIBLE.' > 0 THEN '.$this->logModel::RESEND_REQUEST_TIME.' ELSE 0 '
            .'END) as avg_request_delay_time_mien_giam, '

            //Tổng thời gian PGD xử lý phiếu thu gia hạn, cơ cấu trung bình
            .'AVG(CASE '
                .'WHEN '.$this->logModel::TYPE_PAYMENT.' = '.$this->logModel::TYPE_PAYMENT_GH.' THEN '.$this->logModel::RESEND_REQUEST_TIME.' '
                .'WHEN '.$this->logModel::TYPE_PAYMENT.' = '.$this->logModel::TYPE_PAYMENT_CC.' THEN '.$this->logModel::RESEND_REQUEST_TIME .' ELSE 0 '
            .'END) as avg_request_delay_time_gia_han_co_cau, '

            //Tổng số lần gửi duyệt trong giờ hành chính
            .'SUM(CASE '
                .'WHEN DATE_FORMAT(FROM_UNIXTIME('.$this->logModel::REQUEST_TIME.'), "%H") > 8 AND DATE_FORMAT(FROM_UNIXTIME('.$this->logModel::REQUEST_TIME.'), "%H") < 17 AND '.$this->logModel::REQUEST_DAY_OF_WEEK.' > 0 THEN 1 '
                .'WHEN DATE_FORMAT(FROM_UNIXTIME('.$this->logModel::REQUEST_TIME.'), "%H") = 8 AND DATE_FORMAT(FROM_UNIXTIME('.$this->logModel::REQUEST_TIME.'), "%i") > 29 AND '.$this->logModel::REQUEST_DAY_OF_WEEK.' > 0 THEN 1 '
                .'WHEN DATE_FORMAT(FROM_UNIXTIME('.$this->logModel::REQUEST_TIME.'), "%H") = 17 AND DATE_FORMAT(FROM_UNIXTIME('.$this->logModel::REQUEST_TIME.'), "%i") < 31 AND '.$this->logModel::REQUEST_DAY_OF_WEEK.' > 0 THEN 1 ELSE 0 '
            .'END) as total_request_in_office_hour, '
            
            //Tổng số lần gửi duyệt sau giờ hành chính
            .'SUM(CASE '
                .'WHEN '.$this->logModel::REQUEST_DAY_OF_WEEK.' = 0 THEN 1 '
                .'WHEN (DATE_FORMAT(FROM_UNIXTIME('.$this->logModel::REQUEST_TIME.'), "%H") < 8 OR DATE_FORMAT(FROM_UNIXTIME('.$this->logModel::REQUEST_TIME.'), "%H") > 17) AND '.$this->logModel::REQUEST_DAY_OF_WEEK.' > 0 THEN 1 '
                .'WHEN DATE_FORMAT(FROM_UNIXTIME('.$this->logModel::REQUEST_TIME.'), "%H") = 8 AND DATE_FORMAT(FROM_UNIXTIME('.$this->logModel::REQUEST_TIME.'), "%i") < 30  THEN 1 '
                .'WHEN DATE_FORMAT(FROM_UNIXTIME('.$this->logModel::REQUEST_TIME.'), "%H") = 17 AND DATE_FORMAT(FROM_UNIXTIME('.$this->logModel::REQUEST_TIME.'), "%i") > 30 AND '.$this->logModel::REQUEST_DAY_OF_WEEK.' > 0 THEN 1 ELSE 0 '
            .'END) as total_request_out_office_hour ';

            return $select;
    }

    /**
     * TỔNG HỢP LỆNH PGD GỬI DUYỆT
     * @return string
     * */
    protected function queryReport3() {
        $cancelTrungLenh = '%"type":"'.$this->logModel::CANCEL_NOTE.'","id":"'.$this->logModel::CANCEL_TRUNG_LENH.'"%';
        $cancelSaiTien = '%"type":"'.$this->logModel::CANCEL_NOTE.'","id":"'.$this->logModel::CANCEL_SAI_SO_TIEN.'"%';
        $cancelSaiPTTT = '%"type":"'.$this->logModel::CANCEL_NOTE.'","id":"'.$this->logModel::CANCEL_SAI_PHUONG_THUC_THANH_TOAN.'"%';
        $cancelSaiLoaiTT = '%"type":"'.$this->logModel::CANCEL_NOTE.'","id":"'.$this->logModel::CANCEL_SAI_LOAI_THANH_TOAN.'"%';
        $cancelSaiTTMienGiam = '%"type":"'.$this->logModel::CANCEL_NOTE.'","id":"'.$this->logModel::CANCEL_SAI_THONG_TIN_MG.'"%';
        $cancelLoiGDDuyetDD = '%"type":"'.$this->logModel::CANCEL_NOTE.'","id":"'.$this->logModel::CANCEL_LOI_GD_DUYET_DINH_DANH.'"%';
        $cancelLoiGopGDBank = '%"type":"'.$this->logModel::CANCEL_NOTE.'","id":"'.$this->logModel::CANCEL_LOI_GOP_GD_NGAN_HANG.'"%';
        $cancelSaiNgayTT = '%"type":"'.$this->logModel::CANCEL_NOTE.'","id":"'.$this->logModel::CANCEL_SAI_NGAY_THANH_TOAN.'"%';
        $cancelHuyPTHeyu = '%"type":"'.$this->logModel::CANCEL_NOTE.'","id":"'.$this->logModel::CANCEL_HUY_PT_HEYU.'"%';

        $returnThieuChungTu = '%"type":"'.$this->logModel::RETURN_NOTE.'","id":"'.$this->logModel::RETURN_THIEU_CHUNG_TU.'"%';
        $returnSaiTTMienGiam = '%"type":"'.$this->logModel::RETURN_NOTE.'","id":"'.$this->logModel::RETURN_SAI_THONG_TIN_MG.'"%';
        $returnSaiTTGiaHan = '%"type":"'.$this->logModel::RETURN_NOTE.'","id":"'.$this->logModel::RETURN_SAI_THONG_TIN_GH.'"%';
        $returnSaiTTCoCau = '%"type":"'.$this->logModel::RETURN_NOTE.'","id":"'.$this->logModel::RETURN_THONG_TIN_CC.'"%';
        $returnSaiTTHeyU = '%"type":"'.$this->logModel::RETURN_NOTE.'","id":"'.$this->logModel::RETURN_SAI_THONG_TIN_HEYU.'"%';
        $returnBoSungXacNhanHuyTuQL = '%"type":"'.$this->logModel::RETURN_NOTE.'","id":"'.$this->logModel::RETURN_BO_SUNG_XN_HUY_PT_TU_QL.'"%';
        $select = $this->logModel::STORE_NAME. ','
            // Tổng số lần kế toán xử lý
            .'SUM(CASE '
                .'WHEN ('.$this->logModel::REQUIRE_NOTE.' like \''.$cancelTrungLenh.'\') THEN 1 ELSE 0 '
            .'END) as cancel_trung_lenh, '
            .'SUM(CASE '
                .'WHEN ('.$this->logModel::REQUIRE_NOTE.' like \''.$cancelSaiTien.'\') THEN 1 ELSE 0 '
            .'END) as cancel_sai_tien, '
            .'SUM(CASE '
                .'WHEN ('.$this->logModel::REQUIRE_NOTE.' like \''.$cancelSaiPTTT.'\') THEN 1 ELSE 0 '
            .'END) as cancel_sai_pttt, '
            .'SUM(CASE '
                .'WHEN ('.$this->logModel::REQUIRE_NOTE.' like \''.$cancelSaiLoaiTT.'\') THEN 1 ELSE 0 '
            .'END) as cancel_sai_loai_tt, '
            .'SUM(CASE '
                .'WHEN ('.$this->logModel::REQUIRE_NOTE.' like \''.$cancelSaiTTMienGiam.'\') THEN 1 ELSE 0 '
            .'END) as cancel_sai_tt_mg, '
            .'SUM(CASE '
                .'WHEN ('.$this->logModel::REQUIRE_NOTE.' like \''.$cancelLoiGDDuyetDD.'\') THEN 1 ELSE 0 '
            .'END) as cancel_loi_gd_duyet_dd, '
            .'SUM(CASE '
                .'WHEN ('.$this->logModel::REQUIRE_NOTE.' like \''.$cancelLoiGopGDBank.'\') THEN 1 ELSE 0 '
            .'END) as cancel_loi_gop_gd_bank, '
            .'SUM(CASE '
                .'WHEN ('.$this->logModel::REQUIRE_NOTE.' like \''.$cancelSaiNgayTT.'\') THEN 1 ELSE 0 '
            .'END) as cancel_sai_ngay_tt, '
            .'SUM(CASE '
                .'WHEN ('.$this->logModel::REQUIRE_NOTE.' like \''.$cancelHuyPTHeyu.'\') THEN 1 ELSE 0 '
            .'END) as cancel_huy_pt_heyu, '

            .'SUM(CASE '
                .'WHEN ('.$this->logModel::REQUIRE_NOTE.' like \''.$returnThieuChungTu.'\') THEN 1 ELSE 0 '
            .'END) as return_thieu_chung_tu, '
            .'SUM(CASE '
                .'WHEN ('.$this->logModel::REQUIRE_NOTE.' like \''.$returnSaiTTMienGiam.'\') THEN 1 ELSE 0 '
            .'END) as return_sai_tt_mg, '
            .'SUM(CASE '
                .'WHEN ('.$this->logModel::REQUIRE_NOTE.' like \''.$returnSaiTTGiaHan.'\') THEN 1 ELSE 0 '
            .'END) as return_sai_tt_gh, '
            .'SUM(CASE '
                .'WHEN ('.$this->logModel::REQUIRE_NOTE.' like \''.$returnSaiTTCoCau.'\') THEN 1 ELSE 0 '
            .'END) as return_sai_tt_cc, '
            .'SUM(CASE '
                .'WHEN ('.$this->logModel::REQUIRE_NOTE.' like \''.$returnSaiTTHeyU.'\') THEN 1 ELSE 0 '
            .'END) as return_sai_tt_heyu, '
            .'SUM(CASE '
                .'WHEN ('.$this->logModel::REQUIRE_NOTE.' like \''.$returnBoSungXacNhanHuyTuQL.'\') THEN 1 ELSE 0 '
            .'END) as return_bo_sung_xac_nhan_huy_ty_ql ';
            return $select;
    }
}
