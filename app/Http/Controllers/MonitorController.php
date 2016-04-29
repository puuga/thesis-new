<?php namespace App\Http\Controllers;

use App\Content;
use App\Category;
use App\Activity;
use App\History;
use View;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Http\Response;
use DB;
use Helper;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MonitorController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function allContents() {
		// return response()->json(['result' => 'success', 'contents' => Content::all()]);
		$content = Content::with('activities')->get()->toJson();
		return response($content, 200)->header('Content-Type', 'application/json');
	}

	public function myContent() {
		// $contents = Content::where('user_id', Auth::user()->id);
		$contents = Auth::user()->contents;

		return view('monitor.mycontent', ['contents'=>$contents]);
	}

	public function monitorDetail($id) {
		$histories = Content::find($id)->histories()->orderBy('created_at', 'desc')->get();

		$frequencies = DB::select('SELECT
			    YEAR(created_at) year_ac,
			    MONTH(created_at) month_ac,
			    DAY(created_at) day_ac,
			    COUNT(id) count
			FROM
			    histories
			WHERE
			    content_id = ?
			GROUP BY DATE(created_at)',[$id]
		);

		$year_count = DB::select('SELECT
			    count(distinct YEAR(created_at)) year_count
			FROM
			    histories
			WHERE
			    content_id = ?
			GROUP BY YEAR(created_at)',[$id]
		);

    for ($i=0; $i < count($histories); $i++) {
      // activity array
      $activity_arr = explode(",",$histories[$i]->activity_order);
      $histories[$i]->activity_order_arr = $activity_arr;

      // ans for each activity
      $histories[$i]->answer_arr = $this->getAnswer($histories[$i]);

      // todo: total time for each activity
      $histories[$i]->timediff_arr = $this->getTime($histories[$i]);
    }

		// dd($histories);

		return view('monitor.history', [
			'content_id'=>$id,
			'content'=>Content::find($id)->get(),
			'histories'=>$histories,
			'frequencies'=>$frequencies,
			'year_count'=>$year_count
		]);
	}

	function getYearCount($id) {
		$year_count = DB::select('SELECT
			    count(distinct YEAR(created_at)) year_count
			FROM
			    histories
			WHERE
			    content_id = ?
			GROUP BY YEAR(created_at)',[$id]
		);

		return $year_count;
	}

	function getFrequencies($id) {
		$frequencies = DB::select('SELECT
			    YEAR(created_at) year_ac,
			    MONTH(created_at) month_ac,
			    DAY(created_at) day_ac,
			    COUNT(id) count
			FROM
			    histories
			WHERE
			    content_id = ?
			GROUP BY DATE(created_at)',[$id]
		);

		return $frequencies;
	}

	function getHistories($id) {
		$histories = Content::find($id)->histories()->orderBy('created_at', 'desc')->get();

		for ($i=0; $i < count($histories); $i++) {
      // activity array
      $activity_arr = explode(",",$histories[$i]->activity_order);
      $histories[$i]->activity_order_arr = $activity_arr;

      // ans for each activity
      $histories[$i]->answer_arr = $this->getAnswer($histories[$i]);

      // todo: total time for each activity
      $histories[$i]->timediff_arr = $this->getTime($histories[$i]);
    }

		return $histories;
	}

	public function monitorCSV($id) {
		$histories = $this->getHistories($id);

		$frequencies = $this->getFrequencies($id);

		$year_count = $this->getYearCount($id);

		// dd($histories);

		return view('monitor.csv', [
			'content'=>$content = Content::find($id),
			'histories'=>$histories,
			'frequencies'=>$frequencies,
			'year_count'=>$year_count
		]);
	}

	public function createArffFile1($id) {
		$content = Content::find($id);
		$histories = $this->getHistories($id);
		$frequencies = $this->getFrequencies($id);
		//Usage
		// File::put($path,$contents);
		//Example
		// File::put('web/text/mytextdocument.txt','John Doe');
		// Local
		Storage::disk('local')->put(
			"arff".$id."/arff.".$id.'.1.arff',
			Helper::createArff1Content($content, $histories, $frequencies)
		);

		$filename = "arff.".$id.'.1.arff';

		return response()->json([
			'result'=>'success',
			'action'=>'arff file created',
			'filename'=>$filename,
			'url'=>route('getArffFile', ['id' => $id, 'filename'=>$filename])
		]);
	}

	public function createArffFile2($id) {
		$content = Content::find($id);
		$histories = $this->getHistories($id);
		$frequencies = $this->getFrequencies($id);
		//Usage
		// File::put($path,$contents);
		//Example
		// File::put('web/text/mytextdocument.txt','John Doe');
		// Local
		Storage::disk('local')->put(
			"arff".$id."/arff.".$id.'.2.arff',
			Helper::createArff2Content($content, $histories, $frequencies)
		);

		$filename = "arff.".$id.'.2.arff';

		return response()->json([
			'result'=>'success',
			'action'=>'arff file created',
			'filename'=>"arff.".$id.'.2.arff',
			'url'=>route('getArffFile', ['id' => $id, 'filename'=>$filename])
		]);
	}

	public function getArffFile($id, $filename) {
		$filenameWithPath =  "arff".$id."/".$filename;
		if ( Storage::disk('local')->exists($filenameWithPath) ) {
			$file =  Storage::disk('local')->get($filenameWithPath);
			return (new Response($file, 200))->header('Content-Type', 'application/octet-stream');
		}
		abort(404);
	}

  function getTime($history) {
    $answers = DB::select("
    select activity_id,action,action_at
    from interactivities
    where history_id = :history_id and (action='answer' or action='start activity')
    order by sequence_number",
    ['history_id' => $history->id]);

    $timediff_arr = [];
		if ( count($answers)==0 ) {
			return $timediff_arr;
		}

    for ( $i=0; $i<count($history->activity_order_arr) ; $i++ ) {
			if ( !isset($history->activity_order_arr[$i]) ) {
				continue;
			}
			if ( !isset($history->content->activities[$history->activity_order_arr[$i]-1]) ) {
				continue;
			}
      $act = $history->content->activities[$history->activity_order_arr[$i]-1];
			if ( !isset($answers[$i*2]) ) {
				$timediff_arr[] = 0;
				continue;
			}
      if ( $act->id === $answers[$i*2]->activity_id ) {
        $starttime = strtotime($answers[$i*2]->action_at);
				if ( isset($answers[$i*2+1]) ) {
					$endtime = strtotime($answers[$i*2+1]->action_at);
				} else {
					$endtime = $starttime;
				}

        $timediff_arr[] = $endtime - $starttime;
      }
    }

    return $timediff_arr;
  }

  function getAnswer($history) {
    $answers = DB::select("
    select activity_id,detail
    from interactivities
    where history_id = :history_id and action='answer'",
    ['history_id' => $history->id]);

    $answer_arr = [];
		if ( count($answers)==0 ) {
			return $answer_arr;
		}

    for ( $i=0; $i<count($history->activity_order_arr) ; $i++ ) {
			if ( !isset($history->content->activities[$history->activity_order_arr[$i]-1]) ) {
				continue;
			}
      $act = $history->content->activities[$history->activity_order_arr[$i]-1];
			if ( !isset($answers[$i]) ) {
				$answer_arr[] = false;
				continue;
			}
      if ( $act->id === $answers[$i]->activity_id ) {
        if ( Helper::isCorrectAnswer($history, $act, $answers[$i]) ) {
          $answer_arr[] = true;
					continue;
        } else {
          $answer_arr[] = false;
					continue;
        }
      }
    }

		// dd($answer_arr);

    return $answer_arr;
  }

	public function monitorDetailByHistory($id, $history_id) {
		$history = History::find($history_id);

		$answers = DB::select("
		select activity_id,detail
		from interactivities
		where history_id = :history_id and action='answer'",
		['history_id' => $history_id]);

		return view('monitor.result_detail', [
			'history'=>$history,
			'answers'=>$answers
			]);
	}

	public function monitorDummy() {
		return view('monitor.dummy');
	}

}
