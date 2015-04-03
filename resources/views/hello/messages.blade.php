@extends('hello.hello_template')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<h1>Hello</h1>
			<p>
				<a href="{{ route('newMessageForm') }}" class="btn btn-success">add message</a>
			</p>

			<div class="">
				@if ( isset($message) )
					messages is: {{ $message->message }} <br/>
					comments: {{ count($message->comments) }}
					@if ( count($message->comments)!=0 )
						@foreach ($message->comments as $comment)
							<li>
								{{ $comment->comment }}
							</li>
						@endforeach
					@endif
					<form class="form-inline" action="{{ route('newComment',$message->id) }}" method="post">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="sr-only" for="comment">Comment</label>
							<input type="text" class="form-control" id="comment" name="comment" placeholder="Comment">
						</div>
						<button type="submit" class="btn btn-primary">Comment</button>

					</form>
				@elseif ( isset($messages) )
					@if ( count($messages)!=0 )
						there are {{ count($messages) }} messages.
						@foreach ($messages as $message)
							<li>
								{{ $message->message }}
								<a href="{{ route('messageId', $message->id) }}" class="btn btn-primary">{{ $message->message }}</a>
							</li>
						@endforeach
					@else
						<p>there is no any message.</p>
					@endif
				@endif

			</div>
		</div>
	</div>
</div>
@endsection
