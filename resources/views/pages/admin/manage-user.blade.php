@extends('layouts.default_layout')
@section('title', 'Manage Users')
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@endpush
@push('scripts')
    <script src="{{ asset('/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/plugins/gritter/js/jquery.gritter.js') }}"></script>
    <script src="{{ asset('/plugins/parsleyjs/dist/parsley.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script>
        let url = '';
        let method = '';
        let subdept_id, jabatan_id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 
        var daTable = $('#daTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('manage.user.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'dtmCreated', name: 'dtmCreated'},
                {data: 'txtName', name: 'txtName'},
                {data: 'txtUsername', name: 'txtUsername'},
                {data: 'txtInitial', name: 'txtInitial'},
                {data: 'txtDepartmentName', name: 'txtDepartmentName'},
                {data: 'txtLevelName', name: 'txtLevelName'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        function getUrl(){
            return url;
        }
        function getMethod(){
            return method;
        }
        function getSubdepartmentList(iddept){
            let wrapper = $('#Subdepartment_ID');
            let opt = '';
            wrapper.empty();
            $.get("{{ route('manage.subdepartment.list') }}", {
                id_department: iddept
            }, function(response){
                $.each(response.data, function(i, val){
                    opt += '<option value="'+val.intSubdepartment_ID+'">'+val.txtSubdepartmentName+'</option>';
                })
                wrapper.append(opt);
                if (subdept_id) {
                    wrapper.val(subdept_id).trigger('change');
                }
            })
        }
        function getJobpositionList(iddept){
            let wrapper = $('select#Jobposition_ID');
            let opt = '';
            wrapper.empty();
            $.get("{{ route('manage.jobposition.list') }}", {
                id_department: iddept
            }, function(response){
                $.each(response.data, function(i, val){
                    opt += '<option value="'+val.intJabatan_ID+'">'+val.txtNamaJabatan+'</option>';
                })
                wrapper.append(opt);
                if (jabatan_id) {
                    wrapper.val(jabatan_id).trigger('change');
                }
            })
        }
        function refresh(){
            daTable.ajax.reload(null, false);
        }
        function create(){
            $('.modal-header h4').html('Create User');
            $('#modal-level').modal('show');
            $('.input-password').css('display', 'block');
            url = "{{ route('manage.user.store') }}";
            method = "POST";
        }
        function edit(id){
            let editUrl = replaceUrl("{{ route('manage.user.edit',':id') }}", id);
            $('.modal-body form').append('<input type="hidden" name="_method" value="PUT">');
            url = replaceUrl("{{ route('manage.user.update', ':id') }}", id);
            method = "POST";
            $.get(editUrl, function(response){
                $('.modal-header h4').html('Edit User '+response.user.txtNik);
                $('#modal-level').modal('show');
                $('input#Name').val(response.user.txtName);
                $('input#NIK').val(response.user.txtNik);
                $('input#Initial').val(response.user.txtInitial);
                $('input#UserName').val(response.user.txtUsername);
                $('input#Email').val(response.user.txtEmail);
                $('select#Level_ID').val(response.user.intLevel_ID).trigger('change');
                $('select#Cg_ID').val(response.user.intCg_ID).trigger('change');
                $('select#Department_ID').val(response.user.intDepartment_ID).trigger('change');
                subdept_id = response.user.intSubdepartment_ID;
                jabatan_id = response.user.intJabatan_ID;
                $('#preview-photo').attr('src', "{{ asset('img/user') }}/"+response.user.txtPhoto);
                $('.input-password').css('display', 'none');
            });
        }
        function resetPassword(id){
            let editUrl = "{{ route('manage.user.edit',':id') }}";
            editUrl = editUrl.replace(':id', id);
            url = "{{ route('manage.user.change-password', ':id') }}";
            url = url.replace(':id', id);
            method = "PUT";
            $.get(editUrl, function(response){
                $('.modal-header h4').html('Reset Password '+response.user.txtNik);
                $('#modal-reset').modal('show');
            });
        }
        function destroy(id){
            let deleteUrl = "{{ route('manage.user.destroy', ':id') }}";
            deleteUrl = deleteUrl.replace(':id', id);
            swal({
                title: 'Are you sure?',
                text: 'You will not be able to recover this Data!',
                icon: 'warning',
                buttons: {
                    cancel: {
                        text: 'Cancel',
                        value: null,
                        visible: true,
                        className: 'btn btn-default',
                        closeModal: true,
                    },
                    confirm: {
                        text: 'Delete',
                        value: true,
                        visible: true,
                        className: 'btn btn-danger',
                        closeModal: true
                    }
                }
            }).then(function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: deleteUrl,
                        method: "DELETE",
                        dataType: "JSON",
                        success: function(response){
                            refresh();
                            notification(response.status, response.message,'bg-success');
                        }
                    })
                }
            });
        }
        function showPassword(that){
            let elem = $(that).closest('.input-group').find('input');
            if (elem.attr('type') == 'password') {
                elem.removeAttr('type').attr('type', 'text');
            } else {
                elem.removeAttr('type').attr('type', 'password');
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
        function replaceUrl(param, id){
            return param.replace(':id', id);
        }
        $(document).ready(function(){
            $('select#Department_ID').select2({
                placeholder: "SELECT DEPARTMENT",
                allowClear: true,
                dropdownParent: $('#modal-level')
            });
            $('select#Subdepartment_ID').select2({
                placeholder: "SELECT SUB DEPARTMENT",
                allowClear: true,
                dropdownParent: $('#modal-level')
            });
            $('select#Level_ID').select2({
                placeholder: "SELECT LEVEL",
                allowClear: true,
                dropdownParent: $('#modal-level')
            });
            $('select#Cg_ID').select2({
                placeholder: "SELECT CG",
                allowClear: true,
                dropdownParent: $('#modal-level')
            });
            $('select#Jobposition_ID').select2({
                placeholder: "SELECT JOB POSITION",
                allowClear: true,
                dropdownParent: $('#modal-level')
            });
            $('select#Department_ID').on('change', function(){
                getSubdepartmentList($(this).val());
                getJobpositionList($(this).val());
            })
            $('#modal-level').on('hide.bs.modal', function(){
                $('.modal-body form')[0].reset();
                $('select#Jobposition_ID, select#Subdepartment_ID').empty();
                $('select#Department_ID, select#Level_ID, select#Subdepartment_ID, select#Cg_ID, select#Jobposition_ID').val('').trigger('change');
                $('#preview-photo').attr('src', "{{ asset('img/user/default.png') }}");
                $('input[name="_method"]').remove();
            })
            $('form#form-user').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: getUrl(),
                    method: getMethod(),
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "JSON",
                    success: function(response){
                        $('#modal-level').modal('hide');
                        refresh();
                        notification(response.status, response.message,'bg-success');
                    },
                    error: function(response){
                        let fields = response.responseJSON.fields;
                        $.each(fields, function(i, val){
                            notification(response.responseJSON.status, val[0],'bg-danger');
                        })
                    }
                })
            })
            $('form#reset-password').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url: getUrl(),
                    method: getMethod(),
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(response){
                        $('#modal-reset').modal('hide');
                        notification(response.status, response.message,'bg-success');
                    },
                    error: function(response){
                        let fields = response.responseJSON.fields;
                        $.each(fields, function(i, val){
                            notification(response.responseJSON.status, val[0],'bg-danger');
                        })
                    }
                })
            })
        })
    </script>
