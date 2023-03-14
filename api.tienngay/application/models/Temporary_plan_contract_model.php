<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Temporary_plan_contract_model extends CI_Model
{

    private $collection = 'temporary_plan_contract';

    private $createdAt;

    public function  __construct()
    {
        parent::__construct();
        $this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
        $this->load->model("payment_model");
        $this->load->model("contract_model");
        $this->load->model("vbee_thn_model");
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
    public function count($condition){
        return $this->mongo_db->where($condition)->count($this->collection);
    }
    public function find_where($condition){
        return $this->mongo_db
            ->get_where($this->collection, $condition);
    }
    public function find_where_order_by($condition){
        return $this->mongo_db
            ->order_by(array("time_timestamp" => "ESC"))
            ->get_where($this->collection, $condition);
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
    public function find_one_order_by($condition, $orderBy){
        return $this->mongo_db
            ->order_by($orderBy)
            ->limit(1)
            ->get_where($this->collection, $condition);
    }
    public function getBangLaiKy($contractCode) {
        //Step 1: Tìm tất cả các HĐ từ phòng giao dịch
        $conditions = [
            'aggregate' => "store",
            'pipeline' => [
                ['$lookup' =>
                    [
                        'from' => 'contract',
                        'let' => array(
                            "code_contract" => '$code_contract'
                        ),
                        'pipeline' => array(
                            array(
                                '$match' => array(
                                    '$expr' => array(
                                        '$and' => array(
                                            array(
                                                '$eq' => array('$code_contract', '$$code_contract')
                                            )
                                        )
                                    )
                                ),
                            ),
                            array(
                                '$project' => [
                                    'code_contract' => 1,
                                    'loan_infor.amount_money' => 1,
                                    'created_at' => 1
                                ]
                            )
                        ),
                        'as' => "contracts",
                    ]
                ],
                ['$project' =>
                    [
                        "name" => 1,
                    ]
                ],

            ],
            'cursor' => new stdClass,
        ];

        $command = new MongoDB\Driver\Command($conditions);
        $cursor = $this->manager->executeCommand($this->config->item("current_DB"), $command);
        return $cursor->toArray();
    }

    public function getCurrentPlan($contractCode,$date_pay) {
        $data = $this->find_one_order_by(
                array("code_contract" => $contractCode,
                       "ngay_ky_tra" => array('$lt' => $date_pay)
                   ),
                array("ngay_ky_tra" => "DESC"
        ));
        return $data;
    }
      public function getCurrentPlan_top($contractCode,$date_pay) {
        $data = $this->findOne(
                array("code_contract" => $contractCode,
                       "ngay_ky_tra" => array('$gt' => $date_pay))
            );
        return $data;
    }

    public function getKiPhaiThanhToanXaNhat($contractCode) {
        $data = $this->find_one_order_by(
                array("code_contract" => $contractCode),
                array("ngay_ky_tra" => "DESC"
        ));
        return $data;
    }
     public function getKiChuaThanhToanGanNhat($contractCode) {
        $data = $this->find_one_order_by(
                array("code_contract" => $contractCode,"status"=>1),
                array("ngay_ky_tra" => "ASC"
        ));
        return $data;
    }
    public function getKiDaThanhToanGanNhat($contractCode) {
        $data = $this->find_one_order_by(
                array("code_contract" => $contractCode,"status"=>2),
                array("ngay_ky_tra" => "DESC"
        ));
        return $data;
    }



    public function getCurrentPlanAfter($contractCode, $currentPlanId,$date_pay) {
        $condition = array(
            "code_contract" => $contractCode,
            "ngay_ky_tra" => array('$gt' => $date_pay
        ));
        $data = $this->mongo_db
                ->get_where($this->collection, $condition);
        foreach($data as $k=>$v) {
            if($v['_id'] == $currentPlanId) unset($data[$k]);
        }
        return $data;
    }

    public function getCurrentPlanBefore($contractCode, $currentPlanId,$date_pay) {
        $condition = array(
            "code_contract" => $contractCode,
            "ngay_ky_tra" => array('$lt' => $date_pay));
        $data = $this->mongo_db
                ->get_where($this->collection, $condition);
        foreach($data as $k=>$v) {
            if($v['_id'] == $currentPlanId) unset($data[$k]);
        }
        return $data;
    }
    //sau 24/11
     public function goc_chua_tra_den_thoi_diem_dao_han_2($codeContract="",$date_pay="") {
        
        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract,
                    "ngay_ky_tra" => array('$gt' => $date_pay)
                )
            ),
            array(
                '$group' => array(
                    '_id' => '$code_contract',
                    'goc_chua_tra_den_thoi_diem_dao_han' =>  array('$sum' => '$tien_goc_1ky_phai_tra')
                ),
            )
        );
        $data = $this->findAggregate($ops);
        return $data[0]['goc_chua_tra_den_thoi_diem_dao_han'];
    }
    //trước 24/11
     public function goc_chua_tra_den_thoi_diem_dao_han_1($codeContract="",$date_pay="") {
        
        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract,
                    "ngay_ky_tra" => array('$lt' => $date_pay),
                    "status"=>2
                )
            ),
            array(
                '$group' => array(
                    '_id' => '$code_contract',
                    'goc_chua_tra_den_thoi_diem_dao_han' =>  array('$sum' => '$tien_goc_1ky_phai_tra')
                ),
            )
        );
        $data = $this->findAggregate($ops);
        return $data[0]['goc_chua_tra_den_thoi_diem_dao_han'];
    }


    public function goc_da_tra_den_thoi_diem_dao_han($codeContract="",$date_pay="") {
        
        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract,
                    "ngay_ky_tra" => array('$lte' => $date_pay),
                    "status"=>2
                )
            ),
            array(
                '$group' => array(
                    '_id' => '$code_contract',
                    'goc_da_tra_den_thoi_diem_dao_han' =>  array('$sum' => '$tien_goc_1ky_phai_tra')
                ),
            )
        );
        $data = $this->findAggregate($ops);
        return $data[0]['goc_da_tra_den_thoi_diem_dao_han'];
    }
    public function tong_tien_goc($codeContract="",$date_pay="") {
       
        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract
                    
                )
            ),
            array(
                '$group' => array(
                    '_id' => '$code_contract',
                    'tong_tien_goc' =>  array('$sum' => '$tien_goc_1ky_phai_tra')
                ),
            )
        );
        $data = $this->findAggregate($ops);
        return $data[0]['tong_tien_goc'];
    }
     public function tong_tien_goc_da_tra($codeContract="") {
       
        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract
                    
                )
            ),
            array(
                '$group' => array(
                    '_id' => '$code_contract',
                    'tong_tien_goc' =>  array('$sum' => '$tien_goc_1ky_da_tra')
                ),
            )
        );
        $data = $this->findAggregate($ops);
        return $data[0]['tong_tien_goc'];
    }
      public function tong_tien_phai_tra_den_thoi_diem_dao_han($codeContract="",$date_pay="") {
       
        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract,
                 
                )
            ),
            array(
                '$group' => array(
                    '_id' => '$code_contract',
                    'tien_tra_1ky_den_thoi_diem_dao_han' =>  array('$sum' => '$tien_tra_1_ky'),
          
                ),
            )
        );
        $data = $this->findAggregate($ops);
        return $data[0]['tien_tra_1ky_den_thoi_diem_dao_han'];
    }
 
    public function tong_tien_phai_tra_den_thang($codeContract="",$date_pay="") {
       
        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract,
                    "ngay_ky_tra" => array('$lte' => $date_pay+5*24*60*60)
                )
            ),
            array(
                '$group' => array(
                    '_id' => '$code_contract',
                    'tien_tra_1ky_den_thoi_diem_dao_han' =>  array('$sum' => '$tien_tra_1_ky'),
                    'tien_cham_tra' =>  array('$sum' => '$fee_delay_pay'),
                ),
            )
        );
        $data = $this->findAggregate($ops);
        return $data[0]['tien_tra_1ky_den_thoi_diem_dao_han']+ $data[0]['tien_cham_tra'] ;
    }
     public function lai_phi_chua_tra_den_thoi_diem_hien_tai($codeContract="",$date_pay="") {
       
        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract,
                    "ngay_ky_tra" => array('$lt' => $date_pay),
                    "status"=>1
                )
            ),
            array(
                '$group' => array(
                    '_id' => '$code_contract',
                    'lai_chua_tra_den_thoi_diem_hien_tai' =>  array('$sum' => '$tien_lai_1ky_phai_tra'),
                    'phi_chua_tra_den_thoi_diem_hien_tai' =>  array('$sum' => '$tien_phi_1ky_phai_tra')

                ),
            )
        );
        $data = $this->findAggregate($ops);
        return $data;
    }
      public function goc_lai_phi_con_lai_den_ngay_thanh_toan($codeContract="",$date_pay="") {
       
        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract,
                    "ngay_ky_tra" => array('$gte' => $date_pay),  
                )
            ),
            array(
                '$group' => array(
                    '_id' => '$code_contract',
                    'lai_chua_tra' =>  array('$sum' => '$tien_lai_1ky_con_lai'),
                    'phi_chua_tra' =>  array('$sum' => '$tien_phi_1ky_con_lai'),
                    'goc_chua_tra' =>  array('$sum' => '$tien_goc_1ky_con_lai')

                ),
            )
        );
        $data = $this->findAggregate($ops);
        return $data;
    }
     public function goc_lai_phi_chua_tra($codeContract="") {
       
        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract,
                   
                    
                )
            ),
            array(
                '$group' => array(
                    '_id' => '$code_contract',
                    'lai_chua_tra' =>  array('$sum' => '$tien_lai_1ky_con_lai'),
                    'phi_chua_tra' =>  array('$sum' => '$tien_phi_1ky_con_lai'),
                    'goc_chua_tra' =>  array('$sum' => '$tien_goc_1ky_con_lai')

                ),
            )
        );
        $data = $this->findAggregate($ops);
        return $data;
    }
       public function goc_lai_phi_da_tra($codeContract="",$date_pay="") {
       
        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract,
                    "status"=>1
                )
            ),
            array(
                '$group' => array(
                    '_id' => '$code_contract',
                    'lai_da_tra' =>  array('$sum' => '$tien_lai_1ky_da_tra'),
                    'phi_da_tra' =>  array('$sum' => '$tien_phi_1ky_da_tra'),
                    'goc_da_tra' =>  array('$sum' => '$tien_goc_1ky_da_tra')

                ),
            )
        );
        $data = $this->findAggregate($ops);
        return $data;
    }

      public function tien_thua_thanh_toan($codeContract="") {

        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract,
                    "status" => 1
                )
            ),
            array(
                '$group' => array(
                    '_id' => '$code_contract',
                    'goc_tra_thua' =>  array('$sum' => '$tien_goc_1ky_da_tra'),
                    'lai_tra_thua' =>  array('$sum' => '$tien_lai_1ky_da_tra'),
                    'phi_tra_thua' =>  array('$sum' => '$tien_phi_1ky_da_tra'),


                ),
            )
        );
        $data = $this->findAggregate($ops);
        return $data;
    }

     public function tien_goc_con_lai($codeContract="") {

        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract,
                    
                )
            ),
            array(
                '$group' => array(
                    '_id' => '$code_contract',
                    'goc_con_lai' =>  array('$sum' => '$tien_goc_1ky_con_lai'),
                    


                ),
            )
        );
        $data = $this->findAggregate($ops);
        return $data[0]['goc_con_lai'];
    }

    public function findAggregate($operation){
        return $this->mongo_db
            ->aggregate($this->collection, $operation)->toArray();
    }
    // sau 24/11
    public function lai_phi_con_no_cua_ki_tiep_theo_2($codeContract="",$date_pay="") {
        
        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract,
                    "ngay_ky_tra" => array('$gt' => $date_pay)
                )
            ),
            array(
                '$project' => array(
                    'tien_lai_1ky_phai_tra' => 1,
                    'tien_phi_1ky_phai_tra' => 1,
                    'ngay_ky_tra' => 1,
                    'ky_tra' => 1
                )
            ),
            array(
                '$sort' => array(
                    'ngay_ky_tra' => 1
                )
            ),
            array(
                '$limit' => 1
            )
        );
        $data = $this->findAggregate($ops);
        return $data;
    }
    //trước 24/11
    public function lai_phi_con_no_cua_ki_tiep_theo_1($codeContract="",$date_pay="") {
        
        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract,
                    "status" => 1
                )
            ),
            array(
                '$project' => array(
                    'tien_lai_1ky_phai_tra' => 1,
                    'tien_phi_1ky_phai_tra' => 1,
                    'ngay_ky_tra' => 1,
                    'ky_tra' => 1
                )
            ),
            array(
                '$sort' => array(
                    'ngay_ky_tra' => 1
                )
            ),
            array(
                '$limit' => 1
            )
        );
        $data = $this->findAggregate($ops);
        return $data;
    }
	public function find_where1($condition){
		return $this->mongo_db
			->order_by(['created_at'=> 'DESC'])
			->get_where($this->collection, $condition);
	}
     public function get_tien_con_no($codeContract="",$date_pay="") {
        
        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract,
                    "ngay_ky_tra" => array('$lt' => $date_pay)
                )
            ),
            array(
                '$group' => array(
                    '_id' => '$code_contract',
                    'goc_con_lai_den_thoi_diem_thanh_toan' =>  array('$sum' => '$tien_goc_1ky_con_lai'),
                    'lai_con_lai_den_thoi_diem_thanh_toan' =>  array('$sum' => '$tien_lai_1ky_con_lai'),
                    'phi_con_lai_den_thoi_diem_thanh_toan' =>  array('$sum' => '$tien_phi_1ky_con_lai'),
                    'cham_tra_con_lai_den_thoi_diem_thanh_toan' =>  array('$sum' => '$tien_phi_cham_tra_1ky_con_lai'),
                ),
            )
        );
        $data = $this->findAggregate($ops);
        return $data[0]['goc_con_lai_den_thoi_diem_thanh_toan']+$data[0]['lai_con_lai_den_thoi_diem_thanh_toan']+$data[0]['phi_con_lai_den_thoi_diem_thanh_toan']+$data[0]['cham_tra_con_lai_den_thoi_diem_thanh_toan'];
    }
        public function get_tien_da_tra_truoc_tat_toan_ki_tt($codeContract="",$date_pay="") {
        
        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract,
                    "status"=>2,
                    "ngay_ky_tra" => array('$lte' => $date_pay)
                )
            ),
            array(
                '$group' => array(
                    '_id' => '$code_contract',
                    'tien_goc_da_tra_truoc_tat_toan' =>  array('$sum' => '$tien_goc_1ky_phai_tra'),
                    'tien_lai_da_tra_truoc_tat_toan' =>  array('$sum' => '$tien_lai_1ky_phai_tra'),
                    'tien_phi_da_tra_truoc_tat_toan' =>  array('$sum' => '$tien_phi_1ky_phai_tra'),
                     'tien_cham_tra_da_tra_truoc_tat_toan' =>  array('$sum' => '$tien_phi_cham_tra_1ky_da_tra'),
                ),
            )
        );
        $data = $this->findAggregate($ops);
        return $data[0];
    }
       public function get_tien_da_tra_truoc_tat_toan($codeContract="",$date_pay="") {
        
        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract,
                    
                )
            ),
            array(
                '$group' => array(
                    '_id' => '$code_contract',
                    'tien_goc_da_tra_truoc_tat_toan' =>  array('$sum' => '$tien_goc_1ky_da_tra'),
                    'tien_lai_da_tra_truoc_tat_toan' =>  array('$sum' => '$tien_lai_1ky_da_tra'),
                    'tien_phi_da_tra_truoc_tat_toan' =>  array('$sum' => '$tien_phi_1ky_da_tra'),
                     'tien_cham_tra_da_tra_truoc_tat_toan' =>  array('$sum' => '$tien_phi_cham_tra_1ky_da_tra'),
                ),
            )
        );
        $data = $this->findAggregate($ops);
        return $data[0];
    }
      public function get_tien_da_tra_sau_thanh_toan($codeContract="",$date_pay="") {
        
        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract,
                    "ngay_ky_tra" => array('$lte' => $date_pay),
                     "status" => 2
                )
            ),
            array(
                '$group' => array(
                    '_id' => '$code_contract',
                    'tien_goc_da_tra' =>  array('$sum' => '$tien_goc_1ky_da_tra'),
                    'tien_lai_da_tra' =>  array('$sum' => '$tien_lai_1ky_da_tra'),
                    'tien_phi_da_tra' =>  array('$sum' => '$tien_phi_1ky_da_tra'),
                    'tien_cham_tra_da_tra' =>  array('$sum' => '$tien_phi_cham_tra_1ky_da_tra'),

                    
                ),
            )
        );
        $data = $this->findAggregate($ops);
        return $data[0];
    }
       public function get_tien_phai_tra_hop_dong($codeContract="",$date_pay="") {
        
        $ops = array(
            array (
                '$match' => array (
                    "code_contract"=> $codeContract
                   
                     
                )
            ),
            array(
                '$group' => array(
                    '_id' => '$code_contract',
                    'tien_goc_phai_tra' =>  array('$sum' => '$tien_goc_1ky_phai_tra'),
                    'tien_lai_phai_tra' =>  array('$sum' => '$tien_lai_1ky_phai_tra'),
                    'tien_phi_phai_tra' =>  array('$sum' => '$tien_phi_1ky_phai_tra'),
                    'tien_cham_tra_phai_tra' =>  array('$sum' => '$fee_delay_pay'),

                    
                ),
            )
        );
        $data = $this->findAggregate($ops);
        return $data[0];
    }

	public function find_where_select($condition){


		return $this->mongo_db
			->order_by(array("ngay_ky_tra" => "ASC"))
			->limit(1)
			->select(['tien_tra_1_ky','ngay_ky_tra'])
			->get_where($this->collection, $condition);
	}

	public function find_where_select_excel($condition){


		return $this->mongo_db
			->order_by(array("ngay_ky_tra" => "ASC"))
			->select(['tien_tra_1_ky','ngay_ky_tra'])
			->get_where($this->collection, $condition);
	}

	public function find_where_select_check_rule($condition){

		return $this->mongo_db
			->order_by(array("ngay_ky_tra" => "ASC"))
//			->limit(1)
			->get_where($this->collection, $condition);
	}

	public function find_where_report($code_contract){
		$mongo = $this->mongo_db;
		$where = array();

		$where['code_contract'] = $code_contract;
		$where['ky_tra'] = ['$in' => [1, 2, 3]];

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo->select(['status'])->get($this->collection);
	}

