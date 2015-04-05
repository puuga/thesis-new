<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schools', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',1000)->nullable();
			$table->string('address',1000)->nullable();
			$table->string('tumbul',255)->nullable();
			$table->string('district',255)->nullable();
			$table->string('province',255)->nullable();
			$table->string('state',255)->nullable();
			$table->string('zone',255)->nullable();
			$table->string('country',255)->nullable();
			$table->string('region',255)->nullable();
			$table->string('zip',255)->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('schools');
	}

}
