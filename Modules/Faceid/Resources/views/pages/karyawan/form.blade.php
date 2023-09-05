@extends('faceid::layouts.default_layout')
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
    <li class="breadcrumb-item active">Manage Foto Karyawan</li>
</ol>
<!-- END breadcrumb -->
<!-- BEGIN page-header -->
<h1 class="page-header">Manage Foto Karyawan</h1>
<!-- END page-header -->
<div class="row">
    <div class="col">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Foto Karyawan Table</h4>
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                    <a type="button" onclick="refresh()" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
                </div>
            </div>

            <div class="panel-body">
                <form action="{{ route('faceid.karyawan.update', $fotoKaryawan->id) }}" class="row mb-3" method="post" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="form-group mb-3">
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
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
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('faceid.karyawan.list') }}",
        deferRender: true,
        pagination: true,
        columns: [{
                data: 'checkbox',
                name: 'checkbox'
            },
            {
                data: 'foto',
                name: 'foto'
            },
            {
                data: 'txtName',
                name: 'txtName'
            },
            {
                data: 'dtmCreated',
                name: 'dtmCreated'
            },

            {
                data: 'action',
                name: 'action',
            },
        ]
    });

    $("#btn-add").on('click', function() {
        let route = $(this).attr('data-route')
        $(".karyawan").addClass('show')
        $("#form-foto").attr('action', route)
    })

    $("#btn-close").on('click', function() {
        $("#form-foto").removeAttr('action')
    })

    $("#datatable").on('click', '.btn-edit', function() {
        let route = $(this).attr('data-route')
        let id = $(this).attr('id')

        $("#modal-test").addClass('d-none')
        $("#form-foto").attr('action', route)
        $("#form-foto").append(`<input type="hidden" name="_method" value="PUT">`);

        $.ajax({
            url: "/faceid/karyawan/" + id,
            type: 'GET',
            method: 'GET',
            success: function(response) {
                let karyawan = response.karyawan;

                $("#karyawan").val(karyawan.txtName)
            }
        })
    })

    $("#datatable").on('click', '.check-karyawan', function() {
        let id = $(this).attr('id')

        if ($(this).is(':checked')) {
            $("#form-export").append(`<input type="hidden" name="idkary[]" id="kar-` + id + `" value="` + id + `">`);
        } else {
            $("#kar-" + id).remove()
        }

    })

    $("#datatable").on('click', '.btn-delete', function(e) {
        e.preventDefault();
        let route = $(this).attr('data-route')
        $("#form-delete").attr('action', route)

        swal({
            title: 'Hapus foto karyawan?',
            text: 'Menghapus foto karyawan bersifat permanen.',
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