//truoc han
	public function find_thn_truoc_han()
	{
		$mongo = $this->mongo_db;
		$date = $this->createdAt;
		$current_time = date('Y-m-d', (int)$date);
		$end = strtotime(date('Y-m-d', trim($date + 5 * 24 * 60 * 60)) . ' 00:00:00');
		$start = strtotime(date('Y-m-d', trim($date + 5 * 24 * 60 * 60)) . ' 23:59:59');
		$result1 = $mongo->where([
			'status' => 1,
			'customer_infor.customer_phone_number' => ['$exists' => true],
			'ngay_ky_tra' => ['$gte' => $end, '$lte' => $start],
			"call_id" => ['$exists' => false],
			'status_vbee_thn' => ['$exists' => false]
		])->order_by(array('ngay_ky_tra' => 'ASC'))
			->limit(30)
			->get($this->collection);
		return $result1;
	}
//qua han
	public function find_thn_qua_han()
	{
		$mongo = $this->mongo_db;
		$date = $this->createdAt;
		$current_time = date('Y-m-d', (int)$date);
		$start = strtotime(trim($current_time) . ' 00:00:00');
		$end = strtotime(trim(date('Y-m-d', $start - 29 * 24 * 60 * 60)) . ' 00:00:00');
		$result = $mongo->where(
			[
				'customer_infor.customer_phone_number' => ['$exists' => true],
				'ngay_ky_tra' => ['$lt' => $start, '$gte' => $end],
				'status' => 1,
				"call_id" => ['$exists' => false],
				'status_vbee_thn' => ['$exists' => false]
			])
			->order_by(array('ngay_ky_tra' => 'DESC'))
			->limit(30)
			->get($this->collection);
		return $result;
	}
