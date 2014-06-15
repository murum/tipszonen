<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSystemTypeToCouponRows extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('coupon_rows', function(Blueprint $table)
		{
            $table->string('system_type', 10)->default('E');
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
			$table->dropColumn('system_type');
		});
	}

}
