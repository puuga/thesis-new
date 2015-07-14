<?php namespace App\Http\Controllers;

use App\User;
use App\Category;
use View;
use Illuminate\Http\Request;
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

		return view('admin.category', ['categorys'=>$categorys]);
	}

	public function createCategory(Request $request) {
		$category = new Category;
		$category->name = $request->input('inName');
		$category->save();

		return response()->json(['result' => 'success','category' => $category,'count'=>count(Category::all())]);
	}



}
