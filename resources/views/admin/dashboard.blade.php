@extends('app')

@section('content')

<div class="container">

	<div class="row">

		<h1>All Schools <span class="label label-info">{{ count($schools) }}</span></h1>

		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Address</th>
					<th>Tumbul</th>
					<th>District</th>
					<th>Province</th>
					<th>State</th>
					<th>Zone</th>
					<th>Country</th>
					<th>Region</th>
					<th>Zip</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($schools as $school)
				<tr>
					<td>{{ $school->id }}</td>
					<td>{{ $school->name }}</td>
					<td>{{ $school->address }}</td>
					<td>{{ $school->tumbul }}</td>
					<td>{{ $school->district }}</td>
					<td>{{ $school->province }}</td>
					<td>{{ $school->state }}</td>
					<td>{{ $school->zone }}</td>
					<td>{{ $school->country }}</td>
					<td>{{ $school->region }}</td>
					<td>{{ $school->zip }}</td>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>

	</div>

</div>

<script type="text/javascript">
	function switchPermission(id) {
		$.ajax({
		  url: "user/switchpermission/"+id,
		  cache: false
		})
	  .done(function( result ) {
			if (result.result==='success') {
				$("#type"+id).html(result.user.type);
			}
	  })
		.fail(function() {
	    alert( "error" );
	  });
	}

	function grantAdmin(id) {
		$.ajax({
		  url: "user/grantadmin/"+id,
		  cache: false
		})
	  .done(function( result ) {
			if (result.result==='success') {
				var text = result.user.is_admin=== "1" ? "Yes" : "No"
				$("#admin"+id).html(text);
			}
	  })
		.fail(function() {
	    alert( "error" );
	  });
	}
</script>

@endsection
