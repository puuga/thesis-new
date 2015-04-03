<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('message_comments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('message_id')->unsigned();
			$table->foreign('message_id')->references('id')->on('messages')->onDelete('cascade');
			$table->string('comment',255)->nullable();
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
		Schema::drop('message_comments');
	}

}
