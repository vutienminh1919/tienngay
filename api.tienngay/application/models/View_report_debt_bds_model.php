<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class View_report_debt_bds_model extends CI_Model
{

	private $collection = 'view_report_debt_bds';

	public function __construct()
	{
		parent::__construct();
		$this->manager = new MongoDB\Driver\Manager($this->config->item("mongo_db")['dsn'], $this->config->item("mongo_db")['options']);
		$this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
	}

	public function insert($data)
	{
		return $this->mongo_db_read_live->insert($this->collection, $data);
	}

	public function findOne($condition)
	{
		return $this->mongo_db_read_live->where($condition)->find_one($this->collection);
	}

	public function count($condition)
	{
		return $this->mongo_db_read_live->where($condition)->count($this->collection);
	}

	public function find_where($condition)
	{
		return $this->mongo_db_read_live
			->get_where($this->collection, $condition);
	}

	public function find()
	{
		return $this->mongo_db_read_live
			->order_by(array('created_at' => 'DESC'))
			->get($this->collection);
	}

	public function update($condition, $set)
	{
		return $this->mongo_db_read_live->where($condition)->set($set)->update($this->collection);
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
		$data = $this->mongo_db_read_live->aggregate($this->collection, $ops)->toArray();
		if (isset($data[0]['total'])) {
			return $data[0]['total'];
		} else {
			return 0;
		}

	}


}
