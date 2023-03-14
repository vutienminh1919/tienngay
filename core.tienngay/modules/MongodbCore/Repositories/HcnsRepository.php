<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Entities\Hcns;
use Modules\MongodbCore\Repositories\Interfaces\HcnsRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use MongoDB\BSON\Regex;

class HcnsRepository implements HcnsRepositoryInterface
{
        /**
     * @var Model
     */
    protected $hcnsModel;


   /**
    * HcnsRepository .
    *
    * @param Hcns
    */
   public function __construct(Hcns $hcnsModel) {
       $this->hcnsModel = $hcnsModel;
   }

   /**
    * create Record
    * @param  Array  $data
    * @return Collection
    */

    public function createRecord($data = []) {
        $result = [];
        if(!empty($data['user_name'])) {
            $result[$this->hcnsModel::USER_NAME] = $data['user_name'];
        }
        if(!empty($data['user_identify'])) {
            $result[$this->hcnsModel::USER_IDENTIFY] = $data['user_identify'];
        }
        if(isset($data['user_phone'])) {
            $result[$this->hcnsModel::USER_PHONE] = $data['user_phone'];
        }
        if(isset($data['user_email'])) {
            $result[$this->hcnsModel::USER_EMAIL] = $data['user_email'];
        }
        if(isset($data[$this->hcnsModel::DAY_OFF])) {
            $result[$this->hcnsModel::DAY_OFF] = $data['day_off'];
        }
        if(isset($data['reason_for_leave'])) {
            $result[$this->hcnsModel::REASON_FOR_LEAVE] = $data['reason_for_leave'];
        }
        if(isset($data['created_by'])) {
            $result[$this->hcnsModel::CREATED_BY] = $data['created_by'];
            $result[$this->hcnsModel::UPDATED_BY] = $data['created_by'];
        }
        if(isset($data[$this->hcnsModel::PATH])) {
            $result[$this->hcnsModel::PATH] = $data[$this->hcnsModel::PATH];
        } else {
            $result[$this->hcnsModel::PATH] = [];
        }
        $result[$this->hcnsModel::CREATED_AT] = time();
        $result[$this->hcnsModel::UPDATED_AT] = time();
        $result[$this->hcnsModel::DELETED_AT] = NULL;
        if(isset($data[$this->hcnsModel::ROOM])) {
            $result[$this->hcnsModel::ROOM] = $data[$this->hcnsModel::ROOM];
        }
        if(isset($data[$this->hcnsModel::DAY_ON])) {
            $result[$this->hcnsModel::DAY_ON] = $data[$this->hcnsModel::DAY_ON];
        }
        if(isset($data[$this->hcnsModel::POSITION])) {
            $result[$this->hcnsModel::POSITION] = $data[$this->hcnsModel::POSITION];
        }
        if(isset($data[$this->hcnsModel::WORK_PLACE])) {
            $result[$this->hcnsModel::WORK_PLACE] = $data[$this->hcnsModel::WORK_PLACE];
        }
        if(isset($data[$this->hcnsModel::DATE_RANGE])) {
            $result[$this->hcnsModel::DATE_RANGE] = $data[$this->hcnsModel::DATE_RANGE];
        }
        if(isset($data[$this->hcnsModel::ISSUED_BY])) {
            $result[$this->hcnsModel::ISSUED_BY] = $data[$this->hcnsModel::ISSUED_BY];
        }
        if(isset($data[$this->hcnsModel::TEMPORARY_ADDRESS])) {
            $result[$this->hcnsModel::TEMPORARY_ADDRESS] = $data[$this->hcnsModel::TEMPORARY_ADDRESS];
        }
        if(isset($data[$this->hcnsModel::PERMANENT_ADDRESS])) {
            $result[$this->hcnsModel::PERMANENT_ADDRESS] = $data[$this->hcnsModel::PERMANENT_ADDRESS];
        }
        if(isset($data[$this->hcnsModel::USER_PASSPORT])) {
            $result[$this->hcnsModel::USER_PASSPORT] = $data[$this->hcnsModel::USER_PASSPORT];
        }
        $result[$this->hcnsModel::SCAN] = $this->hcnsModel::YET_SCAN;
        $create = $this->hcnsModel->create($result);
        return $create;
    }

