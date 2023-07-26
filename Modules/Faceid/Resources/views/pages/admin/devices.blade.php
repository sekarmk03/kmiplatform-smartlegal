@extends('roonline::layouts.default_layout')
@section('title', 'Manage Devices')
@push('css')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link href="{{ asset('/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
<link href="{{ asset('/plugins/select-picker/dist/picker.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
<!-- BEGIN breadcrumb -->
<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
    <li class="breadcrumb-item active">Manage Devices</li>
</ol>
<!-- END breadcrumb -->
<!-- BEGIN page-header -->
<h1 class="page-header">Manage Devices</h1>
<!-- END page-header -->
<div class="row">
    <div class="col">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Devices Table</h4>
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                    <a type="button" onclick="refresh()" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row my-3">
                    <div class="col-md-2 ms-auto">
                        <button class="btn btn-sm btn-success float-end" onclick="create()"><i class="fa-solid fa-plus"></i> New Devices</button>
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
                                    <th>CREATED BY</th>
                                    <th>MODULE NAME</th>
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
                <form action="" method="post" id="form-level" data-parsley-validate="true">
                    <div class="mb-3">
                        <label for="Locater" class="form-label">Locater</label>
                        <select class="select2 form-control" id="Locater" name="intLocater_ID" data-parsley-required="true">
                            @foreach ($locaters as $item)
                            <option value="{{ $item->intLocater_ID }}">{{ $item->txtLocaterName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" id="ModuleName">Module Name</label>
                        <input class="form-control" type="text" name="txtModuleName" id="ModuleName" placeholder="Module Name" oninput="this.value = this.value.toUpperCase()" />
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input name="activate" class="form-check-input" type="checkbox" id="checkBox" value="1" />
                            <label class="form-check-label" for="checkBox">Activate?</label>
                        </div>
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
<script src="{{ asset('/plugins/select-picker/dist/picker.min.js') }}"></script>
<script src="{{ asset('/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
<script src="{{ asset('/plugins/gritter/js/jquery.gritter.js') }}"></script>
<script>
    let url = '';
    let method = '';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var daTable = $('#daTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('roonline.manage.device') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'dtmInserted',
                name: 'dtmInserted'
            },
            {
                data: 'txtInsertedBy',
                name: 'txtInsertedBy'
            },
            {
                data: 'txtModuleName',
                name: 'txtModuleName'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

    function getUrl() {
        return url;
    }

    function getMethod() {
        return method;
    }

    function refresh() {
        daTable.ajax.reload(null, false);
    }

    function create() {
        $('.modal-header h4').html('Create Level');
        $('#modal-level').modal('show');
        url = "{{ route('roonline.manage.device.store') }}";
        method = "POST";
    }

    function edit(id) {
        $('.modal-header h4').html('Edit Device');
        $('.modal-body form').append('<input type="hidden" name="_method" value="PUT">');
        let editUrl = "{!! route('roonline.manage.device.edit', ':id') !!}";
        editUrl = editUrl.replace(':id', id);
        url = "{{ route('roonline.manage.device.update', ':id') }}";
        url = url.replace(':id', id);
        method = "POST";
        $.get(editUrl, function(response) {
            $('#modal-level').modal('show');
            $('input#ModuleName').val(response.device.txtModuleName);
            $('select#Locater').picker('set', response.device.intLocater_ID);
            $('input#checkBox').prop('checked', (response.device.bitActive ? true : false));
        }).fail(function(response) {
            notification(response.responseJSON.status, response.responseJSON.message, 'bg-danger');
        });
    }

    function destroy(id) {
        let deleteUrl = "{{ route('roonline.manage.device.destroy', ':id') }}";
        deleteUrl = deleteUrl.replace(':id', id);
        swal({
            title: 'Are you sure?',
            text: 'You will not be able to recover this Data!',
            icon: 'warning',
            buttons: {
                cancel: {
                    text: 'Cancel',
                    value: null,
                    visible: true,
                    className: 'btn btn-default',
                    closeModal: true,
                },
                confirm: {
                    text: 'Delete',
                    value: true,
                    visible: true,
                    className: 'btn btn-danger',
                    closeModal: true
                }
            }
        }).then(function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: deleteUrl,
                    method: "DELETE",
                    dataType: "JSON",
                    success: function(response) {
                        refresh();
                        notification(response.status, response.message, 'bg-success');
                    }
                })
            }
        });
    }

    function notification(status, message, bgclass) {
        $.gritter.add({
            title: status,
            text: '<p class="text-light">' + message + '</p>',
            class_name: bgclass
        });
        return false;
    }
    $(document).ready(function() {
        $('select#Locater').picker({
            search: true,
            'texts': {
                trigger: "Select a Locater",
                search: "Search Locater",
                noResult: "No results",
            },
        });
        $('#modal-level').on('hide.bs.modal', function() {
            $('.modal-body form')[0].reset();
            $('input[name="_method"]').remove();
        })
        $('#form-level').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            formData.append('txtInsertedBy', "{{ Auth::user()->txtName }}");
            formData.append('txtUpdatedBy', "{{ Auth::user()->txtName }}");
            $.ajax({
                url: getUrl(),
                method: getMethod(),
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(response) {
                    $('#modal-level').modal('hide');
                    refresh();
                    notification(response.status, response.message, 'bg-success');
                },
                error: function(response) {
                    let fields = response.responseJSON.fields;
                    $.each(fields, function(i, val) {
                        notification(response.status, val[0], 'bg-danger');
                    })
                }
            })
        })
    })
</script>
@endpush