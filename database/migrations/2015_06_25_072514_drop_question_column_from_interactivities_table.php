<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropQuestionColumnFromInteractivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('interactivities', function(Blueprint $table)
		{
			// drop key question_id
			$table->dropForeign('interactivities_question_id_foreign');

			// drop column question_id
			$table->dropColumn('question_id');
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
			//
		});
	}

}
