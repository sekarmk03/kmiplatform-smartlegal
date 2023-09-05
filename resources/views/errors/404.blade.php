<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="utf-8" />
	<title>Coming Soon | KMI Platform</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN core-css ================== -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="{{ asset('css/vendor.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/default/app.min.css') }}" rel="stylesheet" />
	<!-- ================== END core-css ================== -->
	
	<!-- ================== BEGIN page-css ================== -->
	<link href="{{ asset('plugins/countdown/jquery.countdown.css') }}" rel="stylesheet" />
	<!-- ================== END page-css ================== -->
</head>
<body class='pace-top'>
	<!-- BEGIN #loader -->
	<div id="loader" class="app-loader">
		<span class="spinner"></span>
	</div>
	<!-- END #loader -->

	<!-- BEGIN #app -->
	<div id="app" class="app">
		<!-- BEGIN coming-soon -->
		<div class="coming-soon">
			<!-- BEGIN coming-soon-header -->
			<div class="coming-soon-header">
				<div class="bg-cover"></div>
				<div class="brand">
					<img src="{{ asset('img/logo/kalbe.png') }}" alt="KMI Logo" width="44"><b>KMI</b> Platform
				</div>
				<div class="desc">
					Fitur ini masih dalam tahap pengerjaan. Silahkan kembali ke halaman sebelumnya sampai informasi lebih lanjut tentang fitur ini.
				</div>
			</div>
			<!-- END coming-soon-header -->
		</div>
		<!-- END coming-soon -->
		<!-- BEGIN scroll-top-btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top" data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
		<!-- END scroll-top-btn -->
	</div>
	<!-- END #app -->
	
	<!-- ================== BEGIN core-js ================== -->
	<script src="{{ asset('js/vendor.min.js') }}"></script>
	<script src="{{ asset('js/app.min.js') }}"></script>
	<!-- ================== END core-js ================== -->
	
	<!-- ================== BEGIN page-js ================== -->
	<script src="{{ asset('plugins/countdown/jquery.plugin.min.js') }}"></script>
	<script src="{{ asset('plugins/countdown/jquery.countdown.min.js') }}"></script>
	<script src="{{ asset('js/demo/coming-soon.demo.js') }}"></script>
	<!-- ================== END page-js ================== -->
</body>
</html>