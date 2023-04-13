@extends('roonline::layouts.default_layout')
@section('title', 'Log History')
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/plugins/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link href="{{ asset('/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/select-picker/dist/picker.min.css') }}" rel="stylesheet" />
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
                    <div class="row mb-3">
                        <div class="col-2">
                            <select name="txtLineProcess" id="Line" class="form-control">
                                <option value="noFilter">No Filter</option>
                                @foreach ($lines as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <select name="txtStatus" id="Status" class="form-control">
                                <option value="noFilter">No Filter</option>
                                @foreach ($statuses as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-primary" onclick="refresh()">Filter <i class="fas fa-magnifying-glass"></i></button>
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
<div class="modal fade" id="modal-view">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modal Dialog</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Close</a>
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
    <script src="{{ asset('/plugins/select-picker/dist/picker.min.js') }}"></script>
    <script>
        let url = '';
        let method = '';
        const excludes = ['txt', 'dtm'];
        let exportColumns = [1, 2, 3, 4, 5, 6];
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 
        var daTable = $('#daTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{!! route('roonline.log-history.index') !!}",
                data: function(data){
                    data.txtLineProcessName = $('select#Line').val();
                    data.txtStatus = $('select#Status').val();
                }
            },
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
        function view(id){
            let wrapper = $('.modal-body');
            wrapper.find('.mb-3').remove();
            let input = '';
            let viewUrl = "{!! route('roonline.log-history.view', ':id') !!}";
            viewUrl = viewUrl.replace(':id', id);
            $.get(viewUrl, function(response){
                $('#modal-view').modal('show');
                let datas = response.data;
                $.each(datas, function(idx, val){
                    input += '<div class="mb-3">'+
                            '<label class="form-label" for="'+idx+'">'+idx.replace(/([A-Z])/g, ' $1').trim()+'</label>'+
                            '<input class="form-control" type="text" name="'+idx+'" id="'+idx+'" value="'+val+'" readonly/>'+
                        '</div>';
                })
                wrapper.append(input);
            })
        }
        $(document).ready(function(){
            $('select#Line').picker({
                search: true,
                'texts': {
                    trigger : "Select a Line",
                    search : "Search a Line",
                    noResult : "No results",
                },
            });
            $('select#Status').picker({
                search: true,
                'texts': {
                    trigger : "Select a Status",
                    search : "Search a Status",
                    noResult : "No results",
                },
            });
        })
    </script>
@endpush