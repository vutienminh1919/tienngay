<?php


class Profile_exemption_model extends CI_Model
{
	private $collection = 'profile_exemption';
	private $manager, $creatAt;

	public function __construct()
	{
		parent::__construct();
		$this->load->model("time_model");
		$this->manager = new \MongoDB\Driver\Manager($this->config->item("mongo_db")['dsn'], $this->config->item("mongo_db")['options']);
		$this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
	}

	public function insert($data)
	{
		return $this->mongo_db->insert($this->collection, $data);
	}

	public function insertReturnId($data)
	{
		return $this->mongo_db->insertReturnId($this->collection, $data);
	}

	public function update($condition, $set){
		return $this->mongo_db->where($condition)->set($set)->update($this->collection);
	}

	public function findOne($condition)
	{
		return $this->mongo_db->where($condition)->find_one($this->collection);
	}

	public function find_where_in($field = "", $in = array())
	{
		return $this->mongo_db
			->where_in($field, $in)->order_by(array('created_at' => 'DESC'))->get($this->collection);
	}

	public function find_where($condition)
	{
		return $this->mongo_db
			->order_by(array('created_at' => 'DESC'))
			->get_where($this->collection, $condition);
	}

	public function find_one_select($condition, $select)
	{
		return $this->mongo_db
			->select($select)
			->where($condition)
			->find_one($this->collection);
	}

	public function findOneAndUpdate($where = "", $inforUupdate = "")
	{
		$update = array(
			'$set' => $inforUupdate
		);
		return $this->mongo_db->find_one_and_update($this->collection, $where, $update);
	}

	public function count($condition)
	{
		return $this->mongo_db->where($condition)->count($this->collection);
	}

	public function delete($condition)
	{
		return $this->mongo_db->where($condition)->delete($this->collection);
	}

	public function get_all_profile($condition = array(), $limit = 30, $offset = 0)
	{
		$mongo = $this->mongo_db;
		$order_by = ['created_at' => 'DESC'];
		$where = array();
		if (isset($condition['from_date']) && isset($condition['to_date'])) {
			$where['created_at'] = array(
				'$gte' => $condition['from_date'],
				'$lte' => $condition['to_date']
			);
			unset($condition['from_date']);
			unset($condition['to_date']);
		}
		if (isset($condition['store'])) {
			$where['store.id'] = $condition['store'];
		}
		if (isset($condition['status'])) {
			$where['status'] = (int)$condition['status'];
		}
		if (isset($condition['type_send'])) {
			$where['type_send'] = (int)$condition['type_send'];
		}
		if (isset($condition['postal_code'])) {
			$where['postal_code'] = $condition['postal_code'];
		}
		if (isset($condition['bbbg_code'])) {
			$where['profile_name'] = $condition['bbbg_code'];
		}
		if (isset($condition['code_contract'])) {
			$where['code_contract'] = $condition['code_contract'];
		}
		if (!empty($condition['domain_area']) && $condition['domain_area'] == 'MB') {
			$where['domain_area'] = 'MB';
		} elseif (!empty($condition['domain_area']) && $condition['domain_area'] == 'MN') {
			$where['domain_area'] = 'MN';
		}
		if (isset($condition['tab']) && $condition['tab'] == 'profile_normal') {
			$where['type_exception'] = array('$nin' => array(1, 2));
		} elseif ($condition['tab'] == 'profile_exception') {
			$where['type_exception'] = 1;
		} elseif ($condition['tab'] == 'profile_asset') {
			$where['type_exception'] = 2;
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (!empty($condition['customer_name'])) {
			$mongo = $mongo->where_text($condition['customer_name'], ['$language' => 'none', '$caseSensitive' => false, '$diacriticSensitive' => false]);
		}
		if (!empty($condition['customer_phone_number'])) {
			$mongo = $mongo->like("customer_phone_number", $condition['customer_phone_number']);
		}
		if (!empty($condition['code_contract_disbursement'])) {
			$mongo = $mongo->like("code_contract_disbursement", $condition['code_contract_disbursement']);
		}
		if (isset($condition['total'])) {
			return $mongo
				->order_by($order_by)
				->count($this->collection);
		} else {
			return $mongo
				->order_by($order_by)
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		}


	}

	public function count_profile_by_month($condition)
	{
		$mongo = $this->mongo_db;
		$where = array();
		if (!empty($condition['current_month'])) {
			$where['month'] = $condition['current_month'];
		}
		if (!empty($condition['current_year'])) {
			$where['year'] = $condition['current_year'];
		}
		if (!empty($condition['type_send'])) {
			$where['type_send'] = $condition['type_send'];
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		return $mongo
			->count($this->collection);
	}
}
