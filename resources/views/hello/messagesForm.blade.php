@extends('hello.hello_template')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<h1>Add Message</h1>

			<form class="" action="{{ route('newMessage') }}" method="post">
				<div class="form-group">
					<label for="message">Message</label>
					<input type="text" class="form-control" id="message" name="message" placeholder="Message">
				</div>

				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<button type="submit" class="btn btn-primary">Submit</button>
				<button type="reset" class="btn btn-default">Reset</button>

			</form>
		</div>
	</div>
</div>
@endsection
