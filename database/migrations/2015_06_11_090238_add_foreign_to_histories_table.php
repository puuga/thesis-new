<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignToHistoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('histories', function(Blueprint $table)
		{
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('histories', function(Blueprint $table)
		{
			$table->dropForeign('histories_user_id_foreign');
			$table->dropForeign('histories_content_id_foreign');
		});
	}

}
