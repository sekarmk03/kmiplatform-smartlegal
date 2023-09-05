@extends('layouts.default_layout', ['appContentClass' => 'p-0'])

@section('title', 'Profile Page')

@push('css')
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link href="{{ asset('plugins/superbox/superbox.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('plugins/lity/dist/lity.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
@endpush

@push('scripts')
	<script src="{{ asset('plugins/superbox/jquery.superbox.min.js') }}"></script>
	<script src="{{ asset('plugins/lity/dist/lity.min.js') }}"></script>
    <script src="{{ asset('/plugins/gritter/js/jquery.gritter.js') }}"></script>
	<script src="{{ asset('js/demo/profile.demo.js') }}"></script>
	<script>
		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 
		function browsePhoto(){
			$('input[name="txtPhoto"]').click();
		}
		function previewProfile(input){
			if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#previewPhoto').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
		}
		function notification(status, message, bgclass){
            $.gritter.add({
                title: status,
                text: '<p class="text-light">'+message+'</p>',
                class_name: bgclass
            });
            return false;
        }
		$(document).ready(function(){
			$('#ProfileForm').on('submit', function(e){
				e.preventDefault();
				var formData = new FormData($(this)[0]);
				$.ajax({
					url: $(this).attr('action'),
					type: "POST",					
                    data: formData,
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
					success: function(res){
						notification(res.status, res.message, 'bg-success');
					}, 
					error: function(res){
						let fields = res.responseJSON.fields;
						if (fields) {							
							$.each(fields, function(i, val){
								$.each(val, function(idx, value){
									notification(res.responseJSON.status, val[idx],'bg-danger');
								})
							})
						} else {
							notification(res.responseJSON.status, res.responseJSON.message,'bg-danger');
						}
					}
				})
			})
			$('#FormPassword').on('submit', function(e){
				e.preventDefault();
				$.ajax({
					url: $(this).attr('action'),
					type: "PUT",
					data: $(this).serialize(),
					dataType: "JSON",
					success: function(res){
						notification(res.status, res.message, 'bg-success');
					}, 
					error: function(res){
						let fields = res.responseJSON.fields;
						if (fields) {							
							$.each(fields, function(i, val){
								$.each(val, function(idx, value){
									notification(res.responseJSON.status, val[idx],'bg-danger');
								})
							})
						} else {
							notification(res.responseJSON.status, res.responseJSON.message,'bg-danger');
						}
					}
				})
			})
		})
	</script>
@endpush

