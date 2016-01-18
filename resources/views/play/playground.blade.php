@extends('app')

@section('headExtend')

	<!-- prefetch images -->
	@foreach ($history->content->activities as $activity)
		@if( !is_null($activity->image_placeholder) )
			<link rel="prefetch" href="{{ route('getimagebyid', $activity->image_placeholder) }}">
		@endif
	@endforeach

	<style>
		.btn-next {
			position: fixed;
	    bottom: 5%;
	    right: 5%;
		}

		body {
    	height: 100vh;
		}

		.image-preview {
			max-width: 100%;
			max-height: 100%;
		}

		.result1 {
			/*display: none;*/
			background-color: rgba(224, 242, 241, .8);

			position: fixed;
	    top: 0px;
	    right: 0px;
			width: 100%;
			height: 100%;
			z-index: -100;

			text-align: center;
		}

		.text-in-result {
			top: 20%;
		  vertical-align: middle;
		}

		@-webkit-keyframes pulse {
			from {
				opacity: 0.0;
				font-size: medium;
			}
			to {
				opacity: 1.0;
				font-size: xx-large;
			}
		}

		.bringToTop {
			z-index: 2000;
		}

		.anim1 {
			animation: pulse 2s ease-in-out 0s 1 normal forwards;
			-webkit-animation: pulse 2s ease-in-out 0s 1 normal forwards;
			-webkit-animation-name: pulse;
		  -webkit-animation-duration: 2s;
		  -webkit-animation-iteration-count: 1;
		  -webkit-animation-timing-function: ease-in-out;
		  /*-webkit-animation-direction: alternate;*/
			-webkit-animation-direction: normal;
			-webkit-animation-fill-mode:forwards;
		}

		.anim2 {
			animation: pulse 2s ease-in-out 0s 1 normal forwards;
			-webkit-animation: pulse 2s ease-in-out 0s 1 normal forwards;
		  -webkit-animation-name: pulse;
		  -webkit-animation-duration: 2s;
		  -webkit-animation-iteration-count: 1;
		  -webkit-animation-timing-function: ease-in-out;
		  /*-webkit-animation-direction: alternate;*/
			-webkit-animation-direction: normal;
			-webkit-animation-fill-mode:forwards;
		}

		.anim3 {
			animation: pulse 2s ease-in-out 0s 1 normal forwards;
			-webkit-animation: pulse 2s ease-in-out 0s 1 normal forwards;
		  -webkit-animation-name: pulse;
		  -webkit-animation-duration: 2s;
		  -webkit-animation-iteration-count: 1;
		  -webkit-animation-timing-function: ease-in-out;
		  /*-webkit-animation-direction: alternate;*/
			-webkit-animation-direction: normal;
			-webkit-animation-fill-mode:forwards;
		}

		.image-option-preview {
			max-width: 120px;
			max-height: 120px;
		}
	</style>

	<link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}">

	<script src="{{ asset('/js/jquery.pep3.js') }}"></script>
	<script src="{{ asset('/js/extend.array.js') }}"></script>
	<script src="{{ asset('/js/extend.compare.js') }}"></script>

	{{-- socket.io --}}
	{{-- <script src="{{ Request::server("SERVER_NAME") }}:8081/socket.io/socket.io.js"></script> --}}
	{{-- <script src="http://localhost:8081/socket.io/socket.io.js"></script> --}}
	{{-- <script src="{{ asset('/socket.io/socket.io.js') }}"></script> --}}
	{{-- <script src="https://cdn.socket.io/socket.io-1.4.3.js"></script> --}}

	<script type="text/javascript">
		activityCount = {{ count($history->content->activities) }};
		currentActivityIndex = 0;
		activityIds = [{{ implode(",",$activityIdByOrders) }}];
		activityOrder = [{{ $history->activity_order }}];
		activityJson = null;
		var currentActivity = null;
		var documentHeight = 0;
    var documentWidth = 0;
    var currentOptionTrueArr;
    var currentHold;
    var currentHoldObj;
    var currentFocusPepObj;
		var sequenceNumber = 0;
		var currentActivityId = 0;

		var isPepInDropable = false;
		var focusPepText = "";
		var focusDropText = "";

		function launchIntoFullscreen(element) {
			$("#pText").hide();
			$("#txt-hint").show();
			$("#pImage").show();

			var doc = window.document;
		  var docEl = doc.documentElement;

			var requestFullScreen = docEl.requestFullscreen
				|| docEl.mozRequestFullScreen
				|| docEl.webkitRequestFullScreen
				|| docEl.msRequestFullscreen;

			if (requestFullScreen != undefined) {
				requestFullScreen.call(docEl);
			}

			loadActivities({{ $history->content->id }});
		}

		// exit fullscreen
		function exitFullscreen() {
			var doc = window.document;
		  var docEl = doc.documentElement;

			var cancelFullScreen = doc.exitFullscreen
				|| doc.mozCancelFullScreen
				|| doc.webkitExitFullscreen
				|| doc.msExitFullscreen;

			if (cancelFullScreen != undefined) {
				cancelFullScreen.call(doc);
			}
		}
	</script>
