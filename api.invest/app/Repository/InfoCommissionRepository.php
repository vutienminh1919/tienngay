<?php


namespace App\Repository;


use App\Models\InfoCommission;
use Illuminate\Support\Facades\DB;

class InfoCommissionRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return InfoCommission::class;
    }

    public function get_all_commission($request)
    {
        $date = !empty($request->month) ? $request->month : date('Y-m');
        $query = DB::table('info_commission')
            ->where('info_commission.time', $date)
            ->whereNull('info_commission.detail_id')
            ->join('user', 'info_commission.user_id', '=', 'user.id')
            ->select('info_commission.*', 'user.full_name', 'user.phone');

        if (!empty($request->user_id)) {
            $query = $query->where('info_commission.user_id', $request->user_id);
        }

        $query = $query->paginate(20);
        return $query;
    }

    public function commission_investor($request)
    {
        $date = !empty($request->month) ? $request->month : date('Y-m');
        $query = DB::table('info_commission')
            ->where('info_commission.time', $date)
            ->where('info_commission.user_id', $request->user_id)
            ->whereNull('info_commission.detail_id')
            ->join('user', 'info_commission.user_id', '=', 'user.id')
            ->select('info_commission.*', 'user.full_name', 'user.phone');
        $query = $query->first();
        return $query;
    }

    public function detail_commission_investor($request)
    {
        $date = !empty($request->month) ? $request->month : date('Y-m');
        $query = DB::table('info_commission')
            ->where('info_commission.time', $date)
            ->where('info_commission.detail_id', $request->detail_id)
            ->join('user', 'info_commission.user_id', '=', 'user.id')
            ->select('info_commission.*', 'user.full_name', 'user.phone');
        $query = $query->get();
        return $query;
    }

    public function commission_investor_group($info_id)
    {
        $query = DB::table('info_commission')
            ->where('info_commission.detail_id', $info_id)
            ->selectRaw('sum(info_commission.total_money) as total_money, sum(info_commission.money_commission) as money_commission, info_commission.user_id')
            ->groupBy('info_commission.user_id');
        $query = $query->get();
        return $query;
    }

    public function commission_investor_group_many($users_id, $timeline)
    {
        $query = DB::table('info_commission')
            ->whereIn('info_commission.user_id', $users_id)
            ->whereNull('info_commission.detail_id')
            ->where('info_commission.time', $timeline)
            ->selectRaw('sum(info_commission.total_money) as total_money, sum(info_commission.money_commission) as money_commission');
        $query = $query->first();
        return $query;
    }

    public function excel_all_commission($request)
    {
        $date = !empty($request->month) ? $request->month : date('Y-m');
        $query = DB::table('info_commission')
            ->where('info_commission.time', $date)
            ->whereNotNull('info_commission.detail_id')
            ->join('user', 'info_commission.user_id', '=', 'user.id')
            ->join('contract', 'info_commission.contract_id', '=', 'contract.id')
            ->select('info_commission.*', 'user.full_name', 'user.phone', 'contract.code_contract_disbursement', 'contract.amount_money', 'contract.created_at as contract_created_at', 'contract.interest', 'contract.type_interest', 'contract.number_day_loan');

        if (!empty($request->user_id)) {
            $query = $query->where('info_commission.user_id', $request->user_id);
        }

        $query = $query->get();
        return $query;
    }
}
