<?php


namespace Modules\AssetLocation\Http\Service;


use Modules\AssetLocation\Http\Repository\RoleRepository;

class RoleService extends BaseService
{
    protected $roleRepository;
    protected $storeRepository;

    public function __construct(RoleRepository $roleRepository,
                                StoreService $storeService)
    {
        $this->roleRepository = $roleRepository;
        $this->storeService = $storeService;
    }

    public function getStores($userId)
    {
        $roles = $this->roleRepository->findMany(["status" => "active"]);
        $roleStores = array();
        if (count($roles) > 0) {
            foreach ($roles as $role) {
                if (!empty($role['users']) && count($role['users']) > 0) {
                    $arrUsers = array();
                    foreach ($role['users'] as $item) {
                        array_push($arrUsers, key($item));
                    }
                    //Check userId in list key of $users
                    if (in_array($userId, $arrUsers) == TRUE) {
                        if (!empty($role['stores'])) {
                            //Push store
                            foreach ($role['stores'] as $key => $item) {
                                array_push($roleStores, key($item));
                            }
                        }
                    }
                }
            }
        }
        return array_unique($roleStores);
    }

    public function getStoresName($userId)
    {
        $roles = $this->roleRepository->findMany(["status" => "active"]);
        $roleStores = array();
        if (count($roles) > 0) {
            foreach ($roles as $role) {
                if (!empty($role['users']) && count($role['users']) > 0) {
                    $arrUsers = array();
                    foreach ($role['users'] as $item) {
                        array_push($arrUsers, key($item));
                    }
                    //Check userId in list key of $users
                    if (in_array($userId, $arrUsers) == TRUE) {
                        if (!empty($role['stores'])) {
                            //Push store
                            foreach ($role['stores'] as $key => $item) {
                                foreach ($item as $k => $v) {
                                    $roleStores[] = [
                                        'id' => $k,
                                        'name' => $v['name']
                                    ];
                                }
                            }
                        }
                    }
                }
            }
        }
        return $roleStores;
    }

    public function get_user_collection_mb()
    {
        $tpb = $this->get_user_by_role("tbp-thn-mien-bac");
        $lead = $this->get_user_by_role("lead-thn-mien-bac");
        $call = $this->get_user_by_role("call-thu-hoi-no-mien-bac");
        $field = $this->get_user_by_role("field-thu-hoi-no-mien-bac");
        $fieldB4 = $this->get_user_by_role("field-thu-hoi-no-mien-bac-b4");
        $data = array_merge($tpb, $lead, $call, $field, $fieldB4);
        return array_unique($data);
    }

    public function get_user_by_role($slug)
    {
        $data = [];
        $role = $this->roleRepository->findOne(["slug" => $slug]);
        if ($role && count($role['users']) > 0) {
            foreach ($role['users'] as $users) {
                foreach ($users as $user) {
                    array_push($data, $user['email']);
                }
            }
        }
        return array_unique($data);
    }

    public function get_user_collection_mn()
    {
        $tpb = $this->get_user_by_role("tbp-thn-mien-nam");
        $lead = $this->get_user_by_role("lead-thn-mien-nam");
        $call = $this->get_user_by_role("call-thu-hoi-no-mien-nam");
        $field = $this->get_user_by_role("field-thu-hoi-no-mien-nam");
        $fieldB4 = $this->get_user_by_role("field-thu-hoi-no-mien-nam-b4");
        $data = array_merge($tpb, $lead, $call, $field, $fieldB4);
        return array_unique($data);
    }

    public function get_store_by_collection($email)
    {
        $area = $this->check_area_user_collection($email);
        $stores = $this->storeService->get_name_store_by_area($area);
        return $stores;

    }

    public function check_area_user_collection($email)
    {
        $user_mb = $this->get_user_collection_mb();
        $user_mn = $this->get_user_collection_mn();
        $flag = '';
        if (in_array($email, $user_mb)) {
            $flag = 'mb';
        } elseif (in_array($email, $user_mn)) {
            $flag = 'mn';
        }
        return $flag;
    }
}
