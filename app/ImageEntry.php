<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageEntry extends Model {

	//
	protected $table = 'image_entries';
	protected $appends = ['image_path'];

	public function user() {
		return $this->belongsTo('App\User');
	}

	public function getImagePathAttribute() {
		if ( is_null($this->attributes['id']) ) {
			return "";
		}
		return route('getimagebyid',$this->attributes['id']);
	}

}
