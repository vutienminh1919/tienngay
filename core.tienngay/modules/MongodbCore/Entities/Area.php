<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Area extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'area';

    protected $guarded = [];

    public $timestamps = FALSE;

    /**
     * Column name table
     */
    const ID = "_id";
    const CODE = "code";
    const DOMAIN = "domain";
    const REGION = "region";
    const STATUS = "status";
    const TITLE = "title";

    const STATUS_ACTIVE = 1;
    const STATUS_BLOCK = 2;
    const ACTIVE = 'active';
    const BLOCK = 'block';
}
