<?php


namespace Modules\AssetTienNgay\Http\Service;


use http\Env\Request;
use Modules\AssetTienNgay\Http\Repository\LogMenuAssetRepository;
use Modules\AssetTienNgay\Http\Repository\LogSuppliesRepository;
use Modules\AssetTienNgay\Http\Repository\MenuAssetRepository;
use Modules\AssetTienNgay\Http\Repository\SuppliesRepository;
use Modules\AssetTienNgay\Http\Repository\UserRepository;
use Modules\AssetTienNgay\Model\LogMenuAsset;
use Modules\AssetTienNgay\Model\LogSuppliesAsset;
use Modules\AssetTienNgay\Model\MenuAsset;
use Modules\AssetTienNgay\Model\SuppliesAsset;
use Modules\AssetTienNgay\Model\User;

class MenuAssetService extends BaseService
{
    protected $menuAssetRepository;
    protected $logMenuAssetRepository;
    protected $userAssetRepository;
    protected $suppliesRepository;
    protected $logSuppliesRepository;

    public function __construct(MenuAssetRepository $menuAssetRepository,
                                LogMenuAssetRepository $logMenuAssetRepository,
                                UserRepository $userRepository,
                                SuppliesRepository $suppliesRepository,
                                LogSuppliesRepository $logSuppliesRepository)
    {
        $this->menuAssetRepository = $menuAssetRepository;
        $this->logMenuAssetRepository = $logMenuAssetRepository;
        $this->userRepository = $userRepository;
        $this->suppliesRepository = $suppliesRepository;
        $this->logSuppliesRepository = $logSuppliesRepository;
    }

    public function create($request)
    {
        $data = [];
        if (isset($request->parent_id)) {
            $menu = $this->menuAssetRepository->find($request->parent_id);
            if ($request->type_menu == 'USER') {
                if ($menu['level'] == '1') {
                    return false;
                }
                if ($menu['type'] !== "HO" && $menu['type'] !== "PGD") {
                    return false;
                }
                $user = $this->userRepository->findOne([User::EMAIL => $request->name]);
                $request->name = $user['email'];
                $request->user_id = $user['_id'];
                $request->user_name = $user['full_name'];
                $request->user_email = $user['email'];
            } else {
                if ($menu['type'] == "HO" || $menu['type'] == "PGD") {
                    if ($menu['level'] == '2') {
                        return false;
                    }
                }
            }
            $request->type_menu = $menu['type'];
            $level = (string)((int)$menu['level'] + 1);
        } else {
            $level = '1';
        }
        $data = [
            MenuAsset::NAME => check_undefined($request->name),
            MenuAsset::SLUG => slugify($request->name),
            MenuAsset::URL => check_undefined($request->url),
            MenuAsset::PARENT_ID => check_undefined($request->parent_id),
            MenuAsset::ICON => check_undefined($request->icon),
            MenuAsset::SIGN => check_undefined($request->sign),
            MenuAsset::USER_ID => check_undefined($request->user_id),
            MenuAsset::USER_NAME => check_undefined($request->user_name),
            MenuAsset::USER_EMAIL => check_undefined($request->user_email),
            MenuAsset::STATUS => MenuAsset::ACTIVE,
            MenuAsset::LEVEL => $level,
            MenuAsset::TYPE => check_undefined($request->type_menu),
            MenuAsset::CREATED_AT => time(),
            MenuAsset::CREATED_BY => $request->user_info->email
        ];
        $menu_new = $this->menuAssetRepository->create($data);
        $this->logMenuAssetRepository->create([
            LogMenuAsset::REQUEST => $data,
            LogMenuAsset::RESPONSE => $menu_new,
            LogMenuAsset::TYPE => LogMenuAsset::CREATE,
            LogMenuAsset::CREATED_AT => time(),
            LogMenuAsset::CREATED_BY => $request->user_info->email
        ]);
        return true;
    }

