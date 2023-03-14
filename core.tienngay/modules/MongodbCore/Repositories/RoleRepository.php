<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Entities\Role;
use Modules\MongodbCore\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Repositories\UserCpanelRepository;
use Modules\MongodbCore\Repositories\StoreRepository;

class RoleRepository implements RoleRepositoryInterface
{

    /**
     * @var Model
     */
    protected $roleModel;
    protected $userModel;
    protected $storeRepo;

    /**
     * RoleRepository constructor.
     *
     * @param Role $role
     */
    public function __construct(
        Role $role,
        UserCpanelRepository $userCpanelRepository,
        StoreRepository $storeRepository
    ){
        $this->roleModel = $role;
        $this->userModel = $userCpanelRepository;
        $this->storeRepo = $storeRepository;
    }
    /**
     * Check the store is TCVDB or TCV.
     *
     * @param string $storeId
     * @return boolean
     */
    public function isTCVDB($storeId){
        $result = $this->roleModel::where(Role::SLUG, 'cong-ty-cpcn-tcv-dong-bac')
            ->where(Role::STATUS, Role::ACTIVE)
            ->where("stores." . $storeId, 'exists', true)
            ->first();
        if ($result) {
            return true;
        }
        return false;
    }

//lấy hết nhân viên là tbp kiểm soát nội bộ
    public function getEmailKsnb()
    {
        $user = [];
        $result = $this->roleModel::where(Role::SLUG, 'ksnb')
            ->where(Role::STATUS, ROLE::ACTIVE)
            ->first();
        if ($result) {
            $role = $result["users"];
            foreach ($role as $array => $arr) {
                foreach ($arr as $key => $value) {
                    foreach ($value as $k => $v) {
                        $user[] = $v;
                    }
                }
            }
        }
        return $user;
    }

    ///////////////////////////////

    public function getEmailGroupNvkd($storeId)
    {
        $user = [];
        $result = $this->roleModel
            ->where(Role::ID , $storeId)
            ->first();
        if ($result) {
            $users = $result["users"];
            foreach ($users as $array => $arr) {
                foreach ($arr as $key => $value) {
                    foreach ($value as $k => $v) {
                      if ($this->userModel->getUserActive($v)){
                       $user[] = $v;
                      }
                    }
                }
            }
        }
        return $user;
    }
    /////////////////////////////////

    public function getMailByRole($id)
    {
        $user = [];
        $result = $this->roleModel->where(Role::ID, $id)
            ->where(Role::STATUS, Role::ACTIVE)
            ->first();
        if (!empty($result['users'])) {
            $idTeleSale = config('mongodbcore.roleIdTeleSale');
            if ($result->_id !== $idTeleSale) {
                foreach ($result['users'] as $v1) {
                    $employeeEmail = reset($v1)['email'];
                    if ($employeeEmail == 'ngochtm@tienngay.vn') {
                        continue;
                    }
                    if ($this->userModel->getUserActive($employeeEmail)){
                         $user[] = $employeeEmail;
                    }
                }
            } else {
                foreach ($result['users'] as $v1) {
                    $employeeEmail = reset($v1)['email'];
                    if ($this->userModel->getUserActive($employeeEmail)){
                         $user[] = $employeeEmail;
                    }
                }
            }
        }
        return $user;
    }

    ///////////////////////////////

    public function getAllRoom()
    {
        $whiteList = config('mongodbcore.roomWhiteList');
        $room = [];
        $allPgd = $this->storeRepo->getActiveList();
        $activePgds = array_column($allPgd->toArray(), '_id');
        if (!$whiteList) {
            $whiteList = [];
        }
        $pgds = $this->roleModel->where(Role::STATUS, Role::ACTIVE)
        ->where(Role::STORES, 'size', 1)
        ->where(function($query) {
            return $query->where(Role::SLUG, 'like', '%pgd%')
                    ->orWhere(Role::NAME, 'like', '%pgd%');
        })->get([Role::NAME, Role::STORES]);
        foreach ($pgds->toArray() as $key => $value) {
            $idStore = key(reset($value[Role::STORES]));
            if (in_array($idStore, $activePgds)) {
                $room [] = [
                    'id' => $value[Role::ID],
                    'name' => $value[Role::NAME]
                ];
            }
        }
        if (!empty($whiteList)) {
            $otherRooms = $this->roleModel->where(Role::STATUS, Role::ACTIVE)
                ->whereIn(Role::ID, $whiteList)->get([Role::NAME, Role::STORES]);
            foreach ($otherRooms->toArray() as $key => $value) {
                $room [] = [
                    'id' => $value[Role::ID],
                    'name' => $value[Role::NAME]
                ];
            }

        }
        return $room;
    }

