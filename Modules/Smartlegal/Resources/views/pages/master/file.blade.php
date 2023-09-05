@extends('smartlegal::layouts.default_layout')
@section('title', 'Files')
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
		<li class="breadcrumb-item active">Files</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Files</h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col-12 ui-sortable">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">File Table</h4>
                    <div class="me-3">
                        <button type="button" class="btn btn-primary btn-sm" onclick="create()">
                            <i class="fas fa-plus"></i>
                            Add New File
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
                                        <th class="text-center">FILENAME</th>
                                        <th class="text-center">FILEPATH</th>
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
                        <label for="File" class="form-label">Pilih File</label>
                        <input class="form-control" type="file" id="File" name="txtFile" required>
                    </div>
                    <div class="mb-3" id="FrameContainer">
                        <label for="FileFrame" class="form-label" id="FileNameLabel"></label>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive embed-responsive-16by9" src="" frameborder="0" width="100%" height="300px" id="FileFrame"></iframe>
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
        
        let daTable = $('#daTable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            responsive: true,
            ajax: "{{ route('smartlegal.master.file.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center'},
                {data: 'dtmCreatedAt', name: 'dtmCreatedAt', className: 'text-center'},
                {data: 'txtFilename', name: 'txtFilename', className: 'text-center'},
                {data: 'txtPath', name: 'txtPath', className: 'text-center'},
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

        const download = ( id ) => {
            let downloadUrl = "{{ route('smartlegal.master.file.download', ':id') }}";
            downloadUrl = downloadUrl.replace(':id', id);
            window.location = downloadUrl;
        }

        const create = () => {
            $('.modal-header h4').html('Add File');
            $('#modal-form').modal('show');
            $("#FrameContainer").hide();
            url = "{{ route('smartlegal.master.file.store') }}";
            method = "POST";
        }

        const edit = ( id ) => {
            $('.modal-header h4').html('Edit File');
            let editUrl = "{{ route('smartlegal.master.file.edit', ':id') }}";
            editUrl = editUrl.replace(':id', id);
            url = "{{ route('smartlegal.master.file.update', ':id') }}";
            url = url.replace(':id', id);
            $('.modal-body form').append('<input type="hidden" name="_method" value="PUT">');
            method = "POST";
            $.get(editUrl, (response) => {
                $('#modal-form').modal('show');
                $('input#File').val(response.data.txtFile);
                $("#FrameContainer").show();
                $("#FileNameLabel").html(response.data.txtFilename);
                $('iframe#FileFrame').attr('src', response.data.txtPath);
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

        const destroy = (id) => {
            let deleteUrl = "{{ route('smartlegal.master.file.destroy', ':id') }}";
            deleteUrl = deleteUrl.replace(':id', id);
            swal({
                title: 'Are you sure?',
                text: 'You will not be able to recover this data!',
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
            }).then((isConfirm) => {
                if (isConfirm) {
                    $.ajax({
                        url: deleteUrl,
                        method: "DELETE",
                        dataType: "JSON",
                        success: (response) => {
                            refresh();
                            notification(response.status, response.message,'bg-success');
                            conn.send(['success', 'issuer']);
                        }
                    });
                }
            });
        }

        $(document).ready(() => {
            $('.notif-icon').find('span').text();
            $('#modal-form').on('hide.bs.modal', () => {
                $('input#File').val('');
                $('input[name="_method"]').remove();
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