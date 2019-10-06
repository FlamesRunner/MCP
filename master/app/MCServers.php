<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MCServers extends Model
{
	protected $table = 'serverTbl';
	public $timestamps = true;

	protected $fillable = [
        	'host', 'apikey', 'email'
	];

}
