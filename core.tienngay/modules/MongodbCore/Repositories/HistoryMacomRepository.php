<?php

namespace Modules\MongodbCore\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Modules\MongodbCore\Repositories\Interfaces\HistoryMacomRepositoryInterface;
use Modules\MongodbCore\Entities\HistoryMacom;

class HistoryMacomRepository implements HistoryMacomRepositoryInterface
{

    /**
     * @var Model
     */
    protected $historyMacomModel;

   /**
    * MacomRepository .
    *
    * @param Macom
    */
    
    public function __construct(HistoryMacom $historyMacomModel) {
        $this->historyMacomModel = $historyMacomModel;
    }

    /**
    * create
    * @param array $data
    * @return Collection
    */
    public function create($data = []) {
        $result = [
            HistoryMacom::CAMPAIGN_NAME => $data[HistoryMacom::CAMPAIGN_NAME] ?? "",
            HistoryMacom::CODE_AREA     => $data[HistoryMacom::CODE_AREA] ?? "",
            HistoryMacom::SOCIAL_MEIDA  => $data[HistoryMacom::SOCIAL_MEIDA] ?? "",
            HistoryMacom::PR            => $data[HistoryMacom::PR] ?? "",
            HistoryMacom::KOL_KOC       => $data[HistoryMacom::KOL_KOC] ?? "",
            HistoryMacom::OOH           => $data[HistoryMacom::OOH] ?? "",
            HistoryMacom::OTHER         => $data[HistoryMacom::OTHER] ?? "",
            HistoryMacom::STORES        => $data[HistoryMacom::STORES] ?? "",
            HistoryMacom::AREA_NAME     => $data[HistoryMacom::AREA_NAME] ?? "",
            HistoryMacom::DOMAIN        => $data[HistoryMacom::DOMAIN] ?? "",
            HistoryMacom::DOMAIN_NAME   => $data[HistoryMacom::DOMAIN_NAME] ?? "",
            HistoryMacom::CREATED_AT    => time(),
            HistoryMacom::CREATED_BY    => $data[HistoryMacom::CREATED_BY] ?? "",
            HistoryMacom::STATUS        =>  HistoryMacom::STATUS_ACTIVE,
            HistoryMacom::URL           =>  $data[HistoryMacom::URL] ?? "",
            HistoryMacom::HITS          =>  $data[HistoryMacom::HITS] ?? "",
            HistoryMacom::MACOM_ID      =>  $data[HistoryMacom::MACOM_ID] ?? "",
            HistoryMacom::MONTH            =>  date('Y-m-d H:i:s', time()),
        ];
        if (empty($result)) {
            return false;
        }
        $create = $this->historyMacomModel->create($result);
        if ($create) {
            return $create;
        }
        return false;
    }

    /**
    * update
    * @param array $data
    * @param string $id
    * @return Collection
    */
    public function update($data = [], $id) {
        $result = [
            HistoryMacom::CAMPAIGN_NAME => $data[HistoryMacom::CAMPAIGN_NAME] ?? "",
            HistoryMacom::SOCIAL_MEIDA  => $data[HistoryMacom::SOCIAL_MEIDA] ?? "",
            HistoryMacom::PR            => $data[HistoryMacom::PR] ?? "",
            HistoryMacom::KOL_KOC       => $data[HistoryMacom::KOL_KOC] ?? "",
            HistoryMacom::OOH           => $data[HistoryMacom::OOH] ?? "",
            HistoryMacom::OTHER         => $data[HistoryMacom::OTHER] ?? "",
            HistoryMacom::STORES        => $data[HistoryMacom::STORES] ?? "",
            HistoryMacom::AREA_NAME     => $data[HistoryMacom::AREA_NAME] ?? "",
            HistoryMacom::DOMAIN        => $data[HistoryMacom::DOMAIN] ?? "",
            HistoryMacom::DOMAIN_NAME   => $data[HistoryMacom::DOMAIN_NAME] ?? "",
            HistoryMacom::UPDATED_AT    => time(),
            HistoryMacom::UPDATED_BY    => $data[HistoryMacom::UPDATED_BY] ?? "",
            HistoryMacom::STATUS        => HistoryMacom::STATUS_ACTIVE,
            HistoryMacom::URL           => $data[HistoryMacom::URL] ?? "",
            HistoryMacom::HITS          => $data[HistoryMacom::HITS] ?? "",
        ];
        if (empty($result)) {
            return false;
        }
        $update = $this->historyMacomModel->where(HistoryMacom::MACOM_ID, $id)->update($result);
        if ($update) {
            return $update;
        }
        return false;
    }
    /**
    * getStoreById
    * @param string $id
    * @return Collection
    */
    public function getStoreById($id) {
        $store = $this->historyMacomModel
        ->where('store_id', $id)
        ->get()->toArray();
        if ($store) {
            return $store;
        }
        return false;
    }

    /**
    * Write user's log
    * @param $id String: 
    * @param $action String: user's action
    * @param $createdby String: login user
    * @param $old array: old data
    * @param $new array: new data
    */
    public function wlog($id, $action, $createdBy, $old = false) {
        if ($old) {
            $log = [
                'action'        => $action,
                'created_by'    => $createdBy,
                'created_at'    => time(),
                'data_old'      => $old,
            ];
        } else {
            $log = [
                'action'        => $action,
                'created_by'    => $createdBy,
                'created_at'    => time(),
            ];
        }
        $updateKsnb = $this->historyMacomModel::where(HistoryMacom::MACOM_ID, $id)
            ->push($this->historyMacomModel::LOGS, $log);
    }

    public function findById($id) {
        $result = $this->historyMacomModel
        ->where(HistoryMacom::MACOM_ID, $id)
        ->first();
        if ($result) {
            return $result;
        }
        return [];
    }

    public function findLog($id) {
        $result = $this->historyMacomModel
        ->where(HistoryMacom::MACOM_ID, $id)
        ->select([HistoryMacom::LOGS])
        ->first();
        if ($result) {
            return $result;
        }
        return [];
    }
} 
