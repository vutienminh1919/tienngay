

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Store_model extends CI_Model
{
    private $collection = 'store';

    public function  __construct()
    {
        parent::__construct();
    }
    
    public function find(){
        return $this->mongo_db
            ->order_by(array('created_at' => 'DESC'))
            ->get($this->collection);
    }

    public function getCountStore($inputs = array()){
        $mongo = $this->mongo_db;
        if(isset($inputs['count']) && $inputs['count']) {
            $where = [];
            if(isset($inputs['user_id'])) {
                $where['user_id'] = $inputs['user_id'];
            }
            if(isset($inputs['type'])) {
                $where['type'] = $inputs['type'];
            }
            $mongo = $mongo->set_where($where);
            return $mongo->count($this->collection);
        }
    }
    public function getStore($where = array()){
        $mongo = $this->mongo_db;
        $order_by = ['created_at' => 'DESC'];
        if(isset($where['start']) && isset($where['end'])){
            $where['create_at'] = array(
                '$gte' => $where['start'],
                '$lte' => $where['end']
            );
            unset($where['start']);
            unset($where['end']);
            unset($where['count']);
        }
        
        $mongo = $mongo->set_where($where);
        // if(!empty($searchLike)){
        //     foreach($searchLike as $key => $value){
        //         $mongo = $mongo->like($key,$value);

        //     }
        // }
        return $mongo->order_by($order_by)->offset($offset)->limit($limit)->get($this->collection);
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
    
}


