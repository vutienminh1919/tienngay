<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class CskhInsert extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'cskh_insert';

    protected $guarded = [];

    public $timestamps = FALSE;

}
