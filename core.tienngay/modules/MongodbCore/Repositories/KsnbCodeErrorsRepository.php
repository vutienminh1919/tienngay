<?php


namespace Modules\MongodbCore\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\MongodbCore\Entities\KsnbCodeError;
use Modules\MongodbCore\Repositories\KsnbCodeErrorsRepositoryInterface;

class KsnbCodeErrorsRepository implements KsnbCodeErrorsRepositoryInterface
{
    /**
     * @var Model
     */
     protected $ksnbCodeErrorsModel;

    /**
     * StoreRepository constructor.
     *
     * @param KsnbCodeError $ksnbCodeError
     */
    public function __construct(KsnbCodeError $ksnbCodeError) {
        $this->ksnbCodeErrorsModel = $ksnbCodeError;
    }

//cập nhật mẫ lỗi trong bảng mã lỗi của biên bản ksnb
    public function updateKsnbErrors($data, $id)
    {
        $result = [];
        if (isset($data['code_error'])) {
            $result[$this->ksnbCodeErrorsModel::COLUMN_CODE_ERROR] = ucfirst($data['code_error']);
        }
        if (isset($data['description'])) {
            $result[$this->ksnbCodeErrorsModel::COLUMN_DESCRIPTION] = $data['description'];
        }
        if (isset($data['type'])) {
            $result[$this->ksnbCodeErrorsModel::COLUMN_TYPE] = $data['type'];
            $result[$this->ksnbCodeErrorsModel::COLUMN_TYPE_NAME] = $this->ksnbCodeErrorsModel::getTypeName($data['type']);
        }
        if (isset($data['punishment'])) {
            $result[$this->ksnbCodeErrorsModel::COLUMN_PUNISHMENT] = $data['punishment'];
            $result[$this->ksnbCodeErrorsModel::COLUMN_PUNISHMENT_NAME] = $this->ksnbCodeErrorsModel::getPunishmentName($data['punishment']);
        }
        if (isset($data['discipline'])) {
            $result[$this->ksnbCodeErrorsModel::COLUMN_DISCIPLINE] = $data['discipline'];
            $result[$this->ksnbCodeErrorsModel::COLUMN_DISCIPLINE_NAME] = $this->ksnbCodeErrorsModel::getDisciplineName($data['discipline']);
        }
        if (isset($data['update_by'])){
            $result[$this->ksnbCodeErrorsModel::COLUMN_UPDATED_BY] = $data['update_by'];
        }
        if (isset($data['quote_document'])) {
            $result[$this->ksnbCodeErrorsModel::COLUMN_QUOTE_DOCUMENT] = $data['quote_document'];
        }
        if (isset($data['no'])) {
            $result[$this->ksnbCodeErrorsModel::COLUMN_NO] = $data['no'];
        }
        if (isset($data['sign_day'])) {
            $result[$this->ksnbCodeErrorsModel::COLUMN_SIGN_DAY] = $data['sign_day'];
        }
        if (empty($result)) {
            return false;
        }
        $update = $this->ksnbCodeErrorsModel::where($this->ksnbCodeErrorsModel::COLUMN_ID, $id)
        ->update($result);
        return $update;
    }

//Tạo mới mẫ lỗi trong bảng mã lỗi của biên bản ksnb
    public function createKsnbErrors($data = [])
    {
        $result = [];
        if (isset($data['code_error'])) {
            $result[$this->ksnbCodeErrorsModel::COLUMN_CODE_ERROR] = ucfirst($data['code_error']);
        }
        if (isset($data['description'])) {
            $result[$this->ksnbCodeErrorsModel::COLUMN_DESCRIPTION] = $data['description'];
        }
        if (isset($data['type'])) {
            $result[$this->ksnbCodeErrorsModel::COLUMN_TYPE] = $data['type'];
            $result[$this->ksnbCodeErrorsModel::COLUMN_TYPE_NAME] = $this->ksnbCodeErrorsModel::getTypeName($data['type']);
        }
        if (isset($data['punishment'])) {
            $result[$this->ksnbCodeErrorsModel::COLUMN_PUNISHMENT] = $data['punishment'];
            $result[$this->ksnbCodeErrorsModel::COLUMN_PUNISHMENT_NAME] = $this->ksnbCodeErrorsModel::getPunishmentName($data['punishment']);
        }
        if (isset($data['discipline'])) {
            $result[$this->ksnbCodeErrorsModel::COLUMN_DISCIPLINE] = $data['discipline'];
            $result[$this->ksnbCodeErrorsModel::COLUMN_DISCIPLINE_NAME] = $this->ksnbCodeErrorsModel::getDisciplineName($data['discipline']);
        }
        if (isset($data['create_by'])) {
            $result[$this->ksnbCodeErrorsModel::COLUMN_CREATED_BY] = $data['create_by'];
        }
        if (isset($data['status'])){
            $result[$this->ksnbCodeErrorsModel::COLUMN_STATUS]=$data['status'];
        }
        if (isset($data['quote_document'])) {
            $result[$this->ksnbCodeErrorsModel::COLUMN_QUOTE_DOCUMENT] = $data['quote_document'];
        }
        if (isset($data['no'])) {
            $result[$this->ksnbCodeErrorsModel::COLUMN_NO] = $data['no'];
        }
        if (isset($data['sign_day'])) {
            $result[$this->ksnbCodeErrorsModel::COLUMN_SIGN_DAY] = $data['sign_day'];
        }

        $create = $this->ksnbCodeErrorsModel->create($result);
        return $create;
    }

//Lấy ra từng bản ghi mẫ lỗi trong bảng mã lỗi của biên bản ksnb
    public function showKsnbErrors($id)
    {
        $show = $this->ksnbCodeErrorsModel->find($id);
        return $show;
    }

//Lấy ra hết bản ghi mẫ lỗi trong bảng mã lỗi của biên bản ksnb
    public function getAllKsnbErrors($dataSearch = [])
    {
        $searchArr = [];
        if(!empty($dataSearch['status'])) {
            $searchArr[] = [KsnbCodeError::COLUMN_STATUS, '=', trim($dataSearch['status'])];
        }
        if(!empty($dataSearch['type'])) {
            $searchArr[] = [KsnbCodeError::COLUMN_TYPE, '=', trim($dataSearch['type'])];
        }
        if(!empty($dataSearch['discipline'])) {
            $searchArr[] = [KsnbCodeError::COLUMN_DISCIPLINE, '=', trim($dataSearch['discipline'])];
        }
        if(!empty($dataSearch['punishment'])) {
            $searchArr[] = [KsnbCodeError::COLUMN_PUNISHMENT, '=', trim($dataSearch['punishment'])];
        }
        if(!empty($dataSearch['code_error'])) {
            $searchArr[] = [KsnbCodeError::COLUMN_CODE_ERROR, '=', trim($dataSearch['code_error'])];
        }
        $list_ksnb = $this->ksnbCodeErrorsModel;
        return $list_ksnb
        ->where($searchArr)
        ->orderBy($this->ksnbCodeErrorsModel::COLUMN_CREATED_AT, "DESC")
        ->paginate(15);
    }

