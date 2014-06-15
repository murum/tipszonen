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


Route::get('kuponger', array('as' => 'coupon', 'before' => 'auth', 'uses' => 'CouponController@index'));
Route::get('kuponger/{id}', array('as' => 'coupon.show', 'before' => 'auth', 'uses' => 'CouponController@show'));
Route::get('skapa-kupong/{id}', array('as' => 'coupon.new', 'uses' => 'CouponController@create'));
Route::get('skapa-kupong/egna-filer', array('as' => 'own_files', 'before' => 'auth', 'uses' => 'CouponController@create_own_file'));
Route::post('skapa-kupong/egna-filer', array('as' => 'post_own_file', 'before' => 'auth', 'uses' => 'CouponController@store_own_file'));
Route::get('skapa-kupong/egna-filer/klar', array('as' => 'own_file.completed', 'before' => 'auth', 'uses' => 'CouponController@create_own_file_completed'));


// Medlemmar
Route::get('medlemmar', array('as' => 'member', 'uses' => 'MembersController@index'));
Route::get('medlemmar/{id}', array('as' => 'member.show', 'uses' => 'MembersController@show'));
Route::get('medlemmar/{id}/redigera', array('as' => 'member.edit', 'uses' => 'MembersController@edit'));
Route::post('medlemmar/{id}/redigera', array('as' => 'member.update', 'uses' => 'MembersController@update'));

// Forum routes
Route::get('forum', array('as' => 'forum', 'before' => 'auth', 'uses' => 'ForumController@index'));