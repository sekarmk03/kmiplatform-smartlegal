@extends('smartlegal::layouts.default_layout')
@section('title', 'Department')
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
		<li class="breadcrumb-item active">Department</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Department</h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col-12 ui-sortable">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Department Table</h4>
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
                                        <th class="text-center">DEPARTMENT NAME</th>
                                        <th class="text-center">INITIAL</th>
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
                        <label class="form-label" for="DepartmentName">Department Name</label>
                        <input class="form-control" type="text" name="txtDepartmentName" id="DepartmentName" placeholder="Enter department name.." oninput="this.value = this.value.toUpperCase()" required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="DepartmentInitial">Department Initial</label>
                        <input class="form-control" type="text" name="txtInitial" id="DepartmentInitial" placeholder="Enter department initial.." onkeypress="return event.charCode != 32" oninput="this.value = this.value.toUpperCase()" required/>
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
    <script src="{{ asset('/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/plugins/gritter/js/jquery.gritter.js') }}"></script>
    <script src="{{ asset('/plugins/select-picker/dist/picker.min.js') }}"></script>
    <script src="{{ asset('/plugins/parsleyjs/dist/parsley.min.js') }}"></script>
    <script src="{{ asset('/plugins/select2/dist/js/select2.min.js') }}"></script>
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
            ajax: "{{ route('smartlegal.master.department.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center'},
                {data: 'dtmCreated', name: 'dtmCreated', className: 'text-center'},
                {data: 'txtDepartmentName', name: 'txtDepartmentName', className: 'text-center'},
                {data: 'txtInitial', name: 'txtInitial', className: 'text-center'},
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'},
            ]
        });
        
        const getUrl = () => url;
        const getMethod = () => method;
        const refresh = () => daTable.ajax.reload(null, false);

        const edit = ( id ) => {
            $('.modal-header h4').html('Edit Department');
            let editUrl = "{{ route('smartlegal.master.department.edit', ':id') }}";
            editUrl = editUrl.replace(':id', id);
            url = "{{ route('smartlegal.master.department.update', ':id') }}";
            url = url.replace(':id', id);
            method = "PUT";
            $.get(editUrl, (response) => {
                $('#modal-level').modal('show');
                $('input#DepartmentName').val(response.data.txtDepartmentName);
                $('input#DepartmentInitial').val(response.data.txtInitial);
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