    //////////////////////////////

    public function getByEmailCaptionHo()
    {
        $user = [];
        $result = $this->roleModel->where(Role::SLUG, 'truong-phong-ho')
            ->where(Role::STATUS,Role::ACTIVE)->get(['users']);

        if ($result){
            foreach ($result as $array => $arr){
                foreach ($arr['users'] as $k =>$v){
                  $user[] = reset($v)['email'];
                }
            }
        }
        return $user;
    }

    ////////////////////////////

    public function isTPHO($id)
    {
        $isTPHO = false;
        if ($id) {
            $result = $this->roleModel->where(Role::SLUG, 'truong-phong-ho')
            ->where(Role::USERS . '.' . $id, '$exists', true)->first();
            if (isset($result->_id)) {
                $isTPHO = true;
            }
        }
        return $isTPHO;
    }

    public function isASM($id)
    {
        $isASM = false;
        if ($id) {
            $result = $this->roleModel->where(Role::SLUG, 'asm')
            ->where(Role::USERS . '.' . $id, '$exists', true)->first();
            if (isset($result->_id)) {
                $isASM = true;
            }
        }

        return $isASM;

    }

    public function isCHT($id)
    {
        $isCHT = false;
        if (!empty($id)) {
            $result = $this->roleModel->where(Role::SLUG, 'cua-hang-truong')
            ->where(Role::USERS . '.' . $id, '$exists', true)->first();
            if (isset($result->_id)) {
                $isCHT = true;
            }
        }

        return $isCHT;
    }

    public function getStoreName($storeId) {
        $result = $this->roleModel->where(Role::ID, $storeId)->first();
        if (isset($result[Role::NAME])) {
            return $result[Role::NAME];
        }
        return '';
    }

    public function checkPosition($id)
    {
        if ($this->isTPHO($id)) {
            return "Trưởng bộ phận";
        } else if ($this->isASM($id)) {
            return "Quản lý khu vực";
        } else if ($this->isCHT($id)) {
            return "Cửa hàng trưởng";
        } else {
            return "Nhân viên";
        }
    }


    /**
     * get all email hcns.
     * @param
     * @return Collection
     */
    public function getAllHcns() {
        $allUser = $this->roleModel->where(Role::STATUS, Role::ACTIVE)
        ->where(function($q) {
            return $q->where(Role::SLUG, 'like', '%hcns%')
                    ->orWhere(Role::NAME, 'like', '%HCNS%');
        })->get([ROLE::USERS]);
        $arrEmail = [];
        foreach ($allUser as $key => $value) {
            if (!empty($value['users'])) {
                foreach ($value['users'] as $k => $item) {
                    foreach ($item as $i) {
                        array_push($arrEmail, $i['email']);
                    }
                }
            }
        }
        $getEmail = array_unique($arrEmail);
        return $getEmail;
    }

    public function getStoreByUserId($id)
    {
        $room = [];
        $pgds = $this->roleModel->where(Role::STATUS, Role::ACTIVE)
        ->where(Role::STORES, 'size', 1)
        ->where('users.' . $id, '$exists', true)
        ->where(function($query) {
            return $query->where(Role::SLUG, 'like', '%pgd%')
                    ->orWhere(Role::NAME, 'like', '%pgd%');
        })->get([Role::NAME, Role::STORES]);
        foreach ($pgds->toArray() as $pgd) {
            foreach ($pgd[Role::STORES] as $store) {
                foreach ($store as $key => $value) {
                    $room [] = [
                        'id' => $key,
                        'name' => $value[Role::NAME]
                    ];
                }
            }
        }
        if (empty($room)) {
            $room [] = [
                'id' => '611f4cbd5324a72ed500df52',
                'name' => 'Bảo hiểm PTI'
            ];
        }
        return $room;

    }

    public function getQuanLy_TBP() {
        $result = [];
        $emails = $this->roleModel->where(Role::STATUS, ROLE::ACTIVE)
        ->where(Role::SLUG, 'quan-ly-va-truong-bo-phan')
        ->get(['users']);
        if ($emails) {
            foreach ($emails[0]['users'] as $key => $item) {
                foreach ($item as $k => $i) {
                    foreach ($i as $e) {
                        $result[] = $e;
                    }
                }
            }
        }
        return $result ;
    }

