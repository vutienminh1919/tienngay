<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Import_vps_model extends CI_Model
{
	private $collection = 'import_vps';

	public function __construct()
	{
		parent::__construct();
	}

	public function find_pagination($per_page, $uriSegment)
	{
		return $this->mongo_db
			->limit($per_page)
			->offset($uriSegment)
			->get($this->collection);
	}

	public function find()
	{
		return $this->mongo_db
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

	public function count()
	{
		return $this->mongo_db->count($this->collection);
	}

	public function find_where($condition)
	{
		return $this->mongo_db
			->get_where($this->collection, $condition);
	}

	public function update($condition, $set)
	{
		return $this->mongo_db->where($condition)->set($set)->update($this->collection);
	}

	public function delete()
	{
		return $this->mongo_db->delete($this->collection);
	}

	public function sum_where($condtion = array(), $get)
	{
		$ops = array(
			array(
				'$match' => $condtion
			),

			array(
				'$group' => array(
					'_id' => null,
					'total' => array('$sum' => array('$toDouble' => $get)),
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


