@extends('app')

@section('content')

<div class="container">

	<div class="row">

		<h1>
			All Schools
			<span class="label label-info">{{ count($schools) }}</span>
			<button class="btn btn-primary" data-toggle="modal" data-target="#complete-dialog">New School</button>
		</h1>

		<table class="table table-striped table-bordered table-hover" id="myTable">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Address</th>
					<th>Tumbul</th>
					<th>District</th>
					<th>Province</th>
					<th>State</th>
					<th>Zone</th>
					<th>Country</th>
					<th>Region</th>
					<th>Zip</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($schools as $school)
				<tr>
					<td>{{ $school->id }}</td>
					<td>{{ $school->name }}</td>
					<td>{{ $school->address }}</td>
					<td>{{ $school->tumbul }}</td>
					<td>{{ $school->district }}</td>
					<td>{{ $school->province }}</td>
					<td>{{ $school->state }}</td>
					<td>{{ $school->zone }}</td>
					<td>{{ $school->country }}</td>
					<td>{{ $school->region }}</td>
					<td>{{ $school->zip }}</td>
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
        <h4 class="modal-title">New School</h4>
      </div>

      <div class="modal-body">
				<form class="form-horizontal" id="newSchoolForm">

				  <div class="form-group">
				    <label for="inName" class="col-sm-2 control-label">Name</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="inName" name="inName" placeholder="Name">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="inAddress" class="col-sm-2 control-label">Address</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="inAddress" name="inAddress" placeholder="Address">
				    </div>
				  </div>

					<div class="form-group">
				    <label for="inTumbul" class="col-sm-2 control-label">Tumbul</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="inTumbul" name="inTumbul" placeholder="Tumbul">
				    </div>
				  </div>

					<div class="form-group">
				    <label for="inDistrict" class="col-sm-2 control-label">District</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="inDistrict" name="inDistrict" placeholder="District">
				    </div>
				  </div>

					<div class="form-group">
				    <label for="inProvince" class="col-sm-2 control-label">Province</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="inProvince" name="inProvince" placeholder="Province">
				    </div>
				  </div>

					<div class="form-group">
				    <label for="inState" class="col-sm-2 control-label">State</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="inState" name="inState" placeholder="State">
				    </div>
				  </div>

					<div class="form-group">
				    <label for="inZone" class="col-sm-2 control-label">Zone</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="inZone" name="inZone" placeholder="Zone">
				    </div>
				  </div>

					<div class="form-group">
				    <label for="inCountry" class="col-sm-2 control-label">Country</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="inCountry" name="inCountry" placeholder="Country">
				    </div>
				  </div>

					<div class="form-group">
				    <label for="inRegion" class="col-sm-2 control-label">Region</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="inRegion" name="inRegion" placeholder="Region">
				    </div>
				  </div>

					<div class="form-group">
				    <label for="inZip" class="col-sm-2 control-label">Zip</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="inZip" name="inZip" placeholder="Zip">
				    </div>
				  </div>



				</form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
				<button
				type="button"
				class="btn btn-primary"
				id="newSchool"
				autocomplete="off"
				data-loading-text="Creating...">Create</button>
      </div>
    </div>
  </div>
</div>

<script>

	// submit new school
	$('#newSchool').on('click', function () {
		var $btn = $(this).button('loading');
		// business logic...
		ajaxNewSchool();
		//$btn.button('reset');
	})

	function ajaxNewSchool() {
		$.ajax({
		  url: "school/create",
			method: "POST",
		  data: {
				inName : $("#inName").val(),
				inAddress : $("#inAddress").val(),
				inTumbul : $("#inTumbul").val(),
				inDistrict : $("#inDistrict").val(),
				inProvince : $("#inProvince").val(),
				inState : $("#inState").val(),
				inZone : $("#inZone").val(),
				inCountry : $("#inCountry").val(),
				inRegion : $("#inRegion").val(),
				inZip : $("#inZip").val()
			}

		})
	  .done(function( result ) {
			// alert( "done "+result.result );
			if (result.result==='success') {
				//$("#type"+id).html(result.user.type);
				console.log(result.toString());
				console.log(result.school.toString());
				appendSchoolToTable(result.school);
				$('#newSchool').button('reset');
				$('#complete-dialog').modal('hide')
			}
	  })
		.fail(function() {
	    alert( "error" );
	  });
	}

	function appendSchoolToTable(school) {
		var row = "";
		row += "<tr>";
		row += "<td>"+school.id+"</td>";
		row += "<td>"+school.name+"</td>";
		row += "<td>"+school.address+"</td>";
		row += "<td>"+school.tumbul+"</td>";
		row += "<td>"+school.district+"</td>";
		row += "<td>"+school.province+"</td>";
		row += "<td>"+school.state+"</td>";
		row += "<td>"+school.zone+"</td>";
		row += "<td>"+school.country+"</td>";
		row += "<td>"+school.region+"</td>";
		row += "<td>"+school.zip+"</td>";
		row += "</tr>";
		$('#myTable > tbody:last').append(row);
	}
</script>

@endsection
