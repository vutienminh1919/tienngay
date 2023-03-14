<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class LogTran extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'log_trans';

    protected $primaryKey = '_id';

    protected $guarded = [];

    public $timestamps = false;

    const TRAN_ID     = "transaction_id";
    const ACTION      = "action";
    const OLD_LOG     = "old";
    const NEW_LOG     = "new";
    const CREATED_AT  = "created_at";
    const CREATED_BY  = "created_by";


    const GUI_KT_DUYET  = "gui_kt_duyet";
    const KT_TRA_VE     = "tra_ve";
    const KT_DUYET      = "duyet_giao_dich";
    const KT_HUY        = "huy_giao_dich";
    const VIEW_EVIDENCE = "view_evidence";
}
