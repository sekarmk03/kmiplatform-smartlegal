<?php
	$appHeaderClass = (!empty($appHeaderInverse)) ? 'app-header-inverse ' : '';
	$appHeaderMenu = (!empty($appHeaderMenu)) ? $appHeaderMenu : '';
	$appHeaderMegaMenu = (!empty($appHeaderMegaMenu)) ? $appHeaderMegaMenu : ''; 
	$appHeaderTopMenu = (!empty($appHeaderTopMenu)) ? $appHeaderTopMenu : '';
?>

<!-- BEGIN #header -->
<div id="header" class="app-header <?php echo e($appHeaderClass); ?>">
	<!-- BEGIN navbar-header -->
	<div class="navbar-header">
		<?php if($appSidebarTwo): ?>
		<button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-end-mobile">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<?php endif; ?>
		<a href="" class="navbar-brand">
			<span class="navbar-logo">
				<img src="<?php echo e(asset('img/logo/kalbe.png')); ?>" width="20" alt="kalbe logo">
			</span>
			<b class="me-1">Kalbe</b> <span style="color: #83bb43">Morinaga</span></a>
		<?php if($appHeaderMegaMenu && !$appSidebarTwo): ?>
		<button type="button" class="navbar-mobile-toggler" data-bs-toggle="collapse" data-bs-target="#top-navbar">
			<span class="fa-stack fa-lg">
				<i class="far fa-square fa-stack-2x"></i>
				<i class="fa fa-cog fa-stack-1x mt-1px"></i>
			</span>
		</button>
		<?php endif; ?>
		<?php if($appTopMenu && !$appSidebarHide && !$appSidebarTwo): ?>
		<button type="button" class="navbar-mobile-toggler" data-toggle="app-top-menu-mobile">
			<span class="fa-stack fa-lg">
				<i class="far fa-square fa-stack-2x"></i>
				<i class="fa fa-cog fa-stack-1x mt-1px"></i>
			</span>
		</button>
		<?php endif; ?>
		<?php if($appTopMenu && $appSidebarHide && !$appSidebarTwo): ?>
		<button type="button" class="navbar-mobile-toggler" data-toggle="app-top-menu-mobile">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<?php endif; ?>
		<?php if(!$appSidebarHide): ?>
		<button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<?php endif; ?>
	</div>
	
	<?php echo $__env->renderWhen($appHeaderMegaMenu, 'includes.component.header-mega-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
	
	<!-- BEGIN header-nav -->
	<div class="navbar-nav">
		<div class="navbar-item dropdown">
			<a href="#" data-bs-toggle="dropdown" class="navbar-link dropdown-toggle icon">
				<i class="fa fa-bell"></i>
				<span class="badge">5</span>
			</a>
			<?php echo $__env->make('includes.component.header-dropdown-notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
		
		<?php if(isset($appHeaderLanguageBar)): ?>
			<?php echo $__env->make('includes.component.header-language-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php endif; ?>
		
		<div class="navbar-item navbar-user dropdown">
			<a href="#" class="navbar-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
				<img src="<?php echo e(asset('/img/user/'.Auth::user()->txtPhoto)); ?>" alt="" /> 
				<span>
					<span class="d-none d-md-inline"><?php echo e(Auth::user()->txtName); ?></span>
					<b class="caret"></b>
				</span>
			</a>
			<?php echo $__env->make('includes.component.header-dropdown-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
		
		<?php if($appSidebarTwo): ?>
		<div class="navbar-divider d-none d-md-block"></div>
		<div class="navbar-item d-none d-md-block">
			<a href="javascript:;" data-toggle="app-sidebar-end" class="navbar-link icon">
				<i class="fa fa-th"></i>
			</a>
		</div>
		<?php endif; ?>
	</div>
	<!-- END header-nav -->
</div>
<!-- END #header --><?php /**PATH C:\laragon\www\standardization\Modules/ROonline\Resources/views/includes/header.blade.php ENDPATH**/ ?>