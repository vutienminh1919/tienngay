<?php

class Log_transaction_file_bank_import_model extends CI_Model
{
	private $collection = 'log_transaction_file_bank_import';

    public function  __construct()
    {
        parent::__construct();
    }
    public function insert($data){
        return $this->mongo_db->insert($this->collection, $data);
    }

	public function delete($condition){
        return $this->mongo_db->where($condition)->delete($this->collection);
    }

	public function delete_all(){
		return $this->mongo_db->delete_all($this->collection);
	}

	public function getAll()
	{
		$mongo = $this->mongo_db;
		$where = [];
		$where['type'] = 'all';
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		return $mongo->get($this->collection);

	}
	public function getAllCancel()
	{
		$mongo = $this->mongo_db;
		$where = [];
		$where['type'] = 'cancel';
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		return $mongo->get($this->collection);

	}


}
