<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Log_trans_model extends CI_Model
{

	private $collection = 'log_trans';

    public function  __construct()
    {
        parent::__construct();
		$this->manager = new MongoDB\Driver\Manager($this->config->item("mongo_db")['dsn'],$this->config->item("mongo_db")['options']);
		$this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
    }

    public function insert($data) {
        $insert = [
            "transaction_id" => isset($data['transaction_id']) ? $data['transaction_id'] : "",
            "action" => isset($data['action']) ? $data['action'] : "",
            "old" => isset($data['old']) ? $data['old'] : "",
            "new" => isset($data['new']) ? $data['new'] : "",
            "created_at" => isset($data['created_at']) ? $data['created_at'] : "",
            "created_by" => isset($data['created_by']) ? $data['created_by'] : "",
        ];
        $this->mongo_db->insert($this->collection, $data);
    }

	public function getAllCkThanhToan($condition, $vp = false)
	{
		$mongo = $this->mongo_db;
		$where['action'] = 'duyet_giao_dich';
		if ($vp) {
			//
		} else {
			$where['old.bank'] = ['$nin' => ['VPB']];
		}
		$where['old.type'] = 4;
		$where['old.payment_method'] = "2";
		if(!empty($condition['code_contract'])){
			$where['old.code_contract'] = $condition['code_contract'];
		}
		if(!empty($condition["code_transaction_bank"])){
			$where['old.code_transaction_bank'] = $condition["code_transaction_bank"];
		}
		if(!empty($condition['code_contract_disbursement'])){
			$where['old.code_contract_disbursement'] = $condition['code_contract_disbursement'];
		}
		$mongo = $mongo->set_where($where);
		if (!empty($condition['place'])) {
			$mongo->where_in('old.store.id', $condition['place']);
		}
		return $mongo
			->order_by(['created_at' => 'desc'])
			->limit(1)
			->get($this->collection);

	}

	public function getAllTienMatThanhToan($condition, $vp = false)
	{
		$mongo = $this->mongo_db;
		$where['action'] = 'duyet_giao_dich';
		if($vp){
			//
		}else{
			$where['old.bank'] = ['$nin' => ['VPB']];
		}
		$where['old.type'] = 4;
		$where['old.payment_method'] = "1";
		if(!empty($condition['code_contract'])){
			$where['old.code_contract'] = $condition['code_contract'];
		}
		if(!empty($condition["code_transaction_bank"])){
			$where['old.code_transaction_bank'] = $condition["code_transaction_bank"];
		}
		if(!empty($condition['code_contract_disbursement'])){
			$where['old.code_contract_disbursement'] = $condition['code_contract_disbursement'];
		}
		$mongo = $mongo->set_where($where);
		if(!empty($condition['place'])){
			$mongo->where_in('old.store.id', $condition['place']);
		}
		return $mongo
			->order_by(['created_at' => 'desc'])
			->limit(1)
			->get($this->collection);

	}

	public function getAlltatToan($condition, $vp = false)
	{
		$mongo = $this->mongo_db;
		$where = [];
		$where['action'] = 'duyet_giao_dich';
		$where['old.type'] = 3;
		if($vp){
			//
		}else {
			$where['old.bank'] = ['$nin' => ['VPB']];
		}
		if(!empty($condition['code_contract'])){
			$where['old.code_contract'] = $condition['code_contract'];
		}
		if(!empty($condition["code_transaction_bank"])){
			$where['old.code_transaction_bank'] = $condition["code_transaction_bank"];
		}
		if(!empty($condition['code_contract_disbursement'])){
			$where['old.code_contract_disbursement'] = $condition['code_contract_disbursement'];
		}
		$mongo = $mongo->set_where($where);
		if (!empty($condition['place'])) {
			$mongo->where_in('old.store.id', $condition['place']);
		}
		return $mongo
			->order_by(['created_at' => 'desc'])
			->limit(1)
			->get($this->collection);

	}
}
