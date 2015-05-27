<?php namespace App\Http\Controllers;

use App\User;
use App\Category;
use View;
use Request;
use Auth;

class CategoryController extends Controller {


	public function __construct()
	{
		$this->middleware('auth');
		// $this->middleware('guest');
	}


	public function categoryList()
	{
		$categorys = Category::all();

		return view('category.home', ['categorys'=>$categorys]);
	}



}
