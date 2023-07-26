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
			<div class="menu-item {{ (empty(Request::segment(2))?'active':'') }}">
				<a href="/faceid" class="menu-link">
					<div class="menu-icon">
						<i class="ion-md-analytics bg-gradient-green"></i>
					</div>
					<div class="menu-text">Dashboard</div>
				</a>
			</div>

			<div class="menu-item {{ (Request::segment(2) == 'device'?'active':'') }}">
				<a href="{{ route('faceid.device.index') }}" class="menu-link">
					<div class="menu-icon">
						<i class="ion-md-list-box bg-gradient-blue"></i>
					</div>
					<div class="menu-text">Data Device</div>
				</a>
			</div>

			<div class="menu-item {{ (Request::segment(2) == 'karyawan'?'active':'') }}">
				<a href="{{ route('faceid.karyawan.index') }}" class="menu-link">
					<div class="menu-icon">
						<i class="ion-md-list-box bg-gradient-blue"></i>
					</div>
					<div class="menu-text">Data Karyawan</div>
				</a>
			</div>

			<div class="menu-item {{ (Request::segment(2) == 'logs'?'active':'') }}">
				<a href="{{ route('faceid.logs.index') }}" class="menu-link">
					<div class="menu-icon">
						<i class="ion-md-clock bg-gradient-purple"></i>
					</div>
					<div class="menu-text">Log History</div>
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