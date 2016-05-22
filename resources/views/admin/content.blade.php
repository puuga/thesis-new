@extends('app')

@section('content')

<div class="container">

	<div class="row">

		<h1>
			All Lessons {{ count($contents) }}
		</h1>

		<table class="table table-striped table-bordered table-hover" id="myTable">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Owner</th>
					<th>progression</th>
					<th>is published</th>
					<th>Access</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($contents as $content)
				<tr>
					<td>{{ $content->id }}</td>
					<td>{{ $content->name }}</td>
					<td>
						{{ $content->user->name }},
						{{ $content->user->school->name }}
					</td>
					<td>{{ $content->is_inprogress==="1"?"inprogress":"done" }}</td>
					<td>{{ $content->is_public==="1"?"Yes":"No" }}</td>
					<td>
						{{ $content->count }}
						<a href="{{ route('monitorCSV',[$content->id]) }}">CSV</a>
					</td>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>

	</div>

</div>

@endsection
