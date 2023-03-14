
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payment_holidays_model extends CI_Model
{
	private $collection = 'payment_holidays';
	const STATUS_ACTIVE = 1;
	const STATUS_DISABLE = 2;

	public function __construct()
	{
		parent::__construct();
	}

	public function insert($data)
	{
		return $this->mongo_db->insert($this->collection, $data);
	}

	public function findOne($conditions)
	{
		return $this->mongo_db->where('deleted_at is null')->where($conditions)->find_one($this->collection);
	}

	public function findOneActive($conditions)
	{
		$conditions['status'] = self::STATUS_ACTIVE;
		return $this->mongo_db->where('deleted_at is null')->where($conditions)->find_one($this->collection);
	}
}


