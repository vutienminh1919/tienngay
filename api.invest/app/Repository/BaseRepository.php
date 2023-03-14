<?php

namespace App\Repository;

use App\Models\Contract;
use App\Models\Investor;
use App\Models\Pay;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

abstract class BaseRepository implements BaseRepositoryInterface
{
    const DESC = 'DESC';
    const ASC = 'ASC';
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        $result = $this->model->find($id);

        return $result;
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function update($id, $attributes = [])
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    protected function filterCondition($filter)
    {
        $condition = [];
        if (isset($filter['name'])) {
            $condition[] = ['name', 'like', '%' . $filter['name'] . '%'];
        }
        if (isset($filter['email'])) {
            $condition[] = ['email', '=', $filter['email']];
        }
        if (isset($filter['phone'])) {
            $condition[] = ['phone', '=', $filter['phone']];
        }
        return $condition;
    }


    public function toggleActive($id)
    {
        $data = $this->find($id);
        if ($data) {
            if ($data->status == 'active') {
                $value = 'deactive';
            } else if ($data->status == 'deactive') {
                $value = 'active';
            }
            if (isset($value)) {
                return $this->update($id, [
                    'status' => $value
                ]);
            }
        }
        return null;
    }

    /**
     * @param $id
     * @param $table
     * @param $collection
     * @return mixed
     */
    public function find_foreignKey($id, $relationship, $collection)
    {
        $result = $this->model->whereHas($relationship, function ($query) use ($id, $collection) {
            $query->where($collection, $id);
        })->get();

        return $result;
    }

    public function delete_field($field, $value)
    {
        DB::beginTransaction();
        try {
            $this->model->where($field, $value)->delete();
            DB::commit();
            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            return false;
        }
        return;
    }

    /**
     * @param $id
     * @param $table
     * @param $collection
     * @return mixed
     */
    public function count_find_foreignKey($id, $relationship, $collection)
    {
        $result = $this->model->whereHas($relationship, function ($query) use ($id, $collection) {
            $query->where($collection, $id);
        })->count();

        return $result;
    }

    public function search_overview_pay($condition)
    {
        $query = $this->model;
        if (isset($condition['fdate']) && $condition['tdate']) {
            $fdate = strtotime($condition['fdate'] . ' 00:00:00');
            $tdate = strtotime($condition['tdate'] . ' 23:59:59');
            $query = $query->whereBetween(Pay::COLUMN_NGAY_KY_TRA, [$fdate, $tdate]);
        }
        if (isset($condition['code_contract'])) {
            $code_contract = $condition['code_contract'];
            $query = $query->whereHas('contract', function ($query_contract) use ($code_contract) {
                $query_contract->where(Contract::COLUMN_CODE_CONTRACT_DISBURSEMENT, 'LIKE', "%$code_contract%");
            });
        }
        if (isset($condition['investor_code'])) {
            $investor_code = $condition['investor_code'];
            $query = $query->where(Pay::COLUMN_INVESTOR_CODE, 'LIKE', "%$investor_code%");
        }
        $type = $condition['type'];
        $query = $query->whereHas('contract', function ($query_contract) use ($type) {
            $query_contract->where(Contract::COLUMN_TYPE_CONTRACT, $type);
        });
        return $query;
    }

    public function findOne($condition)
    {
        $query = $this->model;
        foreach ($condition as $key => $value) {
            $query = $query->where($key, $value);
        }
        return $query->first();
    }

    public function findMany($condition)
    {
        $query = $this->model;
        foreach ($condition as $key => $value) {
            $query = $query->where($key, $value);
        }
        return $query
            ->orderBy('created_at', self::DESC)
            ->get();
    }

    public function where_has($relationship, $column, $value)
    {
        $model = $this->model;
        $model = $model->whereHas($relationship, function ($query) use ($column, $value) {
            $query->where($column, $value);
        });
        return $model;
    }

    public function findOneDesc($condition)
    {
        $query = $this->model;
        foreach ($condition as $key => $value) {
            $query = $query->where($key, $value);
        }
        return $query
            ->orderBy('created_at', self::DESC)
            ->first();
    }

    public function findManySortColumn($condition, $colum, $sort)
    {
        $query = $this->model;
        foreach ($condition as $key => $value) {
            $query = $query->where($key, $value);
        }
        return $query
            ->orderBy($colum, $sort)
            ->get();
    }

    public function findOneSortColumn($condition, $colum, $sort)
    {
        $query = $this->model;
        foreach ($condition as $key => $value) {
            $query = $query->where($key, $value);
        }
        return $query
            ->orderBy($colum, $sort)
            ->first();
    }

    public function find_one($key, $value)
    {
        $query = $this->model;
        $query = $query->where($key, $value);
        return $query->first();
    }

    public function search_overview_pay_v2($condition)
    {
        $type = $condition['type'];
        $pays = DB::table('pay')
            ->join('contract', 'pay.contract_id', '=', 'contract.id')
            ->join('investor', 'contract.investor_id', '=', 'investor.id')
            ->leftJoin('transaction', 'pay.id', '=', 'transaction.pay_id')
            ->where('contract.type_contract', $type)
            ->select('pay.*',
                'contract.code_contract_disbursement',
                'contract.investment_amount',
                'investor.name', 'investor.phone_number',
                'investor.type_interest_receiving_account',
                'transaction.created_at as transaction_created_at',
                'contract.type_contract',
                'contract.start_date',
                'contract.due_date',
                'pay.contract_id'
            );

        if (!empty($condition['fdate']) && !empty($condition['tdate'])) {
            $fdate = strtotime($condition['fdate'] . ' 00:00:00');
            $tdate = strtotime($condition['tdate'] . ' 23:59:59');
            $pays = $pays
                ->whereBetween('pay.ngay_ky_tra', [$fdate, $tdate]);
        }
        if (!empty($condition['code_contract'])) {
            $code_contract = $condition['code_contract'];
            $pays = $pays->where('contract.code_contract_disbursement', 'LIKE', "%$code_contract%");
        }

        if (!empty($condition['full_name'])) {
            $full_name = $condition['full_name'];
            $pays = $pays->where('investor.name', 'LIKE', "%$full_name%");
        }

        if (!empty($condition['status'])) {
            $status = $condition['status'];
            if ($status == 2) {
                $pays = $pays->where('pay.status', (int)$status);
            } else {
                $pays = $pays->whereIn('pay.status', [1, 3, 4, 5, 6, 7]);
            }
        }
        return $pays;
    }

    public function count($condition)
    {
        $query = $this->model;
        foreach ($condition as $key => $value) {
            $query = $query->where($key, $value);
        }
        return $query
            ->count();
    }
}
