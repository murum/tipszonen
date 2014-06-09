<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCouponRows extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('coupon_rows', function(Blueprint $table)
		{
            $table->dropForeign('coupon_rows_product_id_foreign');
            $table->dropForeign('coupon_rows_user_id_foreign');

            $table->dropColumn('user_id');
            $table->dropColumn('product_id');
            $table->dropColumn('round');
            $table->dropColumn('game_start');
            $table->dropColumn('game_end');
            $table->dropColumn('game_week');

            $table->integer('coupon_id')->unsigned();
            $table->foreign('coupon_id')
                ->references('id')->on('coupons')
                ->onDelete('cascade')
                ->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('coupon_rows', function(Blueprint $table)
		{
            $table->integer('user_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->string('round');
            $table->dateTime('game_start');
            $table->dateTime('game_end');
            $table->string('game_week');

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
		});
	}

}
