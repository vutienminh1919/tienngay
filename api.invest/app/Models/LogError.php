<?php


namespace App\Models;


class LogError extends BaseModel
{
    protected $table = 'log_error';

    const INPUT = 'input';
    const ERROR = 'error';
    const ACTION = 'action';
}
