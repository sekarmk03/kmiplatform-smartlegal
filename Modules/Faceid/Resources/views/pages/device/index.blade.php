@extends('faceid::layouts.default_layout')
@section('title', 'Data Device')
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
    <li class="breadcrumb-item active">Data Device</li>
</ol>
<!-- END breadcrumb -->
<!-- BEGIN page-header -->
<h1 class="page-header">Data Device</h1>
<!-- END page-header -->
<div class="row">
    <div class="col">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Device Table</h4>
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                    <a type="button" onclick="refresh()" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row mb-3">
                    <div class="col-md-12 ms-auto">
                        <a href="#modal-dialog" id="btn-add" class="btn btn-primary" data-route="{{ route('faceid.device.store') }}" data-bs-toggle="modal"><i class="ion-ios-add"></i> Add Device</a>
                    </div>
                </div>
                <div class="row">
                    <!-- html -->
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID Device</th>
                                    <th>IP Address</th>
                                    <th>Nama Device</th>
                                    <th>Action</th>
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
<div class="modal fade" id="modal-dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Data Device</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="" method="post" id="form-foto" data-parsley-validate="true" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="iddev">ID Device</label>
                        <input type="text" name="iddev" id="iddev" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="nama_device">Nama Device</label>
                        <input type="text" name="nama_device" id="nama_device" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="ipaddress">IP Address</label>
                        <input type="text" name="ipaddress" id="ipaddress" class="form-control">
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

<form action="" class="d-none" id="form-delete" method="post">
    @csrf
    @method('DELETE')
</form>
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
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('faceid.device.list') }}",
        deferRender: true,
        pagination: true,
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'iddev',
                name: 'iddev'
            },
            {
                data: 'ipaddress',
                name: 'ipaddress'
            },
            {
                data: 'nama_device',
                name: 'nama_device'
            },
            {
                data: 'action',
                name: 'action',
            },
        ]
    });

    $("#btn-add").on('click', function() {
        let route = $(this).attr('data-route')
        $("#form-foto").attr('action', route)
    })

    $("#btn-close").on('click', function() {
        $("#form-foto").removeAttr('action')
    })

    $("#datatable").on('click', '.btn-edit', function() {
        let route = $(this).attr('data-route')
        let id = $(this).attr('id')

        $("#form-foto").attr('action', route)
        $("#form-foto").append(`<input type="hidden" name="_method" value="PUT">`);

        $.ajax({
            url: "/faceid/device/" + id,
            type: 'GET',
            method: 'GET',
            success: function(response) {
                let device = response.device;

                $("#nama_device").val(device.nama_device)
                $("#iddev").val(device.iddev)
                $("#ipaddress").val(device.ipaddress)
            }
        })
    })

    $("#datatable").on('click', '.btn-delete', function(e) {
        e.preventDefault();
        let route = $(this).attr('data-route')
        $("#form-delete").attr('action', route)

        swal({
            title: 'Hapus data device?',
            text: 'Menghapus data device bersifat permanen.',
            icon: 'error',
            buttons: {
                cancel: {
                    text: 'Cancel',
                    value: null,
                    visible: true,
                    className: 'btn btn-default',
                    closeModal: true,
                },
                confirm: {
                    text: 'Yes',
                    value: true,
                    visible: true,
                    className: 'btn btn-danger',
                    closeModal: true
                }
            }
        }).then((result) => {
            if (result) {
                $("#form-delete").submit()
            } else {
                $("#form-delete").attr('action', '')
            }
        });
    })
</script>
@endpush