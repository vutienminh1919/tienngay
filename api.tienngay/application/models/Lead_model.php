<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lead_model extends CI_Model
{

	private $collection = 'lead';


	public function __construct()
	{
		parent::__construct();

		$this->manager = new MongoDB\Driver\Manager($this->config->item("mongo_db")['dsn'], $this->config->item("mongo_db")['options']);
	}

	public function insert($data)
	{
		return $this->mongo_db->insert($this->collection, $data);
	}

	public function insertReturnId($data)
	{
		return $this->mongo_db->insertReturnId($this->collection, $data);
	}

	public function findOne($condition)
	{
		return $this->mongo_db->where($condition)->order_by(array('created_at' => 'DESC'))->find_one($this->collection);
	}

	public function findOneASC()
	{
		return $this->mongo_db->order_by(array('created_at' => 'ASC'))->find_one($this->collection);
	}

	public function find_where_in($field = "", $in = array())
	{
		return $this->mongo_db
			->where_in($field, $in)->order_by(array('created_at' => 'DESC'))->get($this->collection);
	}

	public function findOne_langding($condition)
	{
		return $this->mongo_db->where($condition)->order_by(array('created_at' => 'DESC'))->limit('1')->get($this->collection);
	}

	public function findOne_create($condition, $in)
	{
		return $this->mongo_db->where($condition)->where_in('status_sale', $in)->order_by(array('created_at' => 'DESC'))->limit('1')->get($this->collection);
	}

	public function count($condition = array())
	{
		if (!empty($condition)) {
			return $this->mongo_db->where($condition)->count($this->collection);
		} else {
			return $this->mongo_db->count($this->collection);
		}
	}

	public function find_where_1($condition)
	{
		$result =  $this
			->mongo_db
			->order_by(array('created_at' => 'DESC'))
			->limit(1)
			->get_where($this->collection, $condition);
		return $result;
	}
	public function find_where($condition)
	{
		return $this->mongo_db
			->get_where($this->collection, $condition);
	}

	// search name
	public function searchByUserName($condition)
	{
		return $this->mongo_db->like('fullname', $condition['fullname'])->get($this->collection);
	}

	public function find()
	{
		return $this->mongo_db
			->order_by(array('created_at' => 'DESC'))
			->get($this->collection);
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

	public function getByRole($condition = array(), $limit = 30, $offset = 0)
	{
		$order_by = ['created_at' => 'DESC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}
		//  if(isset($condition['start']) && !isset($condition['end'])){
		//    $where['created_at'] = array(

		//        '$lte' => $condition['start']
		//    );
		//    unset($condition['start']);

		// }
		if (isset($condition['source'])) {
			$where['source'] = $condition['source'];
		}
		if (isset($condition['area'])) {
			$where['area'] = $condition['area'];
		}
		if (isset($condition['status_sale'])) {
			$where['status_sale'] = $condition['status_sale'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (!empty($condition['utm_source'])) {
			$mongo = $mongo->like("utm_source", $condition['utm_source']);
		}
		if (!empty($condition['utm_campaign'])) {
			$mongo = $mongo->like("utm_campaign", $condition['utm_campaign']);
		}
		if (isset($condition['code_store'])) {
			$mongo = $mongo->where_in('id_PDG', array($condition['code_store']));
		}
		if (isset($condition['isExport'])) {
			return $mongo->order_by($order_by)
				->get($this->collection);
		}
		return $mongo->order_by($order_by)
			->limit($limit)
			->offset($offset)
			->get($this->collection);

	}

	public function mkt_lead_cancel_static($condition = array())
	{
		$order_by = ['created_at' => 'DESC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}
		//  if(isset($condition['start']) && !isset($condition['end'])){
		//    $where['created_at'] = array(

		//        '$lte' => $condition['start']
		//    );
		//    unset($condition['start']);

		// }
		if (isset($condition['source'])) {
			$where['source'] = $condition['source'];
		}
		if (isset($condition['area'])) {
			$where['area'] = $condition['area'];
		}
		if (isset($condition['status_sale'])) {
			$where['status_sale'] = $condition['status_sale'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (!empty($condition['utm_source'])) {
			$mongo = $mongo->like("utm_source", $condition['utm_source']);
		}
		if (!empty($condition['utm_campaign'])) {
			$mongo = $mongo->like("utm_campaign", $condition['utm_campaign']);
		}
		if (isset($condition['code_store'])) {
			$mongo = $mongo->where_in('id_PDG', $condition['code_store']);
		}
		return $mongo->order_by($order_by)
			->get($this->collection);

	}

	public function mkt_report_general($condition = array())
	{
		$order_by = ['created_at' => 'DESC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}
		//  if(isset($condition['start']) && !isset($condition['end'])){
		//    $where['created_at'] = array(

		//        '$lte' => $condition['start']
		//    );
		//    unset($condition['start']);

		// }
		if (isset($condition['source'])) {
			$where['source'] = $condition['source'];
		}
		if (isset($condition['area'])) {
			$where['area'] = $condition['area'];
		}
		if (isset($condition['status_sale'])) {
			$where['status_sale'] = $condition['status_sale'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (!empty($condition['utm_source'])) {
			$mongo = $mongo->like("utm_source", $condition['utm_source']);
		}
		if (!empty($condition['utm_campaign'])) {
			$mongo = $mongo->like("utm_campaign", $condition['utm_campaign']);
		}
		if (isset($condition['code_store'])) {
			$mongo = $mongo->where_in('id_PDG', $condition['code_store']);
		}
		if (isset($condition['isExport'])) {
			return $mongo->order_by($order_by)
				->get($this->collection);
		}
		return $mongo->order_by($order_by)
			->get($this->collection);

	}

	public function getByRole_total($condition)
	{
		$order_by = ['created_at' => 'DESC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}
		if (isset($condition['source'])) {
			$where['source'] = $condition['source'];
		}
		if (isset($condition['area'])) {
			$where['area'] = $condition['area'];
		}
		if (isset($condition['status_sale'])) {
			$where['status_sale'] = $condition['status_sale'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (!empty($condition['utm_source'])) {
			$mongo = $mongo->like("utm_source", $condition['utm_source']);
		}
		if (!empty($condition['utm_campaign'])) {
			$mongo = $mongo->like("utm_campaign", $condition['utm_campaign']);
		}
		if (isset($condition['code_store'])) {
			$mongo = $mongo->where_in('id_PDG', $condition['code_store']);
		}
		return $mongo->order_by($order_by)
			->count($this->collection);
	}

	public function getByRole_pgd_excel($condition = array())
	{
		$order_by = ['office_at' => 'DESC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['office_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}
		//  if(isset($condition['start']) && !isset($condition['end'])){
		//    $where['created_at'] = array(

		//        '$lte' => $condition['start']
		//    );
		//    unset($condition['start']);

		// }
		if (isset($condition['source'])) {
			$where['source'] = $condition['source'];
		}
		if (isset($condition['area'])) {
			$where['area'] = $condition['area'];
		}
		if (isset($condition['status_sale'])) {
			$where['status_sale'] = $condition['status_sale'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (!empty($condition['utm_source'])) {
			$mongo = $mongo->like("utm_source", $condition['utm_source']);
		}
		if (!empty($condition['utm_campaign'])) {
			$mongo = $mongo->like("utm_campaign", $condition['utm_campaign']);
		}
		if (isset($condition['code_store'])) {
			$mongo = $mongo->where_in('id_PDG', $condition['code_store']);
		}

		return $mongo->order_by($order_by)
			->get($this->collection);

	}

	public function getByRole_pgd($condition = array(), $limit = 30, $offset = 0)
	{
		$order_by = ['office_at' => 'DESC'];
//		$order_by = ['updated_at' => 'DESC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['office_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}
		if (isset($condition['status_sale'])) {
			$where['status_sale'] = $condition['status_sale'];
		}
		if (isset($condition['status'])) {
			$where['status'] = $condition['status'];
		}
		if (isset($condition['status_pgd'])) {
			$where['status_pgd'] = $condition['status_pgd'];
		}
		if (isset($condition['area_search'])) {
			$where['id_PDG'] = ['$in' => $condition['area_search']];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		if (isset($condition['code_store'])) {
			$mongo = $mongo->where_in('id_PDG', $condition['code_store']);
		}
		if (isset($condition['id_PDG'])) {
			$mongo = $mongo->where_in('id_PDG', $condition['id_PDG']);
		}
		if (!empty($condition['utm_source'])) {
			$mongo = $mongo->like("utm_source", $condition['utm_source']);
		}
		if (!empty($condition['utm_campaign'])) {
			$mongo = $mongo->like("utm_campaign", $condition['utm_campaign']);
		}
		if (!empty($condition['phone_number'])) {
			$mongo = $mongo->like("phone_number", $condition['phone_number']);
		}
		if (isset($condition['total']) && $condition['total']) {
			return $mongo->where_in('status_sale', array('2'))
				->order_by($order_by)
				->count($this->collection);
		} else {
			return $mongo->where_in('status_sale', array('2'))->order_by($order_by)
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		}


	}

	public function getByRole_mkt_pgd($condition = array(), $limit = 30, $offset = 0)
	{
		$order_by = ['office_at' => 'DESC'];
//		$order_by = ['updated_at' => 'DESC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['office_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}
		if (isset($condition['status_sale'])) {
			$where['status_sale'] = $condition['status_sale'];
		}
		if (isset($condition['status'])) {
			$where['status'] = $condition['status'];
		}
		if (isset($condition['status_pgd'])) {
			$where['status_pgd'] = $condition['status_pgd'];
		}
		if (isset($condition['status_contract'])) {
			$where['status_pgd'] = $condition['status_contract'];
		}
		if (isset($condition['area_search'])) {
			$where['id_PDG'] = ['$in' => $condition['area_search']];
		}


		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		if (isset($condition['code_store'])) {
			$mongo = $mongo->where_in('id_PDG', $condition['code_store']);
		}
		if (isset($condition['id_PDG'])) {
			$mongo = $mongo->where_in('id_PDG', $condition['id_PDG']);
		}
		if (!empty($condition['utm_source'])) {
			$mongo = $mongo->like("utm_source", $condition['utm_source']);
		}
		if (!empty($condition['utm_campaign'])) {
			$mongo = $mongo->like("utm_campaign", $condition['utm_campaign']);
		}
		if (!empty($condition['phone_number'])) {
			$mongo = $mongo->like("phone_number", $condition['phone_number']);
		}
		if (isset($condition['total']) && $condition['total']) {
			return $mongo->where_in('status_sale', array('2'))
				->order_by($order_by)
				->count($this->collection);
		} else {
			return $mongo->where_in('status_sale', array('2'))->order_by($order_by)
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		}


	}

	public function getByRole_mkt($condition = array())
	{
		$order_by = ['office_at' => 'DESC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['office_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}
		if (isset($condition['source'])) {
			$where['source'] = $condition['source'];
		}
		if (isset($condition['area'])) {
			$where['area'] = $condition['area'];
		}
		if (isset($condition['status_sale'])) {
			$where['status_sale'] = $condition['status_sale'];
		}
		if (isset($condition['status_sale_fist'])) {
			$where['status_sale'] = $condition['status_sale_fist'];
		}
		if (isset($condition['status_sale_last'])) {
			$where['status_sale'] = $condition['status_sale_last'];
		}


		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (!empty($condition['utm_source'])) {
			$mongo = $mongo->like("utm_source", $condition['utm_source']);
		}
		if (!empty($condition['utm_campaign'])) {
			$mongo = $mongo->like("utm_campaign", $condition['utm_campaign']);
		}

		if (isset($condition['code_store'])) {
			$mongo = $mongo->where_in('id_PDG', $condition['code_store']);
		}
		return $mongo->where_in('status_sale', array('2', '30'))->order_by($order_by)
			->get($this->collection);

	}

	public function getLead_pt($condition = array(), $limit = 30, $offset = 0)
	{
	    $order_by = ["priority_level" => "ASC", "created_at" => "DESC", 'source' => 'ASC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}
		if (isset($condition['start'])) {
			$where['created_at'] = [
				'$gte' => $condition['start'],
			];
			unset($condition['start']);
		}
		if (isset($condition['end'])) {
			$where['created_at'] = [
				'$lte' => $condition['end'],
			];
			unset($condition['start']);
		}
//		if (isset($condition['status_sale'])) {
//			$where['status_sale'] = $condition['status_sale'];
//		}
		if (isset($condition['area'])) {
			$where['area'] = $condition['area'];
		}
		if (isset($condition['source'])) {
			$where['source'] = $condition['source'];
		}
		if (isset($condition['cskh']) && !isset($condition['tab13'])) {
			$where['cskh'] = $condition['cskh'];
		}
		if (isset($condition['tab13'])) {
			$where['da_tat_toan'] = 'yes';
			if (isset($condition['cskh'])) {
				$where['cskh_taivay'] = $condition['cskh'];
			}
			if (in_array('telesales', $condition['tab13']['groupRoles']) && !in_array('tbp-cskh', $condition['tab13']['groupRoles'])) {

				$where['cskh_taivay'] = $condition['tab13']['email'];
			}

		}

		if (isset($condition['tab2'])) {
		    $where['cskh'] = array('$exists' => false);
		    $mongo= $mongo->where_in('priority',array('1','2','3'));
			$mongo = $mongo->where_in('status_sale', array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19'));
		}

		if (isset($condition['tab3'])) {
			if (in_array('telesales', $condition['tab3']['groupRoles']) && !in_array('tbp-cskh', $condition['tab3']['groupRoles']))
			{
				$where['cskh'] = $condition['tab3']['email'];
			}
		}
		if (isset($condition['tab6'])) {
			if (in_array('telesales', $condition['tab6']['groupRoles']) && !in_array('tbp-cskh', $condition['tab6']['groupRoles'])){
				$where['cskh'] = $condition['tab6']['email'];
			}
		}
		if (isset($condition['tab4'])) {
			if (!empty($condition['priority'])) {
				$mongo = $mongo->where_in('status_sale', array('1'));
				$mongo = $mongo->where_in("priority", [(string)$condition['priority']]);
			} else {
				$mongo = $mongo->where_in('status_sale', array('1'));
			}
		}
		if (isset($condition['tab14'])) {
//			$where['cskh'] = $condition['tab14']['email'];
		}


		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (isset($condition['tab5'])) {
			$mongo = $mongo->where_in('status_sale', array('2'));
		}

		/**
		* Get data
		* @param array $condition = [];
		* @param array $condition['source'], $condition['priority]
		* @return array $mongo
		*/
		if (empty($condition['tab15']) && !empty($condition['source_active']) && empty($condition['tab11']) && empty($condition['tab10'])) {
			if(!empty($condition['source']) && !empty($condition['priority'])) {
				if((in_array($condition['source'], $condition['source_active']) || $condition['source'] == 'phan_nguyen') && $condition['priority'] == "1") {
					$mongo = $mongo->where_in('status_sale', array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19','20'));
					$mongo = $mongo->where('priority', '1');
				} elseif((in_array($condition['source'], $condition['source_active']) || $condition['source'] == 'phan_nguyen') && $condition['priority'] != "1") {
					//return về rỗng
					$mongo = $mongo->where_in('status_sale', array('0'));
				} elseif (!in_array($condition['source'], $condition['source_active']) || $condition['source'] != 'phan_nguyen') {
					$mongo = $mongo->where_in('status_sale', array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19','20'));
					$mongo = $mongo->where_in("priority", [(string)$condition['priority']]);
				}
			} elseif(!empty($condition['source'])) {
				if (in_array($condition['source'], $condition['source_active']) || $condition['source'] == 'phan_nguyen') {
					$mongo = $mongo->where('priority', '1');
				} else {
					$mongo = $mongo->where_in('status_sale', array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19','20'));
					$mongo = $mongo->where_in("priority", ['1','2','3']);
				}
			} elseif(!empty($condition['priority'])) {
				if ($condition['priority'] == "1") {
					$mongo = $mongo->where_in("priority", [(string)$condition['priority']]);
					$mongo = $mongo->where_in('status_sale', array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19','20'));
				} else {
					$mongo = $mongo->where_in("priority", [(string)$condition['priority']]);
					$mongo = $mongo->where(["source" => ['$nin' => $condition['source_active']]]);
					$mongo = $mongo->where(["source" => ['$ne' => 'phan_nguyen']]);
					$mongo = $mongo->where_in('status_sale', array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19','20'));
				}
			} else {
				$mongo = $mongo->where(['$or' => [
					['source' => ['$in' => $condition['source_active']], 'priority' => "1"],
					['source' => ['$nin' => $condition['source_active']]]
				]]);
			}
		}

		if (isset($condition['tab2'])) {
			if (!empty($condition['priority'])) {
				$mongo = $mongo->where_in('status_sale', array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19'));
				$mongo = $mongo->where_in("priority", [(string)$condition['priority']]);
			} else {
				$mongo = $mongo->where_in('status_sale', array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19'));
			}
		}


		if (isset($condition['tab6'])) {
			$mongo = $mongo->where_in('status_sale', array('5', '10', '11', '12', '13', '14', '15', '16', '17', '18'));
		}
		if (isset($condition['tab11'])) {
			$mongo = $mongo->where_in('status_pgd', ['16']);
		}

		if (isset($condition['tab14'])) {
			$mongo = $mongo->where_in('is_topup', ['1']);
		}
		if (isset($condition['tab10'])) {
			$mongo = $mongo->where_in('status_pgd', ['8']);
		}
		if (!empty($condition['email_cskh'])) {
			$mongo = $mongo->where_in('cskh', [$condition['email_cskh']]);
		}
		if (!empty($condition['fullname'])) {
			$mongo = $mongo->like("fullname", $condition['fullname']);
		}
		if (isset($condition['sdt'])) {
			$mongo = $mongo->like("phone_number", $condition['sdt']);
		}
		if (isset($condition['status_sale'])) {
			$mongo = $mongo->where_in("status_sale", [(string)$condition['status_sale']]);
		}


		if (isset($condition['total']) && $condition['total']) {
			return $mongo
				->order_by($order_by)
				->count($this->collection);
		} else {
			return $this->mongo_db
			    ->order_by($order_by)
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		}


	}


	public function getLead_test($condition = array(), $limit = 30, $offset = 0)
	{
		$order_by = ['created_at' => 'DESC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}

		if (isset($condition['sdt'])) {
			$mongo = $mongo->like("phone_number", $condition['sdt']);
			return $mongo->order_by($order_by)
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		}

		if (!empty($condition['fullname'])) {
			$mongo = $mongo->like("fullname", $condition['fullname']);
			return $mongo->order_by($order_by)
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		}

	}


	public function getAllLeadExport($condition = array())
	{

		$conditions = [
			'aggregate' => $this->collection,
			'pipeline' => [
				['$project' =>
					[
						'_id' => ['$toString' => '$_id'],
						'cskh' => 1,
						'created_at' => 1,
						'source' => 1,
						'utm_source' => 1,
						'fullname' => 1,
						'phone_number' => 1,
						'status_sale' => 1,
						'reason_cancel' => 1,
						'id_PDG' => 1,
						'hk_district' => 1,
						'hk_province' => 1,
						'hk_ward' => 1,
						'ns_district' => 1,
						'ns_province' => 1,
						'ns_ward' => 1,
					]
				],
				['$lookup' =>
					[
						'from' => 'contract',
						'localField' => "_id",
						'foreignField' => "customer_infor.id_lead",
						'as' => "contract_info"
					],
				],
				['$project' =>
					[
						'_id' => ['$toString' => '$_id'],
						'cskh' => 1,
						'created_at' => 1,
						'source' => 1,
						'utm_source' => 1,
						'fullname' => 1,
						'phone_number' => 1,
						'status_sale' => 1,
						'reason_cancel' => 1,
						'id_PDG' => 1,
						'hk_district' => 1,
						'hk_province' => 1,
						'hk_ward' => 1,
						'ns_district' => 1,
						'ns_province' => 1,
						'ns_ward' => 1,
						'contract_info.status' => 1,
						'contract_info.loan_infor.amount_loan' => 1

					]
				],
			],
			'cursor' => new stdClass,
		];
		$match = array();
		if (!empty($condition)) {
			if (!empty($condition['start']) && !empty($condition['end'])) {
				$match['$match']['created_at'] = array(
					'$gte' => $condition['start'],
					'$lte' => $condition['end']
				);
			}
			array_push($conditions['pipeline'], $match);
		}
		$command = new MongoDB\Driver\Command($conditions);
		$arr = array();
		try {
			$cursor = $this->manager->executeCommand($this->config->item("current_DB"), $command);
			foreach ($cursor as $item) {
				array_push($arr, $item);
			}
			return $arr;
		} catch (\MongoDB\Driver\Exception\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getListLeadMKTExport($condition = array())
	{
		$conditions = [
			'aggregate' => $this->collection,
			'pipeline' => [
				['$project' =>
					[
						'_id' => ['$toString' => '$_id'],
						'cskh' => 1,
						'created_at' => 1,
						'source' => 1,
						'utm_source' => 1,
						'utm_campaign' => 1,
						'fullname' => 1,
						'phone_number' => 1,
						'status_sale' => 1,
						'status_pgd' => 1,
						'id_PDG' => 1,
						'office_at' => 1,
						'updated_at' => 1
					]
				],
				['$lookup' =>
					[
						'from' => 'contract',
						'localField' => "_id",
						'foreignField' => "customer_infor.id_lead",
						'as' => "contract_info"
					],
				],
			],
			'cursor' => new stdClass,
		];
		$match = array();
		$match['$match']['status_sale'] = array(
			'$in' => array('2', '9')
		);
		if (!empty($condition)) {
			if (!empty($condition['start']) && !empty($condition['end'])) {
				$match['$match']['created_at'] = array(
					'$gte' => $condition['start'],
					'$lte' => $condition['end']
				);
			}
		}
		array_push($conditions['pipeline'], $match);
		$command = new MongoDB\Driver\Command($conditions);
		$arr = array();
		try {
			$cursor = $this->manager->executeCommand($this->config->item("current_DB"), $command);
			foreach ($cursor as $item) {
				array_push($arr, $item);
			}
			return $arr;
		} catch (\MongoDB\Driver\Exception\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getLead_pt_total($condition = array())
	{
		$order_by = ['created_at' => 'DESC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}
		if (isset($condition['sdt'])) {
			$where['phone_number'] = $condition['sdt'];
		}
		if (isset($condition['tab2'])) {
			$where['cskh'] = array('$exists' => false);
		}
		if (isset($condition['tab3'])) {
			// if(in_array('telesales',  $condition['tab3']['groupRoles']))
			// {
			$where['cskh'] = $condition['tab3']['email'];
			// }else{
			//     $where['cskh'] =array('$exists' => true);
			// }
		}
		if (isset($condition['tab4'])) {
			$where['status_sale'] = '1';
		}
		if (isset($condition['area'])) {
			$where['area'] = $condition['area'];
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (isset($condition['tab5'])) {
			$mongo = $mongo->where_in('status_sale', array('2', '9'));
		}
		if (!empty($condition['fullname'])) {
			$mongo = $mongo->like("fullname", $condition['fullname']);
		}

		return $mongo->order_by($order_by)
			->count($this->collection);

	}

	public function find_where_select($condition, $value)
	{
		return $this->mongo_db
			->select($value)
			->get_where($this->collection, $condition);
	}

	public function findOneAndUpdate($where = "", $inforUupdate = "")
	{
		$update = array(
			'$set' => $inforUupdate
		);
		return $this->mongo_db->find_one_and_update($this->collection, $where, $update);
	}

	public function getLeadLogCancel($condition = array())
	{
		$order_by = ['created_at' => 'DESC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}

		if (isset($condition['status'])) {
			$where['status'] = $condition['status'];
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (!empty($condition['reason_cancel'])) {
			$mongo = $mongo->like("reason_cancel", $condition['reason_cancel']);
		}

		return $mongo->order_by($order_by)
			->get($this->collection);
	}


	public function find_date($condition)
	{
		$order_by = ['created_at' => 'DESC'];
		$where = array();

		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}
		if (isset($condition['status'])) {
			$where['status_sale'] = $condition['status_sale'];
		}

		$where['da_tat_toan'] = array('$exists' => false);
		//Điều chỉnh chia Lead thủ công không áp dụng với Lead Phan Nguyễn
		$where['source'] = array('$ne' => 'phan_nguyen');

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo->order_by($order_by)->get($this->collection);
	}

	public function find_date_day($condition)
	{
		$order_by = ['created_at' => 'DESC'];
		$where = array();

		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}

		$where['da_tat_toan'] = array('$exists' => false);

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}


		return $mongo->order_by($order_by)->get($this->collection);
	}

	public function find_date_day_count($condition)
	{
		$order_by = ['created_at' => 'DESC'];
		$where = array();

		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		if (isset($condition['cskh'])) {
			$mongo = $mongo->where_in('cskh', [$condition['cskh']]);
		}

		return $mongo->order_by($order_by)->count($this->collection);
	}


	public function getByRole_pgd_list($condition = array(), $limit = 30, $offset = 0)
	{
		$order_by = ['office_at' => 'DESC'];
//		$order_by = ['updated_at' => 'DESC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['office_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}
		if (isset($condition['status_sale'])) {
			$where['status_sale'] = $condition['status_sale'];
		}
		if (isset($condition['status'])) {
			$where['status'] = $condition['status'];
		}

		if (isset($condition['status_pgd'])) {
			$where['status_pgd'] = $condition['status_pgd'];
		}
		if (isset($condition['cvkd'])) {
			$where['cvkd'] = $condition['cvkd'];
		}
		if (isset($condition['source_pgd'])) {
			$where['source'] = $condition['source_pgd'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if ($condition['is_cvkd'] = 1 && !empty($condition['cvkd'])) {
			$mongo = $mongo->or_where(['created_by' => $condition['cvkd'], 'cvkd' => $condition['cvkd']]);

		}
		if (isset($condition['code_store'])) {
			$mongo = $mongo->where_in('id_PDG', $condition['code_store']);
		}
		if (isset($condition['id_PDG'])) {
			$mongo = $mongo->where_in('id_PDG', $condition['id_PDG']);
		}
		if (!empty($condition['utm_source'])) {
			$mongo = $mongo->like("utm_source", $condition['utm_source']);
		}
		if (!empty($condition['utm_campaign'])) {
			$mongo = $mongo->like("utm_campaign", $condition['utm_campaign']);
		}
		if (!empty($condition['phone_number'])) {
			$mongo = $mongo->like("phone_number", $condition['phone_number']);
		}
		if (isset($condition['total']) && $condition['total']) {
			return $mongo->where_in('status_sale', array('2', '30'))
				->order_by($order_by)
				->count($this->collection);
		} else {
			return $mongo->where_in('status_sale', array('2', '30'))->order_by($order_by)
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		}


	}

	public function getByRole_AT_list($condition)
	{
		$where = array();
		$mongo = $this->mongo_db;

		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo->where_in("utm_source", array("accesstrade", "google"))->get($this->collection);

	}

	public function getAllLeadExcel($condition = array())
	{
		if (!empty($condition['start']) && !empty($condition['end'])) {
			$gte = $condition['start'];
			$lte = $condition['end'];
		}
		$conditions = [
			'aggregate' => $this->collection,
			'pipeline' => [
				['$project' =>
					[
						'_id' => ['$toString' => '$_id'],
						'cskh' => 1,
						'created_at' => 1,
						'source' => 1,
						'utm_source' => 1,
						'utm_campaign' => 1,
						'fullname' => 1,
						'phone_number' => 1,
						'status_sale' => 1,
						'reason_cancel' => 1,
						'id_PDG' => 1,
						'hk_district' => 1,
						'hk_province' => 1,
						'hk_ward' => 1,
						'ns_district' => 1,
						'ns_province' => 1,
						'ns_ward' => 1,
						"tls_note" => 1,
						'type_finance' => 1,
						'position' => 1,
						'identify_lead' => 1,
						'priority' => 1,
					]
				],
				['$lookup' =>
					[
						'from' => 'contract',
						'localField' => "_id",
						'foreignField' => "customer_infor.id_lead",
						'as' => "contract_info"
					],
				],
				['$project' =>
					[
						'_id' => ['$toString' => '$_id'],
						'cskh' => 1,
						'created_at' => 1,
						'source' => 1,
						'utm_source' => 1,
						'utm_campaign' => 1,
						'fullname' => 1,
						'phone_number' => 1,
						'status_sale' => 1,
						'reason_cancel' => 1,
						'id_PDG' => 1,
						'hk_district' => 1,
						'hk_province' => 1,
						'hk_ward' => 1,
						'ns_district' => 1,
						'ns_province' => 1,
						'ns_ward' => 1,
						"tls_note" => 1,
						'type_finance' => 1,
						'position' => 1,
						'identify_lead' => 1,
						'contract_info.status' => 1,
						'contract_info.loan_infor.amount_loan' => 1,
						'priority' => 1,
					]
				],
				['$match' =>
					[
						'created_at' =>
							[
								'$gte' => $gte,
								'$lte' => $lte
							],
						''
					]
				],
				['$sort' =>
					[
						'office_at' => -1
					]
				],
				['$limit' => 3000],
			],
			'cursor' => new stdClass,
		];
		$command = new MongoDB\Driver\Command($conditions);
		$arr = array();
		try {
			$cursor = $this->manager->executeCommand($this->config->item("current_DB"), $command);

			foreach ($cursor as $item) {
				array_push($arr, $item);
			}
			return $arr;
		} catch (\MongoDB\Driver\Exception\Exception $e) {
			return $e->getMessage();
		}
	}

	public function find_one($condition)
	{
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;

		if (isset($condition['list_cskh'])) {
			$mongo = $mongo->where_in('cskh', $condition['list_cskh']);
		}

		return $mongo
			->order_by(array('created_at' => 'DESC'))
			->limit(1)
			->get($this->collection);
	}

	public function get_lead_have_contract($condition = array())
	{
		$conditions = [
			'aggregate' => $this->collection,
			'pipeline' => [
				['$project' =>
					[
						'_id' => ['$toString' => '$_id'],
						'cskh' => 1,
						'created_at' => 1,
						'source' => 1,
						'utm_source' => 1,
						'fullname' => 1,
						'phone_number' => 1,
						'status_sale' => 1,
						'reason_cancel' => 1,
						'id_PDG' => 1,

					]
				],
				['$lookup' =>
					[
						'from' => 'contract',
						'localField' => "_id",
						'foreignField' => "customer_infor.id_lead",
						'as' => "contract"
					],
				],
				['$project' =>
					[
						'_id' => ['$toString' => '$_id'],
						'cskh' => 1,
						'created_at' => 1,
						'source' => 1,
						'utm_source' => 1,
						'fullname' => 1,
						'phone_number' => 1,
						'status_sale' => 1,
						'reason_cancel' => 1,
						'id_PDG' => 1,
						'contract.status' => 1,
						'contract.loan_infor.amount_loan' => 1

					]
				],
			],
			'cursor' => new stdClass,
		];
		$match = array();
		if (!empty($condition)) {
			if (!empty($condition['status_contract'])) {
				$match['$match']['contract.status'] = array(
					'$gte' => 17
				);
			}
			array_push($conditions['pipeline'], $match);
		}
		$command = new MongoDB\Driver\Command($conditions);
		$arr = array();
		try {
			$cursor = $this->manager->executeCommand($this->config->item("current_DB"), $command);
			foreach ($cursor as $item) {
				array_push($arr, $item);
			}
			return $arr;
		} catch (\MongoDB\Driver\Exception\Exception $e) {
			return $e->getMessage();
		}
	}


	public function find_where_count($condition)
	{
		$where = array();
		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['created_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['cskh'] = $condition['cskh'];

		$where['status_sale'] = array('$nin' => ["20", "30"]);

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo->count($this->collection);

	}

	public function find_where_count_phan_bo_ton_cu($condition)
	{
		$where = array();

		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['created_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['cskh'] = $condition['cskh'];
		$where['status_sale'] = array('$in' => ["1", "5", "10", "11", "12", "13", "14", "15", "16", "17", "18"]);
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		return $mongo->count($this->collection);
	}


	public function find_where_count_xu_ly($condition)
	{
		$where = array();

		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['created_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['cskh'] = $condition['cskh'];

		$where['status_sale'] = array('$in' => ["2", "19", "3", "4", "5", "6", "7", "8", "9"]);

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		return $mongo->count($this->collection);
	}

	public function find_where_count_xu_ly_ton_cu($condition)
	{
		$where = array();

		$mongo = $this->mongo_db;


		$where['created_at'] = array(
			'$gte' => strtotime(date('Y-01-01' . ' 00:00:00')),
			'$lte' => strtotime(date('Y-m-d' . ' 23:59:59'))
		);

		$where['cskh'] = $condition['cskh'];

		$where['status_sale'] = array('$in' => ["10","11","12","13","14","15","16", "17", "18",'5']);

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		return $mongo->count($this->collection);

	}


	public function find_where_leadQlf_count($condition)
	{

		$where = array();

		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['office_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['cskh'] = $condition['cskh'];

		$where['status_sale'] = "2";

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		return $mongo->count($this->collection);

	}

	public function get_lead_money($condition)
	{
		$where = array();

		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['office_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}
		$where['cskh'] = $condition['cskh'];
		$where['status_sale'] = "2";

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo
			->select(array("phone_number"))
			->get($this->collection);
	}

	function get_lead_report($condition)
	{

		$where = array();

		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['office_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['cskh'] = $condition['cskh'];

		$where['status_sale'] = "2";

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo
			->select(array("phone_number"))
			->get($this->collection);

	}

	public function find_where_lead_count_pgd($condition)
	{

		$where = array();

		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['office_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['id_PDG'] = $condition['id_PDG'];

		$where['status_sale'] = "2";

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo->count($this->collection);

	}

	public function find_where_lead_pgd($condition)
	{

		$where = array();

		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['office_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['id_PDG'] = $condition['id_PDG'];

		$where['status_sale'] = "2";

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo->get($this->collection);

	}


	public function find_count($condition)
	{

		$where = array();

		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['created_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['cskh'] = array('$exists' => true);

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo->count($this->collection);
	}

	public function find_count_xl($condition)
	{
		$where = array();
		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['created_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['cskh'] = array('$exists' => true);

		$where['status_sale'] = array('$in' => ["2", "3", "4", "5", "6", "7", "8", "9", "19"]);

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo->count($this->collection);
	}

	public function getLeadNotQualifiedTS($condition = array())
	{
		$order_by = ['updated_at' => 'DESC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}
		if (isset($condition["reason_cancel"])) {
			$where['source'] = "TS";
			$where['status_sale'] = "19";
			$where['reason_cancel'] = (string)$condition["reason_cancel"];
		} else {
			$where['source'] = "TS";
			$where['status_sale'] = "19";
			$where['reason_cancel'] = array('$in' => ["5", "7", "8", "9", "10", "12", "13", "15", "34", "41", "50"]);
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo->order_by($order_by)
			->get($this->collection);
	}

	public function getLeadQualifiedTS($condition = array())
	{
		$order_by = ['updated_at' => 'DESC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}
		if (isset($condition["status"]) && isset($condition["reason_cancel"])) {
			$where['source'] = "TS";
			$where['status_sale'] = (string)$condition["status"];
			$where['reason_cancel'] = (string)$condition["reason_cancel"];
		} else if (isset($condition["status"])) {
			$where['source'] = "TS";
			$where['status_sale'] = (string)$condition["status"];
			$where['reason_cancel'] = array('$nin' => ["5", "7", "8", "9", "10", "12", "13", "15", "34", "41", "50"]);
		} else if (isset($condition["reason_cancel"])) {
			$where['source'] = "TS";
			$where['status_sale'] = array('$in' => ["2", "5", "6", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"]);
			$where['reason_cancel'] = (string)$condition["reason_cancel"];
		} else {
			$where['source'] = "TS";
			$where['status_sale'] = array('$in' => ["2", "5", "6", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"]);
			$where['reason_cancel'] = array('$nin' => ["5", "7", "8", "9", "10", "12", "13", "15", "34", "41", "50"]);
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo->order_by($order_by)
			->get($this->collection);
	}

	public function getLeadTS($condition = array(), $limit = 30, $offset = 0)
	{
		$order_by = ['created_at' => 'DESC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}
		if (isset($condition['status_sale'])) {
			$where['status_sale'] = $condition['status_sale'];
		}
		if (isset($condition['area'])) {
			$where['area'] = $condition['area'];
		}
		if (isset($condition['source'])) {
			$where['source'] = $condition['source'];
		}

		if (isset($condition['tab']) && $condition['tab'] == 'list_not_qualified') {
			if (isset($condition["reason_cancel"])) {
				$where['source'] = "TS";
				$where['status_sale'] = "19";
				$where['reason_cancel'] = (string)$condition["reason_cancel"];
			} else {
				$where['source'] = "TS";
				$where['status_sale'] = "19";
				$where['reason_cancel'] = array('$in' => ["5", "7", "8", "9", "10", "12", "13", "15", "34", "41", "50"]);
			}
		} else {
			if (isset($condition["status"]) && isset($condition["reason_cancel"])) {
				$where['source'] = "TS";
				$where['status_sale'] = (string)$condition["status"];
				$where['reason_cancel'] = (string)$condition["reason_cancel"];
			} else if (isset($condition["status"])) {
				$where['source'] = "TS";
				$where['status_sale'] = (string)$condition["status"];
				$where['reason_cancel'] = array('$nin' => ["5", "7", "8", "9", "10", "12", "13", "15", "34", "41", "50"]);
			} else if (isset($condition["reason_cancel"])) {
				$where['source'] = "TS";
				$where['status_sale'] = array('$in' => ["2", "5", "6", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"]);
				$where['reason_cancel'] = (string)$condition["reason_cancel"];
			} else {
				$where['source'] = "TS";
				$where['status_sale'] = array('$in' => ["2", "5", "6", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"]);
				$where['reason_cancel'] = array('$nin' => ["5", "7", "8", "9", "10", "12", "13", "15", "34", "41", "50"]);
			}
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		if (!empty($condition['fullname'])) {
			$mongo = $mongo->like("fullname", $condition['fullname']);
		}
		if (isset($condition['sdt'])) {
			$mongo = $mongo->like("phone_number", $condition['sdt']);
		}

		if (isset($condition['total']) && $condition['total']) {
			return $mongo
				->order_by($order_by)
				->count($this->collection);
		} else {
			return $mongo
				->order_by($order_by)
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		}

	}

	public function getByRole_price_ctv($condition = [], $limit = 30, $offset = 0)
	{

		$order_by = ['created_at' => 'DESC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['date_pay'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['status_web'] = "Thành công";

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		if (!empty($condition['key'])) {
			$mongo = $mongo->like("his_key", $condition['key']);
		}
		if (isset($condition['phone'])) {
			$mongo = $mongo->like("phone_number", $condition['phone']);
		}

		return $mongo
			->order_by($order_by)
			->limit($limit)
			->offset($offset)
			->get($this->collection);


	}

	public function getByRole_count_ctv($condition = [])
	{
		$order_by = ['created_at' => 'DESC'];
		$where = array();
		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['date_pay'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['status_web'] = "Thành công";

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		if (!empty($condition['key'])) {
			$mongo = $mongo->like("his_key", $condition['key']);
		}
		if (isset($condition['phone'])) {
			$mongo = $mongo->like("phone_number", $condition['phone']);
		}

		return $mongo
			->order_by($order_by)
			->count($this->collection);
	}

	public function getAllOrderCtv($condition = array(), $limit = 30, $offset = 0)
	{
		$order_by = ['created_at' => 'DESC'];
		$mongo = $this->mongo_db;
		$where = [];
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end'],
			);
			unset($condition['start']);
			unset($condition['end']);
		}
		if (isset($condition['status'])) {
			$where['status_web'] = $condition['status'];
		}
		if (isset($condition['ctv_phone'])) {
			$where['ctv_phone'] = $condition['ctv_phone'];
		}

		if (isset($condition['lead_phone'])) {
			$where['phone_number'] = $condition['lead_phone'];
		}
		$where['lead_type'] = '1'; //Đơn được tạo từ website Ctv TienNgay
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (!empty($condition['lead_name'])) {
			$mongo = $mongo->like("fullname", $condition['lead_name']);
		}
		if (!empty($condition['ctv_name'])) {
			$mongo = $mongo->like("ctv_name", $condition['ctv_name']);
		}
		if (isset($condition['total'])) {
			return $mongo
				->order_by($order_by)
				->count($this->collection);
		} else {
			return $mongo
				->order_by($order_by)
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		}
	}

	public function find_leadQLF($condition = [])
	{
		$order_by = ['created_at' => 'DESC'];
		$where = array();
		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['created_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		if (isset($condition['utm_source'])) {
			$where['utm_source'] = $condition['utm_source'];
		}

		if (isset($condition['status_sale'])) {
			$where['status_sale'] = trim($condition['status_sale']);
		}


		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo
			->select(['phone_number'])
			->order_by($order_by)
			->get($this->collection);
	}

	public function find_lead_mkt_count($condition = [])
	{

		$order_by = ['created_at' => 'DESC'];
		$where = array();
		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['created_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['utm_source'] = array('$in' => ["accesstrade", "masoffer", "jeff", "Toss", "Dinos", "Crezu", "phan_nguyen"]);

		if (isset($condition['status_sale'])) {
			$where['status_sale'] = $condition['status_sale'];
		}

		if (isset($condition['utm_source'])) {
			$where['utm_source'] = $condition['utm_source'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo
			->order_by($order_by)
			->count($this->collection);

	}

	public function find_lead_mkt($condition = [], $limit = 30, $offset = 0)
	{

		$order_by = ['created_at' => 'DESC'];
		$where = array();
		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['created_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['utm_source'] = array('$in' => ["accesstrade", "masoffer", "jeff", "Toss", "Dinos", "Crezu", "phan_nguyen"]);


		if (isset($condition['status_sale'])) {
			$where['status_sale'] = $condition['status_sale'];
		}

		if (isset($condition['utm_source'])) {
			$where['utm_source'] = $condition['utm_source'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo
			->select(["_id", 'phone_number', "fullname", "status_sale", "created_at", "reason_cancel", "utm_source", 'id_PDG'])
			->limit($limit)
			->offset($offset)
			->order_by($order_by)
			->get($this->collection);
	}

	public function find_lead_mkt_excel($condition)
	{

		$order_by = ['created_at' => 'DESC'];
		$where = array();
		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['created_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}


		$where['utm_source'] = array('$in' => ["accesstrade", "masoffer", "jeff", "Toss", "Dinos", "Crezu", "phan_nguyen"]);


		if (isset($condition['status_sale'])) {
			$where['status_sale'] = $condition['status_sale'];
		}

		if (isset($condition['utm_source'])) {
			$where['utm_source'] = $condition['utm_source'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo
			->select(["_id", 'phone_number', "fullname", "status_sale", "created_at", "reason_cancel", "utm_source", 'id_PDG'])
			->order_by($order_by)
			->get($this->collection);

	}

	public function find_one_check_phone($condition)
	{
		$order_by = ['created_at' => 'DESC'];
		$where = array();
		$mongo = $this->mongo_db;

		if (!empty($condition)) {
			$where['phone_number'] = $condition;
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo
			->order_by($order_by)
			->get($this->collection);
	}

	public function get_thoi_gian_khach_hen($condition)
	{


		$order_by = ['created_at' => 'DESC'];
		$where = array();
		$mongo = $this->mongo_db;

		$where['thoi_gian_khach_hen'] = array(
			'$ne' => false
		);

		$where['status_thoi_gian_khach_hen'] = "1";

		$where['thoi_gian_khach_hen'] = array(
			'$lte' => $condition['cenvertedTime']
		);

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo
			->order_by($order_by)
			->get($this->collection);


	}
	public function update_missed_call($condition, $set)
	{
		return $this->mongo_db->where($condition)->set($set)->update($this->collection);
	}

	public function get_count_lead_time($condition)
	{
		$where = array();
		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			if (isset($condition['update_at'])) {
				$where['updated_at'] = array(
					'$gte' => $condition['fdate'],
					'$lte' => $condition['tdate']
				);
			} elseif (isset($condition['office_at'])) {
				$where['office_at'] = array(
					'$gte' => $condition['fdate'],
					'$lte' => $condition['tdate']
				);
			} else {
				$where['created_at'] = array(
					'$gte' => $condition['fdate'],
					'$lte' => $condition['tdate']
				);
			}

			unset($condition['fdate']);
			unset($condition['tdate']);
		}


		if (isset($condition['status_sale'])) {
			$where['status_sale'] = ['$in' => $condition['status_sale']];
		}

		if (isset($condition['cskh'])) {
			$where['cskh'] = $condition['cskh'];
		}

		if (isset($condition['id_PDG'])) {
			$where['id_PDG'] = $condition['id_PDG'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo
			->count($this->collection);

	}

	public function get_data_lead_time($condition)
	{
		$where = array();
		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			if (isset($condition['update_at'])) {
				$where['updated_at'] = array(
					'$gte' => $condition['fdate'],
					'$lte' => $condition['tdate']
				);
			} elseif (isset($condition['office_at'])) {
				$where['office_at'] = array(
					'$gte' => $condition['fdate'],
					'$lte' => $condition['tdate']
				);
			} else {
				$where['created_at'] = array(
					'$gte' => $condition['fdate'],
					'$lte' => $condition['tdate']
				);
			}

			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		if (isset($condition['status_sale'])) {
			$where['status_sale'] = ['$in' => $condition['status_sale']];
		}

		if (isset($condition['id_PDG'])) {
			$where['id_PDG'] = $condition['id_PDG'];
		}
		if (isset($condition['cskh'])) {
			$where['cskh'] = $condition['cskh'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo
			->select(['phone_number','fullname'])
			->get($this->collection);

	}


	public function getLeadVbee($condition = [], $limit = 30, $offset = 0) {
		$order_by = ['created_at' => 'DESC'];
		$where = [];
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = [
				'$gte' => (int)$condition['start'],
				'$lte' => (int)$condition['end'],
			];
		} elseif (isset($condition['start'])) {
			$where['created_at'] = [
				'$gte' => (int)$condition['start'],
			];
		} elseif (isset($condition['end'])) {
			$where['created_at'] = [
				'$lte' => (int)$condition['end'],
			];
		}
		if (!empty($condition['source'])) {
			$where['source'] =  $condition['source'];
		} else {
			$where['source'] = ['$in' => $condition['source_active']];
		}
		if (!empty($condition['status_sale'])) {
			$where['status_sale'] = $condition['status_sale'];
		}
		if (!empty($condition['cskh'])) {
			$where['cskh'] = $condition['cskh'];
		}
		if (!empty($condition['priority'])) {
			if ($condition['priority'] != "1") {
				$where['priority'] = $condition['priority'];
			}
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (!empty($condition['fullname'])) {
			$mongo = $mongo->like('fullname', $condition['fullname']);
		}
		if (!empty($condition['sdt'])) {
			$mongo = $mongo->like('phone_number', $condition['sdt']);
		}
		if (isset($condition['total'])) {
			return $mongo
				->order_by($order_by)
				->count($this->collection);
		} else {
			return $this->mongo_db
			    ->order_by($order_by)
				->limit($limit)
				->offset($offset)
				->get($this->collection);
		}
	}

	public function report_inhouse_count($condition){
		$where = array();
		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['office_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['status_sale'] = "2";

		if (isset($condition['store_search'])) {
			$where['id_PDG'] = $condition['store_search'];
		}
		if (isset($condition['status_pgd'])) {
			$where['status_pgd'] = $condition['status_pgd'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo->count($this->collection);
	}

	public function report_inhouse($condition, $limit, $offset){

		$where = array();
		$mongo = $this->mongo_db;
		$order_by = ['office_at' => 'DESC'];

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['office_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['status_sale'] = "2";

		if (isset($condition['store_search'])) {
			$where['id_PDG'] = $condition['store_search'];
		}
		if (isset($condition['status_pgd'])) {
			$where['status_pgd'] = $condition['status_pgd'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo
			->order_by($order_by)
			->select(['created_at','cvkd','fullname','phone_number','id_PDG','status_pgd','source','utm_source','utm_campaign','position','identify_lead','office_at','reason_process'])
			->limit($limit)
			->offset($offset)
			->get($this->collection);
	}

	public function exportLeadVbee($condition = []) {
		$order_by = ['created_at' => 'DESC'];
		$where = [];
		$in = [];
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = [
				'$gte' => (int)$condition['start'],
				'$lte' => (int)$condition['end'],
			];
		} elseif (isset($condition['start'])) {
			$where['created_at'] = [
				'$gte' => (int)$condition['start'],
			];
		} elseif (isset($condition['end'])) {
			$where['created_at'] = [
				'$lte' => (int)$condition['end'],
			];
		}
		if (!empty($condition['source'])) {
			$where['source'] =  $condition['source'];
		} else {
			$where['source'] = ['$in' => $condition['source_active']];
		}
		if (!empty($condition['status_sale'])) {
			$where['status_sale'] = $condition['status_sale'];
		}
		if (!empty($condition['cskh'])) {
			$where['cskh'] = $condition['cskh'];
		}
		if (!empty($condition['priority'])) {
			$where['priority'] = $condition['priority'];
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (!empty($condition['fullname'])) {
			$mongo = $mongo->like('fullname', $condition['fullname']);
		}
		if (!empty($condition['sdt'])) {
			$mongo = $mongo->like('phone_number', $condition['sdt']);
		}
		return $mongo->order_by($order_by)
		->select(['fullname','source','priority','phone_number','status_sale','cskh'])
		->get($this->collection);
	}

	public function report_inhouse_export($condition){
		$where = array();
		$mongo = $this->mongo_db;
		$order_by = ['office_at' => 'DESC'];

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['office_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['status_sale'] = "2";

		if (isset($condition['store_search'])) {
			$where['id_PDG'] = $condition['store_search'];
		}
		if (isset($condition['status_pgd'])) {
			$where['status_pgd'] = $condition['status_pgd'];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo
			->order_by($order_by)
			->select(['cvkd','fullname','phone_number','id_PDG','status_pgd','office_at','reason_process'])
			->get($this->collection);
	}

	public function exportLeadPGDCancel($condition) {
		$order_by = ['created_at' => 'DESC'];
		$where = [];
		$in = [];
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = [
				'$gte' => (int)$condition['start'],
				'$lte' => (int)$condition['end'],
			];
		} elseif (isset($condition['start'])) {
			$where['created_at'] = [
				'$gte' => (int)$condition['start'],
			];
		} elseif (isset($condition['end'])) {
			$where['created_at'] = [
				'$lte' => (int)$condition['end'],
			];
		}
		if (!empty($condition['source'])) {
			$where['source'] =  $condition['source'];
		}
		if (!empty($condition['status_sale'])) {
			$where['status_sale'] = $condition['status_sale'];
		}
		if (!empty($condition['cskh'])) {
			$where['cskh'] = $condition['cskh'];
		}
		if (!empty($condition['priority'])) {
			$where['priority'] = $condition['priority'];
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (!empty($condition['fullname'])) {
			$mongo = $mongo->like('fullname', $condition['fullname']);
		}
		if (!empty($condition['sdt'])) {
			$mongo = $mongo->like('phone_number', $condition['sdt']);
		}
		return $mongo->order_by($order_by)
		->where('status_pgd', '16')
		->get($this->collection);
	}

	public function exportLeadPGDReturn($condition) {
		$order_by = ['created_at' => 'DESC'];
		$where = [];
		$in = [];
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = [
				'$gte' => (int)$condition['start'],
				'$lte' => (int)$condition['end'],
			];
		} elseif (isset($condition['start'])) {
			$where['created_at'] = [
				'$gte' => (int)$condition['start'],
			];
		} elseif (isset($condition['end'])) {
			$where['created_at'] = [
				'$lte' => (int)$condition['end'],
			];
		}
		if (!empty($condition['source'])) {
			$where['source'] =  $condition['source'];
		}
		if (!empty($condition['status_sale'])) {
			$where['status_sale'] = $condition['status_sale'];
		}
		if (!empty($condition['cskh'])) {
			$where['cskh'] = $condition['cskh'];
		}
		if (!empty($condition['priority'])) {
			$where['priority'] = $condition['priority'];
		}
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (!empty($condition['fullname'])) {
			$mongo = $mongo->like('fullname', $condition['fullname']);
		}
		if (!empty($condition['sdt'])) {
			$mongo = $mongo->like('phone_number', $condition['sdt']);
		}
		return $mongo->order_by($order_by)
		->where('status_pgd', '8')
		->get($this->collection);
	}

	public function findAggregate($operation)
	{
		return $this->mongo_db
			->aggregate($this->collection, $operation)->toArray();
	}

	public function get_all_lead_success()
	{
		$mongo = $this->mongo_db;
		$order_by = ['created_at' => 'ASC'];
		$where = array();
		$where['status_web'] = "Thành công";
		$where['tien_hoa_hong'] = array('$gt' => 0);
		$where['payment_status'] = array('$nin' => array(1, 2)); //Chưa thanh toán tiền hoa hồng cho CTV
		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		return $mongo
			->order_by($order_by)
			->select(array('ctv_code'))
			->get($this->collection);
	}

	public function get_all_lead_group_by($condition = array())
	{
		$ops = array(
			array(
				'$match' => array(
					'ctv_code' => $condition['ctv_code'],
					'status_web' => "Thành công",
					'tien_hoa_hong' => array('$gt' => 0),
					'payment_status' => array('$nin' => array(1, 2)) //Chưa thanh toán tiền hoa hồng cho CTV
				)
			),
			array(
				'$group' => array(
					'_id' => $condition['ctv_code'],
					'total' => array('$sum' => '$tien_hoa_hong')
				)
			)
		);
		$data = $this->findAggregate($ops);
		return $data[0];
	}

	public function find_condition($condition){

		$where = array();
		$mongo = $this->mongo_db;

		if (!empty($condition['flag_lead']) && $condition['flag_lead'] == "1"){
			if (isset($condition['fdate']) && isset($condition['tdate'])) {
				$where['created_at'] = array(
					'$gte' => $condition['fdate'],
					'$lte' => $condition['tdate']
				);
				unset($condition['fdate']);
				unset($condition['tdate']);
			}
		} elseif (!empty($condition['get_data']) && $condition['get_data'] == 'get') {
			if (isset($condition['fdate']) && isset($condition['tdate'])) {
				$where['office_at'] = array(
					'$gte' => strtotime('-3 month', $condition['fdate']),
					'$lte' => $condition['tdate']
				);
				unset($condition['fdate']);
				unset($condition['tdate']);
			}
		} else {
			if (isset($condition['fdate']) && isset($condition['tdate'])) {
				$where['office_at'] = array(
					'$gte' => $condition['fdate'],
					'$lte' => $condition['tdate']
				);
				unset($condition['fdate']);
				unset($condition['tdate']);
			}
		}


		if (!empty($condition['status_sale'])) {
			$where['status_sale'] = $condition['status_sale'];
		}

		if (!empty($condition['id_PDG'])) {
			$where['id_PDG'] = $condition['id_PDG'];
		}

		if (!empty($condition['source']) && $condition['source'] == "google") {
			$where['utm_source'] = ['$in' => ['Google', 'GS','DONG.GG']];
		}

		if (!empty($condition['source']) && $condition['source'] == "tiktok") {
			$where['utm_source'] = "tiktok";
		}

		if (!empty($condition['store'])) {
			$where['id_PDG'] = ['$in' => $condition['store']];
		}

		if (!empty($condition['source']) && $condition['source'] == "khac") {
			$where['utm_source'] = ['$nin' => ['Google', 'GS','DONG.GG',"tiktok","FB OanhNT","masoffer", "Dinos","accesstrade","jeff","tiktok","GS","phan_nguyen"]];
			$where['source'] = ['$nin' => ['6']];
		}

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		if (!empty($condition['source']) && $condition['source'] == "facebook") {
			$mongo = $mongo->or_where([
				'utm_source' => ['$in' => ["FB OanhNT"]],
				'source' => "6",
			]);
		}


		if (!empty($condition['get_data']) && $condition['get_data'] == "get"){
			return $mongo
				->select(['phone_number'])
				->get($this->collection);
		} else {
			return $mongo
				->count($this->collection);
		}

	}

	public function check_phone_exists($phone) {
		$mongo = $this->mongo_db;
		if(!empty($phone)){
			$mongo = $mongo->where(["phone_number" => $phone, "priority" => ['$in' => ['1', '2', '3']]]);
		} else {
			return [];
		}
		return $mongo->get($this->collection);
	}

	public function find_where_count_phan_nguyen($condition){
		$where = array();
		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['created_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['cskh'] = $condition['cskh'];

		$where['source'] = "phan_nguyen";

		$where['status_sale'] = array('$nin' => ["20", "30"]);

		$where['priority'] = ['$nin' => ["1"]];

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}

		return $mongo->count($this->collection);
	}

	public function find_where_count_xu_ly_phan_nguyen($condition)
	{
		$where = array();

		$mongo = $this->mongo_db;

		if (isset($condition['fdate']) && isset($condition['tdate'])) {
			$where['created_at'] = array(
				'$gte' => $condition['fdate'],
				'$lte' => $condition['tdate']
			);
			unset($condition['fdate']);
			unset($condition['tdate']);
		}

		$where['cskh'] = $condition['cskh'];

		$where['source'] = "phan_nguyen";

		$where['priority'] = ['$nin' => ["1"]];

		$where['status_sale'] = array('$in' => ["2", "19", "3", "4", "5", "6", "7", "8", "9"]);

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		return $mongo->count($this->collection);
	}

	public function find_where_count_xu_ly_ton_cu_phan_nguyen($condition){

		$where = array();

		$mongo = $this->mongo_db;

		$where['created_at'] = array(
			'$gte' => strtotime(date('Y-01-01' . ' 00:00:00')),
			'$lte' => strtotime(date('Y-m-d' . ' 23:59:59'))
		);

		$where['cskh'] = $condition['cskh'];

		$where['source'] = "phan_nguyen";

		$where['priority'] = ['$nin' => ["1"]];

		$where['status_sale'] = array('$in' => ["10","11","12","13","14","15","16", "17", "18",'5']);

		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		return $mongo->count($this->collection);

	}


	public function getLead_pt_excel_new($condition = array())
	{
		$order_by = ["priority_level" => "ASC", "created_at" => "DESC", 'source' => 'ASC'];
		$where = array();
		$in = array();
		$mongo = $this->mongo_db;
		if (isset($condition['start']) && isset($condition['end'])) {
			$where['created_at'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
			unset($condition['start']);
			unset($condition['end']);
		}
		if (isset($condition['start'])) {
			$where['created_at'] = [
				'$gte' => $condition['start'],
			];
			unset($condition['start']);
		}
		if (isset($condition['end'])) {
			$where['created_at'] = [
				'$lte' => $condition['end'],
			];
			unset($condition['start']);
		}
//		if (isset($condition['status_sale'])) {
//			$where['status_sale'] = $condition['status_sale'];
//		}
		if (isset($condition['area'])) {
			$where['area'] = $condition['area'];
		}
		if (isset($condition['source'])) {
			$where['source'] = $condition['source'];
		}
		if (isset($condition['cskh']) && !isset($condition['tab13'])) {
			$where['cskh'] = $condition['cskh'];
		}
		if (isset($condition['tab13'])) {
			$where['da_tat_toan'] = 'yes';
			if (isset($condition['cskh'])) {
				$where['cskh_taivay'] = $condition['cskh'];
			}
			if (in_array('telesales', $condition['tab13']['groupRoles']) && !in_array('tbp-cskh', $condition['tab13']['groupRoles'])) {

				$where['cskh_taivay'] = $condition['tab13']['email'];
			}

		}

		if (isset($condition['tab2'])) {
			$where['cskh'] = array('$exists' => false);
			$mongo= $mongo->where_in('priority',array('1','2','3'));
			$mongo = $mongo->where_in('status_sale', array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19'));
		}

		if (isset($condition['tab3'])) {
			if (in_array('telesales', $condition['tab3']['groupRoles']) && !in_array('tbp-cskh', $condition['tab3']['groupRoles']))
			{
				$where['cskh'] = $condition['tab3']['email'];
			}
		}
		if (isset($condition['tab6'])) {
			if (in_array('telesales', $condition['tab6']['groupRoles']) && !in_array('tbp-cskh', $condition['tab6']['groupRoles'])){
				$where['cskh'] = $condition['tab6']['email'];
			}
		}
		if (isset($condition['tab4'])) {
			if (!empty($condition['priority'])) {
				$mongo = $mongo->where_in('status_sale', array('1'));
				$mongo = $mongo->where_in("priority", [(string)$condition['priority']]);
			} else {
				$mongo = $mongo->where_in('status_sale', array('1'));
			}
		}
		if (isset($condition['tab14'])) {
//			$where['cskh'] = $condition['tab14']['email'];
		}


		if (!empty($where)) {
			$mongo = $mongo->set_where($where);
		}
		if (isset($condition['tab5'])) {
			$mongo = $mongo->where_in('status_sale', array('2'));
		}

		/**
		 * Get data
		 * @param array $condition = [];
		 * @param array $condition['source'], $condition['priority]
		 * @return array $mongo
		 */
		if (empty($condition['tab15']) && !empty($condition['source_active']) && empty($condition['tab11']) && empty($condition['tab10'])) {
			if(!empty($condition['source']) && !empty($condition['priority'])) {
				if((in_array($condition['source'], $condition['source_active']) || $condition['source'] == 'phan_nguyen') && $condition['priority'] == "1") {
					$mongo = $mongo->where_in('status_sale', array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19','20'));
					$mongo = $mongo->where('priority', '1');
				} elseif((in_array($condition['source'], $condition['source_active']) || $condition['source'] == 'phan_nguyen') && $condition['priority'] != "1") {
					//return về rỗng
					$mongo = $mongo->where_in('status_sale', array('0'));
				} elseif (!in_array($condition['source'], $condition['source_active']) || $condition['source'] != 'phan_nguyen') {
					$mongo = $mongo->where_in('status_sale', array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19','20'));
					$mongo = $mongo->where_in("priority", [(string)$condition['priority']]);
				}
			} elseif(!empty($condition['source'])) {
				if (in_array($condition['source'], $condition['source_active']) || $condition['source'] == 'phan_nguyen') {
					$mongo = $mongo->where('priority', '1');
				} else {
					$mongo = $mongo->where_in('status_sale', array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19','20'));
					$mongo = $mongo->where_in("priority", ['1','2','3']);
				}
			} elseif(!empty($condition['priority'])) {
				if ($condition['priority'] == "1") {
					$mongo = $mongo->where_in("priority", [(string)$condition['priority']]);
					$mongo = $mongo->where_in('status_sale', array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19','20'));
				} else {
					$mongo = $mongo->where_in("priority", [(string)$condition['priority']]);
					$mongo = $mongo->where(["source" => ['$nin' => $condition['source_active']]]);
					$mongo = $mongo->where(["source" => ['$ne' => 'phan_nguyen']]);
					$mongo = $mongo->where_in('status_sale', array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19','20'));
				}
			} else {
				$mongo = $mongo->where(['$or' => [
					['source' => ['$in' => $condition['source_active']], 'priority' => "1"],
					['source' => ['$nin' => $condition['source_active']]]
				]]);
			}
		}

		if (isset($condition['tab2'])) {
			if (!empty($condition['priority'])) {
				$mongo = $mongo->where_in('status_sale', array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19'));
				$mongo = $mongo->where_in("priority", [(string)$condition['priority']]);
			} else {
				$mongo = $mongo->where_in('status_sale', array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19'));
			}
		}


		if (isset($condition['tab6'])) {
			$mongo = $mongo->where_in('status_sale', array('5', '10', '11', '12', '13', '14', '15', '16', '17', '18'));
		}
		if (isset($condition['tab11'])) {
			$mongo = $mongo->where_in('status_pgd', ['16']);
		}

		if (isset($condition['tab14'])) {
			$mongo = $mongo->where_in('is_topup', ['1']);
		}
		if (isset($condition['tab10'])) {
			$mongo = $mongo->where_in('status_pgd', ['8']);
		}
		if (!empty($condition['email_cskh'])) {
			$mongo = $mongo->where_in('cskh', [$condition['email_cskh']]);
		}
		if (!empty($condition['fullname'])) {
			$mongo = $mongo->like("fullname", $condition['fullname']);
		}
		if (isset($condition['sdt'])) {
			$mongo = $mongo->like("phone_number", $condition['sdt']);
		}
		if (isset($condition['status_sale'])) {
			$mongo = $mongo->where_in("status_sale", [(string)$condition['status_sale']]);
		}


		return $mongo
			->order_by($order_by)
			->get($this->collection);



	}


}

