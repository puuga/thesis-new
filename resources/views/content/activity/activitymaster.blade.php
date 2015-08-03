@extends('app')

@section('content')
<script type="text/javascript">
	function hello() {
		alert('Hello');
	}

	function saveAnimation(activityId) {
		var caOption = $("input[name='caOptions']:checked").val();
		var iaOption = $("input[name='iaOptions']:checked").val();

		// console.log(caOption);
		// console.log(iaOption);

		// ajax
		$.ajax({
			url: "{{ route('updateActivityAnimation') }}",
			method: "POST",
			data: {
				activity_id : activityId,
				correct_animation : caOption,
				incorrect_animation : iaOption
			}
		})
		.done(function( result ) {
			if (result.result==='success') {
				console.log("saveAnimation: success");
			}
		})
		.fail(function() {
			alert( "error" );
		});
	}

	function saveImage() {
		var data = new FormData($("#imageForm")[0]);
		console.log('upload placeholder image');
		console.log(data);
		$.ajax({
			url : "{{ route('addimageentrytoctivity') }}",
			method : 'POST',
			data	: data,
			processData: false,
			contentType: false
		})
		.done(function( result ) {
			if (result.result==='success') {
				console.log("saveImage: success");
			}
		})
		.fail(function() {
			alert( "error" );
		});
	}
</script>

@yield('contentextend')

@endsection
