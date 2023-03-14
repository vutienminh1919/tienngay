<?php


namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Entities\GroupRole;
use Modules\MongodbCore\Repositories\UserCpanelRepository;

class GroupRoleRepository
{
    /**
     * @var Model
     */
     protected $groupRoleModel;
     protected $userCpanelRepository;

     /**
     * RoleRepository constructor.
     *
      *  * @param GroupRole $groupRole
     */

     public function __construct(GroupRole $groupRole, UserCpanelRepository $userCpanelRepository)
     {
        $this->groupRoleModel = $groupRole;
        $this->userCpanelRepository = $userCpanelRepository;
     }
    //lấy hết nhân viên phòng kiểm soát nội bộ
    public function getEmailGroupKsnb()
    {
    $user =[];
        $result = $this->groupRoleModel::where(GroupRole::SLUG, 'kiem-soat-noi-bo')
            ->where(GroupRole::STATUS, GroupRole::ACTIVE)
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

//lấy hết nhân viên phòng kinh doanh
    public function getEmailGroupNvkd($id)
    {
        $user = [];
        $result = $this->groupRoleModel::where(GroupRole::SLUG, 'giao-dich-vien')
            ->where(GroupRole::STATUS, GroupRole::ACTIVE)
            ->first();
        if ($result) {
            $groupRole = $result["users"];
            foreach ($groupRole as $array => $arr) {
                foreach ($arr as $key => $value) {
                    foreach ($value as $k => $v) {
                        $user[] = $v;
                    }
                }
            }
        }
        return $user;
    }

    public function getEmailCht()
    {
        $arrCHT = [];
        $result = $this->groupRoleModel::where(GroupRole::SLUG, 'cua-hang-truong')
            ->where(GroupRole::STATUS, GroupRole::ACTIVE)
            ->first();
        if ($result) {
            $groupRole = $result["users"];
            foreach ($groupRole as $array => $arr) {
                foreach ($arr as $key => $value) {
                    foreach ($value as $k => $v) {
                        $arrCHT[] = $v;
                    }
                }
            }
        }
        return $arrCHT;
    }

    public function isCHT($email)
    {
        $arrCHT = $this->getEmailCht();
        if (in_array($email, $arrCHT)) {
            return true;
        }
        return false;
    }

    /**
     * Get group role list
     * @param $userId string
     * @return array
     * */
    public function getGroupRoleByUserId($userId)
    {
        $result = $this->groupRoleModel::where(GroupRole::STATUS, GroupRole::ACTIVE)
            ->where(["users.$userId" => ['$exists' => true]])
            ->get();
        $groupRole = [];
        foreach($result as $role) {
            $groupRole[] = $role["slug"];
        }
        return $groupRole;
    }

//lay group role
    public function getGroupRole($userId)
    {
        $groupRoles = $this->groupRoleModel::where(GroupRole::STATUS, GroupRole::ACTIVE)->get();
        $arr = array();
        foreach ($groupRoles as $groupRole) {
            if (empty($groupRole['users'])) continue;
            foreach ($groupRole['users'] as $item) {
                if (key($item) == $userId) {
                    array_push($arr, $groupRole['slug']);
                    continue;
                }
            }
        }
        return $arr;
    }

    public function getAsm() {
        $result = $this->groupRoleModel::where(GroupRole::STATUS, GroupRole::ACTIVE)
        ->where(GroupRole::SLUG, 'quan-ly-khu-vuc')
        ->select(['users'])->first();
        if ($result) {
            foreach ($result['users'] as $email) {
                foreach ($email as $e) {
                    $data[] = $e['email'];
                }
            }
            return $data;
        }
        return false;
    }

    public function getEmailGDKD() {
        $gdkd = $this->groupRoleModel->where(GroupRole::STATUS, GroupRole::ACTIVE)
        ->where(GroupRole::SLUG, 'giam-doc-kinh-doanh')
        ->get(['users']);
        if ($gdkd) {
            $gdkd = $gdkd->toArray();
            $arrEmail = [];
            foreach ($gdkd as $key => $item) {
                foreach ($item['users'] as $i) {
                    foreach ($i as $k) {
                        if ($this->userCpanelRepository->getUserActive($k['email'])){
                            $arrEmail[] = $k['email'];
                        }
                    }
                }
            }
            return array_values(array_unique($arrEmail));
        }
        return false;
    }

    public function getEmailTradeMKT() {
        $trade = $this->groupRoleModel->where(GroupRole::STATUS, GroupRole::ACTIVE)
        ->where(GroupRole::SLUG, 'trade-marketing')
        ->get(['users']);
        if ($trade) {
            $trade = $trade->toArray();
            $arrEmail = [];
            foreach ($trade as $key => $item) {
                foreach ($item['users'] as $i) {
                    foreach ($i as $k) {
                        if ($this->userCpanelRepository->getUserActive($k['email'])){
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
