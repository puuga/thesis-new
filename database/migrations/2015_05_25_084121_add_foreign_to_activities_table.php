<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignToActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('activities', function(Blueprint $table)
		{
			$table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
			$table->foreign('activity_type_id')->references('id')->on('activity_types')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('activities', function(Blueprint $table)
		{
			$table->dropForeign('posts_content_id_foreign');
			$table->dropForeign('posts_activity_type_id_foreign');
		});
	}

}
