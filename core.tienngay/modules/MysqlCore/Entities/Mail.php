<?php

namespace Modules\MysqlCore\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mail extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     * Assign vitual account number for contract
     *
     * @var string
     */
    protected $table = 'mails';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Column name table
     */
    const ID                        = 'id';
    const FROM                      = 'from';
    const TO                        = 'to';
    const SUBJECT                   = 'subject';
    const MESSAGE                   = 'message';
    const NAMEFROM                  = 'nameFrom';
    const TYPE                      = 'type';
    const STATUS                    = 'status';
    const ERRORS                    = 'errors';
    const DELETED_AT                = 'deleted_at';
    const CREATED_AT                = 'created_at';
    const UPDATED_AT                = 'updated_at';

    // status
    const STATUS_WAITING            = 1;
    const STATUS_SUCCESS            = 2;
    const STATUS_ERRORS             = 3;
    const STATUS_INACTIVE           = 4;
    const STATUS_SENDING            = 5;

    // type
    const TYPE_ALERT_SERVER_DOWN    = 1;
    const TYPE_OBSERVE_APPROVED_TRANSACTION    = 2;
    const TYPE_KSNB                 = 3;
    const TYPE_TENANCY              = 6;
    const TYPE_MKT                  = 4;
    const TYPE_RESET_SPASS          = 5;
    const TYPE_TRADE                = 7;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::FROM,
        self::TO,
        self::SUBJECT,
        self::MESSAGE,
        self::NAMEFROM,
        self::TYPE,
        self::STATUS
    ];

    /**
     * Get table name function
     *
     * @return string
     */
    public function getTableName() {
        return $this->table;
    }

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        self::STATUS => self::STATUS_WAITING,
    ];


}
