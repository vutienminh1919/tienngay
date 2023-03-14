<?php

namespace Modules\MongodbCore\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Modules\MongodbCore\Repositories\Interfaces\MacomRepositoryInterface;
use Modules\MongodbCore\Entities\Macom;

class MacomRepository implements MacomRepositoryInterface
{

    /**
     * @var Model
     */
    protected $macomModel;

   /**
    * MacomRepository .
    *
    * @param Macom
    */
    
    public function __construct(Macom $macomModel) {
        $this->macomModel = $macomModel;
    }

    /**
    * find by id
    * @param string $id
    * @return Collection
    */
    public function findById($id) {
        $result = $this->macomModel::where(Macom::ID, $id)
        ->first();
        if ($result) {
            return $result;
        }
        return false;
    }

    /**
    * create
    * @param array $data
    * @return Collection
    */
    public function create($data = []) {
        $result = [
            Macom::CAMPAIGN_NAME    => $data[Macom::CAMPAIGN_NAME] ?? "",
            Macom::CODE_AREA        => $data[Macom::CODE_AREA] ?? "",
            Macom::SOCIAL_MEIDA     => $data[Macom::SOCIAL_MEIDA] ?? "",
            Macom::PR               => $data[Macom::PR] ?? "",
            Macom::KOL_KOC          => $data[Macom::KOL_KOC] ?? "",
            Macom::OOH              => $data[Macom::OOH] ?? "",
            Macom::OTHER            => $data[Macom::OTHER] ?? "",
            Macom::STORES           => $data[Macom::STORES] ?? "",
            Macom::AREA_NAME        => $data[Macom::AREA_NAME] ?? "",
            Macom::DOMAIN           => $data[Macom::DOMAIN] ?? "",
            Macom::DOMAIN_NAME      => $data[Macom::DOMAIN_NAME] ?? "",
            Macom::CREATED_AT       => time(),
            Macom::CREATED_BY       => $data[Macom::CREATED_BY] ?? "",
            Macom::STATUS           =>  Macom::STATUS_ACTIVE,
            Macom::URL              =>  $data[Macom::URL] ?? "",
            Macom::HITS             =>  $data[Macom::HITS] ?? "",
            Macom::MONTH            =>  date('Y-m-d H:i:s', time()),
        ];
        if (empty($result)) {
            return false;
        }
        $create = $this->macomModel->create($result);
        if ($create) {
            return $create;
        }
        return false;
    }

    /**
    * udpate
    * @param array $data
    * @param string $id
    * @return Collection
    */
    public function update($data = [], $id) {
        $result = [
            Macom::CAMPAIGN_NAME        => $data[Macom::CAMPAIGN_NAME] ?? "",
            Macom::STORES               => $data[Macom::STORES] ?? "",
            Macom::SOCIAL_MEIDA         => $data[Macom::SOCIAL_MEIDA] ?? "",
            Macom::PR                   => $data[Macom::PR] ?? "",
            Macom::KOL_KOC              => $data[Macom::KOL_KOC] ?? "",
            Macom::OOH                  => $data[Macom::OOH] ?? "",
            Macom::OTHER                => $data[Macom::OTHER] ?? "",
            Macom::UPDATED_AT           => time(),
            Macom::UPDATED_BY           => $data[Macom::UPDATED_BY] ?? "",
            Macom::URL                  => $data[Macom::URL] ?? "",
            Macom::HITS                 => $data[Macom::HITS] ?? "",
            Macom::STATUS               => Macom::STATUS_ACTIVE,
        ];
        if (empty($result)) {
            return false;
        }
        $update = $this->macomModel->where(Macom::ID, $id)->update($result);
        if ($update) {
            return $update;
        }
        return false;
    }

