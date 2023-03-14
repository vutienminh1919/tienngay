<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Depreciation extends Model
{
    protected $connection = 'mongodb';

    protected $table = 'depreciation';

    protected $fillable = ['code', 'type_property', 'name_property', 'slug_main_property', 'year', 'name', 'slug' ,'phan_khuc', 'giam_tru_tieu_chuan', 'khau_hao'];

    /**
     * initial constants
     */
    const COLUMN_ID = "_id";
    const COLUMN_CODE = "code";
    const COLUMN_PROPERTY_TYPE = "type_property";
    const COLUMN_PROPERTY_NAME = "name_property";
    const COLUMN_SLUG_MAIN_PROPERTY = "slug_main_property";
    const COLUMN_YEAR = "year";
    const COLUMN_NAME = "name";
    const COLUMN_SLUG = "slug";
    const COLUMN_PHAN_KHUC = "phan_khuc";
    const COLUMN_GIAM_TRU_TIEU_CHUAN = "giam_tru_tieu_chuan";
    const COLUMN_KHAU_HAO = "khau_hao";
    
    /**
     * end initial constants
     */
}
