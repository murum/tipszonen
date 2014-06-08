<?php

use Laracasts\Validation\FormValidator;

class RegisterForm extends FormValidator {

    protected $rules = [
        'username' => 'required|alpha_num|min:3|unique:users',
        'email' => 'required|email|unique:users|confirmed',
        'password' => 'required|confirmed|min:6',
    ];

} 
