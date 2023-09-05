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
@endsection
@push('scripts')
    <script src="{{ asset('/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/gritter/js/jquery.gritter.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 
        var daTable = $('#daTable').DataTable({
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
        function refresh(){
            daTable.ajax.reload(null, false);
        }
    </script>
@endpush