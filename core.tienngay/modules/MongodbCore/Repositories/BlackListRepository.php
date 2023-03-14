<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Entities\BlackList;
use Modules\MongodbCore\Repositories\Interfaces\BlackListRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use MongoDB\BSON\Regex;

class BlackListRepository implements BlackListRepositoryInterface
{
    /**
     * @var Model
     */
    protected $blacklistModel;


    /**
     * HcnsRepository .
     *
     * @param BlackList
     */
    public function __construct(BlackList $blacklistModel)
    {
        $this->blacklistModel = $blacklistModel;
    }

    public function createProperty($data = [])
    {
        $result = [];
//dd($data);
        if (!empty($data[BlackList::NAME])) {
            $result[BlackList::NAME] = $data[BlackList::NAME];
        }

        if (!empty($data[BlackList::PHONE])) {
            $result[BlackList::PHONE] = $data[BlackList::PHONE];
        }

        if (!empty($data[BlackList::IDENTIFY])) {
            $result[BlackList::IDENTIFY] = $data[Blacklist::IDENTIFY];
        } else {
            $result[BlackList::IDENTIFY] = "";
        }

        if (!empty($data[BlackList::PASSPORT])) {
            $result[BlackList::PASSPORT] = $data[BlackList::PASSPORT];
        } else {
            $result[BlackList::PASSPORT] = "";
        }

        if (!empty($data[BlackList::ID_HCNS])) {
            $result[BlackList::ID_HCNS] = $data[BlackList::ID_HCNS];
        } else {
            $result[BlackList::ID_HCNS] = "";
        }

        if (!empty($data[BlackList::ID_EXEMTION])) {
            $result[BlackList::ID_EXEMTION] = $data[BlackList::ID_EXEMTION];
        } else {
            $result[BlackList::ID_EXEMTION] = "";
        }

        if (!empty($data[BlackList::ID_PROPERTY])) {
            $result[BlackList::ID_PROPERTY] = $data[BlackList::ID_PROPERTY];
        } else {
            $result[BlackList::ID_PROPERTY] = "";
        }

        if (!empty($data[BlackList::CREATED_AT])) {
            $result[BlackList::CREATED_AT] = $data[BlackList::CREATED_AT];
        }

        if (!empty($data[BlackList::CREATED_BY])) {
            $result[BlackList::CREATED_BY] = $data[BlackList::CREATED_BY];
        }

        $create = $this->blacklistModel->create($result);
        return $create;
    }

    public function getAllBlackList()
    {
        $blackList = $this->blacklistModel;
        return $blackList
            ->orderBy(BlackList::CREATED_AT, "ASC")
            ->get();
    }

    public function search($data = [])
    {
        $listRecord = $this->blacklistModel;
        if (!empty($data['from_date']) && !empty($data['to_date'])) {
            $from_date = strtotime(trim($data['from_date']) . ' 00:00:00');
            $to_date = strtotime(trim($data['to_date']) . ' 23:59:59');
            $listRecord = $listRecord->whereBetween('created_at', [$from_date, $to_date]);
        }
        if (!empty($data['user_name'])) {
            $listRecord = $listRecord->where(BlackList::NAME, '$regex', '/' . trim($data['user_name']) . '/i');
        }
        if (!empty($data['user_phone'])) {
            $listRecord = $listRecord->where(BlackList::PHONE, '$regex', '/' . trim($data['user_phone']) . '/i');
        }
        if (!empty($data['user_identify'])) {
            $listRecord = $listRecord->where(BlackList::IDENTIFY, '$regex', '/' . trim($data['user_identify']) . '/i');
        }
        if (!empty($data['user_passport'])) {
            $listRecord = $listRecord->where(BlackList::PASSPORT, '$regex', '/' . trim($data['user_passport']) . '/i');
        }
        if (!empty($data['id_blacklist']) && $data['id_blacklist'] == 1) {
            $listRecord = $listRecord->where(BlackList::ID_PROPERTY, '!=', "");
        }
        if (!empty($data['id_blacklist']) && $data['id_blacklist'] == 2) {
            $listRecord = $listRecord->where(BlackList::ID_HCNS, '!=', "");
        }
        if (!empty($data['id_blacklist']) && $data['id_blacklist'] == 3) {
            $listRecord = $listRecord->where(BlackList::ID_EXEMTION, '!=', "");
        }
        $listRecord->options([
            'collation' => [
            'locale' => 'en',
            'strength' => 1
        ]]);
        return $listRecord->get();
    }

