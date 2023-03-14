<?php
namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Macom extends Model
{
    protected $connection = "mongodb";

    protected $collection = "macom";

    protected $primarykey = "_id";

    public $timestamps = false;

    /**
     * Column name table
    */

    const ID                    = '_id';
    const CREATED_BY            = 'created_by';
    const CREATED_AT            = 'created_at';
    const UPDATED_AT            = 'updated_at';
    const UPDATED_BY            = 'updated_by';
    const ZALO                  = 'zalo';
    const SOCIAL_MEIDA          = 'social_media';
    const KOL_KOC               = 'kol_koc';
    const OOH                   = 'ooh';
    const PR                    = 'pr_tv';
    const OTHER                 = 'other';
    const STATUS                = 'status';
    const LOG                   = 'logs';
    const TYPE                  = 'type';
    const COSTS                 = 'costs';
    const STORES                = 'stores';
    const STORE_ID              = 'store_id';
    const STORE_NAME            = 'store_name';
    const LICENSE_PATH          = "license_path";
    const CODE_AREA             = "code_area";
    const AREA_NAME             = "area_name";
    const DOMAIN                = "domain";
    const DOMAIN_NAME           = "domain_name";
    const CAMPAIGN_NAME         = "campaign_name";
    const URL                   = "url";
    const HITS                  = "hits";
    const MONTH                 = "month";

    protected $guarded = [];

    const TYPE_CONTRACT         = "contract";
    const TYPE_COST             = "cost";
    const STATUS_ACTIVE         = 1;
    const STATUS_BLOCK          = 2;
    const DOMAIN_MB             = "MB";
    const DOMAIN_MN             = "MN";
    const KV_QN                 = "KV_QN";
}