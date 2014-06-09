<?php

// Route Patterns
Route::pattern('id', '[0-9]+');

Route::get('/', array('as' => 'home', 'before' => 'auth', 'uses' => 'HomeController@index'));

Route::resource('sessions', 'SessionsController', array( 'only' => array( 'create', 'store', 'destroy' ) ) );
Route::get('logga-in', array('as' => 'login', 'before' => 'auth.guest', 'uses' => 'SessionsController@create'));
Route::get('logga-in-facebook', array('as' => 'login-facebook', 'before' => 'auth.guest', 'uses' => 'SessionsController@loginWithFacebook'));
Route::get('logga-ut', array('as' => 'logout', 'before' => 'auth', 'uses' => 'SessionsController@destroy'));

Route::resource('anvandare', 'UsersController');
Route::resource('user', 'UsersController');
Route::get('registrera-dig', array('as' => 'register', 'before' => 'auth.guest', 'uses' => 'UsersController@create'));


// Medlemmar
Route::get('medlemmar', array('as' => 'member', 'uses' => 'MembersController@index'));
Route::get('medlemmar/{id}', array('as' => 'member.show', 'uses' => 'MembersController@show'));

// Forum routes
Route::get('forum', array('as' => 'forum', 'before' => 'auth', 'uses' => 'ForumController@index'));