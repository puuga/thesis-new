@extends('app')

@section('content')
<div class="container">

	<div class="row">
		<h1>{{ $content->name}}</h1>
	</div>

	<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default">
			    <div class="panel-body">

						<dl class="dl-horizontal">
						  <dt>Content name</dt>
						  <dd>{{ $content->name }}</dd>
						</dl>

						<dl class="dl-horizontal">
						  <dt>Description</dt>
						  <dd>{{ $content->description }}</dd>
						</dl>

						<dl class="dl-horizontal">
						  <dt>Category</dt>
						  <dd>{{ $content->category->name }}</dd>
						</dl>

						<dl class="dl-horizontal">
						  <dt>Level</dt>
						  <dd>{{ $content->level }}</dd>
						</dl>

					</div>
				</div>

				<div class="text-center">
					<a class="btn btn-primary btn-lg" href="{{ route('play',$content->id) }}" role="button">
						<span class="glyphicon glyphicon-play" aria-hidden="true"></span> Learn
					</a>
				</div>

			</div>

			<div class="col-sm-6">
				<div class="panel panel-default">
			    <div class="panel-body">

						<dl>
						  <dt>Placeholder Image</dt>
						  <dd>
								@if ( is_null($content->image_entry_id) )
									<img src="{{ asset('/images/placeholder.svg') }}"
									class="img-responsive img-rounded"
									alt="placeholder image">
								@else
									<img src="{{ route('getimagebyid', $content->image_entry_id) }}"
									class="img-responsive img-rounded"
									alt="placeholder image">
								@endif
							</dd>
						</dl>

					</div>
				</div>
			</div>
	</div>

</div>
@endsection
