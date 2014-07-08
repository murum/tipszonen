<?php

class Role extends Eloquent {

	protected $table = 'roles';
	public $timestamps = false;

    const ADMIN = 'Admin';
    const MEMBER = 5;

	public function permissions()
	{
		return $this->belongsToMany('Permission');
	}

	public function users()
	{
		return $this->belongsToMany('User');
	}

}