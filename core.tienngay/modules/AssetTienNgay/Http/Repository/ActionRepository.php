<?php


namespace Modules\AssetTienNgay\Http\Repository;


use Modules\AssetTienNgay\Model\ActionAsset;

class ActionRepository extends BaseRepository
{
    public function getModel()
    {
        return ActionAsset::class;
    }

    public function get_action_add_user($action)
    {
        return $this->model
            ->whereNotIn(ActionAsset::ID, $action)
            ->get();
    }

    public function get_all_action_add_user()
    {
        return $this->model
            ->get();
    }
}
