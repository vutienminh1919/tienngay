<?php

namespace Modules\MysqlCore\Entities;

use Illuminate\Database\Eloquent\Model;

class CustomerJobInfo extends Model
{
    protected $connection = 'mysql';

    protected $table = 'customer_job_info';

    /**
     * initial constants
     */
    // receive salary via
    const RECEIVE_SALARY_VIA_CASH = 1;
    const RECEIVE_SALARY_VIA_BANK = 2;

    /**
     * end initial constants
     */

}
