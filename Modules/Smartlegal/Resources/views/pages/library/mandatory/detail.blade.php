@extends('smartlegal::layouts.default_layout')
@section('title', 'Library Detail')
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" rel="stylesheet">
    <style>
        table.dataTable tbody tr.selected>* {
            box-shadow: inset 0 0 0 9999px rgba(251, 255, 0, 0.5) !important;
            color: white;
        }
        #detailTbl td {
            vertical-align: top;
        }
        #detailTbl tr td:first-child {
            white-space: nowrap;
        }
    </style>
@endpush
@section('content')
    <!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="javascript:;">Library</a></li>
		<li class="breadcrumb-item active">Detail</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Library Detail</h1>
	<!-- END page-header -->
    <div class="row mt-4 pe-3">
        <div class="col">
            <h3>No. {{ substr($mandatory['doc_number'], 0, 11) }}</h3>
            <p class="fst-italic my-0">Terakhir diperbarui {{ $mandatory['updated_at'] }}</p>
            <?php 
                $color = [
                    'Requested' => '',
                    'Revised' => '',
                    'Rejected' => '',
                    'Approved/Active' => 'green',
                    'Warning' => 'yellow',
                    'Expired' => 'red',
                    'Terminated' => 'black'
                ];
            ?>
            <p class="mt-0 fw-bolder"><span><i class="fas fa-circle" style="color: {{ $color[$mandatory['status']] }}"></i></span>&nbsp;{{ $mandatory['status'] }}</p>
        </div>
        <div class="card mx-2 me-5 fs-5 py-3 px-3">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <table id="detailTbl">
                            <tr>
                                <td>No. Request</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['request_number'] }}</td>
                            </tr>
                            <tr>
                                <td>No. Perizinan</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['doc_number'] }}</td>
                            </tr>
                            <tr>
                                <td>Nama Perizinan</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['doc_name'] }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Perizinan</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['variant'] }}</td>
                            </tr>
                            <tr>
                                <td>Nama PIC</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['pic'] }}</td>
                            </tr>
                            <tr>
                                <td>Tipe Dokumen</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['type'] }}</td>
                            </tr>
                            <tr>
                                <td>Instansi Penerbit</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['issuer'] }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col">
                        <table>
                            <tr>
                                <td>Periode Berlaku</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['exp_period'] }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal berlaku</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['date'] }}</td>
                            </tr>
                            <tr>
                                <td>Reminder pembaruan</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['rem_period'] }}</td>
                            </tr>
                            <tr>
                                <td>Biaya pembaruan</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['renewal_cost'] }}</td>
                            </tr>
                            <tr>
                                <td>PIC Reminder</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['pic_reminder'] }}</td>
                            </tr>
                            <tr>
                                <td>Location filling hardcopy</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['location'] }}</td>
                            </tr>
                            <tr>
                                <td>Cost Center</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['cost_center'] }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 ui-sortable">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Version History Table</h4>
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
                                        <th class="text-center">Kode Perizinan</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Nama Perizinan</th>
                                        <th class="text-center">Penerbit</th>
                                        <th class="text-center">Nama File</th>
                                        <th class="text-center">Action</th>
                                        <th class="text-center">Attachment</th>
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
    <div class="row mt-1">
        <div class="col-12 ui-sortable">
            <div class="panel panel-inverse" style="background-color: transparent">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#default-tab-1" data-bs-toggle="tab" class="nav-link active">Reviewer Notes</a>
                    </li>
                    <li class="nav-item">
                        <a href="#default-tab-2" data-bs-toggle="tab" class="nav-link">Approval Log</a>
                    </li>
                </ul>
                <div class="tab-content panel p-3 rounded-0 rounded-bottom">
                    <div class="tab-pane fade active show" id="default-tab-1">
                        <div class="col">
                            <div class="table-responsive">
                                <table id="daTable" class="table table-striped table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">User</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Catatan</th>
                                            <th class="text-center">Lead Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="default-tab-2">
                    bbb
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #modal-dialog-preview -->
    <div class="modal fade" id="modal-preview" style="z-index: 2000;">
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
    <!-- #modal-dialog -->
    <div class="modal fade" id="modal-attachment">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Attachment List</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table id="daTableAttachment" class="table table-striped table-bordered align-middle">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">FILE NAME</th>
                                    <th class="text-center">DATE</th>
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
    <script src="{{ asset('/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/plugins/gritter/js/jquery.gritter.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-select-bs5/js/select.bootstrap5.min.js') }}"></script>
    <script>
        let url = '';
        let method = '';
        let daTableAttachment;
        let daTable;
        let fileDocID;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        daTable = $('#daTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: true,
                responsive: true,
                select: true,
                ajax: "{{ route('smartlegal.library.mandatory.show', $mandatory['doc_id']) }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center'},
                    {data: 'doc_number', name: 'doc_number', className: 'text-center'},
                    {data: 'date', name: 'date', className: 'text-center'},
                    {data: 'doc_name', name: 'doc_name', className: 'text-center'},
                    {data: 'issuer_name', name: 'issuer_name', className: 'text-center'},
                    {data: 'file_name', name: 'file_name', className: 'text-center', width: '30%'},
                    {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'},
                    {data: 'attachment', name: 'attachment', orderable: false, searchable: false, className: 'text-center'},
                ]
            });

        const getUrl = () => url;
        const getMethod = () => method;
        const refresh = () => {
            daTable.ajax.reload(null, false);
            daTableAttachment.ajax.reload(null, false);
        }

        const preview = ( id ) => {
            $('.modal-header h4').html('File Preview');
            let previewUrl = "{{ route('smartlegal.master.file.preview', ':id') }}";
            previewUrl = previewUrl.replace(':id', id);
            $.get(previewUrl, (response) => {
                $('#modal-preview').modal('show');
                $('iframe#FileFrame').attr('src', response.data.txtPath);
            });
        }

        const download = ( id ) => {
            let downloadUrl = "{{ route('smartlegal.master.file.download', ':id') }}";
            downloadUrl = downloadUrl.replace(':id', id);
            window.location = downloadUrl;
        }

        const attachments = ( id ) => {
            let attachmentUrl = "{{ route('smartlegal.library.mandatory.attachment', ':id') }}"
            attachmentUrl = attachmentUrl.replace(':id', id);
            if (!daTableAttachment) {
                daTableAttachment = $('#daTableAttachment').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: true,
                    responsive: true,
                    ajax: attachmentUrl,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center'},
                        {data: 'file_name', name: 'file_name', className: 'text-center'},
                        {data: 'date', name: 'date', className: 'text-center'},
                        {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'},
                    ]
                });
            } else {
                refresh();
            }
            $('#modal-attachment').modal('show');
        }

        const triggerUpload = ( id ) => {
            document.getElementById('FileUpload').click();
            fileDocID = id;
        }

        const upload = () => {
            const fileInput = document.getElementById('FileUpload');
            const file = fileInput.files[0];
            console.log(file);

            if (file) {
                const formData = new FormData();
                formData.append('txtFile', file);
                formData.append('intDocID', fileDocID);

                url = "{{ route('smartlegal.library.mandatory.upload') }}";
                method = "POST";

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
            }
        }

        const getReviewHistory = ( id ) => {

        }

        $(document).ready(() => {
            $('.notif-icon').find('span').text();
            $('#modal-preview').on('hide.bs.modal', () => {
                $('iframe#FileFrame').attr('src', '');
            });
            daTable.on('select', (e, dt, type, indexes) => {
                if (type === 'row') {
                    let rowData = daTable.row(indexes).data();
                    console.log(rowData);
                }
            });
        });
    </script>
@endpush