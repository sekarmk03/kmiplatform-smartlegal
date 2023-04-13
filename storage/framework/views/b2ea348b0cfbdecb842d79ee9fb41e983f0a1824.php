
<?php $__env->startSection('title', 'Manage Modules'); ?>
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
		<li class="breadcrumb-item active">Manage Modules</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Manage Modules</h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Modules Table</h4>
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
                            <?php echo Level::createBtn(); ?>

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
<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modal Dialog</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label" id="ModuleName">Module Name</label>
                    <input class="form-control" type="text" name="txtModuleName" id="ModuleName" placeholder="Module Name" onkeypress="return validate(event)"/>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input name="intStatus" class="form-check-input" type="checkbox" id="checkBox" value="1"/>
                        <label class="form-check-label" for="checkBox">Enabled Module?</label>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 
        var daTable = $('#daTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(route('manage.module.index')); ?>",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'dtmCreated', name: 'dtmCreated'},
                {data: 'txtCreatedBy', name: 'txtCreatedBy'},
                {data: 'txtModuleName', name: 'txtModuleName'},
                {data: 'status', name: 'status'},
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
        function validate(event){
            var key = event.which || event.keyCode || 0;
            return ((key >= 65 && key <= 92) || (key >= 97 && key <= 124))
        }
        function create(){
            $('.modal-header h4').html('Create New Module');
            $('#modal-form').modal('show');
            url = "<?php echo e(route('manage.module.store')); ?>";
            method = "POST";
        }
        function edit(id){
            $('.modal-header h4').html('Edit Level');
            let editUrl = "<?php echo e(route('manage.module.edit',':id')); ?>";
            editUrl = editUrl.replace(':id', id);
            url = "<?php echo e(route('manage.module.update', ':id')); ?>";
            url = url.replace(':id', id);
            method = "PUT";
            $.get(editUrl, function(response){
                $('#modal-form').modal('show');
                $('input#ModuleName').val(response.module.txtModuleName).prop('readonly', true);
                (response.module.intStatus == 1)?$('input#checkBox').prop('checked', true):$('input#checkBox').prop('checked', false);
            });
        }
        function destroy(id){
            let deleteUrl = "<?php echo e(route('manage.module.destroy', ':id')); ?>";
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
            $('#modal-form').on('hide.bs.modal', function(){
                $('input#ModuleName').val('').prop('readonly', false);
                $('input#checkBox').prop('checked', true);
            })
            $('.modal-body form').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url: getUrl(),
                    method: getMethod(),
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(response){
                        $('#modal-form').modal('hide');
                        refresh();
                        notification(response.status, response.message,'bg-success');
                    },
                    error: function(response){
                        let fields = response.responseJSON.fields;
                        $.each(fields, function(i, val){
                            notification(response.status, val[0],'bg-danger');
                        })
                    }
                })
            })
        })
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.default_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\standardization\resources\views/pages/admin/manage-modules.blade.php ENDPATH**/ ?>