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

	<div class="row">
		<h1>Interactivitis</h1>
		<ul>
		@foreach($history->interactivities as $interactivity)
			<li>
				{{ $interactivity->sequence_number }}
				{{ $interactivity->id }}
				{{ $interactivity->action_at }}
				<?php
				if ( !isset($lTime) ) {
					$lTime = strtotime($interactivity->action_at);
					$cTime = $lTime;
					$dTime = 0;
				} else {
					$lTime = $cTime;
					$cTime = strtotime($interactivity->action_at);
					$dTime = $cTime - $lTime;
				}
				?>
				+{{ $dTime }}
				<span class="{{ strpos($interactivity->action, 'start activity')!== false ? "badge" : "" }}">{{ $interactivity->action }}</span>
				{{ $interactivity->detail }}
			</li>
		@endforeach
		</ul>
	</div>

</div>

@endsection
