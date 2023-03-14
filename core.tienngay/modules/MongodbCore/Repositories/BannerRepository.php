<?php

namespace Modules\MongodbCore\Repositories;

use Modules\MongodbCore\Entities\Banner;
use Modules\MongodbCore\Repositories\BannerRepositoryInterface;
use Modules\MongodbCore\Repositories\BaseRepository;

/**
 * get all Banners for website CTV_TienNgay
 *
 * @param $data (void)
 *
 * @return Modules\MongodbCore\Entities\Banner
 */

class BannerRepository extends BaseRepository implements BannerRepositoryInterface
{
    public function getModel()
    {
        return Banner::class;
    }

    public function get_banner_ctv_tienngay()
    {
        $query = $this->model;
        return $query
            ->where(Banner::COLUMN_STATUS, Banner::STATUS_ACTIVE)
            ->where(Banner::COLUMN_PAGE, '10')
            ->orderBy(Banner::COLUMN_CREATED_AT, self::DESC)
            ->get();
    }

    public function get_banner_admin_ctv_tienngay()
    {
        $query = $this->model;
        return $query
            ->where(Banner::COLUMN_STATUS, Banner::STATUS_ACTIVE)
            ->where(Banner::COLUMN_PAGE, '11')
            ->orderBy(Banner::COLUMN_CREATED_AT, self::DESC)
            ->get();
    }

    public function toggleActive($id)
    {
        // TODO: Implement toggleActive() method.
    }

    public function find_foreignKey($id, $table, $collection)
    {
        // TODO: Implement find_foreignKey() method.
    }

    public function count_find_foreignKey($id, $table, $collection)
    {
        // TODO: Implement count_find_foreignKey() method.
    }
}
