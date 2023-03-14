<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Property_blacklist_model extends CI_Model
{
	private $collection = 'blacklist_property';

	public function __construct()
	{
		parent::__construct();
	}

	public function find()
	{
		return $this->mongo_db
			->order_by(array('created_at' => 'DESC'))
			->get($this->collection);
	}

	public function insert($data)
	{
		return $this->mongo_db->insert($this->collection, $data);
	}

	public function findOne($condition)
	{
		return $this->mongo_db->where($condition)->find_one($this->collection);
	}

	public function count($condition)
	{
		return $this->mongo_db->where($condition)->count($this->collection);
	}

	public function find_where($condition)
	{
		return $this->mongo_db->where($condition)->get($this->collection);
	}

	public function find_where_in($field = "", $in = array())
	{
		return $this->mongo_db
			->where_in($field, $in)->order_by(array('updated_at' => 'DESC'))->get($this->collection);
	}

	public function update($condition, $set)
	{
		return $this->mongo_db->where($condition)->set($set)->update($this->collection);
	}

	public function delete($condition)
	{
		return $this->mongo_db->where($condition)->delete($this->collection);
	}

	public function insertReturnId($data)
	{
		return $this->mongo_db->insertReturnId($this->collection, $data);
	}

	public function find_distinct_main($condition, $distinct)
	{
		$mongo = $this->mongo_db;
		return $mongo
			->where($condition)
			->distinct($this->collection, $distinct);
	}
	//danh sách request vào blacklist
	public function getRequestBlacklistProperty($condition, $limit, $offset)
	{
		$mongo = $this->mongo_db;
		$order_by = ['status' => 'ASC', 'created_at' => 'DESC'];
		$where = [];
//		$where['status'] = ['$in' => [1, 2, 3, 4, 200]];

		if (!empty($condition['property'])) {
			$where['code'] = $condition['property'];
		}
		if (!empty($condition['status_blacklist'])) {
			$where['status'] = (int)$condition['status_blacklist'];
		} else {
			$where['status'] = ['$in' => [1, 2, 3, 4, 200]];
		}
		if (!empty($condition['user'])) {
			$where['created_by'] = $condition['user'];
		}
		if (!empty($condition['hang_xe'])) {
			$where['slug_brand_name'] = $condition['hang_xe'];
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (isset($condition['total'])) {
			return $mongo->order_by($order_by)
				->count($this->collection);
		}
		else {
			return $mongo->order_by($order_by)
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		}

	}
	//danh sách blacklist
	public function getBlacklistProperty($condition, $limit, $offset)
	{
		$mongo = $this->mongo_db;
		$order_by = ['status' => 'ASC','created_at' => 'DESC'];
		$where = [];
		if (!empty($condition['from_date']) && !empty($condition['to_date'])) {
			$where['created_at'] = array(
				'$gte' => $condition['from_date'],
				'$lte' => $condition['to_date'],
			);
			unset($condition['from_date']);
			unset($condition['to_date']);
		}

		$where['status'] = ['$in' => ['active', 2]];
		if (!empty($condition['property'])) {
			$where['code'] = $condition['property'];
		}
		if (!empty($condition['hang_xe'])) {
			$where['slug_brand_name'] = $condition['hang_xe'];
		}
		if (!empty($condition['so_khung'])) {
			$where['chassis_number'] = $condition['so_khung'];
		}
		if (!empty($condition['bien_so_xe'])) {
			$where['vehicle_number'] = $condition['bien_so_xe'];
		}
		if (!empty($condition['so_may'])) {
			$where['engine_number'] = $condition['so_may'];
		}
		if (!empty($condition['phone'])) {
			$where['customer_infor.phone'] = $condition['phone'];
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (!empty($condition['identify_passport'])) {
			$mongo = $mongo->or_where(
				['customer_infor.identify' => $condition['identify_passport'],
				'customer_infor.passport' => $condition['identify_passport']]
			);
		}
		if (isset($condition['total'])) {
			return $mongo->order_by($order_by)
				->count($this->collection);
		} else {
			return $mongo->order_by($order_by)
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		}

	}

	public function find_where_not_in($condition, $field="", $in=""){
		if(empty($in)) {
			return $this->mongo_db
				->order_by(array('created_at' => 'DESC'))
				->get_where($this->collection, $condition);
		} else {
			return $this->mongo_db
				->order_by(array('created_at' => 'DESC'))
				->where_not_in($field, $in)
				->get_where($this->collection, $condition);
		}
	}

	public function get_check_fake_property($condition)
	{
		$mongo = $this->mongo_db;
		$where = [];
		$where['status'] = ['active'];
		if (!empty($condition['passport'])) {
			$mongo = $mongo->or_where(['customer_infor.passport' => $condition['passport']]);
		};
		return $mongo
			->or_where([
				'chassis_number' => $condition['chassis_number'],
				'registration.number' => $condition['registration_number'],
				'vehicle_number' => $condition['vehicle_number'],
				'engine_number' => $condition['engine_number'],
				'customer_infor.identify' => $condition['identify'],
				'customer_infor.phone' => $condition['phone']
			])
			->get($this->collection);

	}

	public function get_property_blacklist_scan()
	{
		$mongo = $this->mongo_db;
		$mongo = $mongo->where(['customer_infor.identify' => ['$exists' => true]]);
		$mongo = $mongo->or_where(['customer_infor.identify' => ['$ne' => ""], 'customer_infor.passport' => ['$ne' => ""], 'customer_infor.passport' => ['$exists' => true]]);
		return $mongo
			->where(['status' => ['$in' => ['active', 2]], 'scan' => 1])
			->get($this->collection);

	}

}
