<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('matches', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('round');
            $table->integer('matchnumber');
            $table->string('home_team');
            $table->string('away_team');
            $table->string('home_score')->default(0);
            $table->string('away_score')->default(0);
            $table->boolean('ended')->default(false);
            $table->dateTime('start');
			$table->timestamps();

            $table->foreign('product_id')
                ->references('id')->on('products')
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
            $table->dropForeign('matches_product_id_foreign');
            $table->dropColumn('product_id');
        });

		Schema::drop('matches');
	}

}
