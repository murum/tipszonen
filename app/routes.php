<?php

Route::get('/', array('as' => 'home', 'before' => 'auth', 'uses' => 'HomeController@index'));
Route::get('/kupong', array('as' => 'kupong', 'before' => 'auth', 'uses' => 'CouponController@index'));
Route::get('/test', array('as' => 'test', 'before' => 'auth', 'uses' => 'CouponController@test'));

Route::resource('sessions', 'SessionsController', array( 'only' => array( 'create', 'store', 'destroy' ) ) );
Route::get('logga-in', array('as' => 'login', 'before' => 'auth.guest', 'uses' => 'SessionsController@create'));
Route::get('logga-in-facebook', array('as' => 'login-facebook', 'before' => 'auth.guest', 'uses' => 'SessionsController@loginWithFacebook'));
Route::get('logga-ut', array('as' => 'logout', 'before' => 'auth', 'uses' => 'SessionsController@destroy'));

Route::resource('anvandare', 'UsersController');
Route::resource('user', 'UsersController');
Route::get('registrera-dig', array('as' => 'register', 'before' => 'auth.guest', 'uses' => 'UsersController@create'));