@endsection

@section('jsReadyExtend')
	// for resize screen
	documentHeight = $(document).height();
  documentWidth = $(document).width();

	console.log("activityIds: "+activityIds.toString());

	var startData = {
		content_id: {{ $history->content->id }},
		activityIds : "activityIds.toString()",
		action : "start_content",
		detail : activityIds.toString(),
		userName : "{{ Auth::user()->name }}",
		userId : "{{ Auth::user()->id }}"
	};
	////
	$.ajax({
		url: "http://{{ Request::server("SERVER_NAME") }}:8081/monitor",
		// jsonp: "callback",
		dataType: "jsonp",
		data: startData
	})
	.done(function( msg ) {
		console.log( "Data Saved: " + msg.toString() );
		console.log( msg );
	})
	.fail(function( msg ) {
		console.log( "error: " + msg.toString() );
		console.log( msg );
	});

	// loadActivities({{ $history->content->id }});
@endsection

@section('content')

<script type="text/javascript">
	function playSound(element) {
		//starts playing
		element.trigger('play');
	}

	function stopSound(element) {
		//pause playing
	  element.trigger('pause');
	  //set play time to 0
	  element.prop("currentTime",0);
	}
	function beforePerformNextActivity() {
		// correct/incorrect logic
		var cString = checkHoldObj();
		if ( currentActivity.activity_type_id === "2" ) {
			cString = JSON.stringify(currentHoldObj);
			track("answer_correct",JSON.stringify(currentOptionTrueArr).toString());
		}
		console.log("beforePerformNextActivity");
		console.log(cString);
		console.log(JSON.stringify(currentOptionTrueArr).toString());
		track("answer",cString.toString());
		if ( currentActivity.activity_type_id === "2" ) {
			cString = JSON.stringify(currentHoldObj);
			console.log("check");
			console.log(cString.toString());
			console.log(JSON.stringify(currentOptionTrueArr).toString());
			console.log(deepCompare(JSON.parse(cString), currentOptionTrueArr));
			if ( deepCompare(JSON.parse(cString), currentOptionTrueArr) ) {
				// correct answer
				activateEndCorrectAnswerAnimation();
	    } else {
				// incorrect answer
				activateEndIncorrectAnswerAnimation();
			}
		} else {
			if ( cString.toString() === currentOptionTrueArr.toString() ) {
				// correct answer
				activateEndCorrectAnswerAnimation();
	    } else {
				// incorrect answer
				activateEndIncorrectAnswerAnimation();
			}
		}
	}

	function activateEndCorrectAnswerAnimation() {
		var className = "";
		var soundId = "";
		switch (activityJson[currentActivityIndex].correct_animation) {
			case "1":
				className = "anim1";
				soundId = "#correctSound1";
				break;
			case "2":
				className = "anim2";
				soundId = "#correctSound2";
				break;
			case "3":
				className = "anim3";
				soundId = "#correctSound3";
				break;
			default:
				console.log("Can not render activity");
		}

		$("#correctAnswer").addClass("bringToTop");
		$("#correctTextAnswer").addClass(className);
		playSound($(soundId));
	}

	function deactivateEndCorrectAnswerAnimation() {
		var className = "";
		var soundId = "";
		switch (activityJson[currentActivityIndex].correct_animation) {
			case "1":
				className = "anim1";
				soundId = "#correctSound1";
				break;
			case "2":
				className = "anim2";
				soundId = "#correctSound2";
				break;
			case "3":
				className = "anim3";
				soundId = "#correctSound3";
				break;
			default:
				console.log("Can not render activity");
		}

		$("#correctAnswer").removeClass("bringToTop");
		$("#correctTextAnswer").removeClass(className);
		stopSound($(soundId));
	}

	function activateEndIncorrectAnswerAnimation() {
		var className = "";
		var soundId = "";
		switch (activityJson[currentActivityIndex].incorrect_animation) {
			case "1":
				className = "anim1";
				soundId = "#incorrectSound1";
				break;
			case "2":
				className = "anim2";
				soundId = "#incorrectSound2";
				break;
			case "3":
				className = "anim3";
				soundId = "#incorrectSound3";
				break;
			default:
				console.log("Can not set animation");
		}

		$("#incorrectAnswer").addClass("bringToTop");
		$("#incorrectTextAnswer").addClass(className);
		playSound($(soundId));
	}

	function deactivateEndIncorrectAnswerAnimation() {
		var className = "";
		var soundId = "";
		switch (activityJson[currentActivityIndex].incorrect_animation) {
			case "1":
				className = "anim1";
				soundId = "#incorrectSound1";
				break;
			case "2":
				className = "anim2";
				soundId = "#incorrectSound2";
				break;
			case "3":
				className = "anim3";
				soundId = "#incorrectSound3";
				break;
			default:
				console.log("Can not set animation");
		}

		$("#incorrectAnswer").removeClass("bringToTop");
		$("#incorrectTextAnswer").removeClass(className);
		stopSound($(soundId));
	}

	// main logic when perform next activity
	function nextActivity() {
		// correct/incorrect logic
		beforePerformNextActivity();

		// next activity logic
		// nextActivityLogic();
	}

	function nextActivityLogic() {
		// hide result div
		deactivateEndCorrectAnswerAnimation();
		deactivateEndIncorrectAnswerAnimation();

		// logic
		currentActivityIndex++;
		if (currentActivityIndex<activityCount) {
			// load nextActivity();
			// loadActivity(activityIds[currentActivityIndex]);
			renderActivity(activityJson[(parseInt(activityOrder[currentActivityIndex])-1)]);
		} else {
			// finish();
			// alert("End");

			// exit fullscreen
			exitFullscreen();

			// goto result page
			location.href = "{{ route('scoreByHistory',$history->id) }}";
		}
	}

	function loadActivities(contentId) {
		$.ajax({
		  url: "{{ route('getActivities',"") }}/"+contentId,
			method: "GET"
		})
	  .done(function( result ) {
			// alert( "done "+result.result );
			console.log("load id:"+contentId);
			console.log(result);
			activityJson = result;

			renderActivity(activityJson[(parseInt(activityOrder[currentActivityIndex])-1)]);

	  })
		.fail(function() {
	    alert( "error" );
	  });
	}

	function moveWhenResize() {
    // move pep to new position
    // 1. detect how many pep
    // 2. move pep one by one

    var numberOfPep = $(".pep").length;
		if (numberOfPep===0) {
			return;
		}
    for (i=1; i<=numberOfPep; i++) {
      // read old pos
      var oldTop = $(".pep.qz"+i).position().top;
      var oldLeft = $(".pep.qz"+i).position().left;

      // cal new pos
      var newTop = oldTop * $(document).height() / documentHeight;
      var newLeft = oldLeft * $(document).width() / documentWidth;

      // move to new pos
      $(".pep.qz"+i).css({"top":newTop,"left":newLeft});
    }

    documentHeight = $(document).height();
    documentWidth = $(document).width();
  }

	// reset pep position to init
  function resetPep() {

		var activity = activityJson[(parseInt(activityOrder[currentActivityIndex])-1)];
		switch (activity.activity_type_id) {
			case "1":
				var numberOfPep = $(".pep").length;
		    var margin = 100/(numberOfPep+1);
		    for (i=0; i<numberOfPep; i++) {
		      // $(".pep.qz"+(i+1)).css({"top":$(".droppable.hz"+(i+1)).position().top-120});
		      $(".pep.qz"+(i+1)).css({"top":"20%"});
		      $(".pep.qz"+(i+1)).css({"left":(i*margin+10)+"%"});

		    }
		    track("reset","pep");
		    currentHold = [];
		    currentHoldObj = [];
				checkHoldObj();
				break;
			case "2":
				var numberOfPep = $(".pep").length;
		    var margin = 100/(numberOfPep+1);
		    for (i=0; i<numberOfPep; i++) {
		      // $(".pep.qz"+(i+1)).css({"top":$(".droppable.hz"+(i+1)).position().top-120});
		      $(".pep.qz"+(i+1)).css({"top":"20%"});
		      $(".pep.qz"+(i+1)).css({"left":(i*margin+10)+"%"});

		    }
		    track("reset","pep");
		    currentHold = [];
		    // currentHoldObj = [];
				currentHoldObj = makeClearCurrentHoldObj(currentOptionTrueArr);
				// checkHoldObj();
				break;
			case "5":
			case "6":
				currentHold = [];
				currentHoldObj = defaultAnswerForOprions(activity);

				// reset button
				for (var i = 0; i < activity.extra1.length; i++) {
					if ( $("#option"+i).hasClass("btn-raised") ) {
						$("#option"+i).removeClass("btn-raised");
						$("#option"+i).addClass("btn-flat");
					}
				}

				track("reset","options");
				break;
			default:
				console.log("Can not reset");
		}
  }

	function renderActivity(activity) {
		console.log("render activity id:"+activity.id);
		console.log(activity);

		currentActivity = activity;

		currentActivityId = activity.id;

		// track
    track("start activity",activity.id);


		currentHold = [];
    currentHoldObj = [];

		fabBtnToReset();

		switch (activity.activity_type_id) {
			case "1":
				renderActivityType1(activity);
				currentOptionTrueArr = activity.content_arr;
				break;
			case "2":
				renderActivityType2(activity);
				currentOptionTrueArr = getCurrentOptionTrueArr(JSON.parse(activity.extra2));
				currentHoldObj = makeClearCurrentHoldObj(currentOptionTrueArr);
				// console.log("renderActivityType2");
				// console.log(activity);
				// console.log("currentOptionTrueArr");
				// console.log(currentOptionTrueArr);
				// console.log("currentHoldObj");
				// console.log(currentHoldObj);
				break;
			case "5":
				renderActivityType5(activity);
				currentOptionTrueArr = activity.extra2.split(",");
				break;
			case "6":
				renderActivityType6(activity);
				currentOptionTrueArr = activity.extra2.split(",");
				break;
			default:
				console.log("Can not render activity");
		}
		$(window).resize( moveWhenResize );
	}

	function renderActivityType1(activity) {
		$('#pTitle').html(activity.title);
		$('#pText').html(activity.shuffled_content);
		$('#pHint').html(activity.placeholder);
		if ( activity.image_placeholder!=null ) {
			$('#pImage').attr('src', activity.image_path);
			$('#main_image').show();
			$('#main_content').removeClass('col-xs-12').addClass('col-xs-6');
		} else {
			$('#pImage').attr('src', "");
			$('#main_image').hide();
			$('#main_content').removeClass('col-xs-6').addClass('col-xs-12');
		}

		if (activity.content !== null) {
			makeDrop(activity);
	    makePep(activity);
		}

	}

	function renderActivityType2(activity) {
		$('#pTitle').html(activity.title);
		// $('#pText').html(activity.shuffled_content);
		$('#pHint').html("");
		if ( activity.image_placeholder!=null ) {
			$('#pImage').attr('src', activity.image_path);
			$('#main_image').show();
			$('#main_content').removeClass('col-xs-12').addClass('col-xs-6');
		} else {
			$('#pImage').attr('src', "");
			$('#main_image').hide();
			$('#main_content').removeClass('col-xs-6').addClass('col-xs-12');
		}

		if (activity.content !== null) {
			makeDropType2(activity);
	    makePepType2(activity);
		}

	}

	function renderActivityType5(activity) {
		$('#pTitle').html(activity.title);
		// $('#pHint').html(activity.content);
		if ( activity.image_placeholder!=null ) {
			$('#pImage').attr('src', activity.image_path);
			$('#main_image').show();
			$('#main_content').removeClass('col-xs-12').addClass('col-xs-6');
		} else {
			$('#pImage').attr('src', "");
			$('#main_image').hide();
			$('#main_content').removeClass('col-xs-6').addClass('col-xs-12');
		}

		if (activity.extra1 !== null) {
			makeOptionsImage(activity);
		}

	}

	function renderActivityType6(activity) {
		$('#pTitle').html(activity.title);
		// $('#pHint').html(activity.content);
		if ( activity.image_placeholder!=null ) {
			$('#pImage').attr('src', activity.image_path);
			$('#main_image').show();
			$('#main_content').removeClass('col-xs-12').addClass('col-xs-6');
		} else {
			$('#pImage').attr('src', "");
			$('#main_image').hide();
			$('#main_content').removeClass('col-xs-6').addClass('col-xs-12');
		}

		if (activity.extra1 !== null) {
			makeOptions(activity);
		}

	}

	function getCurrentOptionTrueArr(ansSet) {
		// console.log("ans");
		// console.log(ansSet);
		var newAnsSet = [];

		for (var i = 0; i < ansSet.length; i++) {
			var ans = ansSet[i];
			var newAns = {};
			var members = [];
			if ( ans.child1 !== "" ) {
				members.push(ans.child1);
			}
			if ( ans.child2 !== "" ) {
				members.push(ans.child2);
			}
			if ( ans.child3 !== "" ) {
				members.push(ans.child3);
			}
			if ( ans.child4 !== "" ) {
				members.push(ans.child4);
			}
			if ( ans.child5 !== "" ) {
				members.push(ans.child5);
			}
			if ( ans.child6 !== "" ) {
				members.push(ans.child6);
			}
			if ( ans.child7 !== "" ) {
				members.push(ans.child7);
			}
			if ( ans.child8 !== "" ) {
				members.push(ans.child8);
			}

			newAns.members = members;
			newAns.head = ans.head;

			newAnsSet.push(newAns);
		}

		// console.log(newAnsSet);
		return newAnsSet;
	}

	function makeClearCurrentHoldObj(ansSet) {
		var newAnsSet = [];
		for (var i = 0; i < ansSet.length; i++) {
			var ans = ansSet[i];
			var newAns = {};
			var members = [];

			newAns.members = members;
			newAns.head = ans.head;

			newAnsSet.push(newAns);
		}
		// console.log(newAnsSet);
		return newAnsSet;
	}

	function makeOptionsImage(activity) {
		$("#pepZone").html("");
		$("#dropZone").html("");
		//<a href="javascript:void(0)" class="btn btn-flat btn-primary">Primary</a>
		var options = activity.extra1.split(",");
		var answerOptions = activity.extra2.split(",");
		var output = "<h2>"+activity.content+"</h2>";

		// set default answer
		currentHoldObj = defaultAnswerForOprions(activity);

		for (var i = 0; i < options.length; i++) {
			output += "<a href='javascript:void(0)' ";
			output += "id='option"+i+"' ";
			output += "class='btn btn-flat btn-primary btn-lg' ";
			output += "data-answer='"+answerOptions[i]+"' ";
			output += "data-index='"+i+"' ";
			output += "data-val1='"+options[i]+"' ";
			output += "onclick='toggleOption("+i+")' >";
			// output += options[i];
			output += "<img class='image-option-preview' ";
			output += "src='/imageentry/getbyid/"+options[i]+"' />";
			output += "</a>";
			if ( i!=0 && i%2==1) {
				output += "<br/>";
			}
		}
		$('#pHint').html(output);
	}

	function makeOptions(activity) {
		$("#pepZone").html("");
		$("#dropZone").html("");
		//<a href="javascript:void(0)" class="btn btn-flat btn-primary">Primary</a>
		var options = activity.extra1.split(",");
		var answerOptions = activity.extra2.split(",");
		var output = "<h2>"+activity.content+"</h2>";

		// set default answer
		currentHoldObj = defaultAnswerForOprions(activity);

		for (var i = 0; i < options.length; i++) {
			output += "<a href='javascript:void(0)' ";
			output += "id='option"+i+"' ";
			output += "class='btn btn-flat btn-primary btn-lg' ";
			output += "data-answer='"+answerOptions[i]+"' ";
			output += "data-index='"+i+"' ";
			output += "data-val1='"+options[i]+"' ";
			output += "onclick='toggleOption("+i+")' >";
			output += options[i];
			output += "</a><br/>";
		}
		$('#pHint').html(output);
	}

	function defaultAnswerForOprions(activity) {
		var def = [];
		for (var i = 0; i < activity.extra2.split(",").length; i++) {
			def.push('false');
		}
		return def;
	}

	function toggleOption(i) {
		// console.log(i);
		if ($("#option"+i).hasClass("btn-flat")) {
			$("#option"+i).removeClass("btn-flat");
			$("#option"+i).addClass("btn-raised");

			currentHoldObj[i] = "true";
			track("click", $("#option"+i).attr("data-val1"));
		} else {
			$("#option"+i).removeClass("btn-raised");
			$("#option"+i).addClass("btn-flat");

			currentHoldObj[i] = "false";
			track("click", $("#option"+i).attr("data-val1"));
		}
		// console.log(currentHoldObj);

		// toggle fabBtn if atlast one answer
		var activity = activityJson[(parseInt(activityOrder[currentActivityIndex])-1)];
    if ( currentHoldObj.indexOf("true")>=0 ) {
			// correct anwser
      console.log("full answer");
      //$('#simple-dialog').modal('show');

			// change reset button to next button
			fabBtnToNext();
    } else {
			// incorrect anwser
			// change next button to reset button
			fabBtnToReset();
		}
	}

	function makePep(activity) {
		console.log("makePep");
		var output="";

    // set data
    for (i=0; i<activity.shuffled_content.length; i++) {
      output += "<div class='pep qz"+(i+1)+"'";
			output += " id='pepqz"+(i+1)+"'";
      output += " onmousedown='logOnMouseDown(this)' ";
      output += " ontouchstart='logOnMouseDown(this)' ";
      output += " onmouseup='logOnMouseUp(this)' ";
      output += " ontouchend='logOnMouseUp(this)'>";
      output += "drag me "+(i+1)+"</div>";
    }
    $("#pepZone").html(output);

    // set css
    var margin = 100/(activity.shuffled_content.length+1);
    for (i=0; i<activity.shuffled_content.length; i++) {
      if ( activity.shuffled_content[i]=="A" ||
      activity.shuffled_content[i]=="E" ||
      activity.shuffled_content[i]=="I" ||
      activity.shuffled_content[i]=="O" ||
      activity.shuffled_content[i]=="U" ) {
        $(".pep.qz"+(i+1)).css({"background":"#4CAF50"});
      }
      // $(".pep.qz"+(i+1)).css({"top":$(".droppable.hz"+(i+1)).position().top-120});
      $(".pep.qz"+(i+1)).css({"top":"12%"});
      $(".pep.qz"+(i+1)).css({"left":""+(i*margin+10)+"%"});
      $(".pep.qz"+(i+1)).css({"border":"1"});
      $(".pep.qz"+(i+1)).css({"padding":"10px"});
      $(".pep.qz"+(i+1)).html(activity.shuffled_content[i]);
    }

    activatePep();
	}

	function makePepType2(activity) {
		console.log("makePepType2");
		var output="";
		var content = activity.content.split(",");

    // set data
    for (i=0; i<content.length; i++) {
      output += "<div class='pep qz"+(i+1)+"'";
			output += " id='pepqz"+(i+1)+"'";
      output += " onmousedown='logOnMouseDown(this)' ";
      output += " ontouchstart='logOnMouseDown(this)' ";
      output += " onmouseup='logOnMouseUp(this)' ";
      output += " ontouchend='logOnMouseUp(this)'>";
      output += content[i]+"</div>";
    }
    $("#pepZone").html(output);

		// set css
    var margin = 100/(content.length+1);
    for (i=0; i<content.length; i++) {

      // $(".pep.qz"+(i+1)).css({"top":$(".droppable.hz"+(i+1)).position().top-120});
      $(".pep.qz"+(i+1)).css({"top":"12%"});
      $(".pep.qz"+(i+1)).css({"left":""+(i*margin+10)+"%"});
      $(".pep.qz"+(i+1)).css({"border":"1"});
      $(".pep.qz"+(i+1)).css({"padding":"10px"});
			$(".pep.qz"+(i+1)).css({"width":"auto"});
			$(".pep.qz"+(i+1)).css({"display":"inline-block"});
    }

		activatePepType2();
	}

	function makeDrop(activity) {
		var output="";
    // set data
    for (i=0; i<activity.content.length; i++) {
      output += "<div class='droppable hz"+(i+1)+"'></div>";
    }
    $("#dropZone").html(output);

    // set css
    var margin = 100/(activity.content.length+1);
    for (i=0; i<activity.content.length; i++) {
      $(".droppable.hz"+(i+1)).css({"bottom":"10%"});
      $(".droppable.hz"+(i+1)).css({"left":""+(i*margin+10)+"%"});
      $(".droppable.hz"+(i+1)).css({"border":"1"});
      $(".droppable.hz"+(i+1)).html(i+1);
    }
	}

	function makeDropType2(activity) {
		var drop = activity.extra1.split(",");
		var output="";
    // set data
    for (i=0; i<drop.length; i++) {
      output += "<div class='droppable hz"+(i+1)+"'>"+drop[i]+"</div>";
    }
    $("#dropZone").html(output);

		// set css
    var margin = 100/(drop.length+1);
    for (i=0; i<drop.length; i++) {
      $(".droppable.hz"+(i+1)).css({"bottom":"10%"});
      $(".droppable.hz"+(i+1)).css({"left":""+(i*margin+10)+"%"});
			$(".droppable.hz"+(i+1)).css({"width":""+((100/drop.length)*0.6)+"%"});
      $(".droppable.hz"+(i+1)).css({"border":"1"});
    }
	}

	function activatePepType2() {
		$('.pep').pep({
		  droppable: '.droppable',
		  overlapFunction: function($a, $b) {
		    var rect1 = $a[0].getBoundingClientRect(); // drop
		    var rect2 = $b[0].getBoundingClientRect(); // pep

				var result = (  rect2.left    > rect1.left  &&
		              rect2.right   < rect1.right &&
		              rect2.top     > rect1.top   &&
		              rect2.bottom  < rect1.bottom  );

				isPepInDropable = result | isPepInDropable;
				// isPepInDropable = result;
				// focusPepText = $b[0].innerText;
				if (result) {
					focusDropText = $a[0].innerText;
					// console.log(focusDropText);
					// if ( currentActivity.activity_type_id === "2" && isPepInDropable ) {
					// 	// track
				  //   track("on", focusDropText);
					// 	updateHoldObjType2("on", focusPepText, focusDropText)
					// }
				}

				// console.log($a);
				// console.log($b);
				// console.log(isPepInDropable);

		    return result;
		  }
		})
	}

	function activatePep() {
    $('.pep').pep({
      droppable: ".droppable",
      overlapFunction: false,
      useCSSTranslation: false,
      start: function(ev, obj) {
        obj.noCenter = false;
      },
      drag: function(ev, obj) {
        var vel = obj.velocity();
        var rot = (vel.x)/5;
        rotate(obj.$el, rot)
      },
      stop: function(ev, obj) {
        // handleCentering(ev, obj);
        rotate(obj.$el, 0);
        //for (var key in obj.$container) {
        //	console.log(key);
        //}
        //console.log(obj.$container);
      },
      rest: handleCentering
    });
  }

  function handleCentering(ev, obj) {
    if ( obj.activeDropRegions.length > 0 ) {
      centerWithin(obj);
    }
  }

  function centerWithin(obj) {
    var $parent = obj.activeDropRegions[0];
		var hold = $parent.context.innerHTML;
    var pTop    = $parent.offset().top;
    var pLeft   = $parent.offset().left;
    var pHeight = $parent.outerHeight();
    var pWidth  = $parent.outerWidth();

    var oTop    = obj.$el.offset().top;
    var oLeft   = obj.$el.offset().left;
    var oHeight = obj.$el.outerHeight();
    var oWidth  = obj.$el.outerWidth();

    var cTop    = pTop + (pHeight/2);
    var cLeft   = pLeft + (pWidth/2);


    if ( !obj.noCenter ) {
      //console.log("drop2 "+ obj);
      // console.log("on "+ $parent.context.innerHTML);
      // track
			var focusedPep = obj.$container.context.innerHTML;
			track("focus",obj.$container.context.innerHTML);
      track("on", focusedPep+" on "+hold);
      updateHoldObj("on", hold, document.getElementById(obj.$container.context.id));

      if ( !obj.shouldUseCSSTranslation() ) {
        var moveTop = cTop - (oHeight/2);
        var moveLeft = cLeft - (oWidth/2);
        obj.$el.animate({ top: moveTop, left: moveLeft }, 50);
      } else {
        var moveTop   = (cTop - oTop) - oHeight/2;
        var moveLeft  = (cLeft - oLeft) - oWidth/2;

        // console.log(oTop, oLeft);
        obj.moveToUsingTransforms( moveTop, moveLeft );
      }

      obj.noCenter = true;
      return;
    }

    obj.noCenter = false;
  }

  function rotate($obj, deg) {
    $obj.css({
      "-webkit-transform": "rotate("+ deg +"deg)",
      "-moz-transform": "rotate("+ deg +"deg)",
      "-ms-transform": "rotate("+ deg +"deg)",
      "-o-transform": "rotate("+ deg +"deg)",
      "transform": "rotate("+ deg +"deg)"
    });
  }

	function logOnMouseUp(obj) {
    // console.log("drop "+ obj.innerHTML);

    // track
    track("drop",obj.innerHTML);

		if ( currentActivity.activity_type_id === "2" && isPepInDropable ) {
			// track
	    // track("on", focusDropText);
			// updateHoldObjType2("on", focusPepText, focusDropText);

			var focusPepTextTemp = focusPepText;

			track("on", focusDropText);
			updateHoldObjType2("on", focusPepTextTemp, focusDropText);

			// function delayTrack() {
			// 	track("on", focusDropText);
			// 	updateHoldObjType2("on", focusPepTextTemp, focusDropText);
	    // }

			// setTimeout(delayTrack, 500);
		}
  }

  function logOnMouseDown(obj) {
    // console.log("choose "+ obj.innerHTML);

		// track
		track("choose",obj.innerHTML);

		focusPepText = obj.innerHTML;
    currentFocusPepObj = obj;
		if ( currentActivity.activity_type_id === "2" ) {
			updateHoldObjType2("choose", focusPepText, focusDropText)
		} else {
			updateHoldObj("choose",obj);
		}
  }

	// socket.io
	// var socket = io().connect("{{ Request::server("SERVER_NAME") }}:8081");


	function track(action, detail) {
    var now = new Date();
    now = now.getFullYear() + '-' +
      ('00' + (now.getMonth()+1)).slice(-2) + '-' +
      ('00' + now.getDate()).slice(-2) + ' ' +
      ('00' + now.getHours()).slice(-2) + ':' +
      ('00' + now.getMinutes()).slice(-2) + ':' +
      ('00' + now.getSeconds()).slice(-2);

		;

		console.log("action:"+action+" detail:"+detail);

		var trackData = {
			content_id: {{ $history->content->id }},
			activity_id: currentActivityId,
			history_id: {{ $history->id }},
			action: action,
			action_at: now,
			detail: detail,
			action_sequence_number: sequenceNumber++ };

    $.ajax({
      type: "POST",
      url: "{{ route('trackInteractivity') }}",
      data: trackData
    })
    .done(function( msg ) {
      console.log( "Data Saved: " + msg.toString() );
      console.log( msg );
    })
    .fail(function( msg ) {
      console.log( "error: " + msg.toString() );
      console.log( msg );
    });

		// socket.io
		trackData.userName = "{{ Auth::user()->name }}";
		trackData.userId = "{{ Auth::user()->id }}";
		// socket.emit('monitor_message', trackData);
		$.ajax({
      url: "http://{{ Request::server("SERVER_NAME") }}:8081/monitor",
			// jsonp: "callback",
			dataType: "jsonp",
      data: trackData
    })
    .done(function( msg ) {
      console.log( "Data Saved: " + msg.toString() );
      console.log( msg );
    })
    .fail(function( msg ) {
      console.log( "error: " + msg.toString() );
      console.log( msg );
    });
  }

  function updateHoldObj(action, obj, pep) {
    if ( action=="on" ) {
      mDetail = parseInt(obj);
      currentHoldObj[mDetail-1] = pep;
    } else if ( action=="choose" ){
      var index=currentHoldObj.indexOf(obj);
			// var index=currentHoldObj.indexOf(obj);
			// console.log("index:"+index);
      if ( index!=-1 ) {
        currentHoldObj[index] = "";
      }
    }

		// toggle fabBtn if full length answer
		var cString = checkHoldObj();
    if ( isFullLengthAnswer(cString,currentOptionTrueArr.length) ) {
			// correct anwser
      console.log("full answer");
      //$('#simple-dialog').modal('show');

			// change reset button to next button
			fabBtnToNext();
    } else {
			// incorrect anwser
			// change next button to reset button
			fabBtnToReset();
		}
  }

	function updateHoldObjType2(action, pep, drop) {
		if ( action==="on" ) {
      // add pep to drop member
			for (var i = 0; i < currentHoldObj.length; i++) {
				if (currentHoldObj[i].head === drop) {
					currentHoldObj[i].members.push(pep);
					currentHoldObj[i].members.sort();
				}
			}
    } else if ( action==="choose" ){
      // remove pep from currentHoldObj members
			for (var i = 0; i < currentHoldObj.length; i++) {
				var index = currentHoldObj[i].members.indexOf(pep);
				if ( index !== -1 ) {
					currentHoldObj[i].members.splice(index, 1);
					currentHoldObj[i].members.sort();
				}
			}
    }
		// console.log("updateHoldObjType2");
		// console.log(currentHoldObj);

		// toggle fabBtn if atlast one answer
		var isAnswered = false;
		for (var i = 0; i < currentHoldObj.length; i++) {
			if ( currentHoldObj[i].members.length > 0 ) {
				isAnswered = true;
				break;
			}
		}
		if (isAnswered) {
			// correct anwser
      console.log("full answer");

			// change reset button to next button
			fabBtnToNext();
		} else {
			// incorrect anwser
			// change next button to reset button
			fabBtnToReset();
		}
	}

	function fabBtnToNext() {
		$("#fabBtn")
		.attr('href','javascript:nextActivity()')
		.removeClass("mdi-av-replay")
		.addClass("mdi-content-forward");
	}

	function fabBtnToReset() {
		$("#fabBtn")
		.attr('href','javascript:resetPep()')
		.removeClass("mdi-content-forward")
		.addClass("mdi-av-replay");
	}

	function isFullLengthAnswer(arr, answerLength) {
		if (arr.length != answerLength) {
			return false;
		}
		for ( k=0; k<arr.length; k++ ) {
      if ( typeof arr[k]==="undefined" || arr[k]==="" ) {
        return false;
      }
    }
		return true;
	}

	function checkHoldObj() {
		var cString = [];
    for ( k=0; k<currentHoldObj.length; k++ ) {
      if ( typeof currentHoldObj[k]==="undefined") {
        cString.push("");
      } else if ( typeof currentHoldObj[k]==="string" ) {
      	cString.push(currentHoldObj[k]);
      } else {
				cString.push(currentHoldObj[k].innerHTML);
      }
    }
    // console.log("currentHoldObj:"+currentHoldObj.toString());
		// console.log(currentHoldObj);
		console.log("cString:"+cString);
		console.log(cString);
    console.log("currentOptionTrueArr:"+currentOptionTrueArr.toString());
		console.log(currentOptionTrueArr);
		return cString;
	}