    /**
     * update record
     * @param Array $data
     * @param String $id
     * @return Collection
     */
    public function updateRecord($data = [], $id) {
        $result = [];
        if(isset($data['user_name'])) {
            $result[$this->hcnsModel::USER_NAME] = $data['user_name'];
        }
        if(isset($data['user_identify'])) {
            $result[$this->hcnsModel::USER_IDENTIFY] = $data['user_identify'];
        }
        if(isset($data['user_phone'])) {
            $result[$this->hcnsModel::USER_PHONE] = $data['user_phone'];
        }
        if(isset($data['user_email'])) {
            $result[$this->hcnsModel::USER_EMAIL] = $data['user_email'];
        }
        if(isset($data['day_off'])) {
            $result[$this->hcnsModel::DAY_OFF] = $data['day_off'];
        }
        if(isset($data['reason_for_leave'])) {
            $result[$this->hcnsModel::REASON_FOR_LEAVE] = $data['reason_for_leave'];
        }
        if(isset($data['updated_by'])) {
            $result[$this->hcnsModel::UPDATED_BY] = $data['updated_by'];
        }
        $result[$this->hcnsModel::PATH] = $data[$this->hcnsModel::PATH];
        $result[$this->hcnsModel::UPDATED_AT] = time();
        if(isset($data[$this->hcnsModel::ROOM])) {
            $result[$this->hcnsModel::ROOM] = $data['room'];
        }
        if(isset($data[$this->hcnsModel::DAY_ON])) {
            $result[$this->hcnsModel::DAY_ON] = $data['day_on'];
        }
        if(isset($data[$this->hcnsModel::POSITION])) {
            $result[$this->hcnsModel::POSITION] = $data['position'];
        }
        if(isset($data[$this->hcnsModel::WORK_PLACE])) {
            $result[$this->hcnsModel::WORK_PLACE] = $data['work_place'];
        }
        if(isset($data[$this->hcnsModel::DATE_RANGE])) {
            $result[$this->hcnsModel::DATE_RANGE] = $data['date_range'];
        }
        if(isset($data['issued_by'])) {
            $result[$this->hcnsModel::ISSUED_BY] = $data['issued_by'];
        }
        if(isset($data[$this->hcnsModel::TEMPORARY_ADDRESS])) {
            $result[$this->hcnsModel::TEMPORARY_ADDRESS] = $data['temporary_address'];
        }
        if(isset($data[$this->hcnsModel::PERMANENT_ADDRESS])) {
            $result[$this->hcnsModel::PERMANENT_ADDRESS] = $data['permanent_address'];
        }
        if(isset($data[$this->hcnsModel::USER_PASSPORT])) {
            $result[$this->hcnsModel::USER_PASSPORT] = $data['user_passport'];
        }
        $update = $this->hcnsModel::where($this->hcnsModel::ID, $id)->update($result);
        return $update;
    }

    /**

    * Get list resouce by data search
    * @param Array $data
    * @param boolen $export
    * @return collection
    */
    public function getAllRecord($data=[], $export = false) {

        $listRecord = $this->hcnsModel;
        if(!empty($data['user_name'])) {
            $listRecord = $listRecord->where(Hcns::USER_NAME, '$regex', '/'.trim($data['user_name']).'/i');
        }
        if(!empty($data['user_phone'])) {
            $listRecord = $listRecord->where(Hcns::USER_PHONE, '$regex', '/'.trim($data['user_phone']).'/i');
        }
        if(!empty($data['user_identify'])) {
            $listRecord = $listRecord->where(Hcns::USER_IDENTIFY, '$regex', '/'.trim($data['user_identify']).'/i');
        }
        if(!empty($data['user_passport'])) {
            $listRecord = $listRecord->where(Hcns::USER_PASSPORT, '$regex', '/'.trim($data['user_passport']).'/i');
        }
        if ($export) {
            return $listRecord
            ->orderBy($this->hcnsModel::CREATED_AT, 'DESC')
            ->get();
        } else {
            return $listRecord
            ->orderBy($this->hcnsModel::CREATED_AT, 'DESC')
            ->paginate(10);
        }

    }

    /**
     * find record
     * @param String $id
     * @return Collection
     */
    public function findRecord($id) {
        $record = $this->hcnsModel::where($this->hcnsModel::ID, $id)->find($id);
        if ($record) {
            return $record;
        }
    }

    /**
    * Check identify unique
    * @param String $id
    * @param String $identify
    * @return bool
    */
    public function checkExistIdentify($id, $identify) {
        $record = NULL;
        if ($id) {
            $record = $this->hcnsModel::where($this->hcnsModel::ID, '!=', $id)
            ->where($this->hcnsModel::USER_IDENTIFY, $identify)->first();
        } else {
            $record = $this->hcnsModel::where($this->hcnsModel::USER_IDENTIFY, $identify)->first();
        }

        if ($record) {
            return true;
        } else {
            return false;
        }
    }

        /**
    * Check passport unique
    * @param String $id
    * @param String $passport
    * @return bool
    */
    public function checkExistPassport($id, $passport) {
        $record = NULL;
        if ($id) {
            $record = $this->hcnsModel::where($this->hcnsModel::ID, '!=', $id)
            ->where($this->hcnsModel::USER_PASSPORT, $passport)->first();
        } else {
            $record = $this->hcnsModel::where($this->hcnsModel::USER_PASSPORT, $passport)->first();
        }

        if ($record) {
            return true;
        } else {
            return false;
        }
    }

    public function getHcns() {
        $records = $this->hcnsModel::get();
        return $records;
    }

    public function updateScan($data = [], $id)
    {
        $result = [];
        if(isset($data['scan'])) {
            $result[Hcns::SCAN] = $data['scan'];
        }
        $update = $this->hcnsModel::where($this->hcnsModel::ID, $id)->update($result);
        return $update;
    }

    public function getALlHcnsScan()
    {
        $listRecord = $this->hcnsModel;
        $listRecord = $this->hcnsModel::where($this->hcnsModel::SCAN, $this->hcnsModel::YET_SCAN)->get();
        return $listRecord;

    }

    public function getHcnsWithNoScan()
    {
        $records = Hcns::where(Hcns::SCAN, '$exists', false)->get();
        return $records;

    }

    public function addScanHcns($id)
    {
        $result = [];
        $result[Hcns::SCAN] = Hcns::YET_SCAN;
        $update = $this->hcnsModel::where(Hcns::ID, $id)->update($result);
        return $update;

    }
}
