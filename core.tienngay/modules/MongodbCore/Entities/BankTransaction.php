<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class BankTransaction extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'bank_transaction';

    /**
     * Column name table
     */
    const TYPE            = 'type';
    const CONTENT         = 'content';



    //const value
    const TYPE_MOMO_RECONCILIATION = 'momo_reconciliation';
}
