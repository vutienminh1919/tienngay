<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/NL_Withdraw.php';

class Transaction extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('contract_model');
        $this->load->model('role_model');
        $this->load->model('kpi_pgd_model');
        $this->load->model('kpi_gdv_model');
        $this->load->model('store_model');
        $this->load->model('user_model');
        $this->load->model('bao_hiem_pgd_model');
        $this->load->model('report_kpi_model');
        $this->load->model('report_kpi_user_model');
        $this->load->model('report_kpi_top_user_model');
         $this->load->model('report_kpi_top_pgd_model');
        $this->load->model('tempo_contract_accounting_model');
        $this->load->model('transaction_model');
         $this->load->model('group_role_model');
         $this->load->model("lead_model");
         $this->load->model("area_model");
        $this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
        $this->load->model('contract_tempo_model');
      
       
    }
    public function contract_compa()
    {
         $contract = $this->contract_model->find_where(array('status'=>17,'debt.tong_tien_da_thanh_toan_pt'=>array('$gt'=>0)));
         foreach ($contract as $key => $value) {
            if( $value['debt']['tong_tien_da_thanh_toan_pt'] >=$value['debt']['tong_tien_phai_tra'])
            {
             print($value['code_contract']).'<br>';
            }
         }

    }
    public function run_update()
    {
        $transaction_data = $this->transaction_model->find_where(array('status'=>1,'type'=>array('$in'=>[3,4,5])));
        foreach ($transaction_data as $key => $value) {
            $contract = $this->contract_model->findOne(array('code_contract'=>$value['code_contract']));
            $this->transaction_model->update(
            array("_id" => $value['_id']),
            array("code_contract_disbursement" => $contract['code_contract_disbursement'],
                "customer_name" => $contract['customer_infor']['customer_name'])
        );
        }

    }

	/**Cron cập nhật ngày tất toán thực tế cho hợp đồng gốc
	 *
	 */
	public function sync_date_payment_finish_with_contract()
	{
		//Tìm tất cả các PT đã Tất toán thành công
		$transactions_db = $this->transaction_model->find_where(array('type' => 3, 'status'=> 1, 'date_payment_finish' => array('$exists' => false)));
		if (empty($transactions_db)) {
			echo 'Không tìm thấy hoặc không tồn tại PT cần đồng bộ!';
			return;
		}
		foreach ($transactions_db as $transaction) {
			//Tìm theo mã phiếu ghi các HĐ đã tất toán nhưng chưa có field 'date_payment_finish'
			$contract_db = $this->contract_model->findOne(
				[
					'code_contract' => $transaction['code_contract'],
					'status' => 19,
					'date_payment_finish' => array('$exists' => false)
				]);
			//Update 'date_payment_finish' - ngày tất toán cho transaction
			$this->transaction_model->update(['_id' => $transaction['_id']],
				['date_payment_finish' => (int)$transaction['date_pay']]
			);
			//Update 'date_payment_finish' - ngày tất toán cho contract
			$this->contract_model->update(['_id' => $contract_db['_id']],
				['date_payment_finish' => (int)$transaction['date_pay']]
			);
		}
		echo 'Done!';
    }


}
