<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Province extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'province';

    protected $guarded = [];

    /**
     * Column name table
     */

}
