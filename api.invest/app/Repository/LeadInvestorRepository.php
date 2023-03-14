<?php


namespace App\Repository;


use App\Models\Call;
use App\Models\LeadInvestor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LeadInvestorRepository extends BaseRepository implements LeadInvestorRepositoryInterface
{
    public function getModel()
    {
        return LeadInvestor::class;
    }

    public function get_list_lead_investor($filter)
    {
        $model = $this->model;
        if (!empty($filter['find_call_assign'])) {
            $find_call_assign = $filter['find_call_assign'];
            $model = $model->where(LeadInvestor::COLUMN_ASSIGN_CALL, $find_call_assign);
        }
        if (!empty($filter['assign_call'])) {
            $assign_call = $filter['assign_call'];
            $model = $model->where(LeadInvestor::COLUMN_ASSIGN_CALL, $assign_call);
        }
        if (!empty($filter['phone'])) {
            $phone = $filter['phone'];
            $model = $model->where(LeadInvestor::COLUMN_PHONE, 'LIKE', "%$phone%");
        }
        if (!empty($filter['name_investor'])) {
            $name_investor = $filter['name_investor'];
            $model = $model->where(LeadInvestor::COLUMN_NAME, 'LIKE', "%$name_investor%");
        }
        if (!empty($filter['status_call'])) {
            $status_call = $filter['status_call'];
            if ($status_call == 100) {
                $model = $model->whereNull(LeadInvestor::COLUMN_STATUS_CALL);
            } else {
                $model = $model->whereHas('call', function ($query_call) use ($status_call) {
                    if ($status_call == 1) {
                        $query_call->whereIn(Call::COLUMN_STATUS, [1, 2, 3, 4, 5, 6, 7, 8, 9]);
                    } else {
                        $query_call->where(Call::COLUMN_STATUS, (int)$status_call);
                    }
                });
            }
            if ($status_call == 13) {
                if (!empty($filter['note_delete'])) {
                    $node_delete = $filter['note_delete'];
                    $model = $model->whereHas('call', function ($query_call) use ($node_delete) {
                        $query_call->where(Call::COLUMN_NOTE, (int)$node_delete);
                    });
                }
            }
        }
        if (!empty($filter['source'])) {
            $source = $filter['source'];
            $model = $model->where(LeadInvestor::COLUMN_SOURCE, $source);
        }
        if (!empty($filter['priority'])) {
            $priority = $filter['priority'];
            if ($priority) {
                $model = $model->where(LeadInvestor::COLUMN_PRIORITY, (int)$priority);
            }
        }

        $model = $model->orderBy(LeadInvestor::COLUMN_ID, self::DESC);
        $model = $model->paginate();
        return $model;
    }

    public function getAllListNew($filter)
    {
        $model = $this->model;
        if (isset($filter['fdate']) && isset($filter['tdate'])) {
            $fdate = $filter['fdate'] . ' 00:00:00';
            $tdate = $filter['tdate'] . ' 23:59:59';
            $model = $model->whereBetween(LeadInvestor::COLUMN_CREATED_AT, [$fdate, $tdate]);
        }
        $model = $model->orderBy(LeadInvestor::COLUMN_CREATED_AT, self::DESC);
        $model = $model->get();
        return $model;
    }

    public function get_all_lead()
    {
        $model = $this->model;
        return $model->orderBy(LeadInvestor::COLUMN_CREATED_AT, self::DESC)
            ->get();
    }

    public function get_lead_null_assign()
    {
        $start = '2022-04-27 00:00:00';
        $date = date('Y-m-d 17:30:00');
        $model = $this->model;
        return $model
            ->whereBetween(LeadInvestor::COLUMN_CREATED_AT, [$start, $date])
            ->whereNull(LeadInvestor::COLUMN_ASSIGN_CALL)
            ->orderBy(LeadInvestor::COLUMN_ID, self::ASC)
            ->get();
    }

    public function findLastLead()
    {
        $start = '2022-04-27 00:00:00';
        $model = $this->model;
        return $model
            ->where(LeadInvestor::COLUMN_CREATED_AT, '>=', $start)
            ->whereNotNull(LeadInvestor::COLUMN_ASSIGN_CALL)
            ->orderBy(LeadInvestor::COLUMN_ID, self::DESC)
            ->first();
    }

    public function getAll()
    {
        $model = $this->model->all();
        return $model;
    }

    public function find_phone($phone)
    {
        $model = $this->model;
        return $model->where(LeadInvestor::COLUMN_PHONE, '=', $phone)->get()->toArray();
    }

    public function update_missed_call($phone, $data = [])
    {
        $model = $this->model->where(LeadInvestor::COLUMN_PHONE, '=', $phone);
        if ($model) {
            $model->update($data);
            return true;
        }
        return false;
    }

    public function total_excel_call_lead($filter)
    {
        $model = $this->model;
        if (isset($filter['fdate']) && isset($filter['tdate'])) {
            $fdate = $filter['fdate'] . ' 00:00:00';
            $tdate = $filter['tdate'] . ' 23:59:59';
            $model = $model->whereBetween(LeadInvestor::COLUMN_CREATED_AT, [$fdate, $tdate]);
        }
        $model = $model->count();
        return $model;
    }

    public function excel_call_lead_v2($filter)
    {
        $user = DB::table('lead_investor')
            ->leftJoin('call', 'lead_investor.id', '=', 'call.lead_investor_id')
            ->leftJoin('user', 'lead_investor.assign_call', '=', 'user.id')
            ->select('lead_investor.*',
                'call.status as call_status',
                'call.note as note_cancel',
                'call.call_note',
                'call.updated_at as call_updated_at',
                'user.email as user_call');

        if (isset($filter['fdate']) && isset($filter['tdate'])) {
            $fdate = $filter['fdate'] . ' 00:00:00';
            $tdate = $filter['tdate'] . ' 23:59:59';
            $user = $user
                ->whereBetween('lead_investor.created_at', [$fdate, $tdate]);
        }
        $user = $user
            ->orderBy('lead_investor.created_at', self::DESC)
            ->get();
        return $user;
    }

    public function lead_import_vbee()
    {
        //$curenTime = Carbon::now()->subDay(1)->format("Y-m-d");
        $curenTime = strtotime(trim(date("Y-m-d", time()) . "00:00:00"));;
        $result = $this->model
            ->where(LeadInvestor::COLUMN_LEAD_STATUS, LeadInvestor::COLUMN_LEAD_STATUS_BLOCK)
            ->where(function ($query) use ($curenTime) {
                return $query->whereNull(LeadInvestor::COLUMN_SCAN_DATE)
                    ->orWhere(LeadInvestor::COLUMN_SCAN_DATE, '!=', $curenTime);
            })
            ->where(function ($query) {
                return $query->whereIn(LeadInvestor::COLUMN_DAY_CALL, [1, 2, 3])
                    ->orWhere(function ($sub) {
                        return $sub->whereNull(LeadInvestor::COLUMN_DAY_CALL);
                    });
            })
            ->get()->toArray();
        return $result;
    }

    public function find_one_check_phone($phone)
    {
        $result = $this->model->where([
            LeadInvestor::COLUMN_PHONE => $phone
        ])->get()->toArray();

        return $result;
    }

    public function find_call_id($request)
    {
        $result = $this->model->where([LeadInvestor::COLUMN_CALL_ID => $request[LeadInvestor::COLUMN_CALL_ID]])->first();
        return $result;
    }

}
