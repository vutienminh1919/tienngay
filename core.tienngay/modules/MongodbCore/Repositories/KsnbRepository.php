<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Entities\ReportsKsnb;
use Modules\MongodbCore\Repositories\Interfaces\KsnbRepositoryInterface;
use Modules\MongodbCore\Entities\KsnbCodeError;
use Modules\MongodbCore\Repositories\KsnbCodeErrorsRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class KsnbRepository implements KsnbRepositoryInterface
{

    /**
     * @var Model
     */
     protected $ksnbModel;
     protected $ksnbCodeErrorModel;

    /**
     * KsnbRepository .
     *
     * @param ReportsKsnb
     */
    public function __construct(ReportsKsnb $ksnbModel, KsnbCodeError $ksnbCodeErrorModel) {
        $this->ksnbModel = $ksnbModel;
        $this->ksnbCodeErrorModel = $ksnbCodeErrorModel;
    }

    /**
     * Get vpb_store_code
     *
     * @param  string  $storeId
     * @return boolean
     */

    public function createReport($data = []){
        $result = [];
        if(!empty($data['code_error'])) {
            $result[$this->ksnbModel::COLUMN_CODE_ERROR] = $data['code_error'];
        }
        if(!empty($data['description'])) {
            $result[$this->ksnbModel::COLUMN_DESCRIPTION] = $data['description'];
        }
        if(!empty($data['description_error'])) {
            $result[$this->ksnbModel::COLUMN_DESCRIPTION_ERROR] = $data['description_error'];
        }
        if(!empty($data['discipline'])) {
            $result[$this->ksnbModel::COLUMN_DISCIPLINE] = $data['discipline'];
            $result[$this->ksnbModel::COLUMN_DISCIPLINE_NAME] = $this->ksnbCodeErrorModel::getDisciplineName($data['discipline']);
        }
        if(!empty($data['punishment'])) {
            $result[$this->ksnbModel::COLUMN_PUNISHMENT] = $data['punishment'];
            $result[$this->ksnbModel::COLUMN_PUNISHMENT_NAME] = $this->ksnbCodeErrorModel::getPunishmentName($data['punishment']);
        }
        if(!empty($data['type'])) {
            $result[$this->ksnbModel::COLUMN_TYPE] = $data['type'];
            $result[$this->ksnbModel::COLUMN_TYPE_NAME] = $this->ksnbCodeErrorModel::getTypeName($data['type']);
        }
        $result[$this->ksnbModel::COLUMN_STATUS] = ReportsKsnb:: COLUMN_STATUS_NEW;

        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_WAIT_CONFRIM;

        if(!empty($data['created_by'])) {
            $result[$this->ksnbModel::COLUMN_CREATED_BY] = $data['created_by'];
        }
        if(!empty($data[$this->ksnbModel::COLUMN_IMAGE_PATH])) {
            $result[$this->ksnbModel::COLUMN_IMAGE_PATH] = $data[$this->ksnbModel::COLUMN_IMAGE_PATH];
        }


        if(!empty($data[$this->ksnbModel::COLUMN_USER_NAME])) {
            $result[$this->ksnbModel::COLUMN_USER_NAME] = $data[$this->ksnbModel::COLUMN_USER_NAME];
        }
        if(!empty($data[$this->ksnbModel::COLUMN_USER_EMAIL])) {
            $result[$this->ksnbModel::COLUMN_USER_EMAIL] = $data[$this->ksnbModel::COLUMN_USER_EMAIL];
        }
        if(!empty($data[$this->ksnbModel::COLUMN_STORE_NAME])) {
            $result[$this->ksnbModel::COLUMN_STORE_NAME] = $data[$this->ksnbModel::COLUMN_STORE_NAME];
        }
        if(!empty($data[$this->ksnbModel::COLUMN_STORE_ID])) {
            $result[$this->ksnbModel::COLUMN_STORE_ID] = $data[$this->ksnbModel::COLUMN_STORE_ID];
        }
        if(!empty($data[$this->ksnbModel::COLUMN_STORE_EMAIL_TPGD])) {
            $result[$this->ksnbModel::COLUMN_STORE_EMAIL_TPGD] = $data[$this->ksnbModel::COLUMN_STORE_EMAIL_TPGD];
        }
        if(!empty($data['quote_document'])) {
            $result[ReportsKsnb::COLUMN_QUOTE_DOCUMENT] = $data['quote_document'];
        }
        if(!empty($data['no'])) {
            $result[ReportsKsnb::COLUMN_NO] = $data['no'];
        }
        if(!empty($data['sign_day'])) {
            $result[ReportsKsnb::COLUMN_SIGN_DAY] = $data['sign_day'];
        }

        $create = $this->ksnbModel->create($result);
        return $create;
    }
//Cập nhật biên bản ksnb
    public function updateReport($data = [], $id) {
        $result = [];
        if(isset($data['code_error'])) {
            $result[$this->ksnbModel::COLUMN_CODE_ERROR] = $data['code_error'];
        }
        if(isset($data['description'])) {
            $result[$this->ksnbModel::COLUMN_DESCRIPTION] = $data['description'];
        }
        if(isset($data['description_error'])) {
            $result[$this->ksnbModel::COLUMN_DESCRIPTION_ERROR] = $data['description_error'];
        }
        if(isset($data['discipline'])) {
            $result[$this->ksnbModel::COLUMN_DISCIPLINE] = $data['discipline'];
            $result[$this->ksnbModel::COLUMN_DISCIPLINE_NAME] = $this->ksnbCodeErrorModel::getDisciplineName($data['discipline']);
        }
        if(isset($data['punishment'])) {
            $result[$this->ksnbModel::COLUMN_PUNISHMENT] = $data['punishment'];
            $result[$this->ksnbModel::COLUMN_PUNISHMENT_NAME] = $this->ksnbCodeErrorModel::getPunishmentName($data['punishment']);
        }
        if(isset($data['type'])) {
            $result[$this->ksnbModel::COLUMN_TYPE] = $data['type'];
            $result[$this->ksnbModel::COLUMN_TYPE_NAME] = $this->ksnbCodeErrorModel::getTypeName($data['type']);
        }
         if (!empty($data['updated_by'])){
            $result[$this->ksnbModel::COLUMN_UPDATED_BY] = $data['updated_by'];
        }

        if(!empty($data[$this->ksnbModel::COLUMN_IMAGE_NAME])) {
            $result[$this->ksnbModel::COLUMN_IMAGE_NAME] = $data[$this->ksnbModel::COLUMN_IMAGE_NAME];
        }
        if(!empty($data[$this->ksnbModel::COLUMN_IMAGE_TYPE])) {
            $result[$this->ksnbModel::COLUMN_IMAGE_TYPE] = $data[$this->ksnbModel::COLUMN_IMAGE_TYPE];
        }
        if(isset($data[$this->ksnbModel::COLUMN_USER_NAME])) {
            $result[$this->ksnbModel::COLUMN_USER_NAME] = $data[$this->ksnbModel::COLUMN_USER_NAME];
        }
        if(isset($data[$this->ksnbModel::COLUMN_USER_EMAIL])) {
            $result[$this->ksnbModel::COLUMN_USER_EMAIL] = $data[$this->ksnbModel::COLUMN_USER_EMAIL];
        }
        if(isset($data[$this->ksnbModel::COLUMN_STORE_NAME])) {
            $result[$this->ksnbModel::COLUMN_STORE_NAME] = $data[$this->ksnbModel::COLUMN_STORE_NAME];
        }
        if(!empty($data[$this->ksnbModel::COLUMN_STORE_ID])) {
            $result[$this->ksnbModel::COLUMN_STORE_ID] = $data[$this->ksnbModel::COLUMN_STORE_ID];
        }
        if(isset($data[$this->ksnbModel::COLUMN_STORE_EMAIL_TPGD])) {
            $result[$this->ksnbModel::COLUMN_STORE_EMAIL_TPGD] = $data[$this->ksnbModel::COLUMN_STORE_EMAIL_TPGD];
        }
        if(isset($data[$this->ksnbModel::COLUMN_STORE_EMAIL_ASM])) {
            $result[$this->ksnbModel::COLUMN_STORE_EMAIL_ASM] = $data[$this->ksnbModel::COLUMN_STORE_EMAIL_ASM];
        }
        if(!empty($data[$this->ksnbModel::COLUMN_IMAGE_PATH])) {
            $result[$this->ksnbModel::COLUMN_IMAGE_PATH] = $data[$this->ksnbModel::COLUMN_IMAGE_PATH];
        }
        if(!empty($data['quote_document'])) {
            $result[ReportsKsnb::COLUMN_QUOTE_DOCUMENT] = $data['quote_document'];
        }
        if(!empty($data['no'])) {
            $result[ReportsKsnb::COLUMN_NO] = $data['no'];
        }
        if(!empty($data['sign_day'])) {
            $result[ReportsKsnb::COLUMN_SIGN_DAY] = $data['sign_day'];
        }

        $update = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        return $update;
    }

    //Lấy hết biên bản ksnb
    public function getAllReport($dataSearch = []) {
        $searchArr = [];
        if(!empty($dataSearch['status'])) {
            $searchArr[] = [ReportsKsnb::COLUMN_STATUS, '=', trim($dataSearch['status'])];
        }
        if(!empty($dataSearch['start_date'])) {
            $startDate = Carbon::parse(trim($dataSearch['start_date']) . ' 00:00:00');
            $searchArr[] = [(ReportsKsnb::COLUMN_CREATED_AT), '>=', $startDate];
        }
        if(!empty($dataSearch['end_date'])) {
            $endDate =  Carbon::parse(trim($dataSearch['end_date']) . ' 23:59:59');
            $searchArr[] = [(ReportsKsnb::COLUMN_CREATED_AT), '<=', $endDate];
        }
        if(!empty($dataSearch['user_email'])) {
            $searchArr[] = [ReportsKsnb::COLUMN_USER_EMAIL, '=', trim($dataSearch['user_email'])];
        }
        if(!empty($dataSearch['process'])) {
            $searchArr[] = [ReportsKsnb::COLUMN_PROCESS, '=', trim($dataSearch['process'])];
        }
        if(!empty($dataSearch['type'])) {
            $searchArr[] = [ReportsKsnb::COLUMN_TYPE, '=', trim($dataSearch['type'])];
        }
        if(!empty($dataSearch['discipline'])) {
            $searchArr[] = [ReportsKsnb::COLUMN_DISCIPLINE, '=', trim($dataSearch['discipline'])];
        }

        $result = $this->ksnbModel
        ->where($searchArr)
        ->where(ReportsKsnb::COLUMN_FLAG, 'exists', false)
        ->orderBy($this->ksnbModel::COLUMN_CREATED_AT, "DESC")
        ->paginate(15);
        return $result;

    }

    //Lấy từng  biên bản ksnb
    public function find($id) {
        $show = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->find($id);
        return $show;
    }





    //update process bb khi được duyệt
    public function update_confrim($data = [], $id)
    {
        $result = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_ACTIVE;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_ACTIVE;
        $result[$this->ksnbModel::COLUMN_WAIT_FEEDBACK_TIME] =  time();
        $updateKsnb = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        return $updateKsnb;
    }


    public function getEmailAll($id)
    {
        $result = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->find($id);
        $user = $result['user_email'];
        return $user;
    }

    public function getEmailAllTpgg($id)
    {
        $user = [];
        $result = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->find($id);
        $user[] = $result['email_tpgd'];
        return $user;
    }

    /**
     * Lấy dữ liệu theo email
     * @param Array $users
     * @return Collection
    */
    public function get_email_ksnb($users, $dataSearch = [])
    {
        $searchArr = [];
        if(!empty($dataSearch['status'])) {
            $searchArr[] = [ReportsKsnb::COLUMN_STATUS, '=', trim($dataSearch['status'])];
        }
        if(!empty($dataSearch['start_date'])) {
            $startDate = strtotime(trim($dataSearch['start_date']) . ' 00:00:00');
            $searchArr[] = [ReportsKsnb::COLUMN_CREATED_AT, '>=', $startDate];
        }
        if(!empty($dataSearch['end_date'])) {
            $endDate =  strtotime(trim($dataSearch['end_date']) . ' 23:59:59');
            $searchArr[] = [ReportsKsnb::COLUMN_CREATED_AT, '<=', $endDate];
        }
        if(!empty($dataSearch['user_email'])) {
            $searchArr[] = [ReportsKsnb::COLUMN_USER_EMAIL, '=', trim($dataSearch['user_email'])];
        }
        if(!empty($dataSearch['process'])) {
            $searchArr[] = [ReportsKsnb::COLUMN_PROCESS, '=', trim($dataSearch['process'])];
        }
        if(!empty($dataSearch['type'])) {
            $searchArr[] = [ReportsKsnb::COLUMN_TYPE, '=', trim($dataSearch['type'])];
        }
        if(!empty($dataSearch['discipline'])) {
            $searchArr[] = [ReportsKsnb::COLUMN_DISCIPLINE, '=', trim($dataSearch['discipline'])];
        }
        $result = $this->ksnbModel::whereIn($this->ksnbModel::COLUMN_USER_EMAIL, $users)
            ->where($searchArr)
            ->where(ReportsKsnb::COLUMN_FLAG, 'exists', false)
            ->whereIn($this->ksnbModel::COLUMN_STATUS, [
                ReportsKsnb::COLUMN_STATUS_ACTIVE,
                ReportsKsnb::COLUMN_STATUS_BLOCK
            ])->orderBy($this->ksnbModel::COLUMN_CREATED_AT, "DESC")
            ->paginate(15);
        return  $result;
    }

    //update process bb khi ko đc duyệt
    public function updateNotConfrim($data = [], $id)
    {
        $result = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_NOT_ACTIVE;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_NOT_ACTIVE;
        $result[$this->ksnbModel::COLUMN_REASON_NOT_CONFIRM] = $data['reason_not_confirm'];
        $updateKsnb = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        return $updateKsnb;
    }

    //update process bb khi gửi duyệt lại
    public function updateReConfrim($data = [], $id)
    {
        $result = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COULUMN_PROCESS_RECONFIRM;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_NEW;
        $updateKsnb = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        return $updateKsnb;
    }

    //update process bb khi đã có phản hồi của nv vi phạm
    public function updateFeedBack($data=[], $id)
    {
        $result = [];
        // $comment = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_FEEDBACK;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_ACTIVE;
        $result[$this->ksnbModel::COLUMN_UPDATED_BY] = $data['created_by'];
        $result[$this->ksnbModel::COLUMN_WAIT_FEEDBACK_TIME] =  time();
        $comment = [
            'comment' => $data['comment'],
            'created_at' => time(),
            'created_by' => $data['created_by'],
        ];
        $updateKsnb = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        $push = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->push($this->ksnbModel::COLUMN_COMMENT, $comment);
        if ($updateKsnb && $push) {
            return true;
        }
        return false;
    }

    //update process khi đưa ra kết luận
    public function updateInfer($data=[], $id)
    {
        $result = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_BLOCK;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_ACTIVE;
        $result[$this->ksnbModel::COLUMN_INFER] = $data['infer'];
        $updateKsnb = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        return $updateKsnb;
    }

    /**
    * Write user's log
    * @param $id String: reportsksnb collection's Id
    * @param $action String: user's action
    * @param $createdby String: login user
    */
    public function wlog($id, $action, $createdBy) {
        $log = [
            'action'        => $action,
            'created_by'    => $createdBy,
            'created_at'    => time()
        ];
        $updateKsnb = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)
            ->push($this->ksnbModel::COLUMN_LOGS, $log);
    }

    public function updateWaitConfrim($data=[], $id)
    {
        $result = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_NEW;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_NEW;
        $updateKsnb = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        return $updateKsnb;
    }




    public function cancelReportnv($id)
    {
        $result = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)
            ->where($this->ksnbModel::COLUMN_STATUS, $this->ksnbModel::COLUMN_STATUS_NEW)->update([
                ReportsKsnb::COLUMN_STATUS => ReportsKsnb::COULUMN_STATUS_DELETE
            ]);

        return $result;
    }

    public function cancelReporttbp($id)
    {
        $result = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)
            ->whereIn($this->ksnbModel::COLUMN_STATUS, [
                $this->ksnbModel::COLUMN_STATUS_NOT_ACTIVE ,
                $this->ksnbModel::COLUMN_STATUS_BLOCK ,
                $this->ksnbModel::COLUMN_STATUS_ACTIVE ,
            ])->update([
                ReportsKsnb::COLUMN_STATUS => ReportsKsnb::COULUMN_STATUS_DELETE
            ]);
        return $result;
    }


    public function updateKsnbFeedback($data=[], $id)
    {
        $result = [];
        // $comment = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_WAIT_FEEDBACK;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_ACTIVE;
        $result[$this->ksnbModel::COLUMN_UPDATED_BY] =  $data['created_by'];
        $result[$this->ksnbModel::COLUMN_WAIT_FEEDBACK_TIME] =  time();
        $comment = [
            'ksnb_comment' => $data['ksnb_comment'],
            'created_at'   => time(),
            'created_by'   => $data['created_by'],
        ];
        $updateKsnb = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        $push = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->push($this->ksnbModel::COLUMN_KSNB_COMMENT, $comment);
        if ($updateKsnb && $push) {
            return true;
        }
        return false;
    }

    public function updateWaitInfer($data=[], $id)
    {
        $result = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_WAIT_INFER;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_ACTIVE;
        $updateKsnb = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        return $updateKsnb;
    }