</script>

<div class="container" style="height:100%; background-color:white;">

	<div class="row" id="preview" style="height:100%">

		<div class="text-center" style="height:15%">
		</div>

		<div
		class="text-center text-uppercase"
		id="pText"
		style="height:15%;">
			<button onclick="launchIntoFullscreen();"
			id="btn-fullscreen"
			class="btn btn-primary btn-lg">
				Play Activity
			</button>
		</div>

		<div class="col-xs-6" id="main_content" style="height:50%">
			<div class="text-center" style="height:15%">
				<h2>
					<span id="pTitle">

					</span>
				</h2>
			</div>
			<div class="text-center" id="txt-hint">
				<span id="pHint"></span>
			</div>
		</div>

		<div class="col-xs-6 text-center" id="main_image" style="height:50%;">
			<img
			class="image-preview img-thumbnail"
			id="pImage"
			src=""
			alt="&lt;&lt; Image &gt;&gt;" />
		</div>

		<div class="text-center" id="pHold" style="height:20%; visibility: hidden;">
			&lt;&lt; Hold &gt;&gt;
		</div>

	</div>

</div>

<div id="pepZone"></div>
<div id="dropZone"></div>

<div id="correctAnswer"
	class="result1"
	onclick="nextActivityLogic()"
	ontouchstart="nextActivityLogic()">
	<div>Tab To Continue.</div>
	<div id="correctTextAnswer" class="text-in-result">
		Very Good!
	</div>