@endpush
@section('content')
    <!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
		<li class="breadcrumb-item active">Manage Users</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Manage Users</h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Users Table</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                        <a type="button" onclick="refresh()" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row my-3">
                        <div class="col-md-2 ms-auto">
                            {!! Level::createBtn() !!}
                        </div>
                    </div>
                    <div class="row">
                        <!-- html -->
                        <div class="table-responsive">
                            <table id="daTable" class="table table-striped table-bordered align-middle">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <TH>DATE CREATED</TH>
                                    <th>NAME</th>
                                    <th>USER NAME</th>
                                    <th>INITIAL</th>
                                    <th>DEPT</th>
                                    <th>LEVEL</th>
                                    <TH>ACTION</TH>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #modal-dialog -->
    <div class="modal fade" id="modal-level">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Dialog</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                <form action="" method="post" id="form-user" data-parsley-validate="true">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="Level_ID">LEVEL*</label>
                            <select class="select2 form-control" id="Level_ID" name="intLevel_ID" data-parsley-required="true" >
                                <option value=""></option>
                                @foreach ($levels as $item)                        
                                    <option value="{{ $item->intLevel_ID }}">{{ $item->txtLevelName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Department_ID">DEPARTMENT*</label>
                            <select class="select2 form-control" id="Department_ID" name="intDepartment_ID" data-parsley-required="true">
                                <option value=""></option>
                                @foreach ($departments as $item)                        
                                    <option value="{{ $item->intDepartment_ID }}">{{ $item->txtDepartmentName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Subdepartment_ID">SUB DEPARTMENT*</label>
                            <select class="select2 form-control" id="Subdepartment_ID" name="intSubdepartment_ID" data-parsley-required="true">
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Jobposition_ID">JOB POSITION*</label>
                            <select class="select2 form-control" id="Jobposition_ID" name="intJabatan_ID" data-parsley-required="true">
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Cg_ID">CG*</label>
                            <select class="select2 form-control" id="Cg_ID" name="intCg_ID" data-parsley-required="true">
                                <option value=""></option>
                                @foreach ($cgs as $item)
                                    <option value="{{ $item->intCg_ID }}">{{ $item->txtCgName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="NIK">NIK*</label>
                            <input class="form-control" type="text" name="txtNik" id="NIK" placeholder="NIK" oninput="this.value = this.value.toUpperCase()" onkeypress="return event.charCode != 32" data-parsley-required="true"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Name">NAME*</label>
                            <input class="form-control" type="text" name="txtName" id="Name" placeholder="Name" oninput="this.value = this.value.toUpperCase()" data-parsley-required="true" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Initial">INITIAL*</label>
                            <input class="form-control" type="text" name="txtInitial" id="Initial" placeholder="Initial Name" oninput="this.value = this.value.toUpperCase()" onkeypress="return event.charCode != 32" data-parsley-required="true" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="UserName">USERNAME*</label>
                            <input class="form-control" type="text" name="txtUsername" id="UserName" placeholder="User Name" oninput="this.value = this.value.toLowerCase()" onkeypress="return event.charCode != 32" data-parsley-required="true" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Email">EMAIL*</label>
                            <input class="form-control" type="text" name="txtEmail" id="Email" placeholder="user@email.com" data-parsley-required="true" data-parsley-type="email" onkeypress="return event.charCode != 32"/>
                        </div>
                        <div class="mb-3 input-password">
                            <label class="form-label" id="Password">PASSWORD*</label>
                            <div class="input-group">
                                <input type="password" id="Password" class="form-control" name="txtPassword" placeholder="******" onkeypress="return event.charCode != 32" required/>
                                <button type="button" class="btn btn-default" onclick="showPassword(this)"><div class="fas fa-eye"></div></button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <!-- file -->
                            <label for="Photo" class="form-label">PHOTO PROFILE</label>
                            <input type="file" class="form-control" name="txtPhoto" id="Photo" onchange="document.getElementById('preview-photo').src = window.URL.createObjectURL(this.files[0])"/>
                        </div>
                        <div class="mb-3">
                            <div class="mx-auto">
                                <img class="img-thumbnail" src="{{ asset('img/user/default.png') }}" alt="Photo Profile Preview" id="preview-photo" width="156">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Close</a>
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                </form>
                </div>
            </div>
        </div>
    </div>
    <!-- #modal-dialog -->
    <div class="modal fade" id="modal-reset">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">Modal Dialog</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                <form action="" method="post" id="reset-password" data-parsley-validate="true">
                    <div class="mb-3">
                        <label class="form-label" id="NewPassword">New Password</label>
                        <div class="input-group">
                            <input type="password" id="NewPassword" class="form-control" name="txtPassword" placeholder="******" onkeypress="return event.charCode != 32" required/>
                            <button type="button" class="btn btn-default" onclick="showPassword(this)"><div class="fas fa-eye"></div></button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Close</a>
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection