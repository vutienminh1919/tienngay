<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu_model extends CI_Model
{

    private $collection = 'menu';

    public function  __construct()
    {
        parent::__construct();
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
    public function find_where($condition){
        return $this->mongo_db
            ->get_where($this->collection, $condition);
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
    
    public function get_menu($token,$language) {
        $api = new Api();
        $menus = $api->apiPost($token, "menu/get_menu", array("status" => "active", 'language' =>  $language));
        return $menus->data;
    }
	public function get_url_menu_by_user($token, $menuIds) {
		$api = new Api();
		$where = array(
			'status' => 'active'
		);
		$post = array(
                    'where' => array(
                        'status' => 'active'
                    ),
                    'fields' => '_id',
                    'in' => $menuIds
		);
                
                
                
		$roles = $api->apiPost($token, "menu/find_where_in", $post);
		$array = [];
		if (isset($roles->data)) {
			foreach ($roles->data as $menu) {
				$url_array = explode('/', $menu->url);
				$url = strtolower($url_array[0]);
				if (empty($url_array[0])) {
					if (!empty($url_array[1])) {
						$url = strtolower($url_array[1]);
					}
				}
				$array[] = $url;
			}
		}
		return $array;
	}
}
