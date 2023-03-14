<?php

namespace App\Models;

class Menu extends BaseModel
{
	protected $table = 'menu';

	public function role() {
		return $this->belongsToMany(Role::class, 'menu_role', 'menu_id', 'role_id')
			->withTimestamps();
	}

	public function user() {
	    return $this->belongsToMany(User::class, 'user_menu');
    }

    public function action() {
	    return $this->hasOne(Action::class);
    }
}
