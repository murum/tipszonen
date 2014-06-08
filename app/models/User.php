<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends BaseModel implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
    public $timestamps = true;
    protected $hidden = array('password', 'remember_token', 'salt', 'register_ip', 'forget_token', 'active_token');
    protected $guarded = array('id');

    /**
     * RULES
     */
    protected static $rules = [
        'username' => 'required|alpha_num|min:3|unique:users',
        'email' => 'required|email|unique:users|confirmed',
        'email_confirmation' => 'required|email',
        'password' => 'required|min:6',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function($model)
        {
            $model->register_ip = get_ip();

            return $model->validate();
        });
    }

    public function role()
    {
        return $this->belongsToMany('Role');
    }

    public function attempts()
    {
        return $this->hasMany('Login_attempts');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

}
