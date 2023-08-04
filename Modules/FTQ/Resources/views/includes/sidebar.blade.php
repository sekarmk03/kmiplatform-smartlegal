@php
	$appSidebarClass = (!empty($appSidebarTransparent)) ? 'app-sidebar-transparent' : '';
@endphp
<!-- BEGIN #sidebar -->
<div id="sidebar" class="app-sidebar {{ $appSidebarClass }}">
	<!-- BEGIN scrollbar -->
	<div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
		<div class="menu">
			@if (!$appSidebarSearch)
			<div class="menu-profile">
				<a href="javascript:;" class="menu-profile-link" data-toggle="app-sidebar-profile" data-target="#appSidebarProfileMenu">
					<div class="menu-profile-cover with-shadow"></div>
					<div class="menu-profile-image">
						<img src="{{ asset('/img/user/'.Auth::user()->txtPhoto) }}" alt="User Photo" />
					</div>
					<div class="menu-profile-info">
						<div class="d-flex align-items-center">
							<div class="flex-grow-1">
								{{ Auth::user()->txtName }}
							</div>
							<div class="menu-caret ms-auto"></div>
						</div>
						<small>{{ Auth::user()->txtNik }}</small>
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
			@endif
			
			@if ($appSidebarSearch)
			<div class="menu-search mb-n3">
        		<input type="text" class="form-control" placeholder="Sidebar menu filter..." data-sidebar-search="true" />
			</div>
			@endif	
			<div class="menu-header">Navigation</div>		
			@php
				$user = DB::connection('ftq')->table('truser_level')
					->where('user_id', Auth::user()->id)->first();
				$menus = Modules\FTQ\Entities\Menu::with('submenu')
					->whereIn('intMenu_ID', Modules\FTQ\Entities\LevelMenu::where('intLevel_ID', $user->intLevel_ID)->get(['intMenu_ID'])->toArray())
					->orderBy('intQueue', 'ASC')->get();
				$currentUrl = (Request::path() != '/') ? '/'. Request::path() : '/';
			@endphp
			@foreach ($menus as $item)
			@if (count($item->submenu) > 0)
			@php				
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
			@endphp
				<div class="menu-item has-sub {{ $active }}">
					<a href="javascript:;" class="menu-link">
						<div class="menu-icon">
							<i class="{{ $item->txtMenuIcon }}"></i>
						</div>
						<div class="menu-text">{{ $item->txtMenuTitle }}</div>
						<div class="menu-caret"></div>
					</a>
					<div class="menu-submenu">
						@foreach ($item->submenu as $sub)
						<div class="menu-item {{ Route::currentRouteName() == $sub->txtSubmenuRoute?'active':''; }}">
							<a href="{{ '/'.$sub->txtSubmenuUrl }}" class="menu-link"><div class="menu-text"><i class="{{ $sub->txtSubmenuIcon }} text-theme ms-1"></i> {{ $sub->txtSubmenuTitle }}</div></a>
						</div>
						@endforeach
					</div>
				</div>
				@else
				<div class="menu-item {{ Route::currentRouteName() == $item->txtMenuRoute ? 'active':'' }}">
					<a href="{{ '/'.$item->txtMenuUrl }}" class="menu-link">
						<div class="menu-icon">
							<i class="{{ $item->txtMenuIcon }}"></i>
						</div>
						<div class="menu-text">{{ $item->txtMenuTitle }}</div>
					</a>
				</div>
				@endif
			@endforeach
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