<?php

namespace App\Repository;


use App\Models\Call;
use App\Models\Investor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Contract;
use App\Repository\ContractRepository;

class InvestorRepository extends BaseRepository implements InvestorRepositoryInterface
{
    const AFTER_7_DAYS = 7;
    const AFTER_15_DAYS = 15;
    const AFTER_30_DAYS = 30;

    public function getModel()
    {
        return Investor::class;
    }

    public function getInfoInvestor($phone)
    {
        return $this->model
            ->where(function ($query) use ($phone) {
                return $query->where(Investor::COLUMN_PHONE_NUMBER, $phone);
            })
            ->first();
    }

    public function getListNewPaginate($filter, $per_page = 15)
    {
        $model = $this->model;

        if (!empty($filter['start_date']) && isset($filter['end_date'])) {
            $model = $model->whereBetween(Investor::CREATED_AT, [$filter['start_date'], $filter['end_date']]);
        }

        if (!empty($filter['find_call_assign'])) {
            $find_call_assign = $filter['find_call_assign'];
            $model = $model->where(Investor::COLUMN_ASSIGN_CALL, $find_call_assign);
        }
        if (!empty($filter['assign_call'])) {
            $model = $model->where(Investor::COLUMN_ASSIGN_CALL, $filter['assign_call']);
        }
        if (!empty($filter['name'])) {
            $name = $filter['name'];
            $model = $model->where(Investor::COLUMN_NAME, 'LIKE', "%$name%");
        }
        if (!empty($filter['phone'])) {
            $phone = $filter['phone'];
            $model = $model->where(Investor::COLUMN_PHONE_NUMBER, 'LIKE', "%$phone%");
        }
        if (!empty($filter['email'])) {
            $email = $filter['email'];
            $model = $model->where(Investor::COLUMN_EMAIL, 'LIKE', "%$email%");
        }
        if (!empty($filter['status_call'])) {
            $status_call = $filter['status_call'];
            if ($status_call == 100) {
                $model = $model->whereNull(Investor::COLUMN_STATUS_CALL);
            } else {
                $model = $model->whereHas('call', function ($query_call) use ($status_call) {
                    $query_call->where(Call::COLUMN_STATUS, (int)$status_call);
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
        $model = $model->whereHas('user', function ($query_build) {
            $query_build->where('type', User::TYPE_NHA_DAU_TU_APP);
            $query_build->where('status', User::STATUS_ACTIVE);
        });
        $model = $model->where(Investor::COLUMN_STATUS, Investor::STATUS_NEW);
        $model = $model->orderBy(Investor::COLUMN_STATUS, self::DESC);
        $model = $model->orderBy(Investor::COLUMN_CREATED_AT, self::DESC);
        $model = $model->paginate($per_page);
        return $model;
    }

    public function getListPaginate($filter)
    {
        $model = $this->model;
        if (isset($filter['find_call_assign'])) {
            $find_call_assign = $filter['find_call_assign'];
            $model = $model->where(Investor::COLUMN_ASSIGN_CALL, $find_call_assign);
        }
        if (isset($filter['assign_call'])) {
            $model = $model->where(Investor::COLUMN_ASSIGN_CALL, $filter['assign_call']);
        }
        if (isset($filter['name'])) {
            $name = $filter['name'];
            $model = $model->where(Investor::COLUMN_NAME, 'LIKE', "%$name%");
        }
        if (!empty($filter['phone'])) {
            $phone = $filter['phone'];
            $model = $model->where(Investor::COLUMN_PHONE_NUMBER, 'LIKE', "%$phone%");
        }
        if (!empty($filter['email'])) {
            $email = $filter['email'];
            $model = $model->where(Investor::COLUMN_EMAIL, 'LIKE', "%$email%");
        }
        if (!empty($filter['status_call'])) {
            $status_call = $filter['status_call'];
            if ($status_call == 100) {
                $model = $model->whereNull(Investor::COLUMN_STATUS_CALL);
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
        if (!empty($filter['investment_status'])) {
            $investment_status = $filter['investment_status'];
            $model = $model->where(Investor::COLUMN_INVESTMENT_STATUS, $investment_status);
        }
        $model = $model->whereHas('user', function ($query) {
            $query->where('type', User::TYPE_NHA_DAU_TU_APP);
        });
        return $model
            ->where(Investor::COLUMN_STATUS, Investor::STATUS_ACTIVE)
            ->orderBy(Investor::COLUMN_ACTIVE_AT, self::DESC)
            ->paginate(10);
    }

    public function findConfirmNew($id)
    {
        $model = $this->model;
        $model = $model->where(Investor::COLUMN_ID, $id);
        $model = $model->where(function ($query) {
            $query = $query->where(Investor::COLUMN_STATUS, Investor::STATUS_NEW);
            $query = $query->orWhere(Investor::COLUMN_STATUS, Investor::STATUS_BLOCK);
            return $query;
        });
        $model = $model->first();
        return $model;
    }

    public function findInvestor($id)
    {
        $model = $this->model;
        $model = $model->where(Investor::COLUMN_ID, $id);
        $model = $model->where(function ($query) {
            $query = $query->where(Investor::COLUMN_STATUS, Investor::STATUS_ACTIVE);
            $query = $query->orWhere(Investor::COLUMN_STATUS, Investor::STATUS_DEACTIVE);
            return $query;
        });
        $model = $model->first();
        return $model;
    }

    public function find_identity($identity)
    {
        return $this->model
            ->where(function ($query) use ($identity) {
                return $query->where(Investor::COLUMN_IDENTITY, $identity);
            })
            ->first();
    }

    public function findCode($code)
    {
        return $this->model
            ->where(function ($query) use ($code) {
                return $query->where(Investor::COLUMN_CODE, $code);
            })
            ->where(Investor::COLUMN_STATUS, Investor::STATUS_ACTIVE)
            ->first();
    }


    public function getListNdtUyQuyenPaginate($filter)
    {
        $model = $this->model;
        if (isset($filter['name'])) {
            $name = $filter['name'];
            $model = $model->where(Investor::COLUMN_NAME, 'LIKE', "%$name%");
        }
        if (isset($filter['phone'])) {
            $phone = $filter['phone'];
            $model = $model->where(Investor::COLUMN_PHONE_NUMBER, 'LIKE', "%$phone%");
        }
        if (isset($filter['email'])) {
            $email = $filter['email'];
            $model = $model->where(Investor::COLUMN_EMAIL, 'LIKE', "%$email%");
        }
        $model = $model->whereHas('user', function ($query_build) {
            $query_build->where('type', User::TYPE_NHA_DAU_TU_UY_QUYEN);
        });
        return $model
            ->orderBy(Investor::COLUMN_CREATED_AT, self::DESC)
            ->paginate();
    }

    public function getALlActive()
    {
        $model = $this->model;
        $type = User::TYPE_NHA_DAU_TU_APP;
        $model = $model->whereHas('user', function ($query) use ($type) {
            $query->where('type', $type);
        });
        return $model
            ->where(Investor::COLUMN_STATUS, Investor::STATUS_ACTIVE)
            ->orderBy(Investor::COLUMN_ACTIVE_AT, self::DESC)
            ->get();
    }

    public function getAllListNew($filter)
    {
        $model = $this->model;
        $model = $model->whereHas('user', function ($query_build) {
            $query_build->where('type', User::TYPE_NHA_DAU_TU_APP);
        });
        if (isset($filter['fdate']) && isset($filter['tdate'])) {
            $fdate = $filter['fdate'] . ' 00:00:00';
            $tdate = $filter['tdate'] . ' 23:59:59';
            $model = $model->whereBetween(Investor::COLUMN_CREATED_AT, [$fdate, $tdate]);
        }
        $model = $model->orderBy(Investor::COLUMN_CREATED_AT, self::DESC);
        $model = $model->get();
        return $model;
    }

    public function get_investor_different_active()
    {
        $model = $this->model;
        $model = $model->whereHas('user', function ($query_build) {
            $query_build->where('type', User::TYPE_NHA_DAU_TU_APP);
        });
        return $model->whereNotIn(Investor::COLUMN_STATUS, [Investor::STATUS_ACTIVE])
            ->orderBy(Investor::COLUMN_CREATED_AT, self::DESC)
            ->get();
    }

    public function get_investor_active()
    {
        $model = $this->model;
        $model = $model->whereHas('user', function ($query_build) {
            $query_build->where('type', User::TYPE_NHA_DAU_TU_APP);
        });
        return $model->where(Investor::COLUMN_STATUS, Investor::STATUS_ACTIVE)
            ->where(Investor::COLUMN_INVESTMENT_STATUS, Investor::CHUA_DAU_TU)
            ->orWhereNull(Investor::COLUMN_INVESTMENT_STATUS)
            ->orderBy(Investor::COLUMN_CREATED_AT, self::DESC)
            ->get();
    }

    public function get_investor_null_assign()
    {
        $date = date('Y-m-d 17:30:00');
        $model = $this->model;
        return $model->whereNull(Investor::COLUMN_ASSIGN_CALL)
            ->where(Investor::COLUMN_CREATED_AT, '<=', $date)
            ->orderBy(Investor::COLUMN_ID, self::ASC)
            ->get();
    }

    public function findLastLead()
    {
        $model = $this->model;
        return $model->whereNotNull(Investor::COLUMN_ASSIGN_CALL)
            ->orderBy(Investor::COLUMN_ID, self::DESC)
            ->first();
    }

    public function get_list_null_type_interest_receving()
    {
        $model = $this->model;
        $model = $model
            ->where(Investor::COLUMN_STATUS, Investor::STATUS_ACTIVE)
            ->where(Investor::COLUMN_INVESTMENT_STATUS, Investor::DA_DAU_TU)
            ->whereNull(Investor::COLUMN_TYPE_INTEREST_RECEIVING_ACCOUNT)
            ->whereNotNull(Investor::COLUMN_PHONE_VIMO);
        return $model->get();
    }

    public function get_investor_active_assign_call()
    {
        $model = $this->model;
        $model = $model->whereHas('user', function ($query_build) {
            $query_build->where('type', User::TYPE_NHA_DAU_TU_APP);
        });
        return $model->where(Investor::COLUMN_STATUS, Investor::STATUS_ACTIVE)
            ->whereNull(Investor::COLUMN_INVESTMENT_STATUS)
            ->orderBy(Investor::COLUMN_CREATED_AT, self::DESC)
            ->get();
    }

    public function get_investor_no_process()
    {
        $model = $this->model;
        $model = $model->whereHas('user', function ($query_build) {
            $query_build->where('type', User::TYPE_NHA_DAU_TU_APP);
        });
        return $model
            ->whereIn(Investor::COLUMN_STATUS_CALL, Investor::STATUS_CALL_BACKLOG)
            ->orderBy(Investor::COLUMN_CREATED_AT, self::DESC)
            ->get();
    }

    public function assign_call_investor_active()
    {
        $model = $this->model;
        $model = $model->whereHas('user', function ($query_build) {
            $query_build->where('type', User::TYPE_NHA_DAU_TU_APP);
        });
        return $model
            ->whereIn(Investor::COLUMN_STATUS, [Investor::STATUS_ACTIVE, Investor::STATUS_BLOCK])
//            ->whereIn(Investor::COLUMN_STATUS_CALL, [11, 12, 13, 14])
            ->orderBy(Investor::COLUMN_CREATED_AT, self::DESC)
            ->get();
    }

    public function get_investor_send_mkt()
    {
        $model = $this->model;
        $model = $model->whereHas('user', function ($query_build) {
            $query_build->where('type', User::TYPE_NHA_DAU_TU_APP);
        });
        return $model
            ->where(Investor::COLUMN_STATUS, Investor::STATUS_ACTIVE)
            ->orderBy(Investor::COLUMN_CREATED_AT, self::DESC)
            ->get();
    }

    public function getCountListNewPaginate($filter)
    {
        $model = $this->model;

        if (isset($filter['start_date']) && isset($filter['end_date'])) {
            $model = $model->whereBetween(Investor::CREATED_AT, [$filter['start_date'], $filter['end_date']]);
        }

        if (isset($filter['find_call_assign'])) {
            $find_call_assign = $filter['find_call_assign'];
            $model = $model->where(Investor::COLUMN_ASSIGN_CALL, $find_call_assign);
        }
        if (isset($filter['assign_call'])) {
            $model = $model->where(Investor::COLUMN_ASSIGN_CALL, $filter['assign_call']);
        }
        if (isset($filter['phone'])) {
            $phone = $filter['phone'];
            $model = $model->where(Investor::COLUMN_PHONE_NUMBER, 'LIKE', "%$phone%");
        }
        if (isset($filter['email'])) {
            $email = $filter['email'];
            $model = $model->where(Investor::COLUMN_EMAIL, 'LIKE', "%$email%");
        }
        if (isset($filter['status_call'])) {
            $status_call = $filter['status_call'];
            if ($status_call == 100) {
                $model = $model->whereNull(Investor::COLUMN_STATUS_CALL);
            } else {
                $model = $model->whereHas('call', function ($query_call) use ($status_call) {
                    $query_call->where(Call::COLUMN_STATUS, (int)$status_call);
                });
            }
        }
        $model = $model->whereHas('user', function ($query_build) {
            $query_build->where('type', User::TYPE_NHA_DAU_TU_APP);
            $query_build->where('status', User::STATUS_ACTIVE);
        });
        $model = $model->where(Investor::COLUMN_STATUS, Investor::STATUS_NEW);
        $model = $model->orderBy(Investor::COLUMN_STATUS, self::DESC);
        $model = $model->orderBy(Investor::COLUMN_CREATED_AT, self::DESC);
        $model = $model->count();
        return $model;
    }

    public function excel_getAllListNew($filter)
    {
        $user = DB::table('user')
            ->join('investor', 'user.id', '=', 'investor.user_id')
            ->where('user.type', User::TYPE_NHA_DAU_TU_APP)
            ->where('user.status', 'active')
            ->select('investor.*');

        if (isset($filter['fdate']) && isset($filter['tdate'])) {
            $fdate = $filter['fdate'] . ' 00:00:00';
            $tdate = $filter['tdate'] . ' 23:59:59';
            $user = $user
                ->whereBetween('investor.created_at', [$fdate, $tdate]);
        }
        $user = $user
            ->orderBy('investor.created_at', self::DESC)
            ->get();
        return $user;
    }

    public function getLeadNewInDay($from_date, $to_date, $telesales)
    {
        $model = $this->model;
        return $model
            ->whereBetween(Investor::COLUMN_TIME_ASSIGN_CALL, [$from_date, $to_date])
//            ->whereBetween(Investor::COLUMN_CREATED_AT, [$from_date, $to_date])
//            ->whereNotNull(Investor::COLUMN_TIME_ASSIGN_CALL)
            ->where(Investor::COLUMN_ASSIGN_CALL, $telesales)
            ->count();
    }

    public function getLeadBackLogToSave($end_current_day, $telesales)
    {
        $model = $this->model;
        $model = $model->where(Investor::COLUMN_TIME_ASSIGN_CALL, '<', $end_current_day);
        $model = $model->where(function ($query) {
            $query->whereIn(Investor::COLUMN_STATUS_CALL, Investor::STATUS_CALL_BACKLOG)
                ->orWhereNull(Investor::COLUMN_STATUS_CALL);
        });
        return $model
            ->whereNotNull(Investor::COLUMN_TIME_ASSIGN_CALL)
            ->where(Investor::COLUMN_ASSIGN_CALL, $telesales)
            ->count();
    }

    public function getLeadBackLogRealTime($from_date, $end_current_day, $telesales)
    {
        $model = $this->model;
        $model = $model->where(Investor::COLUMN_TIME_ASSIGN_CALL, '<', $end_current_day);
        $model = $model->where(function ($query) {
            $query->whereIn(Investor::COLUMN_STATUS_CALL, Investor::STATUS_CALL_BACKLOG)
                ->orWhereNull(Investor::COLUMN_STATUS_CALL);
        });
        return $model
            ->whereNotNull(Investor::COLUMN_TIME_ASSIGN_CALL)
            ->where(Investor::COLUMN_ASSIGN_CALL, $telesales)
            ->count();
    }

    public function getLeadInDayProcessed($from_date, $to_date, $telesales)
    {
        $model = $this->model;
        return $model
            ->whereNotNull(Investor::COLUMN_TIME_ASSIGN_CALL)
//            ->whereBetween(Investor::COLUMN_CREATED_AT, [$from_date, $to_date])
            ->whereBetween(Investor::COLUMN_TIME_ASSIGN_CALL, [$from_date, $to_date])
//            ->whereBetween(Investor::COLUMN_ACTIVE_AT, [$from_date, $to_date])
//            ->where(Investor::COLUMN_STATUS,Investor::STATUS_ACTIVE)
            ->whereIn(Investor::COLUMN_STATUS_CALL, array(11, 13))
            ->where(Investor::COLUMN_ASSIGN_CALL, $telesales)
            ->count();
    }

    public function getLeadNewActiveInday($from_date, $to_date, $telesales)
    {
        $model = $this->model;
        return $model
            ->whereNotNull(Investor::COLUMN_TIME_ASSIGN_CALL)
            ->whereBetween(Investor::COLUMN_ACTIVE_AT, [$from_date, $to_date])
            ->where(Investor::COLUMN_STATUS, Investor::STATUS_ACTIVE)
            ->where(Investor::COLUMN_STATUS_CALL, '=', 11)
            ->where(Investor::COLUMN_ASSIGN_CALL, $telesales)
            ->count();
    }

    public function getLeadNewActiveOld($end_current_day, $telesales)
    {
        $model = $this->model;
        $model = $model->whereNotNull(Investor::COLUMN_TIME_ASSIGN_CALL);
        return $model
            ->where(Investor::COLUMN_TIME_ASSIGN_CALL, '<', $end_current_day)
            ->where(Investor::COLUMN_STATUS_CALL, '=', 11)
            ->where(Investor::COLUMN_ASSIGN_CALL, $telesales)
            ->count();
    }

    public function getEmailTelesales($id_telesales)
    {
        $email = DB::table('user')
            ->join('investor', 'user.id', '=', 'investor.assign_call')
            ->where('user.id', '=', $id_telesales)
            ->first('user.email');
        $email_tls = '';
        if (!empty($email)) {
            $email_tls = $email->email;
        }
        return $email_tls;
    }

    public function getIdTelesales()
    {
        $user_telesales = DB::table('user')
            ->join('user_role', 'user.id', '=', 'user_role.user_id')
            ->where('role_id', '=', 5)
            ->get('user.id');
        $array_id_telesales = array();
        foreach ($user_telesales as $user_telesale) {
            array_push($array_id_telesales, $user_telesale->id);
        }
        return $array_id_telesales;
    }

    public function total_excel_call($filter)
    {
        $model = $this->model;
        $model = $model->whereHas('user', function ($query_build) {
            $query_build->where('type', User::TYPE_NHA_DAU_TU_APP);
        });
        if (isset($filter['fdate']) && isset($filter['tdate'])) {
            $fdate = $filter['fdate'] . ' 00:00:00';
            $tdate = $filter['tdate'] . ' 23:59:59';
            $model = $model->whereBetween(Investor::COLUMN_CREATED_AT, [$fdate, $tdate]);
        }
        $model = $model->count();
        return $model;
    }

    public function excel_call_v2($filter)
    {
        $user = DB::table('user as kh')
            ->join('investor', 'kh.id', '=', 'investor.user_id')
            ->leftJoin('call', 'investor.id', '=', 'call.investor_id')
            ->leftJoin('user as tls', 'investor.assign_call', '=', 'tls.id')
            ->where('kh.type', User::TYPE_NHA_DAU_TU_APP)
            ->where('kh.status', User::STATUS_ACTIVE)
            ->select('investor.name',
                'investor.id',
                'investor.phone_number',
                'investor.phone_vimo',
                'investor.status',
                'investor.phone_number',
                'investor.created_at',
                'call.status as call_status',
                'call.note as note_cancel',
                'call.call_note',
                'kh.source',
                'kh.referral_code',
                'call.updated_at as call_updated_at',
                'tls.email as user_call');

        if (isset($filter['fdate']) && isset($filter['tdate'])) {
            $fdate = $filter['fdate'] . ' 00:00:00';
            $tdate = $filter['tdate'] . ' 23:59:59';
            $user = $user
                ->whereBetween('investor.created_at', [$fdate, $tdate]);
        }
        $user = $user
            ->orderBy('investor.created_at', self::DESC)
            ->get();
        return $user;
    }

    public function getALlActive_v2()
    {
        $user = DB::table('user as kh')
            ->join('investor', 'kh.id', '=', 'investor.user_id')
            ->leftJoin('call', 'investor.id', '=', 'call.investor_id')
            ->leftJoin('user as tls', 'investor.assign_call', '=', 'tls.id')
            ->where('kh.type', User::TYPE_NHA_DAU_TU_APP)
            ->where('investor.status', User::STATUS_ACTIVE)
            ->leftJoin('contract', 'contract.investor_id', '=', 'investor.id')
            ->leftJoin('pay', 'pay.contract_id', '=', 'contract.id')
            ->select(['investor.id',
                'investor.name',
                'investor.phone_number',
                'investor.investment_status',
                'investor.birthday',
                'investor.active_at',
                'investor.city',
                'call.status as call_status',
                'call.note as note_cancel',
                'call.call_note',
                'call.updated_at as call_updated_at',
                'tls.email as user_call'])
            ->selectRaw('
            COUNT(DISTINCT contract.id) as total_contract,
            SUM(ROUND(pay.tien_goc_1ky)) as total_money_contract,
            SUM(CASE
                        WHEN pay.status = 1
                        THEN pay.tien_goc_1ky
                        ELSE 0
                END) AS goc_con_lai
            ')
            ->groupBy(['investor.id',
                'call_status',
                'note_cancel',
                'call.call_note',
                'call_updated_at',
                'user_call'
            ])
            ->orderBy('investor.created_at', self::DESC)
            ->get();
        return $user;

    }

    public function total_investor_activate_new_dash($condition)
    {
        $model = $this->model;
        $from_date = $condition['from_date'];
        $to_date = $condition['to_date'];
        return $model
            ->whereNotNull(Investor::COLUMN_TIME_ASSIGN_CALL)
            ->whereBetween(Investor::COLUMN_ACTIVE_AT, [$from_date, $to_date])
            ->where(Investor::COLUMN_STATUS, Investor::STATUS_ACTIVE)
            ->where(Investor::COLUMN_STATUS_CALL, '=', 11)
            ->count();
    }

    public function total_investor_activated_invested($condition)
    {
        $model = $this->model;
        $from_date = $condition['from_date'];
        $to_date = $condition['to_date'];
        return $model
            ->whereNotNull(Investor::COLUMN_TIME_ASSIGN_CALL)
            ->whereBetween(Investor::COLUMN_ACTIVE_AT, [$from_date, $to_date])
            ->where(Investor::COLUMN_STATUS, Investor::STATUS_ACTIVE)
            ->where(Investor::COLUMN_STATUS_CALL, '=', 11)
            ->where(Investor::COLUMN_INVESTMENT_STATUS, '=', Investor::DA_DAU_TU)
            ->count();
    }

    public function total_investor_activated_not_invested_yet($condition)
    {
        $model = $this->model;
        $from_date = $condition['from_date'];
        $to_date = $condition['to_date'];
        return $model
            ->whereNotNull(Investor::COLUMN_TIME_ASSIGN_CALL)
            ->whereBetween(Investor::COLUMN_ACTIVE_AT, [$from_date, $to_date])
            ->where(Investor::COLUMN_STATUS, Investor::STATUS_ACTIVE)
            ->where(Investor::COLUMN_STATUS_CALL, '=', 11)
            ->where(Investor::COLUMN_INVESTMENT_STATUS, '=', Investor::CHUA_DAU_TU)
            ->count();
    }

    public function identification($arr_id)
    {
        $model = $this->model;
        return $model->whereIn(Investor::COLUMN_ID, $arr_id)
            ->get();
    }

    public function list_v2($filter)
    {
        $user = DB::table('user as kh')
            ->where('kh.type', User::TYPE_NHA_DAU_TU_APP)
            ->join('investor', 'kh.id', '=', 'investor.user_id')
            ->where('investor.status', User::STATUS_ACTIVE)
            ->leftJoin('call', 'investor.id', '=', 'call.investor_id')
            ->leftJoin('user as tls', 'investor.assign_call', '=', 'tls.id');

        if (!empty($filter['email'])) {
            $user = $user->where('investor.email', $filter['email']);
        }

        if (!empty($filter['phone'])) {
            $user = $user->where('investor.phone_number', $filter['phone']);
        }

        if (!empty($filter['name'])) {
            $user = $user->where('investor.name', $filter['name']);
        }

        if (isset($filter['find_call_assign'])) {
            $find_call_assign = $filter['find_call_assign'];
            $user = $user->where('investor.assign_call', $find_call_assign);
        }

        if (isset($filter['assign_call'])) {
            $user = $user->where('investor.assign_call', $filter['assign_call']);
        }

        if (!empty($filter['investment_status'])) {
            $investment_status = $filter['investment_status'];
            $user = $user->where('investor.investment_status', $investment_status);
        }

        if (!empty($filter['status_call'])) {
            $status_call = $filter['status_call'];
            if ($status_call == 100) {
                $user = $user->whereNull('investor.status_call');
            } else {
                if ($status_call == 1) {
                    $user = $user->whereIn('investor.status_call', [1, 2, 3, 4, 5, 6, 7, 8, 9]);
                } else {
                    $user = $user->where('investor.status_call', (int)$status_call);
                }
            }
            if ($status_call == 13) {
                if (!empty($filter['note_delete'])) {
                    $node_delete = $filter['note_delete'];
                    $user = $user->where('call.note', $node_delete);
                }
            }
        }

        $user = $user->select('investor.id',
            'investor.name',
            'investor.phone_number',
            'investor.active_at',
            'investor.investment_status',
            'investor.assign_call',
            'call.status as call_status',
            'call.note as note_cancel',
            'call.call_note',
            'call.updated_at as call_updated_at',
            'kh.source as user_source',
            'kh.referral_code as referral_code',
            'tls.email as user_call',
            'tls.id as id_user_call'
        );

        if (!empty($filter['tab'])) {
            if ($filter['tab'] == 'not-investment') {
                $user = $user->where('investor.investment_status', Investor::CHUA_DAU_TU);
                if (!empty($filter['time_care'])) {
                    $date = $this->get_time_care($filter['time_care']);
                    if ($filter['time_care'] == self::AFTER_7_DAYS || $filter['time_care'] == self::AFTER_15_DAYS) {
                        $user = $user->whereBetween('investor.active_at', [$date['start'], $date['end']]);
                    } else {
                        $user = $user->where('investor.active_at', '<=', $date['start']);
                    }
                }
            } elseif ($filter['tab'] == 'expire') {
                $user = $user->where('investor.investment_status', Investor::DA_DAU_TU);
                $user_effect = $this->get_investor_contract_effect();
                $user = $user->whereNotIn('investor.id', $user_effect);
                if (!empty($filter['time_care'])) {
                    $date = $this->get_time_care($filter['time_care']);
                    $user = $user->leftJoin('contract', 'investor.id', '=', 'contract.investor_id');
                    if ($filter['time_care'] == self::AFTER_7_DAYS || $filter['time_care'] == self::AFTER_15_DAYS) {
                        $user = $user->whereBetween('contract.created_at', [$date['start'], $date['end']]);
                    } else {
                        $user = $user->where('contract.created_at', '<=', $date['start']);
                    }
                    $user = $user->groupBy([
                        'investor.id',
                        'call_status',
                        'note_cancel',
                        'call_note',
                        'call_updated_at'
                    ]);
                }
            }
        }
        $user = $user
            ->orderBy('investor.created_at', self::DESC)
            ->paginate(30);
        return $user;
    }

    public function get_investor_contract_effect()
    {
        return $result = DB::table('user')
            ->where('user.status', '=', User::STATUS_ACTIVE)
            ->join('investor', 'investor.user_id', '=', 'user.id')
            ->where('investor.status', '=', Investor::STATUS_ACTIVE)
            ->where('investor.investment_status', '=', Investor::DA_DAU_TU)
            ->join('contract', 'contract.investor_id', '=', 'investor.id')
            ->where('contract.status_contract', Contract::EFFECT)
            ->pluck('investor.id')
            ->toArray();
    }

    public function get_time_care($time)
    {
        $result = [];
        if ($time == self::AFTER_7_DAYS) {
            $result['start'] = Carbon::now()->subDays(14)->format('Y-m-d 00:00:00');
            $result['end'] = Carbon::now()->subDays(7)->format('Y-m-d 23:00:00');
        } elseif ($time == self::AFTER_15_DAYS) {
            $result['start'] = Carbon::now()->subDays(29)->format('Y-m-d 00:00:00');
            $result['end'] = Carbon::now()->subDays(15)->format('Y-m-d 23:00:00');
        } else {
            $result['start'] = Carbon::now()->subDays(30)->format('Y-m-d 00:00:00');
        }
        return $result;
    }

}
