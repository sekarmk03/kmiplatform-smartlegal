@extends('smartlegal::layouts.default_layout')
@section('title', 'Request | Mandatory')
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
		<li class="breadcrumb-item active">Request Mandatory</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Request Mandatory</h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col-12 ui-sortable">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Request Table</h4>
                    <div class="me-3">
                        <button type="button" class="btn btn-primary btn-sm" onclick="create()">
                            <i class="fas fa-plus"></i>
                            Create New
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
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Request No.</th>
                                        <th class="text-center">Kode Perizinan</th>
                                        <th class="text-center">Tipe Perizinan</th>
                                        <th class="text-center">Jenis Perizinan</th>
                                        <th class="text-center">Nama Perizinan</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">PIC</th>
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
                        <label class="form-label" for="DocName">Document Name<span style="color: red">*</span></label>
                        <input class="form-control" type="text" name="txtDocName" id="DocName" placeholder="Enter document name.." required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="TypeID">Type<span style="color: red">*</span></label>
                        <select class="select2 form-select" name="intTypeID" id="TypeID" required></select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="PICUser">PIC Document<span style="color: red">*</span></label>
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
                        <label class="form-label" for="">Variant<span style="color: red">*</span></label>
                        <div>
                            @foreach ($variants as $item)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="intVariantID" id="VariantID_{{ $item->intDocVariantID }}" value="{{ $item->intDocVariantID }}">
                                <label class="form-check-label" for="VariantID_{{ $item->intDocVariantID }}">{{ $item->txtVariantName }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="PublishDate">Publish Date<span style="color: red">*</span></label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="dtmPublishDate" id="PublishDate" placeholder="Enter document publish date.." data-date-format="yyyy-mm-dd" required/>
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    <div class="mb-3 renewal">
                        <label class="form-label" for="ExpireDate">Expire Date<span style="color: red">*</span></label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="dtmExpireDate" id="ExpireDate" placeholder="Enter document expire date.." data-date-format="yyyy-mm-dd"/>
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="IssuerID">Issuer<span style="color: red">*</span></label>
                        <select class="select2 form-select" name="intIssuerID" id="IssuerID" required></select>
                        <input class="form-control mt-1" type="text" name="txtOtherIssuer" id="OtherIssuer" placeholder="Enter issuer name.."/>
                    </div>
                    <div class="mb-3 renewal">
                        <label class="form-label" for="ReminderPeriod">Reminder Period<span style="color: red">*</span></label>
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
                        <label class="form-label" for="PICReminder">PIC Reminder<span style="color: red">*</span></label>
                        <select class="selectpicker form-select" name="picReminders[]" id="PICReminder" multiple></select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="LocationFilling">Location Filling<span style="color: red">*</span></label>
                        <input class="form-control" type="text" name="txtLocationFilling" id="LocationFilling" placeholder="Enter location filling document.." required/>
                    </div>
                    <div class="mb-3">
                        <label for="File" class="form-label">Pilih File<span style="color: red">*</span></label>
                        <input class="form-control" type="file" id="File" name="txtFile" required>
                    </div>
                    <div class="mb-3" id="FrameContainer">
                        <label for="FileFrame" class="form-label" id="FileNameLabel"></label>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive embed-responsive-16by9" src="" frameborder="0" width="100%" height="300px" id="FileFrame"></iframe>
                        </div>
                    </div>
                    <div class="mb-3 renewal">
                        <label class="form-label" for="RenewalCost">Renewal Cost<span style="color: red">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Rp</span>
                            <input class="form-control" type="number" name="intRenewalCost" id="RenewalCost" placeholder="Enter renewal cost (e.g. 250000).."/>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="CostCenter" class="form-label">Cost Center<span style="color: red">*</span></label>
                        <select class="select2 form-select" name="intCostCenterID" id="CostCenter" required>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="Notes">Notes</label>
                        <textarea name="txtNote" id="Notes" cols="30" rows="5" class="form-control" placeholder="Enter Document Notes.."></textarea>
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
    <!-- #modal-dialog-form note -->
    <div class="modal fade" id="modal-form-note">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Add Termination Note</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
            <form action="" id="termination-form">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="Notes">Notes<span style="color: red">*</span></label>
                        <textarea name="txtTerminationNote" id="TerminationNotes" cols="30" rows="7" class="form-control" placeholder="Enter Termination Notes.." required></textarea>
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
            responsive: true,
            ajax: "{{ route('smartlegal.request.mandatory.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center'},
                {data: 'created_at', name: 'created_at', className: 'text-center'},
                {data: 'request_number', name: 'request_number', className: 'text-center'},
                {data: 'doc_number', name: 'doc_number', className: 'text-center'},
                {data: 'type', name: 'type', className: 'text-center'},
                {data: 'variant', name: 'variant', className: 'text-center'},
                {data: 'doc_name', name: 'doc_name', className: 'text-center'},
                {data: 'status', name: 'status', className: 'text-center'},
                {data: 'pic', name: 'pic', className: 'text-center'},
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
                wrapper.on('sp-change', () => {
                    let selectedValue = wrapper.val();
                    wrapper.val(selectedValue).picker();
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
                option += `<option value="0">Other..</option>`;
                wrapper.append(option);
                wrapper.val(id).trigger('change');
            });
        }

        const create = () => {
            $('.modal-header h4').html('Create New Request');
            $('#modal-form').modal('show');
            $("#FrameContainer").hide();
            $('#OtherIssuer').hide().removeAttr('required').val('');
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
            $('#IssuerID').change(() => {
                if ($('#IssuerID').val() == 0) {
                    $('#OtherIssuer').show().prop('required', true);
                } else {
                    $('#OtherIssuer').hide().removeAttr('required').val('');
                }
            });
            getAllUsers('PICReminder', []);
            url = "{{ route('smartlegal.request.mandatory.store') }}";
            method = "POST";
        }

        const update = ( id ) => {
            // id document
            $('.modal-header h4').html('Update Document');
            let editUrl = "{{ route('smartlegal.request.mandatory.edit', ':id') }}";
            editUrl = editUrl.replace(':id', id);
            url = "{{ route('smartlegal.request.mandatory.update', ':id') }}";
            url = url.replace(':id', id);
            $('.modal-body form').append('<input type="hidden" name="_method" value="PUT">');
            method = "POST";
            $.get(editUrl, (response) => {
                $('#modal-form').modal('show');
                $('#OtherIssuer').hide().removeAttr('required').val('');
                let selectedVal = response.data.intVariantID;
                if (selectedVal == 1) {
                    $('div.renewal').hide();
                } else if (selectedVal == 2) {
                    $('div.renewal').show();
                }
                $('input#DocName').val(response.data.txtDocName);
                getAllDocTypes('TypeID', response.data.intTypeID);
                $('select#TypeID').prop('disabled', true);
                getAllDepartments('PICDepartment', response.data.intPICDeptID);
                $('select#PICDepartment').prop('disabled', true);
                getUsersByDepartments('PICUser', response.data.intPICUserID, response.data.intPICDeptID);
                $('input[name="intVariantID"][value="' + response.data.intVariantID + '"]').prop('checked', true);
                $('input[name="intVariantID"]').change(() => {
                    selectedVal = $('input[name="intVariantID"]:checked').val();

                    if (selectedVal == 1) {
                        $('div.renewal').hide();
                    } else if (selectedVal == 2) {
                        $('div.renewal').show();
                    }
                });
                $('input#PublishDate').val(response.data.dtmPublishDate);
                $('input#ExpireDate').val(response.data.dtmExpireDate);
                getAllIssuers('IssuerID', response.data.intIssuerID);
                $('#IssuerID').change(() => {
                    if ($('#IssuerID').val() == 0) {
                        $('#OtherIssuer').show().prop('required', true);
                    } else {
                        $('#OtherIssuer').hide().removeAttr('required').val('');
                    }
                });
                $('input#ReminderPeriod').val(response.data.intReminderPeriod);
                $('select#RemPeriodUnit').val(response.data.remPeriodUnit);
                getAllUsers('PICReminder', response.data.picReminders);
                $('input#LocationFilling').val(response.data.txtLocationFilling);
                $("#FileNameLabel").html(response.data.txtFilename);
                $('iframe#FileFrame').attr('src', response.data.txtPath);
                $('input#RenewalCost').val(response.data.intRenewalCost);
                getAllDepartments('CostCenter', response.data.intCostCenterID);
                $('textarea#Notes').val(response.data.txtNote);
            });
        }

        const terminate = ( id ) => {
            $('#modal-form-note').modal('show');
            url = "{{ route('smartlegal.request.mandatory.terminate', ':id') }}";
            url = url.replace(':id', id);
            method = "PUT";
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
            $('#modal-form, #modal-form-note').on('hidden.bs.modal', () => {
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
            $('#modal-form .modal-body form').on('submit', (e) => {
                e.preventDefault();
                let formData = new FormData($('.modal-body form')[0]);
                console.log(formData);
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
                        location.reload();
                        notification(response.status, response.message,'bg-success');
                        conn.send(['success', 'request']);
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
            $('#modal-form-note .modal-body form').on('submit', (e) => {
                e.preventDefault();
                let formData = $('#modal-form-note .modal-body form').serialize();
                let contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
                console.log(formData);
                $.ajax({
                    url: getUrl(),
                    method: getMethod(),
                    data: formData,
                    dataType: 'JSON',
                    contentType: contentType,
                    success: (response) => {
                        $('#modal-form-note').modal('hide');
                        refresh();
                        location.reload();
                        notification(response.status, response.message,'bg-success');
                        conn.send(['success', 'terminate']);
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