<?php

namespace App\Models;

use DateTimeInterface;

class Role extends Model
{
	protected $table = 'role';

	public function user() {
		return $this->belongsToMany(User::class, 'user_role', 'role_id', 'user_id')
            ->withPivot('position');
	}

	public function menu() {
		return $this->belongsToMany(Menu::class, 'menu_role', 'role_id', 'menu_id')
			->withTimestamps();
	}
}
