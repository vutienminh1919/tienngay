<?php


namespace App\Repository;


use App\Http\Controllers\ContractController;
use App\Models\Contract;
use App\Models\Investor;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ContractRepository extends BaseRepository implements ContractRepositoryInterface
{
    public function getModel()
    {
        return Contract::class;
    }

    public function get_contract_investor_app($condition, $offset, $limit)
    {
        $query = $this->model;
        if (isset($condition['start']) && isset($condition['end'])) {
            $query = $query->whereBetween(Contract::COLUMN_CREATED_AT, [$condition['start'], $condition['end']]);
        }
        if (isset($condition['minLoan']) && isset($condition['maxLoan'])) {
            $query = $query->whereBetween(Contract::COLUMN_INVESTMENT_AMOUNT, [$condition['minLoan'], $condition['maxLoan']]);
        }
        if (isset($condition['text'])) {
            $query = $query->where(Contract::COLUMN_AMOUNT_MONEY, $condition['text']);
        }
        if (!empty($condition['option'])) {
            $query = $query->where(Contract::COLUMN_STATUS_CONTRACT, (int)$condition['option']);
        }

        if (!empty($condition['type_interest'])) {
            $query = $query->where(Contract::COLUMN_TYPE_INTEREST, $condition['type_interest']);
        }

        if (isset($condition['id'])) {
            $id = $condition['id'];
            $query = $query->where(function ($query) use ($id) {
                return $query->where(Contract::COLUMN_INVESTOR_ID, $id);
            });
        }

        $query = $query
            ->where(Contract::COLUMN_STATUS, Contract::SUCCESS)
            ->offset($offset)
            ->limit($limit)
            ->orderBy(Contract::COLUMN_CREATED_AT, self::DESC)
            ->get();
        return $query;
    }

    public function getContract($condition)
    {
        $query = $this->model;
        if (isset($condition['fdate']) && $condition['tdate']) {
            $fdate = $condition['fdate'] . ' 00:00:00';
            $tdate = $condition['tdate'] . ' 23:59:59';
            $query = $query->whereBetween(Contract::COLUMN_CREATED_AT, [$fdate, $tdate]);
        }
        if (isset($condition['investor_code'])) {
            $investor_code = $condition['investor_code'];
            $query = $query->whereHas('investor', function ($query_contract) use ($investor_code) {
                $query_contract->where(Investor::COLUMN_NAME, 'LIKE', "%$investor_code%");
            });
        }
        if (isset($condition['code_contract'])) {
            $code_contract = $condition['code_contract'];
            $query = $query->where(Contract::COLUMN_CODE_CONTRACT_DISBURSEMENT, 'LIKE', "%$code_contract%")
                ->orWhere(Contract::COLUMN_CODE_CONTRACT, 'LIKE', "%$code_contract%");
        }

        if (isset($condition['status'])) {
            $query = $query->where(Contract::COLUMN_STATUS_CONTRACT, (int)$condition['status']);
        }

        if (isset($condition['type'])) {
            $query = $query->where(Contract::COLUMN_TYPE_CONTRACT, Contract::HOP_DONG_UY_QUYEN);
        } else {
            $query = $query->where(Contract::COLUMN_TYPE_CONTRACT, Contract::HOP_DONG_DAU_TU_APP);
        }
        $query = $query
            ->orderBy(Contract::COLUMN_CREATED_AT, self::DESC)
            ->paginate(100);
        return $query;
    }

    public function findCode($code)
    {
        return $this->model
            ->where(function ($query) use ($code) {
                return $query->where(Contract::COLUMN_CODE_CONTRACT, $code);
            })
            ->first();
    }

    public function financial_report_contract($condition)
    {
        $id = $condition['id'];
        return $this->model
            ->where(function ($query) use ($id) {
                return $query->where(Contract::COLUMN_INVESTOR_ID, $id);
            })
            ->whereBetween(Contract::COLUMN_CREATED_AT, [$condition['start'], $condition['end']])
            ->get();
    }

    public function find_interest_paginate($interest_id)
    {
        return $this->model
            ->where(Contract::COLUMN_INTEREST_ID, $interest_id)
            ->orderBy(Contract::COLUMN_CREATED_AT, self::DESC)
            ->paginate();
    }

    public function getAllContract($condition)
    {
        $query = $this->model;
        if (isset($condition['fdate']) && $condition['tdate']) {
            $fdate = $condition['fdate'] . ' 00:00:00';
            $tdate = $condition['tdate'] . ' 23:59:59';
            $query = $query->whereBetween(Contract::COLUMN_CREATED_AT, [$fdate, $tdate]);
        }
        if (isset($condition['code_contract'])) {
            $code_contract = $condition['code_contract'];
            $query = $query->where(Contract::COLUMN_CODE_CONTRACT_DISBURSEMENT, 'LIKE', "%$code_contract%")
                ->orWhere(Contract::COLUMN_CODE_CONTRACT, 'LIKE', "%$code_contract%");
        }
        if (isset($condition['investor_code'])) {
            $investor_code = $condition['investor_code'];
            $query = $query->whereHas('investor', function ($query_contract) use ($investor_code) {
                $query_contract->where(Investor::COLUMN_NAME, 'LIKE', "%$investor_code%");
            });
        }
        if (isset($condition['type'])) {
            $query = $query->where(Contract::COLUMN_TYPE_CONTRACT, Contract::HOP_DONG_UY_QUYEN);
        } else {
            $query = $query->where(Contract::COLUMN_TYPE_CONTRACT, Contract::HOP_DONG_DAU_TU_APP);
        }
        $query = $query
            ->orderBy(Contract::COLUMN_CREATED_AT, self::DESC)
            ->get();
        return $query;
    }

    public function getSumNdtByTelesales($telesales = '', $from_date, $to_date)
    {
        $model = $this->model;
        $model = $model->whereBetween(Contract::COLUMN_CREATED_AT, [$from_date, $to_date]);
        $model = $model->whereHas('investor', function ($query_build) use ($telesales) {
            $query_build->where(Investor::COLUMN_ASSIGN_CALL, $telesales);
        });

        return $model->sum(Contract::COLUMN_AMOUNT_MONEY);
    }

    public function get_contract_to_check_status()
    {
        $model = $this->model;
        $model = $model
            ->where(Contract::COLUMN_STATUS, Contract::SUCCESS)
            ->where(Contract::COLUMN_STATUS_CONTRACT, Contract::EFFECT)
            ->orderBy(Contract::COLUMN_CREATED_AT, self::ASC)
            ->get();
        return $model;
    }

    public function get_contract_by_referral($request, $investor_id)
    {
        $fdate = !empty($request->fdate) ? $request->fdate : date('Y-m-01 00:00:00');
        $tdate = !empty($request->tdate) ? $request->tdate : date('Y-m-d 23:59:59');

        $query = DB::table('contract')
            ->where(Contract::COLUMN_INVESTOR_ID, $investor_id)
            ->whereBetween(Contract::COLUMN_CREATED_AT, [$fdate, $tdate])
            ->where(Contract::COLUMN_TYPE_CONTRACT, Contract::HOP_DONG_DAU_TU_APP)
            ->where(Contract::COLUMN_STATUS, Contract::SUCCESS)
            ->selectRaw('sum(contract.investment_amount) as total_invest')
            ->first();
        return $query;

    }

    public function get_all_contract_by_referral($request, $user_id)
    {
        $fdate = !empty($request->fdate) ? $request->fdate : date('Y-m-01 00:00:00');
        $tdate = !empty($request->tdate) ? $request->tdate : date('Y-m-d 23:59:59');

        $query = DB::table('user')
            ->where(User::REFERRAL_ID, $user_id)
            ->join('investor', 'user.id', '=', 'investor.user_id')
            ->join('contract', 'investor.id', '=', 'contract.investor_id')
            ->whereBetween('contract.created_at', [$fdate, $tdate])
            ->where('contract.type_contract', Contract::HOP_DONG_DAU_TU_APP)
            ->where('contract.status', Contract::SUCCESS)
            ->selectRaw('sum(contract.investment_amount) as total_invest')
            ->first();
        return $query;

    }

    public function get_contract_commission_by_user($user_id, $request)
    {
        $query = DB::table('user')
            ->join('investor', 'user.id', '=', 'investor.user_id')
            ->join('contract', 'investor.id', '=', 'contract.investor_id')
            ->whereBetween('contract.created_at', [$request->fdate, $request->tdate])
            ->where('contract.type_contract', Contract::HOP_DONG_DAU_TU_APP)
            ->where('contract.status', Contract::SUCCESS)
            ->join('transaction', 'contract.id', '=', 'transaction.contract_id')
            ->where('transaction.type', Transaction::DAU_TU)
            ->where('user.id', $user_id)
            ->select('contract.*', 'investor.name as name_investor', 'transaction.transaction_vimo', 'transaction.trading_code')
            ->get();

        return $query;
    }


    public function get_all_commission($request)
    {
        $query = DB::table('contract')
            ->whereBetween('contract.created_at', [$request->fdate, $request->tdate])
            ->where('contract.type_contract', Contract::HOP_DONG_DAU_TU_APP)
            ->where('contract.status', Contract::SUCCESS)
            ->join('investor', 'contract.investor_id', '=', 'investor.id')
            ->join('user', 'investor.user_id', '=', 'user.id')
            ->whereNotNull('user.referral_id')
            ->selectRaw('sum(contract.investment_amount) as total_invest, user.referral_id')
            ->groupBy('user.referral_id')
            ->paginate(30);
        return $query;
    }

    public function contract_by_user($investor_id, $query)
    {
        $model = DB::table('contract')
            ->where('contract.investor_id', $investor_id)
            ->where('contract.type_contract', Contract::HOP_DONG_DAU_TU_APP)
            ->where('contract.status', Contract::SUCCESS);

        if ($query == 'count') {
            $model = $model->count();
        } else {
            $model = $model->sum('contract.investment_amount');
        }
        return $model;
    }

    public function getALlActive_v2($investor_id)
    {
        $query = DB::table('contract')
            ->where('contract.investor_id', $investor_id)
            ->where('contract.type_contract', Contract::HOP_DONG_DAU_TU_APP)
            ->selectRaw('sum(contract.investment_amount) as total_invest, count(*) as total_contract')
            ->first();
        return $query;
    }

    public function get_contract_by_promotions($fdate, $tdate)
    {
        if (!empty($fdate) && !empty($tdate)) {
            $query = DB::table('contract')
                ->where('contract.number_day_loan', '>', 30)
                ->whereBetween('contract.created_at', [$fdate, $tdate])
                ->where('contract.type_contract', Contract::HOP_DONG_DAU_TU_APP)
                ->where('contract.status', Contract::SUCCESS)
                ->join('investor', 'contract.investor_id', '=', 'investor.id')
                ->selectRaw('sum(contract.investment_amount) as total_invest, contract.investor_id, investor.name, investor.email, investor.phone_number, investor.identity, investor.city')
                ->groupBy('contract.investor_id')
                ->get();
            return $query;
        }
    }

    public function get_contract_by_user($investor_id, $flag)
    {
        $query = DB::table('contract')
            ->where('contract.investor_id', $investor_id)
            ->where('contract.type_contract', Contract::HOP_DONG_DAU_TU_APP);
        if ($flag == 'sum') {
            $query = $query->sum('contract.investment_amount');
        } elseif ($flag == 'count') {
            $query = $query->count('contract.investment_amount');
        } else {
            $query = $query->pluck('contract.investment_amount')->toArray();
        }
        return $query;
    }

    public function find_contract($code_contract)
    {
        $model = $this->model;
        $model = $model->where(function ($query) use ($code_contract) {
            return $query->where(Contract::COLUMN_CODE_CONTRACT, $code_contract)
                ->orWhere(Contract::COLUMN_CODE_CONTRACT_DISBURSEMENT, $code_contract);
        });
        return $model->first();
    }

    public function get_all_contract_by_referral_v2($request, $user_id)
    {
        $fdate = !empty($request->fdate) ? $request->fdate : date('Y-m-01 00:00:00');
        $tdate = !empty($request->tdate) ? $request->tdate : date('Y-m-d 23:59:59');
        $query = DB::table('user')
            ->where(User::REFERRAL_ID, $user_id)
            ->join('investor', 'user.id', '=', 'investor.user_id')
            ->join('contract', 'investor.id', '=', 'contract.investor_id')
            ->where('contract.type_contract', Contract::HOP_DONG_DAU_TU_APP)
            ->where('contract.status', Contract::SUCCESS)
            ->whereBetween('contract.start_date', [strtotime('2023-01-01'), strtotime($tdate)])
            ->where(function ($sub) use ($fdate, $tdate) {
                return $sub->whereBetween('contract.due_date', [strtotime($fdate), strtotime($tdate)])
                    ->orWhere('contract.due_date', '>=', strtotime($tdate));
            })
            ->select('contract.*', 'investor.name', 'user.id as user_id');
        return $query->get();

    }

    public function all_commission_v1($request)
    {
        echo $request->fdate;
        $query = DB::table('contract')
            ->whereBetween('contract.created_at', [$request->fdate, $request->tdate])
            ->where('contract.type_contract', Contract::HOP_DONG_DAU_TU_APP)
            ->where('contract.status', Contract::SUCCESS)
            ->join('investor', 'contract.investor_id', '=', 'investor.id')
            ->join('user', 'investor.user_id', '=', 'user.id')
            ->whereNotNull('user.referral_id')
            ->selectRaw('sum(contract.investment_amount) as total_invest, user.referral_id')
            ->groupBy('user.referral_id')
            ->get();
        return $query;
    }

    public function excel_all_contract($condition)
    {
        $query = DB::table('pay')
            ->join('contract', 'pay.contract_id', '=', 'contract.id');

        if (!empty($condition['fdate']) && !empty($condition['tdate'])) {
            $fdate = $condition['fdate'] . ' 00:00:00';
            $tdate = $condition['tdate'] . ' 23:59:59';
            $query = $query->whereBetween('contract.created_at', [$fdate, $tdate]);
        }

        if (!empty($condition['code_contract'])) {
            $code_contract = $condition['code_contract'];
            $query = $query->where(function ($query) use ($code_contract) {
                $query->where('contract.code_contract_disbursement', 'LIKE', "%$code_contract%")
                    ->orWhere('contract.code_contract', 'LIKE', "%$code_contract%");
            });
        }

        if (!empty($condition['status'])) {
            $query = $query->where('contract.status_contract', (int)$condition['status']);
        }

        if (!empty($condition['type'])) {
            $query = $query->where('contract.type_contract', Contract::HOP_DONG_UY_QUYEN);
        } else {
            $query = $query->where('contract.type_contract', Contract::HOP_DONG_DAU_TU_APP);
        }

        $query = $query->selectRaw('sum(pay.lai_ky) as tong_lai, contract.*, count(*) as tong_ky');
        $query = $query
            ->groupBy('contract.id')
            ->orderBy('contract.created_at', self::DESC)
            ->get();
        return $query;
    }

    public function excel_contract($contract_id, $status)
    {
        $query = DB::table('pay')
            ->where('pay.contract_id', $contract_id)
            ->where('pay.status', $status)
            ->selectRaw('count(*) as da_tra, sum(pay.lai_ky) as lai_da_tra, sum(pay.tien_goc_1ky_phai_tra) as goc_da_tra')
            ->first();
        return $query;
    }

    public function report_contract($request)
    {
        $month = $request->month ?? date('Y-m');
        $start_date = Carbon::parse($month)->startOfMonth()->unix();
        $end_date = Carbon::parse($month)->endOfMonth()->unix();
        $type_contract = $request->type_contract ?? Contract::HOP_DONG_UY_QUYEN;
        $query = DB::table('contract')
            ->where(function ($sub) use ($start_date, $end_date) {
                return $sub->whereBetween('contract.due_date', [$start_date, $end_date])
                    ->orWhere('contract.due_date', ">=", $end_date);
            })
            ->where('contract.type_contract', $type_contract)
            ->join('investor', 'contract.investor_id', "=", 'investor.id')
            ->select('contract.*', 'investor.name')
            ->orderByDesc('contract.created_at');

        if ($request->action == 'paginate') {
            $query = $query->paginate(30);
        } elseif ($request->action == 'get') {
            $query = $query->get();
        } else {
            $query = $query->count();
        }
        return $query;
    }

    public function report_contract_uq($request)
    {
        $month = $request->month ?? date('Y-m');
        $start_date = Carbon::parse($month)->startOfMonth()->format('Y-m-d');
        $end_date = Carbon::parse($month)->endOfMonth()->format('Y-m-d');

        $query = DB::table('contract')
            ->where('contract.start_date', '<=', strtotime($start_date))
            ->where(function ($sub) use ($start_date, $end_date) {
                return $sub->where('contract.date_expire', ">=", strtotime($start_date))
                    ->orWhere(function ($subQuery) {
                        return $subQuery->where('contract.status_contract', Contract::EFFECT);
                    });
            })
            ->where('contract.type_contract', Contract::HOP_DONG_UY_QUYEN)
            ->join('investor', 'contract.investor_id', "=", 'investor.id')
            ->join('transaction', 'transaction.contract_id', "=", 'contract.id');

        if (!empty($request->full_name)) {
            $name = $request->full_name;
            $query = $query->where('investor.name', 'LIKE', "%$name%");
        }

        $query = $query->selectRaw("contract.*,
                investor.name as investor_name,
                SUM(CASE
                        WHEN transaction.type = 2
                        THEN transaction.tien_goc
                        ELSE 0
                    END) AS goc_da_tra,
                SUM(CASE
                        WHEN transaction.type = 2
                        THEN transaction.tien_lai
                        ELSE 0
                    END) AS lai_da_tra,
                SUM(CASE
                        WHEN transaction.type = 2 AND DATE_FORMAT(FROM_UNIXTIME(transaction.date_pay), '%Y-%m-%d') <= '$end_date'
                        THEN transaction.tien_lai
                        ELSE 0
                    END) AS lai_da_tra_toi_ngay_bao_cao
            ")
            ->groupBy(['investor.name', 'contract.id'])
            ->orderByDesc('contract.created_at');
        if ($request->action == 'paginate') {
            $query = $query->paginate(30);
        } elseif ($request->action == 'get') {
            $query = $query->get();
        }
        return $query;
    }

    public function get_contract_paginate($condition)
    {
        $query = DB::table('contract')
            ->join('investor', 'contract.investor_id', '=', 'investor.id')
            ->join('pay', 'contract.id', '=', 'pay.contract_id');

        if (!empty($condition['fdate']) && $condition['tdate']) {
            $fdate = $condition['fdate'] . ' 00:00:00';
            $tdate = $condition['tdate'] . ' 23:59:59';
            $query = $query->whereBetween('contract.created_at', [$fdate, $tdate]);
        }

        if (!empty($condition['code_contract'])) {
            $code_contract = $condition['code_contract'];
            $query = $query->where('contract.code_contract_disbursement', 'LIKE', "%$code_contract%")
                ->orWhere('contract.code_contract', 'LIKE', "%$code_contract%");
        }

        if (!empty($condition['status'])) {
            $query = $query->where('contract.status_contract', (int)$condition['status']);
        }

        if (!empty($condition['investor_code'])) {
            $name = $condition['investor_code'];
            $query = $query->where('investor.name', 'LIKE', "%$name%");
        }

        if (!empty($condition['type'])) {
            $query = $query->where('contract.type_contract', Contract::HOP_DONG_UY_QUYEN);
        } else {
            $query = $query->where('contract.type_contract', Contract::HOP_DONG_DAU_TU_APP);
        }

        $query = $query
            ->selectRaw('investor.name as investor_name,
            contract.*,
            COUNT(pay.id) as tong_ky_tra,
            SUM(pay.lai_ky) as tong_lai,
            SUM(CASE
                    WHEN pay.status = 2
                    THEN 1
                    ELSE 0
                END) AS da_thanh_toan,
            SUM(CASE
                    WHEN pay.status = 2
                    THEN pay.tien_goc_1ky_phai_tra
                    ELSE 0
                 END) AS goc_da_tra,
            SUM(CASE
                    WHEN pay.status = 2
                    THEN pay.tien_lai_1ky_phai_tra
                    ELSE 0
                END) AS lai_da_tra
            ')
            ->groupBy(['investor.name', 'contract.id'])
            ->orderBy('contract.created_at', self::DESC);
        if ($condition['action'] == 'excel') {
            $query = $query->get();
        } else {
            $query = $query->paginate(30);
        }

        return $query;

    }
}
