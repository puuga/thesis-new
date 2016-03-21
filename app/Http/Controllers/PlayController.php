<?php namespace App\Http\Controllers;

use App\Content;
use App\Category;
use App\Activity;
use App\History;
use App\Interactivity;
use View;
use Illuminate\Http\Request;
use Auth;
use DB;

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
		$content->count = $content->count+1;
		$content->save();
		$length = count($content->activities);
		$randomOrderArray = $this->randomNumberArray($length);
		$activityIdByOrders = $this->activityIdByOrders($randomOrderArray, $history);
		$history->activity_order = implode(",", $randomOrderArray);
		// $history->activity_order = $this->randomNumberArray($length);

		// 3. save history
		$history->save();

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

	public function track(Request $request) {
		// $interactivities = array();
		// dd($request->input('trackDatas'));

		foreach ($request->input('trackDatas') as $inter) {
			$interactivity = new Interactivity;
			$interactivity->user_id = Auth::user()->id;
			$interactivity->content_id = $inter["content_id"];
			$interactivity->activity_id = $inter["activity_id"];
			$interactivity->history_id = $inter["history_id"];
			$interactivity->action = $inter["action"];
			$interactivity->action_at = $inter["action_at"];
			$interactivity->detail = $inter["detail"];
			$interactivity->sequence_number = $inter["action_sequence_number"];

			$interactivity->save();
			
			$interactivities[] = $interactivity;
		}

		return response()->json(['result' => 'success','interactivities' => $interactivities]);

	}

	public function scoreByHistory($history_id) {
		$history = History::find($history_id);

		$answers = DB::select("
		select activity_id,detail
		from interactivities
		where history_id = :history_id and action='answer'",
		['history_id' => $history_id]);

		return view('play.result', ['history'=>$history,'answers'=>$answers]);
	}

}
