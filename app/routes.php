<?php

// Route Patterns
Route::pattern('id', '[0-9]+');

Route::get('/', array('as' => 'home', 'uses' => 'CouponController@index'));

Route::resource('sessions', 'SessionsController', array( 'only' => array( 'create', 'store', 'destroy' ) ) );
Route::get('logga-in', array('as' => 'login', 'before' => 'auth.guest', 'uses' => 'SessionsController@create'));
Route::get('logga-in-facebook', array('as' => 'login-facebook', 'before' => 'auth.guest', 'uses' => 'SessionsController@loginWithFacebook'));
Route::get('logga-ut', array('as' => 'logout', 'before' => 'auth', 'uses' => 'SessionsController@destroy'));

Route::resource('anvandare', 'UsersController');
Route::resource('user', 'UsersController');
Route::get('registrera-dig', array('as' => 'register', 'before' => 'auth.guest', 'uses' => 'UsersController@create'));


Route::get('kuponger', array('as' => 'coupon', 'uses' => 'CouponController@index'));
Route::get('kuponger/{id}', array('as' => 'coupon.show', 'uses' => 'CouponController@show'));
Route::get('kuponger/{id}/uppdatering', array('as' => 'coupon.show_update', 'uses' => 'CouponController@show_update'));
Route::get('skapa-kupong/{id}', array('as' => 'coupon.new', 'uses' => 'CouponController@create'));
Route::post('skapa-kupong/{id}', array('as' => 'coupon.store', 'uses' => 'CouponController@store'));
Route::get('skapa-kupong/egna-filer', array('as' => 'own_files', 'uses' => 'CouponController@create_own_file'));
Route::post('skapa-kupong/egna-filer', array('as' => 'post_own_file', 'uses' => 'CouponController@store_own_file'));
Route::get('skapa-kupong/egna-filer/klar', array('as' => 'own_file.completed', 'uses' => 'CouponController@create_own_file_completed'));

Route::get('kuponger/sok', array('as' => 'search.coupon', 'uses' => 'CouponController@search'));


// Medlemmar
Route::get('medlemmar', array('as' => 'member', 'uses' => 'MembersController@index'));
Route::get('medlemmar/{id}', array('as' => 'member.show', 'uses' => 'MembersController@show'));
Route::get('medlemmar/{id}/redigera', array('as' => 'member.edit', 'uses' => 'MembersController@edit'));
Route::post('medlemmar/{id}/redigera', array('as' => 'member.update', 'uses' => 'MembersController@update'));

// Admin
Route::get('admin', array('as' => 'admin', 'before' => 'auth|auth.is_admin', 'uses' => 'AdminController@index'));
Route::get('admin/kuponger', array('as' => 'admin.coupon', 'before' => 'auth|auth.is_admin', 'uses' => 'AdminController@get_coupons'));
Route::get('admin/kuponger/{id}/ta-bort', array('as' => 'admin.coupon.get_remove', 'before' => 'auth|auth.is_admin', 'uses' => 'AdminController@get_remove_coupon'));
Route::get('admin/medlemmar', array('as' => 'admin.users', 'before' => 'auth|auth.is_admin', 'uses' => 'AdminController@get_users'));
Route::get('admin/medlemmar/{id}', array('as' => 'admin.users.get_single', 'before' => 'auth|auth.is_admin', 'uses' => 'AdminController@get_user'));
Route::get('admin/medlemmar/{id}/ta-bort', array('as' => 'admin.users.get_remove', 'before' => 'auth|auth.is_admin', 'uses' => 'AdminController@get_remove_user'));
Route::post('admin/medlemmar/{id}', array('as' => 'admin.users.post_single', 'before' => 'auth|auth.is_admin', 'uses' => 'AdminController@post_user'));
Route::get('admin/liverattning', array('as' => 'admin.liverattning', 'before' => 'auth|auth.is_admin', 'uses' => 'AdminController@get_score'));
Route::get('admin/uppdatera-resultat/{id}', array('as' => 'admin.liverattning.get_single', 'before' => 'auth|auth.is_admin', 'uses' => 'AdminController@get_coupon_score'));
Route::post('admin/uppdatera-resultat/match/{id}', array('as' => 'admin.liverattning.update.match', 'before' => 'auth|auth.is_admin', 'uses' => 'AdminController@post_coupon_score'));
Route::post('admin/uppdatera-resultat/utdelning/{id}', array('as' => 'admin.liverattning.update.dividend', 'before' => 'auth|auth.is_admin', 'uses' => 'AdminController@post_coupon_dividend'));