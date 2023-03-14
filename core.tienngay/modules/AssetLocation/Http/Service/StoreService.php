<?php


namespace Modules\AssetLocation\Http\Service;


use Modules\AssetLocation\Http\Repository\BaseRepository;
use Modules\AssetLocation\Http\Repository\RoleRepository;
use Modules\AssetLocation\Http\Repository\StoreRepository;
use Modules\AssetLocation\Model\Role;

class StoreService extends BaseService
{
    protected $storeRepository;
    protected $roleRepository;

    public function __construct(StoreRepository $storeRepository,
                                RoleRepository $roleRepository)
    {
        $this->storeRepository = $storeRepository;
        $this->roleRepository = $roleRepository;
    }

    public function get_user_by_store($store_id)
    {
        $roles = $this->roleRepository->findMany(['status' => 'active']);
        $data = [];
        $user_id = [];
        $i = 0;
        foreach ($roles as $key => $role) {
            if (!empty($role['users']) && !empty($role['stores'])) {
                $data[$i]['users'] = $role['users'];
                $data[$i]['stores'] = $role['stores'];
                $i++;
            }
        }
        foreach ($data as $da) {
            foreach ($da['stores'] as $d) {
                $storeId = [];
                foreach ($d as $k => $v) {
                    array_push($storeId, $k);
                }
                if (in_array($store_id, $storeId) == true) {
                    if (count($da['stores']) > 1) {
                        continue;
                    }
                    foreach ($da['users'] as $ds) {
                        foreach ($ds as $k => $v) {
                            if (in_array($v['email'], Role::BLOCK_EMAIL_TLS)) continue;
                            array_push($user_id, $v['email']);
                        }
                    }
                }
            }
        }
        return $user_id;
    }

    public function get_user_asm_by_store($store_id)
    {

        $roles = $this->roleRepository->findManyAsm();
        $data = [];
        $user_id = [];
        $i = 0;
        foreach ($roles as $key => $role) {
            if (!empty($role['users']) && !empty($role['stores'])) {
                $data[$i]['users'] = $role['users'];
                $data[$i]['stores'] = $role['stores'];
                $i++;
            }
        }
        foreach ($data as $da) {
            foreach ($da['stores'] as $d) {
                $storeId = [];
                $storeName = [];
                foreach ($d as $k => $v) {
                    array_push($storeId, $k);
                    array_push($storeName, $v['name']);
                }
                if (in_array($store_id, $storeId) == true) {
                    foreach ($da['users'] as $d) {
                        foreach ($d as $k => $v) {
                            array_push($user_id, $v['email']);
                        }
                    }
                }

            }
        }
        return $user_id;
    }

    public function get_all_user_by_store($store_id)
    {
        $users = $this->get_user_by_store($store_id);
        $asm = $this->get_user_asm_by_store($store_id);
        return array_unique(array_merge($users, $asm));
    }

    public function get_store_by_area($area)
    {
        if ($area == 'mb') {
            $stores = $this->storeRepository->whereIn('code_area', ['KV_HN1', 'KV_QN', 'Priority', 'KV_BTB']);
        } else {
            $stores = $this->storeRepository->whereIn('code_area', ['KV_HCM1', 'KV_HCM2', 'KV_MK', 'KV_BD']);
        }
        $data = [];
        foreach ($stores as $store) {
            array_push($data, $store['_id']);
        }
        return $data;
    }

    public function get_name_store_by_area($area)
    {
        if ($area == 'mb') {
            $stores = $this->storeRepository->whereIn('code_area', ['KV_HN1', 'KV_QN', 'Priority', 'KV_BTB']);
        } elseif ($area == 'mn') {
            $stores = $this->storeRepository->whereIn('code_area', ['KV_HCM1', 'KV_HCM2', 'KV_MK', 'KV_BD']);
        } else {
            $stores = $this->storeRepository->getAll();
        }
        $data = [];
        foreach ($stores as $store) {
            $data[$store['_id']] = $store['name'];
        }
        return $data;
    }
}