    public function get_user_depart($request)
    {
        $data = $this->menuAssetRepository->findManySortColumn(
            [
                MenuAsset::PARENT_ID => $request->depart_id,
                MenuAsset::STATUS => MenuAsset::ACTIVE
            ],
            MenuAsset::CREATED_AT,
            self::DESC
        );
        return $data;
    }

    public function get_list_ware_house()
    {
        $main = $this->menuAssetRepository->findOne([MenuAsset::TYPE => 'KHO', MenuAsset::LEVEL => '1']);
        $data = $this->menuAssetRepository->findManySortColumn(
            [MenuAsset::PARENT_ID => $main->_id],
            MenuAsset::CREATED_AT,
            self::DESC
        );
        return $data;
    }

    public function get_list_equipment()
    {
        $main = $this->menuAssetRepository->findOne([MenuAsset::TYPE => 'DEVICE', MenuAsset::LEVEL => '1']);
        $data = $this->menuAssetRepository->findManySortColumn(
            [MenuAsset::PARENT_ID => $main->_id],
            MenuAsset::CREATED_AT,
            self::DESC
        );
        return $data;
    }

    public function show($request)
    {
        return $this->menuAssetRepository->find($request->id);
    }

    public function get_child($request)
    {
        $data = $this->menuAssetRepository->findManySortColumn(
            [
                MenuAsset::PARENT_ID => $request->id,
                MenuAsset::STATUS => MenuAsset::ACTIVE
            ],
            MenuAsset::CREATED_AT,
            self::DESC);
        return $data;
    }

    public function get_depart_main($request)
    {
        $parent = [];
        $depart_ho = $this->menuAssetRepository->findOne([MenuAsset::TYPE => 'HO', MenuAsset::LEVEL => '1']);
        $parent[$depart_ho->_id] = $depart_ho->name;
        $depart_pgd = $this->menuAssetRepository->findOne([MenuAsset::TYPE => 'PGD', MenuAsset::LEVEL => '1']);
        $parent[$depart_pgd->_id] = $depart_pgd->name;
        return $parent;
    }

    public function get_child_app($request)
    {
        $data = $this->menuAssetRepository->findManySortColumn(
            [
                MenuAsset::PARENT_ID => $request->parent_id,
                MenuAsset::STATUS => MenuAsset::ACTIVE
            ],
            MenuAsset::CREATED_AT,
            self::DESC);
        $result = [];
        foreach ($data as $value) {
            if ($value['level'] == '3') {
                if ($value['type'] == 'HO' || $value['type'] == 'PGD') {
                    $result[$value['user_id']] = $value['name'];
                } else {
                    $result[$value['_id']] = $value['name'];
                }
            } else {
                $result[$value['_id']] = $value['name'];
            }
        }
        return $result;
    }

    public function get_equip_main($request)
    {
        $main = $this->menuAssetRepository->findOne([MenuAsset::TYPE => 'DEVICE', MenuAsset::LEVEL => '1']);
        $data = $this->menuAssetRepository->findManySortColumn(
            [
                MenuAsset::PARENT_ID => $main->_id,
                MenuAsset::STATUS => MenuAsset::ACTIVE
            ],
            MenuAsset::CREATED_AT,
            self::DESC);
        $result = [];
        foreach ($data as $value) {
            $result[$value['_id']] = $value['name'];
        }
        return $result;
    }

    public function validate_create($request)
    {
        $message = [];
        if (empty($request->name)) {
            $message[] = "Tên menu không để trống";
        }
        $menu = $this->menuAssetRepository->findOne([MenuAsset::SLUG => slugify($request->name)]);
        if ($menu) {
            $message[] = "Tên menu đã tồn tại";
        }

        if (!empty($request->sign)) {
            $menu = $this->menuAssetRepository->findOne([MenuAsset::SIGN => $request->sign]);
            if ($menu) {
                $message[] = "Kí hiệu đã tồn tại";
            }
        }
        return $message;
    }

