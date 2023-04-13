<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="utf-8" />
	<title>403 | Forbidden</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN core-css ================== -->
	<link href="<?php echo e(asset('css/vendor.min.css')); ?>" rel="stylesheet" />
	<link href="<?php echo e(asset('css/apple/app.min.css')); ?>" rel="stylesheet" />
	<link href="<?php echo e(asset('plugins/ionicons/css/ionicons.min.css')); ?>" rel="stylesheet" />
	<!-- ================== END core-css ================== -->
</head>
<body class='pace-top'>
	<!-- BEGIN #loader -->
	<div id="loader" class="app-loader">
		<span class="spinner"></span>
	</div>
	<!-- END #loader -->

	<!-- BEGIN #app -->
	<div id="app" class="app">
		<!-- BEGIN error -->
		<div class="error">
			<div class="error-code">403</div>
			<div class="error-content">
				<div class="error-message">Forbidden</div>
				<div class="error-desc mb-4">
					You dont have access to reach this page. <br />
					Contact your admin to update your priviledge.
				</div>
				<div>
					<a href="<?php echo e(route('manage.menu.index')); ?>" class="btn btn-success px-3">Go Home</a>
				</div>
			</div>
		</div>
		<!-- END error -->
		
		<!-- BEGIN scroll-top-btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-primary btn-scroll-to-top" data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
		<!-- END scroll-top-btn -->
	</div>
	<!-- END #app -->
	
	<!-- ================== BEGIN core-js ================== -->
	<script src="<?php echo e(asset('js/vendor.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/app.min.js')); ?>"></script>
	<!-- ================== END core-js ================== -->
</body>
</html><?php /**PATH C:\laragon\www\standardization\resources\views/errors/403.blade.php ENDPATH**/ ?>