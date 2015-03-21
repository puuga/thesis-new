@extends('hello.hello_template')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<h1>Hello</h1>

			<div class="">
				@if ( isset($message) )
					messages is: {{ $message->message }}
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