    public function createHcns($data = [])
    {
        $result = [];
        if (!empty($data[BlackList::NAME])) {
            $result[BlackList::NAME] = $data[BlackList::NAME];
        }
        if (!empty($data[BlackList::PHONE])) {
            $result[BlackList::PHONE] = $data[BlackList::PHONE];
        }
        if (!empty($data[BlackList::IDENTIFY])) {
            $result[BlackList::IDENTIFY] = $data[BlackList::IDENTIFY];
        }
        if (!empty($data[BlackList::PASSPORT])) {
            $result[BlackList::PASSPORT] = $data[BlackList::PASSPORT];
        }
        if (!empty($data[BlackList::ID_HCNS])) {
            $result[BlackList::ID_HCNS] = $data[BlackList::ID_HCNS];
        } else {
            $result[BlackList::ID_HCNS] = "";
        }
        if (!empty($data[BlackList::ID_EXEMTION])) {
            $result[BlackList::ID_EXEMTION] = $data[BlackList::ID_EXEMTION];
        } else {
            $result[BlackList::ID_EXEMTION] = "";
        }
        if (!empty($data[BlackList::ID_PROPERTY])) {
            $result[BlackList::ID_PROPERTY] = $data[BlackList::ID_PROPERTY];
        } else {
            $result[BlackList::ID_PROPERTY] = "";
        }
        if (!empty($data[BlackList::CREATED_AT])) {
            $result[BlackList::CREATED_AT] = $data[BlackList::CREATED_AT];
        }
        if (!empty($data[BlackList::CREATED_BY])) {
            $result[BlackList::CREATED_BY] = $data[BlackList::CREATED_BY];
        }
        $create = $this->blacklistModel->create($result);
        return $create;
    }

    public function createExemtion($data = [])
    {
        $result = [];
        if (!empty($data[BlackList::NAME])) {
            $result[BlackList::NAME] = $data[BlackList::NAME];
        }
        if (!empty($data[BlackList::PHONE])) {
            $result[BlackList::PHONE] = $data[BlackList::PHONE];
        }
        if (!empty($data[BlackList::IDENTIFY])) {
            $result[BlackList::IDENTIFY] = $data[BlackList::IDENTIFY];
        }
        if (!empty($data[BlackList::PASSPORT])) {
            $result[BlackList::PASSPORT] = $data[BlackList::PASSPORT];
        } else {
            $result[BlackList::PASSPORT] = "";
        }
        if (!empty($data[BlackList::ID_HCNS])) {
            $result[BlackList::ID_HCNS] = $data[BlackList::ID_HCNS];
        } else {
            $result[BlackList::ID_HCNS] = "";
        }
        if (!empty($data[BlackList::ID_EXEMTION])) {
            $result[BlackList::ID_EXEMTION] = $data[BlackList::ID_EXEMTION];
        }
        if (!empty($data[BlackList::ID_PROPERTY])) {
            $result[BlackList::ID_PROPERTY] = $data[BlackList::ID_PROPERTY];
        } else {
            $result[BlackList::ID_PROPERTY] = "";
        }
        if (!empty($data[BlackList::ID_CONTRACT_EXEMTION])) {
            $result[BlackList::ID_CONTRACT_EXEMTION] = $data[BlackList::ID_CONTRACT_EXEMTION];
        }
        if (!empty($data[BlackList::CREATED_AT])) {
            $result[BlackList::CREATED_AT] = $data[BlackList::CREATED_AT];
        }
        if (!empty($data[BlackList::CREATED_BY])) {
            $result[BlackList::CREATED_BY] = $data[BlackList::CREATED_BY];
        }
        $create = $this->blacklistModel->create($result);
        return $create;
    }

    public function findExemtion($identify)
    {
        $record = BlackList::where(BlackList::IDENTIFY, $identify)->where(BlackList::ID_EXEMTION, '!=', "")->first();
        return $record;

    }

    public function updateIdExemtion($data = [], $id)
    {
        $result = [];
        if (!empty($data[BlackList::ID_EXEMTION])) {
            $result[BlackList::ID_EXEMTION] = $data[BlackList::ID_EXEMTION];
        }
        if (!empty($data[BlackList::ID_CONTRACT_EXEMTION])) {
            $result[BlackList::ID_CONTRACT_EXEMTION] = $data[BlackList::ID_CONTRACT_EXEMTION];
        }
        $update = $this->blacklistModel::where(BlackList::ID, $id)->push($result);
        return $update;
    }

    public function getAllExemtion()
    {
        $result = BlackList::where(BlackList::ID_CONTRACT_EXEMTION, '$exists', true)->get();
        return $result;
    }

    public function getExemtion($id)
    {
        $result = BlackList::where(BlackList::ID, $id)->first();
        return $result;
    }

    public function findProperty($id)
    {
        $result = BlackList::where(BlackList::ID_PROPERTY, $id)->first();
        return $result;
    }

