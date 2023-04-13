
<?php $__env->startSection('title', 'Manage Database | Standardization'); ?>
<?php $__env->startPush('css'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <link href="<?php echo e(asset('/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('/plugins/gritter/css/jquery.gritter.css')); ?>" rel="stylesheet" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
		<li class="breadcrumb-item active">Manage Database</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Manage Database</h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Database Table</h4>
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
                            <button onclick="create()" class="btn btn-sm btn-primary float-end"><i class="fa-solid fa-plus"></i> Create</button>
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
                                    <TH>CREATED BY</TH>
                                    <th>DATABASE NAME</th>
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
          <form action="" method="post">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label class="form-label" id="Database">Database Name</label>
                    <input class="form-control" type="text" name="txtDatabaseName" id="Database" placeholder="Database Name" onkeypress="return event.charCode != 32"/>
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
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('/plugins/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/plugins/datatables.net-responsive/js/dataTables.responsive.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/plugins/sweetalert/dist/sweetalert.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/plugins/gritter/js/jquery.gritter.js')); ?>"></script>
    <script>
        let url = '';
        let method = '';
        let accountID = "<?php echo e(openssl_decrypt(Request::segment(3), 'AES-128-CTR', 'Standardization', 0, '1234567891011121')); ?>";
        let datableUrl = "<?php echo e(route('manage.database.index', ':id')); ?>";
        datableUrl = datableUrl.replace(':id', accountID);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 
        var daTable = $('#daTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: datableUrl,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'dtmCreated', name: 'dtmCreated'},
                {data: 'txtCreatedBy', name: 'txtCreatedBy'},
                {data: 'txtDatabaseName', name: 'txtDatabaseName'},
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
        function create(){
            $('.modal-header h4').html('Create New Database');
            $('#modal-level').modal('show');
            url = "<?php echo e(route('manage.database.store')); ?>";
            method = "POST";
        }
        function destroy(id){
            let deleteUrl = "<?php echo e(route('manage.database.destroy', ':id')); ?>";
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
                        success: function(response){
                            refresh();
                            notification(response.status, response.message,'bg-success');
                        }
                    })
                }
            });
        }
        function notification(status, message, bgclass){
            $.gritter.add({
                title: status,
                text: '<p class="text-light">'+message+'</p>',
                class_name: bgclass
            });
            return false;
        }
        $(document).ready(function(){
            $('#modal-level').on('hide.bs.modal', function(){
                $('input#Database').val('');
                $('input[name="_method"]').remove();
            })
            $('.modal-body form').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                formData.append('intAccount_ID', accountID);
                formData.append('txtCreatedBy', "<?php echo e(Auth::user()->txtName); ?>");
                formData.append('txtUpdatedBy', "<?php echo e(Auth::user()->txtName); ?>");
                $.ajax({
                    url: getUrl(),
                    method: getMethod(),
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "JSON",
                    success: function(response){
                        $('#modal-level').modal('hide');
                        refresh();
                        notification(response.status, response.message,'bg-success');
                    },
                    error: function(response){
                        let fields = response.responseJSON.fields;
                        $.each(fields, function(i, val){
                            $.each(val, function(ind, value){
                                notification(response.responseJSON.status, val[ind],'bg-danger');
                            })
                        })
                    }
                })
            })
        })
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.default_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\standardization\resources\views/pages/admin/manage-databases.blade.php ENDPATH**/ ?>