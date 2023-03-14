<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Log_vbee_thn_model extends CI_Model
{
	private $collection = 'log_vbee_thn';

	public function  __construct()
	{
		parent::__construct();
	}

	public function insert($data){
		return $this->mongo_db->insert($this->collection, $data);
	}

	public function find_record($phone, $campaign_id)
	{
		$mongo = $this->mongo_db;
		return $mongo
			->where(['request.data.state' => 40, 'request.data.campaign_id' => $campaign_id, 'request.data.callee_id' => $phone])
			->select(['request.data.record_audio'])
			->get($this->collection);

	}
}
