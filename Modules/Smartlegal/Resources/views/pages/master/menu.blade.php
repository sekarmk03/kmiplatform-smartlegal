@extends('smartlegal::layouts.default_layout')
@section('title', 'Document Issuers')
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
		<li class="breadcrumb-item active">Document Issuers</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Document Issuers</h1>
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
                                        <th class="text-center">#</th>
                                        <th class="text-center">CREATED AT</th>
                                        <th class="text-center">PARENT MENU</th>
                                        <th class="text-center">MENU TITLE</th>
                                        <th class="text-center">ICON</th>
                                        <th class="text-center">URL</th>
                                        <th class="text-center">ROUTE</th>
                                        <th class="text-center">TYPE</th>
                                        <th class="text-center">ORDER</th>
                                        <th class="text-center">DESCRIPTION</th>
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
            ajax: "{{ route('smartlegal.master.menu.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center'},
                {data: 'created_at', name: 'created_at', className: 'text-center'},
                {data: 'parent_title', name: 'parent_title', className: 'text-center'},
                {data: 'menu_title', name: 'menu_title', className: 'text-center'},
                {data: 'icon', name: 'icon', className: 'text-center'},
                {data: 'url', name: 'url', className: 'text-center'},
                {data: 'route', name: 'route', className: 'text-center'},
                {data: 'type', name: 'type', className: 'text-center'},
                {data: 'order', name: 'order', className: 'text-center'},
                {
                    data: 'desc',
                    name: 'desc',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return '<div style="word-wrap: break-word; max-width: 700px;">' + data + '</div>';
                        }
                        return data;
                    }
                }
            ]
        });
        function refresh(){
            daTable.ajax.reload(null, false);
        }
    </script>
@endpush