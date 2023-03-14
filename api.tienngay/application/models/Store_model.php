<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Store_model extends CI_Model
{
	private $collection = 'store';

	public function __construct()
	{
		parent::__construct();
		$this->load->model("area_model");
	}

	public function find()
	{
		return $this->mongo_db
			->order_by(array('created_at' => 'DESC'))
			->get($this->collection);
	}

	public function findOneAndUpdate($where = "", $inforUupdate = "")
	{
		$update = array(
			'$set' => $inforUupdate
		);
		return $this->mongo_db->find_one_and_update($this->collection, $where, $update);
	}

	public function getCountStore($inputs = array())
	{
		$mongo = $this->mongo_db;
		if (isset($inputs['count']) && $inputs['count']) {
			$where = [];
			if (isset($inputs['user_id'])) {
				$where['user_id'] = $inputs['user_id'];
			}
			if (isset($inputs['type'])) {
				$where['type'] = $inputs['type'];
			}
			$mongo = $mongo->set_where($where);
			return $mongo->count($this->collection);
		}
	}

	public function getStore($where = array())
	{
		$mongo = $this->mongo_db;
		$order_by = ['created_at' => 'DESC'];
		if (isset($where['start']) && isset($where['end'])) {
			$where['create_at'] = array(
				'$gte' => $where['start'],
				'$lte' => $where['end']
			);
			unset($where['start']);
			unset($where['end']);
			unset($where['count']);
		}

		$mongo = $mongo->set_where($where);

		return $mongo->order_by($order_by)->offset($offset)->limit($limit)->get($this->collection);
	}

	public function getStore_by_add($condition = array())
	{
		$order_by = ['name' => 'DESC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		$where['status'] = "active";
		$where['type_pgd'] = "1";
		if (!empty($condition['province_id'])) {
			$where['province_id'] = $condition['province_id'];
		}
		if (!empty($condition['district_id'])) {
			$where['district_id'] = $condition['district_id'];
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		return $mongo->order_by($order_by)->get($this->collection);
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
		return $this->mongo_db
			->order_by(['name' => 'ASC'])
			->get_where($this->collection, $condition);
	}

	public function find_where_order_by($condition)
	{
		return $this->mongo_db
			->order_by(['code_area' => 'DESC'])
			->get_where($this->collection, $condition);
	}

	public function update($condition, $set)
	{
		return $this->mongo_db->where($condition)->set($set)->update($this->collection);
	}

	public function delete($condition)
	{
		return $this->mongo_db->where($condition)->delete($this->collection);
	}

	public function find_where_select($condition, $value)
	{
		return $this->mongo_db
			->select($value)
			->get_where($this->collection, $condition);
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

	public function find_where_in($field = "", $in = array())
	{
		return $this->mongo_db
			->where_in($field, $in)->order_by(array('created_at' => 'DESC'))->get($this->collection);
	}

	public function find_where_in_follow($field = "", $in = array())
	{
		return $this->mongo_db
			->where_in($field, $in)->select(['name'])->order_by(array('created_at' => 'DESC'))->get($this->collection);
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

	public function sum_where($condtion = array(), $get)
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

	public function where_code_area($condition)
	{

		$where = array();

		$mongo = $this->mongo_db;

		if (isset($condition['code'])) {
			$where['code_area'] = $condition['code'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo
			->select(["_id"])
			->get($this->collection);
	}

	public function find_where_in_new($condition)
	{

		$where = array();

		$mongo = $this->mongo_db;

		$where['status'] = "active";
		$area_mb = ["KV_HN1", "KV_MT1", "KV_HN2", "KV_QN", 'Priority', 'KV_BTB'];
		$area_mn = ["KV_HCM1", "KV_HCM2"];
		$area_mekong = ["KV_MK"];


		if (isset($condition['area'])) {
			if ($condition['increase'] == 1) {
				if ($condition['area'] == "MB") {
					$where['code_area'] = array('$in' => $area_mb);
				}
				if ($condition['area'] == "MN") {
					$where['code_area'] = array('$in' => $area_mn);
				}
				if ($condition['area'] == "MK") {
					$where['code_area'] = array('$in' => $area_mekong);
				}
			} elseif ($condition['increase'] == 2) {
				$array_area_merge = array_merge($area_mb, $area_mn);
				$where['code_area'] = array('$in' => $array_area_merge);
			} elseif ($condition['increase'] == 3) {
				$array_area_merge = array_merge($area_mb, $area_mn, $area_mekong);
				$where['code_area'] = array('$in' => $array_area_merge);
			}

		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo->order_by(array('created_at' => 'DESC'))->get($this->collection);
	}

	public function get_vpb_store_code($condition)
	{
		$mongo = $this->mongo_db;
		if (!empty($condition['vpb_store_code'])) {
			$mongo = $mongo->like("vpb_store_code", $condition['vpb_store_code']);
		}
		return $mongo->get($this->collection);
	}

	public function insertReturnId($data)
	{
		return $this->mongo_db->insertReturnId($this->collection, $data);
	}

	public function find_where_sort($condition)
	{
		return $this->mongo_db
			->order_by(['code_area' => 'ASC'])
			->get_where($this->collection, $condition);
	}

	public function find_one_select($condition, $select)
	{
		return $this->mongo_db
			->select($select)
			->where($condition)
			->find_one($this->collection);
	}

	public function get_code_area($condition)
	{
		$where = array();

		$mongo = $this->mongo_db;

		if (isset($condition['id'])) {
			$where['_id'] = new MongoDB\BSON\ObjectId($condition['id']);
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo
			->select(["code_area"])
			->find_one($this->collection);
	}

	public function find_where_in_active($field = "", $in = array())
	{
		return $this->mongo_db
			->where(['status' => 'active'])
			->where_in($field, $in)->order_by(array('created_at' => 'DESC'))->get($this->collection);
	}

	public function find_pgd_active_and_valid_address()
	{
		$mongo = $this->mongo_db;
		$nin = ['Priority', 'BPD01', 'Direct Sale KGN', 'Direct Sale BD', 'Direct Sale HCM 1', 'Direct Sale HCM 2'];
		return $mongo->where(['status' => 'active', 'type_pgd' => ['$in' => ["1"]], 'name' => ['$nin' => $nin]])
			->select(['address', 'location', 'name', 'phone'])
			->get($this->collection);

	}

	/** Get domain area
	 * @param $store_id
	 * @return string
	 */
	public function get_area_by_store_id($store_id)
	{
		$mongo = $this->mongo_db;
		$area_text = '';
		$store_record = $mongo->where(['_id' => new \MongoDB\BSON\ObjectId($store_id)])
			->select(['code_area'])
			->find_one($this->collection);

		$area_record = $this->area_model->get_domain_by_code_area($store_record['code_area']);
		if (!empty($area_record)) {
			$area_text = $area_record['domain']['code'];
		}
		return $area_text;
	}

	public function find_distinct($condition, $distinct)
	{
		$mongo = $this->mongo_db;
		return $mongo
			->where($condition)
			->distinct($this->collection, $distinct);
	}

}


