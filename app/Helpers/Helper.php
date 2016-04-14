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

  public static function createArff1Content($content, $histories, $frequencies) {
    $out = "";
    $out .= "@RELATION content".$content->id."\n";
    $out .= "@attribute history_id NUMERIC\n";
    $out .= "@attribute time STRING\n";
    $out .= "@attribute user_id NUMERIC\n";
    $out .= "@attribute user_name STRING\n";

    for ($i=0; $i < count($content->activities); $i++) {
      $out .= "@attribute activity_answer_".($i+1)." {0,1}\n";
      $out .= "@attribute activity_time_".($i+1)." NUMERIC\n";
    }

    $out .= "@attribute score NUMERIC\n";
    $out .= "@attribute total_time NUMERIC\n";

    $out .= "@data\n";

    $new_results = Helper::arffContent($content, $histories, $frequencies);

    // dd($new_results);

    foreach($new_results as $new_result) {
      for($i=1; $i <= count($content->activities); $i++) {
        if($new_result["answer_".$i]=="null") {
          $conti=true;
          break;
        }
        $conti=false;
      }
      if($conti==true) {
        continue;
      }

      $out .= $new_result["history_id"].",";
      $out .= $new_result["created_at"].",";
      $out .= $new_result["user_id"].",";
      $out .= str_replace(" ", "_", $new_result["user_name"]).",";
      for($i=1; $i <= count($content->activities); $i++) {
        $out .= ($new_result["answer_".$i]=="correct" ? 1 : 0 ).",";
        $out .= $new_result["timediff_".$i].",";
      }
      $out .= $new_result["score"].",";
      $out .= $new_result["time"]."\n";
    }

    return $out;
  }

  public static function createArff2Content($content, $histories, $frequencies) {
    $out = "";
    $out .= "@RELATION content".$content->id;
    $out .= "@attribute history_id NUMERIC\n";
    $out .= "@attribute time STRING\n";
    $out .= "@attribute user_id NUMERIC\n";
    $out .= "@attribute user_name STRING\n";

    for ($i=0; $i < count($content->activities); $i++) {
      $out .= "@attribute activity_answer_".($i+1)." {0,1}\n";
      $out .= "@attribute activity_time_".($i+1)." NUMERIC\n";
      $out .= "@attribute interactivity_count_{{ $i+1 }} NUMERIC\n";
    }

    $out .= "@attribute score NUMERIC\n";
    $out .= "@attribute total_time NUMERIC\n";

    $out .= "@data\n";

    $new_results = Helper::arffContent($content, $histories, $frequencies);

    foreach($new_results as $new_result) {
      for($i=1; $i <= count($content->activities); $i++) {
        if($new_result["answer_".$i]=="null") {
          $conti=true;
          break;
        }
        $conti=false;
      }
      if($conti==true) {
        continue;
      }

      $out .= $new_result["history_id"].",";
      $out .= $new_result["created_at"].",";
      $out .= $new_result["user_id"].",";
      $out .= str_replace(" ", "_", $new_result["user_name"]).",";
      for($i=1; $i <= count($content->activities); $i++) {
        $out .= ($new_result["answer_".$i]=="correct" ? 1 : 0 ).",";
        $out .= $new_result["timediff_".$i].",";
        $out .= $new_result["interactivity_count".$i].",";
      }
      $out .= $new_result["score"].",";
      $out .= $new_result["time"]."\n";
    }

    return $out;
  }

  static function arffContent($content, $histories, $frequencies) {
    $activity_count=count($histories[0]->content->activities);
    for ($i=0; $i < $activity_count; $i++) {
      $activity_id_arr[] = $histories[0]->content->activities[$i]->id;
    }
    // dd($activity_id_arr);
    $new_results = array();
    $sum_time = 0;

    foreach ($histories as $history) {
      $arr["history_id"] = $history->id;
      $arr["user_id"] = $history->user->id;
      $arr["user_name"] = $history->user->name;
      $arr["created_at"] = $history->created_at;
      $time = 0;
      $score = 0;

      for ($i = 0; $i < count($history->activity_order_arr); $i++) {
        $key = $history->activity_order_arr[$i];
        $timediff = isset($history->timediff_arr[$i]) ? $history->timediff_arr[$i] : 0;
        $answer = "";
        if ($timediff==0) {
          $answer = "null";
        } elseif (isset($history->answer_arr[$i]) && $history->answer_arr[$i]==true) {
          $answer = "correct";
          $score++;
        } else {
          $answer = "incorrect";
        }

        $arr["answer_".$key] = $answer;
        $arr["timediff_".$key] = $timediff;

        $interactivity_count = DB::table('interactivities')
          ->where('history_id', '=', $history->id)
          ->where('activity_id', '=', $activity_id_arr[$i])
          ->where(function($q){
            $q->where('action', '=', 'choose')
            ->orWhere('action', '=', 'click');
          })
          ->get();
        $arr["interactivity_count".$key] = count($interactivity_count);

        $time += $timediff;
        if ( !isset($sum_results[$key]["time"]) ) {
          $sum_results[$key]["time"] = 0;
        }
        if ( !isset($sum_results[$key]["answer_yes_counter"]) ) {
          $sum_results[$key]["answer_yes_counter"] = 0;
        }
        if ( !isset($sum_results[$key]["answer_no_counter"]) ) {
          $sum_results[$key]["answer_no_counter"] = 0;
        }
        if ( !isset($sum_results[$key]["counter"]) ) {
          $sum_results[$key]["counter"] = 0;
        }
        $sum_results[$key]["time"] += $timediff;
        if ($answer==="correct" && $timediff!=0) {
          $sum_results[$key]["answer_yes_counter"]++;
        } else if ($answer==="incorrect" && $timediff!=0) {
          $sum_results[$key]["answer_no_counter"]++;
        }
        if ($timediff!=0) {
          $sum_results[$key]["counter"]++;
        }
      }

      $sum_time += $time;

      $arr["score"] = $score;
      $arr["time"] = $time;
      $new_results[] = $arr;
    }

    return $new_results;
  }

}
