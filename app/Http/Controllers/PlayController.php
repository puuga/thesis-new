<?php namespace App\Http\Controllers;

use App\Content;
use App\Category;
use App\Activity;
use App\History;
use View;
use Illuminate\Http\Request;
use Auth;

class PlayController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function play($id) {
		// 1. create history
		// 2. random activity order
		// 3. save history

		// 1. create history
		$history = new History;
		$history->content_id = $id;
		$history->user_id = Auth::user()->id;

		// 2. random activity order
		$content = Content::find($id);
		$length = count($content->activities);
		$randomOrderArray = $this->randomNumberArray($length);
		$activityIdByOrders = $this->activityIdByOrders($randomOrderArray, $history);
		$history->activity_order = implode(",", $randomOrderArray);
		// $history->activity_order = $this->randomNumberArray($length);

		// 3. save history
		// $history->save();

		return view('play.playground', [
			'history'=>$history,
			'randomOrderArray'=>$randomOrderArray,
			'activityIdByOrders'=>$activityIdByOrders
			]);
	}

	// if length == 3 then $random = [2,1,3]
	// if length == 5 then $random = [2,5,4,1,3]
	private function randomNumberArray($length) {
  	$random = Array();

		for ( $i=1; $i<=$length; $i++) {
      if ( count($random)==0 ) {
        $random[] = rand(1, $length);
      } else {
        do {
          $ran = rand(1, $length);
        } while ( in_array($ran, $random) );
        $random[] = $ran;
      }
    }

		return $random;
	}

	private function activityIdByOrders($order, $history) {
		$activityIds = Array();
		for ( $i=0; $i < count($order); $i++ ) {
			$activityIds[] = $history->content->activities[$order[$i]-1]->id;
		}
		return $activityIds;
	}

	public function getActivities($id) {
		$activity = Content::find($id)->activities->toJson();

		return response($activity, 200)->header('Content-Type', 'application/json');

	}

}
