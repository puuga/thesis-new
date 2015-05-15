<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model {

	//
	protected $table = 'contents';

	public function category() {
		return $this->belongsTo('App\Category');
	}

	public function user() {
		return $this->belongsTo('App\User');
	}

	public function plainContents() {
		return $this->hasMany('App\PlainContent');
	}

	public function questions() {
		return $this->hasMany('App\Question');
	}

	public function imageEntries() {
		return $this->hasMany('App\ImageEntry');
	}

}
