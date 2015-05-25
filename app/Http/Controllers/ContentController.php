<?php namespace App\Http\Controllers;

use App\Content;
use App\Category;
use View;
use Illuminate\Http\Request;
use Auth;

class ContentController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
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

}
