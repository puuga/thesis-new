@extends('app')

@section('content')
<script type="text/javascript">

	<?php
		$jContents = Array();
		$jActs = $content->activities;
		for ($i=0; $i < count($jActs); $i++) {
			$jAct["id"] = $jActs[$i]->id;
			$jAct["content_id"] = $jActs[$i]->content_id;
			$jAct["activity_type_id"] = $jActs[$i]->activity_type_id;
			$jAct["activity_type_name"] = $jActs[$i]->activityType->name;
			$jAct["activity_type_layout"] = $jActs[$i]->activityType->layout;
			$jAct["order"] = $jActs[$i]->order;
			$jAct["title"] = $jActs[$i]->title;
			$jAct["content"] = $jActs[$i]->content;
			$jAct["placeholder"] = $jActs[$i]->placeholder;
			$jAct["image_placeholder"] = $jActs[$i]->image_placeholder;
			$jAct["image_path"] = $jActs[$i]->image_path;
			$jAct["extra1"] = $jActs[$i]->extra1;
			$jAct["extra2"] = $jActs[$i]->extra2;

			$jContents[] = $jAct;
		}
	?>

	// activities = <?php echo json_encode($content->activities); ?>;
	activities = <?php echo json_encode($jContents); ?>;
	console.log(activities);

	// move activity up
	function moveActivityUp(orderr) {
		if (orderr === 1) {
			return;
		}
		var index = orderr-1;

		$.ajax({
			url: "{{ route('changeactivityorder') }}",
			method: "POST",
			data: {
				act1id : activities[index-1].id,
				act1order : orderr,
				act2id : activities[index].id,
				act2order : orderr-1
			}
		})
		.done(function( result ) {
			// alert( "done "+result.result );
			if (result.result==='success') {
				// swap value
				activities[index-1].order = orderr;
				activities[index].order = orderr-1;

				// swap object
				var temp = activities[index-1];
				activities[index-1] = activities[index];
				activities[index] = temp;

				// console.log(activities.length);
				drawActivity(activities);
			}
		})
		.fail(function() {
			alert( "error" );
		});
	}

	// move activity down
	function moveActivityDown(orderr) {
		if (orderr === activities.length) {
			return;
		}
		var index = orderr-1;

		$.ajax({
			url: "{{ route('changeactivityorder') }}",
			method: "POST",
			data: {
				act1id : activities[index].id,
				act1order : orderr+1,
				act2id : activities[index+1].id,
				act2order : orderr
			}
		})
		.done(function( result ) {
			// alert( "done "+result.result );
			if (result.result==='success') {
				// swap value
				activities[index].order = orderr+1;
				activities[index+1].order = orderr;

				// swap object
				var temp = activities[index+1];
				activities[index+1] = activities[index];
				activities[index] = temp;

				// console.log(activities.length);
				drawActivity(activities);
			}
		})
		.fail(function() {
			alert( "error" );
		});
	}

	// deleteActivity
	function deleteActivity(id) {
		var r = confirm("Delete Activity: " + id);
		if (r == true) {
			$.ajax({
				url: "{{ route('deleteactivity') }}",
				method: "POST",
				data: {
					activity_id : id,
					content_id : {{ $content->id }}
				}
			})
			.done(function( result ) {
				if (result.result==='success') {
					// alert('success');
					location.reload();
				}
			})
			.fail(function() {
				alert( "error" );
			});
		}
	}

	function drawActivity(activities) {
		var text = "";
		for (var x in activities) {
			if (activities.hasOwnProperty(x)) {
				text += drawActivityPanel(activities[x]);
			}
		}
		$("#activityContainer").html(text);
	}

	function drawActivityPanel(activity, activityType) {
		var text = "";
		var activity_type_name = (typeof activityType !== "undefined") ? activityType.name : activity.activity_type_name ;
		var activity_type_layout = (typeof activityType !== "undefined") ? activityType.layout : activity.activity_type_layout ;
		text += "<div class='panel panel-default'>";
		text += "<div class='panel-body'>";
		text += "<div class='col-md-3'>";// start 1st column
		text += "Activity_id: " + activity.id +"<br/>";
		text += "Type : "+ activity_type_name +"<br/>";
		text += "Layout : "+ activity_type_layout +"<br/>";
		text += "</div>";// close 1st column
		text += "<div class='col-md-3'>";// start 2nd column
		if (activity_type_name==="TEXT" && activity_type_layout==="1") {
			text += "Title : "+ activity.title +"<br/>";
			text += "Text : "+ activity.content +"<br/>";
		} else if (activity_type_name==="TEXT" && activity_type_layout==="2") {
			text += "Title : "+ activity.title +"<br/>";
			text += "SubTitle : "+ activity.content +"<br/>";
		} else if (activity_type_name==="IMAGE" && activity_type_layout==="1") {
			text += "Title : "+ activity.title +"<br/>";
			text += "SubTitle : "+ activity.content +"<br/>";
		} else if (activity_type_name==="MULTIPLE CHOICE" && activity_type_layout==="1") {
			text += "Title : "+ activity.title +"<br/>";
			text += "SubTitle : "+ activity.content +"<br/>";
			if (activity.extra1 !== null) {
				text += "option 1: "+ activity.extra1.split(",")[0] +", "+ activity.extra2.split(",")[0] +"<br/>";
				text += "option 2: "+ activity.extra1.split(",")[1] +", "+ activity.extra2.split(",")[1] +"<br/>";
				text += "option 3: "+ activity.extra1.split(",")[2] +", "+ activity.extra2.split(",")[2] +"<br/>";
				text += "option 4: "+ activity.extra1.split(",")[3] +", "+ activity.extra2.split(",")[3] +"<br/>";
			}
		} else if (activity_type_name==="MULTIPLE CHOICE" && activity_type_layout==="2") {
			text += "Title : "+ activity.title +"<br/>";
			text += "SubTitle : "+ activity.content +"<br/>";
			if (activity.extra1 !== null) {
				text += "option 1: "+ activity.extra1.split(",")[0] +", "+ activity.extra2.split(",")[0] +"<br/>";
				text += "option 2: "+ activity.extra1.split(",")[1] +", "+ activity.extra2.split(",")[1] +"<br/>";
				text += "option 3: "+ activity.extra1.split(",")[2] +", "+ activity.extra2.split(",")[2] +"<br/>";
				text += "option 4: "+ activity.extra1.split(",")[3] +", "+ activity.extra2.split(",")[3] +"<br/>";
			}
		}
		text += "</div>";// close 2nd column
		text += "<div class='col-md-2'>";// start 3rd column
		text += "<img class='img-responsive img-rounded' style='max-width:100px;max-height:100px;' src='"+activity.image_path+"'>";
		text += "</div>";// close 3rd column
		text += "<div class='col-md-2'>";// start 4rd column
		text += "<a ";
		text += "class='btn btn-warning'";
		text += "href='javascript:moveActivityUp("+activity.order+")'>";
		text += "<span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span>";
		text += "</a>";
		text += "<br/>";
		text += "<a ";
		text += "class='btn btn-warning'";
		text += "href='javascript:moveActivityDown("+activity.order+")'>";
		text += "<span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span>";
		text += "</a>";
		text += "</div>";// close 4rd column
		text += "<div class='col-md-2'>";// start 5th column
		text += "<a ";
		text += "class='btn btn-info'";
		text += "href='/contents/designactivity/"+activity.id+"'>";
		text += "<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>";
		text += "</a>";
		text += "<br/>";
		text += "<a ";
		text += "class='btn btn-danger'";
		text += "href='javascript:deleteActivity("+activity.id+")'>";
		text += "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
		text += "</a>";
		text += "</div>";// close 5th column
		text += "</div>";// close panel-body
		text += "</div>";// close panel
		return text;
	}

</script>
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
						  <dt>Access</dt>
						  <dd>
								{{ $content->is_public == 1 ? 'Public' : 'Limit' }}<br/>
								<small>
									Public : Every body can access<br/>
									Limit : Only Students are in same Author's school can access.
								</small>
							</dd>
						</dl>

						<dl class="dl-horizontal">
							<dt>Progress</dt>
							<dd>{{ $content->is_inprogress==='1' ? 'Draft' : 'Done' }}</dd>
						</dl>

						<dl class="dl-horizontal">
						  <dt>Access Count</dt>
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
								<button type="submit" class="btn btn-primary">
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
				Activities (<span id="activityNumber">{{ count($content->activities)}}</span>)
				<div class="btn-group">
				  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						<span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" role="menu">
				    <li><a href="javascript:void(0)" data-toggle="modal" data-target="#moNewInteractiveActivity">New Interactive Activity</a></li>
				    <li><a href="javascript:void(0)">New Plain Activity</a></li>
				  </ul>
				</div>
			</h2>

			<div id="activityContainer">

			</div>

		</div>

	</div>

</div>

<!-- Edit Content Desctiption Modal -->
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

<!-- Modal -->
<div class="modal fade" id="moNewInteractiveActivity" tabindex="-1" role="dialog" aria-labelledby="moNewInteractiveActivityLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="moNewInteractiveActivityLabel">New Activity</h2>
      </div>

      <div class="modal-body">
				<form class="form-horizontal" id="newActivityForm">
					<div class="form-group">
						<label class="col-sm-2 control-label">Text</label>
						<div class="col-sm-10">
							<div class="radio radio-primary">
								<label>
									<input type="radio" name="optionsRadios" id="optionsRadios1" value="1">
									Layout 1
									<img class="img-responsive img-thumbnail"
										src="{{ asset('/images/text-1.png') }}" alt="Layout 1" />
								</label>
							</div>
							<div class="radio radio-primary">
								<label>
									<input type="radio" name="optionsRadios" id="optionsRadios2" value="2">
									Layout 2
								</label>
							</div>
						</div>

					</div>


					<div class="form-group">
						<label class="col-sm-2 control-label">Image</label>
						<div class="col-sm-10">
							<div class="radio radio-primary">
								<label>
									<input type="radio" name="optionsRadios" id="optionsRadios3" value="3">
									Layout 1
								</label>
							</div>
							<div class="radio radio-primary">
								<label>
									<input type="radio" name="optionsRadios" id="optionsRadios4" value="4" disabled>
									Layout 2
								</label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">Multiple Choices</label>
						<div class="col-sm-10">
							<div class="radio radio-primary">
								<label>
									<input type="radio" name="optionsRadios" id="optionsRadios2" value="5">
									Layout 1
									<img class="img-responsive img-thumbnail"
										src="{{ asset('/images/multiple_choices-1.png') }}" alt="Layout 1" />
								</label>
							</div>
							<div class="radio radio-primary">
								<label>
									<input type="radio" name="optionsRadios" id="optionsRadios3" value="6">
									Layout 2
									<img class="img-responsive img-thumbnail"
										src="{{ asset('/images/multiple_choices-2.png') }}" alt="Layout 2" />
								</label>
							</div>
						</div>
					</div>

				</form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button
				type="button"
				class="btn btn-primary"
				id="newActivity"
				autocomplete="off"
				data-loading-text="Creating...">New Activity</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
// submit new activity
$('#newActivity').on('click', function () {
	var $btn = $(this).button('loading');
	// business logic...
	ajaxNewActivity();
	//$btn.button('reset');
});

function ajaxNewActivity() {
	$.ajax({
		url: "{{ route('createActivity', $content->id) }}",
		method: "POST",
		data: {
			inActivityTypeId : $('input[name=optionsRadios]:checked', '#newActivityForm').val()
		}
	})
	.done(function( result ) {
		// alert( "done "+result.result );
		if (result.result==='success') {
			// $("#type"+id).html(result.user.type);
			// console.log(result.toString());
			// console.log(result.activity.toString());
			$("#activityNumber").html(result.activity.order);

			$('#activityContainer').append(drawActivityPanel(result.activity,result.activity_type));

			// reset button
			$('#newActivity').button('reset');
			$('#moNewInteractiveActivity').modal('hide');
			$('#newActivityForm')[0].reset();
		}
	})
	.fail(function() {
		alert( "error" );
	});
}

drawActivity(activities);

</script>
@endsection
