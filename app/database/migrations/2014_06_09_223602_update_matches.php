<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMatches extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('matches', function(Blueprint $table)
		{
            $table->dropForeign('matches_product_id_foreign');
            $table->dropColumn('product_id');

            $table->integer('coupon_detail_id')->unsigned();
            $table->foreign('coupon_detail_id')
                ->references('id')->on('coupon_details')
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
		Schema::table('matches', function(Blueprint $table)
		{
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->dropForeign('matches_coupon_detail_id_foreign');
            $table->dropColumn('coupon_detail_id');
		});
	}

}
