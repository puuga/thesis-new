@extends('content.activity.activitymaster')

@section('styleextend')
.pepcustom {
	color: White;
	background-color: #2196F3;
	display: inline-block;
	padding: 5px;
	margin: 5px;
	text-align: center;
  vertical-align: middle;
  border-radius: 1em;
}
.holdcustom {
	border: 2px solid #2196F3;
	display: inline-block;
	padding: 10px;
	margin: 5px;
}
.image-preview {
	width: 100px;
	height: 100px;
}
.image-option-preview {
	max-width: 60px;
	max-height: 60px;
}
@endsection

@section('contentextend')
<?php
	function getImagePlaceholder($ac) {
		// !is_null($ac->image_placeholder) ? route('getimagebyid', $ac->image_placeholder) : '';
		if ( !is_null($ac->image_placeholder) ) {
			$out = route('getimagebyid', $ac->image_placeholder);
		} else {
			$out = '';
		}
		return $out;
	}

	function getOptionImageP($ac, $i) {
		if ( !is_null($ac->extra1) ) {
			$temp = explode(",",$ac->extra1);
			if ( $temp[$i]==='' ) {
				return '';
			}
			$out = route('getimagebyid', $temp[$i]);
		} else {
			$out = '';
		}
		return $out;
	}

	function getOptionImagePId($ac, $i) {
		if ( !is_null($ac->extra1) ) {
			$temp = explode(",",$ac->extra1);
			if ( $temp[$i]==='' ) {
				return '';
			}
			$out = $temp[$i];
		} else {
			$out = '';
		}
		return $out;
	}
