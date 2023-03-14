
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Seo_model extends CI_Model
{
	private $collection = 'seo';

	public function  __construct()
	{
		parent::__construct();
	}

	public function find(){
		return $this->mongo_db
			->order_by(array('created_at' => 'DESC'))
			->get($this->collection);
	}
	public function insert($data){
		return $this->mongo_db->insert($this->collection, $data);
	}
	public function findOne($condition){
		return $this->mongo_db->where($condition)->find_one($this->collection);
	}
	public function count($condition){
		return $this->mongo_db->where($condition)->count($this->collection);
	}
	public function find_where($field="", $in=array()){
		return $this->mongo_db
			->where_in($field, $in)->order_by(array('updated_at' => 'DESC'))->get($this->collection);
	}
	public function find_seo_in($condition, $in)
	{
		return $this->mongo_db->where($condition)->where_in('code_seo', $in)->order_by(array('created_at' => 'DESC'))->limit('1')->get($this->collection);
	}
	public function update($condition, $set){
		return $this->mongo_db->where($condition)->set($set)->update($this->collection);
	}
	public function delete($condition){
		return $this->mongo_db->where($condition)->delete($this->collection);
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


	public function post_api($url,$data,$headers) {
		$postdata = http_build_query(
			$data
		);
		if(empty($headers)){
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
		try{
			return $decodeResponse;
			// \Log::info($result);
		}catch(\Exception $e){
			return false;
		}
	}

	public function getMaxNumberseo()
	{
		return $this->mongo_db
			->select(array("code_seo"))
			->order_by(array('code_seo' => 'DESC'))
			->limit(1)
			->get($this->collection);
	}

	public function find_where_pt($condition = array(), $limit = 30, $offset = 0)
	{
		if (!empty($condition['count'])) {
			return $this->mongo_db->where_in("status", array("active"))
			->order_by(array("updated_at" => "DESC"))->count($this->collection);
		} else {
			return $this->mongo_db
				->where_in("status", array("active"))
				->limit($limit)->offset($offset)
				->order_by(array("updated_at" => "DESC"))
				->get($this->collection);
		}
		
	}

}


