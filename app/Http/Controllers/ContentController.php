<?php namespace App\Http\Controllers;

use App\Content;
use App\Category;
use View;
use Request;
use Auth;

class ContentController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}


	public function newContent()
	{
		return view('content.newcontent');
	}

	public function createContent() {
		return view('contact');
	}

}
