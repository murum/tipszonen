<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLoginAttemptsTable extends Migration {

	public function up()
	{
		Schema::create('login_attempts', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('login_ip');
			$table->timestamp('login_time');
		});
	}

	public function down()
	{
		Schema::drop('login_attempts');
	}
}