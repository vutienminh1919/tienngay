<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Borrowed_model extends CI_Model
{

	private $collection = 'borrowed';

	private $manager, $createdAt;
	const REQUEST_TO_BORROW = '4';
	const REQUEST_EXTEND_BORROWED = '15';
	const WAIT_DEBT_MANAGER_APPROVE = '16';
	const WAIT_DEBT_MANAGER_APPROVE_EXTEND_BORROWED = '17';
	const DUE_TIME_EXTEND_BORROW_QLKV = 10;

	public function __construct()
	{
		parent::__construct();
		$this->load->model("temporary_plan_contract_model");
		$this->load->model("transaction_model");
		$this->manager = new MongoDB\Driver\Manager($this->config->item("mongo_db")['dsn'],$this->config->item("mongo_db")['options']);
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

	public function findOne($condition)
	{
		return $this->mongo_db->where($condition)->find_one($this->collection);
	}

	public function find_where_in($field = "", $in = array())
	{
		return $this->mongo_db
			->where_in($field, $in)->order_by(array('created_at' => 'DESC'))->get($this->collection);
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

	public function countContract()
	{
		$condition = array(
			'type' => array('$ne' => "vaynhanh")
		);
		return $this->mongo_db
			->where($condition)->count($this->collection);
	}


	public function countOldContract()
	{
		$condition = array(
			'type' => "old_contract"
		);
		return $this->mongo_db
			->where($condition)->count($this->collection);
	}

	public function count_in($field = "", $in = array())
	{
		return $this->mongo_db->where_in($field, $in)->count($this->collection);
	}

	public function find_where($condition)
	{
		return $this->mongo_db
			->order_by(array('created_at' => 'DESC'))
			->get_where($this->collection, $condition);
	}

	public function find_where_order_by($condition, $orderBy = array())
	{
		return $this->mongo_db
			->order_by($orderBy)
			->get_where($this->collection, $condition);
	}

	public function findContract()
	{
		$condition = array(
			'type' => array('$ne' => "vaynhanh")
		);
		return $this->mongo_db
			->order_by(array('created_at' => 'DESC'))->get_where($this->collection, $condition);
	}

	public function update($condition, $set)
	{
		return $this->mongo_db->where($condition)->set($set)->update($this->collection);
	}

	public function delete($condition)
	{
		return $this->mongo_db->where($condition)->delete($this->collection);
	}

	public function delete_all($condition)
	{
		return $this->mongo_db->where($condition)->delete_all($this->collection);
	}

	public function find()
	{
		return $this->mongo_db
			->order_by(array('created_at' => 'DESC'))
			->get($this->collection);
	}


	public function find_select()
	{
		return $this->mongo_db
			->select(array("code_contract"))
			->order_by(array('created_at' => 'DESC'))
			->get($this->collection);
	}

	public function getDataByRole($condition = array(), $limit = 30, $offset = 0)
	{
		$order_by = ["created_at" => "DESC"];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['borrowed_start'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		if (isset($condition['stores'])) {
			$in = $condition['stores'];
			unset($condition['stores']);
		}

		if (isset($condition['status'])) {
			$where['status'] = $condition['status'];
		}
		if (isset($condition['groupRoles_store'])) {
			$where['groupRoles_store'] = $condition['groupRoles_store'];
		}
		if (isset($condition['domain_borrow']) || isset($condition['created_by'])) {
			if (isset($condition['domain_borrow'])) {
				$mongo = $mongo->or_where(['created_by.email' => $condition['created_by'], 'domain_borrow' => $condition['domain_borrow']]);
			}
		}
		if (isset($condition['area'])) {
			if ($condition['area'] == "KV_HN1" || $condition['area'] == "MB" || $condition['area'] == "KV_HN2") {
				$where['area'] = array('$in' => ["KV_HN1", "KV_MT1","KV_HN2", "KV_QN"]);
			}
			if ($condition['area'] == "KV_HCM1") {
				$where['area'] = array('$in' => ["KV_HCM1"]);
			}
			if ($condition['area'] == "KV_HCM2") {
				$where['area'] = array('$in' => ["KV_HCM2"]);
			}
			if ($condition['area'] == "MN") {
				$where['area'] = array('$in' => ["KV_HCM2", "KV_HCM1","KV_BD"]);
			}

			if ($condition['area'] == "KV_MK" || $condition['area'] == "MK") {
				$where['area'] = array('$in' => ["KV_MK","KV_BD"]);
			}
			//Thêm khu vực cho asm qly nhiều khu vực
			if ($condition['area'] == "Khu_vuc") {
				$where['area'] = array('$in' => ["KV_MK","KV_HCM2","KV_HCM1","KV_BD"]);
			}
		}

		if (isset($condition['stores_list'])) {
			$where['stores'] = array('$in' => $condition['stores_list']);
		}

		if (isset($condition['store'])) {
			$where['stores'] = $condition['store'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		if (!empty($condition['code_contract_disbursement_text'])) {
			$mongo = $mongo->like("code_contract_disbursement_text", $condition['code_contract_disbursement_text']);
		}

		if (!empty($condition['groupRoles_store_search'])) {
			$mongo = $mongo->like("groupRoles_store", $condition['groupRoles_store_search']);
		}
		if (!empty($in)) {
			return $mongo->order_by($order_by)
				->where_in('stores', $in)
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		} else {
			return $mongo->order_by($order_by)
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		}

	}

	public function getDataByRole_quahan($condition = array(), $limit = 30, $offset = 0)
	{

		$order_by = ["created_at" => "DESC"];
		$where = array();
		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['borrowed_start'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['status'] = array('$in' => ["12"]);

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		if (!empty($condition['code_contract_disbursement_text'])) {
			$mongo = $mongo->like("code_contract_disbursement_text", $condition['code_contract_disbursement_text']);
		}

		return $mongo->order_by($order_by)
			->limit($limit)
			->offset($offset)
			->get($this->collection);


	}


	public function getDataByRole_header()
	{
		$order_by = ["priority_level" => "ASC", 'start_date' => 'DESC', "created_at" => "DESC"];
		$where = array();
		$mongo = $this->mongo_db;


		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo->order_by($order_by)
			->get($this->collection);

	}

	public function getCountByRole_quahan($condition = array()){
		$order_by = ["created_at" => "DESC"];
		$where = array();

		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['borrowed_start'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['status'] = array('$in' => ["12"]);

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		if (!empty($condition['code_contract_disbursement_text'])) {
			$mongo = $mongo->like("code_contract_disbursement_text", $condition['code_contract_disbursement_text']);
		}


			return $mongo->order_by($order_by)
				->count($this->collection);

	}

	public function getCountByRole($condition = array())
	{
		$order_by = ["created_at" => "DESC"];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['borrowed_start'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		if (isset($condition['status'])) {
			$where['status'] = $condition['status'];
		}


		if (isset($condition['groupRoles_store'])) {
			$where['groupRoles_store'] = $condition['groupRoles_store'];
		}
		if (isset($condition['domain_borrow']) || isset($condition['created_by'])) {
			if (isset($condition['domain_borrow'])) {
				$mongo = $mongo->or_where(['created_by.email' => $condition['created_by'], 'domain_borrow' => $condition['domain_borrow']]);
			}
		}
		if (isset($condition['stores'])) {
			$in = $condition['stores'];
			unset($condition['stores']);
		}

		if (isset($condition['area'])) {
			if ($condition['area'] == "KV_HN1" || $condition['area'] == "MB" || $condition['area'] == "KV_HN2") {
				$where['area'] = array('$in' => ["KV_HN1", "KV_MT1","KV_HN2", "KV_QN"]);
			}
			if ($condition['area'] == "KV_HCM1") {
				$where['area'] = array('$in' => ["KV_HCM1"]);
			}
			if ($condition['area'] == "KV_HCM2") {
				$where['area'] = array('$in' => ["KV_HCM2"]);
			}
			if ($condition['area'] == "MN") {
				$where['area'] = array('$in' => ["KV_HCM2", "KV_HCM1", "KV_BD"]);
			}

			if ($condition['area'] == "KV_MK" || $condition['area'] == "MK") {
				$where['area'] = array('$in' => ["KV_MK","KV_BD"]);
			}
			if ($condition['area'] == "Khu_vuc") {
				$where['area'] = array('$in' => ["KV_MK","KV_HCM2","KV_HCM1","KV_BD"]);
			}

		}

		if (isset($condition['stores_list'])) {
			$where['stores'] = array('$in' => $condition['stores_list']);
		}
		if (isset($condition['store'])) {
			$where['stores'] = $condition['store'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		if (!empty($condition['code_contract_disbursement_text'])) {
			$mongo = $mongo->like("code_contract_disbursement_text", $condition['code_contract_disbursement_text']);
		}

		if (!empty($condition['groupRoles_store_search'])) {
			$mongo = $mongo->like("groupRoles_store", $condition['groupRoles_store_search']);
		}
		if (!empty($in)) {
			return $mongo->order_by($order_by)
				->where_in('stores', $in)
				->count($this->collection);
		} else {
			return $mongo->order_by($order_by)
				->count($this->collection);
		}

	}

	public function getNotification_borrowed($inputs = array())
	{
		$mongo = $this->mongo_db;
		$where = [];
		$limit = '';
		if (isset($inputs['user_id'])) {
			$where['user_id'] = $inputs['user_id'];
		}
		if (isset($inputs['status_notification'])) {
			$status = $inputs['status_notification'];
			unset($inputs['status_notification']);
		}
		if (isset($inputs['limit'])) {
			$limit = $inputs['limit'];
			unset($inputs['limit']);
		}
		$mongo = $mongo->set_where($where);
		if (isset($inputs['count'])) {
			unset($inputs['count']);
			return $mongo->order_by(array('created_at' => 'DESC'))
				->where_in('status_notification', [1])
				->count($this->collection);
		}
		if (!empty($limit)) {
			return $mongo->order_by(array('created_at' => 'DESC'))
				->limit($limit)
				->offset(0)
				->where_in('status_notification', $status)
				->get_where($this->collection, $inputs);
		}
		return $mongo->order_by(array('created_at' => 'DESC'))
			->where_in('status_notification', $status)
			->get_where($this->collection, $inputs);
	}

	public function getDataByRole_excel($condition){

		$order_by = ["created_at" => "DESC"];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['borrowed_start'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		if (isset($condition['store'])) {
			$where['stores'] = $condition['store'];
		}

		if (isset($condition['stores'])) {
			$in = $condition['stores'];
			unset($condition['stores']);
		}

		if (isset($condition['groupRoles_store'])) {
			$where['groupRoles_store'] = $condition['groupRoles_store'];
		}

		if (isset($condition['domain_borrow']) || isset($condition['created_by'])) {
			if (isset($condition['domain_borrow'])) {
				$mongo = $mongo->or_where(['created_by.email' => $condition['created_by'], 'domain_borrow' => $condition['domain_borrow']]);
			}
		}

		if (isset($condition['area'])) {
			if ($condition['area'] == "KV_HN1" || $condition['area'] == "MB" || $condition['area'] == "KV_HN2") {
				$where['area'] = array('$in' => ["KV_HN1", "KV_MT1","KV_HN2", "KV_QN"]);
			}
			if ($condition['area'] == "KV_HCM1") {
				$where['area'] = array('$in' => ["KV_HCM1"]);
			}
			if ($condition['area'] == "KV_HCM2") {
				$where['area'] = array('$in' => ["KV_HCM2"]);
			}
			if ($condition['area'] == "MN") {
				$where['area'] = array('$in' => ["KV_HCM2", "KV_HCM1","KV_BD"]);
			}

			if ($condition['area'] == "KV_MK" || $condition['area'] == "MK") {
				$where['area'] = array('$in' => ["KV_MK","KV_BD"]);
			}
		}

		if (isset($condition['stores_list'])) {
			$where['stores'] = array('$in' => $condition['stores_list']);
		}

		if (isset($condition['status'])) {
			$where['status'] = $condition['status'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		if (!empty($condition['code_contract_disbursement_text'])) {
			$mongo = $mongo->like("code_contract_disbursement_text", $condition['code_contract_disbursement_text']);
		}

		if (!empty($in)) {
			return $mongo->order_by($order_by)
				->where_in('stores', $in)

				->get($this->collection);
		} else {
			return $mongo->order_by($order_by)

				->get($this->collection);
		}




	}

	public function find_where_select($condition, $select)
	{
		return $this->mongo_db
			->select($select)
			->where($condition)
			->get($this->collection);
	}




}
