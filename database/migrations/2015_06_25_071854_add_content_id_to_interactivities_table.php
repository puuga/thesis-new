<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContentIdToInteractivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('interactivities', function(Blueprint $table)
		{
			// add content_id column
			$table->integer('content_id')->unsigned()->nullable()->after('activity_id');

			// add key
			$table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');

			// change column question_id to null-able
			// $table->integer('activity_id')->unsigned()->nullable()->change();
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
			$table->dropForeign('interactivities_content_id_foreign');
		});
	}

}
