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
      @if (count($year_count) > 0)
        <div id='calendar_div' style='width: 800; height: {{count($year_count)*200}}px'></div>
      @else
        I don't have any records!
      @endif
		</div>

		<h1>history count: {{ count($histories) }}</h1>

    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th>Content name</th>
          <th>At</th>
          <th>Score</th>
        </tr>
      </thead>

      <tbody>

        @foreach ($histories as $history)
    	    {{-- <p>
    				id {{ $history->id }}<br/>
    				content_id {{ $history->content->id }}<br/>
    				activity_order {{ $history->activity_order }}<br/>
    				at {{ $history->created_at }}<br/>
    				<a href="{{ route('scoreByHistory',$history->id) }}">score</a><br/>
    			</p> --}}
          <tr>
            <td>{{ $history->content->name }}</td>
            <td>{{ $history->created_at }}</td>
            <td><a href="{{ route('scoreByHistory',$history->id) }}">score</a></td>
          </tr>
    		@endforeach

      </tbody>

    </table>

	</div>

</div>

<br/>
<br/>

@endsection