</div>

<div id="incorrectAnswer"
	class="result1"
	onclick="nextActivityLogic()"
	ontouchstart="nextActivityLogic()">
	<div>Tab To Continue.</div>
	<div id="incorrectTextAnswer" class="text-in-result">
		Try more!
	</div>
</div>

<div class="" style="visibility: hidden;">
	<audio id="correctSound1">
	  <source
		src="{{ asset('/sounds/FFXIV_Victory_Fanfare.ogg') }}"
		type="audio/mpeg">
	  Your browser does not support the audio tag.
	</audio>
</div>

<div class="" style="visibility: hidden;">
	<audio id="correctSound2">
	  <source
		src="{{ asset('/sounds/d2ef5d_Angry_Birds_Level_Complete_Sound_Effect.mp3') }}"
		type="audio/mpeg">
	  Your browser does not support the audio tag.
	</audio>
</div>

<div class="" style="visibility: hidden;">
	<audio id="correctSound3">
	  <source
		src="{{ asset('/sounds/mario-state-clear.mp3') }}"
		type="audio/mpeg">
	  Your browser does not support the audio tag.
	</audio>
</div>

<div class="" style="visibility: hidden;">
	<audio id="incorrectSound1">
	  <source
		src="{{ asset('/sounds/Sad_Trombone-Joe_Lamb-665429450.mp3') }}"
		type="audio/mpeg">
	  Your browser does not support the audio tag.
	</audio>
</div>

<div class="" style="visibility: hidden;">
	<audio id="incorrectSound2">
	  <source
		src="{{ asset('/sounds/e264ad_Angry_Birds_Level_Failed_Piglets_Sound_Effect.mp3') }}"
		type="audio/mpeg">
	  Your browser does not support the audio tag.
	</audio>
</div>

<div class="" style="visibility: hidden;">
	<audio id="incorrectSound3">
	  <source
		src="{{ asset('/sounds/mario-die.mp3') }}"
		type="audio/mpeg">
	  Your browser does not support the audio tag.
	</audio>
</div>



<div class="btn-next" id="btnNext">
	<a href="javascript:resetPep()"
	class="btn btn-danger btn-fab btn-raised mdi-av-replay"
	id="fabBtn"></a>
</div>

<script type="text/javascript">
	$("#txt-hint").hide();
	$("#pImage").hide();
</script>
@endsection
