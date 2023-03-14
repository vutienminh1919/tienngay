<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Depreciation_model extends CI_Model
{
	private $collection = 'depreciation';
	private $manager;

	public function __construct()
	{
		parent::__construct();
		$this->manager = new MongoDB\Driver\Manager($this->config->item("mongo_db")['dsn'], $this->config->item("mongo_db")['options']);
	}

	public function insert($data)
	{
		return $this->mongo_db->insert($this->collection, $data);
	}

	public function findOne($condition)
	{
		return $this->mongo_db->where($condition)->find_one($this->collection);
	}

	public function update($condition, $set)
	{
		return $this->mongo_db->where($condition)->set($set)->update($this->collection);
	}

	public function delete($condition)
	{
		return $this->mongo_db->where($condition)->delete($this->collection);
	}

	public function find_where($condition)
	{
		return $this->mongo_db->get_where($this->collection, $condition);
	}

	public function get_list_depreciation($condition = array(), $limit = 30, $offset = 0)
	{
		$mongo = $this->mongo_db;
		$where = array();
		if (!empty($condition['vehicles'])) {
			$where['main_property'] = $condition['vehicles'];
		}
		if (!empty($condition['type_property'])) {
			$where['type_property'] = $condition['type_property'];
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		return $mongo->order_by(array('main_property' => 'ASC'))
			->order_by(array('type_property' => 'ASC'))
			->order_by(array('depreciation' => 'ASC'))
			->order_by(array('year' => 'ASC'))
			->limit($limit)
			->offset($offset)
			->get($this->collection);
	}

	public function get_count_depreciation($condition)
	{
		$mongo = $this->mongo_db;
		$where = array();
		if (!empty($condition['vehicles'])) {
			$where['main_property'] = $condition['vehicles'];
		}
		if (!empty($condition['type_property'])) {
			$where['type_property'] = $condition['type_property'];
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		return $mongo
			->count($this->collection);
	}

	public function findOneMain()
	{
		$mongo = $this->mongo_db;
		return $mongo->select(['main_property'])
			->get($this->collection);
	}

	public function find_one_name_main()
	{
		$mongo = $this->mongo_db;
		return $mongo->distinct($this->collection, 'main_property');
	}

	public function get_depreciation_new($condition = array(), $limit = 30, $offset = 0)
	{
		$mongo = $this->mongo_db;
		$where = array();
		if (!empty($condition['hang_xe_khau_hao'])) {
			$where['slug_main_property'] = $condition['hang_xe_khau_hao'];
		}
		if (!empty($condition['phan_khuc_khau_hao'])) {
			$where['phan_khuc'] = $condition['phan_khuc_khau_hao'];
		}
		if (!empty($condition['code'])) {
			$where['code'] = $condition['code'];
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		return $mongo->order_by(array('slug_main_property' => 'ASC'))
			->order_by(array('phan_khuc' => 'ASC'))
			->order_by(array('year' => 'ASC'))
			->limit($limit)
			->offset($offset)
			->get($this->collection);
	}

	public function get_count_depreciation_new($condition)
	{
		$mongo = $this->mongo_db;
		$where = array();
		if (!empty($condition['hang_xe_khau_hao'])) {
			$where['slug_main_property'] = $condition['hang_xe_khau_hao'];
		}
		if (!empty($condition['phan_khuc_khau_hao'])) {
			$where['phan_khuc'] = $condition['phan_khuc_khau_hao'];
		}
		if (!empty($condition['code'])) {
			$where['code'] = $condition['code'];
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		return $mongo
			->count($this->collection);
	}

	public function find_distinct_main($condition, $distinct)
	{
		$mongo = $this->mongo_db;
		return $mongo
			->where($condition)
			->distinct($this->collection, $distinct);
	}
}