?>
<div class="container">
	<div class="row">
		<a class="btn btn-primary" href="{{ route('designContent',$activity->content_id) }}">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			Content
		</a>

	</div>
	<div class="row">
		<div class="col-xs-6">
			<h3>Infomation</h3>

			<form class="form-horizontal" name="myForm" id="myForm">
			</form>

			<div class="form-group">
				<label for="inTitle" class="col-xs-2 control-label">Title</label>
				<div class="col-xs-10">
			    <input
					class="form-control"
					form="myForm"
					id="inTitle"
					name="inTitle"
					type="text"
					placeholder="Title"
					data-hint="You should really write something here"
					onkeyup="javascript:updateTitle()"
					value="{{ !is_null($activity->title) ? $activity->title : ''}}">
				</div>
			</div>

			<div class="form-group">
				<label for="inText" class="col-xs-2 control-label">Sub-Title</label>
				<div class="col-xs-10">
			    <input
					class="form-control"
					form="myForm"
					id="inSubTitle"
					name="inSubTitle"
					type="text"
					placeholder="sub title"
					data-hint="You should really write something here"
					onkeyup="javascript:updateSubTitle()"
					value="{{ !is_null($activity->content) ? $activity->content : ''}}">
				</div>
			</div>

			<div class="form-group">
				<label for="inOption1" class="col-xs-2 control-label">option1</label>
				<div class="col-xs-1">
					<div class="checkbox">
            <label>
              <input form="myForm"
								type="checkbox" id="inOptionChk1" value="0"
								onchange="markCorrectIncorrectOption(this)"
								{{ !is_null($activity->extra2) ? explode(",",$activity->extra2)[0]==="true" ? 'checked': '' : '' }}>
            </label>
          </div>
				</div>
				<div class="col-xs-8">
					<form name="imageForm1" id="imageForm1">
						<input class="form-control" type="file" name="imagefield" id="imageId1" accept="image/*">
						<a class="btn btn-flat btn-primary" href="javascript:saveImageOption('1')">Save Image</a>
					</form>
				</div>
			</div>

			<div class="form-group">
				<label for="inOption2" class="col-xs-2 control-label">option2</label>
				<div class="col-xs-1">
					<div class="checkbox">
            <label>
              <input form="myForm"
								type="checkbox" id="inOptionChk2" value="1"
								onchange="markCorrectIncorrectOption(this)"
								{{ !is_null($activity->extra2) ? explode(",",$activity->extra2)[1]==="true" ? 'checked': '' : '' }}>
            </label>
          </div>
				</div>
				<div class="col-xs-8">
					<form name="imageForm2" id="imageForm2">
						<input class="form-control" type="file" name="imagefield" id="imageId2" accept="image/*">
						<a class="btn btn-flat btn-primary" href="javascript:saveImageOption('2')">Save Image</a>
					</form>
				</div>
			</div>

			<div class="form-group">
				<label for="inOption3" class="col-xs-2 control-label">option3</label>
				<div class="col-xs-1">
					<div class="checkbox">
            <label>
              <input form="myForm"
								type="checkbox" id="inOptionChk3" value="2"
								onchange="markCorrectIncorrectOption(this)"
								{{ !is_null($activity->extra2) ? explode(",",$activity->extra2)[2]==="true" ? 'checked': '' : '' }}>
            </label>
          </div>
				</div>
				<div class="col-xs-8">
					<form name="imageForm3" id="imageForm3">
						<input class="form-control" type="file" name="imagefield" id="imageId3" accept="image/*">
						<a class="btn btn-flat btn-primary" href="javascript:saveImageOption('3')">Save Image</a>
					</form>
				</div>
			</div>

			<div class="form-group">
				<label for="inOption4" class="col-xs-2 control-label">option4</label>
				<div class="col-xs-1">
					<div class="checkbox">
            <label>
              <input form="myForm"
								type="checkbox" id="inOptionChk4" value="3"
								onchange="markCorrectIncorrectOption(this)"
								{{ !is_null($activity->extra2) ? explode(",",$activity->extra2)[3]==="true" ? 'checked': '' : '' }}>
            </label>
          </div>
				</div>
				<div class="col-xs-8">
					<form name="imageForm4" id="imageForm4">
						<input class="form-control" type="file" name="imagefield" id="imageId4" accept="image/*">
						<a class="btn btn-flat btn-primary" href="javascript:saveImageOption('4')">Save Image</a>
					</form>
				</div>
			</div>

			<div class="form-group">
        <div class="col-xs-10 col-xs-offset-2">
					<button form="myForm" type="button" class="btn btn-default" onclick="resetForm()">Reset</button>
          <button form="myForm" type="button" class="btn btn-primary" onclick="saveInformation()">Save</button>
        </div>
      </div>

			<hr/>
			<h3>Image</h3>

			<form class="form-horizontal" id="imageForm">

				<input type="hidden" name="activity_id" value="{{$activity->id}}">

				<div class="form-group">
					<label for="inImage" class="col-xs-2 control-label">Image</label>
					<div class="col-xs-10">
				    <input
						class="form-control"
						id="inImage"
						name="inImage"
						type="file"
						accept="image/*">
					</div>
				</div>

				<div class="form-group">
          <div class="col-xs-10 col-xs-offset-2">
            <button type="button" class="btn btn-primary" onclick="saveImage()">Use new image</button>
          </div>
        </div>
			</form>

			<hr/>
			<h3>Animation</h3>

			<form class="form-horizontal" id="animationForm">
				<div class="form-group">
					<label class="col-xs-2 control-label">Correct animation</label>
					<div class="col-xs-10">
						<div class="radio radio-primary">
							<label>
								<input
								type="radio"
								name="caOptions"
								id="caOptions1"
								value="1"
								{{ $activity->correct_animation === '1' ? 'checked' : '' }}>
								Set 1
							</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-2 control-label">Incorrect animation</label>
					<div class="col-xs-10">
						<div class="radio radio-primary">
							<label>
								<input
								type="radio"
								name="iaOptions"
								id="iaOptions1"
								value="1"
								{{ $activity->correct_animation === '1' ? 'checked' : '' }}>
								Set 1
							</label>
						</div>
					</div>
				</div>

				<div class="form-group">
          <div class="col-xs-10 col-xs-offset-2">
            <button type="button" class="btn btn-primary" onclick="saveAnimation({{$activity->id}})">Use new animation</button>
          </div>
        </div>

			</form>
		</div>

		<div class="col-xs-6">
			<h3>Preview</h3>

			<div class="panel panel-default">
		    <div class="panel-body">

					<div class="" id="preview">
						<div class="text-center" id="pTitle">
							&lt;&lt; Title &gt;&gt;
						</div>
						<div class="text-center" id="pSubTitle">
							&lt;&lt; Text &gt;&gt;
						</div>
						<div class="col-xs-6">
							<div class="text-center" id="pOptions">
								<a href='#' class='btn btn-primary btn-xs' id='optionP0'>
									<img class="image-option-preview"
										id="optionImageP0"
										src="{{ getOptionImageP($activity,0) }}"
										data-imageid="{{ getOptionImagePId($activity,0) }}" />
								</a>

								<a href='#' class='btn btn-primary btn-xs' id='optionP1'>
									<img class="image-option-preview"
										id="optionImageP1"
										src="{{ getOptionImageP($activity,1) }}"
										data-imageid="{{ getOptionImagePId($activity,1) }}" />
								</a>

								<br/>

								<a href='#' class='btn btn-primary btn-xs' id='optionP2'>
									<img class="image-option-preview"
										id="optionImageP2"
										src="{{ getOptionImageP($activity,2) }}"
										data-imageid="{{ getOptionImagePId($activity,2) }}" />
								</a>

								<a href='#' class='btn btn-primary btn-xs' id='optionP3'>
									<img class="image-option-preview"
										id="optionImageP3"
										src="{{ getOptionImageP($activity,3) }}"
										data-imageid="{{ getOptionImagePId($activity,3) }}" />
								</a>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="text-center">
								<img
								class="image-preview"
								id="pImage"
								src="{{ getImagePlaceholder($activity) }}"
								alt="&lt;&lt; Image &gt;&gt;" />
							</div>
						</div>
						<div class="text-center" id="pHold">
						</div>
					</div>

		    </div>
			</div>

		</div>

	</div>