 //Cập nhật trạng thái mẫ lỗi trong bảng mã lỗi của biên bản ksnb
    public function update_status($id)
    {
        $ksnb_code = $this->ksnbCodeErrorsModel::where($this->ksnbCodeErrorsModel::COLUMN_ID, $id)->find($id);
        if ($ksnb_code['status'] == $this->ksnbCodeErrorsModel::COLUMN_ACTIVE){
            $this->ksnbCodeErrorsModel::where($this->ksnbCodeErrorsModel::COLUMN_ID, $id)->update([$this->ksnbCodeErrorsModel::COLUMN_STATUS=>$this->ksnbCodeErrorsModel::COLUMN_BLOCK]);
        }else{
            $this->ksnbCodeErrorsModel::where($this->ksnbCodeErrorsModel::COLUMN_ID, $id,)->update([$this->ksnbCodeErrorsModel::COLUMN_STATUS=>$this->ksnbCodeErrorsModel::COLUMN_ACTIVE]);
        }
    }

    public function find($id)
    {
        $result = $this->ksnbCodeErrorsModel::where($this->ksnbCodeErrorsModel::COLUMN_ID, $id)->find($id);
        return $result;
    }

    //lấy hết tất cả mã lỗi theo nhóm vi phạm
    public function getCodeByType($type)
    {
        $listCode = $this->ksnbCodeErrorsModel::where($this->ksnbCodeErrorsModel::COLUMN_TYPE, $type)
        ->where($this->ksnbCodeErrorsModel::COLUMN_STATUS, $this->ksnbCodeErrorsModel::COLUMN_ACTIVE)->get();
        return $listCode;
    }

