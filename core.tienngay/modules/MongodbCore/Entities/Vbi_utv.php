<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Vbi_utv extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'vbi_utv';

    protected $guarded = [];

    /**
     * Column name table
     */
    const COLUMN_CUSTOMER_PHONE = "customer_info.customer_phone";
}
