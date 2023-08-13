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
			<?php
				$user = Modules\ROonline\Entities\TrUser::where('user_id', Auth::user()->id)->first();
				$menus = Modules\ROonline\Entities\Menu::with('submenu')
					->whereIn('intMenu_ID', Modules\ROonline\Entities\LevelMenu::where('intLevel_ID', $user->intLevel_ID)->get(['intMenu_ID'])->toArray())
					->orderBy('intQueue', 'ASC')->get();
				$currentUrl = (Request::path() != '/') ? '/'. Request::path() : '/';
			?>
			<?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php if(count($item->submenu) > 0): ?>
			<?php				
				$submenu = $item->submenu;
				$active = '';
				foreach ($submenu as $key => $val) {
					if ('/'.$val->txtSubmenuUrl == $currentUrl) {
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
						<?php $__currentLoopData = $item->submenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div class="menu-item <?php echo e(Route::currentRouteName() == $sub->txtSubmenuRoute?'active':''); ?>">
							<a href="<?php echo e('/'.$sub->txtSubmenuUrl); ?>" class="menu-link"><div class="menu-text"><i class="<?php echo e($sub->txtSubmenuIcon); ?> text-theme ms-1"></i> <?php echo e($sub->txtSubmenuTitle); ?></div></a>
						</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
				</div>
				<?php else: ?>
				<div class="menu-item <?php echo e(Route::currentRouteName() == $item->txtMenuRoute ? 'active':''); ?>">
					<a href="<?php echo e('/'.$item->txtMenuUrl); ?>" class="menu-link">
						<div class="menu-icon">
							<i class="<?php echo e($item->txtMenuIcon); ?>"></i>
						</div>
						<div class="menu-text"><?php echo e($item->txtMenuTitle); ?></div>
					</a>
				</div>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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