    //lấy chế tài phạt theo mã lỗi
    public function getPunishmentByCode($code)
    {
        $listCode = $this->ksnbCodeErrorsModel::where($this->ksnbCodeErrorsModel::COLUMN_CODE_ERROR, $code)->get();
        return $listCode;
    }

    //lấy hình thức kỷ luật theo mã lỗi
    public function getDisciplineByCode($code)
    {
        $listCode = $this->ksnbCodeErrorsModel::where($this->ksnbCodeErrorsModel::COLUMN_CODE_ERROR, $code)->get();
        return $listCode;
    }



    //lấy mô tả mã lỗi theo mã lỗi
    public function getDescription($code)
    {
        $listCode = $this->ksnbCodeErrorsModel::where($this->ksnbCodeErrorsModel::COLUMN_CODE_ERROR, $code)->get();
        return $listCode;
    }

    public function checkExistCodeError($id, $codeError) {
        $result = $this->ksnbCodeErrorsModel::where($this->ksnbCodeErrorsModel::COLUMN_ID, '!=', $id)
            ->where($this->ksnbCodeErrorsModel::COLUMN_CODE_ERROR, $codeError)
            ->first();
        if ($result) {
            return true;
        }
        return false;
    }

    /**
    * get all item
    * @param $selectFileds Array
    * @return $listCode Array
    */
    public function getAllErrorCodes($selectFileds = false)
    {
        $listCode = [];
        if ($selectFileds) {
            $listCode = $this->ksnbCodeErrorsModel::where($this->ksnbCodeErrorsModel::COLUMN_STATUS, $this->ksnbCodeErrorsModel::COLUMN_ACTIVE)->get($selectFileds);
        } else {
            $listCode = $this->ksnbCodeErrorsModel::where($this->ksnbCodeErrorsModel::COLUMN_STATUS, $this->ksnbCodeErrorsModel::COLUMN_ACTIVE)->get();
        }
        return $listCode;
    }

    /**
    * get item information
    * @param $code String
    * @return $errorCode collection
    */
    public function getErrorCodeInfo($code)
    {
        $errorCode = $this->ksnbCodeErrorsModel::where($this->ksnbCodeErrorsModel::COLUMN_CODE_ERROR, $code)
        ->where($this->ksnbCodeErrorsModel::COLUMN_STATUS, $this->ksnbCodeErrorsModel::COLUMN_ACTIVE)->first();
        if ($errorCode) {
            return $errorCode->toArray();
        }
        return false;
    }

    public function getCodesNoQuote()
    {
        $result = KsnbCodeError::where(KsnbCodeError::COLUMN_QUOTE_DOCUMENT, '$exists', false)->get();
        if ($result) {
            return $result;
        }
        return false;
    }

    public function addQuoteDocument($id)
    {
        $result = [];
        $result[KsnbCodeError::COLUMN_QUOTE_DOCUMENT] = config('mongodbcore.quote');
        $result[KsnbCodeError::COLUMN_NO] = config('mongodbcore.no');
        $result[KsnbCodeError::COLUMN_SIGN_DAY] = config('mongodbcore.sign_day');
        $update = $this->ksnbCodeErrorsModel::where(KsnbCodeError::COLUMN_ID, $id)->update($result);
        return $update;

    }

    public function getQuoteDocument($code)
    {
        $result = KsnbCodeError::where(KsnbCodeError::COLUMN_CODE_ERROR, $code)->get();
        if ($result) {
            return $result;
        }
        return false;
    }
}
