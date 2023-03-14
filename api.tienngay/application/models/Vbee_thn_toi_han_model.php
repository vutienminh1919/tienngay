<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Vbee_thn_toi_han_model extends CI_Model
{
	private $collection = 'vbee_thn_toi_han';

	public function __construct()
	{
		parent::__construct();
		$this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
//        $this->load->model("payment_model");
//        $this->load->model("contract_model");
//        $this->load->model("temporary_plan_contract_model");
	}

	public function insert($data)
	{
		return $this->mongo_db->insert($this->collection, $data);
	}

	public function update($condition, $set)
	{
		return $this->mongo_db->where($condition)->set($set)->update($this->collection);
	}

	public function find_where($condition)
	{
		return $this->mongo_db->limit(1)
			->get_where($this->collection, $condition);
	}

	public function findOne($condition)
	{
		return $this->mongo_db->where($condition)->find_one($this->collection);
	}

	public function count($condition)
	{
		return $this->mongo_db->where($condition)->count($this->collection);
	}

	public function find_where_order_by($condition)
	{
		return $this->mongo_db
			->order_by(array("time_timestamp" => "ESC"))
			->get_where($this->collection, $condition);
	}

	public function delete($condition)
	{
		return $this->mongo_db->where($condition)->delete($this->collection);
	}

	public function find()
	{
		return $this->mongo_db
			->order_by(array('created_at' => 'DESC'))
			->get($this->collection);
	}

	public function find_one_order_by($condition, $orderBy)
	{
		return $this->mongo_db
			->order_by($orderBy)
			->limit(1)
			->get_where($this->collection, $condition);
	}

	public function find_where_1($condition)
	{
		$result = $this
			->mongo_db
			->order_by(array('created_at' => 'DESC'))
			->limit(1)
			->get_where($this->collection, $condition);
		return $result;
	}


	public function find_thn_vbee_toi_han()
	{
		$mongo = $this->mongo_db;
		$date = $this->createdAt;
		$current_time = date('Y-m-d', (int)$date);
		$start = strtotime(trim($current_time) . ' 0:00:00');
		$end = strtotime(trim($current_time) . ' 23:59:59');
		$result1 = $mongo->where([
			'scan_date' => [
				'$ne' => $current_time
			],
			"thnCallData_error" => ['$exists' => false],
			'status' => 1,
			"call_thn_toi_han_thanh_cong" => ['$exists' => false],
			"call_thn_toi_han_that_bai" => ['$exists' => false],
			'ngay_ky_tra' => ['$gte' => $start, '$lte' => $end],
			"so_ngay_cham_tra" => 0
		])->order_by(array('ngay_ky_tra' => 'DESC'))
			->limit(30)
			->get($this->collection);
		return $result1;
	}

	public function find_one_check_phone_thn_vbee($condition)
	{
		$order_by = ['created_at' => 'DESC'];
		$where = array();
		$mongo = $this->mongo_db;

		if (!empty($condition)) {
			$where = [
				'phone' => $condition['phone'],
				'_id' => new \MongoDB\BSON\ObjectId($condition['id'])
			];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo
			->order_by($order_by)
			->find_one($this->collection);
	}

	public function get_data_toi_han($condition,$limit,$offset)
	{
		$mongo = $this->mongo_db;
		$where = [];

		if (isset($condition['start_date']) && isset($condition['end_date'])) {
			$where['calledAtVbee'] = array(
				'$gte' => (int)$condition['start_date'],
				'$lte' => (int)$condition['end_date']
			);
			unset($condition['start_date']);
			unset($condition['end_date']);
		}

		if (!empty($condition['sdt'])) {
			$where['phone'] =  $condition['sdt'];
		}

		if (!empty($condition['code_contract_disbursement'])){
			$where['code_contract_disbursement'] =  $condition['code_contract_disbursement'];
		}



		if (!empty($condition['customer_identify'])){
			$where['cmt'] =  $condition['customer_identify'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		if (!empty($condition['name'])){
			 $mongo = $mongo->like('name' , $condition['name']);
		}
		if (isset($condition['total'])) {
			return $mongo->order_by(array('calledAtVbee' => 'DESC'))
				->where(array("call_thn_toi_han" => 1))
				->count($this->collection);
		} else {
			return $mongo->where(array("call_thn_toi_han" => 1))
				->order_by(array('calledAtVbee' => 'DESC'))
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		}
	}

	public function get_thn_vbee_excel($condition)
	{
		$mongo = $this->mongo_db;
		$where = [];
		if (isset($condition['start_date']) && isset($condition['end_date'])) {
			$where['calledAtVbee'] = array(
				'$gte' => (int)$condition['start_date'],
				'$lte' => (int)$condition['end_date']
			);
			unset($condition['start_date']);
			unset($condition['end_date']);
		}
		if (!empty($condition['code_contract_disbursement'])) {
			$where['code_contract_disbursement'] =  $condition['code_contract_disbursement'];
		}

		if (($condition['tab'] == 'toi_han')){
			$where['call_thn_toi_han']  = 1;
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo->get($this->collection);



	}

	public function update_recording_vbee_thn_toi_han($id, $data)
	{
		$mongo = $this->mongo_db;
		return $mongo
			->where(['_id' => new \MongoDB\BSON\ObjectId($id)])
			->push('record', $data)
			->update($this->collection);
	}


}
