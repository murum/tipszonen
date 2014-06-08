<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('username')->unique();
			$table->string('email')->unique();
			$table->string('password')->nullable();
			$table->string('register_ip');
			$table->string('forget_token')->nullable();
            $table->string('remember_token')->nullable();
			$table->string('active_token')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}