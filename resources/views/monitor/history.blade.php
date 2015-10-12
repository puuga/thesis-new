@extends('app')

@section('headExtend')
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['annotationchart']}]}"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load("visualization", "1.1", {packages:["calendar"]});
  google.setOnLoadCallback(drawChart);

	function drawChart() {
		var dataTable = new google.visualization.DataTable();
		dataTable.addColumn({ type: 'date', id: 'Date' });
		dataTable.addColumn({ type: 'number', id: 'Access' });
		dataTable.addRows([
			@foreach ($frequencies as $frequency)
			  [ new Date({{$frequency->year_ac}},
					{{$frequency->month_ac-1}},
					{{$frequency->day_ac}}),
					{{$frequency->count}}
				],
			@endforeach
		]);

		var chart = new google.visualization.Calendar(document.getElementById('calendar_div'));

		var options = {
		title: "Access frequency",
		};

		chart.draw(dataTable, options);
	}

</script>
@endsection

@section('content')

<div class="container">

	<div class="row">

		<div class="jumbotron">
			<div id='calendar_div'
      style='width: 800; height: {{ isset($year_count[0]->year_count)?$year_count[0]->year_count*200:200}}px'></div>
		</div>

    {{-- <p>
      {{ print_r($histories) }}
    </p> --}}

    <h1>User Analytic ({{ count($histories) }})</h1>
    <p>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th>id</th>
            <th>at</th>
            <th>user</th>
            <?php
              $activity_count=count($histories[0]->content->activities);
              for ($i=0; $i < $activity_count; $i++) {
                $activity_id_arr[] = $histories[0]->content->activities[$i]->id;
              }
            ?>
            @for ($i = 0; $i < $activity_count; $i++)
              <th>id / yes-no / time</th>
            @endfor
            <th>Score</th>
            <th>Total time</th>
          </tr>
        </thead>
        <tbody>
          <?php $sum_time=0; ?>
          @foreach ($histories as $history)
          <tr data-href="{{ route('monitorDetailByHistory',[$history->content_id,$history->id]) }}">
            <td>{{ $history->id }}</td>
            <td>{{ $history->created_at }}</td>
            <td>{{ $history->user->id }}, {{ $history->user->name }}</td>
            <?php
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
              <?php $sum_time += $time; ?>
              {{ $time."s" }}
            </td>
          </tr>
          @endforeach
        </tbody>

      </table>
    </p>

    <h1>Statistic</h1>
    <p>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th>Activity id</th>
            <th>Complete (%)</th>
            <th>Correct Answer (%)</th>
            <th>Incorrect Answer (%)</th>
            <th>Average Time (s)</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $sum_avg_time = 0;

            $total_complete = 0;
            $total_correct = 0;
            $total_incorrect = 0;
          ?>
          @for ($i = 1; $i <= $activity_count; $i++)
          <?php
            $total_complete += count($histories)!=0 ? $sum_results[$i]["counter"]/count($histories)*100 : 0;
            $total_correct += $sum_results[$i]["counter"]!=0 ? $sum_results[$i]["answer_yes_counter"]/$sum_results[$i]["counter"]*100 : 0;
            $total_incorrect += $sum_results[$i]["counter"]!=0 ? $sum_results[$i]["answer_no_counter"]/$sum_results[$i]["counter"]*100 : 0;
          ?>
          <tr>
            <td>{{ $i }}</td>
            <td>
              {{ $sum_results[$i]["counter"] }} / {{ count($histories) }}
              = {{ $sum_results[$i]["counter"]/count($histories)*100 }}
            </td>
            <td>{{ $sum_results[$i]["counter"]!=0 ? $sum_results[$i]["answer_yes_counter"]/$sum_results[$i]["counter"]*100 : 0}}</td>
            <td>{{ $sum_results[$i]["counter"]!=0 ? $sum_results[$i]["answer_no_counter"]/$sum_results[$i]["counter"]*100 : 0}}</td>
            <?php $sum_avg_time_i = $sum_results[$i]["counter"]!=0 ? $sum_results[$i]["time"]/$sum_results[$i]["counter"] : 0; ?>
            <?php $sum_avg_time += $sum_avg_time_i; ?>
            <td>{{ $sum_avg_time_i }}</td>
          </tr>
          @endfor
        </tbody>
        <tfoot>
          <tr class="info">
            <td>Total</td>
            <td>{{ $total_complete/$activity_count }}</td>
            <td>{{ $total_correct/$activity_count }}</td>
            <td>{{ $total_incorrect/$activity_count }}</td>
            <td>{{ $sum_avg_time/$activity_count }}</td>
          </tr>
        </tfoot>
      </table>
    </p>

	</div>

</div>

<script type="text/javascript">
$('tr[data-href]').on("click", function() {
  document.location = $(this).data('href');
});
$('tr[data-href]').css('cursor', 'pointer');
</script>

@endsection
