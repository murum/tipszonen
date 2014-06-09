<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coupon_details', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('round')->unsigned();
            $table->integer('game_stop')->unsigned();
            $table->integer('game_week')->unsigned();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('coupon_details');
	}

}
