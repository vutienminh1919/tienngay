<?php

namespace Modules\MysqlCore\Entities;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $connection = 'mysql';

    protected $table = 'debts';

    /**
     * initial constants
     */

    /**
     * end initial constants
     */
}
