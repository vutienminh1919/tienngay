<?php


namespace Modules\AssetTienNgay\Http\Service;


use Modules\AssetTienNgay\Http\Repository\DepartmentRepository;
use Modules\AssetTienNgay\Http\Repository\EquipmentRepository;
use Modules\AssetTienNgay\Http\Repository\MenuAssetRepository;
use Modules\AssetTienNgay\Http\Repository\RoleRepository;
use Modules\AssetTienNgay\Http\Repository\UserRepository;
use Modules\AssetTienNgay\Http\Repository\WarehouseRepository;
use Modules\AssetTienNgay\Model\Department;
use Modules\AssetTienNgay\Model\MenuAsset;
use Modules\AssetTienNgay\Model\RoleAsset;
use Modules\AssetTienNgay\Model\WarehouseAsset;

class RoleService extends BaseService
{
    protected $roleRepository;
    protected $menuRepository;
    protected $departmentRepository;
    protected $warehouseRepository;
    protected $equipmentRepository;
    protected $userRepository;

    public function __construct(RoleRepository $roleRepository,
                                MenuAssetRepository $menuRepository,
                                DepartmentRepository $departmentRepository,
                                WarehouseRepository $warehouseRepository,
                                EquipmentRepository $equipmentRepository,
                                UserRepository $userRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->menuRepository = $menuRepository;
        $this->departmentRepository = $departmentRepository;
        $this->warehouseRepository = $warehouseRepository;
        $this->equipmentRepository = $equipmentRepository;
        $this->userRepository = $userRepository;
    }

    public function create($request)
    {
        $data = [
            RoleAsset::NAME => $request->name,
            RoleAsset::SLUG => slugify($request->name),
            RoleAsset::STATUS => RoleAsset::ACTIVE,
            RoleAsset::CREATED_AT => time(),
            RoleAsset::CREATED_BY => $request->user_info->email,
            RoleAsset::USERS => explode(',', $request->users),
            RoleAsset::MENUS => explode(',', $request->menus),
        ];
        $this->roleRepository->create($data);
    }

    public function update($request)
    {
        $data = [
            RoleAsset::USERS => explode(',', $request->users),
            RoleAsset::MENUS => explode(',', $request->menus),
            RoleAsset::UPDATED_AT => time(),
            RoleAsset::UPDATED_BY => $request->user_info->email,
        ];
        $this->roleRepository->update($request->role_id, $data);
    }

    public function get_menu_user($request)
    {
        $data_parent = [];
        $data_child = [];
        $roles = $this->roleRepository->getAll();
        foreach ($roles as $role) {
            if (in_array($request->user_info->_id, $role['users'])) {
                foreach ($role['menus'] as $menu) {
                    $data_menu = $this->menuRepository->find($menu);
                    if ($data_menu && !isset($data_menu['parent_id'])) {
                        array_push($data_parent, $data_menu['_id']);
                    }
                    if ($data_menu && isset($data_menu['parent_id'])) {
                        array_push($data_child, $data_menu['_id']);
                    }
                }
            }
        }
        $data_parent_unique = array_unique($data_parent);
        $data_child_unique = array_unique($data_child);
        $result = [];
        foreach ($data_parent_unique as $key => $datum) {
            $mn = $this->menuRepository->find($datum);
            $result[$key] = $mn;
            if (!isset($mn['parent_id'])) {
                $childs = $this->get_id_menu_child($datum, $data_child_unique);
                if (count($childs) > 0) {
                    $result[$key]['child'] = $childs;
                    foreach ($result[$key]['child'] as $item) {
                        if ($item['type'] == 'HO' || $item['type'] == 'PGD') {
                            $item['url'] = "supplies/department?department_id=" . $item['_id'];
                        } elseif ($item['type'] == 'KHO') {
                            $item['url'] = "supplies/warehouse?warehouse_id=" . $item['_id'];
                        } elseif ($item['type'] == 'DEVICE') {
                            $item['url'] = "supplies/equipment?equipment_id=" . $item['_id'];
                        }
                    }
                }
            }
        }
        return $result;
    }

    public function get_id_menu_child($parent_id, $menus)
    {
        $data = [];
        $childs = $this->menuRepository->findMany([MenuAsset::PARENT_ID => $parent_id]);
        foreach ($childs as $child) {
            array_push($data, $child['_id']);
        }
        $result = [];
        if ($data) {
            foreach ($menus as $value) {
                if (in_array($value, $data)) {
                    $child = $this->menuRepository->find($value);
                    array_push($result, $child);
                }
            }
        }
        return $result;
    }

    public function get_slug_role_user($request)
    {
        $data = [];
        $roles = $this->roleRepository->search_like([RoleAsset::SLUG => "hanh-chinh"]);
        foreach ($roles as $role) {
            if (in_array($request->user_info->_id, $role['users'])) {
                array_push($data, $role['slug']);
            }
        }
        return $data;
    }

    public function get_all($request)
    {
        $role = $this->roleRepository->getAll();
        return $role;
    }

