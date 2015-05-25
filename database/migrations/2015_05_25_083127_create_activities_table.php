<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activities', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('content_id')->unsigned();
			$table->integer('activity_type_id')->unsigned();
			$table->integer('order');
			$table->string('title',255)->nullable();
			$table->string('content',5000)->nullable();
			$table->string('placeholder',1000)->nullable();
			$table->string('image_placeholder',1000)->nullable();
			$table->string('extra1',5000)->nullable();
			$table->string('extra2',5000)->nullable();
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
		Schema::drop('activities');
	}

}