    public function get_menu($request)
    {
        $main = $this->menuAssetRepository->findManySortColumn(
            [
                MenuAsset::LEVEL => '1'
            ],
            MenuAsset::CREATED_AT,
            self::ASC
        );
        $data = [];
        foreach ($main as $parent) {
            $data[] = [
                "_id" => $parent->_id,
                "level" => '1',
                "name" => "../ " . $parent->name,
                "url" => check_undefined($parent->url),
                "sign" => check_undefined($parent->sign),
                'type' => $parent->type,
                'status' => $parent->status
            ];
            $parent = $this->menuAssetRepository->findMany([MenuAsset::PARENT_ID => $parent->_id]);
            foreach ($parent as $child) {
                $data_child = [];
                $childs = $this->menuAssetRepository->findMany([MenuAsset::PARENT_ID => $child->_id]);
                foreach ($childs as $value) {
                    $data_child[] = [
                        "_id" => $value->_id,
                        "level" => '3',
                        "name" => "../../../ " . $value->name,
                        "url" => check_undefined($value->url),
                        "sign" => check_undefined($value->sign),
                        'type' => $value->type,
                        'status' => $value->status
                    ];
                }
                $data[] = [
                    "_id" => $child->_id,
                    "level" => '2',
                    "name" => "../../ " . $child->name,
                    "url" => check_undefined($child->url),
                    "sign" => check_undefined($child->sign),
                    "childs" => $data_child,
                    'type' => $child->type,
                    'status' => $child->status
                ];
            }
        }
        return $data;
    }

    public function get_menu_parent($request)
    {
        $main = $this->menuAssetRepository->findManySortColumn(
            [
                MenuAsset::LEVEL => '1'
            ],
            MenuAsset::CREATED_AT,
            self::ASC
        );

        $data = [];
        foreach ($main as $parent) {
            $data[$parent->_id] = $parent->name;
            $parents = $this->menuAssetRepository->findMany([MenuAsset::PARENT_ID => $parent->_id]);
            foreach ($parents as $child) {
                $data[$child->_id] = $parent->name . '/ ' . $child->name;
            }
        }
        return $data;
    }

    public function get_menu_add_role($request)
    {
        $menuids = $request->menuids;
        if (isset($menuids) && count($menuids) > 0) {
            $menus = $this->menuAssetRepository->get_menu_add_role($menuids);
        } else {
            $menus = $this->menuAssetRepository->get_all_menu_add_role();
        }
        foreach ($menus as $menu) {
            if ($menu->level == '1') {
                $menu->name = $menu->name;
            } elseif ($menu->level == '2') {
                $main = $this->menuAssetRepository->find($menu->parent_id);
                $menu->name = $main->name . '/ ' . $menu->name;
            }
        }
        return $menus;
    }

    public function get_list_department()
    {
        $data_id = [];
        $ho = $this->menuAssetRepository->findOne([MenuAsset::TYPE => 'HO', MenuAsset::LEVEL => '1']);
        array_push($data_id, $ho['_id']);
        $pgd = $this->menuAssetRepository->findOne([MenuAsset::TYPE => 'PGD', MenuAsset::LEVEL => '1']);
        array_push($data_id, $pgd['_id']);
        $data = $this->menuAssetRepository->get_list_department($data_id);
        return $data;
    }

    public function toggle_status($request)
    {
        $message = [];
        $menu = $this->menuAssetRepository->find($request->id);
        if ($menu['status'] == MenuAsset::ACTIVE) {
            if (!empty($menu['user_id'])) {
                $supplies = $this->suppliesRepository->findOne([SuppliesAsset::USER_ID => $menu['user_id']]);
                if ($supplies) {
                    $message[] = "Nhân sự đang có thiết bị, không thể block";
                    return $message;
                } else {
                    $this->menuAssetRepository->update($request->id,
                        [
                            MenuAsset::STATUS => MenuAsset::BLOCK,
                            MenuAsset::UPDATED_AT => time(),
                            MenuAsset::UPDATED_BY => $request->user_info->email,
                        ]);
                }
            } else {
                $this->menuAssetRepository->update($request->id,
                    [
                        MenuAsset::STATUS => MenuAsset::BLOCK,
                        MenuAsset::UPDATED_AT => time(),
                        MenuAsset::UPDATED_BY => $request->user_info->email,
                    ]);
            }
        } else {
            $this->menuAssetRepository->update($request->id,
                [
                    MenuAsset::STATUS => MenuAsset::ACTIVE,
                    MenuAsset::UPDATED_AT => time(),
                    MenuAsset::UPDATED_BY => $request->user_info->email,
                ]);
        }
        return $message;
    }

