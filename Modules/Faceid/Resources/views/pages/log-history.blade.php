@extends('roonline::layouts.default_layout')
@section('title', 'Log History')
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/plugins/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link href="{{ asset('/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
		<li class="breadcrumb-item active">Log History</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Log History</h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Log History</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                        <a type="button" onclick="refresh()" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <!-- html -->
                        <div class="table-responsive">
                            <table id="daTable" class="table table-striped table-bordered align-middle">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <TH>DATE CREATED</TH>
                                    <th>LINE PROCESS</th>
                                    <th>OKP</th>
                                    <th>PRODUCT</th>
                                    <th>RO</th>
                                    <th>STATUS</th>
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
@endsection
@push('scripts')
    <script src="{{ asset('/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/plugins/gritter/js/jquery.gritter.js') }}"></script>
    <script>
        let url = '';
        let method = '';
        let exportColumns = [1, 2, 3, 4, 5, 6];
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 
        var daTable = $('#daTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('roonline.log-history.index') !!}",
            dom: "<'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>>rtip",
            buttons: [
                {
                    extend:    'copy',
                    text:      '<i class="fas fa-copy"></i>',
                    className: 'btn btn-sm btn-success',
                    exportOptions: {
                    columns: exportColumns,
                }
                },
                {
                    extend:    'print',
                    text:      '<i class="fas fa-print"></i>',
                    className: 'btn btn-sm btn-success',
                    exportOptions: {
                    columns: exportColumns,
                }
                },
                {
                    extend:    'pdfHtml5',
                    text:      '<i class="far fa-file-pdf"></i>',
                    className: 'btn btn-sm btn-success',
                    exportOptions: {
                    columns: exportColumns,
                }
                },
                {
                    extend:    'excel',
                    text:      '<i class="fas fa-file-excel"></i>',
                    className: 'btn btn-sm btn-success',
                    exportOptions: {
                    columns: exportColumns,
                }
                },
            ],
            columns: [
                {data: 'intLog_History_ID', name: 'intLog_History_ID'},
                {data: 'TimeStamp', name: 'TimeStamp'},
                {data: 'txtLineProcessName', name: 'txtLineProcessName'},
                {data: 'txtBatchOrder', name: 'txtBatchOrder'},
                {data: 'txtProductName', name: 'txtProductName'},
                {data: 'floatValues', name: 'floatValues'},
                {data: 'txtStatus', name: 'txtStatus'},
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
        function notification(status, message, bgclass){
            $.gritter.add({
                title: status,
                text: '<p class="text-light">'+message+'</p>',
                class_name: bgclass
            });
            return false;
        }
        $(document).ready(function(){
        })
    </script>
@endpush