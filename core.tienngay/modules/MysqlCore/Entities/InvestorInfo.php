<?php

namespace Modules\MysqlCore\Entities;

use Illuminate\Database\Eloquent\Model;

class InvestorInfo extends Model
{
    protected $connection = 'mysql';

    protected $table = 'investor_info';

    /**
     * initial constants
     */
    // form of receipt
    const FORM_OF_RECEIPT_CASH = 1;
    const FORM_OF_RECEIPT_BANK = 2;
    /**
     * end initial constants
     */
}
