<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Laravel Training - @yield('title')</title>

	<!-- Fonts -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

	<!-- Styles -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

	<style>
		body
		{
			font-family: 'Lato';
		}
		.fa-btn
		{
			margin-right: 6px;
		}
		#nav_profile_icon
		{
			margin-top: 5px;
			border: 1px solid white;
		}
	</style>

</head>
<body id="app-layout">
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<ul class="nav navbar-nav">
				
				<?php
					$is_active = 'class="active"';
					$url =  url()->current();
					$pos = strrpos($url, "/");
					$page = substr($url, $pos+1);
				?>

				@if(Auth::check())
					<li {!! ($page == 'dashboard') ? $is_active : '' !!} >{!! Html::link('/dashboard', 'Dashboard') !!}</li>
					<li {!! ($page == 'details') ? $is_active : '' !!} >{!! Html::link('/details', 'Details') !!}</li>

					@if(Auth::user()->role_id == 1)
						<li {!! ($page == 'add_user') ? $is_active : '' !!} >{!! Html::link('/add_user', 'Add User') !!}</li>
						<li {!! ($page == 'permission') ? $is_active : '' !!} >{!! Html::link('/permission', 'Permission Manager') !!}</li>
					@endif

				@else
					<li {!! ($page == 'local.laravel.com' || $page == 'public') ? $is_active : '' !!} >{!! Html::link(route('home'), 'Home') !!}</li>
					<li {!! ($page == 'register') ? $is_active : '' !!} >{!! Html::link('/register', 'Register') !!}</li>
					<li {!! ($page == 'login') ? $is_active : '' !!} >{!! Html::link('/login', 'Login') !!}</li>
				@endif

			</ul>

			<ul class="nav navbar-nav navbar-right">

				@if(Auth::check())

					<li>{!! Html::image(asset('images/profile_pic' . '/' . Auth::user()->photo) , 'No image found', array( 'width' => 40, 'height' => 40, 'id' => 'nav_profile_icon')) !!}</li>

					<li>{!! Html::link('/logout', 'Log out') !!}</li>
				@endif

			</ul>
		</div>
	</nav>

	@if(Session::has('flash_message'))
		<div class="alert alert-success">{{ Session::get('flash_message')}}
		</div>
	@endif

	@yield('content')

	<!-- Google Analytics -->
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		// ga('create', 'UA-83853347-1', {'cookieDomain': 'none'});
		ga('create', 'UA-83853347-1', {'cookieDomain': 'none', 'cookieExpires': 0});
		ga('send', 'pageview');

		// console.log(ga.q);
		// ga(function()
		// {
		// 	// Logs an array of all tracker objects.
		// 	console.log(ga.getAll());
		// });
		
		ga(function(tracker) {
			console.log(tracker.get('clientId'));
		}); 
		
	</script>

	<!-- jQuery -->
	<script src="//code.jquery.com/jquery.js"></script>
	<script>
		var appUrl = "{{ URL('/') }}" + '/';
		var pic_link = "{{ asset('images/profile_pic') . '/'}}";
	</script>
	<script type="text/javascript">
		$.ajaxSetup
		({
			headers: 
			{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>

	<!-- JavaScripts -->
	@yield('js-css')
</body>
</html>
