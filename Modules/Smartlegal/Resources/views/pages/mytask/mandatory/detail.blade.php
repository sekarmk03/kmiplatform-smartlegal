@extends('smartlegal::layouts.default_layout')
@section('title', 'Detail Request')
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/select-picker/dist/picker.min.css') }}" rel="stylesheet">
    <style>
        td {
            vertical-align: top;
        }
        tr td:first-child {
            white-space: nowrap;
        }
    </style>
@endpush
@section('content')
    <!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="javascript:;">My Task</a></li>
		<li class="breadcrumb-item active">Detail</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Detail Request</h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col ui-sortable me-1">
            <div class="panel panel-inverse">
                <div class="panel-body">
                    <div class="row px-3 pb-4">
                        <div class="text-center mb-1">
                            <h3>No. {{ $mandatory['request_number'] }}</h3>
                            <p class="fst-italic mb-0">Diajukan pada {{ $mandatory['created_at'] }}</p>
                            <p class="fst-italic mt-0">Terakhir diubah {{ $mandatory['updated_at'] }}</p>
                        </div>
                        <hr>
                        <table class="fs-5">
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
                                <td>Nama Dokumen</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['doc_name'] }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['status'] }}</td>
                            </tr>
                            <tr>
                                <td>Tipe Perizinan</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['type'] }}</td>
                            </tr>
                            <tr>
                                <td>PIC Dokumen</td>
                                <td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['pic'] }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Dokumen</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['variant'] }}</td>
                            </tr>
                            <tr>
                                <td>Masa Berlaku</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['exp_period'] }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Awal</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['publish_date'] }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Akhir</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['exp_date'] }}</td>
                            </tr>
                            <tr>
                                <td>Penerbit Dokumen</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['issuer'] }}</td>
                            </tr>
                            <tr>
                                <td>Periode Reminder</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['rem_period'] }}</td>
                            </tr>
                            <tr>
                                <td>Filling Hardcopy</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['location'] }}</td>
                            </tr>
                            <tr>
                                <td>Biaya Renewal</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['renewal_cost'] }}</td>
                            </tr>
                            <tr>
                                <td>Cost Center</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['cost_center'] }}</td>
                            </tr>
                            <tr>
                                <td>Catatan</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['note'] }}</td>
                            </tr>
                        </table>
                        @if ($mandatory['status'] == 'Requested' || $mandatory['status'] == 'Revised')
                        <div class="mt-4 px-5 mb-3">
                            <div class="btn-group w-100 fs-4">
                                <button type="button" class="btn btn-primary" onclick="addNote({{ $mandatory['doc_id'] }}, 2)">
                                    <i class="fas fa-pencil-alt"></i>
                                    Revise
                                </button>
                                <button type="button" class="btn btn-green" onclick="addNote({{ $mandatory['doc_id'] }}, 3)">
                                    <i class="fas fa-check"></i>
                                    Approve
                                </button>
                                <button type="button" class="btn btn-danger" onclick="addNote({{ $mandatory['doc_id'] }}, 4)">
                                    <i class="fas fa-reply"></i>
                                    Reject
                                </button>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-primary" onclick="edit({{ $mandatory['doc_id'] }})">
                                    <i class="fas fa-pencil-alt"></i>
                                    Edit Request
                                </button>
                            </div>
                        </div>
                        @endif
                        <div>
                            <form action="" method="" id="formNote">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label" for="Note">Catatan</label>
                                    <input type="text" hidden id="noteType" name="noteType">
                                    <textarea name="txtNote" id="Note" cols="30" rows="5" class="form-control" placeholder="Masukkan catatan"></textarea>
                                </div>
                                <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col ui-sortable">
            <div class="panel panel-inverse">
                <div class="panel-body">
                    <div class="row embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive embed-responsive-16by9" src="{{ asset($mandatory['file_path']) }}" frameborder="0" width="100%" height="600px"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col ui-sortable mt-3">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Reviewer Notes</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                        <a type="button" onclick="refresh()" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="daTable" class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Status</th>
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
                        <input class="form-control" type="text" name="txtRequestNumber" id="RequestNumber" placeholder="YYYY/Reg-[No.Type]/[Dept]/xxxx" disabled/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="DocNumber">Document Number</label>
                        <input class="form-control" type="text" name="txtDocNumber" id="DocNumber" placeholder="[Category][No.Type][Dept]xxxx-xx" disabled/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="DocName">Document Name</label>
                        <input class="form-control" type="text" name="txtDocName" id="DocName" placeholder="Enter document name.."/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="TypeID">Type</label>
                        <select class="select2 form-select" name="intTypeID" id="TypeID" disabled></select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">PIC Document</label>
                        <div class="input-group">
                            <div class="col-4">
                                <select class="select2 form-select" name="intPICDeptID" id="PICDepartment" disabled></select>
                            </div>
                            <div class="col">
                                <select class="select2 form-select" name="intPICUserID" id="PICUser"></select>
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
                    <div class="mb-3">
                        <label class="form-label" for="PublishDate">Publish Date</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="dtmPublishDate" id="PublishDate" placeholder="Enter document publish date.." data-date-format="yyyy-mm-dd"/>
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
                        <select class="select2 form-select" name="intIssuerID" id="IssuerID"></select>
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
                        <input class="form-control" type="text" name="txtLocationFilling" id="LocationFilling" placeholder="Enter location filling document.."/>
                    </div>
                    <div class="mb-3">
                        <label for="File" class="form-label">Pilih File</label>
                        <input class="form-control" type="file" id="File" name="txtFile">
                    </div>
                    <div class="mb-3" id="FrameContainer">
                        <label for="FileFrame" class="form-label" id="FileNameLabel"></label>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive embed-responsive-16by9" src="" frameborder="0" width="100%" height="300px" id="FileFrame"></iframe>
                        </div>
                    </div>
                    <div class="mb-3 renewal">
                        <label class="form-label" for="RenewalCost">Renewal Cost</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Rp</span>
                            <input class="form-control" type="number" name="intRenewalCost" id="RenewalCost" placeholder="Enter renewal cost (e.g. 250000).."/>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="CostCenter" class="form-label">Cost Center</label>
                        <select class="select2 form-select" name="intCostCenterID" id="CostCenter">
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
@endsection
@push('scripts')
    <script src="{{ asset('/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
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
            ajax: "{{ route('smartlegal.master.approval.document', $mandatory['doc_id']) }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center'},
                {data: 'status', name: 'status', className: 'text-center'},
                {data: 'name', name: 'name', className: 'text-center'},
                {data: 'date', name: 'date', className: 'text-center'},
                {data: 'note', name: 'note', width: '40%'},
                {data: 'lead_time', name: 'lead_time', className: 'text-center'},
            ]
        });
        
        const getUrl = () => url;
        const getMethod = () => method;
        const refresh = () => location.reload();

        const addNote = ( id, action ) => {
            $('#formNote').show();
            const actionList = {
                2: 'revise',
                3: 'approve',
                4: 'reject'
            };
            if (action != 0 && action in actionList) {
                $('#noteType').val(action);
                $('textarea#Note').attr('placeholder', `Masukkan catatan ${actionList[action]}`);
                url = "{{ route('smartlegal.mytask.mandatory.approve', ':id') }}";
                url = url.replace(':id', id);
                method = "PUT";
            }
        }

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
                wrapper.append(option);
                wrapper.val(id).trigger('change');
            });
        }

        const edit = ( id ) => {
            // id document
            $('.modal-header h4').html('Update Document Request');
            let editUrl = "{{ route('smartlegal.mytask.mandatory.edit', ':id') }}";
            editUrl = editUrl.replace(':id', id);
            url = "{{ route('smartlegal.mytask.mandatory.update', ':id') }}";
            url = url.replace(':id', id);
            $('.modal-body form').append('<input type="hidden" name="_method" value="PUT">');
            method = "POST";
            $.get(editUrl, (response) => {
                $('#modal-form').modal('show');
                $('input#RequestNumber').val(response.data.txtRequestNumber);
                $('input#DocNumber').val(response.data.txtDocNumber);
                $('input#DocName').val(response.data.txtDocName);
                getAllDocTypes('TypeID', response.data.intTypeID);
                getAllDepartments('PICDepartment', response.data.intPICDeptID);
                getUsersByDepartments('PICUser', response.data.intPICUserID, response.data.intPICDeptID);
                $('input[name="intVariantID"][value="' + response.data.intVariantID + '"]').prop('checked', true);
                $('input#PublishDate').val(response.data.dtmPublishDate);
                $('input#ExpireDate').val(response.data.dtmExpireDate);
                getAllIssuers('IssuerID', response.data.intIssuerID);
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

        const notification = (status, message, bgclass) => {
            $.gritter.add({
                title: status,
                text: `<p class="text-light">${message}</p>`,
                class_name: bgclass
            });
            return false;
        }

        $(document).ready(() => {
            $('#formNote').hide();
            $('#formNote').on('submit', (e) => {
                e.preventDefault();
                $.ajax({
                    url: getUrl(),
                    method: getMethod(),
                    data: $('#formNote').serialize(),
                    dataType: "JSON",
                    success: (response) => {
                        refresh();
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
            $('select#TypeID').select2({
                disabled: true,
                placeholder: {
                    id: '-1',
                    text: 'Select Document Type'
                },
                dropdownParent: $('#modal-form')
            });
            $('select#PICDepartment').select2({
                disabled: true,
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
        });
    </script>
@endpush