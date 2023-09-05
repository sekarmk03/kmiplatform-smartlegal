@extends('layouts.default_layout')
@section('title', 'Manage Levels')
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
		<li class="breadcrumb-item active">Manage Levels</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Manage Levels</h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Levels Table</h4>
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
                                    <th>LEVEL NAME</th>
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
          <form action="" method="post" id="form-level">
                <div class="mb-3">
                    <label class="form-label" id="LevelName">Level Name</label>
                    <input class="form-control" type="text" name="txtLevelName" id="LevelName" placeholder="Level Name" oninput="this.value = this.value.toUpperCase()"/>
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
<div class="modal fade" id="modal-access">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modal Dialog</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="form-access">
                @method('PUT')
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sub Menu</th>
                            <th>Access</th>
                        </tr>
                    </thead>
                    <tbody class="listAccess">
                        
                    </tbody>
                </table>
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
@push('scripts')
    <script src="{{ asset('/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/plugins/gritter/js/jquery.gritter.js') }}"></script>
    <script>
        let url = '';
        let method = '';
        let ind = 0;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 
        var daTable = $('#daTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('manage.level.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'dtmCreated', name: 'dtmCreated'},
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
        function refresh(){
            daTable.ajax.reload(null, false);
        }
        function create(){
            $('.modal-header h4').html('Create Level');
            $('#modal-level').modal('show');
            url = "{{ route('manage.level.store') }}";
            method = "POST";
        }
        function edit(id){
            $('.modal-header h4').html('Edit Level');
            let editUrl = "{{ route('manage.level.edit',':id') }}";
            editUrl = editUrl.replace(':id', id);
            url = "{{ route('manage.level.update', ':id') }}";
            url = url.replace(':id', id);
            method = "PUT";
            $.get(editUrl, function(response){
                $('#modal-level').modal('show');
                $('input#LevelName').val(response.level.txtLevelName);
            }).fail(function(response){
                notification(response.responseJSON.status, response.responseJSON.message,'bg-danger');
            });
        }
        function tableAccess(data){
            let wrapper = $('.listAccess');
            wrapper.find('tr').remove();
            let trdata = '';
            $.each(data, function(i, val){
                trdata += '<tr>'+
                        '<td>'+(++i)+'</td>'+
                        '<td>'+val.txtSubmenuTitle+'</td>'+
                        '<td>'+accessCheck(val.routes, val.access)+'<br></td>'+
                    '</tr>';
            })
            wrapper.append(trdata);
        }
        function accessCheck(data, check){
            let list = '';
            $.each(data, function(i, val){
                ++ind;
                if (check.length != 0) {
                    list += '<div class="form-check">'+
                        '<input type="hidden" name="submenu_id[]" value="'+check[i].intSubmenu_ID+'"/>'+
                        '<input type="hidden" name="route_id[]" value="'+check[i].intRoute_ID+'"/>'+
                        '<input name="accessible[]" class="form-check-input" type="checkbox" id="checkbox'+(ind)+'" '+(check[i].intAccessible == 1?'checked':'')+' value="1"/>'+
                        '<label class="form-check-label" for="checkbox'+(ind)+'">'+val.txtRouteTitle+' - '+val.txtRouteName+'</label>'+
                        '</div><br>';
                } else {
                    list += '<div class="form-check">'+
                        '<input type="hidden" name="submenu_id[]" value="'+val.intSubmenu_ID+'"/>'+
                        '<input type="hidden" name="route_id[]" value="'+val.intRoute_ID+'"/>'+
                        '<input name="accessible[]" class="form-check-input" type="checkbox" id="checkbox'+(ind)+'" value="1"/>'+
                        '<label class="form-check-label" for="checkbox'+(ind)+'">'+val.txtRouteTitle+' - '+val.txtRouteName+'</label>'+
                        '</div><br>';
                }
            })
            return list;
        }
        function access(id){
            $('.modal-header h4').html('Access Control Level');
            let accessUrl = "{{ route('manage.level.access',':id') }}";
            accessUrl = accessUrl.replace(':id', id);
            url = "{{ route('manage.level.change', ':id') }}";
            url = url.replace(':id', id);
            $.get(accessUrl, function(response){
                $('#modal-access').modal('show');
                let access = response.level;
                tableAccess(access);
            }).fail(function(response){
                notification(response.responseJSON.status, response.responseJSON.message,'bg-danger');
            });
        }
        function destroy(id){
            let deleteUrl = "{{ route('manage.level.destroy', ':id') }}";
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
        $(document).ready(function(){
            $('#modal-level').on('hide.bs.modal', function(){
                ind = 0;
                $('input#LevelName').val('');
                $('input[name="_method"]').remove();
            })
            $('#form-level').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url: getUrl(),
                    method: getMethod(),
                    data: $(this).serialize(),
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
            $('#form-access').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $('.form-check-input').each(function(i, obj){
                    formData.append('intAccess[]', $(this).is(':checked')?1:0);
                })
                $.ajax({
                    url: getUrl(),
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(response){
                        $('#modal-access').modal('hide');
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