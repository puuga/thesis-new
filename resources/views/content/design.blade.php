@extends('master')

@section('content')
<div class="container">

	<div class="row">
		<h1>
			Design Content
			<button type="button"
			class="btn btn-default"
			aria-label="Center Align"
			data-toggle="modal"
			data-target="#moEditContent">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
			</button>
		</h1>
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
						  <dt>Level</dt>
						  <dd>{{ $content->level }}</dd>
						</dl>

						<dl class="dl-horizontal">
						  <dt>Published</dt>
						  <dd>{{ $content->is_public == 1 ? 'Yes' : 'No' }}</dd>
						</dl>

						<dl class="dl-horizontal">
							<dt>Inprogress || Pubished</dt>
							<dd>{{ $content->is_inprogress==='1' ? 'Inprogress' : 'Pubished' }}</dd>
						</dl>

						<dl class="dl-horizontal">
						  <dt>Content views</dt>
						  <dd>{{ $content->count }}</dd>
						</dl>

					</div>
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
						<p>
							Update Placeholder Image<br/>
							<form
							action="{{ route('addimageentrytocontent', []) }}"
							role="form"
							method="post"
							enctype="multipart/form-data" >
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="contentid" value="{{ $content->id }}">
				        <input type="file" class="form-control" name="imagefield" accept="image/*">
								<button type="submit" class="btn btn-primary" form="formEdit">
									<span class="glyphicon glyphicon-upload" aria-hidden="true"></span> upload
								</button>
					    </form>
						</p>
					</div>
				</div>
			</div>
	</div>

	<hr/>

	<div class="row">
		<div class="col-md-12">

			<h2>
				Activities
				<div class="btn-group">
				  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						<span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" role="menu">
				    <li><a href="#">New Interactive Activity</a></li>
				    <li><a href="#">New Plain Activity</a></li>
				  </ul>
				</div>
			</h2>

			<div class="row">
				<div class="col-md-6">

				</div>
				<div class="col-md-6">

				</div>
			</div>

		</div>


	</div>

</div>

<!-- Modal -->
<div class="modal fade" id="moEditContent" tabindex="-1" role="dialog" aria-labelledby="moEditContentLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
        <h4 class="modal-title" id="moEditContentLabel">Edit Content</h4>
      </div>

      <div class="modal-body">
				<form class="form-horizontal" id="formEdit" role="form" method="POST" action="{{ route('updateContent',[$content->id]) }}">

					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="form-group">
				    <label for="inName" class="col-sm-2 control-label">Name</label>
				    <div class="col-sm-10">
				      <input
							type="text"
							class="form-control"
							name="inName"
							id="inName"
							placeholder="Content Name"
							value="{{ $content->name }}"
							required>
				    </div>
				  </div>

					<div class="form-group">
				    <label for="inDescription" class="col-sm-2 control-label">Description</label>
				    <div class="col-sm-10">
							<textarea
							class="form-control"
							name="inDescription"
							id="inDescription"
							placeholder="Description"
							rows="3">{{ $content->description }}</textarea>
				    </div>
				  </div>

					<div class="form-group">
						<label for="inLevel" class="col-sm-2 control-label">For Level</label>
				    <div class="col-sm-10">
							<input
							type="number"
							class="form-control"
							name="inLevel"
							id="inLevel"
							min="1"
							max="6"
							value="{{ $content->level }}"
							required>
				    </div>
					</div>

					<div class="form-group">
						<label for="inCategory" class="col-sm-2 control-label">Category</label>
						<div class="col-sm-10">
							<select class="form-control" name="inCategory" id="inCategory">
								@foreach ($categories as $category)
									<option
									value="{{ $category->id }}"
									{{ $content->category_id === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <div class="checkbox">
				        <label>
				          <input
									type="checkbox"
									name="inPublish"
									value="publish"
									{{ $content->is_public === '1' ? 'checked' : '' }}> Publish to Every User
				        </label>
				      </div>
				    </div>
				  </div>

					<div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <div class="checkbox">
				        <label>
				          <input
									type="checkbox"
									name="inProgress"
									value="inProgress"
									{{ $content->is_inprogress === '1' ? 'checked' : '' }}> inProgress
				        </label>
								<p class="help-block">Check this option if the content is not ready to publish.</p>
				      </div>
				    </div>
				  </div>

				</form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="reset" class="btn btn-default" form="formEdit">Reset</button>
        <button type="submit" class="btn btn-primary" form="formEdit">Save changes</button>
      </div>

    </div>
  </div>
</div>
@endsection
