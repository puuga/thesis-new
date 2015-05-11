@extends('app')

@section('content')
<?php
	function cardContent($content) {
		?>
		<div class="col-md-3">
			<div class="panel panel-info">

				<div class="panel-heading">
					<h3 class="panel-title">
						<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> {{ $content->name}}
					</h3>
				</div>

				<div class="panel-body">
					@if ( $content->placeholder === "" )
						<img src="{{ asset('/images/placeholder.svg') }}" class="img-responsive img-rounded" alt="placeholder image">
					@else
						underconstruction!
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
		<?php
	}
?>
<div class="container">

	@if ( Input::has('keysearch') )
		@if ( count($contents) === 0 )
			<h1>No Results for "{{ Input::get('keysearch') }}"</h1>
		@else
			<div class="row">
				<h1>Results with "{{ Input::get('keysearch') }}"</h1>

				@foreach ($contents as $content)

					<?php
						cardContent($content);
					?>

				@endforeach

			</div>
		@endif

	@else
		<div class="row">
			<h1>Top Charts</h1>

			@foreach ($popContents as $content)

				<?php
					cardContent($content);
				?>

			@endforeach

		</div>

		<div class="row">
			<h1>New Releases</h1>

			@foreach ($newContents as $content)

				<?php
					cardContent($content);
				?>

			@endforeach

		</div>

	@endif


</div>
@endsection
