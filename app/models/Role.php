<?php

class Role extends Eloquent {

	protected $table = 'roles';
	public $timestamps = false;

	public function permissions()
	{
		return $this->belongsToMany('Permission');
	}

	public function users()
	{
		return $this->belongsToMany('User');
	}

}