<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class LeadBackLog extends BaseModel
{
    const COLUMN_ID_TLS = 'id_tls';
    const COLUMN_EMAIL = 'email';
    const COLUMN_TOTAL_LEAD_BACKLOG = 'total_lead_backlog';
    const COLUMN_START_DATE = 'start_date';
    const COLUMN_END_DATE = 'end_date';
    const COLUMN_DATE = 'date';
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lead_old_backlog';

}
