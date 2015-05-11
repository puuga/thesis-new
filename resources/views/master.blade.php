<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
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

	<style>
		body { padding-top: 70px; }
	</style>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">EDU App</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li {{ Request::is('store*') || Request::is('/') ? ' class=active' : '' }}>
						<a href="{{ url('store') }}" aria-label="Left Align">
							<span class="glyphicon glyphicon-book" aria-hidden="true"></span>
							Store
						</a>
					</li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
							{{ Auth::user()->type }}: {{ Auth::user()->name }} <span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							@if ( Auth::user()->isTeacher() )
								<li><a href="#">New Content</a></li>
							@endif
							<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')



	<nav class="navbar navbar-default">
		<p class="navbar-text">
			Master Thesis: <strong>A Platform-Independent Framework for Authoring and Monitoring Interactive Contents on Tablets</strong><br/>
			Developed by Siwawes Wongcharoen, Jaratsri Rungrattanaubol and Antony Harfield<br/>
			Department of Computer Science and Information Tecnology, Faculty of Science, Naresuan Univesity, Phitsanulok, Thailand
		</p>

		<ul class="nav navbar-nav">
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
	</nav>

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>

	<!-- Material Design for Bootstrap -->
  <script src="{{ asset('/js/material.min.js') }}"></script>
  <script src="{{ asset('/js/ripples.min.js') }}"></script>
  <script>
    $.material.init();
  </script>

</body>
</html>
