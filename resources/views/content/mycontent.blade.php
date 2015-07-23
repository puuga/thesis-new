@extends('app')

@section('content')
<?php
	function cardContent($i, $content) {
		?>
		<div class="col-sm-4">
			<div class="panel panel-info">

				<div class="panel-heading">
					<h3 class="panel-title">
						{{ $i }}.
						<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
						{{ $content->name}}
						@if( $content->is_inprogress==='1' )
							<span class="label label-warning">Draft</span>
						@elseif( $content->is_inprogress==='0' )
							<span class="label label-primary">Done</span>
						@endif
					</h3>
				</div>

				<div class="panel-body">
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
						<dl>
						  <dt>Description</dt>
						  <dd>{{ $content->description }}</dd>
						</dl>

						<dl>
						  <dt>Level</dt>
						  <dd>{{ $content->level }}</dd>
						</dl>

						<dl>
						  <dt>Access</dt>
						  <dd>{{ $content->is_public == 1 ? 'Public' : 'Limit' }}</dd>
						</dl>

						<dl>
						  <dt>Progress</dt>
							<dd>{{ $content->is_inprogress==='1' ? 'Draft' : 'Done' }}</dd>
						</dl>

						<dl>
						  <dt>Access Count</dt>
						  <dd>{{ $content->count }}</dd>
						</dl>
					</p>

					<div class="text-right">
						<a role="button"
						class="btn btn-flat btn-danger"
						href="#">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							delete
						</a>
						<a role="button"
						class="btn btn-flat btn-default"
						href="{{ route('contentHistory',[$content->id]) }}">
							<span class="glyphicon glyphicon-time" aria-hidden="true"></span>
							access history
						</a>
						<a role="button"
						class="btn btn-flat btn-info"
						href="{{ route('designContent',[$content->id]) }}">
							<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
							design
						</a>
					</div>
				</div>

			</div>
		</div>
		<?php
	}
?>
<div class="container">

	<div class="row">
		<h1>My Contents ({{ count($contents) }})</h1>

		<?php $i=0; ?>

		@foreach ($contents as $content)

			<?php
				cardContent(++$i, $content);
			?>

		@endforeach

	</div>

</div>
@endsection