    /**
    * get_domain_MB
    * @param
    * 
    * @return Collection
    */
    public function get_domain_MB($data = []) {
        if (!empty($data['start_month']) || !empty($data['start_month'])) {
            if (!empty($data['start_month']) && empty($data['end_month'])) {
                $startMonth =  (date('Y-m-01 00:00:00', strtotime($data['start_month'])));
                $endMonth = date('Y-m-d H:i:s', time());
            } 

            if (!empty($data['end_month']) && empty($data['start_month'])) {
                $startMonth = "";
                $endMonth = (date('Y-m-t 23:59:59', strtotime($data['end_month'])));
            }

            if (!empty($data['start_month']) && !empty($data['end_month'])) {
                $startMonth =  (date('Y-m-01 00:00:00', strtotime($data['start_month'])));
                $endMonth = (date('Y-m-t 23:59:59', strtotime($data['end_month'])));
            }
            $result = $this->macomModel->where(Macom::DOMAIN, Macom::DOMAIN_MB)
            ->where(Macom::CODE_AREA, 'not regexp', '/KV_QN/i')
            ->where(Macom::MONTH, '>=' ,$startMonth)
            ->where(Macom::MONTH, '<=' ,$endMonth)->get()->toArray();
            if ($result) {
                foreach ($result as $item) {
                    $allSocial[] = $item[Macom::SOCIAL_MEIDA];
                    $allPr[] = $item[Macom::PR];
                    $allKol[] = $item[Macom::KOL_KOC];
                    $allOoh[] = $item[Macom::OOH];
                    $allOther[] = $item[Macom::OTHER];
                }
                return $data = [
                    'all_social' => array_sum($allSocial),
                    'all_pr' => array_sum($allPr),
                    'all_kol' => array_sum($allKol),
                    'all_ooh' => array_sum($allOoh),
                    'all_other' => array_sum($allOther),
                ];
            }
            return $data = [
                'all_social'    => config('mongodbcore.no_data'),
                'all_pr'        => config('mongodbcore.no_data'),
                'all_kol'       => config('mongodbcore.no_data'),
                'all_ooh'       => config('mongodbcore.no_data'),
                'all_other'     => config('mongodbcore.no_data'),
            ];
        }
        $result = $this->macomModel->where(Macom::DOMAIN, Macom::DOMAIN_MB)
        ->where(Macom::CODE_AREA, 'not regexp', '/KV_QN/i')
        ->get()->toArray();
        if ($result) {
            foreach ($result as $item) {
                $allSocial[] = $item[Macom::SOCIAL_MEIDA];
                $allPr[] = $item[Macom::PR];
                $allKol[] = $item[Macom::KOL_KOC];
                $allOoh[] = $item[Macom::OOH];
                $allOther[] = $item[Macom::OTHER];
            }
            return $data = [
                'all_social' => array_sum($allSocial),
                'all_pr' => array_sum($allPr),
                'all_kol' => array_sum($allKol),
                'all_ooh' => array_sum($allOoh),
                'all_other' => array_sum($allOther),
            ];
        }
        return $data = [
            'all_social'    => config('mongodbcore.no_data'),
            'all_pr'        => config('mongodbcore.no_data'),
            'all_kol'       => config('mongodbcore.no_data'),
            'all_ooh'       => config('mongodbcore.no_data'),
            'all_other'     => config('mongodbcore.no_data'),
        ];
    }
       
    /**
    * get_domain_MN
    * @param
    * 
    * @return Collection
    */
    public function get_domain_MN($data=[]) {
        if (!empty($data['start_month']) || !empty($data['start_month'])) {
            if (!empty($data['start_month']) && empty($data['end_month'])) {
                $startMonth =  (date('Y-m-01 00:00:00', strtotime($data['start_month'])));
                $endMonth = date('Y-m-d H:i:s', time());
            } 

            if (!empty($data['end_month']) && empty($data['start_month'])) {
                $startMonth = "";
                $endMonth = (date('Y-m-t 23:59:59', strtotime($data['end_month'])));
            }

            if (!empty($data['start_month']) && !empty($data['end_month'])) {
                $startMonth =  (date('Y-m-01 00:00:00', strtotime($data['start_month'])));
                $endMonth = (date('Y-m-t 23:59:59', strtotime($data['end_month'])));
            }
            $result = $this->macomModel->where(Macom::DOMAIN, Macom::DOMAIN_MN)
            ->where(Macom::CODE_AREA, 'not regexp', '/KV_QN/i')
            ->where(Macom::MONTH, '>=' ,$startMonth)
            ->where(Macom::MONTH, '<=' ,$endMonth)->get()->toArray();
            if ($result) {
                foreach ($result as $item) {
                    $allSocial[] = $item[Macom::SOCIAL_MEIDA];
                    $allPr[] = $item[Macom::PR];
                    $allKol[] = $item[Macom::KOL_KOC];
                    $allOoh[] = $item[Macom::OOH];
                    $allOther[] = $item[Macom::OTHER];
                }
                return $data = [
                    'all_social' => array_sum($allSocial),
                    'all_pr' => array_sum($allPr),
                    'all_kol' => array_sum($allKol),
                    'all_ooh' => array_sum($allOoh),
                    'all_other' => array_sum($allOther),
                ];
            }
            return $data = [
                'all_social'    => config('mongodbcore.no_data'),
                'all_pr'        => config('mongodbcore.no_data'),
                'all_kol'       => config('mongodbcore.no_data'),
                'all_ooh'       => config('mongodbcore.no_data'),
                'all_other'     => config('mongodbcore.no_data'),
            ];
        }
        $result = $this->macomModel->where(Macom::DOMAIN, Macom::DOMAIN_MN)
        ->get()->toArray();
        if ($result) {
            foreach ($result as $item) {
                $allSocial[] = $item[Macom::SOCIAL_MEIDA];
                $allPr[] = $item[Macom::PR];
                $allKol[] = $item[Macom::KOL_KOC];
                $allOoh[] = $item[Macom::OOH];
                $allOther[] = $item[Macom::OTHER];
            }
            return $data = [
                'all_social' => array_sum($allSocial),
                'all_pr' => array_sum($allPr),
                'all_kol' => array_sum($allKol),
                'all_ooh' => array_sum($allOoh),
                'all_other' => array_sum($allOther),
            ];
        }
        return $data = [
            'all_social'    => config('mongodbcore.no_data'),
            'all_pr'        => config('mongodbcore.no_data'),
            'all_kol'       => config('mongodbcore.no_data'),
            'all_ooh'       => config('mongodbcore.no_data'),
            'all_other'     => config('mongodbcore.no_data'),
        ];
    }

