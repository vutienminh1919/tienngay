<?php


namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Gic_plt_bn extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'gic_plt_bn';

    protected $guarded = [];

    /**
     * Column name table
     */
    const COLUMN_CUSTOMER_PHONE = "customer_info.customer_phone";
    const COLUMN_CODE_GIC_PLT = "request.code_GIC_plt";
}
