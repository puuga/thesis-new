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

    <h1>Time by user</h1>
    <p>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
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
            <th>Total time</th>
          </tr>
        </thead>
        <tbody>
          <?php $sum_time=0; ?>
          @foreach ($histories as $history)
          <tr>
            <td>{{ $history->user->id }}, {{ $history->user->name }}</td>
            <?php $time=0; ?>
            @for ($i = 0; $i < count($history->activity_order_arr); $i++)
              <td>
                <?php
                $key = $history->activity_order_arr[$i];
                $timediff = isset($history->timediff_arr[$i]) ? $history->timediff_arr[$i] : 0;
                $answer = !isset($history->answer_arr[$i]) ? "null" : $history->answer_arr[$i] ? "yes" : "no";
                ?>
                {{ $key }}
                {{ $answer }}
                {{ $timediff."s" }}
                <?php
                $time += $timediff;
                if ( !isset($sum_results[$key]["time"]) ) {
                  $sum_results[$key]["time"] = 0;
                }
                if ( !isset($sum_results[$key]["answer"]) ) {
                  $sum_results[$key]["answer"] = 0;
                }
                $sum_results[$key]["time"] += $timediff;
                $sum_results[$key]["answer"] += $answer==="yes"?1:0;
                echo $answer==="yes"?1:0;
                ?>
              </td>
            @endfor
            <td>
              <?php $sum_time += $time; ?>
              {{ $time."s" }}
            </td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr class="success">
            <td colspan="{{ $activity_count+1 }}">Average time</td>
            <td>
              {{ $sum_time/count($histories) }}
            </td>
          </tr>
          <tr class="info">
            <td>statistic</td>
            @for ($i = 1; $i <= $activity_count; $i++)
            <td>
              {{ $i }}
              {{ $sum_results[$i]["answer"]/count($histories)."%" }}
              {{ $sum_results[$i]["time"]/count($histories)."s" }}
            </td>
            @endfor
          </tr>
        </tfoot>
      </table>
    </p>

		<h1>history count: {{ count($histories) }}</h1>

		@foreach ($histories as $history)
	    <p>
				id {{ $history->id }}<br/>
				content_id {{ $history->content->id }}<br/>
				activity_order {{ $history->activity_order }}<br/>
				at {{ $history->created_at }}<br/>
				by user_id {{ $history->user->id }}, {{ $history->user->name }} <br/>
				<a href="{{ route('monitorDetailByHistory',[$history->content_id,$history->id]) }}">Fine Detail</a><br/>
			</p>
		@endforeach

	</div>

</div>

@endsection
