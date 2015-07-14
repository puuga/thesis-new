@extends('app')

@section('content')

<div class="container">

	<div class="jumbotron">
    <h1>DashBoard</h1>
    <p>information.</p>
    <p><a class="btn btn-primary btn-lg">Learn more</a></p>
	</div>

	<div class="row">

		<div class="col-xs-12 col-sm-6 col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Schools
				</div>
		    <div class="panel-body">
	        {{ count($schools) }}
		    </div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-6 col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Users
				</div>
		    <div class="panel-body">
	        {{ count($users) }}
		    </div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-6 col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Categories
				</div>
		    <div class="panel-body">
	        {{ count($categories) }}
		    </div>
			</div>
		</div>

	</div>

</div>

@endsection
