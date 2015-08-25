<?php namespace App\Http\Controllers;

use App\Category;
use App\User;
use App\School;
use App\Content;
use DB;

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
		$contents = Content::all();
		$published_contents = Content::all()->where('is_public','1');
		$top10Contents = DB::select("select c.id,c.name, count(h.id) countt
			from contents c inner join histories h on c.id = h.content_id
			group by c.id
			order by countt desc
			limit 0,10");

		return view('admin.dashboard',[
			'users' => $users,
			'schools' => $schools,
			'categories' => $categories,
			'contents' => $contents,
			'top10Contents' => $top10Contents,
			'published_contents' => $published_contents
		]);
	}

}
