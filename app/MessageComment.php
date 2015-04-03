<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageComment extends Model {

	//
	protected $table = 'message_comments';

	public function message() {
		return $this->belongsTo('App\Message');
	}

}
