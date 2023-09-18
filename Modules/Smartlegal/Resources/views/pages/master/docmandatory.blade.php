@extends('smartlegal::layouts.default_layout')
@section('title', 'Document Mandatory')
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/select-picker/dist/picker.min.css') }}" rel="stylesheet">
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
                                        <th class="text-center">PIC DOCUMENT</th>
                                        <th class="text-center">VARIANT</th>
                                        <th class="text-center">EXP PERIOD</th>
                                        <th class="text-center">PUBLISH DATE</th>
                                        <th class="text-center">EXPIRED DATE</th>
                                        <th class="text-center">ISSUER</th>
                                        <th class="text-center">REMINDER PERIOD</th>
                                        <th class="text-center">PIC REMINDER</th>
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
        <div class="modal-dialog modal-lg">
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
                        <label class="form-label" for="StatusID">Status</label>
                        <select class="select2 form-select" name="intDocStatusID" id="StatusID"></select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="TypeID">Type</label>
                        <select class="select2 form-select" name="intTypeID" id="TypeID" required></select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="PICUser">PIC Document</label>
                        <div class="input-group">
                            <div class="col-4">
                                <select class="select2 form-select" name="intPICDeptID" id="PICDepartment" required></select>
                            </div>
                            <div class="col">
                                <select class="select2 form-select" name="intPICUserID" id="PICUser" required></select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="">Variant</label>
                        <div>
                            @foreach ($variants as $item)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="intVariantID" id="VariantID_{{ $item->intDocVariantID }}" value="{{ $item->intDocVariantID }}">
                                <label class="form-check-label" for="VariantID_{{ $item->intDocVariantID }}">{{ $item->txtVariantName }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3 renewal">
                        <label class="form-label" for="ExpirationPeriod">Expiration Period</label>
                        <div class="input-group">
                            <input class="form-control" type="number" name="intExpirationPeriod" id="ExpirationPeriod" placeholder="Enter expiration period (day format).."/>
                            <div class="col-3">
                                <select class="select2 form-select" name="expPeriodUnit" id="ExpPeriodUnit">
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
                            <input class="form-control" type="text" name="dtmPublishDate" id="PublishDate" placeholder="Enter document publish date.." data-date-format="yyyy-mm-dd" required/>
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    <div class="mb-3 renewal">
                        <label class="form-label" for="ExpireDate">Expire Date</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="dtmExpireDate" id="ExpireDate" placeholder="Enter document expire date.." data-date-format="yyyy-mm-dd"/>
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="IssuerID">Issuer</label>
                        <select class="select2 form-select" name="intIssuerID" id="IssuerID" required></select>
                    </div>
                    <div class="mb-3 renewal">
                        <label class="form-label" for="ReminderPeriod">Reminder Period</label>
                        <div class="input-group">
                            <input class="form-control" type="number" name="intReminderPeriod" id="ReminderPeriod" placeholder="Enter reminder period (day format).."/>
                            <div class="col-3">
                                <select class="select2 form-select" name="remPeriodUnit" id="RemPeriodUnit">
                                    <option value="tahun">Tahun</option>
                                    <option value="bulan">Bulan</option>
                                    <option value="minggu">Minggu</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 renewal">
                        <label class="form-label" for="PICReminder">PIC Reminder</label>
                        <select class="selectpicker form-select" name="picReminders[]" id="PICReminder" multiple></select>
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
                        <select class="select2 form-select" name="intCostCenterID" id="CostCenter" required>
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
    <script src="{{ asset('/plugins/select-picker/dist/picker.min.js') }}"></script>
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
                {data: 'pic', name: 'pic', className: 'text-center', width: '10%'},
                {data: 'variant', name: 'variant', className: 'text-center'},
                {data: 'exp_period', name: 'exp_period', className: 'text-center'},
                {data: 'publish_date', name: 'publish_date', className: 'text-center'},
                {data: 'exp_date', name: 'exp_date', className: 'text-center'},
                {data: 'issuer', name: 'issuer', className: 'text-center'},
                {data: 'rem_period', name: 'rem_period', className: 'text-center'},
                {data: 'pic_reminder', name: 'pic_reminder', className: 'text-center'},
                {data: 'location', name: 'location', className: 'text-center'},
                {data: 'renewal_cost', name: 'renewal_cost', className: 'text-center'},
                {data: 'cost_center', name: 'cost_center', className: 'text-center'},
                {
                    data: 'note',
                    name: 'note',
                    width: '30%'
                },
                {
                    data: 'termination_note',
                    name: 'termination_note',
                    width: '30%'
                },
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'},
            ]
        });
        
        const getUrl = () => url;
        const getMethod = () => method;
        const refresh = () => daTable.ajax.reload(null, false);

        const getAllDepartments = ( wrapperID, id = false ) => {
            let wrapper = $('select#' + wrapperID);
            let option = '';
            wrapper.empty();
            $.get("{{ route('smartlegal.departments') }}", (response) => {
                $.each(response.data, (i, val) => {
                    option += `<option value="${val.intDepartment_ID}">${val.txtInitial} - ${val.txtDepartmentName}</option>`;
                });
                wrapper.append(option);
                wrapper.val(id).trigger('change');
            });
        }

        const getAllUsers = ( wrapperID, id = [] ) => {
            let wrapper = $('select#' + wrapperID);
            let option = '';
            wrapper.empty();
            $.get("{{ route('smartlegal.users') }}", (response) => {
                $.each(response.data, (i, val) => {
                    option += `<option value="${val.id}">${val.txtInitial} - ${val.txtName}</option>`;
                });
                wrapper.append(option);
                wrapper.attr('multiple', true);
                wrapper.picker({
                    search: true,
                    searchAutofocus: true,
                    texts: {
                        trigger: 'Select PIC Reminder',
                        noResult : "No results",
                        search : "Search"
                    }
                });
                $.each(id, (i, val) => {
                    wrapper.picker('set', val);
                });
            });
        }

        const getUsersByDepartments = ( wrapperID, id = false, deptID ) => {
            let wrapper = $('select#' + wrapperID);
            let option = '';
            wrapper.empty();
            let getUrl = "{{ route('smartlegal.users.department', ':id') }}";
            getUrl = getUrl.replace(':id', deptID);
            $.get(getUrl, (response) => {
                $.each(response.data, (i, val) => {
                    option += `<option value="${val.id}">${val.txtInitial} - ${val.txtName}</option>`;
                });
                wrapper.append(option);
                wrapper.val(id).trigger('change');
            });
        }

        const getAllDocStatuses = ( wrapperID, id = false ) => {
            let wrapper = $('select#' + wrapperID);
            let option = '';
            wrapper.empty();
            $.get("{{ route('smartlegal.master.docstatuses') }}", (response) => {
                $.each(response.data, (i, val) => {
                    option += `<option value="${val.intDocStatusID}">${val.txtStatusName}</option>`;
                });
                wrapper.append(option);
                wrapper.val(id).trigger('change');
            });
        }

        const getAllDocTypes = ( wrapperID, id = false ) => {
            let wrapper = $('select#' + wrapperID);
            let option = '';
            wrapper.empty();
            $.get("{{ route('smartlegal.master.doctypes') }}", (response) => {
                $.each(response.data, (i, val) => {
                    option += `<option value="${val.intDocTypeID}">${val.txtTypeName}</option>`;
                });
                wrapper.append(option);
                wrapper.val(id).trigger('change');
            });
        }

        const getAllIssuers = ( wrapperID, id = false ) => {
            let wrapper = $('select#' + wrapperID);
            let option = '';
            wrapper.empty();
            $.get("{{ route('smartlegal.master.issuers') }}", (response) => {
                $.each(response.data, (i, val) => {
                    option += `<option value="${val.intIssuerID}">${val.txtCode} - ${val.txtIssuerName}</option>`;
                });
                wrapper.append(option);
                wrapper.val(id).trigger('change');
            });
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

        const create = () => {
            $('.modal-header h4').html('Add Mandatory Document');
            $('#modal-form').modal('show');
            $("#FrameContainer").hide();
            getAllDocStatuses('StatusID', false);
            getAllDocTypes('TypeID', false);
            getAllDepartments('PICDepartment', false);
            $('select#PICDepartment').change(() => {
                let selectedOpt = $('select#PICDepartment').val();
                getUsersByDepartments('PICUser', false, selectedOpt);
            });
            getAllDepartments('CostCenter', false);
            $('input[name="intVariantID"]').change(() => {
                let selectedVal = $('input[name="intVariantID"]:checked').val();

                if (selectedVal == 1) {
                    $('div.renewal').hide();
                } else if (selectedVal == 2) {
                    $('div.renewal').show();
                }
            });
            getAllIssuers('IssuerID', false);
            getAllUsers('PICReminder', []);
            url = "{{ route('smartlegal.master.mandatory.store') }}";
            method = "POST";
        }

        const edit = ( id ) => {
            // id document
            $('.modal-header h4').html('Edit Mandatory Document');
            let editUrl = "{{ route('smartlegal.master.mandatory.edit', ':id') }}";
            editUrl = editUrl.replace(':id', id);
            url = "{{ route('smartlegal.master.mandatory.update', ':id') }}";
            url = url.replace(':id', id);
            method = "PUT";
            $.get(editUrl, (response) => {
                $('#modal-form').modal('show');
                $('input#RequestNumber').val(response.data.txtRequestNumber);
                $('input#DocNumber').val(response.data.txtDocNumber);
                $('input#DocName').val(response.data.txtDocName);
                getAllDocStatuses('StatusID', response.data.intStatusID);
                getAllDocTypes('TypeID', response.data.intTypeID);
                getAllDepartments('PICDepartment', response.data.intPICDeptID);
                $('select#PICDepartment').change(() => {
                    let selectedOpt = $('select#PICDepartment').val();
                    getUsersByDepartments('PICUser', response.data.intPICUserID, selectedOpt);
                });
                // getUsersByDepartments('PICUser', response.data.intPICUserID, response.data.intPICDeptID);
                // getAllUsers('PICUser', response.data.intPICUserID);
                $('input[name="intVariantID"][value="' + response.data.intVariantID + '"]').prop('checked', true);
                // expiration period -> n & unit
                $('input#ExpirationPeriod').val(response.data.intExpirationPeriod);
                $('input#PublishDate').val(response.data.dtmPublishDate);
                $('input#ExpireDate').val(response.data.dtmExpireDate);
                getAllIssuers('IssuerID', response.data.intIssuerID);
                // reminder period -> n & unit
                $('input#ReminderPeriod').val(response.data.intReminderPeriod);
                getAllUsers('PICReminder', response.data.picReminders);
                $('input#LocationFilling').val(response.data.txtLocationFilling);
                $("#FileNameLabel").html(response.data.txtFilename);
                $('iframe#FileFrame').attr('src', response.data.txtPath);
                $('input#RenewalCost').val(response.data.intRenewalCost);
                getAllDepartments('CostCenter', response.data.intCostCenterID);
                $('textarea#Notes').val(response.data.txtNote);
                $('textarea#TerminationNotes').val(response.data.txtTerminationNote);
            });
        }

        const destroy = ( id ) => {

        }

        $(document).ready(() => {
            $('.notif-icon').find('span').text();
            $('#modal-form').on('hidden.bs.modal', () => {
                $('#TypeID').val(null).trigger('change');
                $('input#File').val('');
                $('#modal-form form')[0].reset();
                $('input[name="_method"]').remove();
            });
            $("input#PublishDate, input#ExpireDate").datepicker({
                todayHighlight: true,
                autoclose: true
            });
            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });
            $('select#StatusID').select2({
                allowClear: true,
                placeholder: {
                    id: '-1',
                    text: 'Select Document Status'
                },
                dropdownParent: $('#modal-form')
            });
            $('select#TypeID').select2({
                allowClear: true,
                placeholder: {
                    id: '-1',
                    text: 'Select Document Type'
                },
                dropdownParent: $('#modal-form')
            });
            $('select#PICDepartment').select2({
                allowClear: true,
                placeholder: {
                    id: '-1',
                    text: 'Select PIC Department'
                },
                dropdownParent: $('#modal-form')
            });
            $('select#PICUser').select2({
                allowClear: true,
                placeholder: {
                    id: '-1',
                    text: 'Select PIC User'
                },
                dropdownParent: $('#modal-form')
            });
            $('select#IssuerID').select2({
                allowClear: true,
                placeholder: {
                    id: '-1',
                    text: 'Select Document Issuer'
                },
                dropdownParent: $('#modal-form')
            });
            $('select#CostCenter').select2({
                allowClear: true,
                placeholder: {
                    id: '-1',
                    text: 'Select Cost Center Department'
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