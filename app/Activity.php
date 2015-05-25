<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {

	protected $table = 'activities';

	public function content() {
		return $this->belongsTo('App\Content');
	}

	public function interactivities() {
		return $this->hasMany('App\Interactivity');
	}

	public function activityType() {
		return $this->belongsTo('App\ActivityType');
	}

}
