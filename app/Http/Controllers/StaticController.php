<?php namespace App\Http\Controllers;

use App\Content;
use App\Category;
use View;
use Request;
use Auth;

class StaticController extends Controller {

	public $kPage = 16;

	public function __construct()
	{
		// $this->middleware('auth');
		// $this->middleware('guest');

		$categories = Category::all();
		View::share('categories', $categories);
	}


	public function about()
	{
		return view('about');
	}

	public function contact() {
		return view('contact');
	}

}
