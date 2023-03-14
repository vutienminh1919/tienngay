<?php

namespace Modules\MongodbCore\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Modules\MongodbCore\Repositories\Interfaces\AreaRepositoryInterface;
use Modules\MongodbCore\Entities\Area;
use Modules\MongodbCore\Repositories\StoreRepository;

class AreaRepository implements AreaRepositoryInterface
{
    /**
     * @var Model
     */
    protected $areaModel;
    protected $storeRepository;

    /**
     * StoreRepository constructor.
     *
     * @param Store $store
     */
    public function __construct(Area $areaModel, StoreRepository $storeRepository) {
        $this->areaModel = $areaModel;
        $this->storeRepository = $storeRepository;
    }

    /**
     * Get domain
     *
     * @param  string  $code
     * @return boolean
     */
    public function getDomainByCodeArea($code) {
        $result = $this->areaModel::where(Area::CODE, $code)
        ->select([Area::DOMAIN, Area::TITLE])
        ->first();
        if ($result) {
            return $result;
        }
        return NULL;
    } 

    /**
     * Get code_area
     * @return boolean
     */
    public function getCodeArea()
    {
        $result = $this->areaModel::where(Area::STATUS, Area::ACTIVE)
            ->select([Area::CODE, Area::TITLE])
            ->get()
            ->toArray();
        if ($result) {
            return $result;
        }
        return [];
    }

    public function getCodeAreaName($code) {
        $result = $this->areaModel::where(Area::CODE, $code)
        ->where(Area::STATUS, Area::ACTIVE)
        ->select([Area::TITLE, Area::CODE])
        ->first();
        if ($result) {
            return $result;
        }
        return NULL;
    }

    public function getCodeAreaTitle($code)
    {
        $result = $this->areaModel::where(Area::CODE, $code)
//            ->where(Area::STATUS, 'active')
            ->select([Area::TITLE])
            ->first();
        if ($result) {
            return $result->toArray();
        }
        return NULL;
    }

    public function getCodeAreaByDomain($domain)
    {
        $result = $this->areaModel::where(Area::STATUS, Area::ACTIVE)
            ->where('domain.code', $domain)
            ->select(Area::CODE, Area::TITLE)
            ->get();
        if($result){
             return $result->toArray();
        }
        return [];
    }

    public function getAllRegion()
    {
        $result = $this->areaModel::where(Area::STATUS, Area::ACTIVE)
            ->distinct('region')
            ->select('region')
            ->get()->toArray();
        return $result;

    }

    public function getAreaByDomain($code) {
        $result = $this->areaModel::where(Area::DOMAIN.'.'.Area::CODE, $code)
        ->get(['code', 'title']);
        if ($result) {
            return $result->toArray();
        }
        return NULL;
    }

    public function groupKV() {
        $groupKV = $this->areaModel::raw(function ($collection) {
            return $collection->aggregate([
                ['$match' => (object)[
                        Area::STATUS => Area::ACTIVE,
                    ]
                ],
                ['$group' => 
                    [
                        "_id" => ['code' => '$domain.code', 'name' => '$domain.name'], 
                        "kv" => ['$push' => ['kv_code' => '$code', 'kv_name' => '$title']]
                    ]
                ],
                ['$project' => 
                    [ 
                        'kv' => '$kv',
                    ] 
                ],
                
            ]);
        });
        return $groupKV;
    }

}
