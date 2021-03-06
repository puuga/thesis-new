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
		title: "Frequency Access Chart",
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
      style='width: 800; height: {{ isset($year_count[0]->year_count)?count($year_count)*200:200}}px'></div>
		</div>

    {{-- <p>
      {{ print_r($histories) }}
    </p> --}}

    <h1>Access Log ({{ count($histories) }})</h1>

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
              <th>content_id<br/>result<br/>time</th>
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
              <?php
              $key = $history->activity_order_arr[$i];
              if (count($content->activities)>$key) {
                // continue;
              }
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
              <td>
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
          if ( !isset($sum_results[$i]) ) {
            // $total_complete = 0;
            // $total_correct = 0;
            // $total_incorrect = 0;
            $sum_results[$i]["counter"] = 0;
          } else {
            $total_complete += count($histories)!=0 ? $sum_results[$i]["counter"]/count($histories)*100 : 0;
            $total_correct += $sum_results[$i]["counter"]!=0 ? $sum_results[$i]["answer_yes_counter"]/$sum_results[$i]["counter"]*100 : 0;
            $total_incorrect += $sum_results[$i]["counter"]!=0 ? $sum_results[$i]["answer_no_counter"]/$sum_results[$i]["counter"]*100 : 0;
          }
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
            {{-- <td>{{ $sum_avg_time/$activity_count }}</td> --}}
            <td>-</td>
          </tr>
        </tfoot>
      </table>
    </p>

	</div>

  <div class="row">
    <div class="col-lg-12">
      <h3>Extra</h3>
      <a class="btn btn-primary btn-flat" href="{{ route('monitorCSV',[$content_id]) }}">
        raw arff
      </a>

      <a class="btn btn-primary btn-flat" href="javascript:makeArffFile({{$content_id}},1)">
        get arff file (1: time and result)
      </a>

      <a class="btn btn-primary btn-flat" href="javascript:makeArffFile({{$content_id}},2)">
        get arff file (2 tile, result and interactivity count)
      </a>
    </div>

  </div>

  <script type="text/javascript">
    function makeArffFile(id, type) {
      var url = "";
      if (type===1) {
        url = "{{ route('createArffFile1',[$content_id]) }}";
      } else if (type===2) {
        url = "{{ route('createArffFile2',[$content_id]) }}";
      }

      var jqxhr = $.ajax({
        method: "GET",
        url: url
      })
      .done(function(data) {
        // alert( "success" );
        console.log(data);

        if (data.result===false) {
          return;
        }

        window.location = data.url;
      })
      .fail(function() {
        alert( "error" );
      });
    }
  </script>

  <br/>
  <br/>

</div>

<script type="text/javascript">
$('tr[data-href]').on("click", function() {
  document.location = $(this).data('href');
});
$('tr[data-href]').css('cursor', 'pointer');
</script>

@endsection