    /**
    * get_domain_DB
    * @param
    * 
    * @return Collection
    */
    public function get_domain_DB($data=[]) {
        if (!empty($data['start_month']) || !empty($data['start_month'])) {
            if (!empty($data['start_month']) && empty($data['end_month'])) {
                $startMonth =  (date('Y-m-01 00:00:00', strtotime($data['start_month'])));
                $endMonth = date('Y-m-d H:i:s', time());
            } 

            if (!empty($data['end_month']) && empty($data['start_month'])) {
                $startMonth = "";
                $endMonth = (date('Y-m-t 23:59:59', strtotime($data['end_month'])));
            }

            if (!empty($data['start_month']) && !empty($data['end_month'])) {
                $startMonth =  (date('Y-m-01 00:00:00', strtotime($data['start_month'])));
                $endMonth = (date('Y-m-t 23:59:59', strtotime($data['end_month'])));
            }
            $result = $this->macomModel->where(Macom::CODE_AREA, Macom::KV_QN)
            ->where(Macom::MONTH, '>=' ,$startMonth)
            ->where(Macom::MONTH, '<=' ,$endMonth)->get()->toArray();
            if ($result) {
                foreach ($result as $item) {
                    $allSocial[] = $item[Macom::SOCIAL_MEIDA];
                    $allPr[] = $item[Macom::PR];
                    $allKol[] = $item[Macom::KOL_KOC];
                    $allOoh[] = $item[Macom::OOH];
                    $allOther[] = $item[Macom::OTHER];
                }
                return $data = [
                    'all_social' => array_sum($allSocial),
                    'all_pr' => array_sum($allPr),
                    'all_kol' => array_sum($allKol),
                    'all_ooh' => array_sum($allOoh),
                    'all_other' => array_sum($allOther),
                ];
            }
            return $data = [
                'all_social'    => config('mongodbcore.no_data'),
                'all_pr'        => config('mongodbcore.no_data'),
                'all_kol'       => config('mongodbcore.no_data'),
                'all_ooh'       => config('mongodbcore.no_data'),
                'all_other'     => config('mongodbcore.no_data'),
            ];
        }
        $result = $this->macomModel->where(Macom::CODE_AREA, Macom::KV_QN)
        ->get()->toArray();
        if ($result) {
            foreach ($result as $item) {
                $allSocial[] = $item[Macom::SOCIAL_MEIDA];
                $allPr[] = $item[Macom::PR];
                $allKol[] = $item[Macom::KOL_KOC];
                $allOoh[] = $item[Macom::OOH];
                $allOther[] = $item[Macom::OTHER];
            }
            return $data = [
                'all_social' => array_sum($allSocial),
                'all_pr' => array_sum($allPr),
                'all_kol' => array_sum($allKol),
                'all_ooh' => array_sum($allOoh),
                'all_other' => array_sum($allOther),
            ];
        }
        return $data = [
            'all_social'    => config('mongodbcore.no_data'),
            'all_pr'        => config('mongodbcore.no_data'),
            'all_kol'       => config('mongodbcore.no_data'),
            'all_ooh'       => config('mongodbcore.no_data'),
            'all_other'     => config('mongodbcore.no_data'),
        ];
    }

