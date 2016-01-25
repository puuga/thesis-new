@extends('app')

@section('content')

<div class="container">

	<div class="row">

		<h1>All Categories
			<span class="label label-info" id="categoryCount">{{ count($categorys) }}</span>
			<button class="btn btn-primary" data-toggle="modal" data-target="#complete-dialog">New Category</button>
		</h1>

		<table class="table table-striped table-bordered table-hover" id="myTable">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Number of Published Contents</th>
					<th>Number of Inprogress Contents</th>
					<th>Number of Total Contents</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($categorys as $category)
				<tr>
					<td>{{ $category->id }}</td>
					<td>{{ $category->name }}</td>
					<td>{{ count(Helper::getContentsByCategoryProgress($category->id,0)) }}</td>
					<td>{{ count(Helper::getContentsByCategoryProgress($category->id,1)) }}</td>
					<td>{{ count($category->contents) }}</td>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>

	</div>

</div>

<div id="complete-dialog" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">New Category</h4>
      </div>

      <div class="modal-body">
				<form class="form-horizontal" id="newCategoryForm">

				  <div class="form-group">
				    <label for="inName" class="col-sm-2 control-label">Name</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="inName" name="inName" placeholder="Name">
				    </div>
				  </div>

				</form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
				<button
				type="button"
				class="btn btn-primary"
				id="newCategory"
				autocomplete="off"
				data-loading-text="Creating...">Create</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
// submit new Category
$('#newCategory').on('click', function () {
	var $btn = $(this).button('loading');
	// business logic...
	ajaxNewCategory();
	//$btn.button('reset');
});

function ajaxNewCategory() {
	$.ajax({
		url: "{{ route('createCategory') }}",
		method: "POST",
		data: {
			inName : $("#inName").val()
		}
	})
	.done(function( result ) {
		// alert( "done "+result.result );
		if (result.result==='success') {
			appendCategoryToTable(result.category);
			$('#newCategory').button('reset');
			$('#complete-dialog').modal('hide');
			$('#newCategoryForm')[0].reset();
			$('#categoryCount').html(result.count);
		}
	})
	.fail(function() {
		alert( "error" );
	});
}

function appendCategoryToTable(category) {
	var row = "";
	row += "<tr>";
	row += "<td>"+category.id+"</td>";
	row += "<td>"+category.name+"</td>";
	row += "</tr>";
	$('#myTable > tbody:last').append(row);
}
</script>

@endsection
