@extends('app')

@section('content')

<?php
function getColor($percent) {
	return $percent>=0.8 ? 'text-success' : ($percent>=0.4 ? 'text-info' : 'text-mute');
}
?>

<div class="container">

	<div class="row">

		<h1>Result</h1>

		<?php
			$activity_arr = explode(",",$history->activity_order);
			$score = 0;

			for ( $i=0; $i<count($activity_arr) ; $i++ ) {
				if ( !isset($history->content->activities[$activity_arr[$i]-1]) ) {
					continue;
				}
				$act = $history->content->activities[$activity_arr[$i]-1];
				if ( isset($answers[$i]) && $act->id === $answers[$i]->activity_id ) {
					if ( Helper::isCorrectAnswer($history, $act, $answers[$i]) ) {
						$score++;
					}
				}
			}
			$percent = $score/count($activity_arr);
		?>

		{{-- <p>
			{{ print_r($activity_arr) }}
		</p>
		<p>
			{{ print_r($answers) }}
		</p> --}}

		<p class="text-center">
			@if ( $percent >= 0.8 )
				Very Good!
			@else
				May the force be with you!
			@endif
		</p>

		{{-- if score is more than 80% star will green --}}
		{{-- if score is more than 40% star will blue --}}
		{{-- if not star will gray --}}
		<p class="text-center">
			<h1 class="text-center">
				@for ( $i = 1; $i <= count($activity_arr); $i++ )
					@if ( $i <= $score )
						<i class="mdi-action-stars
						{{ getColor($percent) }}"
						style="font-size: 75px;"></i>
					@else
						<i class="mdi-action-star-rate
						{{ getColor($percent) }}"
						style="font-size: 75px;"></i>
					@endif
				@endfor
				<br/>
				{{ $score }} / {{ count($activity_arr) }}
			</h1>
		</p>

	</div>

	<br/>
	<br/>

	<div class="row">
		<p class="text-center">
			<a class="btn btn-default" href="{{ route('contentById', $history->content->id) }}">
				<span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Redo
			</a>
			<a class="btn btn-primary" href="{{ url('store') }}">
				<span class="glyphicon glyphicon-send" aria-hidden="true"></span> Finish
			</a>
		</p>
	</div>

</div>

@endsection
