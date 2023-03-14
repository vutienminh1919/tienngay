
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bao_hiem_pgd_model extends CI_Model
{
	private $collection = 'bao_hiem_pgd';

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
	   public function getBH($condition = array(),$limit = 30, $offset = 0) {
		$order_by = ['created_at' => 'DESC'];
		$where = array();
		$mongo = $this->mongo_db;
	
		 if(isset($condition['start']) && isset($condition['end'])){
			 $where['created_at'] = array(
				 '$gte' => $condition['start'],
				 '$lte' => $condition['end']
			 );
			 unset($condition['start']);
			 unset($condition['end']);
		 }
		if(isset($condition['total']))
		{
			if(isset($condition['stores'])){
			$in = $condition['stores'];
			unset($condition['stores']);
			$mongo = $mongo->set_where($where);
			return $mongo->order_by($order_by)
				->where_in('store.id',$in)
		        ->count($this->collection);
			} else {
				$mongo = $mongo->set_where($where);
				return $mongo->order_by($order_by)
					->count($this->collection);
			}

		}else{
			if(isset($condition['stores'])){
				$in = $condition['stores'];
				unset($condition['stores']);
				$mongo = $mongo->set_where($where);
				return $mongo->order_by($order_by)
					->where_in('store.id',$in)
					  ->limit($limit)
	                ->offset($offset)
					->get($this->collection);
			} else {
				$mongo = $mongo->set_where($where);
				return $mongo->order_by($order_by)
				  ->limit($limit)
	                ->offset($offset)
					->get($this->collection);
			}
	}
    }
    public function sum_where($condtion = array(),$get){
		$ops = array(
			array (
				'$match' => $condtion
			),
			array(
				'$group' => array(
					'_id' => null,
					'total' => array('$sum' =>  $get ),
				),
			),
		);
		$data = $this->mongo_db->aggregate($this->collection, $ops)->toArray();
		if(isset($data[0]['total'])){
			return $data[0]['total'];
		}else{
			return 0;
		}

	}



}


