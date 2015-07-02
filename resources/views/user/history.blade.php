@extends('app')

@section('content')

<div class="container">

	<div class="row">

		<h1>history count: {{ count($histories) }}</h1>

		@foreach ($histories as $history)
	    <p>
				id {{ $history->id }}<br/>
				content_id {{ $history->content->id }}<br/>
				activity_order {{ $history->activity_order }}<br/>
				at {{ $history->created_at }}<br/>
				<a href="{{ route('scoreByHistory',$history->id) }}">score</a><br/>
			</p>
		@endforeach

	</div>

</div>

@endsection
