<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
	<?php echo $__env->make('roonline::includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<?php
	$bodyClass = (!empty($appBoxedLayout)) ? 'boxed-layout ' : '';
	$bodyClass .= (!empty($paceTop)) ? 'pace-top ' : $bodyClass;
	$bodyClass .= (!empty($bodyClass)) ? $bodyClass . ' ' : $bodyClass;
	$appSidebarHide = (!empty($appSidebarHide)) ? $appSidebarHide : '';
	$appHeaderHide = (!empty($appHeaderHide)) ? $appHeaderHide : '';
	$appSidebarTwo = (!empty($appSidebarTwo)) ? $appSidebarTwo : '';
	$appSidebarSearch = (!empty($appSidebarSearch)) ? $appSidebarSearch : '';
	$appTopMenu = (!empty($appTopMenu)) ? $appTopMenu : '';
	
	$appClass = (!empty($appTopMenu)) ? 'app-with-top-menu ' : '';
	$appClass .= (!empty($appHeaderHide)) ? 'app-without-header ' : ' app-header-fixed ';
	$appClass .= (!empty($appSidebarEnd)) ? 'app-with-end-sidebar ' : '';
	$appClass .= (!empty($appSidebarLight)) ? 'app-with-light-sidebar ' : '';
	$appClass .= (!empty($appSidebarWide)) ? 'app-with-wide-sidebar ' : '';
	$appClass .= (!empty($appSidebarHide)) ? 'app-without-sidebar ' : '';
	$appClass .= (!empty($appSidebarMinified)) ? 'app-sidebar-minified ' : '';
	$appClass .= (!empty($appSidebarTwo)) ? 'app-with-two-sidebar app-sidebar-end-toggled ' : '';
	$appClass .= (!empty($appContentFullHeight)) ? 'app-content-full-height ' : '';
	
	$appContentClass = (!empty($appContentClass)) ? $appContentClass : '';
?>
<body class="<?php echo e($bodyClass); ?>">
	<?php echo $__env->make('roonline::includes.component.page-loader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	
	<div id="app" class="app app-sidebar-fixed <?php echo e($appClass); ?>">
		
		<?php echo $__env->renderWhen(!$appHeaderHide, 'roonline::includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
		
		<?php echo $__env->renderWhen($appTopMenu, 'roonline::includes.top-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
		
		<?php echo $__env->renderWhen(!$appSidebarHide, 'roonline::includes.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
		
		
		
		<div id="content" class="app-content <?php echo e($appContentClass); ?>">
			<?php echo $__env->yieldContent('content'); ?>
		</div>
		
		<?php echo $__env->make('roonline::includes.component.scroll-top-btn', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		
		
		
	</div>
	
	<?php echo $__env->yieldContent('outside-content'); ?>
	
	<?php echo $__env->make('roonline::includes.page-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\standardization\Modules/ROonline\Resources/views/layouts/default_layout.blade.php ENDPATH**/ ?>