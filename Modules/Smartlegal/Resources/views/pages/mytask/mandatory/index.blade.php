@extends('smartlegal::layouts.default_layout')
@section('title', 'My Task')
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
		<li class="breadcrumb-item active">My Task</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">My Task</h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col-12 ui-sortable">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <span class="badge rounded-pill bg-danger">{{ $active_task }}</span>
                        &nbsp; My Task Table
                    </h4>
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
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Request No.</th>
                                        <th class="text-center">Kode Perizinan</th>
                                        <th class="text-center">Jenis Perizinan</th>
                                        <th class="text-center">Nama Perizinan</th>
                                        <th class="text-center">Biaya Pembaruan</th>
                                        <th class="text-center">PIC</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Tanggal Request</th>
                                        <th class="text-center">Action</th>
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
    <!-- #modal-dialog-preview -->
    <div class="modal fade" id="modal-preview">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Modal Dialog</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="row embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive embed-responsive-16by9" src="" frameborder="0" width="100%" height="600px" id="FileFrame"></iframe>
                </div>
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
    <script src="{{ asset('/plugins/gritter/js/jquery.gritter.js') }}"></script>
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
            ajax: "{{ route('smartlegal.mytask.mandatory.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center'},
                {data: 'request_number', name: 'request_number', className: 'text-center'},
                {data: 'doc_number', name: 'doc_number', className: 'text-center'},
                {data: 'variant', name: 'variant', className: 'text-center'},
                {data: 'doc_name', name: 'doc_name', className: 'text-center'},
                {data: 'renewal_cost', name: 'renewal_cost', className: 'text-center'},
                {data: 'pic', name: 'pic', className: 'text-center'},
                {data: 'status', name: 'status', className: 'text-center'},
                {data: 'created_at', name: 'created_at', className: 'text-center'},
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'},
            ]
        });
        
        const getUrl = () => url;
        const getMethod = () => method;
        const refresh = () => daTable.ajax.reload(null, false);

        const preview = ( id ) => {
            $('.modal-header h4').html('File Preview');
            let previewUrl = "{{ route('smartlegal.master.file.preview', ':id') }}";
            previewUrl = previewUrl.replace(':id', id);
            $.get(previewUrl, (response) => {
                $('#modal-preview').modal('show');
                $('iframe#FileFrame').attr('src', response.data.txtPath);
            });
        }

        const show = ( id ) => {
            let showUrl = "{{ route('smartlegal.mytask.mandatory.show', ':id') }}"
            showUrl = showUrl.replace(':id', id);
            $.get(showUrl);
        }

        $(document).ready(() => {
            $('.notif-icon').find('span').text();
            $('#modal-form').on('hide.bs.modal', () => {
                $('input#File').val('');
                $('input[name="_method"]').remove();
            });
            $('.modal-body form').on('submit', (e) => {
                e.preventDefault();
                let formData = new FormData($('.modal-body form')[0]);
                $.ajax({
                    url: getUrl(),
                    method: getMethod(),
                    data: formData,
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: (response) => {
                        $('#modal-form').modal('hide');
                        refresh();
                        notification(response.status, response.message,'bg-success');
                        conn.send(['success', 'file']);
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