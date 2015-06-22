<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['school_id', 'name', 'firstname', 'lastname', 'email', 'password', 'type'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function school() {
		return $this->belongsTo('App\School');
	}

	public function contents() {
		return $this->hasMany('App\Content');
	}

	public function imageEntries() {
		return $this->hasMany('App\ImageEntry');
	}

	public function isTeacher() {
		return $this->type === 'teacher';
	}

	public function isStudent() {
		return $this->type === 'student';
	}

	public function isAdmin() {
		return $this->is_admin === '1';
	}

	public function histories()
  {
    return $this->hasMany('App\History');
  }

}