    public function updateProperty($data = [], $id)
    {
        if (!empty($data[BlackList::NAME])) {
            $result[BlackList::NAME] = $data[BlackList::NAME];
        }

        if (!empty($data[BlackList::PHONE])) {
            $result[BlackList::PHONE] = $data[BlackList::PHONE];
        }

        if (!empty($data[BlackList::IDENTIFY])) {
            $result[BlackList::IDENTIFY] = $data[Blacklist::IDENTIFY];
        } else {
            $result[BlackList::IDENTIFY] = "";
        }

        if (!empty($data[BlackList::PASSPORT])) {
            $result[BlackList::PASSPORT] = $data[BlackList::PASSPORT];
        } else {
            $result[BlackList::PASSPORT] = "";
        }

        if (!empty($data[BlackList::ID_HCNS])) {
            $result[BlackList::ID_HCNS] = $data[BlackList::ID_HCNS];
        } else {
            $result[BlackList::ID_HCNS] = "";
        }

        if (!empty($data[BlackList::ID_EXEMTION])) {
            $result[BlackList::ID_EXEMTION] = $data[BlackList::ID_EXEMTION];
        } else {
            $result[BlackList::ID_EXEMTION] = "";
        }

        if (!empty($data[BlackList::ID_PROPERTY])) {
            $result[BlackList::ID_PROPERTY] = $data[BlackList::ID_PROPERTY];
        } else {
            $result[BlackList::ID_PROPERTY] = "";
        }

        if (!empty($data[BlackList::CREATED_AT])) {
            $result[BlackList::CREATED_AT] = $data[BlackList::CREATED_AT];
        }

        if (!empty($data[BlackList::CREATED_BY])) {
            $result[BlackList::CREATED_BY] = $data[BlackList::CREATED_BY];
        }
        if (!empty($data[BlackList::UPDATED_AT])) {
            $result[BlackList::UPDATED_AT] = $data[BlackList::UPDATED_AT];
        }

        if (!empty($data[BlackList::UPDATED_BY])) {
            $result[BlackList::UPDATED_BY] = $data[BlackList::UPDATED_BY];
        }
         $update = $this->blacklistModel::where(BlackList::ID, $id)->update($result);
        return $update;

    }

    public function findSameId($id)
    {
        $result = BlackList::where(BlackList::IDENTIFY, $id)->first();
        return $result;
    }

    public function findSamePassport($passport)
    {
        $result = BlackList::where(BlackList::PASSPORT, $passport)->first();
        return $result;
    }

    public function updatePropertyID($data = [], $id)
    {
        if (!empty($data[BlackList::NAME])) {
            $result[BlackList::NAME] = $data[BlackList::NAME];
        }

        if (!empty($data[BlackList::PHONE])) {
            $result[BlackList::PHONE] = $data[BlackList::PHONE];
        }

        if (!empty($data[BlackList::IDENTIFY])) {
            $result[BlackList::IDENTIFY] = $data[Blacklist::IDENTIFY];
        } else {
            $result[BlackList::IDENTIFY] = "";
        }

        if (!empty($data[BlackList::PASSPORT])) {
            $result[BlackList::PASSPORT] = $data[BlackList::PASSPORT];
        } else {
            $result[BlackList::PASSPORT] = "";
        }

        if (!empty($data[BlackList::ID_HCNS])) {
            $result[BlackList::ID_HCNS] = $data[BlackList::ID_HCNS];
        } else {
            $result[BlackList::ID_HCNS] = "";
        }

        if (!empty($data[BlackList::ID_EXEMTION])) {
            $result[BlackList::ID_EXEMTION] = $data[BlackList::ID_EXEMTION];
        } else {
            $result[BlackList::ID_EXEMTION] = "";
        }

        if (!empty($data[BlackList::ID_PROPERTY])) {
            $result[BlackList::ID_PROPERTY] = $data[BlackList::ID_PROPERTY];
        } else {
            $result[BlackList::ID_PROPERTY] = "";
        }

        if (!empty($data[BlackList::CREATED_AT])) {
            $result[BlackList::CREATED_AT] = $data[BlackList::CREATED_AT];
        }

        if (!empty($data[BlackList::CREATED_BY])) {
            $result[BlackList::CREATED_BY] = $data[BlackList::CREATED_BY];
        }
        if (!empty($data[BlackList::UPDATED_AT])) {
            $result[BlackList::UPDATED_AT] = $data[BlackList::UPDATED_AT];
        }

        if (!empty($data[BlackList::UPDATED_BY])) {
            $result[BlackList::UPDATED_BY] = $data[BlackList::UPDATED_BY];
        }
        $update = $this->blacklistModel::where(BlackList::ID, $id)->update($result);
        return $update;

    }

    public function getBlacklistPropertyAndRemove()
    {
        $result = [];
        $property = Blacklist::where(BlackList::ID_PROPERTY, '!=', "")->delete();
        return $property;

    }

}
