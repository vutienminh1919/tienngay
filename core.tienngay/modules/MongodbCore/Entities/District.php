<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class District extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'district';

    protected $guarded = [];

    /**
     * Column name table
     */

}
