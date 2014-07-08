<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Tipszonen\Roles\HasRole;

class User extends BaseModel implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, HasRole;

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
    protected $hidden = array('password', 'remember_token', 'forget_token', 'active_token');
    protected $guarded = array('id');

    protected $fillable = [
        'active_token',
        'email',
        'password',
        'register_ip',
        'username'
    ];

    /**
     * RULES
     */
    protected static $rules = [
        'username' => 'required|alpha_num|min:3|unique:users',
        'email' => 'required|email|unique:users|confirmed',
        'email_confirmation' => 'required|email',
        'password' => 'required|confirmed|min:6',
        'password_confirmation' => 'required|email',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            $model->register_ip = get_ip();
            return $model;
        });

        static::created(function($model)
        {
            $model->attachRole(Role::MEMBER);
            return $model;
        });
    }

    public function roles()
    {
        return $this->belongsToMany('Role');
    }

    /** ROLES **/
    public function isAdmin() {
        return $this->hasRole(Role::ADMIN);
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
