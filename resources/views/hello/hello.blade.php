@extends('hello.hello_template')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<h1>Hello</h1>

			<div class="">
        @if (isset($id))
          Your ID is: {{ $id }}
        @else
					Hello ?
        @endif
			</div>
		</div>
	</div>
</div>
@endsection
