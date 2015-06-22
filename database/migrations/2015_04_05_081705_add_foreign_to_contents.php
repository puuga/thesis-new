<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignToContents extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contents', function(Blueprint $table)
		{
			$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contents', function(Blueprint $table)
		{
			$table->dropForeign('contents_user_id_foreign');
			$table->dropForeign('contents_category_id_foreign');
		});
	}

}
