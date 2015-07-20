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

	</div>

</div>

@endsection
