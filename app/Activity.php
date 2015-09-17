<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {

	protected $table = 'activities';
	protected $appends = ['image_path','content_arr','shuffled_content','shuffled_content_arr'];

	private $shuffleContent = "";

	public function content() {
		return $this->belongsTo('App\Content');
	}

	public function interactivities() {
		return $this->hasMany('App\Interactivity');
	}

	public function activityType() {
		return $this->belongsTo('App\ActivityType');
	}

	public function getImagePathAttribute() {
		if ( !isset($this->attributes['image_placeholder']) || is_null($this->attributes['image_placeholder']) ) {
			return "";
		}
		return route('getimagebyid',$this->attributes['image_placeholder']);
	}

	public function getContentArrAttribute() {
		if ($this->attributes['activity_type_id'] === "2"
			|| $this->attributes['activity_type_id'] === "6") {
			return "";
		}

		return str_split($this->content);
	}

	private function genShuffleContent() {
		if ($this->attributes['activity_type_id'] === "2"
			|| $this->attributes['activity_type_id'] === "6") {
			return "";
		}

		if ( !isset($this->attributes['content']) ) {
			return "";
		}

		if ( $this->shuffleContent === "" ) {
			$this->shuffleContent = str_shuffle($this->attributes['content']);
		}

		return $this->shuffleContent;
	}

	private function genShuffleContentArr() {
		if ($this->attributes['activity_type_id'] === "2") {
			return "";
		}

		if ( $this->shuffleContent === "" ) {
			$this->genShuffleContent();
		}

		$shuffleContentArr = str_split($this->genShuffleContent());

		return $shuffleContentArr;
	}

	public function getShuffledContentAttribute() {
		return $this->genShuffleContent();
	}

	public function getShuffledContentArrAttribute() {
		return $this->genShuffleContentArr();
	}

}
