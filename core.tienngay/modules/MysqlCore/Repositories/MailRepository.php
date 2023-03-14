<?php

namespace Modules\MysqlCore\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\MysqlCore\Entities\Mail;
use Modules\MysqlCore\Repositories\Interfaces\MailRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MailRepository implements MailRepositoryInterface
{

    /**      
     * @var Model
     */     
     protected $mailModel;

    /**
     * MailRepository constructor.
     *
     * @param Mail $mail
     */
    public function __construct(Mail $mail) {
        $this->mailModel = $mail;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return collection
     */
    public function store($attributes) {
        $mail = $this->mailModel->create($attributes);
        return $mail;
    }


    /**
     * Get mails with status waiting to sent.
     *
     * @param  array $attributes
     * @return collection
     */
    public function waitingSentMails() {
        $mails = $this->mailModel::select(Mail::ID,Mail::FROM,Mail::TO,Mail::SUBJECT,Mail::MESSAGE,Mail::NAMEFROM)
            ->where(Mail::STATUS, '=', Mail::STATUS_WAITING)
            ->whereBetween(Mail::CREATED_AT, [Carbon::now()->subMinutes(5), Carbon::now()])
            ->whereNull(Mail::DELETED_AT)
            ->get();
        foreach ($mails as $mail) {
            $mail = $this->mailModel::where(Mail::ID, '=', $mail['id'])
            ->update([
                Mail::STATUS => Mail::STATUS_SENDING,
            ]);
        }
        return $mails;
    }

    /**
     * Update mail's status
     *
     * @param int $id
     * @param int $status
     * @param string $message
     * @return collection
     */
    public function updateStatus($id, $status, $message) {
        $mail = $this->mailModel::where(Mail::ID, '=', $id)
            ->update([
                Mail::STATUS => $status,
                Mail::ERRORS => $message,
            ]);
        return $mail;
    }

    /**
     * Check exists email.
     *
     * @param int $type
     * @param timestamp $fromTime
     * @param timestamp $toTime
     * @return collection
     */
    public function getMailByType($type, $fromTime = null, $toTime = null) {
        $mails = $this->mailModel::where(Mail::TYPE, '=', $type)
            ->whereNull(Mail::DELETED_AT)
            ->whereIn(Mail::STATUS, [Mail::STATUS_WAITING, Mail::STATUS_SUCCESS]);
        if ($fromTime) {
            $mails->where(Mail::CREATED_AT, '>=', $fromTime);
        }
        if ($toTime) {
            $mails->where(Mail::CREATED_AT, '<=', $toTime);
        }
        $mails = $mails->get();
        return $mails;
    }

    public function findRecord($email) {
        $mail =  $this->mailModel::where(Mail::TO, $email)
        ->whereIn(Mail::STATUS, [Mail::STATUS_WAITING])
        ->first();
        return $mail;
    }
}
