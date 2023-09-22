<?php
	$appSidebarClass = (!empty($appSidebarTransparent)) ? 'app-sidebar-transparent' : '';
	$user_level = DB::connection('roonline')
		->table('truser_level')
		->where('user_id', Auth::user()->id)
		->first();
?>
<!-- BEGIN #sidebar -->
<div id="sidebar" class="app-sidebar <?php echo e($appSidebarClass); ?>">
	<!-- BEGIN scrollbar -->
	<div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
		<div class="menu">
			<?php if(!$appSidebarSearch): ?>
			<div class="menu-profile">
				<a href="javascript:;" class="menu-profile-link" data-toggle="app-sidebar-profile" data-target="#appSidebarProfileMenu">
					<div class="menu-profile-cover with-shadow"></div>
					<div class="menu-profile-image">
						<img src="<?php echo e(asset('/img/user/'.Auth::user()->txtPhoto)); ?>" alt="User Photo" />
					</div>
					<div class="menu-profile-info">
						<div class="d-flex align-items-center">
							<div class="flex-grow-1">
								<?php echo e(Auth::user()->txtName); ?>

							</div>
							<div class="menu-caret ms-auto"></div>
						</div>
						<small><?php echo e(Auth::user()->txtNik); ?></small>
					</div>
				</a>
			</div>
			<div id="appSidebarProfileMenu" class="collapse">
				<div class="menu-item pt-5px">
					<a href="javascript:;" class="menu-link">
						<div class="menu-icon"><i class="fa fa-cog"></i></div>
						<div class="menu-text">Settings</div>
					</a>
				</div>
				<div class="menu-item">
					<a href="javascript:;" class="menu-link">
						<div class="menu-icon"><i class="fa fa-pencil-alt"></i></div>
						<div class="menu-text"> Send Feedback</div>
					</a>
				</div>
				<div class="menu-item pb-5px">
					<a href="javascript:;" class="menu-link">
						<div class="menu-icon"><i class="fa fa-question-circle"></i></div>
						<div class="menu-text"> Helps</div>
					</a>
				</div>
				<div class="menu-divider m-0"></div>
			</div>
			<?php endif; ?>
			
			<?php if($appSidebarSearch): ?>
			<div class="menu-search mb-n3">
        		<input type="text" class="form-control" placeholder="Sidebar menu filter..." data-sidebar-search="true" />
			</div>
			<?php endif; ?>			
			<div class="menu-header">Navigation</div>
			<div class="menu-item <?php echo e((empty(Request::segment(2))?'active':'')); ?>">
				<a href="/roonline" class="menu-link">
					<div class="menu-icon">
						<i class="ion-ios-pulse bg-gradient-green"></i>
					</div>
					<div class="menu-text">Dashboard</div>
				</a>
			</div>
			<div class="menu-item has-sub <?php echo e((in_array(Request::segment(3), ['device', 'inspections', 'line', 'area'])?'active':'')); ?>">
				<a href="javascript:;" class="menu-link">
					<div class="menu-icon">
						<i class="ion-ios-list-box bg-gradient-blue"></i>
					</div>
					<div class="menu-text">Data Management</div>
					<div class="menu-caret"></div>
				</a>
				<div class="menu-submenu">
					<div class="menu-item <?php echo e((Request::segment(3) == 'line'?'active':'')); ?>">
						<a href="<?php echo e(route('roonline.line.index')); ?>" class="menu-link">
							<div class="menu-text">
								<i class="fa-solid fa-clipboard text-theme"></i> 
								Line
							</div>
						</a>
					</div>
					<div class="menu-item <?php echo e((Request::segment(3) == 'area'?'active':'')); ?>">
						<a href="<?php echo e(route('roonline.area.index')); ?>" class="menu-link">
							<div class="menu-text">
								<i class="fa-solid fa-clipboard text-theme"></i> 
								Area
							</div>
						</a>
					</div>
					<div class="menu-item <?php echo e((Request::segment(3) == 'device'?'active':'')); ?>">
						<a href="<?php echo e(route('roonline.device.index')); ?>" class="menu-link">
							<div class="menu-text">
								<i class="fa-solid fa-microchip text-theme"></i> 
								Devices
							</div>
						</a>
					</div>
					<div class="menu-item <?php echo e((Request::segment(3) == 'inspections'?'active':'')); ?>">
						<a href="<?php echo e(route('roonline.manage.inspection')); ?>" class="menu-link">
							<div class="menu-text">
								<i class="fa-solid fa-bug text-theme"></i> 
								Inspections
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="menu-item <?php echo e((Request::segment(2) == 'log-history'?'active':'')); ?>">
				<a href="<?php echo e(route('roonline.log-history.index')); ?>" class="menu-link">
					<div class="menu-icon">
						<i class="ion-md-clock bg-gradient-purple"></i>
					</div>
					<div class="menu-text">Log History</div>
				</a>
			</div>
			<div class="menu-item <?php echo e((Request::segment(2) == 'above-std'?'active':'')); ?>">
				<a href="<?php echo e(route('roonline.above-std.index')); ?>" class="menu-link">
					<div class="menu-icon">
						<i class="ion-ios-stats bg-gradient-red"></i>
					</div>
					<div class="menu-text">Log RO >2%</div>
				</a>
			</div>
			<div class="menu-item <?php echo e((Request::segment(2) == 'access-control'?'active':'')); ?>">
				<a href="<?php echo e(route('roonline.access-control.index')); ?>" class="menu-link">
					<div class="menu-icon">
						<i class="ion-ios-lock bg-gradient-yellow"></i>
					</div>
					<div class="menu-text">Level Access</div>
				</a>
			</div>
			<!-- BEGIN minify-button -->
			<div class="menu-item d-flex">
				<a href="javascript:;" class="app-sidebar-minify-btn ms-auto" data-toggle="app-sidebar-minify"><i class="fa fa-angle-double-left"></i></a>
			</div>
			<!-- END minify-button -->
		
		</div>
		<!-- END menu -->
	</div>
	<!-- END scrollbar -->
</div>
<div class="app-sidebar-bg"></div>
<div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile" class="stretched-link"></a></div>
<!-- END #sidebar -->

<?php /**PATH C:\laragon\www\standardization\Modules/ROonline\Resources/views/includes/sidebar.blade.php ENDPATH**/ ?>