@extends('app')

@section('content')
<div class="container">

	<div class="row">
		<h1>{{ $category->name}}</h1>
	</div>

	<div class="row">
		@foreach ($contents as $content)

			<div class="col-md-3">
				<div class="panel panel-info">

					<div class="panel-heading">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> {{ $content->name}}
						</h3>
					</div>

					<div class="panel-body">
						<p>
							<span class="label label-primary">{{ Helper::getLevelText($content->level) }}</span>
							<span class="label label-info">{{ $content->category->name }}</span>
						</p>
						@if ( is_null($content->image_entry_id) )
							<img src="{{ asset('/images/placeholder.svg') }}"
							class="img-responsive img-rounded"
							alt="placeholder image">
						@else
							<img src="{{ route('getimagebyid', $content->image_entry_id) }}"
							class="img-responsive img-rounded"
							alt="placeholder image">
						@endif

						<p>
							{{ $content->description }}
						</p>
						<div class="text-right">
							<a href="{{ route('contentById', $content->id) }}" class="btn btn-flat btn-primary">
								<span class="glyphicon glyphicon-search" aria-hidden="true"></span> Learn
							</a>
						</div>
					</div>

				</div>
			</div>

		@endforeach
	</div>

	<div class="row">
		<div class="col-md-12">
			<p>
				<?php echo $contents->render(); ?>
			</p>
		</div>
	</div>



</div>
@endsection
