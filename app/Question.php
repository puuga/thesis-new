<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model {

	//
	protected $table = 'questions';

	public function content() {
		return $this->belongsTo('App\Content');
	}

	public function interactivities() {
		return $this->hasMany('App\Interactivity');
	}

}
