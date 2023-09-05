@extends('smartlegal::layouts.default_layout')
@section('title', 'Permissions')
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    <!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
		<li class="breadcrumb-item active">Permissions</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Permissions</h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col-12 ui-sortable">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Role Table</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                        <a type="button" onclick="refresh()" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive">
                                <table id="daTable" class="table table-striped table-bordered align-middle">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">CREATED AT</th>
                                        <th class="text-center">ROLE NAME</th>
                                        <th class="text-center">MENU</th>
                                        <th class="text-center">PERMISSION</th>
                                        <th class="text-center">DESCRIPTION</th>
                                        <th class="text-center">ACTION</th>
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
                        <label class="form-label" for="RoleName">Role Name</label>
                        <input class="form-control" type="text" name="txtRoleName" id="RoleName" placeholder="Enter role name.." required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="MenuID">Menu</label>
                        <select class="select2 form-select" name="intMenuID" id="MenuID">
                            @foreach ($menus as $item)
                            <option value="{{ $item->intMenuID }}">{{ $item->txtMenuTitle }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="PermissionID">Permission</label>
                        <select class="select2 form-select" name="intPermissionID" id="PermissionID">
                            @foreach ($permissions as $item)
                            <option value="{{ $item->intPermissionID }}">{{ $item->txtPermissionName }}</option>
                            @endforeach
                          </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="RoleDesc">Description</label>
                        <textarea name="txtDesc" id="RoleDesc" cols="30" rows="5" class="form-control" placeholder="Enter description.."></textarea>
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
@push('scripts')
    <script src="{{ asset('/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/plugins/gritter/js/jquery.gritter.js') }}"></script>
    <script src="{{ asset('/plugins/select-picker/dist/picker.min.js') }}"></script>
    <script src="{{ asset('/plugins/parsleyjs/dist/parsley.min.js') }}"></script>
    <script>
        let url = '';
        let method = '';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let daTable = $('#daTable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            responsive: true,
            ajax: "{{ route('smartlegal.master.role.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center'},
                {data: 'created_at', name: 'created_at', className: 'text-center'},
                {data: 'role_name', name: 'role_name', className: 'text-center'},
                {data: 'menu_name', name: 'menu_name', className: 'text-center'},
                {data: 'permission_name', name: 'permission_name', className: 'text-center'},
                {
                    data: 'desc',
                    name: 'desc',
                    render: (data, type, row) => {
                        if (type === 'display') {
                            return '<div style="word-wrap: break-word; max-width: 700px;">' + data + '</div>';
                        }
                        return data;
                    },
                },
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'},
            ]
        });
        
        const getUrl = () => url;
        const getMethod = () => method;
        const refresh = () => daTable.ajax.reload(null, false);

        const edit = ( id ) => {
            $('.modal-header h4').html('Edit App Role');
            let editUrl = "{{ route('smartlegal.master.role.edit', ':id') }}";
            editUrl = editUrl.replace(':id', id);
            url = "{{ route('smartlegal.master.role.update', ':id') }}";
            url = url.replace(':id', id);
            method = "PUT";
            $.get(editUrl, (response) => {
                $('#modal-level').modal('show');
                $('input#RoleName').val(response.data.txtRoleName);
                $('select#MenuID').val(response.data.intMenuID).trigger('change');
                $('select#PermissionID').val(response.data.intPermissionID).trigger('change');
                $('textarea#RoleDesc').val(response.data.txtDesc);

                $('select#MenuID').trigger('change');
                $('select#PermissionID').trigger('change');
            });
        }

        const notification = (status, message, bgclass) => {
            $.gritter.add({
                title: status,
                text: `<p class="text-light">${message}</p>`,
                class_name: bgclass
            });
            return false;
        }

        $(document).ready(() => {
            $('#MenuID').select2({
                placeholder: {
                    id: '-1',
                    text: 'Select Menu'
                },
                allowClear: true,
                dropdownParent: $('#modal-level')
            });
            $('#PermissionID').select2({
                placeholder: {
                    id: '-1',
                    text: 'Select Permission'
                },
                allowClear: true,
                dropdownParent: $('#modal-level')
            });
            $('.notif-icon').find('span').text();
            $('#modal-level').on('hide.bs.modal', () => {
                $('.modal-body form')[0].reset();
                $('input[name="_method"]').remove();
            });
            $('.modal-body form').on('submit', (e) => {
                e.preventDefault();
                $.ajax({
                    url: getUrl(),
                    method: getMethod(),
                    data: $('.modal-body form').serialize(),
                    dataType: "JSON",
                    success: (response) => {
                        $('#modal-level').modal('hide');
                        refresh();
                        notification(response.status, response.message,'bg-success');
                        conn.send(['success', 'permission']);
                    },
                    error: (response) => {
                        let fields = response.responseJSON.fields;
                        $.each(fields, (i, val) => {
                            $.each(val, (ind, value) => {
                                notification(response.responseJSON.status, val[ind],'bg-danger');
                            });
                        });
                    }
                });
            });
        });
    </script>
@endpush