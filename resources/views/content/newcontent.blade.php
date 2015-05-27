@extends('app')

@section('content')
<div class="container">

	<div class="row">
		<h1>New Content</h1>
	</div>

	<div class="row">
		<form class="form-horizontal" role="form" method="POST" action="{{ route('createContent') }}">

			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<div class="form-group">
		    <label for="inName" class="col-sm-2 control-label">Name</label>
		    <div class="col-sm-8">
		      <input type="text" class="form-control" name="inName" id="inName" placeholder="Content Name" required>
		    </div>
		  </div>

			<div class="form-group">
		    <label for="inDescription" class="col-sm-2 control-label">Description</label>
		    <div class="col-sm-8">
					<textarea class="form-control" name="inDescription" id="inDescription" placeholder="Description" rows="3"></textarea>
		    </div>
		  </div>

			<div class="form-group">
				<label for="inLevel" class="col-sm-2 control-label">For Level</label>
		    <div class="col-sm-2">
					<input type="number" class="form-control" name="inLevel" id="inLevel" min="1" max="6" required>
		    </div>
			</div>

			<div class="form-group">
				<label for="inCategory" class="col-sm-2 control-label">Category</label>
				<div class="col-sm-2">
					<select class="form-control" name="inCategory" id="inCategory">
						@foreach ($categories as $category)
							<option value="{{ $category->id }}">{{ $category->name }}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <div class="checkbox">
		        <label>
		          <input type="checkbox" name="inPublish" value="publish"> Publish to Every User
		        </label>
		      </div>
		    </div>
		  </div>

			<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" class="btn btn-primary">Create</button>
					<button type="reset" class="btn btn-primary">Reset</button>
		    </div>
		  </div>

		</form>
	</div>


</div>
@endsection
