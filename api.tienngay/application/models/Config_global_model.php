<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Config_global_model extends CI_Model
{
	private $collection = 'config_global';

	public function __construct()
	{
		parent::__construct();
		$this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
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

}
