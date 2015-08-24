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
		<h1>Interactivities</h1>
		<table class="table table-striped table-bordered table-hover">
		  <thead>
		  	<tr>
					<th>sequence number</th>
					<th>id</th>
					<th>action at</th>
					<th>diff</th>
					<th>action</th>
					<th>detail</th>
		  	</tr>
		  </thead>
			<tbody>
				@foreach($history->interactivities as $interactivity)
				<tr class="{{ strpos($interactivity->action, 'start activity')!== false ? "warning" : "" }}">
					<td>{{ $interactivity->sequence_number }}</td>
					<td>{{ $interactivity->id }}</td>
					<td>{{ $interactivity->action_at }}</td>
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
					<td>+{{ $dTime }}</td>
					<td>{{ $interactivity->action }}</td>
					<td>{{ $interactivity->detail }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>

	</div>

</div>

@endsection