    public function show($request)
    {
        $role = $this->roleRepository->find($request->id);
        $users = [];
        if (count($role['users']) > 0) {
            foreach ($role['users'] as $user) {
                $user_info = $this->userRepository->find($user);
                $users[] = [
                    'id' => $user,
                    'email' => $user_info['email']
                ];
            }
        }
        $role['users'] = $users;
        $menus = [];
        if (count($role['menus']) > 0) {
            foreach ($role['menus'] as $menu) {
                $menu_info = $this->menuRepository->find($menu);
                if ($menu_info) {
                    if ($menu_info['level'] == '1') {
                        $menus[] = [
                            'id' => $menu,
                            'name' => $menu_info['name']
                        ];
                    } else {
                        $menu_parent = $this->menuRepository->find($menu_info['parent_id']);
                        if ($menu_parent) {
                            $menus[] = [
                                'id' => $menu,
                                'name' => $menu_parent['name'] . '/ ' . $menu_info['name']
                            ];
                        }
                    }
                }
            }
        }
        $role['menus'] = $menus;
        return $role;
    }

    public function validate_create($request)
    {
        $message = [];
        if (empty($request->name)) {
            $message[] = "Tên role không để trống";
        }
        $menu = $this->roleRepository->findOne([RoleAsset::SLUG => slugify($request->name)]);
        if ($menu) {
            $message[] = "Tên role đã tồn tại";
        }
        return $message;
    }

    public function get_user_role_hcns()
    {
        $role = $this->roleRepository->findOne([RoleAsset::SLUG => 'hanh-chinh-nhan-su']);
        $user = $role['users'];
        return $user;
    }

    public function view_dashboard($id)
    {
        $data = [];
        $roles = $this->roleRepository->getAll();
        foreach ($roles as $role) {
            if (in_array($id, $role['users'])) {
                foreach ($role['menus'] as $menu) {
                    array_push($data, $menu);
                }
            }
        }
        foreach (array_unique($data) as $value) {
            $data_menu = $this->menuRepository->find($value);
            if ($data_menu['slug'] == 'dashboard') {
                return true;
            }
        }
        return false;
    }

    public function get_all_user_role()
    {
        $users_id = [];
        $roles = $this->roleRepository->getAll();
        if ($roles) {
            foreach ($roles as $role) {
                foreach ($role['users'] as $user_id) {
                    array_push($users_id, $user_id);
                }
            }
        }
        $users_id_new = array_unique($users_id);
        $data_users = [];
        foreach ($users_id_new as $value) {
            $user = $this->userRepository->find($value);
            array_push($data_users, $user);
        }
        return $data_users;
    }

    public function check_van_hanh($request)
    {
        $van_hanh = $this->roleRepository->findOne([RoleAsset::SLUG => 'van-hanh']);
        if (in_array($request->user_info->_id, $van_hanh['users'])) {
            return 1;
        } else {
            return 0;
        }
    }

    public function get_user_manager_supplies($department_id)
    {
        $users = [];
        $roles = $this->roleRepository->search_like([RoleAsset::SLUG => 'hanh-chinh']);
        foreach ($roles as $role) {
            if (count($role['menus']) > 0) {
                if (in_array($department_id, $role['menus']) == true) {
                    foreach ($role['users'] as $user) {
                        array_push($users, $user);
                    }
                }
            }
        }
        return array_unique($users);
    }

    public function get_department_manager_by_user_administrative($request)
    {
        $menus = [];
        $roles = $this->roleRepository->search_like([RoleAsset::SLUG => 'hanh-chinh']);
        if ($roles) {
            foreach ($roles as $role) {
                if (count($role['users']) > 0) {
                    if (in_array($request->user_info->_id, $role['users'])) {
                        foreach ($role['menus'] as $menu) {
                            $data_menu = $this->menuRepository->find($menu);
                            if ($data_menu['type'] == "HO" || $data_menu['type'] == 'PGD') {
                                if ($data_menu['level'] == '2') {
                                    array_push($menus, $menu);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $menus;
    }

    public function get_warehouse_manager_by_user_administrative($request)
    {
        $menus = [];
        $roles = $this->roleRepository->search_like([RoleAsset::SLUG => 'hanh-chinh']);
        if ($roles) {
            foreach ($roles as $role) {
                if (count($role['users']) > 0) {
                    if (in_array($request->user_info->_id, $role['users'])) {
                        foreach ($role['menus'] as $menu) {
                            $data_menu = $this->menuRepository->find($menu);
                            if ($data_menu['type'] == "KHO" && $data_menu['level'] == '2') {
                                array_push($menus, $menu);
                            }
                        }
                    }
                }
            }
        }
        return $menus;
    }

    public function get_equipment_manager_by_user_administrative($request)
    {
        $menus = [];
        $roles = $this->roleRepository->search_like([RoleAsset::SLUG => 'hanh-chinh']);
        if ($roles) {
            foreach ($roles as $role) {
                if (count($role['users']) > 0) {
                    if (in_array($request->user_info->_id, $role['users'])) {
                        foreach ($role['menus'] as $menu) {
                            $data_menu = $this->menuRepository->find($menu);
                            if ($data_menu['type'] == "DEVICE" && $data_menu['level'] == '2') {
                                array_push($menus, $menu);
                            }
                        }
                    }
                }
            }
        }
        return $menus;
    }
}
