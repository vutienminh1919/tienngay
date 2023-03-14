<?php


namespace App\Repository;


use App\Models\LeadBackLog;
use Illuminate\Support\Facades\DB;

class LeadBackLogRepository extends BaseRepository implements LeadBackLogRepositoryInterface
{

    public function getModel()
    {
        return LeadBackLog::class;
        // TODO: Implement getModel() method.
    }

    public function getLeadBackLogSaved($id_tls, $date)
    {
        $model = $this->model;
        $model = $model->where(LeadBackLog::COLUMN_START_DATE, $date);
        $model = $model->where(LeadBackLog::COLUMN_ID_TLS, $id_tls);
        $model = $model->first('total_lead_backlog');
        $total_lead = 0;
        if (!empty($model->total_lead_backlog)) {
            $total_lead = $model->total_lead_backlog;
        }
        return $total_lead;
    }
}
