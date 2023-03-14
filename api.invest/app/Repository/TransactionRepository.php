<?php

namespace App\Repository;

use App\Models\Contract;
use App\Models\Investor;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{
    /**
     * @return string
     */
    public function getModel()
    {
        return Transaction::class;
    }

    public function history_transaction_investor($condition, $limit, $offset)
    {
        $transaction = DB::table('investor')
            ->join('contract', 'investor.id', '=', 'contract.investor_id')
            ->join('transaction', 'contract.id', '=', 'transaction.contract_id')
            ->where('investor_id', $condition['id'])
            ->select('transaction.*', 'contract.code_contract_disbursement');
        if (isset($condition['option'])) {
            $transaction = $transaction
                ->where('transaction.type', $condition['option']);
        }
        if (isset($condition['start']) && isset($condition['end'])) {
            $transaction = $transaction
                ->whereBetween('transaction.created_at', [$condition['start'], $condition['end']]);
        }
        $transaction = $transaction
            ->orderBy('transaction.created_at', self::DESC)
            ->limit($limit)
            ->offset($offset)
            ->get();
        return $transaction;
    }

    public function get_proceeds($condition)
    {
        $query = $this->model;
        if (isset($condition['fdate']) && $condition['tdate']) {
            $fdate = $condition['fdate'] . ' 00:00:00';
            $tdate = $condition['tdate'] . ' 23:59:59';
            $query = $query->whereBetween(Transaction::COLUMN_CREATED_AT, [$fdate, $tdate]);
        }
        if (isset($condition['order_code'])) {
            $order_code = $condition['order_code'];
            $query = $query->where(Transaction::COLUMN_TRANSACTION_VIMO, 'LIKE', "%$order_code%");
        }
        if (isset($condition['investor_code'])) {
            $investor_code = $condition['investor_code'];
            $query = $query->where(Transaction::COLUMN_INVESTOR_CODE, 'LIKE', "%$investor_code%");
        }

        $type = $condition['type_contract'];
        $query = $query->whereHas('contract', function ($query_contract) use ($type) {
            $query_contract->where(Contract::COLUMN_TYPE_CONTRACT, $type);
        });
        $query = $query
            ->where(Transaction::COLUMN_TYPE, Transaction::DAU_TU)
            ->orderBy(Transaction::COLUMN_CREATED_AT, self::DESC)
            ->paginate();
        return $query;
    }

    //    public function financial_report_transaction($condition)
    //    {
    //        $id = $condition['contract_id'];
    //        return $this->model
    //            ->where(function ($query) use ($id) {
    //                return $query->where(Transaction::COLUMN_CONTRACT_ID, $id);
    //            })
    //            ->whereBetween(Transaction::COLUMN_CREATED_AT, [$condition['start'], $condition['end']])
    //            ->get();
    //    }

    public function get_money_payment()
    {
        return $this->model
            ->get();
    }

    public function tong_tien_dau_tu($contract_id)
    {
        return $this->model
            ->where(Transaction::COLUMN_CONTRACT_ID, $contract_id)
            ->where(Transaction::COLUMN_TYPE, Transaction::DAU_TU)
            ->sum(Transaction::COLUMN_INVESTMENT_AMOUNT);
    }

    public function tong_tien_lai($contract_id)
    {
        return $this->model
            ->where(Transaction::COLUMN_CONTRACT_ID, $contract_id)
            ->where(Transaction::COLUMN_TYPE, Transaction::TRA_LAI)
            ->sum(Transaction::COLUMN_TIEN_LAI);
    }

    public function money_payment($condition)
    {
        $query = $this->model;
        if (isset($condition['fdate']) && isset($condition['tdate'])) {
            $fdate = $condition['fdate'] . ' 00:00:00';
            $tdate = $condition['tdate'] . ' 23:59:59';
            $query = $query->whereBetween(Transaction::COLUMN_CREATED_AT, [$fdate, $tdate]);
        }
        $type = $condition['type_contract'];
        $query = $query->whereHas('contract', function ($query_contract) use ($type) {
            $query_contract->where(Contract::COLUMN_TYPE_CONTRACT, $type);
        });
        return $query
            ->where(Transaction::COLUMN_TYPE, Transaction::TRA_LAI)
            ->orderBy(Transaction::COLUMN_CREATED_AT, self::DESC)
            ->paginate();
    }

    public function sum_tra_lai($condition, $date = null)
    {
        $model = $this->model;
        $type = $condition['type_contract'];
        $model = $model->where(Transaction::COLUMN_TYPE, Transaction::TRA_LAI);
        if (!is_null($date)) {
            $model = $model->where(Transaction::COLUMN_CREATED_AT, '>=', $date);
        }
        $model = $model->whereHas('contract', function ($query_contract) use ($type) {
            $query_contract->where(Contract::COLUMN_TYPE_CONTRACT, $type);
        });
        return $model->sum(Transaction::COLUMN_INVESTMENT_AMOUNT);
    }

    public function get_proceeds_all($condition)
    {
        $query = $this->model;
        if (isset($condition['fdate']) && $condition['tdate']) {
            $fdate = $condition['fdate'] . ' 00:00:00';
            $tdate = $condition['tdate'] . ' 23:59:59';
            $query = $query->whereBetween(Transaction::COLUMN_CREATED_AT, [$fdate, $tdate]);
        }
        if (isset($condition['order_code'])) {
            $order_code = $condition['order_code'];
            $query = $query->where(Transaction::COLUMN_TRANSACTION_VIMO, 'LIKE', "%$order_code%");
        }
        if (isset($condition['investor_code'])) {
            $investor_code = $condition['investor_code'];
            $query = $query->where(Transaction::COLUMN_INVESTOR_CODE, 'LIKE', "%$investor_code%");
        }
        $type = $condition['type_contract'];
        $query = $query->whereHas('contract', function ($query_contract) use ($type) {
            $query_contract->where(Contract::COLUMN_TYPE_CONTRACT, $type);
        });
        $query = $query
            ->where(Transaction::COLUMN_TYPE, Transaction::DAU_TU)
            ->orderBy(Transaction::COLUMN_CREATED_AT, self::DESC)
            ->get();
        return $query;
    }

    public function financial_report_contract($condition)
    {
        $id = $condition['id'];
        $query = $this->model->newQuery()->with(['contract']);
        $query = $query->whereHas('contract', function ($query_contract) use ($id) {
            $query_contract->where(Contract::COLUMN_INVESTOR_ID, $id)
                ->where(Contract::COLUMN_STATUS, Contract::SUCCESS);
        });
        return $query
            ->whereBetween(Transaction::COLUMN_CREATED_AT, [$condition['start'], $condition['end']])
            ->get();
    }

    public function tong_tien_thu_duoc($condition)
    {
        $type = $condition['type_contract'];
        $query = $this->where_has('contract', Contract::COLUMN_TYPE_CONTRACT, $type);
        return $query
            ->where(Transaction::COLUMN_TYPE, Transaction::DAU_TU)
            ->whereIn(Transaction::COLUMN_STATUS, [Transaction::STATUS_SUCCESS])
            ->sum(Transaction::COLUMN_INVESTMENT_AMOUNT);
    }

    public function tong_giao_dich($condition)
    {
        $type = $condition['type_contract'];
        $query = $this->where_has('contract', Contract::COLUMN_TYPE_CONTRACT, $type);
        return $query
            ->where(Transaction::COLUMN_TYPE, Transaction::DAU_TU)
            ->whereIn(Transaction::COLUMN_STATUS, [Transaction::STATUS_SUCCESS])
            ->count();
    }

    public function tong_tien_thu_duoc_theo_thang($condition)
    {
        $date = date('Y-m-01 00:00:00');
        $type = $condition['type_contract'];
        $query = $this->where_has('contract', Contract::COLUMN_TYPE_CONTRACT, $type);
        return $query
            ->where(Transaction::COLUMN_TYPE, Transaction::DAU_TU)
            ->whereIn(Transaction::COLUMN_STATUS, [Transaction::STATUS_SUCCESS])
            ->where(Transaction::COLUMN_CREATED_AT, '>=', $date)
            ->sum(Transaction::COLUMN_INVESTMENT_AMOUNT);
    }

    public function tong_giao_dich_theo_thang($condition)
    {
        $date = date('Y-m-01 00:00:00');
        $type = $condition['type_contract'];
        $query = $this->where_has('contract', Contract::COLUMN_TYPE_CONTRACT, $type);
        return $query
            ->where(Transaction::COLUMN_TYPE, Transaction::DAU_TU)
            ->whereIn(Transaction::COLUMN_STATUS, [Transaction::STATUS_SUCCESS])
            ->where(Transaction::COLUMN_CREATED_AT, '>=', $date)
            ->count();
    }

    public function tong_tien_thu_duoc_theo_ngay($condition)
    {
        $start = date('Y-m-d 00:00:00', time());
        $end = date('Y-m-d 23:59:59', time());
        $type = $condition['type_contract'];
        $query = $this->where_has('contract', Contract::COLUMN_TYPE_CONTRACT, $type);
        return $query
            ->where(Transaction::COLUMN_TYPE, Transaction::DAU_TU)
            ->whereIn(Transaction::COLUMN_STATUS, [Transaction::STATUS_SUCCESS])
            ->whereBetween(Transaction::COLUMN_CREATED_AT, [$start, $end])
            ->sum(Transaction::COLUMN_INVESTMENT_AMOUNT);
    }

    public function tong_giao_dich_theo_ngay($condition)
    {
        $start = date('Y-m-d 00:00:00', time());
        $end = date('Y-m-d 23:59:59', time());
        $type = $condition['type_contract'];
        $query = $this->where_has('contract', Contract::COLUMN_TYPE_CONTRACT, $type);
        return $query
            ->where(Transaction::COLUMN_TYPE, Transaction::DAU_TU)
            ->whereIn(Transaction::COLUMN_STATUS, [Transaction::STATUS_SUCCESS])
            ->whereBetween(Transaction::COLUMN_CREATED_AT, [$start, $end])
            ->count();
    }

    public function tong_giao_dich_theo_nam($condition)
    {
        $start = date('Y-01-01 00:00:00');
        $end = date('Y-12-31 23:59:59');
        $type = $condition['type_contract'];
        $query = $this->where_has('contract', Contract::COLUMN_TYPE_CONTRACT, $type);
        return $query
            ->where(Transaction::COLUMN_TYPE, Transaction::DAU_TU)
            ->whereIn(Transaction::COLUMN_STATUS, [Transaction::STATUS_SUCCESS])
            ->whereBetween(Transaction::COLUMN_CREATED_AT, [$start, $end])
            ->count();
    }

    public function tong_tien_thu_duoc_theo_nam($condition)
    {
        $start = date('Y-01-01 00:00:00');
        $end = date('Y-12-31 23:59:59');
        $type = $condition['type_contract'];
        $query = $this->where_has('contract', Contract::COLUMN_TYPE_CONTRACT, $type);
        return $query
            ->where(Transaction::COLUMN_TYPE, Transaction::DAU_TU)
            ->whereIn(Transaction::COLUMN_STATUS, [Transaction::STATUS_SUCCESS])
            ->whereBetween(Transaction::COLUMN_CREATED_AT, [$start, $end])
            ->sum(Transaction::COLUMN_INVESTMENT_AMOUNT);
    }

    public function money_payment_all($condition)
    {
        $query = $this->model;
        if (isset($condition['fdate']) && $condition['tdate']) {
            $fdate = $condition['fdate'] . ' 00:00:00';
            $tdate = $condition['tdate'] . ' 23:59:59';
            $query = $query->whereBetween(Transaction::COLUMN_CREATED_AT, [$fdate, $tdate]);
        }
        $type = $condition['type_contract'];
        $query = $query->whereHas('contract', function ($query_contract) use ($type) {
            $query_contract->where(Contract::COLUMN_TYPE_CONTRACT, $type);
        });
        return $query
            ->where(Transaction::COLUMN_TYPE, Transaction::TRA_LAI)
            ->orderBy(Transaction::COLUMN_CREATED_AT, self::DESC)
            ->get();
    }

    public function dashboard_investor($investor_id, $column, $type)
    {
        $model = $this->model;
        $model = $model->whereHas('contract', function ($query) use ($investor_id) {
            $query->where(Contract::COLUMN_INVESTOR_ID, $investor_id);
        });
        if ($type == Transaction::DAU_TU) {
            $model = $model->where(Transaction::COLUMN_STATUS, Transaction::STATUS_SUCCESS);
        }
        return $model
            ->where(Transaction::COLUMN_TYPE, $type)
            ->sum($column);
    }

    public function tong_tien_thu_duoc_theo_tung_thang($condition)
    {
        $fdate = $condition['start'];
        $tdate = $condition['end'];
        $type = $condition['type_contract'];
        $query = $this->where_has('contract', Contract::COLUMN_TYPE_CONTRACT, $type);
        return $query
            ->where(Transaction::COLUMN_TYPE, Transaction::DAU_TU)
            ->whereIn(Transaction::COLUMN_STATUS, [Transaction::STATUS_SUCCESS])
            ->whereBetween(Transaction::COLUMN_CREATED_AT, [$fdate, $tdate])
            ->sum(Transaction::COLUMN_INVESTMENT_AMOUNT);
    }

    public function get_proceeds_v2($condition)
    {
        $type = $condition['type_contract'] ?? 'APP';
        $transaction = DB::table('transaction')
            ->join('contract', 'transaction.contract_id', '=', 'contract.id')
            ->join('investor', 'contract.investor_id', '=', 'investor.id')
            ->leftJoin('pay', 'pay.contract_id', '=', 'contract.id')
            ->leftJoin('user', 'investor.assign_call', '=', 'user.id')
            ->where('transaction.type', Transaction::DAU_TU)
            ->where('contract.type_contract', $type);

        if (!empty($condition['fdate']) && !empty($condition['tdate'])) {
            $fdate = $condition['fdate'] . ' 00:00:00';
            $tdate = $condition['tdate'] . ' 23:59:59';
            $transaction = $transaction
                ->whereBetween('transaction.created_at', [$fdate, $tdate]);
        }
        if (!empty($condition['order_code'])) {
            $order_code = $condition['order_code'];
            $transaction = $transaction->where('transaction.transaction_vimo', 'LIKE', "%$order_code%")
                ->orWhere('transaction.trading_code', 'LIKE', "%$order_code%");
        }

        if (!empty($condition['full_name'])) {
            $full_name = $condition['full_name'];
            $transaction = $transaction->where('investor.name', 'LIKE', "%$full_name%");
        }

        $transaction = $transaction
            ->select('transaction.id',
                'transaction.transaction_vimo',
                'transaction.trading_code',
                'transaction.investment_amount',
                'transaction.interest',
                'transaction.created_at',
                'transaction.date_pay',
                'transaction.status',
                'transaction.code_contract',
                'transaction.tien_goc',
                'transaction.tien_lai',
                'transaction.type_method',
                'transaction.created_by',
                'transaction.payment_source',
                'contract.code_contract_disbursement',
                'contract.investment_amount as contract_amount_money',
                'contract.number_day_loan',
                'contract.type_interest',
                'investor.name',
                'investor.phone_number',
                'user.email as user_call')
            ->selectRaw('SUM(pay.lai_ky) as tong_tien_lai')
            ->groupBy('transaction.id');
        if (!empty($condition['excel']) && $condition['excel'] == true) {
            $transaction = $transaction
                ->orderBy('transaction.created_at', self::DESC)
                ->get();
        } else {
            $transaction = $transaction
                ->orderBy('transaction.created_at', self::DESC)
                ->paginate(30);
        }

        return $transaction;
    }

    public function total_money_invest_by_month($i)
    {
        if ($i < 10) {
            $i = '0' . $i;
        }
        $date = get_created_at_with_year($i, date('Y'));

        $model = DB::table('transaction')
            ->whereBetween('transaction.created_at', [$date['start'], $date['end']])
            ->where('transaction.type', Transaction::DAU_TU)
            ->join('contract', 'transaction.contract_id', '=', 'contract.id')
            ->where('contract.type_contract', Contract::HOP_DONG_DAU_TU_APP)
            ->selectRaw('SUM(transaction.investment_amount) as investment_amount')
            ->first();
        return $model;
    }

    public function total_investment_by_time($condition)
    {
        $fdate = $condition['from_date'];
        $tdate = $condition['to_date'];
        $query = $this->where_has('contract', Contract::COLUMN_TYPE_CONTRACT, Contract::HOP_DONG_DAU_TU_APP);
        return $query
            ->where(Transaction::COLUMN_TYPE, Transaction::DAU_TU)
            ->whereIn(Transaction::COLUMN_STATUS, [Transaction::STATUS_SUCCESS])
            ->whereBetween(Transaction::COLUMN_CREATED_AT, [$fdate, $tdate])
            ->sum(Transaction::COLUMN_INVESTMENT_AMOUNT);
    }

    public function total_money_invest_by_day_on_month($date)
    {
        $start = $date . ' 00:00:00';
        $end = $date . ' 23:59:59';

        $model = DB::table('transaction')
            ->whereBetween('transaction.created_at', [$start, $end])
            ->where('transaction.type', Transaction::DAU_TU)
            ->join('contract', 'transaction.contract_id', '=', 'contract.id')
            ->where('contract.type_contract', Contract::HOP_DONG_DAU_TU_APP)
            ->selectRaw('SUM(transaction.investment_amount) as investment_amount')
            ->first();
        return $model;

    }

    public function total_money_payment_by_day_on_month($date)
    {
        $start = $date . ' 00:00:00';
        $end = $date . ' 23:59:59';
        $model = DB::table('transaction')
            ->whereBetween('transaction.created_at', [$start, $end])
            ->where('transaction.type', Transaction::TRA_LAI)
            ->join('contract', 'transaction.contract_id', '=', 'contract.id')
            ->where('contract.type_contract', Contract::HOP_DONG_DAU_TU_APP)
            ->selectRaw('SUM(transaction.tien_goc) as tien_goc, SUM(tien_lai) as tien_lai, SUM(tong_goc_lai) as tong_goc_lai')
            ->first();
        return $model;
    }

    public function total_money_payment_by_month($i)
    {
        if ($i < 10) {
            $i = '0' . $i;
        }
        $date = get_created_at_with_year($i, date('Y'));

        $model = DB::table('transaction')
            ->whereBetween('transaction.created_at', [$date['start'], $date['end']])
            ->where('transaction.type', Transaction::TRA_LAI)
            ->join('contract', 'transaction.contract_id', '=', 'contract.id')
            ->where('contract.type_contract', Contract::HOP_DONG_DAU_TU_APP)
            ->selectRaw('SUM(transaction.tien_goc) as tien_goc, SUM(transaction.tien_lai) as tien_lai, SUM(transaction.tong_goc_lai) as tong_goc_lai')
            ->first();
        return $model;
    }

    public function financial_report_contract_v2($investor_id, $year, $type, $i)
    {
        if ($i < 10) {
            $i = '0' . $i;
        }
        $date = get_created_at_with_year($i, $year);
        $model = DB::table('transaction')
            ->whereBetween('transaction.created_at', [$date['start'], $date['end']])
            ->where('transaction.type', $type)
            ->join('contract', 'transaction.contract_id', '=', 'contract.id')
            ->where('contract.type_contract', Contract::HOP_DONG_DAU_TU_APP)
            ->where('contract.investor_id', $investor_id)
            ->selectRaw('SUM(transaction.tien_goc) as tien_goc, SUM(transaction.tien_lai) as tien_lai, SUM(transaction.investment_amount) as dau_tu')
            ->first();
        return $model;
    }

    public function transaction_has_been_paid($contract_id)
    {
        $model = DB::table('transaction')
            ->where('transaction.contract_id', $contract_id)
            ->where('transaction.type', Transaction::TRA_LAI)
            ->selectRaw('SUM(transaction.tien_goc) as tien_goc, SUM(transaction.tien_lai) as tien_lai')
            ->first();
        return $model;
    }

    public function dashboard_investor_v2($investor_id)
    {
        $model = DB::table('transaction')
            ->join('contract', 'transaction.contract_id', '=', 'contract.id')
            ->where('contract.investor_id', $investor_id)
            ->where('transaction.status', Transaction::STATUS_SUCCESS)
            ->selectRaw('
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
                        WHEN transaction.type = 1
                        THEN transaction.investment_amount
                        ELSE 0
                    END) AS tong_tien_dau_tu')
            ->first();
        return $model;
    }

    public function money_payment_v2($condition)
    {
        $type = $condition['type_contract'] ?? 'APP';
        $query = DB::table('transaction')
            ->join('contract', 'transaction.contract_id', '=', 'contract.id')
            ->join('investor', 'contract.investor_id', '=', 'investor.id')
            ->where('contract.type_contract', $type)
            ->where('transaction.type', Transaction::TRA_LAI);

        if (!empty($condition['fdate']) && !empty($condition['tdate'])) {
            $fdate = $condition['fdate'] . ' 00:00:00';
            $tdate = $condition['tdate'] . ' 23:59:59';
            $query = $query->whereBetween(Transaction::COLUMN_CREATED_AT, [$fdate, $tdate]);
        }

        if (!empty($condition['code_contract'])) {
            $code_contract = $condition['code_contract'];
            $query = $query->where('contract.code_contract_disbursement', 'LIKE', "%$code_contract%")
                ->orWhere('contract.code_contract', 'LIKE', "%$code_contract%");
        }

        if (!empty($condition['full_name'])) {
            $name = $condition['full_name'];
            $query = $query->where('investor.name', 'LIKE', "%$name%");
        }

        $query = $query->select('transaction.id',
            'transaction.transaction_vimo',
            'transaction.trading_code',
            'transaction.investment_amount',
            'transaction.interest',
            'transaction.created_at',
            'transaction.date_pay',
            'transaction.status',
            'transaction.code_contract',
            'transaction.tien_goc',
            'transaction.tien_lai',
            'transaction.type_method',
            'transaction.created_by',
            'transaction.payment_source',
            'transaction.tong_goc_lai',
            'contract.code_contract_disbursement',
            'contract.investment_amount as contract_amount_money',
            'contract.number_day_loan',
            'contract.type_interest',
            'investor.name as investor_name');
        if (!empty($condition['excel']) && $condition['excel'] == true) {
            $query = $query
                ->orderBy('transaction.created_at', self::DESC)
                ->get();
        } else {
            $query = $query->orderBy('transaction.created_at', self::DESC)
                ->paginate(30);
        }
        return $query;
    }
}