    public function getAllRoomHO()
    {
        $whiteList = config('mongodbcore.roomWhiteList');
        $room = [];
        $allPgd = $this->storeRepo->getActiveList();
        $activePgds = array_column($allPgd->toArray(), '_id');
        if (!$whiteList) {
            $whiteList = [];
        }
        $pgds = $this->roleModel->where(Role::STATUS, Role::ACTIVE)
        ->where(Role::STORES, 'size', 1)
        ->where(function($query) {
            return $query->where(Role::SLUG, 'not regexp', '%pgd%')
                    ->orWhere(Role::NAME, 'not regexp', '%pgd%');
        })->get([Role::NAME, Role::STORES]);
        foreach ($pgds->toArray() as $key => $value) {
            $idStore = key(reset($value[Role::STORES]));
            if (in_array($idStore, $activePgds)) {
                $room [] = [
                    'id' => $value[Role::ID],
                    'name' => $value[Role::NAME]
                ];
            }
        }
        if (!empty($whiteList)) {
            $otherRooms = $this->roleModel->where(Role::STATUS, Role::ACTIVE)
                ->whereIn(Role::ID, $whiteList)->get([Role::NAME, Role::STORES]);
            foreach ($otherRooms->toArray() as $key => $value) {
                $room [] = [
                    'id' => $value[Role::ID],
                    'name' => $value[Role::NAME]
                ];
            }

        }
        return $room;
    }

    public function getNameById($id) {
        $name = $this->roleModel->where(Role::ID, $id)
        ->get([Role::NAME]);
        return $name;
    }

    public function getUserMkt() {
        $listUser = $this->roleModel->where(Role::STATUS, 'active')
        ->where(Role::SLUG, 'marketing')
        ->get([Role::USERS]);
        $arrEmail = [];
        foreach ($listUser as $key => $value) {
            if (!empty($value['users'])) {
                foreach ($value['users'] as $k => $item) {
                    foreach ($item as $i) {
                        array_push($arrEmail, $i['email']);
                    }
                }
            }
        }
        $getEmail = array_unique($arrEmail);
        return $getEmail;
    }


    /**
     * Get store list
     * @param $userId string (loged-in user's id)
     * @param $all boolean (true if want to get all store)
     * @return array
     * */
    public function getStoreList($userId, $all = false)
    {
        $room = [];
        $pgds = $this->roleModel->where(Role::STATUS, Role::ACTIVE);
        if (!$all) {
            $pgds = $pgds->where('users.' . $userId, '$exists', true);
        }
        $pgds = $pgds->where(function($query) {
            return $query->where(Role::SLUG, 'like', '%pgd%')
                    ->orWhere(Role::NAME, 'like', '%pgd%')
                    ->orWhere(Role::SLUG, 'like', '%asm%')
                    ->orWhere(Role::NAME, 'like', '%asm%')
                    ->orWhere(Role::SLUG, 'like', '%rsm%')
                    ->orWhere(Role::NAME, 'like', '%rsm%');
        })->get([Role::NAME, Role::STORES]);
        foreach ($pgds->toArray() as $pgd) {
            if (!is_array($pgd[Role::STORES]) || count($pgd[Role::STORES]) < 1) continue;
            foreach ($pgd[Role::STORES] as $store) {
                if (!is_array($store) || count($store) < 1) continue;
                foreach ($store as $key => $value) {
                    $room [] = [
                        '_id' => $key,
                        'name' => $value[Role::NAME]
                    ];
                }
                
            }
        }
        return $room;
    }

    //lấy user nhân viên phát triển mặt bằng
    public function findOneNvPTMB()
    {
        $result_ptmb = $this->roleModel->where(Role::STATUS,'active')
        ->where(Role::SLUG, 'phat-trien-mat-bang')
         ->get([Role::USERS]);
         $arrEmail = [];
          foreach ($result_ptmb as $key => $value) {
               if (!empty($value['users'])) {
                     foreach ($value['users'] as $k => $item) {
                        foreach ($item as $i) {
                            array_push($arrEmail, $i['email']);
                        }
                     }
               }
          }
          $user_ptmb = array_unique($arrEmail);
          return $user_ptmb;
    }

    /**
     * lấy email user kế toán
     * @param
     * @return array
     * */
    public function getEmailKeToan() {
        $result = $this->roleModel->where(ROLE::STATUS,'active')
        ->where(Role::SLUG, 'ke-toan')
        ->get([Role::USERS]);
        $arrEmail = [];
        if ($result) {
            foreach ($result as $key => $value) {
                if (!empty($value['users'])) {
                      foreach ($value['users'] as $k => $item) {
                         foreach ($item as $i) {
                             array_push($arrEmail, $i['email']);
                         }
                      }
                }
           }
           $userKT = array_unique($arrEmail);
           return $userKT;
        }
        return [];
    }

