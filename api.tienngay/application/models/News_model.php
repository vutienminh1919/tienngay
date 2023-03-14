<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class News_model extends CI_Model
{
	private $collection = 'news';

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

	public function find_where($field = "", $in = array())
	{
		return $this->mongo_db
			->where_in($field, $in)->order_by(array('updated_at' => 'DESC'))->get($this->collection);
	}

	public function find_where_pt($condition = array(), $limit = 30, $offset = 0)
	{
		$mongo = $this->mongo_db;
		$where['type_new'] = '1';
		if (!empty($condition['count'])) {
			$mongo = $mongo->set_where($where);
			return $this->mongo_db
				->where_in("status", array("active"))
				->order_by(array('updated_at' => 'DESC'))->count($this->collection);
		} else {
			$mongo = $mongo->set_where($where);
			return $this->mongo_db
				->where_in("status", array("active"))
				->limit($limit)
				->offset($offset)
				->order_by(array('updated_at' => 'DESC'))->get($this->collection);
		}
	}

	public function update($condition, $set)
	{
		return $this->mongo_db->where($condition)->set($set)->update($this->collection);
	}

	public function delete($condition)
	{
		return $this->mongo_db->where($condition)->delete($this->collection);
	}

	public function find_where_not_in($condition, $field = "", $in = "")
	{
		if (empty($in)) {
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


	public function post_api($url, $data, $headers)
	{
		$postdata = http_build_query(
			$data
		);
		if (empty($headers)) {
			$headers = "Content-type: application/x-www-form-urlencoded\r\n";
		}
		$opts = array('http' =>
			array(
				'method' => 'POST',
				'header' => $headers,
				'content' => $postdata,
				'ignore_errors' => '1'
			)
		);
		$context = stream_context_create($opts);
		$result = file_get_contents($url, false, $context);
		$decodeResponse = json_decode($result);
		try {
			return $decodeResponse;
			// \Log::info($result);
		} catch (\Exception $e) {
			return false;
		}
	}

	public function find_where_select($condition, $value)
	{
		return $this->mongodb
			->select($value)
			->get_where($this->collection, $condition);
	}

	public function get_news_by_position_model($condition = array())
	{
		$order_by = ["period" => "DESC"];
		$where = array();
		$mongo = $this->mongo_db;
		$where['status'] = "active";
		$where['type_new'] = "2";
		if (!empty($condition['title_vi'])) {
			$where['title_vi'] = $condition['title_vi'];
		}
		if (!empty($condition['province'])) {
			$where['province'] = $condition['province'];
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		return $mongo->order_by($order_by)->get($this->collection);
	}

	public function find_where_title_vi($condition)
	{
		$mongo = $this->mongo_db;
		$ops = array(
			array(
				'$match' => array(
					'status' => 'active',
					'type_new' => '2',
					'province.' . $condition['province'] . '.province_code' => $condition['province'],
				)
			)
		);
		$data = $this->mongo_db->aggregate($this->collection, $ops)->toArray();
		return $data;
	}

	public function find_news_recuiment($condition = array())
	{
		$order_by = ["period" => "DESC"];
		$where = array();
		$mongo = $this->mongo_db;
		$where['status'] = "active";
		$where['type_new'] = "2";
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (!empty($condition['title_vi'])) {
			$mongo = $mongo->like("title_vi", $condition['title_vi']);
			return $mongo->order_by($order_by)
				->get($this->collection);
		}
	}

	public function find_news_by_link($condition)
	{
		$where = array();
		$mongo = $this->mongo_db;
		$where['status'] = "active";
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (isset($condition['link'])) {
			$mongo = $mongo->or_where(array('link' => $condition['link'], 'sub_link' => $condition['link']));
		}
		return $mongo->find_one($this->collection);
	}
	public function get_all_recruitment($condition = array(), $limit = 30, $offset = 0)
	{
		$mongo = $this->mongo_db;
		$where['type_new'] = '2';
		if (!empty($condition['count'])) {
			$mongo = $mongo->set_where($where);
			return $this->mongo_db
				->where_in("status", array("active"))
				->order_by(array('updated_at' => 'DESC'))->count($this->collection);
		} else {
			$mongo = $mongo->set_where($where);
			return $this->mongo_db
				->where_in("status", array("active"))
				->limit($limit)
				->offset($offset)
				->order_by(array('updated_at' => 'DESC'))->get($this->collection);
		}
	}

	public function finds_all_new_recruitment($condition = array(), $limit = 8, $offset = 0)
	{
		$mongo = $this->mongo_db;
		$where['type_new'] = '2';
		$where['status'] = 'active';
		$mongo = $mongo->set_where($where);
		if (!empty($condition['count'])) {
			return $mongo->count($this->collection);
		} else {
			return $mongo
				->order_by(array('updated_at' => 'DESC'))
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		}
	}
}


