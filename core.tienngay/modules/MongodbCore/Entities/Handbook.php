<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Handbook extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'handbook';

    protected $guarded = [];

    /**
     * initial constants
     */

    /**
     * end initial constants
     */
}
