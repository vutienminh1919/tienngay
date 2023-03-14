<?php


namespace Modules\AssetTienNgay\Http\Repository;


use Modules\AssetTienNgay\Model\NotificationAsset;

class NotificationRepository extends BaseRepository
{
    public function getModel()
    {
        return NotificationAsset::class;
    }
}
