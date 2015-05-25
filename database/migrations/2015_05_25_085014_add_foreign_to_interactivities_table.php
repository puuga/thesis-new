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
			$table->integer('activity_id')->unsigned()->after('question_id');
			$table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
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
			$table->dropForeign('posts_activity_id_foreign');
		});
	}

}
