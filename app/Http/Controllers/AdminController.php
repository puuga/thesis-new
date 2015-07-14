<?php namespace App\Http\Controllers;

use App\Category;
use App\User;
use App\School;

class AdminController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
		// $this->middleware('guest');
	}

	public function home()
	{
		$users = User::all();
		$schools = School::all();
		$categories = Category::all();
		return view('admin.dashboard',[
			'users' => $users,
			'schools' => $schools,
			'categories' => $categories
		]);
	}

}
