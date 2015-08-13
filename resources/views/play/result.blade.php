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
				$act = $history->content->activities[$activity_arr[$i]-1];
				if ( isset($answers[$i]) && $act->id === $answers[$i]->activity_id ) {
					switch ( $act->activity_type_id ) {
						case '1':
							if ( $act->content===str_replace(",","",$answers[$i]->detail )) {
								$score++;
							}
							break;
						case '2':
							$correctAnswer = DB::table('interactivities')
																->where('activity_id',$act->id)
																->where('history_id',$history->id)
																->where('action','answer_correct')
																->first();
							if ( $correctAnswer->detail === $answers[$i]->detail ) {
								$score++;
							}
							break;
						case '5':
							if ( $act->extra2===$answers[$i]->detail ) {
								$score++;
							}
							break;
						case '6':
							if ( $act->extra2===$answers[$i]->detail ) {
								$score++;
							}
							break;

						default:
							# code...
							break;
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
				very Good!
			@else
				may the force be with you!
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

</div>

@endsection
