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
		<a class="btn btn-primary btn-flat" href="{{ route('designContent',$activity->content_id) }}">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			Content
		</a>

	</div>
	<div class="row">
		<div class="col-xs-6">

			<div class="row">
				<div class="col-xs-12 bg-info">
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
							<label for="inText" class="col-xs-2 control-label">Number of Object</label>
							<div class="col-xs-2">
						    <input
								class="form-control"
								id="inText"
								name="inText"
								type="number"
								min="1"
								max="6"
								placeholder="Text"
								onkeyup="javascript:updateNumberOfObject()"
								onchange="javascript:updateNumberOfObject()"
								value="{{ is_null($activity->content) || $activity->content==="" ? '0' : $activity->content }}">
							</div>
							Minimum is 1 and maximum is 6
						</div>

						@for ($i = 1; $i <= 6; $i++)
						<div class="form-group" id="inObject{{$i}}">
							<label for="inObject{{$i}}img" class="col-xs-4 control-label">Object {{$i}}</label>
							<div class="col-xs-8">
								<button class="btn btn-flat btn-primary" type="button"
								data-toggle="modal"
								data-target="#modalSelectImage"
								data-box-number="{{$i}}">
									Select Image box {{$i}}
								</button>
							</div>
						</div>
						@endfor

						<div class="form-group">
							<label for="inNumberOfHold" class="col-xs-2 control-label">Number Of Hold</label>
							<div class="col-xs-2">
						    <input
								class="form-control"
								id="inNumberOfHold"
								name="inNumberOfHold"
								type="number"
								min="1"
								max="4"
								onchange="javascript:updateNumberOfHold()"
								onkeyup="javascript:updateNumberOfHold()"
								value="{{ is_null($activity->extra1) || $activity->extra1==="" ? 1 : count(explode(",",$activity->extra1)) }}">
							</div>
							Minimum is 1 and maximum is 4
						</div>

						<div class="form-group" id="inHold1">
							<label for="inHold1Text" class="col-xs-4 control-label">Hold 1</label>
							<div class="col-xs-8">
								<input class="form-control" type="text"
								name="inHold1Text" id="inHold1Text"
								value="{{ count(explode(",",$activity->extra1))>0 ? explode(",",$activity->extra1)[0] : "" }}"
								placeholder="1"
								onkeyup="updateHoldPlaceholder()">
							</div>
						</div>

						<div class="form-group" id="inHold2">
							<label for="inHold2Text" class="col-xs-4 control-label">Hold 2</label>
							<div class="col-xs-8">
								<input class="form-control" type="text"
								name="inHold2Text" id="inHold2Text"
								value="{{ count(explode(",",$activity->extra1))>1 ? explode(",",$activity->extra1)[1] : "" }}"
								placeholder="2"
								onkeyup="updateHoldPlaceholder()">
							</div>
						</div>

						<div class="form-group" id="inHold3">
							<label for="inHold3Text" class="col-xs-4 control-label">Hold 3</label>
							<div class="col-xs-8">
								<input class="form-control" type="text"
								name="inHold3Text" id="inHold3Text"
								value="{{ count(explode(",",$activity->extra1))>2 ? explode(",",$activity->extra1)[2] : "" }}"
								placeholder="3"
								onkeyup="updateHoldPlaceholder()">
							</div>
						</div>

						<div class="form-group" id="inHold4">
							<label for="inHold4Text" class="col-xs-4 control-label">Hold 4</label>
							<div class="col-xs-8">
								<input class="form-control" type="text"
								name="inHold4Text" id="inHold4Text"
								value="{{ count(explode(",",$activity->extra1))>3 ? explode(",",$activity->extra1)[3] : "" }}"
								placeholder="4"
								onkeyup="updateHoldPlaceholder()">
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
				</div>
			</div>

			<br/>
			<br/>

			<div class="row">
				<div class="col-xs-12 bg-info">
					<h3>Image</h3>

					@include('content.activity.imagecover')
				</div>
			</div>

			<br/>
			<br/>

			<div class="row">
				<div class="col-xs-12 bg-info">
					<h3>Animation</h3>
					@include('content.activity.animation')
				</div>
			</div>

		</div>

		<div class="col-xs-6">
			<h3>Preview</h3>

			<div class="panel panel-default">
		    <div class="panel-body">

					<div class="" id="preview">
						<div class="text-center" id="pTitle">
							&lt;&lt; Title &gt;&gt;
						</div>
						<div class="text-center" id="pText">
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
								src="{{ is_null($activity->image_placeholder) || $activity->image_placeholder==="" ? '' : route('getimagebyid', $activity->image_placeholder) }}"
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

