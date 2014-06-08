<?php

class Permission extends Eloquent {

	protected $table = 'permissions';
	public $timestamps = false;

	public function roles()
	{
		return $this->belongsToMany('Role');
	}

}