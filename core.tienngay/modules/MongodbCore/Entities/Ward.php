<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Ward extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'ward';

    protected $guarded = [];

    /**
     * Column name table
     */

}
