<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignToContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contents', function(Blueprint $table)
		{
			//
			$table->foreign('image_entry_id')->references('id')->on('image_entries')->onDelete('cascade');
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
			$table->dropForeign('contents_image_entry_id_foreign');
		});
	}

}