// lấy tất cả các bản ghi có process là [active , wait_feedback] và so sánh thời gian hiện tại với thời gian phản hồi
    public function endTimeRp()
    {
        $last3days = time() - 3 * 24 * 60 * 60 ;
        $result = $this->ksnbModel
        ->where($this->ksnbModel::COLUMN_WAIT_FEEDBACK_TIME, '<=' ,$last3days)
        ->whereIn($this->ksnbModel::COLUMN_PROCESS, [$this->ksnbModel::COLUMN_PROCESS_ACTIVE,$this->ksnbModel::COLUMN_PROCESS_WAIT_FEEDBACK])
        ->get();
        return $result;
    }

// cập nhật process cảu các bản ghi sau khi bị quá hạn(vì không phản hồi)
    public function updateEndTime($id)
    {
        $result = $this->ksnbModel->where($this->ksnbModel::COLUMN_ID, $id)
        ->update([ReportsKsnb::COLUMN_PROCESS => ReportsKsnb::COLUMN_PROCESS_END_TIME]);
        $this->wlog($id, 'Phản hồi biên bản', 'System');
        $comment = [
            'comment' => 'Nhân viên vi phạm không phản hồi!',
            'created_by' => 'System',
        ];
        $this->updateFeedBack1($comment, $id);
        return $result;
    }

    public function updateFeedBack1($data=[], $id)
    {
        $result = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_END_TIME;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_ACTIVE;
        $result[$this->ksnbModel::COLUMN_UPDATED_BY] = $data['created_by'];
        $comment = [
            'comment' => $data['comment'],
            'created_at' => time(),
            'created_by' => $data['created_by'],
        ];
        $updateKsnb = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        $push = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->push($this->ksnbModel::COLUMN_COMMENT, $comment);
        if ($updateKsnb && $push) {
            return true;
        }
        return false;
    }


    //Phiếu ghi nhận start

    /**
    * create Note
    * @param array $data
    * @return Collection
    */

    public function createNote($data=[])
    {
        $result = [];
        if(!empty($data[ReportsKsnb::COLUMN_CREATED_BY])) {
            $result[ReportsKsnb::COLUMN_CREATED_BY] = $data['created_by'];
        }
        if(!empty($data[ReportsKsnb::COLUMN_IMAGE_PATH])) {
            $result[ReportsKsnb::COLUMN_IMAGE_PATH] = $data[ReportsKsnb::COLUMN_IMAGE_PATH];
        }
        if(!empty($data[ReportsKsnb::COLUMN_USER_NAME])) {
            $result[ReportsKsnb::COLUMN_USER_NAME] = $data[ReportsKsnb::COLUMN_USER_NAME];
        }
        if(!empty($data[ReportsKsnb::COLUMN_USER_EMAIL])) {
            $result[ReportsKsnb::COLUMN_USER_EMAIL] = $data[ReportsKsnb::COLUMN_USER_EMAIL];
        }
        if(!empty($data[ReportsKsnb::COLUMN_STORE_NAME])) {
            $result[ReportsKsnb::COLUMN_STORE_NAME] = $data[ReportsKsnb::COLUMN_STORE_NAME];
        }
        if(!empty($data[ReportsKsnb::COLUMN_STORE_ID])) {
            $result[ReportsKsnb::COLUMN_STORE_ID] = $data[ReportsKsnb::COLUMN_STORE_ID];
        }
        if(!empty($data[ReportsKsnb::COLUMN_STORE_EMAIL_TPGD])) {
            $result[ReportsKsnb::COLUMN_STORE_EMAIL_TPGD] = $data[ReportsKsnb::COLUMN_STORE_EMAIL_TPGD];
        }
        if(!empty($data['name_note'])) {
            $result[ReportsKsnb::COLUMN_NAME_NOTE] = $data['name_note'];
        }
        if(!empty($data['email_note'])) {
            $result[ReportsKsnb::COLUMN_EMAIL_NOTE] = $data['email_note'];
        }
        if(!empty($data[ReportsKsnb::COLUMN_TITLE])) {
            $result[ReportsKsnb::COLUMN_TITLE] = $data[ReportsKsnb::COLUMN_TITLE];
        }
        if(!empty($data[ReportsKsnb::COLUMN_CONTENT])) {
            $result[ReportsKsnb::COLUMN_CONTENT] = $data['content'];
        }
        $result[ReportsKsnb::COLUMN_FLAG] = ReportsKsnb::COLUMN_STATUS_NEW;

        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_WAIT_CONFRIM;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_NEW;
        if (empty($result)) {
            return false;
        }
        $create = $this->ksnbModel->create($result);
        return $create;
    }


    /**
    * update Note
    * @param array $data
    * @param string $id
    * @return Collection
    */
    public function updateNote($data=[], $id)
    {
        $result = [];
        if(!empty($data[ReportsKsnb::COLUMN_CREATED_BY])) {
            $result[ReportsKsnb::COLUMN_CREATED_BY] = $data['created_by'];
        }
        if(!empty($data[ReportsKsnb::COLUMN_IMAGE_PATH])) {
            $result[ReportsKsnb::COLUMN_IMAGE_PATH] = $data[ReportsKsnb::COLUMN_IMAGE_PATH];
        }
        if(!empty($data[ReportsKsnb::COLUMN_USER_NAME])) {
            $result[ReportsKsnb::COLUMN_USER_NAME] = $data[ReportsKsnb::COLUMN_USER_NAME];
        }
        if(!empty($data[ReportsKsnb::COLUMN_USER_EMAIL])) {
            $result[ReportsKsnb::COLUMN_USER_EMAIL] = $data[ReportsKsnb::COLUMN_USER_EMAIL];
        }
        if(!empty($data[ReportsKsnb::COLUMN_STORE_NAME])) {
            $result[ReportsKsnb::COLUMN_STORE_NAME] = $data[ReportsKsnb::COLUMN_STORE_NAME];
        }
        if(!empty($data[ReportsKsnb::COLUMN_STORE_ID])) {
            $result[ReportsKsnb::COLUMN_STORE_ID] = $data[ReportsKsnb::COLUMN_STORE_ID];
        }
        if(!empty($data[ReportsKsnb::COLUMN_STORE_EMAIL_TPGD])) {
            $result[ReportsKsnb::COLUMN_STORE_EMAIL_TPGD] = $data[ReportsKsnb::COLUMN_STORE_EMAIL_TPGD];
        }
        if(!empty($data['name_note'])) {
            $result[ReportsKsnb::COLUMN_NAME_NOTE] = $data['name_note'];
        }
        if(!empty($data['email_note'])) {
            $result[ReportsKsnb::COLUMN_EMAIL_NOTE] = $data['email_note'];
        }
        if(!empty($data[ReportsKsnb::COLUMN_TITLE])) {
            $result[ReportsKsnb::COLUMN_TITLE] = $data[ReportsKsnb::COLUMN_TITLE];
        }
        if(!empty($data[ReportsKsnb::COLUMN_CONTENT])) {
            $result[ReportsKsnb::COLUMN_CONTENT] = $data['content'];
        }
        if (empty($result)) {
            return false;
        }
        $update = $this->ksnbModel->where(ReportsKsnb::COLUMN_ID, $id)->update($result);
        return $update;
    }

    /**
    * get All Record Note
    * @param
    * @return Collection
    */
    public function getAllNote($dataSearch = []) {
        $searchArr = [];
        if(!empty($dataSearch['start_date'])) {
            $startDate = Carbon::parse(trim($dataSearch['start_date'])  . '00:00:00');
            $searchArr[] = [ReportsKsnb::COLUMN_CREATED_AT, '>=', $startDate];
        }
        if(!empty($dataSearch['end_date'])) {
            $endDate =  Carbon::parse(trim($dataSearch['end_date']) . '23:59:59');
            $searchArr[] = [ReportsKsnb::COLUMN_CREATED_AT, '<=', $endDate];
        }
        if(!empty($dataSearch['name_note'])) {
            $searchArr[] = [ReportsKsnb::COLUMN_NAME_NOTE, '$regex' , '/' .trim($dataSearch['name_note']). '/i'];
        }
        if(!empty($dataSearch['email_note'])) {
            $searchArr[] = [ReportsKsnb::COLUMN_EMAIL_NOTE, '=' ,trim($dataSearch['email_note'])];
        }
        if(!empty($dataSearch['process'])) {
            $searchArr[] = [ReportsKsnb::COLUMN_PROCESS, '=', trim($dataSearch['process'])];
        }
        if(!empty($dataSearch['user_name'])) {
            $searchArr[] = [ReportsKsnb::COLUMN_USER_NAME, '$regex', '/'.trim($dataSearch['user_name']).'/i'];
        }
        if(!empty($dataSearch['user_email'])) {
            $searchArr[] = [ReportsKsnb::COLUMN_USER_EMAIL, '=', trim($dataSearch['user_email'])];
        }
        $result = $this->ksnbModel
        ->where($searchArr)
        ->where(ReportsKsnb::COLUMN_FLAG, ReportsKsnb::COLUMN_STATUS_NEW)
        ->orderBy($this->ksnbModel::COLUMN_CREATED_AT, "DESC")
        ->paginate(15);
        return $result;
    }

    /**
    * find Note
    * @param string $id
    * @return Collection
    */
    public function findNote($id) {
        $result = $this->ksnbModel::where(ReportsKsnb::COLUMN_ID, $id)
        ->where(ReportsKsnb::COLUMN_FLAG, ReportsKsnb::COLUMN_STATUS_NEW)
        ->first();
        return $result;
    }

    /**
    * update wait confirm Note
    * @param string $id
    * @return Collection
    */
    public function waitConfirmNote($id) {
        $result = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_NEW;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_NEW;
        $update = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        return $update;
    }

    /**
    * update not confirm Note
    * @param string $id
    * @return Collection
    */
    public function notConfirmNote($data, $id) {
        $result = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_NOT_ACTIVE;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_NEW;
        $result[$this->ksnbModel::COLUMN_REASON_NOT_CONFIRM] = $data['reason_not_confirm'];
        $update = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        return $update;
    }


    /**
    * update not confirm Note
    * @param string $id
    * @return Collection
    */
    public function waitReConfirmNote($id) {
        $result = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COULUMN_PROCESS_RECONFIRM;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_NEW;
        $update = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        return $update;
    }

    /**
    * update confirm Note
    * @param string $id
    * @return Collection
    */
    public function confirmNote($id) {
        $result = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_ACTIVE;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_ACTIVE;
        $update = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        return $update;
    }

    /**
    * update user feedback Note
    * @param array $data
    * @param string $id
    * @return Collection
    */
    public function userFeedBack($data, $id) {
        $result = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_FEEDBACK;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_ACTIVE;
        $result[$this->ksnbModel::COLUMN_UPDATED_BY] = $data['created_by'];
        $comment = [
            'comment' => $data['comment'],
            'created_at' => time(),
            'created_by' => $data['created_by'],
        ];
        $updateKsnb = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        $push = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->push($this->ksnbModel::COLUMN_COMMENT, $comment);
        if ($updateKsnb && $push) {
            return true;
        }
        return false;
    }

    /**
    * update ksnb feedback Note
    * @param array $data
    * @param string $id
    * @return Collection
    */
    public function ksnbFeedback($data, $id) {
        $result = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_WAIT_FEEDBACK;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_ACTIVE;
        $result[$this->ksnbModel::COLUMN_UPDATED_BY] =  $data['created_by'];
        $comment = [
            'ksnb_comment' => $data['ksnb_comment'],
            'created_at'   => time(),
            'created_by'   => $data['created_by'],
        ];
        $ksnbFeedback = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        $push = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->push($this->ksnbModel::COLUMN_KSNB_COMMENT, $comment);
        if ($ksnbFeedback && $push) {
            return true;
        }
        return false;
    }

    /**
    * update wait infer Note
    * @param array $data
    * @param string $id
    * @return Collection
    */
    public function waitInferNote($id) {
        $result = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_WAIT_INFER;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_ACTIVE;
        $update = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        return $update;
    }

    /**
    * update infer Note
    * @param array $data
    * @param string $id
    * @return Collection
    */
    public function inferNote($data, $id) {
        $result = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_BLOCK;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_ACTIVE;
        $result[$this->ksnbModel::COLUMN_INFER] = $data['infer'];
        $updateKsnb = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        return $updateKsnb;
    }

    /**
    * send report to CEO
    * @param array $data
    * @param string $id
    * @return Collection
    */
    public function sendCeo($data, $id) {
        $result = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_SEND_CEO;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_ACTIVE;
        $result[$this->ksnbModel::COLUMN_INFER] = $data['infer'];
        $updateKsnb = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        return $updateKsnb;
    }

    public function ceoNotConfirm($data, $id) {
        $result = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_CEO_NOT_CONFIRM;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_ACTIVE;
        $result[$this->ksnbModel::COLUMN_CEO_NOT_CONFIRM] = $data['ceo_not_confirm'];
        $updateKsnb = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        return $updateKsnb;
    }


    public function ceoConfirm($data, $id) {
        $result = [];
        $result[$this->ksnbModel::COLUMN_PROCESS] = ReportsKsnb::COLUMN_PROCESS_CEO_CONFIRM;
        $result[$this->ksnbModel::COLUMN_STATUS] =  ReportsKsnb::COLUMN_STATUS_ACTIVE;
        $result[$this->ksnbModel::COLUMN_CEO_CONFIRM] = $data['ceo_confirm'];
        $updateKsnb = $this->ksnbModel::where($this->ksnbModel::COLUMN_ID, $id)->update($result);
        return $updateKsnb;
    }
}
