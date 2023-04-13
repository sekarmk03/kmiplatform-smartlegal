<?php
	$appSidebarClass = (!empty($appSidebarTransparent)) ? 'app-sidebar-transparent' : '';
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
			<?php
				$sidebar = App\Models\MenuModel::with(['submenu' => function($query){
				$query->join('trlevel_access AS tla', 'tla.intSubmenu_ID', '=', 'msubmenus.intSubmenu_ID')
					->where('tla.intLevel_ID', Auth::user()->intLevel_ID)
					->where('tla.intAccessible', 1)
					->groupBy('msubmenus.intSubmenu_ID');
				}])->has('submenu')->get();
				$currentUrl = (Request::path() != '/') ? Request::path() : '/';

				function renderSubmenu($items, $current){
					foreach ($items as $val){		
						$active = ($current == $val->txtUrl?'active':'');
						echo '<div class="menu-item '.$active.'">
							<a href="'.route($val->txtRouteName).'" class="menu-link"><div class="menu-text"><i class="'.$val->txtSubmenuIcon.' text-theme"></i> '.$val->txtSubmenuTitle.'</div></a>
						</div>';
					}
				}
			?>
			<?php $__currentLoopData = $sidebar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php				
				$submenu = $item->submenu;
				$active = '';
				foreach ($submenu as $key => $val) {
					if ($val->txtUrl == $currentUrl) {
						$active = 'active';
						break;
					} else {
						$active = '';
					}
				}
			?>
			<div class="menu-item has-sub <?php echo e($active); ?>">
				<a href="javascript:;" class="menu-link">
					<div class="menu-icon">
						<i class="<?php echo e($item->txtMenuIcon); ?>"></i>
					</div>
					<div class="menu-text"><?php echo e($item->txtMenuTitle); ?></div>
					<div class="menu-caret"></div>
				</a>
				<div class="menu-submenu">
					<?php
						renderSubmenu($submenu, $currentUrl);
					?>					
				</div>
			</div>				
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<div class="menu-item">
				<a href="http://localhost/phpmyadmin" class="menu-link" target="_new">
					<div class="menu-icon">
						<i class="ion-ios-cloud bg-orange"></i>
					</div>
					<div class="menu-text">PhpMyAdmin</div>
				</a>
			</div>
			<div class="menu-item">
				<a href="<?php echo e(route('filemanager')); ?>" class="menu-link" target="_new">
					<div class="menu-icon">
						<i class="ion-ios-folder bg-gradient-blue"></i>
					</div>
					<div class="menu-text">File Manager</div>
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

<?php /**PATH C:\laragon\www\standardization\resources\views/includes/sidebar.blade.php ENDPATH**/ ?>