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
						value="{{ !is_null($activity->title) || $activity->title!=="" ? $activity->title : ''}}">
					</div>
				</div>

				<div class="form-group">
					<label for="inText" class="col-xs-2 control-label">Text</label>
					<div class="col-xs-10">
				    <input
						class="form-control"
						id="inText"
						name="inText"
						type="text"
						placeholder="Text"
						data-hint="You should really write something here"
						onkeyup="javascript:updateText()"
						value="{{ !is_null($activity->content) || $activity->content!=="" ? $activity->content : ''}}">
					</div>
				</div>

				<div class="form-group">
					<label for="inHint" class="col-xs-2 control-label">Hint</label>
					<div class="col-xs-10">
				    <input
						class="form-control"
						id="inHint"
						name="inHint"
						type="text"
						placeholder="Hint"
						data-hint="You should really write something here"
						onkeyup="javascript:updateHint()"
						value="{{ !is_null($activity->placeholder) || $activity->placeholder!=="" ? $activity->placeholder : ''}}">
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
						<div class="text-center text-uppercase" id="pText">
							&lt;&lt; Text &gt;&gt;
						</div>
						<div class="col-xs-6">
							<div class="text-center" id="pHint">
								&lt;&lt; Hint &gt;&gt;
							</div>
						</div>
						<div class="col-xs-6">
							<div class="text-center">
								<img
								class="image-preview"
								id="pImage"
								src="{{ !is_null($activity->image_placeholder) || $activity->image_placeholder!=="" ? route('getimagebyid', $activity->image_placeholder) : ''}}"
								alt="&lt;&lt; Image &gt;&gt;" />
							</div>
						</div>
						<div class="text-center" id="pHold">
							&lt;&lt; Hold &gt;&gt;
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

	function updateText() {
		if ( $("#inText").val() === "" ) {
			$("#pText").html("&lt;&lt; Text &gt;&gt;");
			$("#pHold").html("&lt;&lt; Hold &gt;&gt;");
		} else {
			var arrText = $("#inText").val().split("");
			var output = "";
			var holds = "";
			for (var i = 0; i < arrText.length; i++) {
				output += "<div class='pepcustom'>"+arrText[i]+"</div>";
				holds += "<div class='holdcustom'>&nbsp;</div>";
			}
			$("#pText").html(output);
			$("#pHold").html(holds);
		}
	}

	function updateHint() {
		var text = $("#inHint").val() !== "" ? $("#inHint").val() : "&lt;&lt; Hint &gt;&gt;" ;
		$("#pHint").html(text);
	}

	function resetForm() {
		document.getElementById("myForm").reset();
		updateInformation();
	}

	function updateInformation() {
		updateTitle();
		updateText();
		updateHint();
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

	function saveInformation() {
		var inTitle = $("#inTitle").val();
		var inText = $("#inText").val();
		var inHint = $("#inHint").val();

		// ajax
		$.ajax({
			url: "{{ route('updateActivityInformation') }}",
			method: "POST",
			data: {
				activity_id : {{ $activity->id }},
				activity_type_id : {{ $activity->activity_type_id}},
				inTitle : inTitle,
				inText : inText,
				inHint : inHint
			}
		})
		.done(function( result ) {
			if (result.result==='success') {
				// alert('success');
				// location.reload();

				// change default value
				document.getElementById("inTitle").defaultValue = inTitle;
				document.getElementById("inText").defaultValue = inText;
				document.getElementById("inHint").defaultValue = inHint;
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
