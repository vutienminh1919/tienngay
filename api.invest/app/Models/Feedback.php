<?php


namespace App\Models;


class Feedback extends BaseModel
{
    protected $table = 'feedback';

    const NAME = 'name';
    const PHONE = 'phone';
    const EMAIL = 'email';
    const DESCRIPTION = 'description';
    const STATUS = 'status';

    //status
    const NOT_ANSWER = 1;  // chưa trả lời
}
