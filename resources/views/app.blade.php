<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<meta name="description" content="A Platform-Independent Framework for Authoring and Monitoring Interactive Contents on Tablets">
	<link rel='author' href='https://plus.google.com/u/0/+SiwawesWongcharoen'/>

	<!-- Facebook Open Graph-->
	<meta property='og:title' content='EDU App'/>
	<meta property='og:type' content='website'/>
	<meta property='og:description' content='A Platform-Independent Framework for Authoring and Monitoring Interactive Contents on Tablets'/>

	<!-- Twitter -->
	<meta name='twitter:card' content='summary'>
	<meta name='twitter:title' content='EDU App'>
	<meta name='twitter:description' content='A Platform-Independent Framework for Authoring and Monitoring Interactive Contents on Tablets'>

	<title>EDU App</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<!-- Optional theme -->

	<!-- Material Design for Bootstrap -->
  <link href="{{ asset('/css/roboto.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/material-fullpalette.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/ripples.min.css') }}" rel="stylesheet">

	<!-- Dropdown.js -->
  <link href="//cdn.rawgit.com/FezVrasta/dropdown.js/master/jquery.dropdown.css" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>

	<!-- Material Design for Bootstrap -->
  <script src="{{ asset('/js/material.min.js') }}"></script>
  <script src="{{ asset('/js/ripples.min.js') }}"></script>

	<!-- include BlockUI -->
	<script src="{{ asset('/js/jquery.blockUI.js') }}"></script>

	<!-- include jQuery.tipsy plugin -->
	<script src="{{ asset('/js/jquery.tipsy.js') }}"></script>

	@yield('headExtend')

	<style>
		body { padding-top: 70px; }
		@yield('styleextend')
	</style>
</head>
<body>


  <script>
		$(document).ready(function() {
      // This command is used to initialize some elements and make them work properly
      $.material.init();

			@yield('jsReadyExtend')
    });

		$.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  </script>


	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('store') }}">EDU App</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li {{ Request::is('store*') || Request::is('/') ? ' class=active' : '' }}>
						<a href="{{ url('store') }}" aria-label="Left Align">
							<span class="glyphicon glyphicon-book" aria-hidden="true"></span>
							Store
						</a>
					</li>
					@if ( Request::is('store*') || Request::is('/') )
					<li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<span class="glyphicon glyphicon-th" aria-hidden="true"></span>
							Categories
							<span class="caret"></span>
						</a>
	          <ul class="dropdown-menu" role="menu">
							@foreach ($categories as $category)
	            	<li><a href="{{ route('categoryById', $category->id) }}">{{ $category->name }}</a></li>
							@endforeach
	          </ul>
	        </li>
					@endif

					@if ( !Auth::guest()  )
						@if ( Auth::user()->isTeacher() )
						<li class="dropdown {{ Request::is('contents/*') ? 'active' : '' }}">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
								Authoring Tools
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ route('newContent') }}">New Content</a></li>
								<li class="divider"></li>
								<li><a href="{{ route('myContents') }}">My Contents</a></li>
							</ul>
						</li>

						<li class="dropdown {{ Request::is('monitor/*') ? 'active' : '' }}">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
								Monitoring Tools
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Real time</a></li>
								<li class="divider"></li>
								<li><a href="#">By History</a></li>
							</ul>
						</li>

						@endif
						@if ( Auth::user()->isAdmin() )

						<li class="dropdown {{ Request::is('admin/*') ? 'active' : '' }}">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
								Admin
								<span class="caret"></span>
							</a>
		          <ul class="dropdown-menu" role="menu">
								<li><a href="{{ route('adminHome') }}">Dashboard</a></li>
								<li class="divider"></li>
		            <li><a href="{{ route('userList') }}">Users</a></li>
								<li><a href="{{ route('schoolList') }}">Schools</a></li>
								<li><a href="{{ route('categoryList') }}">Categories</a></li>
		          </ul>
		        </li>

						@endif
					@endif
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if ( Auth::guest() )
						<li>
							<a href="{{ url('/auth/login') }}">
								<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
								Login
							</a>
						</li>
						<li>
							<a href="{{ url('/auth/register') }}">
								<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
								Register
							</a>
						</li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
								{{ Auth::user()->type }}: {{ Auth::user()->name }} <span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ route('histories') }}">History</a></li>
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>


	@if ( Request::is('store') || Request::is('/') || Request::is('store/category*'))
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="panel panel-default">
				    <div class="panel-body">

							<form class="form-inline" action="">
								<div class="form-group">
									<label class="sr-only" for="keysearch">Search</label>
									<input type="text" class="form-control floating-label" name="keysearch" placeholder="Search" size="50" value="{{ Input::has('keysearch') ? Input::get('keysearch') : '' }}">
								</div>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<button type="submit" class="btn btn-primary">
									<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
								</button>
								<a class="btn btn-primary btn-flat" href="javascript:void(0)">
									Advance
								</a>
							</form>

				    </div>
					</div>
				</div>
			</div>
		</div>
	@endif

	@yield('content')


	@if ( !Request::is('play*') )
		<nav class="navbar navbar-default navbar-static-buttom">
			<div class="container">
				<p class="navbar-text">
					Master Thesis:
					<strong>A Platform-Independent Framework for Authoring and Monitoring Interactive Contents on Tablets</strong><br/>
					Developed by
					<a href="mailto:siwawesw55@email.nu.ac.th" class="navbar-link" target="_top">Siwawes Wongcharoen</a>,
					<a href="mailto:jaratsrir@nu.ac.th" class="navbar-link" target="_top">Jaratsri Rungrattanaubol*</a> and
					<a href="mailto:antonyh@nu.ac.th" class="navbar-link" target="_top">Antony Harfield</a><br/>
					Department of Computer Science and Information Tecnology,
					Faculty of Science, Naresuan Univesity, Phitsanulok, Thailand
				</p>

				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="{{ url('about') }}">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							About
						</a>
					</li>
					<li>
						<a href="{{ url('contact') }}">
							<span class="glyphicon glyphicon-send" aria-hidden="true"></span>
							Contact
						</a>
					</li>
				</ul>
			</div>
		</nav>
	@endif


	<!-- eneble block ui while ajax-->
	@if ( !Request::is('play*') )
	<script type="text/javascript">
		$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
	</script>
	@endif

	<!-- Google Analytics -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-40963799-4', 'auto');
	  ga('send', 'pageview');
	</script>

</body>
</html>
