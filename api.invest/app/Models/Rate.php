<?php


namespace App\Models;


class Rate extends BaseModel
{
    const POINT = "point";
    const NOTE = "note";
    const USER_ID = "user_id";
    const CREATED_BY = "created_by";

    protected $table = 'rate';
}
