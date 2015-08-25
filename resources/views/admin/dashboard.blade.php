@extends('app')

@section('headExtend')
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load("visualization", "1.1", {packages:["bar"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Content name', 'Accesses'],
			@foreach ($top10Contents as $content)
		    ['{{ $content->name }}',{{ $content->countt }}],
			@endforeach
    ]);

    var options = {
      chart: {
        title: 'Top 10 accesses',
        subtitle: 'Top 10 all time.',
      },
      bars: 'horizontal' // Required for Material Bar Charts.
    };

    var chart = new google.charts.Bar(document.getElementById('barchart_material'));

    chart.draw(data, options);
  }
</script>
@endsection

@section('content')

<div class="container">

	<div class="jumbotron">
    <h1>DashBoard</h1>
    <p>
			<div id="barchart_material" style="width: 900px; height: 500px;"></div>
		</p>

	</div>

	<div class="row">

		<div class="col-xs-12 col-sm-6 col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Schools
				</div>
		    <div class="panel-body">
					<p>
						{{ count($schools) }}
					</p>
					<p class="text-right">
						<a href="{{ route('schoolList') }}" class="btn btn-flat btn-primary">Explore</a>
					</p>
		    </div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-6 col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Users
				</div>
		    <div class="panel-body">
					<p>
						{{ count($users) }}
					</p>
					<p class="text-right">
						<a href="{{ route('userList') }}" class="btn btn-flat btn-primary">Explore</a>
					</p>
		    </div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-6 col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Categories
				</div>
		    <div class="panel-body">
					<p>
						{{ count($categories) }}
					</p>
					<p class="text-right">
						<a href="{{ route('categoryList') }}" class="btn btn-flat btn-primary">Explore</a>
					</p>
		    </div>
			</div>
		</div>

    <div class="col-xs-12 col-sm-6 col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Published Contents / All Contents
				</div>
		    <div class="panel-body">
					<p>
						{{ count($published_contents) }} / {{ count($contents) }}<br/>
            {{ count($published_contents) / count($contents) *100 }} %
					</p>
					<p class="text-right">
						<a href="{{ route('contentList') }}" class="btn btn-flat btn-primary">Explore</a>
					</p>
		    </div>
			</div>
		</div>

	</div>

</div>

@endsection
