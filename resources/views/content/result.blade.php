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
				$act = $history->content->activities[$activity_arr[$i]-1];
			?>
	    <p>
				activity_id: {{ $act->id }}<br/>
				title: {{ $act->title }}<br/>
				content: {{ $act->content }}<br/>
				@if ( isset($answers[$i]) && $act->id === $answers[$i]->activity_id)
			    answer: {{ $answers[$i]->detail }}
					@if ( $act->activity_type_id === "1" )
						@if( $act->content===str_replace(",","",$answers[$i]->detail) )
							+1
							<?php $score++; ?>
						@endif
					@elseif ( $act->activity_type_id === "2" )
						<?php
							$correctAnswer = DB::table('interactivities')
																->where('activity_id',$act->id)
																->where('history_id',$history->id)
																->where('action','answer_correct')
																->first();
						?>

						@if( Helper::deepCompare(json_decode($answers[$i]->detail),json_decode($correctAnswer->detail)) )
							<br/>answer: {{ $correctAnswer->detail }} --> c_answer<br/>
							+1
							<?php $score++; ?>
						@endif
					@elseif ( $act->activity_type_id === "5" )
						@if( $act->extra2===$answers[$i]->detail )
							+1
							<?php $score++; ?>
						@endif
					@elseif ( $act->activity_type_id === "6" )
						@if( $act->extra2===$answers[$i]->detail )
							+1
							<?php $score++; ?>
						@endif
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
