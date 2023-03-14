<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Vbee_thn_model extends CI_Model
{
	private $collection = 'vbee_thn';

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
		$result =  $this
			->mongo_db
			->order_by(array('created_at' => 'DESC'))
			->limit(1)
			->get_where($this->collection, $condition);
		return $result;
	}

	public function find_thn_vbee_truoc_han()
	{
		$mongo = $this->mongo_db;
		$date = $this->createdAt;
		$current_time = date('Y-m-d', (int)$date);
		$end = strtotime(date('Y-m-d', trim($date + 5 * 24 * 60 * 60)) . ' 00:00:00');
		$start = strtotime(date('Y-m-d', trim($date + 5 * 24 * 60 * 60)) . ' 23:59:59');
		$result1 = $mongo->where([
			'status' => 1,
			"thnCallData_error" => ['$exists' => false],
			"call_thn_truoc_han_thanh_cong" => ['$exists' => false],
			"call_thn_truoc_han_that_bai" => ['$exists' => false],
			'scan_date' => [
				'$ne' => $current_time
			],
			'$or' => [
				['ngay_ky_tra' => ['$gte' => $end, '$lte' => $start]],
				["day_call_thn_truoc_han" => ['$in' => [1, 2, 3]]]
			],

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

	public function get_data_truoc_han($condition,$limit,$offset)
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
			$where['phone'] = $condition['sdt'];
		}

		if (!empty($condition['code_contract_disbursement'])) {
			$where['code_contract_disbursement'] = $condition['code_contract_disbursement'];
		}

		if (!empty($condition['customer_identify'])) {
			$where['cmt'] = $condition['customer_identify'];
		}

		if (!empty($condition['priority_truoc_han'])){
			$where['priority_truoc_han'] =  $condition['priority_truoc_han'];
		}else{
			$where['priority_truoc_han'] = ['$exists' => true];
			//$this->mongo_db->where(['priority_truoc_han' => ['$in' => ['1','2','3']]]);
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		if (!empty($condition['name'])) {
			$mongo = $mongo->like('name', $condition['name']);
		}

		if (isset($condition['total'])) {
			return $mongo
				->order_by(array('calledAtVbee' => 'DESC'))
				//->where(['priority_truoc_han' => ['$exists' => true]])
				->count($this->collection);
		}else{
			return $mongo
				->order_by(array('calledAtVbee' => 'DESC'))
				//->where(['priority_truoc_han' => ['$exists' => true]])
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

		if (($condition['tab'] == 'truoc_han')){
			$where['call_thn_truoc_han']  = 1;
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo->get($this->collection);



	}

	public function update_recording_vbee_thn_truoc_han($id, $data)
	{
		$mongo = $this->mongo_db;
		return $mongo
			->where(['_id' => new \MongoDB\BSON\ObjectId($id)])
			->push('record', $data)
			->update($this->collection);
	}

}
