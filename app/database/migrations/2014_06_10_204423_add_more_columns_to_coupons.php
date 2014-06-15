<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreColumnsToCoupons extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('coupons', function(Blueprint $table)
		{
			$table->string('name')->nullable();
            $table->string('play_url')->nullable();
            $table->string('cost')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('coupons', function(Blueprint $table)
		{
            $table->dropColumn('name');
            $table->dropColumn('play_url');
            $table->dropColumn('cost');
		});
	}

}
