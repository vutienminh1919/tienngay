<?php

namespace App\Models;

class Action extends BaseModel
{
	protected $table = 'action';

    const COLUMN_NAME = 'name';
    const COLUMN_STATUS = 'status';
    const COLUMN_MENU_ID = 'menu_id';
    const COLUMN_URL = 'url';

	public function menu() {
		return $this->belongsTo(Menu::class);
	}
}
