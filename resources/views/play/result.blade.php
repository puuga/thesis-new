@extends('app')

@section('content')

<div class="container">

	<div class="row">

		<h1>history id: {{ $history->id }}</h1>

		<?php
			$activity_arr = explode(",",$history->activity_order);
			$score = 0;
		?>
		{{ print_r($activity_arr) }}

		@for ( $i = 0; $i < count($activity_arr); $i++ )
			<?php
				$act = $history->content->activities[$activity_arr[$i]-1];
			?>
	    <p>
				activitt_id: {{ $act->id }}<br/>
				title: {{ $act->title }}<br/>
				content: {{ $act->content }}<br/>
				@if ( $act->id === $answers[$i]->activity_id)
			    answer: {{ $answers[$i]->detail }}
					@if( $act->content===str_replace(",","",$answers[$i]->detail) )
						+1
						<?php $score++; ?>
					@endif
				@else
			    answer: not answer!
				@endif
			</p>
		@endfor
		<p>
			score: {{ $score }} / {{ count($activity_arr) }}
		</p>

	</div>

</div>

@endsection
