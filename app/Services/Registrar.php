<?php namespace App\Services;

use App\User;
use App\School;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'firstname' => 'required|max:255',
			'lastname' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
			'type' => 'required|max:255',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		// $user = new User;
		// $user->name = $data['firstname'].' '.$data['lastname'];
		// $user->firstname = $data['firstname'];
		// $user->lastname = $data['lastname'];
		// $user->email = $data['email'];
		// $user->password = bcrypt($data['password']);
		// $user->type = $data['type'];
		//
		// //$user->school_id = School::find($data['school_id'])->id;
		// $user->school_id = $data['school_id'];
		// $user->save();
		//
		// // $school = School::find($data['school_id']);
		// // $user = $school->users()->save($school);
		//
		// return $user;

		return User::create([
			'name' => $data['firstname'].' '.$data['lastname'],
			'firstname' => $data['firstname'],
			'lastname' => $data['lastname'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'type' => $data['type'],
			'school_id' => $data['school_id'],
		]);
	}

}
