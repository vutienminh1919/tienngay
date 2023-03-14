<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Elo;
use DateTimeInterface;

class Model extends Elo {

	protected $guarded = [];

	protected function serializeDate(DateTimeInterface $date)
	{
		return (int) $date->format('U');
	}

}