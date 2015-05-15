<?php namespace App\Http\Controllers;

use App\Content;
use App\Category;
use App\ImageEntry;
use View;
use Request;
use Auth;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class ImageEntryController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function allImage() {
		$entries = ImageEntry::all();

		return view('', compact('entries'));
	}

	public function allImageBelongToUser() {
		$images = Auth::user()->imageEntries;

		return view('', ['images'=>$images]);
	}

	public function add() {

		$file = Request::file('imagefield');
		$extension = $file->getClientOriginalExtension();
		Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));
		$entry = new ImageEntry();
		$entry->user_id = Auth::user()->id;
		$entry->filename = $file->getFilename().'.'.$extension;
		$entry->mime = $file->getClientMimeType();
		$entry->original_filename = $file->getClientOriginalName();

		$entry->save();

		return redirect()->back();

	}

	public function addToContent() {

		$file = Request::file('imagefield');
		$extension = $file->getClientOriginalExtension();
		Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));
		$entry = new ImageEntry();
		$entry->user_id = Auth::user()->id;
		$entry->filename = $file->getFilename().'.'.$extension;
		$entry->mime = $file->getClientMimeType();
		$entry->original_filename = $file->getClientOriginalName();

		$entry->save();

		$content = Content::find(Request::input('contentid'));
		$content->image_entry_id = $entry->id;
		$content->save();

		return redirect()->back();

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
