<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageEntry extends Model {

	//
	protected $table = 'image_entries';

	public function user() {
		return $this->belongsTo('App\User');
	}

}
