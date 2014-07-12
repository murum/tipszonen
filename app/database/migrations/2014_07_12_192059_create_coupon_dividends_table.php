<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponDividendsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coupon_dividends', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('coupon_detail_id')->unsigned();
            $table->string('rights');
            $table->string('win');
            $table->integer('amount')->default(0);
            $table->boolean('synced')->default(false);

            $table->foreign('coupon_detail_id')
                ->references('id')->on('coupon_details')
                ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('coupon_dividends', function(Blueprint $table)
        {
            $table->dropForeign('coupon_dividends_coupon_detail_id_foreign');
        });

		Schema::drop('coupon_dividends');
	}

}
