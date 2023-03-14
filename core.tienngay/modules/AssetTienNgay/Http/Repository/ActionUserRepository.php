<?php


namespace Modules\AssetTienNgay\Http\Repository;


use Modules\AssetTienNgay\Model\ActionUser;

class ActionUserRepository extends BaseRepository
{
    public function getModel()
    {
        return ActionUser::class;
    }
}