    /**
    * get_store_MB
    * @param
    * 
    * @return Collection
    */
    public function get_store_MB() {
        $result = $this->macomModel->where(Macom::DOMAIN, Macom::DOMAIN_MB)
        ->where(Macom::CODE_AREA, 'not regexp', '/KV_QN/i')
        ->get()
        ->toArray();
        if ($result) {
            return $result;
        }
        return false;
    }

    /**
    * get_store_MN
    * @param
    * 
    * @return Collection
    */
    public function get_store_MN() {
        $result = $this->macomModel->where(Macom::DOMAIN, Macom::DOMAIN_MN)
        ->get()
        ->toArray();
        if ($result) {
            return $result;
        }
        return false;
    }

    /**
    * get_store_DB
    * @param
    * 
    * @return Collection
    */
    public function get_store_DB() {
        $result = $this->macomModel->where(Macom::DOMAIN, Macom::DOMAIN_DB)
        ->get()
        ->toArray();
        if ($result) {
            return $result;
        }
        return false;
    }

    public function getCampaignName() {
        $result = $this->macomModel->where(Macom::CAMPAIGN_NAME, '$exists', true)
        ->get([Macom::CAMPAIGN_NAME]);
        if ($result) {
            return $result->toArray();
        }
        return [];
    }

    /**
    * get_all_history
    * @param array $data
    * 
    * @return Collection
    */
    public function get_all_history($data = []) {
        $listHistory = $this->macomModel;
        if(!empty($data['start_date'])) {
            $startDate =strtotime(trim($data['start_date'])  . '00:00:00');
            $listHistory = $listHistory->where(Macom::CREATED_AT, '>=' ,$startDate);
        }
        if(!empty($data['end_date'])) {
            $endDate =  strtotime(trim($data['end_date']) . '23:59:59');
            $listHistory = $listHistory->where(Macom::CREATED_AT, '<=' ,$endDate);
        }
        if(!empty($data['store_id'])) {
            $listHistory = $listHistory->where(Macom::STORES .'.'.'id', '=' ,trim($data['store_id']));
        }
        if(!empty($data['code_area'])) {
            $listHistory = $listHistory->where(Macom::CODE_AREA, '=' ,trim($data['code_area']));
        }
        if(!empty($data['campaign_name'])) {
            $listHistory = $listHistory->where(Macom::CAMPAIGN_NAME, '$regex', '/'.trim($data['campaign_name']).'/i');
        }
        return $listHistory
        ->orderBy($this->macomModel::CREATED_AT, 'DESC')
        ->paginate(10);
    }


    // /**
    // * get_all
    // * @param array $data
    // * 
    // * @return Collection
    // */
    // public function get_all($data = []) {
    //     $listHistory = $this->macomModel;
    //     if (!empty($data['month']) || !empty($data['store_id']) || !empty($data['code_area'])) {
    //         if (!empty($data['month'])) {
    //             $startDate =  (date('Y-m-01 00:00:00', strtotime($data['month'])));
    //             // Last day of the month.
    //             $endDate = (date('Y-m-t 23:59:59', strtotime($data['month'])));
    //             $listHistory = $listHistory->where(Macom::MONTH, '>=' ,$startDate)
    //             ->where(Macom::MONTH, '<=' ,$endDate);
    //         }
    //         if(!empty($data['store_id'])) {
    //             $listHistory = $listHistory->where(Macom::STORES .'.'.'id', '=' ,trim($data['store_id']));
    //         }
    //         if(!empty($data['code_area'])) {
    //             $listHistory = $listHistory->where(Macom::CODE_AREA, '=' ,trim($data['code_area']));
    //         }
    //         return $listHistory
    //         ->orderBy(Macom::CREATED_AT, "DESC")->get();
    //     } elseif(empty($data['month']) && empty($data['store_id']) && empty($data['code_area'])) {
    //         return [];
    //     }
    //     return [];
    // }


    /**
    * get_all_domain
    * @param
    * 
    * @return Collection
    */
    public function get_all_domain() {
        $result = $this->macomModel->get()->toArray();
        if ($result) {
            $arr = [];
            foreach ($result as $item) {
                $arr[$item[Macom::DOMAIN]] = $item[Macom::DOMAIN_NAME];
            }
            return $arr;
        }
        return [];
    }

