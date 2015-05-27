@extends('app')

@section('content')

<div class="container">

	<div class="row">

		<h1>All Categorys <span class="label label-info">{{ count($categorys) }}</span></h1>

		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($categorys as $category)
				<tr>
					<td>{{ $category->id }}</td>
					<td>{{ $category->name }}</td>
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
