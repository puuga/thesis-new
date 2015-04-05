<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PlainContent extends Model {

	//
	protected $table = 'plain_contents';

	public function content() {
		return $this->belongsTo('App\Content');
	}

}
