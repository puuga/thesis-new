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
    <!--<p>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th>id</th>
            <th>user</th>
            <?php
              $activity_count=count($histories[0]->content->activities);
              for ($i=0; $i < $activity_count; $i++) {
                $activity_id_arr[] = $histories[0]->content->activities[$i]->id;
              }
							$new_results = array();
            ?>
            @for ($i = 0; $i < $activity_count; $i++)
              <th>id / yes-no / time</th>
            @endfor
            <th>Score</th>
            <th>Total time</th>
          </tr>
        </thead>
        <tbody>
          <?php
						$sum_time=0;
					?>
          @foreach ($histories as $history)
          <tr>
            <td>{{ $history->id }}</td>
            <td>{{ $history->user->id }}, {{ $history->user->name }}</td>
            <?php
							$arr["history_id"] = $history->id;
							$arr["user_id"] = $history->user->id;
							$arr["user_name"] = $history->user->name;
              $time=0;
              $score = 0;
            ?>
            @for ($i = 0; $i < count($history->activity_order_arr); $i++)
              <td>
                <?php
                $key = $history->activity_order_arr[$i];
                $timediff = isset($history->timediff_arr[$i]) ? $history->timediff_arr[$i] : 0;
                $answer = "";
                if ($timediff==0) {
                  $answer = "null";
                } elseif (isset($history->answer_arr[$i]) && $history->answer_arr[$i]==true) {
                  $answer = "correct";
                  $score++;
                } else {
                  $answer = "incorrect";
                }
                ?>
                {{ $key }}<br/>
                {{ $answer }}<br/>
                {{ $timediff."s" }}
                <?php
								$arr["answer_".$key] = $answer;
								$arr["timediff_".$key] = $timediff;

                $time += $timediff;
                if ( !isset($sum_results[$key]["time"]) ) {
                  $sum_results[$key]["time"] = 0;
                }
                if ( !isset($sum_results[$key]["answer_yes_counter"]) ) {
                  $sum_results[$key]["answer_yes_counter"] = 0;
                }
                if ( !isset($sum_results[$key]["answer_no_counter"]) ) {
                  $sum_results[$key]["answer_no_counter"] = 0;
                }
                if ( !isset($sum_results[$key]["counter"]) ) {
                  $sum_results[$key]["counter"] = 0;
                }
                $sum_results[$key]["time"] += $timediff;
                if ($answer==="correct" && $timediff!=0) {
                  $sum_results[$key]["answer_yes_counter"]++;
                } else if ($answer==="incorrect" && $timediff!=0) {
                  $sum_results[$key]["answer_no_counter"]++;
                }
                if ($timediff!=0) {
                  $sum_results[$key]["counter"]++;
                }
                ?>
              </td>
            @endfor
            <td>{{ $score }}</td>
            <td>
              <?php
							$sum_time += $time;

							$arr["score"] = $score;
							$arr["time"] = $time;
							$new_results[] = $arr;

							?>
              {{ $time."s" }}
            </td>
          </tr>
          @endforeach
        </tbody>

      </table>
    </p>-->
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

</div>

@endsection
