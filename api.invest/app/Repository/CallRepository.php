<?php


namespace App\Repository;


use App\Models\Call;

class CallRepository extends BaseRepository implements CallRepositoryInterface
{

    public function getModel()
    {
        return Call::class;
    }

    public function getAllListCall($filter)
    {
        $model = $this->model;
        if (isset($filter['fdate']) && isset($filter['tdate'])) {
            $fdate = $filter['fdate'] . ' 00:00:00';
            $tdate = $filter['tdate'] . ' 23:59:59';
            $model = $model->whereBetween(Call::COLUMN_UPDATED_AT, [$fdate, $tdate]);
        }
        $model = $model->orderBy(Call::COLUMN_UPDATED_AT, self::DESC);
        $model = $model->get();
        return $model;
    }

    public function checkCallVbee($investorId,$vbeeState,$check_phone="")
    {
        $result = $this->model->where([Call::COLUMN_LEAD_INVESTOR_ID => $investorId])->first();
        if (empty($result)) {
            if (!empty($check_phone) && $vbeeState == 40 && $check_phone == 3 ){
                $result1 = $this->model->create(
                    [
                        Call::COLUMN_STATUS => 13,
                        Call::COLUMN_NOTE => 2,
                        Call::COLUMN_LEAD_INVESTOR_ID => $investorId,
                        CAll::COLUMN_CREATED_BY => 'vbee_call'
                    ]
                );
            }elseif($vbeeState == 40 && empty($check_phone)){
                $result1 = $this->model->create(
                    [
                        Call::COLUMN_STATUS => 13,
                        Call::COLUMN_NOTE => 7,
                        Call::COLUMN_LEAD_INVESTOR_ID => $investorId,
                        CAll::COLUMN_CREATED_BY => 'vbee_call'
                    ]
                );
            }else{
                $result1 = $this->model->create(
                    [
                        Call::COLUMN_STATUS => 13,
                        Call::COLUMN_NOTE => 7,
                        Call::COLUMN_LEAD_INVESTOR_ID => $investorId,
                        CAll::COLUMN_CREATED_BY => 'vbee_call'
                    ]
                );
            }
        }
    }
}
