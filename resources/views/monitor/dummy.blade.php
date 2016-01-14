@extends('app')

@section('headExtend')


</script>
@endsection

@section('content')

<div class="container">

	<div class="row">
    <button type="button" name="button" onclick="dummy(1)">send</button>
	</div>

</div>

<script type="text/javascript">
	function dummy(num) {
		var startData1 = {
			activityIds : "1, 2",
			action : "start_content",
			userName : "dummy1",
			userId : "1"
		};
		$.ajax({
			url: "http://{{ Request::server("SERVER_NAME") }}:8081/monitor",
			// jsonp: "callback",
			dataType: "jsonp",
			data: startData1
		})
		.done(function( msg ) {
			console.log( "Data Saved: " + msg.toString() );
			console.log( msg );
		})
		.fail(function( msg ) {
			console.log( "error: " + msg.toString() );
			console.log( msg );
		});

		var trackData = {
			content_id: "1",
			activity_id: "1",
			history_id: "1",
			action: "add",
			action_at: new Date().toLocaleString(),
			detail: "A",
			action_sequence_number: 1,
			userName: "dummy1",
			userId: "1"
		};
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
</script>

@endsection