    public function transfer_user($request)
    {
        $message = [];
        if (empty($request->menu_id)) {
            $message[] = "Danh mục gốc không để trống";
            return $message;
        }
        $menu = $this->menuAssetRepository->find($request->user_id);
        $parent = $this->menuAssetRepository->find($menu['parent_id']);
        $supplies = $this->suppliesRepository->findOne([SuppliesAsset::USER_ID => $menu['user_id']]);
        if ($supplies) {
            $message[] = "Nhân sự đang có thiết bị " . $parent['name'] . " , không thể di chuyển";
            return $message;
        } else {
            $this->menuAssetRepository->update($request->user_id, [
                MenuAsset::PARENT_ID => $request->menu_id,
                MenuAsset::UPDATED_AT => time(),
                MenuAsset::UPDATED_BY => $request->user_info->email,
            ]);
        }
        return $message;
    }

    public function detail($request)
    {
        $data = $this->menuAssetRepository->find($request->id);
        if (!empty($data['parent_id'])) {
            $data['parent'] = $this->menuAssetRepository->find($data['parent_id']);
        }
        return $data;
    }

    public function transfer_menu($request)
    {
        $message = [];
        if (empty($request->menu_id)) {
            $message[] = "Danh mục gốc không để trống";
            return $message;
        }

        $menu = $this->menuAssetRepository->find($request->child_id);
        $this->menuAssetRepository->update($request->child_id, [
            MenuAsset::PARENT_ID => $request->menu_id,
            MenuAsset::UPDATED_AT => time(),
            MenuAsset::UPDATED_BY => $request->user_info->email,
        ]);
        $supplies = $this->suppliesRepository->findManySortColumn(
            [SuppliesAsset::EQUIPMENT_CHILD_ID => $request->child_id],
            SuppliesAsset::CREATED_AT,
            self::DESC
        );
        foreach ($supplies as $supply) {
            $supply_new = $this->suppliesRepository->update($supply['_id'], [SuppliesAsset::EQUIPMENT_ID => $request->menu_id]);
            $log = $this->logSuppliesRepository->create([
                LogSuppliesAsset::TYPE => LogSuppliesAsset::UPDATE,
                LogSuppliesAsset::OLD => $supply,
                LogSuppliesAsset::OLD_STATUS => $supply['status'],
                LogSuppliesAsset::NEW => $supply_new,
                LogSuppliesAsset::NEW_STATUS => $supply_new['status'],
                LogSuppliesAsset::SUPPLIES_ID => $supply['_id'],
                LogSuppliesAsset::NOTE => "Cập nhật loại thiết bị",
                LogSuppliesAsset::CREATED_AT => time(),
                LogSuppliesAsset::CREATED_BY => $request->user_info->email
            ]);
        }
        return $message;
    }

    public function show_by_user($request)
    {
        $data = $this->menuAssetRepository->findOne([MenuAsset::USER_ID => $request->id]);
        return $data;
    }

    public function rename($request)
    {
        $this->menuAssetRepository->update($request->menu_id, [
            MenuAsset::NAME => $request->name,
            MenuAsset::SLUG => slugify($request->name)
        ]);
    }

    public function sw_user_depart($request)
    {
        $this->menuAssetRepository->update($request->menu_id, [
            MenuAsset::PARENT_ID => $request->parent_id,
        ]);
    }

    public function update_sign($request)
    {
        $this->menuAssetRepository->update($request->id, [MenuAsset::SIGN => $request->sign]);
    }
}
