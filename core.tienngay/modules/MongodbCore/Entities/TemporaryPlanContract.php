<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class TemporaryPlanContract extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'temporary_plan_contract';

    protected $primaryKey = '_id';

    /**
     * initial constants
     */
    const CODE_CONTRACT             = 'code_contract';
    const STATUS                    = 'status';
    const NGAY_KY_TRA               = 'ngay_ky_tra';
    const TIEN_TRA_1_KY             = 'tien_tra_1_ky';
    /**
     * end initial constants
     */

    const PAID = 2;	// the term is paid
    const NOT_PAID = 1; // the term is not paid yet
    const LAST_TERM = 1;
    const NOT_LAST_TERM = 0;
}
