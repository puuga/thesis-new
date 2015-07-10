<?php namespace App\Http\Controllers;

use App\Content;
use App\Category;
use App\Activity;
use View;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Http\Response;

class ContentController extends Controller {

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

		return view('content.mycontent', ['contents'=>$contents]);
	}


	public function newContent()
	{
		$categories = Category::all();

		return view('content.newcontent', ['categories'=>$categories]);
	}

	public function createContent(Request $request) {
		$content = new Content;
		$content->category_id = $request->input('inCategory');
		$content->user_id = Auth::user()->id;
		$content->level = $request->input('inLevel');
		$content->name = $request->input('inName');
		$content->description = $request->input('inDescription');
		$content->is_public = $request->input('inPublish') === "publish" ? 1 : 0 ;

		$content->save();

		return redirect()->route('designContent', [$content->id]);
	}

	public function updateContent($id, Request $request) {
		$content = Content::find($id);
		$content->category_id = $request->input('inCategory');
		$content->level = $request->input('inLevel');
		$content->name = $request->input('inName');
		$content->description = $request->input('inDescription');
		$content->is_public = $request->input('inPublish') === "publish" ? 1 : 0 ;
		$content->is_inprogress = $request->input('inProgress') === "inProgress" ? 1 : 0 ;

		$content->save();

		return redirect()->route('designContent', [$content->id]);
	}

	public function designContent($id)
	{
		$content = Content::find($id);

		$categories = Category::all();

		return view('content.design', ['content'=>$content, 'categories'=>$categories]);
	}

	public function createActivity($contentId, Request $request) {
		$activity = new Activity;
		$activity->content_id = $contentId;
		$activity->activity_type_id = $request->input('inActivityTypeId');
		$activity->order = $this->lastActivityOrder($contentId) + 1;

		$activity->save();

		return response()->json(['result' => 'success', 'activity' => $activity, 'activity_type'=>$activity->activityType]);
	}

	private function lastActivityOrder($contentId) {
		$content = Content::find($contentId);
		return count($content->activities);
	}

	public function changeActivityOrder(Request $request) {
		$activity1 = Activity::find($request->input('act1id'));
		$activity1->order = $request->input('act1order');
		$activity1->save();

		$activity2 = Activity::find($request->input('act2id'));
		$activity2->order = $request->input('act2order');
		$activity2->save();

		return response()->json(['result' => 'success', 'activity1'=>$activity1, 'activity2'=>$activity2]);
	}

	public function deleteActivity(Request $request) {
		$activity = Activity::find($request->input('activity_id'));

		//delete activity...
		$activity->delete();

		// reorder
		$content = Content::find($request->input('content_id'));
		$this->reActivityOrder($content->activities);
		return response()->json(['result' => 'success','content'=>$content,'activities'=>$content->activities]);
	}

	private function reActivityOrder($activities) {
		if (count($activities)===0) {
			return;
		}
		for ($i=0; $i < count($activities); $i++) {
			$activities[$i]->order = $i+1;
			$activities[$i]->save();
		}
	}

	public function designActivity($id) {
		$activity = Activity::find($id);
		switch ($activity->activity_type_id) {
			case '1':
				return view('content.activity.designtype1', ['activity'=>$activity]);
				break;
			case '6':
				return view('content.activity.designtype6', ['activity'=>$activity]);
				break;
			default:
				return redirect()->back();
				break;
		}
	}

	public function updateActivityInformation(Request $request) {
		$activity = Activity::find($request->input('activity_id'));

		switch ($activity->activity_type_id) {
			case '1':
				// inTitle => title
				// inText => content
				// inHint => placeholder
				$activity->title = $request->input('inTitle');
				$activity->content = strtoupper($request->input('inText'));
				$activity->placeholder = $request->input('inHint');
				break;
			case '6':
				// inTitle => title
				// inSubTitle => content
				// message1,message2,message3,message4 => extra1
				// isAnswer1,isAnswer2,isAnswer3,isAnswer4 => extra2
				$activity->title = $request->input('inTitle');
				$activity->content = $request->input('inSubTitle');

				$message = $request->input('message1');
				$message .= ",".$request->input('message2');
				$message .= ",".$request->input('message3');
				$message .= ",".$request->input('message4');
				$activity->extra1 = $message;

				$isAnswer = $request->input('isAnswer1');
				$isAnswer .= ",".$request->input('isAnswer2');
				$isAnswer .= ",".$request->input('isAnswer3');
				$isAnswer .= ",".$request->input('isAnswer4');
				$activity->extra2 = $isAnswer;
				break;
			default:
				// return redirect()->back();
				break;
		}
		// update


		// save
		$activity->save();
		return response()->json(['result'=>'success','action'=>'update','activity'=>$activity]);
	}

	public function updateActivityAnimation(Request $request) {
		$activity = Activity::find($request->input('activity_id'));

		// update
		$activity->correct_animation = $request->input('correct_animation');
		$activity->incorrect_animation = $request->input('incorrect_animation');

		// save
		$activity->save();
		return response()->json(['result'=>'success','action'=>'update','activity'=>$activity]);
	}

	public function contentHistory($id) {
		$histories = Content::find($id)->histories;

		return view('content.history', ['histories'=>$histories]);
	}

}
