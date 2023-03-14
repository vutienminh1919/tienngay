<?php

namespace App\Repository;


use App\Models\Contract;
use App\Models\Event;
use App\Models\Investor;
use \App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function findOneByEmailOrPhone($email)
    {
        return $this->model
            ->where(function ($query) use ($email) {
                return $query->where('email', $email)
                    ->orWhere('phone', $email);
            })
            ->where('status', 'active')
            ->first();
    }

    public function checkLoginUser($email, $phone, $token_web)
    {
        return $this->model
            ->where(function ($query) use ($email, $phone) {
                return $query->where('email', $email)
                    ->orWhere('phone', $phone);
            })
            ->where('token_web', $token_web)
            ->where('status', 'active')
            ->first();
    }

    public function findOneByPhone($phone)
    {
        return $this->model
            ->where(function ($query) use ($phone) {
                return $query->where('phone', $phone);
            })
            ->where('status', 'active')
            ->first();
    }

    public function checkLoginUserApp($phone, $token_app)
    {
        return $this->model
            ->where(function ($query) use ($phone) {
                return $query->where('phone', $phone);
            })
            ->where('token_app', $token_app)
            ->where('status', 'active')
            ->first();
    }

    public function getListTypeNhanVien($filter)
    {
        $condition = $this->filterCondition($filter);
        $model = $this->model;
        if (count($condition) > 0) {
            $model = $model->where($condition);
        }
        if (isset($filter['role'])) {
            $model = $model->whereHas('role', function ($query) use ($filter) {
                $query->whereIn('role_id', explode(',', $filter['role']));
            });
        }
        $model = $model->where('type', User::TYPE_NHAN_VIEN);
        $model = $model->with('role');
        $model = $model->orderBy('id', 'DESC');
        $model = $model->paginate();
        return $model;
    }

    public function getAllTypeNhanVien()
    {
        return $this->model
            ->where('type', User::TYPE_NHAN_VIEN)
            ->get();
    }

    public function checkOtp($otp, $phone)
    {
        return $this->model
            ->where(function ($query) use ($phone) {
                return $query->where('phone', $phone);
            })
            ->where('token_active', $otp)
            ->first();
    }

    public function signin_app($phone)
    {
        return $this->model
            ->where('phone', $phone)
            ->where('status', 'active')
            ->first();
    }

    public function checkOtpResetPassApp($otp, $phone)
    {
        return $this->model
            ->where(function ($query) use ($phone) {
                return $query->where('phone', $phone);
            })
            ->where('token_reset_password', $otp)
            ->first();
    }

    public function findPhoneUser($phone)
    {
        return $this->model
            ->where(function ($query) use ($phone) {
                return $query->where('phone', $phone);
            })
            ->first();
    }

    public function findEmailUser($email)
    {
        return $this->model
            ->where(function ($query) use ($email) {
                return $query->where('email', $email);
            })
            ->where('status', 'active')
            ->first();
    }

    public function get_all_commission($request)
    {
        return $this->model
            ->whereNotNull(User::REFERRAL_ID)
            ->where(User::REFERRAL_DATE, '<=', $request->tdate)
            ->select(User::REFERRAL_ID)
            ->distinct()
            ->paginate(20);
    }

    public function get_all_active()
    {
        $model = $this->model;
        $model = $model->where('type', User::TYPE_NHA_DAU_TU_APP);
        $model = $model->where('status', User::STATUS_ACTIVE);
        $model = $model->whereNull(User::TYPE_REFERRAL);
//            ->orWhere(User::TYPE_REFERRAL, User::CVKD);
        $model = $model
            ->select('id', 'phone')
            ->get();
        return $model;
    }

    public function find_user_by_event($filter)
    {
        $result = DB::table('user')
            ->where('user.status', '=', User::STATUS_ACTIVE)
            ->join('investor', 'investor.user_id', '=', 'user.id');
        if ($filter['object'] == Event::ACTIVE_AND_INVESTMENT) {
            $result = $result
                ->where('investor.status', '=', User::STATUS_ACTIVE)
                ->where('investor.investment_status', '=', Investor::DA_DAU_TU);
        } elseif ($filter['object'] == Event::ACTIVE_AND_NO_INVESTMENT) {
            $result = $result
                ->where('investor.status', '=', User::STATUS_ACTIVE)
                ->where('investor.investment_status', '=', Investor::CHUA_DAU_TU);
        } elseif ($filter['object'] == Event::EXPIRE_AND_NO_INVESTMENT) {
            $user_effect = $this->get_user_contract_expire();
            $result = $result
                ->where('investor.status', '=', User::STATUS_ACTIVE)
                ->where('investor.investment_status', '=', Investor::DA_DAU_TU)
                ->whereNotIn('user.id', $user_effect);
        } elseif ($filter['object'] == Event::NO_ACTIVE) {
            $result = $result
                ->where('investor.status', '=', User::STATUS_NEW)
                ->whereNotIn('investor.status_call', [11]);
        } elseif ($filter['object'] == Event::BIRTHDAY) {
            $result = $result
                ->whereRaw("DATE_FORMAT(investor.birthday, '%m-%d') = DATE_FORMAT(now(),'%m-%d')");
        }
        $result = $result
            ->pluck('user.id')
            ->chunk(100);
        return $result;
    }

    public function find_select($id, $select)
    {
        $model = $this->model;
        return $model->where('id', $id)
            ->select($select)
            ->first();
    }

    public function get_user_contract_expire()
    {
        return $result = DB::table('user')
            ->where('user.status', '=', User::STATUS_ACTIVE)
            ->join('investor', 'investor.user_id', '=', 'user.id')
            ->where('investor.status', '=', User::STATUS_ACTIVE)
            ->join('contract', 'contract.investor_id', '=', 'investor.id')
            ->where('contract.status_contract', Contract::EFFECT)
            ->pluck('user.id')
            ->toArray();
    }

    public function findGroupUserPhone($phones)
    {
        $model = $this->model;
        $model = $model->whereIn(User::PHONE, $phones)
            ->where(User::STATUS, User::STATUS_ACTIVE)
            ->pluck(User::COLUMN_ID)
            ->toArray();
        return $model;
    }

    public function get_user_refferall()
    {
        return $result = DB::table('user')
            ->whereNotNull('referral_id')
            ->selectRaw('DISTINCT referral_id')
            ->pluck('referral_id')
            ->toArray();
    }

    public function total_invest($user_id, $request)
    {
        $query = DB::table('user')
            ->where('user.referral_id', $user_id)
            ->join('investor', 'user.id','=', 'investor.user_id')
            ->join('contract', 'contract.investor_id', '=','investor.id')
            ->where('contract.type_contract', Contract::HOP_DONG_DAU_TU_APP)
            ->where('contract.status', 'success')
            ->whereBetween('contract.created_at',[$request->fdate, $request->tdate])
            ->sum('contract.amount_money');
        return $query;
    }

}
