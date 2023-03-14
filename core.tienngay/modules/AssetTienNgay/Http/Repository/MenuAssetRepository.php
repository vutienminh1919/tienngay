<?php


namespace Modules\AssetTienNgay\Http\Repository;


use Modules\AssetTienNgay\Model\MenuAsset;

class MenuAssetRepository extends BaseRepository
{
    public function getModel()
    {
        return MenuAsset::class;
    }

    public function get_menu_user()
    {
        return $this->model
            ->where(MenuAsset::LEVEL, '1')
            ->whereIn(MenuAsset::TYPE, ['HO', 'PGD'])
            ->get();
    }

    public function get_menu_add_role($menu)
    {
        return $this->model
            ->where(MenuAsset::STATUS, MenuAsset::ACTIVE)
            ->whereIn(MenuAsset::LEVEL, ['1', '2'])
            ->whereNotIn(MenuAsset::ID, $menu)
            ->get();
    }

    public function get_all_menu_add_role()
    {
        return $this->model
            ->where(MenuAsset::STATUS, MenuAsset::ACTIVE)
            ->whereIn(MenuAsset::LEVEL, ['1', '2'])
            ->get();
    }

    public function get_list_department($parent_id)
    {
        return $this->model
            ->where(MenuAsset::STATUS, MenuAsset::ACTIVE)
            ->whereIn(MenuAsset::PARENT_ID, $parent_id)
            ->get();
    }
}
