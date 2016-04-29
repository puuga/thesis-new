@extends('app')

@section('content')

<div class="container">

	<div class="row">

		<h1>history id: {{ $history->id }}</h1>

		<?php
			$activity_arr = explode(",",$history->activity_order);
			$score = 0;
		?>
		<p>
			{{ print_r($activity_arr) }}
		</p>
		<p>
			{{ print_r($answers) }}
		</p>

		@for ( $i = 0; $i < count($activity_arr); $i++ )
			<?php
				if (array_key_exists($activity_arr[$i]-1,$history->content->activities)) {
					$act = $history->content->activities[$activity_arr[$i]-1];
				} else {
					continue;
				}
			?>
	    <p>
				activity_id: {{ $act->id }}<br/>
				title: {{ $act->title }}<br/>
				content: {{ $act->content }}<br/>
				@if ( isset($answers[$i]) && $act->id === $answers[$i]->activity_id)
			    answer: {{ $answers[$i]->detail }}<br>
					is correct?:
					@if( Helper::isCorrectAnswer($history, $act, $answers[$i]) )
						+1
						<?php $score++; ?>
					@else
						+0
					@endif
					<br>
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