//toi han
	public function find_thn_toi_han()
	{
		$mongo = $this->mongo_db;
		$date = $this->createdAt;
		$current_time = date('Y-m-d', (int)$date);
		$start = strtotime(trim($current_time) . ' 0:00:00');
		$end = strtotime(trim($current_time) . ' 23:59:59');
		$result = $mongo->where([
			'customer_infor.customer_phone_number' => ['$exists' => true],
			'ngay_ky_tra' => ['$gte' => $start, '$lte' => $end],
			'status' => 1,
			'status_vbee_thn' => ['$exists' => false]
		])
			->order_by(array('ngay_ky_tra' => 'DESC'))
			->limit(30)
			->get($this->collection);
		return $result;
	}

	public function find_where_payment_done($condition){
		return $this->mongo_db
			->order_by(['ky_tra'=> 'DESC'])
			->get_where($this->collection, $condition);
	}

	public function find_where_1($condition)
	{
		return $this->mongo_db
			->limit(1)
			->get_where($this->collection, $condition);
	}

	public function find_where_2($condition)
	{
		return $this->mongo_db
			->order_by(array('ngay_ky_tra' => 'DESC'))
			->limit(1)
			->get_where($this->collection, $condition);
	}

	public function get_data_toi_han($condition,$limit,$offset)
	{
		$mongo = $this->mongo_db;
		$where = [];

		if (isset($condition['start_date']) && isset($condition['end_date'])) {
			$where['ngay_ky_tra'] = array(
				'$gte' => (int)$condition['start_date'],
				'$lte' => (int)$condition['end_date']
			);
			unset($condition['start_date']);
			unset($condition['end_date']);
		}

		if (!empty($condition['sdt'])) {
			$where['customer_infor.customer_phone_number'] =  $condition['sdt'];
		}

		if (!empty($condition['code_contract_disbursement'])){
			$where['code_contract_disbursement'] =  $condition['code_contract_disbursement'];
		}



		if (!empty($condition['customer_identify'])){
			$where['customer_infor.customer_identify'] =  $condition['customer_identify'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		if (!empty($condition['name'])){
			 $mongo = $mongo->like('customer_infor.customer_name' , $condition['name']);
		}
		if (isset($condition['total'])) {
			return $mongo->order_by(array('ngay_ky_tra' => 'DESC'))
				->where(array("call_thn_toi_han" => 1))
				->count($this->collection);
		} else {
			return $mongo->where(array("call_thn_toi_han" => 1))
				->order_by(array('ngay_ky_tra' => 'DESC'))
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		}
	}

	public function get_data_truoc_han($condition,$limit,$offset)
	{
		$mongo = $this->mongo_db;
		$where = [];

		if (isset($condition['start_date']) && isset($condition['end_date'])) {
			$where['ngay_ky_tra'] = array(
				'$gte' => (int)$condition['start_date'],
				'$lte' => (int)$condition['end_date']
			);

			unset($condition['start_date']);
			unset($condition['end_date']);
		}

		if (!empty($condition['sdt'])) {
			$where['customer_infor.customer_phone_number'] = $condition['sdt'];
		}

		if (!empty($condition['code_contract_disbursement'])) {
			$where['code_contract_disbursement'] = $condition['code_contract_disbursement'];
		}

		if (!empty($condition['customer_identify'])) {
			$where['customer_infor.customer_identify'] = $condition['customer_identify'];
		}

		if (!empty($condition['priority_truoc_han'])){
			$where['priority_truoc_han'] =  $condition['priority_truoc_han'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		if (!empty($condition['name'])) {
			$mongo = $mongo->like('customer_infor.customer_name', $condition['name']);
		}

		if (isset($condition['total'])) {
			return $mongo->order_by(array('ngay_ky_tra' => 'DESC'))
				->where(array("priority_truoc_han" => ['$in' => ['1' , '2' ,'3']]))
				->count($this->collection);
		}else{
			return $mongo->where(array("priority_truoc_han" => ['$in' => ['1' , '2' ,'3']]))
				->order_by(array('ngay_ky_tra' => 'DESC'))
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		}
	}

	public function get_data_qua_han($condition,$limit,$offset)
	{
		$mongo = $this->mongo_db;
		$where = [];

		if (isset($condition['start_date']) && isset($condition['end_date'])) {
			$where['ngay_ky_tra'] = array(
				'$gte' => (int)$condition['start_date'],
				'$lte' => (int)$condition['end_date']
			);
			unset($condition['start_date']);
			unset($condition['end_date']);
		}

		if (!empty($condition['sdt'])) {
			$where['customer_infor.customer_phone_number'] = $condition['sdt'];
		}

		if (!empty($condition['code_contract_disbursement'])) {
			$where['code_contract_disbursement'] = $condition['code_contract_disbursement'];
		}

		if (!empty($condition['priority_qh'])) {
			$where['priority_qh'] = $condition['priority_qh'];
		}

		if (!empty($condition['customer_identify'])) {
			$where['customer_infor.customer_identify'] = $condition['customer_identify'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		if (!empty($condition['name'])) {
			$mongo = $mongo->like('customer_infor.customer_name', $condition['name']);
		}

		if (isset($condition['total'])) {
			return $mongo->order_by(array('ngay_ky_tra' => 'DESC'))
				->where(array("priority_qh" => ['$in' => ['1','2','3']]))
				->count($this->collection);
		}else{
			return $mongo->where(array("priority_qh" => ['$in' => ['1','2','3']]))
				->order_by(array('ngay_ky_tra' => 'DESC'))
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		}
	}

	public function find_where_select_debt($condition)
	{
		return $this->mongo_db
			->select(['ngay_ky_tra'])
			->order_by(array('ngay_ky_tra' => 'DESC'))
			->limit(1)
			->get_where($this->collection, $condition);
	}

	public function sum_where_total($condtion = array(), $get)
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
		$data = $this->mongo_db->aggregate($this->collection, $ops)->toArray();
		if (isset($data[0]['total'])) {
			return $data[0]['total'];
		} else {
			return 0;
		}

	}


}
