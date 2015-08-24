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

	public function activity() {
		return $this->belongsTo('App\Activity');
	}

	public function history() {
		return $this->belongsTo('App\History');
	}

}
