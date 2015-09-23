@extends('app')

@section('content')

<div class="container">

	<div class="row">

		<h1>All Users <span class="label label-info">{{ count($users) }}</span></h1>

		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Firstname</th>
					<th>Lastname</th>
					<th>Email</th>
					<th>School</th>
					<th>Type [ Teacher || Student ]</th>
					<th>Admin [ Yes || No ]</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($users as $user)
				<tr>
					<td>{{ $user->id }}</td>
					<td>{{ $user->firstname }}</td>
					<td>{{ $user->lastname }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->school->name }}</td>
					<td>
						<a class="btn btn-default btn-sm" href="javascript:switchPermission({{ $user->id }})" role="button">
							<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
						</a>
						<span id="type{{ $user->id }}">{{ $user->type }}</span>
					</td>
					<td>
						<a class="btn btn-default btn-sm" href="javascript:grantAdmin({{ $user->id }})" role="button">
							<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
						</a>
						<span id="admin{{ $user->id }}">
							{{ $user->is_admin === '1' ? 'Yes' : 'No' }}
						</span>
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
