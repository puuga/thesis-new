<?php namespace App\Http\Controllers;

use App\Message;
use App\MessageComment;
use Illuminate\Http\Request;

class HelloController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function hello()
	{
		// return view('welcome');
		return view('hello.hello');
	}

	public function helloWithId($id) {
		return view('hello.hello',['id'=>$id]);
	}

	public function helloWithName($name) {
		return view('hello.hello',['name'=>$name]);
	}

	public function messages()
	{
		// return view('welcome');
		$messages = Message::all();

		return view('hello.messages',['messages'=>$messages]);
	}

	public function messageWithId($id)
	{
		// return view('welcome');
		$message = Message::find($id);

		return view('hello.messages',['message'=>$message]);
	}

	public function messageCreate(Request $request) {
		$message = new Message;
		$message->message = $request->input('message');
		$message->save();

		return $this->messages();
	}

	public function getMessages() {

		return Message::all();
	}

	public function getMessage($id) {

		$message = Message::find($id);

		return Message::find($id)->toJson();
	}

	public function commentCreate(Request $request, $id) {
		$comment = new MessageComment;
		$comment->comment = $request->input('comment');

		$message = Message::find($id);

		$comment = $message->comments()->save($comment);

		return redirect()->route('messageId', $id);

	}

}
