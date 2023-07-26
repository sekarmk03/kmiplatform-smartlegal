<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="utf-8" />
	<title>@yield('title')</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN core-css ================== -->
	<link href="{{ asset('css/vendor.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/apple/app.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet" />
	<!-- ================== END core-css ================== -->
	
	<!-- ================== BEGIN page-css ================== -->
	<link href="{{ asset('plugins/jvectormap-next/jquery-jvectormap.css') }}" rel="stylesheet" />
	<link href="{{ asset('plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
	<link href="{{ asset('plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
	<!-- ================== END page-css ================== -->
    @stack('css')
</head>
<body>
	<!-- BEGIN #loader -->
	<div id="loader" class="app-loader">
		<span class="spinner"></span>
	</div>
	<!-- END #loader -->
    <!-- BEGIN #app -->
    <div id="app" class="app app-header-fixed app-sidebar-fixed ">
    <!-- BEGIN #header -->
    <div id="header" class="app-header">
        <!-- BEGIN navbar-header -->
        <div class="navbar-header">
            <a href="" class="navbar-brand">
                <span class="navbar-logo">
                    <img src="{{ asset('img/logo/kalbe.png') }}" width="20" alt="kalbe logo">
                </span>
                <b class="me-1">Kalbe</b> <span style="color: #83bb43">Morinaga</span></a>
            <button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- END navbar-header -->
        <!-- BEGIN header-nav -->
        <div class="navbar-nav">
            <div class="navbar-item navbar-user">
                <a type="button" class="btn btn-success" onclick="loginModal()"><i class="fas fa-sign-in"></i> Login</a>
            </div>
        </div>
        <!-- END header-nav -->
    </div>
    <!-- END #header -->
    <!-- BEGIN #sidebar -->
    <div id="sidebar" class="app-sidebar">
        <!-- BEGIN scrollbar -->
        <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
            <!-- BEGIN menu -->
            <div class="menu">
                <div class="menu-header">Navigation</div>
                <div class="menu-item active">
                    <a href="" class="menu-link">
                        <div class="menu-icon">
                            <i class="ion-ios-pulse"></i>
                        </div>
                        <div class="menu-text">Dashboard</div>
                    </a>
                </div>
                
                <!-- BEGIN minify-button -->
                <div class="menu-item d-flex">
                    <a href="javascript:;" class="app-sidebar-minify-btn ms-auto" data-toggle="app-sidebar-minify"><i class="ion-ios-arrow-back"></i> <div class="menu-text">Collapse</div></a>
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
    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        @yield('content')
    </div>
    <!-- END #content -->

    <!-- #modal-dialog -->
    <div class="modal fade" id="modal-login">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Login</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <!-- default -->
                    <div class="note note-default">
                        <div class="note-icon">
                            <img src="{{ asset('img/logo/kalbe.png') }}" width="32" alt="Kalbe Icon">
                        </div>
                        <div class="note-content">
                            <h1 class="h1">
                                <b style="color: #333">Kalbe</b> <span style="color: #83bb43">Morinaga</span>
                            </h1>
                        </div>
                    </div>
                    <form action="" method="post" id="login-form">
                        @csrf
                        <div class="form-floating mb-3">
                            <!-- NIK -->
                            <input type="text" name="txtUserCredential" id="UserName" class="form-control" placeholder="Enter Username"/>
                            <label for="UserName" class="d-flex align-items-center fs-13px">User Name or NIK</label>
                        </div>
                        <div class="form-floating mb-3">
                            <!-- Password -->
                            <input type="password" class="form-control" name="txtPassword" id="Password" placeholder="Enter Password">
                            <label for="Password" class="d-flex align-items-center fs-13px">Password</label>
                        </div>
                        <!-- default -->
                        <div class="form-check">
                            <input class="form-check-input" name="remember" type="checkbox" id="checkbox1" value="1"/>
                            <label class="form-check-label" for="checkbox1">Remember Me</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
                        <button type="submit" class="btn btn-success"><i class="fas fa-sign-in"></i> Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ================== BEGIN core-js ================== -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <!-- ================== END core-js ================== -->

    <!-- ================== BEGIN page-js ================== -->
    <script src="{{ asset('plugins/gritter/js/jquery.gritter.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.canvaswrapper.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.colorhelpers.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.flot.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.flot.saturated.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.flot.browser.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.flot.drawSeries.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.flot.uiConstants.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.flot.crosshair.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.flot.categories.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.flot.navigate.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.flot.touchNavigate.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.flot.hover.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.flot.touch.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.flot.selection.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.flot.symbol.js') }}"></script>
    <script src="{{ asset('plugins/flot/source/jquery.flot.legend.js') }}"></script>
    <script src="{{ asset('plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('plugins/jvectormap-next/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('plugins/jvectormap-next/jquery-jvectormap-world-mill.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
    {{-- <script src="{{ asset('js/demo/dashboard.js') }}"></script> --}}
    <!-- ================== END page-js ================== -->
    <script>
        function notification(status, message, bgclass){
            $.gritter.add({
                title: status,
                text: '<p class="text-light">'+message+'</p>',
                class_name: bgclass
            });
            return false;
        }
        function loginModal(){
            $('#modal-login').modal('show');
        }
        $(document).ready(function(){
            $('#modal-login').on('hide.bs.modal', function(){
                $('input#Password').val('');
            })
            $('#login-form').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{ route('post.auth.index') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: 'JSON',
                    success: function(response){
                        $('#modal-login').modal('hide');
                        notification(response.status, response.message, 'bg-success');
                        window.location.href = "{{ route('manage.user.index') }}";
                    },
                    error: function(response){
                        if(response.status == '404' || response.status == '401'){
                            notification(response.responseJSON.status, response.responseJSON.message,'bg-danger');
                        } else {
                            let fields = response.responseJSON.fields;
                            $.each(fields, function(i, val){
                                $.each(val, function(ind, value){
                                    notification(response.responseJSON.status, val[ind],'bg-danger');
                                })
                            })
                        }
                        $('#modal-login').modal('hide');
                    }
                })
            })
        })
    </script>
</body>
</html>