<div class="modal fade" id="modalSelectImage" tabindex="-1" role="dialog" aria-labelledby="modalSelectImageLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<span aria-hidden="true">&times;</span>
				</button>
        <h4 class="modal-title" id="modalSelectImageLabel">Modal title</h4>
      </div>
      <div class="modal-body">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<form class="form-horizontal" id="imageUploadForm" name="imageUploadForm">
								<fieldset>
					        <legend>Upload Image</legend>
									<div class="form-group">
				            <label for="imagefield" class="col-md-2 control-label">File</label>
				            <div class="col-md-10">
											<input type="file" class="form-control" id="imagefield" name="imagefield" accept="image/*" required="required">
				            </div>
					        </div>
									<div class="form-group">
				            <div class="col-lg-10 col-lg-offset-2">
			                <button type="button" id="btnUploadImage" class="btn btn-primary" onclick="uploadImageToServer()">Upload</button>
				            </div>
					        </div>
								</fieldset>
							</form>
						</div>
          </div>

					<div class="row" id="img-row">
          </div>
				</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Use</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">

	$('#modalSelectImage').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var recipient = button.data('box-number') // Extract info from data-* attributes
	  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		loadImages();

	  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
	  var modal = $(this);
	  // modal.find('.modal-title').text('Image for box ' + recipient);
		$("#modalSelectImageLabel").html('Image for box ' + recipient)
	  // modal.find('.modal-body input').val(recipient);
	});

	function loadImages() {
		$.ajax({
		  method: "GET",
		  url: "{{ route('get_all_image') }}",
		})
	  .done(function( images ) {
	    console.log(images);
			var output = "";
			for (var i = 0; i < images.length; i++) {
				var image = images[i];
				output += "<div class='col-md-3 aaa' id='divImg"+image.id+"' onclick='hilight("+image.id+")'>";
				output += '<img src="'+image.image_path+'" class="img-responsive img-thumbnail">';
				output += "</div>";
			}
			$("#img-row").html(output);
	  });
	}

	function hilight(id) {
		$(".aaa").removeClass("bg-danger");
		$("#divImg"+id).addClass("bg-danger");
		console.log(id);
	}

	function setSelectedImage() {

	}

	function uploadImageToServer() {
		if ( $("#imagefield").val()==='' ) {
			return;
		}
		$("#btnUploadImage").attr("disabled","disabled");
		var form = $("#imageUploadForm");
		var data = new FormData(form[0]);
		$.ajax({
			url : "{{ route('addWithResponse') }}",
			method : 'POST',
			data	: data,
			processData: false,
			contentType: false
		})
		.done(function( result ) {
			if ( result.result==='success' ) {
				$('#imageUploadForm')[0].reset();
				// console.log(result);

				loadImages();
				$("#btnUploadImage").removeAttr("disabled");
			} else if ( result.result==='unsuccess') {
				alert(result.action);
				$("#btnUploadImage").removeAttr("disabled");
			}
		})
		.fail(function() {
			alert( "error" );
		});

	}

	function updateTitle() {
		var text = $("#inTitle").val() !== "" ? $("#inTitle").val() : "&lt;&lt; Title &gt;&gt;" ;
		$("#pTitle").html(text);
	}

	function updateText() {
		if ( $("#inText").val() === "" ) {
			$("#pText").html("&lt;&lt; Text &gt;&gt;");
			$("#pHold").html("&lt;&lt; Hold &gt;&gt;");
		} else {
			var arrText = $("#inText").val().split(",");
			var output = "";
			for (var i = 0; i < arrText.length; i++) {
				output += "<div class='pepcustom' id='pepcustom"+(i+1)+"'>"+arrText[i]+"</div>";
			}
			$("#pText").html(output);
			updateTextOption();
		}
	}

	function updateNumberOfObject() {
		var number = parseInt($("#inText").val());
		if ( isNaN(number) || number<1 || number>6) {
			return;
		}

		for (var i = 1; i <= 6; i++) {
			if ( i<=number ) {
				$('#inObject'+i).show();
			} else {
				$('#inObject'+i).hide();
			}

		}
	}

	function updateNumberOfHold() {
		var number = parseInt($("#inNumberOfHold").val());
		if ( isNaN(number) || number<1 || number>4) {
			return;
		}

		var holds = "";
		for (var i = 0; i < number; i++) {
			holds += "<div class='holdcustom' id='pHold"+(i+1)+"'>";
			holds += "<div id='pPlaceholderHold"+(i+1)+"'></div>";
			holds += "<div id='pMemberHold"+(i+1)+"_1'></div>";
			holds += "<div id='pMemberHold"+(i+1)+"_2'></div>";
			holds += "<div id='pMemberHold"+(i+1)+"_3'></div>";
			holds += "<div id='pMemberHold"+(i+1)+"_4'></div>";
			holds += "<div id='pMemberHold"+(i+1)+"_5'></div>";
			holds += "<div id='pMemberHold"+(i+1)+"_6'></div>";
			holds += "</div>";
		}
		$("#pHold").html(holds);

		updateHoldPlaceholder();

	}

	function updateHoldPlaceholder() {
		var number = parseInt($("#inNumberOfHold").val());
		if ( isNaN(number) || number<1 || number>4) {
			return;
		}

		$('#inHold1').hide();
		$('#inHold2').hide();
		$('#inHold3').hide();
		$('#inHold4').hide();

		for (var i = 1; i <= number; i++ ) {
			$('#inHold'+i).show();
			$('#pPlaceholderHold'+i).html( $('#inHold'+i+'Text').val() );
		}

		updateTextOption();
	}

	function updateTextOption() {
		var numberOfOption = $("#inText").val().split(",").length;
		for (var i = 1; i <= numberOfOption; i++) {
			$('#pepcustom'+i).popover('destroy')
			var options = {
				container: 'body',
				placement: 'auto top',
				content: getContent(i),
				html: true,
			};
			$('#pepcustom'+i).popover(options);
		}
	}

	function getContent(id) {
		var out = "";
		var number = parseInt($("#inNumberOfHold").val());
		if ( isNaN(number) || number<1 || number>4) {
			return out;
		}

		for (var i = 1; i <= number; i++) {
			var holdText = $('#inHold'+i+'Text').val();
			var text = $('#inHold'+id).text();
			var thisId = text+'Op'+i;
			out += '<label><input ';
			out += 'type="radio" ';
			out += 'id="'+thisId+'" ';
			out += 'name="dd" ';
			out += 'value="'+holdText+'" ';
			out += 'data-text="'+text+'" ';
			out += 'onclick="addToMenber(\''+id+'\',\''+i+'\')" ';
			out += '>';
			out += ' '+holdText;
			out += '</label><br/>';
		}
		return out;
	}

	function addToMenber(textId, memberHoldId) {
		// console.log('textId: '+textId);
		// console.log('holdId: '+memberHoldId);
		// clear all old
		for (var i = 1; i <= 4; i++) {
			$('#pMemberHold'+i+'_'+textId).text('');
		}

		// add to member
		var text = $('#pepcustom'+textId).text();
		$('#pMemberHold'+memberHoldId+'_'+textId).text(text);
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
		updateNumberOfHold();
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
		var extra1 = "";
		var extra2 = parseInt($("#inNumberOfHold").val());

		// make extra1
		for (var i = 1; i <= extra2; i++) {
			extra1 += $('#inHold'+i+'Text').val();
			extra1 += i===extra2 ? "" : "," ;
		}

		// make extra2
		var arr = [];
		for (var i = 0; i < parseInt($("#inNumberOfHold").val()); i++) {
			var member = {};
			member.head = $('#pPlaceholderHold'+(i+1)).text();
			member.number = i+1;
			member.child1 = $('#pMemberHold'+(i+1)+'_1').text();
			member.child2 = $('#pMemberHold'+(i+1)+'_2').text();
			member.child3 = $('#pMemberHold'+(i+1)+'_3').text();
			member.child4 = $('#pMemberHold'+(i+1)+'_4').text();
			member.child5 = $('#pMemberHold'+(i+1)+'_5').text();
			member.child6 = $('#pMemberHold'+(i+1)+'_6').text();

			arr.push(member);
		}

		var data = {
			activity_id : {{ $activity->id }},
			activity_type_id : {{ $activity->activity_type_id}},
			inTitle : inTitle,
			inText : inText,
			inHint : inHint,
			extra1 : extra1,
			extra2 : JSON.stringify(arr)
		};

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
				document.getElementById("inTitle").defaultValue = inTitle;
				document.getElementById("inText").defaultValue = inText;
				document.getElementById("inHint").defaultValue = inHint;
			}
		})
		.fail(function() {
			alert( "error" );
		});
	}

	function updateMember() {
		var phpData = JSON.parse({!! json_encode($activity->extra2) !!});
		// console.log(phpData);
		if ( phpData==null ) {
			return;
		}
		for (var i = 0; i < phpData.length; i++) {
			$('#pMemberHold'+(i+1)+'_1').text(phpData[i].child1);
			$('#pMemberHold'+(i+1)+'_2').text(phpData[i].child2);
			$('#pMemberHold'+(i+1)+'_3').text(phpData[i].child3);
			$('#pMemberHold'+(i+1)+'_4').text(phpData[i].child4);
			$('#pMemberHold'+(i+1)+'_5').text(phpData[i].child5);
			$('#pMemberHold'+(i+1)+'_6').text(phpData[i].child6);
		}
	}

	// check data
	updateInformation();

	updateMember();

</script>

@endsection
