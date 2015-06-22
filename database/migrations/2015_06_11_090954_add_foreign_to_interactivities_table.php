<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignToInteractivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('interactivities', function(Blueprint $table)
		{
			// add history_id column
			$table->integer('history_id')->unsigned()->nullable()->after('activity_id');

			// add key
			$table->foreign('history_id')->references('id')->on('histories')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('interactivities', function(Blueprint $table)
		{
			$table->dropForeign('interactivities_history_id_foreign');
		});
	}

}
