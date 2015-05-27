<?php namespace App\Http\Controllers;

use App\User;
use App\Category;
use View;
use Request;
use Auth;

class UserController extends Controller {


	public function __construct()
	{
		$this->middleware('auth');
		// $this->middleware('guest');
	}


	public function userList()
	{
		$users = User::all();

		return view('user.home', ['users'=>$users]);
	}

	public function switchPermission($id) {
		$user = User::find($id);
		$user->type = $user->type === 'teacher' ? 'student' : 'teacher';
		$user->save();
		return response()->json(['result' => 'success', 'user' => $user]);
	}

	public function grantAdmin($id) {
		$user = User::find($id);
		$user->is_admin = $user->is_admin === '1' ? '0' : '1';
		$user->save();
		return response()->json(['result' => 'success', 'user' => $user]);
	}

}
