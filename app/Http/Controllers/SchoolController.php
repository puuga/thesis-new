<?php namespace App\Http\Controllers;

use App\User;
use App\School;
use View;
use Illuminate\Http\Request;
use Auth;

class SchoolController extends Controller {


	public function __construct()
	{
		$this->middleware('auth');
		// $this->middleware('guest');
	}


	public function schoolList()
	{
		$schools = School::all();

		return view('school.home', ['schools'=>$schools]);
	}

	public function createSchool(Request $request) {
		$school = new School;
		$school->name = $request->input('inName');
		$school->address = $request->input('inAddress');
		$school->tumbul = $request->input('inTumbul');
		$school->district = $request->input('inDistrict');
		$school->province = $request->input('inProvince');
		$school->state = $request->input('inState');
		$school->zone = $request->input('inZone');
		$school->country = $request->input('inCountry');
		$school->region = $request->input('inRegion');
		$school->zip = $request->input('inZip');
		$school->save();

		return response()->json(['result' => 'success', 'school' => $school]);
	}


}
