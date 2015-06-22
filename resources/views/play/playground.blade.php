@extends('app')

@section('headExtend')

	<script src="{{ asset('/js/jquery.pep.js') }}"></script>
	<script src="{{ asset('/js/extend.array.js') }}"></script>

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
	</style>

	<link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}">

	<script type="text/javascript">
		activityCount = {{ count($history->content->activities) }};
		currentActivityIndex = 0;
		activityIds = [{{ implode(",",$activityIdByOrders) }}];
		activityOrder = [{{ $history->activity_order }}];
		activityJson = null;
		var documentHeight = 0;
    var documentWidth = 0;
    var currentOptionTrueArr;
    var currentHold;
    var currentHoldObj;
    var currentFocusPep;
    var currentFocusPepObj;
	</script>
@endsection

@section('jsReadyExtend')
	// for resize screen
	documentHeight = $(document).height();
  documentWidth = $(document).width();

	console.log("activityIds: "+activityIds.toString());
	loadActivities({{ $history->content->id }});
@endsection

@section('content')

<script type="text/javascript">
	function nextActivity() {
		currentActivityIndex++;
		if (currentActivityIndex<activityCount) {
			// load nextActivity();
			// loadActivity(activityIds[currentActivityIndex]);
			renderActivity(activityJson[(parseInt(activityOrder[currentActivityIndex])-1)]);
		} else {
			// finish();
			alert("End");
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
			// console.log("load activity id:"+(parseInt(activityOrder[currentActivityIndex])-1));
			// console.log(activityJson);
			// console.log(activityJson[(parseInt(activityOrder[currentActivityIndex])-1)]);
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

    var numberOfPep = activityJson[currentActivityIndex].content.option.length
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
    var numberOfPep = activityJson[currentActivityIndex].content.option.length;
    var margin = 100/(numberOfPep+1);
    for (i=0; i<numberOfPep; i++) {
      // $(".pep.qz"+(i+1)).css({"top":$(".droppable.hz"+(i+1)).position().top-120});
      $(".pep.qz"+(i+1)).css({"top":"20%"});
      $(".pep.qz"+(i+1)).css({"left":(i*margin+10)+"%"});

    }
    track("reset","pep");
    currentHold = [];
    currentHoldObj = [];
  }

	function renderActivity(activity) {
		console.log("render activity id:"+activity.id);
		console.log(activity);

		// track
    track("activity",activity.id);

		currentOptionTrueArr = activity.content_arr;
		currentHold = [];
    currentHoldObj = [];

		switch (activity.activity_type_id) {
			case "1":
				renderActivityType1(activity);
				break;
			default:
				console.log("Can not render activity");
		}
	}

	function renderActivityType1(activity) {
		$('#pTitle').html(activity.title);
		$('#pText').html(activity.shuffled_content);
		$('#pHint').html(activity.placeholder);
		if ( activity.image_placeholder!=null ) {
			$('#pImage').attr('src', activity.image_path);
		} else {
			$('#pImage').attr('src', "");
		}

		if (activity.content !== null) {
			makeDrop(activity);
	    makePep(activity);
		}

	}

	function makePep(activity) {
		console.log("makePep");
		var output="";

    // set data
    for (i=0; i<activity.shuffled_content.length; i++) {
      output += "<div class='pep qz"+(i+1)+"'";
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
      $(".pep.qz"+(i+1)).css({"top":"20%"});
      $(".pep.qz"+(i+1)).css({"left":""+(i*margin+10)+"%"});
      $(".pep.qz"+(i+1)).css({"border":"1"});
      $(".pep.qz"+(i+1)).css({"padding":"10px"});
      $(".pep.qz"+(i+1)).html(activity.shuffled_content[i]);
    }

    activatePep();
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
        handleCentering(ev, obj);
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
      track("on",$parent.context.innerHTML);
      updateHold("on", $parent.context.innerHTML)
      updateHoldObj("on", $parent.context.innerHTML)

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
  }

  function logOnMouseDown(obj) {
    // console.log("choose "+ obj.innerHTML);

    currentFocusPep = obj.innerHTML;
    currentFocusPepObj = obj;
    updateHold("choose",obj.innerHTML);
    updateHoldObj("choose",obj.innerHTML);

    // track
    track("choose",obj.innerHTML);
  }


	function track(action, detail) {
    var now = new Date();
    now = now.getFullYear() + '-' +
      ('00' + (now.getMonth()+1)).slice(-2) + '-' +
      ('00' + now.getDate()).slice(-2) + ' ' +
      ('00' + now.getHours()).slice(-2) + ':' +
      ('00' + now.getMinutes()).slice(-2) + ':' +
      ('00' + now.getSeconds()).slice(-2);

		console.log("action:"+action+" detail:"+detail);

    // $.ajax({
    //   type: "POST",
    //   url: "observe_add.php",
    //   data: { student_name: studentName,
    //     question_id: jsonData.pages[currentPage-1].question_id,
    //     access_id: accessId,
    //     action: action,
    //     detail: detail,
    //     action_at: now,
    //     action_sequence_number: sequenceNumber++ }
    // })
    // .done(function( msg ) {
    //   console.log( "Data Saved: " + msg.toString() );
    // })
    // .fail(function( msg ) {
    //   console.log( "error: " + msg.toString() );
    // });
  }

	function updateHold(action, detail) {
    if ( action=="on" ) {
      mDetail = parseInt(detail);
      currentHold[mDetail-1] = currentFocusPep;
    } else if ( action=="choose" ){
      var index=currentHold.indexOf(detail);
      if ( index!=-1 ) {
        currentHold[index] = "";
      }
    }
    console.log("currentHold:"+currentHold.toString());
    console.log("currentOptionTrueArr:"+currentOptionTrueArr.toString());
    if ( currentHold.equals(currentOptionTrueArr) ) {
      console.log("true");
      // $('#simple-dialog').modal('show');
    }
  }

  function updateHoldObj(action, obj) {
    if ( action=="on" ) {
      mDetail = parseInt(obj);
      currentHoldObj[mDetail-1] = currentFocusPepObj;
    } else if ( action=="choose" ){
      var index=currentHoldObj.indexOf(currentFocusPepObj);
      if ( index!=-1 ) {
        currentHoldObj[index] = "";
      }
    }
    var cString = "";
    for ( k=0; k<currentHoldObj.length; k++ ) {
      if ( typeof currentHoldObj[k]==="undefined") {
        cString += "" + ",";
      } else {
        cString += currentHoldObj[k].innerHTML + ",";
      }
    }
    cString = cString.substr(0, cString.length-1);
    console.log("currentHoldObj:"+cString);
    console.log("currentOptionTrueArr:"+currentOptionTrueArr.toString());
    if ( cString === currentOptionTrueArr.toString() ) {
      console.log("true obj");
      //$('#simple-dialog').modal('show');
    }
  }

</script>

<div class="container" style="height:100%">

	<div class="row" id="preview" style="height:100%">

		<div class="text-center" style="height:15%">
			<h1><span id="pTitle"></span></h1>
		</div>

		<div class="text-center text-uppercase" id="pText" style="height:15%; visibility: hidden;">

		</div>

		<div class="col-xs-6" style="height:50%">
			<div class="text-center">
				Hint:<br/>
				<span id="pHint"></span>
			</div>
		</div>

		<div class="col-xs-6 text-center" style="height:50%">
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

<div class="btn-next" id="btnNext">
	<a href="javascript:nextActivity()" class="btn btn-danger btn-fab btn-raised mdi-content-forward"></a>
</div>
@endsection