    /**
    * get_cost_code_area
    * @param string $code
    * 
    * @return Collection
    */
    public function get_cost_code_area($code) {
        $result = $this->macomModel->where(Macom::CODE_AREA, '=', $code)
        ->get()
        ->toArray();
        if (count($result) > 0) {
            return $result;
        }
        return [];
    }

    /**
    * groupByStoresId
    * @param
    * 
    * @return Collection
    */
    public function groupByStoresId() {
        $group = $this->macomModel::raw(function ($collection) {
            return $collection->aggregate([
                [ '$unwind' => '$stores'],
                ['$group' => [
                    "_id" => '$stores.id',
                    "social_media" => ['$sum' => '$stores.social_media'],
                    "pr_tv" => ['$sum' => '$stores.pr_tv'],
                    "kol_koc" => ['$sum' => '$stores.kol_koc'],
                    "ooh" => ['$sum' => '$stores.ooh'],
                    "other" => ['$sum' => '$stores.other'],
                ],
                ],
            ]);
        });
        return $group->toArray();
    }

    /**
    * groupByCodeArea
    * @param array $data
    * 
    * @return Collection
    */
    public function groupByCodeArea($data = []) {
        if (!empty($data['start_month']) || !empty($data['end_month']) || !empty($data['store_id']) || !empty($data['code_area'])) {
            if (!empty($data['start_month']) && empty($data['end_month'])) {
                $startDate =  (date('Y-m-01 00:00:00', strtotime($data['start_month'])));
                // Last day of the month.
                $endDate = (date('Y-m-t 23:59:59', time()));
            }
            else if (!empty($data['end_month']) && empty($data['start_month'])) {
                $endDate = (date('Y-m-t 23:59:59', strtotime($data['end_month'])));
                $startDate = null;
            }
            else if (!empty($data['start_month']) && !empty($data['end_month'])) {
                $startDate =  (date('Y-m-01 00:00:00', strtotime($data['start_month'])));
                $endDate = (date('Y-m-t 23:59:59', strtotime($data['end_month'])));
            } 
            else if (empty($data['start_month']) && empty($data['end_month'])) {
                $startDate =  null;
                $endDate = null;
            }
            $st = $data['store_id'] ?? "";
            $area = $data['code_area'] ?? "";
            $condition = [];
            if ($startDate && $endDate) {
                $condition ['month'] = (object)['$gte' => $startDate, '$lte' => $endDate];
            }
            if ($st) {
                $condition ['stores.id'] =  $st;
            }
            if ($area) {
                $condition ['stores.code_area'] = $area;
            }
            // dd((object)$condition);
            $group = $this->macomModel::raw(function ($collection) use ($condition) {
                return $collection->aggregate([
                    [ '$unwind' => '$stores'],
                    ['$match' => (object)$condition
                    ],
                    ['$group' => 
                        [
                            "_id" => '$stores.id', 
                            "social_media" => ['$sum' => '$stores.social_media'],
                            "pr_tv" => ['$sum' => '$stores.pr_tv'],
                            "kol_koc" => ['$sum' => '$stores.kol_koc'],
                            "ooh" => ['$sum' => '$stores.ooh'],
                            "other" => ['$sum' => '$stores.other'],
                            "store" => ['$addToSet' => '$stores.store'],
                            "code_area" => ['$addToSet' => '$stores.code_area'],
                        ]
                    ],
                    ['$project' => 
                        [ 
                            'social_media' => '$social_media', 
                            'pr_tv' => '$pr_tv',
                            'kol_koc' => '$kol_koc',
                            'ooh' => '$ooh',
                            'other' => '$other',
                            'store' => '$store',
                            'code_area' => '$code_area',
                        ] 
                    ],
                    
                ]);
            });
        } 

        if (empty($data['start_month']) && empty($data['end_month']) && empty($data['store_id']) && empty($data['code_area'])) {
            $group = [];
            return $group;
        }
        return $group;
    }

    /**
    * lấy tổng tiền hệ thống theo tháng lọc
    * @param array $data
    * 
    * @return Collection
    */
    public function costAllByMonth($data) {
        $allCost = $this->macomModel;
        if (!empty($data['month'])) {
            $startDate =  (date('Y-m-01 00:00:00', strtotime($data['month'])));
            // Last day of the month.
            $endDate = (date('Y-m-t 23:59:59', strtotime($data['month'])));
            $allCost = $allCost->where(Macom::MONTH, '>=' ,$startDate)
            ->where(Macom::MONTH, '<=' ,$endDate);
            return $allCost->get();
        } else {
            return [];
        }
    }
}