    /**
     * Get area
     * @param $userId string (loged-in user's id)
     * @return array
     * */
    public function getAreaByUserId($userId)
    {
        // dd($userId);
        $room = [];
        $pgds = $this->roleModel->where(Role::STATUS, Role::ACTIVE)
        ->where(Role::SLUG, 'like', '%asm%')
        ->where('users.' . $userId, '$exists', true)
        ->get([Role::STORES]);
        if ($pgds) {
            $pgds = $pgds->toArray();
            foreach($pgds as $stores) {
                if (is_array($stores['stores'])) {
                    if (count($stores['stores']) > 0) {
                        foreach($stores['stores'] as  $store) {
                            foreach ($store as $key => $item) {
                                $room[] = [
                                    '_id' => $key,
                                    'name' => $item['name']
                                ];
                            }
                        }
                    }
                }
            }
        }
        return $room;
    }

    public function getEmailMKT() {
        $result = [];
        $emails = $this->roleModel->where(Role::STATUS, ROLE::ACTIVE)
        ->where(Role::SLUG, 'marketing')
        ->get(['users']);
        if ($emails) {
            foreach ($emails[0]['users'] as $key => $item) {
                foreach ($item as $k => $i) {
                    foreach ($i as $e) {
                        $result[] = $e;
                    }
                }
            }
        }
        return $result ;
    }

    public function findAsmByStoreId($storeId) {
        $asm = $this->roleModel->where(Role::STATUS, Role::ACTIVE)
        ->where(Role::SLUG, 'like', '%asm%')
        ->where('stores.' . $storeId, '$exists', true)
        ->get(['users']);
        if ($asm) {
            $asm = $asm->toArray();
            $arrEmail = [];
            foreach ($asm as $key => $item) {
                foreach ($item['users'] as $i) {
                    foreach ($i as $k) {
                        if ($this->userModel->getUserActive($k['email'])){
                            $arrEmail[] = $k['email'];
                        }
                    }
                }
            }
            return array_values(array_unique($arrEmail));
        }
        return false;
    }

    public function findRsmByStoreId($storeId) {
        $rsm = $this->roleModel->where(Role::STATUS, Role::ACTIVE)
        ->where(Role::SLUG, 'like', '%quan-ly-vung%')
        ->where('stores.' . $storeId, '$exists', true)
        ->get(['users']);
        if ($rsm) {
            $rsm = $rsm->toArray();
            $arrEmail = [];
            foreach ($rsm as $key => $item) {
                foreach ($item['users'] as $i) {
                    foreach ($i as $k) {
                        if ($this->userModel->getUserActive($k['email'])){
                            $arrEmail[] = $k['email'];
                        }
                    }
                }
            }
            return array_values(array_unique($arrEmail));
        }
        return false;
    }

    public function getChtByStoreId($storeId) {
        $res = $this->roleModel->where(Role::STATUS, Role::ACTIVE)
        ->where('stores.' . $storeId, '$exists', true)
        ->where(Role::SLUG, 'like', '%pgd%')
        ->get(['users']);
        if ($res) {
            $arrCHT = [];
            foreach ($res->toArray() as $email) {
                if (is_array($email['users'])) { 
                    if (count($email['users']) > 0) { 
                        foreach ($email['users'] as $user) {
                            foreach ($user as $i) {
                                $userActive = $this->userModel->findUserByEmail($i['email']);
                                $cht = $this->isCHT($userActive['_id']);
                                if ($cht) {
                                    $arrCHT[] = $i['email'];
                                } else {
                                    continue;
                                }
                            }
                        }
                    }
                }
            }
            return $arrCHT;
        }
        return [];
    }

    public function getTPMKT() {
        $email = $this->roleModel->where(Role::STATUS, Role::ACTIVE)
        ->where(Role::SLUG, 'like', '%tbp-marketing%')
        ->get(['users']);
        if ($email) {
            $email = $email->toArray();
            $arrEmail = [];
            foreach ($email as $key => $item) {
                foreach ($item['users'] as $i) {
                    foreach ($i as $k) {
                        if ($this->userModel->getUserActive($k['email'])){
                            $arrEmail[] = $k['email'];
                        }
                    }
                }
            }
            return array_values(array_unique($arrEmail));
        }
        return false;
    }
}
