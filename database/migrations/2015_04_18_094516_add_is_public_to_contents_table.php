<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsPublicToContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contents', function(Blueprint $table)
		{
			$table->tinyInteger('is_public')->after('placeholder');
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
			//
		});
	}

}
