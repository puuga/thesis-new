@extends('app')

@section('headExtend')


</script>
@endsection

@section('content')

<div class="container">

	<div class="row">

    {{-- <p>
      {{ print_r($histories) }}
    </p> --}}

    <h1>CSV ({{ count($histories) }})</h1>
		<p>
			@RELATION content{{ $content->id }}
		</p>
    <p>
			@attribute history_id NUMERIC<br/>
			@attribute user_id NUMERIC<br/>
			@attribute user_name STRING<br/>

			@for ($i = 0; $i < count($content->activities); $i++)
				@attribute activity_answer_{{ $i+1 }} {0,1}<br/>
				@attribute activity_time_{{ $i+1 }} NUMERIC<br/>

			@endfor

      @attribute score NUMERIC<br/>
      @attribute total_time NUMERIC<br/>
    </p>
		<p>
			@data
		</p>

		<?php
			$new_results = Helper::arffContent($content, $histories, $frequencies);
		?>
		<p>
			@foreach($new_results as $new_result)
				@for($i=1; $i <= count($content->activities); $i++)
					@if($new_result["answer_".$i]=="null")
						<?php
						$conti=true;
						break;
						?>
					@endif
					<?php $conti=false ?>
				@endfor
				@if($conti==true)
					<?php continue;?>
				@endif

				{{ $new_result["history_id"] }},
				{{ $new_result["user_id"] }},
				{{ str_replace(" ", "_", $new_result["user_name"]) }},
				@for($i=1; $i <= count($content->activities); $i++)
					{{ $new_result["answer_".$i]=="correct" ? 1 : 0 }},
					{{ $new_result["timediff_".$i] }},
				@endfor
				{{ $new_result["score"] }},
				{{ $new_result["time"] }}<br/>
			@endforeach
		</p>

	</div>

	<div class="row">
		<h1>CSV ({{ count($histories) }}) with inter-activity count</h1>
		<p>
			@RELATION content{{ $content->id }}
		</p>
    <p>
			@attribute history_id NUMERIC<br/>
			@attribute user_id NUMERIC<br/>
			@attribute user_name STRING<br/>

			@for ($i = 0; $i < count($content->activities); $i++)
				@attribute activity_answer_{{ $i+1 }} {0,1}<br/>
				@attribute activity_time_{{ $i+1 }} NUMERIC<br/>
				@attribute interactivity_count_{{ $i+1 }} NUMERIC<br/>

			@endfor

      @attribute score NUMERIC<br/>
      @attribute total_time NUMERIC<br/>
    </p>
		<p>
			@data
		</p>
		<p>
			@foreach($new_results as $new_result)
				@for($i=1; $i <= count($content->activities); $i++)
					@if($new_result["answer_".$i]=="null")
						<?php
						$conti=true;
						break;
						?>
					@endif
					<?php $conti=false ?>
				@endfor
				@if($conti==true)
					<?php continue;?>
				@endif

				{{ $new_result["history_id"] }},
				{{ $new_result["user_id"] }},
				{{ str_replace(" ", "_", $new_result["user_name"]) }},
				@for($i=1; $i <= count($content->activities); $i++)
					{{ $new_result["answer_".$i]=="correct" ? 1 : 0 }},
					{{ $new_result["timediff_".$i] }},
					{{ $new_result["interactivity_count".$i] }},
				@endfor
				{{ $new_result["score"] }},
				{{ $new_result["time"] }}<br/>
			@endforeach
		</p>
	</div>

</div>

@endsection
