@extends('layouts.default_layout')
@section('title', 'Manage Submenus')
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <style>
        datalist{
            z-index: 1000;
        }
    </style>
@endpush
@section('content')
    <!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
		<li class="breadcrumb-item active">Manage Submenus</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Manage Submenus</h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Submenus Table</h4>
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
                                    <th>MENU TITLE</th>
                                    <th>SUBMENU TITLE</th>
                                    <th>SUBMENU ICON</th>
                                    <th>URL</th>
                                    <th>ROUTE NAME</th>
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
          <form action="" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="Menu_ID">Menu</label>
                    <select class="select2 form-control" id="Menu_ID" name="intMenu_ID">
                        <option value=""></option>
                        @foreach ($menus as $item)                        
                            <option value="{{ $item->intMenu_ID }}">{{ $item->txtMenuTitle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="ui-widget mb-3">
                    <label class="form-label" id="SubmenuTitle">Submenu Title</label>
                    <input class="form-control" type="text" name="txtSubmenuTitle" id="SubmenuTitle" placeholder="Submenu Title"/>
                </div>
                <div class="mb-3">
                    <label class="form-label" id="SubmenuIcon">Submenu Icon</label>
                    <input class="form-control" type="text" name="txtSubmenuIcon" id="SubmenuIcon" placeholder="Submenu Icon"/>
                </div>
                <div class="mb-3">
                    <label class="form-label" id="SubmenuUrl">Submenu URL</label>
                    <input class="form-control" type="text" name="txtUrl" id="SubmenuUrl" placeholder="Submenu URL" onkeypress="return event.charCode != 32"/>
                </div>
                <div class="mb-3">
                    <label class="form-label" id="RouteName">Submenu Route Name</label>
                    <input class="form-control" type="text" name="txtRouteName" id="SubmenuRoute" placeholder="Route Name" onkeypress="return event.charCode != 32"/>
                </div>
                <div class="mb-3">
                    <table class="table table-striped table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>TITLE</th>
                                <th>ROUTE NAME</th>
                                <th><button type="button" onclick="addRow()" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i> Route</button></th>
                            </tr>
                        </thead>
                        <tbody class="route-list">

                        </tbody>
                    </table>
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
<datalist id="options">
    <option>read</option>
    <option>create</option>
    <option>edit</option>
    <option>update</option>
    <option>delete</option>
</datalist>
@endsection
@push('scripts')
    <script src="{{ asset('/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/plugins/gritter/js/jquery.gritter.js') }}"></script>
    <script src="{{ asset('/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script>
        let url = '';
        let method = '';
        let index = 0;
        let actionBtn = '<button class="btn btn-sm btn-danger" onclick="deleteRow(this)"><i class="fa-solid fa-xmark"></i></button>';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 
        var daTable = $('#daTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('manage.submenu.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'dtmCreated', name: 'dtmCreated'},
                {data: 'txtMenuTitle', name: 'txtMenuTitle'},
                {data: 'txtSubmenuTitle', name: 'txtSubmenuTitle'},
                {data: 'txtSubmenuIcon', name: 'txtSubmenuIcon'},
                {data: 'txtUrl', name: 'txtUrl'},
                {data: 'txtRouteName', name: 'txtRouteName'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        function getUrl(){
            return url;
        }
        function getMethod(){
            return method;
        }
        function refresh(){
            daTable.ajax.reload(null, false);
        }
        function create(){
            $('.modal-header h4').html('Create Submenu');
            $('#modal-level').modal('show');
            url = "{{ route('manage.submenu.store') }}";
            method = "POST";
        }
        function edit(id){
            $('.modal-header h4').html('Edit Submenu');
            $('.modal-body form').append('<input type="hidden" name="_method" value="PUT">');
            let editUrl = "{{ route('manage.submenu.edit',':id') }}";
            editUrl = editUrl.replace(':id', id);
            url = "{{ route('manage.submenu.update', ':id') }}";
            url = url.replace(':id', id);
            method = "POST";
            $.get(editUrl, function(response){
                $('#modal-level').modal('show');
                listRow(response.submenu.routes);
                $('input#SubmenuTitle').val(response.submenu.txtSubmenuTitle);
                $('input#SubmenuIcon').val(response.submenu.txtSubmenuIcon);
                $('input#SubmenuUrl').val(response.submenu.txtUrl);
                $('input#SubmenuRoute').val(response.submenu.txtRouteName);
                $('select#Menu_ID').val(response.submenu.intMenu_ID).trigger('change');
            }).fail(function(response){
                notification(response.responseJSON.status, response.responseJSON.message,'bg-danger');
            });
        }
        function destroy(id){
            let deleteUrl = "{{ route('manage.submenu.destroy', ':id') }}";
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
        function notification(status, message, bgclass){
            $.gritter.add({
                title: status,
                text: '<p class="text-light">'+message+'</p>',
                class_name: bgclass
            });
            return false;
        }

        function addRow(){
            let wrapper = $('.route-list');
            let list = '<tr>'+
                    '<td>'+ (++index) +'</td>'+
                    '<td><input type="text" name="txtRouteTitle[]" placeholder="create, delete, etc.." class="form-control" list="options" autocomplete="off"/></td>'+
                    '<td><input type="text" name="RouteName[]" placeholder="manage..." class="form-control" onkeypress="return event.charCode != 32"/></td>'+
                    '<td>'+actionBtn+'</td>'+
                '</tr>';
            wrapper.append(list);
        }

        function listRow(routes){
            let wrapper = $('.route-list');
            let list = '';
            $.each(routes, function(i, val){
                list += '<tr>'+
                    '<td>'+ (++index) +'</td>'+
                    '<td><input type="hidden" name="routeId" value="'+val.intRoute_ID+'" /><input type="text" name="txtRouteTitle[]" placeholder="create, delete, etc.." class="form-control" list="options" value="'+val.txtRouteTitle+'" autocomplete="off"/></td>'+
                    '<td><input type="text" name="RouteName[]" placeholder="manage..." class="form-control" onkeypress="return event.charCode != 32" value="'+val.txtRouteName+'"/></td>'+
                    '<td>'+actionBtn+'</td>'+
                '</tr>';
            })
            wrapper.append(list);
        }

        function deleteRow(elem){
            --index;
            elem.closest('tr').remove();
        }
        
        $(document).ready(function(){
            $('.select2').select2({
                dropdownParent: $('#modal-level'),
                placeholder: 'Select a Menu',
                allowClear: true
            });
            $('#modal-level').on('hide.bs.modal', function(){
                $('select#Menu_ID').val(null).trigger('change');
                $('input#SubmenuTitle, input#SubmenuIcon, input#SubmenuUrl, input#SubmenuRoute').val('');
                $('input[name="_method"]').remove();
                let wrapper = $('.route-list');
                wrapper.find('tr').remove();
                index = 0;
            })
            $('.modal-body form').on('submit', function(e){
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
                            notification(response.status, val[0],'bg-danger');
                        })
                    }
                })
            })
        })
    </script>
@endpush