</div>

<script type="text/javascript">
	function updateTitle() {
		var text = $("#inTitle").val() !== "" ? $("#inTitle").val() : "&lt;&lt; Title &gt;&gt;" ;
		$("#pTitle").html(text);
	}

	function updateSubTitle() {
		var text = $("#inSubTitle").val() !== "" ? $("#inSubTitle").val() : "&lt;&lt; SubTitle &gt;&gt;" ;
		$("#pSubTitle").html(text);
	}

	function updateOptions() {
		for (var i = 0; i < 4; i++) {
			if ( $("#inOptionChk"+(i+1)).is(':checked') ) {
				var option = $("#optionP"+i);
				option.removeClass("btn-primary");
				option.addClass("btn-info");
			}
		}
	}

	function saveImageOption(previewid) {
		var form = $("#imageForm"+previewid);
		console.log(form);
		var data = new FormData(form[0]);
		console.log("#imageForm"+previewid);
		console.log(data);
		$.ajax({
			url : "{{ route('addWithResponse') }}",
			method : 'POST',
			data	: data,
			processData: false,
			contentType: false
		})
		.done(function( result ) {
			if ( result.result==='success' ) {
				console.log(result);

				// set image id to img attribute
				$("#optionImageP"+(previewid-1)).attr('data-imageid', result.entry.id);
			} else if ( result.result==='unsuccess') {
				alert(result.action);
			}
		})
		.fail(function() {
			alert( "error" );
		});
	}

	function markCorrectIncorrectOption(option) {
		console.log(option.checked);
		var optionVal = option.value;
		if ( option.checked ) {
			if ( $("#inOption"+optionVal).val()==="" ) {
				return ;
			}

			var option = $("#optionP"+optionVal);
			option.removeClass("btn-primary");
			option.addClass("btn-info");
		} else {
			var option = $("#optionP"+optionVal);
			option.removeClass("btn-info");
			option.addClass("btn-primary");
		}

	}

	function resetForm() {
		document.getElementById("myForm").reset();
		updateInformation();
	}

	function updateInformation() {
		updateTitle();
		updateSubTitle();
		updateOptions();
	}

	function readImage(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#pImage').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
	}

	function readImageP(input, i) {
		if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#optionImageP'+i).attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
	}

	$("#inImage").change(function(){
    readImage(this);
	});

	$("#imageId1").change(function(){
    readImageP(this,0);
	});
	$("#imageId2").change(function(){
    readImageP(this,1);
	});
	$("#imageId3").change(function(){
    readImageP(this,2);
	});
	$("#imageId4").change(function(){
    readImageP(this,3);
	});

	function validateOptions() {
		var op1 = $("#inOption1").val();
		var op2 = $("#inOption2").val();
		if ( op1==="" || op1===null ) {
			return false;
		} else if ( op2==="" || op2===null ) {
			return false;
		}
		return true;
	}

	function saveInformation() {
		if ( !validateOptions() ) {
			alert();
			return;
		}

		var data = {};
		data.activity_id = {{ $activity->id }};
		data.activity_type_id = {{ $activity->activity_type_id }};
		data.inTitle = $("#inTitle").val();
		data.inSubTitle = $("#inSubTitle").val();
		data.imageId1 = $("#optionImageP0").attr('data-imageid');
		data.isAnswer1 = $("#inOptionChk1").is(':checked');
		data.imageId2 = $("#optionImageP1").attr('data-imageid');
		data.isAnswer2 = $("#inOptionChk2").is(':checked');
		data.imageId3 = $("#optionImageP2").attr('data-imageid');
		data.isAnswer3 = $("#inOptionChk3").is(':checked');
		data.imageId4 = $("#optionImageP3").attr('data-imageid');
		data.isAnswer4 = $("#inOptionChk4").is(':checked');

		console.log(data);

		// ajax
		$.ajax({
			url: "{{ route('updateActivityInformation') }}",
			method: "POST",
			data: data
		})
		.done(function( result ) {
			if (result.result==='success') {
				// alert('success');
				// location.reload();

				// change default value
				document.getElementById("inTitle").defaultValue = $("#inTitle").val();
				document.getElementById("inSubTitle").defaultValue = $("#inSubTitle").val();
				document.getElementById("inOptionChk1").defaultChecked = data.isAnswer1;
				document.getElementById("inOptionChk2").defaultChecked = data.isAnswer2;
				document.getElementById("inOptionChk3").defaultChecked = data.isAnswer3;
				document.getElementById("inOptionChk4").defaultChecked = data.isAnswer4;
			}
		})
		.fail(function() {
			alert( "error" );
		});
	}

	// check data
	updateInformation();
</script>

@endsection
