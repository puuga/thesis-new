<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model {

	// The table associated with the model.
	protected $table = 'histories';

	public function user()
  {
    return $this->belongsTo('App\User');
  }

	public function content()
  {
    return $this->belongsTo('App\Content');
  }

	public function interactivities()
	{
		return $this->hasMany('App\Interactivity')->orderBy('sequence_number');
	}

	public function interactivities_count()
	{
		return $this->hasMany('App\Interactivity')
			->where('action', '=', 'choose')
			->orWhere('action', '=', 'click')
			->orderBy('sequence_number');
	}

}
