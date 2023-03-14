<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Log_cancel_contract_model extends CI_Model
{

	private $collection = 'log_cancel_contract';

	public function  __construct()
	{
		parent::__construct();
	}
	public function insert($data){
		return $this->mongo_db->insert($this->collection, $data);
	}

	public function insertReturnId($data)
	{
		return $this->mongo_db->insertReturnId($this->collection, $data);
	}

	public function find()
	{
		return $this->mongo_db
			->get($this->collection);
	}

}
