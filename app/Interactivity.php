<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Interactivity extends Model {

	//
	protected $table = 'interactivities';

	public function user() {
		return $this->belongsTo('App\User');
	}

	public function question() {
		return $this->belongsTo('App\Question');
	}

}
