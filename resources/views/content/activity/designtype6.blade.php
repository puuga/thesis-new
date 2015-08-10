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
@endsection

@section('contentextend')
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

			<form class="form-horizontal" id="myForm">

				<div class="form-group">
					<label for="inTitle" class="col-xs-2 control-label">Title</label>
					<div class="col-xs-10">
				    <input
						class="form-control"
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
                <input type="checkbox" id="inOptionChk1" value="1" onchange="markCorrectIncorrectOption(this)"
									{{ !is_null($activity->extra2) ? explode(",",$activity->extra2)[0]==="true" ? 'checked': '' : '' }}>
              </label>
            </div>
					</div>
					<div class="col-xs-9">
				    <input
						class="form-control"
						id="inOption1"
						name="inOption1"
						type="text"
						placeholder="option 1"
						data-hint="required"
						onkeyup="javascript:updateOptions()"
						value="{{ !is_null($activity->extra1) ? explode(",",$activity->extra1)[0] : '' }}"
						required >
					</div>
				</div>

				<div class="form-group">
					<label for="inOption2" class="col-xs-2 control-label">option2</label>
					<div class="col-xs-1">
						<div class="checkbox">
              <label>
                <input type="checkbox" id="inOptionChk2" value="2" onchange="markCorrectIncorrectOption(this)"
									{{ !is_null($activity->extra2) ? explode(",",$activity->extra2)[1]==="true" ? 'checked': '' : '' }}>
              </label>
            </div>
					</div>
					<div class="col-xs-9">
				    <input
						class="form-control"
						id="inOption2"
						name="inOption2"
						type="text"
						placeholder="option 2"
						data-hint="required"
						onkeyup="javascript:updateOptions()"
						value="{{ !is_null($activity->extra1) ? explode(",",$activity->extra1)[1] : '' }}"
						required >
					</div>
				</div>

				<div class="form-group">
					<label for="inOption3" class="col-xs-2 control-label">option3</label>
					<div class="col-xs-1">
						<div class="checkbox">
              <label>
                <input type="checkbox" id="inOptionChk3" value="3" onchange="markCorrectIncorrectOption(this)"
									{{ !is_null($activity->extra2) ? explode(",",$activity->extra2)[2]==="true" ? 'checked': '' : '' }}>
              </label>
            </div>
					</div>
					<div class="col-xs-9">
				    <input
						class="form-control"
						id="inOption3"
						name="inOption3"
						type="text"
						placeholder="option 3"
						data-hint="You should really write something here"
						onkeyup="javascript:updateOptions()"
						value="{{ !is_null($activity->extra1) ? explode(",",$activity->extra1)[2] : '' }}">
					</div>
				</div>

				<div class="form-group">
					<label for="inOption4" class="col-xs-2 control-label">option4</label>
					<div class="col-xs-1">
						<div class="checkbox">
              <label>
                <input type="checkbox" id="inOptionChk4" value="4" onchange="markCorrectIncorrectOption(this)"
									{{ !is_null($activity->extra2) ? explode(",",$activity->extra2)[3]==="true" ? 'checked': '' : '' }}>
              </label>
            </div>
					</div>
					<div class="col-xs-9">
				    <input
						class="form-control"
						id="inOption4"
						name="inOption4"
						type="text"
						placeholder="option 4"
						data-hint="You should really write something here"
						onkeyup="javascript:updateOptions()"
						value="{{ !is_null($activity->extra1) ? explode(",",$activity->extra1)[3] : '' }}">
					</div>
				</div>

				<div class="form-group">
          <div class="col-xs-10 col-xs-offset-2">
						<button type="button" class="btn btn-default" onclick="resetForm()">Reset</button>
            <button type="button" class="btn btn-primary" onclick="saveInformation()">Save</button>
          </div>
        </div>

			</form>

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
			@include('content.activity.animation')

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
								&lt;&lt; Options &gt;&gt;
							</div>
						</div>
						<div class="col-xs-6">
							<div class="text-center">
								<img
								class="image-preview"
								id="pImage"
								src="{{ !is_null($activity->image_placeholder) ? route('getimagebyid', $activity->image_placeholder) : ''}}"
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
		var text = "";
		var op1 = $("#inOption1").val();
		var op2 = $("#inOption2").val();
		var op3 = $("#inOption3").val();
		var op4 = $("#inOption4").val();
		text += op1 !== "" ? optionPreview(op1,1,$("#inOptionChk1").is(':checked'))+"<br/>" : "<br/>" ;
		text += op2 !== "" ? optionPreview(op2,2,$("#inOptionChk2").is(':checked'))+"<br/>" : "<br/>" ;
		text += op3 !== "" ? optionPreview(op3,3,$("#inOptionChk3").is(':checked'))+"<br/>" : "<br/>" ;
		text += op4 !== "" ? optionPreview(op4,4,$("#inOptionChk4").is(':checked'))+"<br/>" : "<br/>" ;
		$("#pOptions").html(text);
	}

	function optionPreview(text, i, checked) {
		var output = "";
		if (checked) {
			output = "<a href='#' class='btn btn-info btn-xs' id='optionP"+i+"'>"+text+"</a>";
		} else {
			output = "<a href='#' class='btn btn-primary btn-xs' id='optionP"+i+"'>"+text+"</a>";
		}
		return output;
	}

	function markCorrectIncorrectOption(option) {
		// console.log(option.checked);
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

	$("#inImage").change(function(){
    readImage(this);
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
		data.message1 = $("#inOption1").val();
		data.isAnswer1 = $("#inOptionChk1").is(':checked');
		data.message2 = $("#inOption2").val();
		data.isAnswer2 = $("#inOptionChk2").is(':checked');
		data.message3 = $("#inOption3").val();
		data.isAnswer3 = $("#inOptionChk3").is(':checked');
		data.message4 = $("#inOption4").val();
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
				document.getElementById("inOption1").defaultValue = data.message1;
				document.getElementById("inOption2").defaultValue = data.message2;
				document.getElementById("inOption3").defaultValue = data.message3;
				document.getElementById("inOption4").defaultValue = data.message4;
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
