<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contract_model extends CI_Model
{

    private $collection = 'contract';
    private $collection_transaction = 'transaction';
    private $manager;

    public function  __construct()
    {
        parent::__construct();
       // $this->manager = new MongoDB\Driver\Manager("mongodb://".$this->config->item('ip_db').":27017");
        $this->load->helper('lead_helper');
    }
    public function insert($data){
        return $this->mongo_db->insert($this->collection, $data);
    }
    public function insertReturnId($data) {
        return $this->mongo_db->insertReturnId($this->collection, $data);
    }
    public function findOne($condition){
        return $this->mongo_db->where($condition)->find_one($this->collection);
    }
    public function find_one_select($condition, $select){
        return $this->mongo_db
                ->select($select)
                ->where($condition)
                ->find_one($this->collection);
    }
	public function findOneAndUpdate($where="", $inforUupdate="") {
		$update = array(
			'$set' => $inforUupdate
		);
		return $this->mongo_db->find_one_and_update($this->collection, $where, $update);
	}
    public function count($condition){
        return $this->mongo_db->where($condition)->count($this->collection);
    }
    public function find_where($condition){
        return $this->mongo_db
            ->get_where($this->collection, $condition);
    }
    public function find_where_tran($condition){
        return $this->mongo_db
            ->get_where($this->collection_transaction, $condition);
    }
    public function update($condition, $set){
        return $this->mongo_db->where($condition)->set($set)->update($this->collection);
    }
    public function delete($condition){
        return $this->mongo_db->where($condition)->delete($this->collection);
    }
    public function find(){
        return $this->mongo_db
            ->order_by(array('created_at' => 'DESC'))
            ->get($this->collection);
    }
    
    public function getMaxNumberContract() {
        return $this->mongo_db
            ->select(array("number_contract"))
            ->order_by(array('number_contract' => 'DESC'))
            ->limit(1)
            ->get($this->collection);
    }
    public function get_status_report($condition,$status_origin)
    {
        $status =contract_status($status_origin);
        
        $transactionData = $this->find_where_tran($condition);
        if (!empty($transactionData)) {
           $status="Tất toán";
        }
        return $status;
    }
    public function getContractByTime($searchLike, $condition) {
		$mongo = $this->mongo_db;
		$order_by = ['created_at' => 'DESC'];
		if(isset($condition['start']) && isset($condition['end'])){
			$condition['created_at'] = array(
				'$gte' => intval($condition['start']),
				'$lte' => intval($condition['end'])
			);
			unset($condition['start']);
			unset($condition['end']);
		}

		$mongo = $mongo->set_where($condition);
		if(!empty($searchLike)){
			foreach($searchLike as $key => $value){
				$mongo = $mongo->like($key,$value);

			}
		}
		return $mongo->order_by($order_by)->get($this->collection);
    }
    
    public function getContractByRole($condition = array()){
        $order_by = ['created_at' => 'DESC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		 if(isset($condition['start']) && isset($condition['end'])){
		 	$where['created_at'] = array(
		 		'$gte' => $condition['start'],
		 		'$lte' => $condition['end']
		 	);
		 	unset($condition['start']);
		 	unset($condition['end']);
         }
        if(isset($condition['property'])){
			$where['loan_infor.type_property.code'] = $condition['property'];
        }
        if(isset($condition['status'])){
			$where['status'] = (int)$condition['status'];
        }
        if(isset($condition['created_by'])){
			$where['created_by'] = $condition['created_by'];
        }
        if(isset($condition['stores'])){
			$in = $condition['stores'];
			unset($condition['stores']);
        }
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if(!empty($in)){
			return $mongo->order_by($order_by)
				->where_in('store.id',$in)
				->get($this->collection);
		} else {
			return $mongo->order_by($order_by)
				->get($this->collection);
		}
    }
    public function findOne_transaction($condition)
    {
        return $this->mongo_db->where($condition)->find_one($this->collection_transaction);
    }
    public function reportExpire($codeContract) {
        $token = $this->session->userdata("user")['token'];
        $this->api = new Api();
        $res = $this->api->apiPost($token, "accountingSystem/report_expire", array("code_contract"=>$codeContract));
        return $res->data;
    }
        public function get_tran_one_tt($condition) {
       $condition_tran=array(
                'code_contract'=>$condition['code_contract'],
                'status'=>$condition['status'],
                'type'=>$condition['type'],
                'date_pay'=> array(
                '$lte' => $condition['endMonth'])
       );
        $tran_tt=$this->findOne_transaction($condition_tran);
        return  $tran_tt;
     }
    public function getStatusContract($condition) {
       $condition_tran=array(
                'code_contract'=>$condition['code_contract'],
                'status'=>$condition['status'],
                'type'=>$condition['type'],
                'date_pay'=> array(
                '$lte' => $condition['endMonth'])
       );
        $tran_tt=$this->findOne_transaction($condition_tran);

        $status = 'Đang vay';
    
        if(!empty( $tran_tt))
        {
            $status="Tất toán";
        }
        if(isset($condition['ky_tt_xa_nhat']) && isset($condition['endMonth']) && isset($condition['status_contract_origin']))
        {
              if($condition['status_contract_origin']==33  &&  $condition['ky_tt_xa_nhat']<$condition['endMonth'])
            {
           //Số tiền gốc còn lại
            $status="Gia hạn";

            } 
             if( $condition['status_contract_origin']==34 &&  $condition['ky_tt_xa_nhat']<$condition['endMonth'])
            {
           //Số tiền gốc còn lại
           $status="Cơ cấu";

            } 
        }
        return $status;
    }
    public function sum_where_transaction($condtion = array(), $get)
    {
        $ops = array(
            array(
                '$match' => $condtion
            ),
            array(
                '$group' => array(
                    '_id' => null,
                    'total' => array('$sum' => $get),
                ),
            ),
        );
        $data = $this->mongo_db->aggregate('transaction', $ops)->toArray();
        if (isset($data[0]['total'])) {
            return $data[0]['total'];
        } else {
            return 0;
        }

    }
   public function get_du_no_goc($code_contract, $date_pay)
    {

        
        $dataDB = $this->contract_model->findOne(array("code_contract" => $code_contract,'status'=>['$in'=>[10,11,12,13,14,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,37,38,39,40,41,42]]));
       
      
         $condition_tran=array(
                'code_contract'=>$dataDB['code_contract'],
                'status'=>1,
                'type'=>['$in'=>[3,4]],
                'date_pay'=> array(
                '$lte' => $date_pay)
       );
         $goc_da_tra_dao_han  =$this->sum_where_transaction( $condition_tran,'$so_tien_goc_da_tra');

        
        $goc_chua_tra_den_thoi_diem_dao_han = $dataDB['loan_infor']['amount_money'] - $goc_da_tra_dao_han;
       
          $condition_tran_ck=array(
                'code_contract'=>$dataDB['code_contract'],
                'status'=>1,
                'type'=>3,
                'date_pay'=> array(
                '$lte' => $date_pay)
       );
        $tran_tt=$this->findOne_transaction($condition_tran_ck);

        $status = 17;
    
        if(!empty( $tran_tt))
        {
            $status=19;
        }
         $condition_tran_ck=array(
                'code_contract'=>$dataDB['code_contract'],
                'status'=>1,
                'type'=>4,
                'type_payment'=>['$in'=>[2,3]],
                'date_pay'=> array(
                '$lte' => $date_pay)
       );
        $tran_tt=$this->findOne_transaction($condition_tran_ck);
         if(!empty( $tran_tt))
        {
            $status=33;
        }
      
        if(in_array( $status, [19,40,33,34]))
        {
          
          
            $goc_chua_tra_den_thoi_diem_dao_han=0;
        }
        


        return $goc_chua_tra_den_thoi_diem_dao_han;
    }
    
    public function getMaHopDongVay($item) {
        $maHDVay = !empty($item->code_contract_disbursement) ? $item->code_contract_disbursement :  $item->code_contract;
        if(!empty($item->type_gh) && !empty($item->code_contract_parent_gh)) {
            if($item->type_gh>=1)
            {
              $maHDVay=$this->find_one_select(['code_contract'=> $item->code_contract_parent_gh],['code_contract_disbursement'])['code_contract_disbursement'];
            }
        }
        if(!empty($item->type_cc) && !empty($item->code_contract_parent_cc)) {
            if($item->type_cc>=1)
            {
              $maHDVay=$this->find_one_select(['code_contract'=> $item->code_contract_parent_cc],['code_contract_disbursement'])['code_contract_disbursement'];
            }
        }
        return $maHDVay;
    }
    
    public function getMaPhuLuc($item) {
        $maPhuLuc = "";
        if(!empty($item->type_gh) && !empty($item->code_contract_parent_gh)) {
            if($item->type_gh>=1)
            {
              $maPhuLuc=$item->code_contract_disbursement;
            }
        }
        if(!empty($item->type_cc) && !empty($item->code_contract_parent_cc)) {
            if($item->type_cc>=1)
            {
              $maPhuLuc=$item->code_contract_disbursement;
            }
        }
        return $maPhuLuc;
    }
    
    public function getInvestor($item) {
        
    }


}
