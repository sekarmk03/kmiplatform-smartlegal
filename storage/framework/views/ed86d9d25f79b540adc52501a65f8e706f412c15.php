
<?php $__env->startSection('title', 'Dashboard Navigation | Standardization'); ?>
<?php $__env->startPush('css'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <link href="<?php echo e(asset('/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('/plugins/gritter/css/jquery.gritter.css')); ?>" rel="stylesheet" />
    <style>
        .panel-body {
            position: relative;
        }
        .panel-body .qa {
            position: absolute;
            top: 25%;
            left: 50%;
            transform: translate(-25%, -50%);
            -ms-transform: translate(-25%, -50%);
            cursor: pointer;
            border: 2px solid #fff;
        }
        .qa-card {
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-25%, -50%);
            -ms-transform: translate(-25%, -50%);
            cursor: pointer;
            border: 2px solid #fff;
        }
        .panel-body .whs {
            position: absolute;
            top: 17%;
            left: 42%;
            transform: translate(-17%, -42%);
            -ms-transform: translate(-17%, -42%);
            cursor: pointer;
            border: 2px solid #fff;
        }
        .whs-card {
            position: absolute;
            top: 22%;
            left: 42%;
            transform: translate(-17%, -42%);
            -ms-transform: translate(-17%, -42%);
            cursor: pointer;
            border: 2px solid #fff;
        }
        .panel-body .eng {
            position: absolute;
            top: 55%;
            left: 48%;
            transform: translate(-55%, -48%);
            -ms-transform: translate(-55%, -48%);
            cursor: pointer;
            border: 2px solid #fff;
        }
        .eng-card {
            position: absolute;
            top: 60%;
            left: 48%;
            transform: translate(-55%, -48%);
            -ms-transform: translate(-55%, -48%);
            cursor: pointer;
            border: 2px solid #fff;
        }
        .panel-body .bda {
            position: absolute;
            top: 37%;
            left: 47%;
            transform: translate(-37%, -47%);
            -ms-transform: translate(-37%, -47%);
            cursor: pointer;
            border: 2px solid #fff;
        }
        .panel-body .mdp {
            position: absolute;
            top: 30%;
            left: 40%;
            transform: translate(-30%, -40%);
            -ms-transform: translate(-30%, -40%);
            cursor: pointer;
            border: 2px solid #fff;
        }
        .panel-body .prd {
            position: absolute;
            top: 20%;
            left: 60%;
            transform: translate(-20%, -60%);
            -ms-transform: translate(-20%, -60%);
            cursor: pointer;
            border: 2px solid #fff;
        }
        .panel-body .ios {
            position: absolute;
            top: 39%;
            left: 63%;
            transform: translate(-39%, -63%);
            -ms-transform: translate(-39%, -63%);
            cursor: pointer;
            border: 2px solid #fff;
        }
        .panel-body .hc {
            position: absolute;
            top: 30%;
            left: 70%;
            transform: translate(-30%, -70%);
            -ms-transform: translate(-30%, -70%);
            cursor: pointer;
            border: 2px solid #fff;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        function showApp(that){
            if ($(that).next().css('display') == "none") {
                $.get("", )
                $(that).next().css('display', 'block');
            } else {            
                $(that).next().css('display', 'none');
            }
        }
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item active">Dashboard</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Kalbe Morinaga</h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Dashboard Navigation</h4>
                </div>
                <div class="panel-body">
                    <button onclick="showApp(this)" class="btn btn-success qa"><i class="fa-solid fa-microscope"></i> QA Dept</button>
                    <div class="card qa-card" style="display: none">
                        <div class="card-body">
                            <?php $__currentLoopData = $qas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(url('/'.strtolower($item->txtModuleName))); ?>" type="button" class="btn btn-outline-warning">
                                    <i class="fa-solid fa-desktop"></i> <?php echo e($item->txtModuleName); ?>

                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <button onclick="showApp(this)" class="btn btn-success whs"><i class="fa-solid fa-warehouse"></i> WHS Dept</button>
                    <div class="card whs-card" style="display: none">
                        <div class="card-body">
                            <a href="" type="button" class="btn btn-outline-warning">
                                <i class="fa-solid fa-desktop"></i> Tester
                            </a>
                        </div>
                    </div>
                    <button onclick="showApp(this)" class="btn btn-success eng"><i class="fa-solid fa-user-gear"></i> ENG Dept</button>
                    <div class="card eng-card" style="display: none">
                        <div class="card-body">
                            <a href="" type="button" class="btn btn-outline-warning">
                                <i class="fa-solid fa-desktop"></i> Tester
                            </a>
                        </div>
                    </div>
                    <button class="btn btn-success bda"><i class="fa-solid fa-envelope"></i> BDA Dept</button>
                    <button class="btn btn-success mdp"><i class="fa-solid fa-timeline"></i> MDP Dept</button>
                    <button class="btn btn-success prd"><i class="fa-solid fa-gear"></i> PRD Dept</button>
                    <button class="btn btn-success ios"><i class="fa-solid fa-chart-pie"></i> IOS Dept</button>
                    <button class="btn btn-success hc"><i class="fa-solid fa-users"></i> HC Dept</button>
            <?xml version="1.0" encoding="UTF-8"?>
            <!-- Do not edit this file with editors other than diagrams.net -->
            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('/plugins/sweetalert/dist/sweetalert.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/plugins/gritter/js/jquery.gritter.js')); ?>"></script>
    <script>
        $(document).ready(function(){
        })
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.default_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\standardization\resources\views/pages/dashboard-navigation.blade.php ENDPATH**/ ?>