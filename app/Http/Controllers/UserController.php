<?php namespace App\Http\Controllers;

use App\User;
use App\Category;
use App\History;
use View;
use Request;
use Auth;
use DB;

class UserController extends Controller {


	public function __construct()
	{
		$this->middleware('auth');
		// $this->middleware('guest');
	}


	public function userList()
	{
		$users = User::all();

		return view('admin.user', ['users'=>$users]);
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

	public function histories() {
		$histories = Auth::user()->histories()->orderBy('created_at', 'desc')->get();

		$frequencies = DB::select('SELECT
			    YEAR(created_at) year_ac,
			    MONTH(created_at) month_ac,
			    DAY(created_at) day_ac,
			    COUNT(id) count
			FROM
			    histories
			WHERE
			    user_id = ?
			GROUP BY DATE(created_at)',[Auth::user()->id]
		);

		$year_count = DB::select('SELECT
			    count(distinct YEAR(created_at)) year_count
			FROM
			    histories
			WHERE
			    user_id = ?
			GROUP BY YEAR(created_at)',[Auth::user()->id]
		);

		return view('user.history', [
			'histories'=>$histories,
			'frequencies'=>$frequencies,
			'year_count'=>$year_count
		]);
	}

	function createSeedUserA() {
		$users = [];
		for ($i=1; $i <= 100 ; $i++) {
			$users[] = User::create([
				'name' => "a$i a$i",
				'firstname' => "a$i",
				'lastname' => "a$i",
				'email' => "a$i@nu.ac.th",
				'password' => bcrypt("123456"),
				'type' => "student",
				'school_id' => "1",
			]);
		}

		return response()->json(['result' => 'success', 'users' => $users]);
	}

	function createSeedUserB() {
		$users = [];
		for ($i=1; $i <= 100 ; $i++) {
			$users[] = User::create([
				'name' => "b$i b$i",
				'firstname' => "b$i",
				'lastname' => "b$i",
				'email' => "b$i@nu.ac.th",
				'password' => bcrypt("123456"),
				'type' => "student",
				'school_id' => "1",
			]);
		}

		return response()->json(['result' => 'success', 'users' => $users]);
	}

	public function createSueUser() {
		$data = [];
		$data[] = ["p3st1","ด.ญ.อัครมณี (เปย)"];
		$data[] = ["p3st2","ด.ญ.ชนกนันท์ (ฝ้าย)"];
		$data[] = ["p3st3","ด.ญ.นันทชา (น้ำริน)"];
		$data[] = ["p3st4","ด.ญ.เกวลีน (แตงโม)"];
		$data[] = ["p3st5","ด.ช.นที (ฟลุ๊ค)"];
		$data[] = ["p3st6","ด.ญ.รุ่งรัตน์ (ใบตอง)"];
		$data[] = ["p3st7","ด.ญ.พรศักดิ์ (เพลิน)"];
		$data[] = ["p3st8","ด.ช.ณัฐภัทร (เติ้ล)"];
		$data[] = ["p3st9","ด.ญ.ปัทมพร (นุ่น)"];
		$data[] = ["p3st10","ด.ญ.วิชาพร (เอย)"];
		$data[] = ["p3st11","ด.ญ.มีนา (มีน)"];
		$data[] = ["p3st12","ด.ญ.ลลิตา (เดียร์)"];
		$data[] = ["p3st13","ด.ญ.ปิญดา (ลูกปลา)"];
		$data[] = ["p3st14","ด.ช.อิทธิพล"];
		$data[] = ["p3st15","ด.ช.เสกสรรค์ (พุฒ) ตี๋"];
		$data[] = ["p4st1","ด.ญ.รสสุคน (พลอย)"];
		$data[] = ["p4st2","ด.ช.ปัณณวัฒน์ (มาร์ค)"];
		$data[] = ["p4st3","ด.ญ.อินทกานต์ (หยก)"];
		$data[] = ["p4st4","ด.ญ.นิชาภรณ์ (บิว)"];
		$data[] = ["p4st5","ด.ช.ณภัทร (โอ๋)"];
		$data[] = ["p4st6","ด.ช.วีระพงษ์ (ท๊อป)"];
		$data[] = ["p4st7","ด.ญ.วรรญารักษ์ (อาย)"];
		$data[] = ["p4st8","ด.ญ.กัณฑิตา (กัน)"];
		$data[] = ["p4st9","ด.ญ.ภิญญดา (แอม)"];
		$data[] = ["p4st10","ด.ญ.มาเรียเรนาเก (นาเดียร์) "];
		$data[] = ["p4st11","ด.ช.ไพรัช (ปาย)"];
		$data[] = ["p4st12","ด.ช.พนัส (โดนัท)"];
		$data[] = ["p4st13","ด.ช.ยุทธภูมิ (โอ)"];
		$data[] = ["p4st14","ด.ญ.กชกร (ไกด์)"];
		$data[] = ["p4st15","ด.ช.ศุภากร (แนน)"];
		$data[] = ["p4st16","ด.ช.อลงกต (ดาม)"];
		$data[] = ["p4st17","ด.ญ.พิมลพรรณ (พั้นช์)"];
		$data[] = ["p4st18","ด.ญ.เขมจิรา (เข็ม) "];
		$data[] = ["p4st19","ด.ช.สุรวุฒิ (เต้)"];
		$data[] = ["p4st20","ด.ญ.พัณณิตา (เฟชร) "];
		$data[] = ["p4st21","ไผ่ (เด็กใหม่)"];

		$users = [];
		for ($i=0; $i < count($data) ; $i++) {
			$thisdata = $data[$i];
			$users[] = User::create([
				'name' => $thisdata[1],
				'firstname' => $thisdata[1],
				'lastname' => " ",
				'email' => $thisdata[0]."@email.com",
				'password' => bcrypt("123456"),
				'type' => "student",
				'school_id' => "1",
			]);
		}

		return response()->json([
			'result' => 'success',
			'data' => $data,
			'user' => $users
		]);
	}

}
