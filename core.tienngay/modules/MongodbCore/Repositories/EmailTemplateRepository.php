<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Repositories\Interfaces\EmailTemplateRepositoryInterface;
use Modules\MongodbCore\Entities\EmailTemplate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;

class EmailTemplateRepository implements EmailTemplateRepositoryInterface
{
        /**
     * @var Model
     */
    protected $emailTemplateModel;

   /**
    * EmailTemplateRepository.
    *
    * @param EmailTemplate
    */
    public function __construct(EmailTemplate $emailTemplateModel) {
        $this->emailTemplateModel = $emailTemplateModel;
    }

    public function getCodeEmail($code) {
        $listEmail = $this->emailTemplateModel::where(EmailTemplate::STORE, $code)->get();
        if ($listEmail) {
            return $listEmail;
        }
        return false;
    }

    public function getMessageEmail($store, $code) {
        $message = $this->emailTemplateModel::where(EmailTemplate::STORE, $store)
        ->where(EmailTemplate::CODE_NAME, $code)->first();
        if ($message) {
            return $message;
        }
        return false;
    }

    public function checkType($store) {
        if ($store == EmailTemplate::FLAG_MKT) {
            return EmailTemplate::MKT ;
        } else if (EmailTemplate::FLAG_CSKH) {
            return EmailTemplate::CSKH;
        } else {
            return EmailTemplate::NDT;
        }
    }

    public function saveTemplate($data = []) {
        $result = [
            EmailTemplate::SUBJECT      => !empty($data['subject']) ? $data['subject'] : "",
            EmailTemplate::CODE         => !empty($data['code']) ? Str::slug($data['code']) : "",
            EmailTemplate::CODE_NAME    => !empty($data['code']) ? Str::slug($data['code']) : "",
            EmailTemplate::MESSAGE      => !empty($data['message']) ? str_replace('"', "'", $data['message']) : "",
            EmailTemplate::CREATED_BY   => !empty($data['created_by']) ? $data['created_by'] : "",
            EmailTemplate::CREATED_AT   => time(),
            EmailTemplate::STORE        => !empty($data['store']) ? $data['store'] : "",
            EmailTemplate::STORE_NAME   => !empty($data[EmailTemplate::STORE_NAME]) ? $data[EmailTemplate::STORE_NAME] : "",
            EmailTemplate::SLUG         => !empty($data[EmailTemplate::STORE_NAME]) ? Str::slug($data[EmailTemplate::STORE_NAME]) : "",
        ];
        if (empty($result)) {
            return ;
        }
        $create = $this->emailTemplateModel->create($result);
        return $create;
    }

    public function getSubject($code) {
        $listEmail = $this->emailTemplateModel::where(EmailTemplate::CODE_NAME, $code)->first();
        if ($listEmail) {
            return $listEmail;
        }
        return false;
    }

    public function updateTemplate($data = [], $id) {
        $result = [
            EmailTemplate::SUBJECT      => !empty($data['subject']) ? $data['subject'] : "",
            EmailTemplate::CODE         => !empty($data['code']) ? Str::slug($data['code']) : "",
            EmailTemplate::CODE_NAME    => !empty($data['code']) ? Str::slug($data['code']) : "",
            EmailTemplate::MESSAGE      => !empty($data['message']) ? str_replace('"', "'", $data['message']) : "",
            EmailTemplate::UPDATED_BY   => !empty($data['updated_by']) ? $data['updated_by'] : "",
            EmailTemplate::UPDATED_AT   => time(),
            EmailTemplate::STORE        => !empty($data['store']) ? $data['store'] : "",
            EmailTemplate::STORE_NAME   => !empty($data[EmailTemplate::STORE_NAME]) ? $data[EmailTemplate::STORE_NAME] : "",
        ];
        if (empty($result)) {
            return ;
        }
        $update = $this->emailTemplateModel
        ->where(EmailTemplate::ID, $id)
        ->update($result);
        return $update;
    }

    /**
    * find Template by id
    * 
    * @param String $id;
    * @return Collection;
    */
    public function findById($id) {
        $detail = $this->emailTemplateModel
        ->where(EmailTemplate::ID, $id)
        ->first();
        if (!$detail) {
            return ;
        }
        return $detail;
    }

    public function getAll($dataSearch = []) {
        $searchArr = [];
        if(!empty($dataSearch['start_date'])) {
            $startDate = strtotime(trim($dataSearch['start_date'])  . '00:00:00');
            $searchArr[] = [EmailTemplate::CREATED_AT, '>=', $startDate];
        }
        if(!empty($dataSearch['end_date'])) {
            $endDate =  strtotime(trim($dataSearch['end_date']) . '23:59:59');
            $searchArr[] = [EmailTemplate::CREATED_AT, '<=',  $endDate];
        }
        if(!empty($dataSearch['subject'])) {
            $searchArr[] = [EmailTemplate::SUBJECT, '$regex' , '/' .trim($dataSearch['subject']). '/i'];
        }
        if(!empty($dataSearch['store'])) {
            $searchArr[] = [EmailTemplate::STORE, '=' , trim($dataSearch['store'])];
        }
        $list = $this->emailTemplateModel
        ->where($searchArr)
        ->where(EmailTemplate::STORE, '$exists', true)
        ->where(EmailTemplate::STORE_NAME, '$exists', true)
        ->orderBy(EmailTemplate::CREATED_AT, "DESC")
        ->paginate(15);
        return $list;
    }

    public function getMessage($code) {
        $listEmail = $this->emailTemplateModel::where(EmailTemplate::SUBJECT, Str::slug($code))->get();
        if ($listEmail) {
            return $listEmail;
        }
        return false;
    }
    
    /**
    * check Exist Code
    * 
    * @param String $id;
    * @param String $code;
    * @return Collection;
    */
    public function checkExistCode($id, $code) {
        $record = NULL;
        if ($id) {
            $record = $this->emailTemplateModel::where(EmailTemplate::ID, '!=', $id)
            ->where(EmailTemplate::CODE, $code)->first();
        } else {
            $record = $this->emailTemplateModel::where(EmailTemplate::CODE, $code)->first();
        }

        if ($record) {
            return true;
        } else {
            return false;
        }
    }

    public function getSlug($code) {
        $listEmail = $this->emailTemplateModel::where(EmailTemplate::STORE, Str::slug($code))
        ->where(EmailTemplate::SLUG, '$exists', true)
        ->first();
        if ($listEmail) {
            return $listEmail;
        }
        return false;
    }
}