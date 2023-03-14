<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Vbi_sxh extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'vbi_sxh';

    protected $guarded = [];

    /**
     * Column name table
     */
    const COLUMN_CUSTOMER_PHONE = "customer_info.customer_phone";

}
