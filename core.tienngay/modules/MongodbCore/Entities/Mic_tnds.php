<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Mic_tnds extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'mic_tnds';

    protected $guarded = [];

    /**
     * Column name table
     */
    const COLUMN_CUSTOMER_PHONE = "customer_info.customer_phone";
}