@section('content')
	<!-- BEGIN profile -->
	<div class="profile">
		<div class="profile-header">
			<!-- BEGIN profile-header-cover -->
			<div class="profile-header-cover"></div>
			<!-- END profile-header-cover -->
			<!-- BEGIN profile-header-content -->
			<div class="profile-header-content">
				<!-- BEGIN profile-header-img -->
				<div class="profile-header-img">
					<img id="previewPhoto" src="{{ asset('img/user/'.$user->txtPhoto) }}" alt="Photo Profile" onclick="browsePhoto()"/>
				</div>
				<!-- END profile-header-img -->
				<!-- BEGIN profile-header-info -->
				<div class="profile-header-info">
					<h4 class="mt-0 mb-1">{{ $user->txtName }}</h4>
					<p class="mb-2">{{ $user->txtNamaJabatan }}</p>
					<form id="ProfileForm" action="{{ route('user.profile.photo', Auth::user()->id) }}" method="post" enctype="multipart/form-data">
						@method('PUT')
						<input type="file" name="txtPhoto" id="Photo" onchange="previewProfile(this)" style="display: none">
						<button type="button" onclick="browsePhoto()" class="btn btn-xs btn-yellow">Change Photo</button>
						<button type="submit" class="btn btn-xs btn-success">Save</button>
					</form>
				</div>
				<!-- END profile-header-info -->
			</div>
			<!-- END profile-header-content -->
			<!-- BEGIN profile-header-tab -->
			<ul class="profile-header-tab nav nav-tabs">
				<li class="nav-item"><a href="#profile-about" class="nav-link active" data-bs-toggle="tab">PROFILE</a></li>
				<li class="nav-item"><a href="#password-about" class="nav-link" data-bs-toggle="tab">PASSWORD</a></li>
			</ul>
			<!-- END profile-header-tab -->
		</div>
	</div>
	<!-- END profile -->
	<!-- BEGIN profile-content -->
	<div class="profile-content">
		<!-- BEGIN tab-content -->
		<div class="tab-content p-0">
			<!-- BEGIN #profile-about tab -->
			<div class="tab-pane fade show active" id="profile-about">
				<!-- BEGIN table -->
				<div class="table-responsive form-inline">
					<table class="table table-profile align-middle">
						<thead>
							<tr>
								<th></th>
								<th>
									<h4>{{ $user->txtName }} [{{ $user->txtInitial }}]
                                        <small>{{ $user->txtUsername }}</small> 
                                        <small>{{ $user->txtNik }}</small> 
                                        <small>{{ $user->txtNamaJabatan }}</small>
                                    </h4>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="field">DEPARTEMEN</td>
								<td>{{ $user->txtDepartmentName }}</td>
							</tr>
							<tr>
								<td class="field">SUB DEPARTEMEN</td>
								<td>{{ $user->txtSubdepartmentName }}</td>
							</tr>
							<tr>
								<td class="field">CG</td>
								<td>{{ $user->txtCgName }}</td>
							</tr>
							<tr class="highlight">
								<td class="field">Extension</td>
								<td><i class="fa-solid fa-phone fa-lg me-5px"></i> {{ $user->txtExt }} </td>
							</tr>
                            <tr class="divider">
								<td colspan="2"></td>
							</tr>
							<tr>
								<td class="field">Email</td>
								<td><i class="fa-solid fa-envelope fa-lg me-5px"></i> {{ $user->txtEmail }}</td>
							</tr>							
							<tr>
								<td class="field">Active</td>
								<td><input class="form-check-input" type="checkbox" id="checkbox1" {{($user->intActive==1)?'checked':''}} disabled/></td>
							</tr>							
							<tr class="divider">
								<td colspan="2"></td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- END table -->
			</div>
			<!-- END #profile-about tab -->			
			<!-- BEGIN #profile-about tab -->
			<div class="tab-pane fade" id="password-about">
				<!-- BEGIN table -->
				<div class="table-responsive form-inline">
					<table class="table table-profile align-middle">
						<thead>
							<tr>
								<th></th>
								<th>
									<h4>{{ $user->txtName }} [{{ $user->txtInitial }}]
                                        <small>{{ $user->txtUsername }}</small> 
                                        <small>{{ $user->txtNik }}</small> 
                                        <small>{{ $user->txtNamaJabatan }}</small>
                                    </h4>
								</th>
							</tr>
						</thead>
                        <form id="FormPassword" action="{{ route('user.profile.reset', Auth::user()->id) }}" method="post">
						@method("PUT")
						<tbody>
							<tr>
								<td class="field">OLD PASSWORD</td>
								<td>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="password" class="form-control" name="txtOldPassword" placeholder="Old Password" id="oldPassword" required>
                                    </div>
                                </td>
							</tr>
							<tr>
								<td class="field">NEW PASSWORD</td>
								<td>
                                    <div class="col-lg-6 col-md-12">
                                        <input type="password" class="form-control" name="txtNewPassword" placeholder="New Password" id="oldPassword" required>
                                    </div>
                                </td>
							</tr>
							<tr>
								<td class="field">CONFIRM NEW PASSWORD</td>
								<td>
                                    <div class="col-lg-6 col-md-12">
                                        <input type="password" class="form-control" name="txtConfirmPassword" placeholder="Confirm New Password" id="ConfirmPassword" required>
                                    </div>
                                </td>
							</tr>						
							<tr class="divider">
								<td colspan="2"></td>
							</tr>
							<tr class="highlight">
								<td class="field">&nbsp;</td>
								<td class="">
									<button type="submit" class="btn btn-primary w-150px">Update</button>
									<button type="submit" class="btn btn-white border-0 w-150px ms-5px">Cancel</button>
								</td>
							</tr>
						</tbody>
                        </form>
					</table>
				</div>
				<!-- END table -->
			</div>
			<!-- END #profile-about tab -->			
		</div>
		<!-- END tab-content -->
	</div>
	<!-- END profile-content -->

@endsection