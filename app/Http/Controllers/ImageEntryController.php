<?php namespace App\Http\Controllers;

use App\Content;
use App\Category;
use App\ImageEntry;
use App\Activity;
use View;
use Request;
use Auth;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class ImageEntryController extends Controller {

	public function __construct()
	{
		// $this->middleware('auth');
	}

	public function allImage() {
		$entries = ImageEntry::all();

		return view('', compact('entries'));
	}

	public function allImageBelongToUser() {
		$images = Auth::user()->imageEntries;

		return view('', ['images'=>$images]);
	}

	private function saveImage($file) {
		$extension = $file->getClientOriginalExtension();
		Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));
		$entry = new ImageEntry();
		$entry->user_id = Auth::user()->id;
		$entry->filename = $file->getFilename().'.'.$extension;
		$entry->mime = $file->getClientMimeType();
		$entry->original_filename = $file->getClientOriginalName();

		$entry->save();

		return $entry;
	}

	public function add() {
		$file = Request::file('imagefield');
		$entry = $this->saveImage($file);

		return redirect()->back();
	}

	public function addWithResponse() {
		$file = Request::file('imagefield');
		$entry = $this->saveImage($file);

		return response()->json([
			'result'=>'success',
			'action'=>'upload image',
			'entry'=>$entry
		]);
	}

	public function addToContent() {
		$file = Request::file('imagefield');
		$entry = $this->saveImage($file);

		$content = Content::find(Request::input('contentid'));
		$content->image_entry_id = $entry->id;
		$content->save();

		return redirect()->back();
	}

	public function addToActivity() {
		$file = Request::file('inImage');
		$entry = $this->saveImage($file);

		$activity = Activity::find(Request::input('activity_id'));
		$activity->image_placeholder = $entry->id;
		$activity->save();

		return response()->json([
			'result'=>'success',
			'action'=>'upload image',
			'activity'=>$activity,'image'=>$entry
		]);
	}

	public function getByFilename($filename) {
		$entry = ImageEntry::where('filename', '=', $filename)->firstOrFail();
		$file = Storage::disk('local')->get($entry->filename);
		return (new Response($file, 200))->header('Content-Type', $entry->mime);
	}

	public function getById($id) {
		$entry = ImageEntry::find($id);
		$file = Storage::disk('local')->get($entry->filename);
		return (new Response($file, 200))->header('Content-Type', $entry->mime);
	}


}
