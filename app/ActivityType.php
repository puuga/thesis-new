<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityType extends Model {

	protected $table = 'activities';

	public function activities() {
		return $this->hasMany('App\Activity');
	}

}
