<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

	//
	protected $table = 'messages';

	public function comments() {
		return $this->hasMany('App\MessageComment');
	}

}
