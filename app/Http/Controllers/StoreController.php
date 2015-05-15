<?php namespace App\Http\Controllers;

use App\Content;
use App\Category;
use View;
use Request;
use Auth;

class StoreController extends Controller {

	public $kPage = 16;

	public function __construct()
	{
		// $this->middleware('auth');
		// $this->middleware('guest');

		$categories = Category::all();
		View::share('categories', $categories);
	}


	public function home()
	{
		if ( Auth::check() ) {
			if ( Request::has('keysearch') ) {
				$keysearch = Request::input('keysearch');
				$contents = Content::where('name', 'like', "%$keysearch%")
															->orWhere('description', 'like', "%$keysearch%")
	                    				->get();
				return view('store.home', ['contents'=>$contents]);
			}
			$popContents = Content::orderBy('count', 'desc')->take(4)->get();
			$newContents = Content::orderBy('updated_at', 'desc')->take(4)->get();
		} else {
			if ( Request::has('keysearch') ) {
				$keysearch = Request::input('keysearch');
				$contents = Content::where('is_public', 1)
											->where(function($query) {
												$query->where('name', 'like', "%$keysearch%")
															->orWhere('description', 'like', "%$keysearch%");
											})
	                    ->get();
				return view('store.home', ['contents'=>$contents]);
			}
			$popContents = Content::where('is_public', 1)->orderBy('count', 'desc')->take(4)->get();
			$newContents = Content::where('is_public', 1)->orderBy('updated_at', 'desc')->take(4)->get();
		}

		return view('store.home', ['popContents'=>$popContents, 'newContents'=>$newContents]);
	}

	public function contentById($id) {
		$content = Content::find($id);
		$content->count = $content->count+1;
		$content->save();
		return view('store.content', ['content'=>$content]);
	}

	public function categoryById($id) {
		$category = Category::find($id);
		if ( Auth::check() ) {
			$contents = $this->categoryByIdWithAuth($id);
		} else {
			$contents = $this->categoryByIdWithOutAuth($id);
		}

		return view('store.category', ['category'=>$category, 'contents'=>$contents]);
	}

	public function categoryByIdWithAuth($id) {
		$contents = Content::
			where('is_public', 1)
			->whereHas('category', function($query) use($id) {
					$query->where('id',$id);
			})
			->orWhere(function($query){
				$query->where('is_public', 0)
					->WhereHas('user', function($query) {
							$query->where('school_id',Auth::user()->school->id);
					});
			})
			->paginate($this->kPage);
			// ->get();

		return $contents;
	}

	public function categoryByIdWithOutAuth($id) {
		$contents = Category::find($id)->contents()
			->where('is_public', 1)
			->paginate($this->kPage);
			// ->get();

		return $contents;
	}

}
