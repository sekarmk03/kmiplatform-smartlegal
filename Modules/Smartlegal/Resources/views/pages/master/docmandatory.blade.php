@extends('smartlegal::layouts.default_layout')
@section('title', 'Document Mandatory')
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    <!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
		<li class="breadcrumb-item active">Document Mandatory</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Document Mandatory</h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col-12 ui-sortable">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Mandatory Table</h4>
                    <div class="me-3">
                        <button type="button" class="btn btn-primary btn-sm" onclick="create()">
                            <i class="fas fa-plus"></i>
                            Add New Document
                        </button>
                    </div>
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
                                        <th class="text-center">CREATED BY</th>
                                        <th class="text-center">REQUEST NUMBER</th>
                                        <th class="text-center">DOCUMENT NUMBER</th>
                                        <th class="text-center">DOCUMENT NAME</th>
                                        <th class="text-center">STATUS</th>
                                        <th class="text-center">TYPE</th>
                                        <th class="text-center">PIC</th>
                                        <th class="text-center">VARIANT</th>
                                        <th class="text-center">EXP PERIOD</th>
                                        <th class="text-center">PUBLISH DATE</th>
                                        <th class="text-center">EXPIRE DATE</th>
                                        <th class="text-center">ISSUER</th>
                                        <th class="text-center">REMINDER PERIOD</th>
                                        <th class="text-center">LOCATION FILLING</th>
                                        <th class="text-center">RENEWAL COST</th>
                                        <th class="text-center">COST CENTER</th>
                                        <th class="text-center">NOTE</th>
                                        <th class="text-center">TERMINATION NOTE</th>
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
    <!-- #modal-dialog-form -->
    <div class="modal fade" id="modal-form">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Modal Dialog</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="RequestNumber">Request Number</label>
                        <input class="form-control" type="text" name="txtRequestNumber" id="RequestNumber" placeholder="YYYY/Reg-[No.Type]/[Dept]/xxxx" required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="DocNumber">Document Number</label>
                        <input class="form-control" type="text" name="txtDocNumber" id="DocNumber" placeholder="[Category][No.Type][Dept]xxxx-xx" required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="DocName">Document Name</label>
                        <input class="form-control" type="text" name="txtDocName" id="DocName" placeholder="Enter document name.." required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="TypeID">Type</label>
                        <select class="select2 form-select" name="intTypeID" id="TypeID" required>
                            @foreach ($types as $item)
                            <option value="{{ $item->intTypeID }}">{{ $item->txtTypeName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="PICUser">PIC Document</label>
                        <div class="input-group">
                            <div class="col-5">
                                <select class="select2 form-select" name="intDepartment_ID" id="PICDepartment" required>
                                    @foreach ($departments as $item)
                                    <option value="{{ $item->intDepartment_ID }}">{{ $item->txtInitial }} - {{ $item->txtDepartmentName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select class="select2 form-select" name="intUserID" id="PICUser" required>
                                    @foreach ($users as $item)
                                    <option value="{{ $item->intUserID }}">{{ $item->txtInitial }} - {{ $item->txtName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="VariantID">Variant</label>
                        <div>
                            @foreach ($variants as $item)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="intVariantID" id="VariantID" value="{{ $item->intVariantID }}">
                                <label class="form-check-label" for="VariantID">{{ $item->txtVariantName }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ExpirationPeriod">Expiration Period</label>
                        <div class="input-group">
                            <input class="form-control" type="number" name="intExpirationPeriod" id="ExpirationPeriod" placeholder="Enter expiration period (day format).." required/>
                            <div class="col-3">
                                <select class="select2 form-select" name="intPeriodUnit" id="PeriodUnit" required>
                                    <option value="tahun">Tahun</option>
                                    <option value="bulan">Bulan</option>
                                    <option value="minggu">Minggu</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="PublishDate">Publish Date</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="dtmPublishDate" id="PublishDate" placeholder="Enter document publish date.." required/>
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ExpireDate">Expire Date</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="dtmExpireDate" id="ExpireDate" placeholder="Enter document expire date.." required/>
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="IssuerID">Issuer</label>
                        <select class="select2 form-select" name="intIssuerID" id="IssuerID" required>
                            @foreach ($issuers as $item)
                            <option value="{{ $item->intIssuerID }}">{{ $item->txtIssuerName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ReminderPeriod">Reminder Period</label>
                        <div class="input-group">
                            <input class="form-control" type="number" name="intReminderPeriod" id="ReminderPeriod" placeholder="Enter reminder period (day format).." required/>
                            <div class="col-3">
                                <select class="select2 form-select" name="intPeriodUnit" id="PeriodUnit" required>
                                    <option value="tahun">Tahun</option>
                                    <option value="bulan">Bulan</option>
                                    <option value="minggu">Minggu</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="LocationFilling">Location Filling</label>
                        <input class="form-control" type="text" name="txtLocationFilling" id="LocationFilling" placeholder="Enter location filling document.." required/>
                    </div>
                    <div class="mb-3">
                        <label for="File" class="form-label">Pilih File</label>
                        <input class="form-control" type="file" id="File" name="txtFile" required>
                    </div>
                    <div class="mb-3" id="FrameContainer">
                        <label for="FileFrame" class="form-label" id="FileNameLabel"></label>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive embed-responsive-16by9" src="" frameborder="0" width="100%" height="300px" id="FileFrame"></iframe>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="RenewalCost">Renewal Cost</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Rp</span>
                            <input class="form-control" type="number" name="intRenewalCost" id="RenewalCost" placeholder="Enter renewal cost (e.g. 250000).." required/>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="CostCenter" class="form-label">Cost Center</label>
                        <select class="select2 form-select" name="intDepartment_ID" id="CostCenter" required>
                            @foreach ($departments as $item)
                            <option value="{{ $item->intDepartment_ID }}">{{ $item->txtInitial }} - {{ $item->txtDepartmentName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="Notes">Notes</label>
                        <textarea name="txtNote" id="Notes" cols="30" rows="5" class="form-control" placeholder="Enter Document Notes.."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="TerminationNotes">Termination Notes</label>
                        <textarea name="txtTerminationNote" id="TerminationNotes" cols="30" rows="5" class="form-control" placeholder="Enter Termination Notes (if the document was terminated).."></textarea>
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
    <script src="{{ asset('/plugins/gritter/js/jquery.gritter.js') }}"></script>
    <script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
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
            responsive: false,
            ajax: "{{ route('smartlegal.master.mandatory.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center'},
                {data: 'created_at', name: 'created_at', className: 'text-center'},
                {data: 'requested_by', name: 'requested_by', className: 'text-center'},
                {data: 'request_number', name: 'request_number', className: 'text-center'},
                {data: 'doc_number', name: 'doc_number', className: 'text-center'},
                {data: 'doc_name', name: 'doc_name', className: 'text-center'},
                {data: 'status', name: 'status', className: 'text-center'},
                {data: 'type', name: 'type', className: 'text-center'},
                {data: 'pic', name: 'pic', className: 'text-center'},
                {data: 'variant', name: 'variant', className: 'text-center'},
                {data: 'exp_period', name: 'exp_period', className: 'text-center'},
                {data: 'publish_date', name: 'publish_date', className: 'text-center'},
                {data: 'exp_date', name: 'exp_date', className: 'text-center'},
                {data: 'issuer', name: 'issuer', className: 'text-center'},
                {data: 'rem_period', name: 'rem_period', className: 'text-center'},
                {data: 'location', name: 'location', className: 'text-center'},
                {data: 'renewal_cost', name: 'renewal_cost', className: 'text-center'},
                {data: 'cost_center', name: 'cost_center', className: 'text-center'},
                {
                    data: 'note',
                    name: 'note',
                    render: (data, type, row) => {
                        if (type === 'display') {
                            return '<div style="word-wrap: break-word; max-width: 700px;">' + data + '</div>';
                        }
                        return data;
                    }
                },
                {
                    data: 'termination_note',
                    name: 'termination_note',
                    render: (data, type, row) => {
                        if (type === 'display') {
                            return '<div style="word-wrap: break-word; max-width: 700px;">' + data + '</div>';
                        }
                        return data;
                    }
                },
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

        const create = () => {
            $('.modal-header h4').html('Add Mandatory Document');
            $('#modal-form').modal('show');
            $("#FrameContainer").hide();
        }

        $(document).ready(() => {
            $('.notif-icon').find('span').text();
            $('#modal-form').on('hide.bs.modal', () => {
                $('#TypeID').val(null).trigger('change');
                $('input#File').val('');
                $('input[name="_method"]').remove();
                $('select#TypeID').val(null).trigger('change');
            });
            $("#PublishDate").datepicker({
                todayHighlight: true,
                autoclose: true
            });
            $("#ExpireDate").datepicker({
                todayHighlight: true,
                autoclose: true
            });
            $('#TypeID').select2({
                allowClear: true,
                placeholder: {
                    id: '-1',
                    text: 'Select Document Type'
                },
                dropdownParent: $('#modal-form')
            });
            $('#PICDepartment').select2({
                allowClear: true,
                placeholder: {
                    id: '-1',
                    text: 'Select PIC Department'
                },
                dropdownParent: $('#modal-form')
            });
            $('#PICUser').select2({
                allowClear: true,
                placeholder: {
                    id: '-1',
                    text: 'Select PIC User'
                },
                dropdownParent: $('#modal-form')
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