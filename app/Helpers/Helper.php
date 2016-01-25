<?php namespace App\Helpers;

use Illuminate\Support\Facades\Facade;
use DB;
use App\Content;

class Helper extends Facade {

  protected static function getFacadeAccessor() { return 'helper'; }

  // user_response, answer
  public static function deepCompare($objectA, $objectB) {
    // check member length
    if (count($objectA) != count($objectB)) {
      return false;
    }

    // check member
    for ($i = 0; $i < count($objectA); $i++) {
      $a = $objectA[$i];
      $b = $objectB[$i];

      if (count($a->members) != count($b->members)) {
        return false;
      } else {
        for ($j = 0; $j < count($b->members); $j++) {
          $bm = $b->members[$j];
          if ( !in_array($bm, $a->members) ) {
            return false;
          }
        }
      }
    }

    return true;
  }

  public static function isCorrectAnswer($history, $activity, $answer) {
    if ( $activity->activity_type_id === "1" ) {
      if ( $activity->content===str_replace(",","",$answer->detail) ) {
        return true;
      } else {
        return false;
      }
    }
    elseif ( $activity->activity_type_id === "2" ) {
      $correctAnswer = DB::table('interactivities')
                        ->where('activity_id',$activity->id)
                        ->where('history_id',$history->id)
                        ->where('action','answer_correct')
                        ->first();
      if ( is_null($correctAnswer) ) {
        return false;
      }
      if ( Helper::deepCompare(json_decode($answer->detail),json_decode($correctAnswer->detail) ) ) {
        return true;
      } else {
        return false;
      }
    }
    elseif ( $activity->activity_type_id === "5" ) {
      if ( $activity->extra2 === $answer->detail ) {
        return true;
      } else {
        return false;
      }
    }
    elseif ( $activity->activity_type_id === "6" ) {
      if ( $activity->extra2 === $answer->detail ) {
        return true;
      } else {
        return false;
      }
    }

  }

  public static function getContentsByCategoryProgress($category_id, $is_inprogress) {
    $contents = Content::where(function($query) use($category_id, $is_inprogress) {
			$query->where('is_inprogress',$is_inprogress)
				->whereHas('category', function($query) use($category_id) {
						$query->where('id',$category_id);
				});
		})->get();

    return $contents;
  }

}
