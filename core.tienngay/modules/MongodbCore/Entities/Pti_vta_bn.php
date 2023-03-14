<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Pti_vta_bn extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'pti_vta_bn';

    protected $guarded = [];

    /**
     * Column name table
     */
    const COLUMN_CUSTOMER_PHONE = "customer_info.customer_phone";

}
