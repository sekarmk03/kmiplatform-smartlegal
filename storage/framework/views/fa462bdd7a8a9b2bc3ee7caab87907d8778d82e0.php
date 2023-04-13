
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css')); ?>">
    <style>
        .highcharts-data-table table {
            min-width: 360px;
            max-width: 800px;
            margin: 1em auto;
        }

            .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item active"><a href="javascript:;">Dashboard</a></li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">PT Kalbe Morinaga Indonesia
        <br><small>Monitoring RO Online</small>
    </h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col-12 ui-sortable">
            <div class="panel panel-inverse">
                <div class="panel-body">
                    <div id="widget" class="row">
                        <!-- Over 2% = #fd97ff -->
                        <?php $__currentLoopData = $lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col">
                            <div class="panel">
                                <div id="<?php echo e(preg_replace('/\s+/', '', $key)); ?>" class="panel-body">
                                    <h4><?php echo e($key); ?></h4>
                                    <div class="row">
                                        <?php $__currentLoopData = $lines[$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col">
                                            <div id="<?php echo e(preg_replace('/\s+/', '', $item['txtLineProcessName'])); ?>" class="widget widget-stats" style="background-color: #8990a4">
                                                <div class="stats-icon stats-icon-lg"><i class="fa fa-cube fa-fw"></i></div>
                                                <div class="stats-content">
                                                    <div class="stats-title"><Strong><?php echo e($item['txtLineProcessName']); ?></strong></div>
                                                    <div class="stats-number text-center">0.0%</div>
                                                    <div class="stats-desc text-center">Status: <strong>Not Running</strong></div>
                                                    <div class="text-center mt-3 avg">Avg : <strong>0</strong></div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <div class="row">
                                        <div class="widget-list rounded mb-4" data-id="widget">
                                            <div class="widget-list-item">
                                                <div class="widget-list-media icon">
                                                    <i class="fa fa-clipboard bg-info text-white"></i>
                                                </div>
                                                <div class="widget-list-content">
                                                    <h4 class="widget-list-title">OKP :</h4>
                                                </div>
                                                <div class="okp widget-list-action text-end">
                                                    <h4 class="widget-list-title"></h4>
                                                </div>
                                            </div>
                                            <div class="widget-list-item">
                                                <div class="widget-list-media icon">
                                                    <i class="fa fa-paper-plane bg-purple text-white"></i>
                                                </div>
                                                <div class="widget-list-content">
                                                    <h4 class="widget-list-title">Product :</h4>
                                                </div>
                                                <div class="product widget-list-action text-end">
                                                    <h4 class="widget-list-title"></h4>
                                                </div>
                                            </div>
                                            <div class="widget-list-item">
                                                <div class="widget-list-media icon">
                                                    <i class="fa fa-note-sticky bg-success text-white"></i>
                                                </div>
                                                <div class="widget-list-content">
                                                    <h4 class="widget-list-title">LOT Number :</h4>
                                                </div>
                                                <div class="lot widget-list-action text-end">
                                                    <h4 class="widget-list-title"></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group row">
                                <div class="col">
                                    <div class="input-group input-daterange">
                                        <input type="text" class="form-control datepicker" name="start" placeholder="Date Time Start">
                                        <span class="input-group-text input-group-addon">to</span>
                                        <input type="text" class="form-control datepicker" name="end" placeholder="Date Time End">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <button onclick="filterBtn()" class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Filter</button>
                            <button class="btn btn-danger btn-sm" onclick="resetBtn()"><i class="fa-solid fa-times"></i> Reset</button>
                        </div>
                    </div>
                    <div class="row p-3 mb-3">
                        <div class="col justify-content-center">
                            <div id="LineA"></div>
                        </div>
                    </div>
                    <div class="row p-3 mb-3">
                        <div class="col justify-content-center">
                            <div id="LineE"></div>
                        </div>
                    </div>
                    <div class="row p-3 mb-3">
                        <div class="col justify-content-center">
                            <div id="LineJ"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('plugins/highcharts/highcharts.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/highcharts/accessibility.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/highcharts/data.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/highcharts/exporting.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/highcharts/export-data.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/highcharts/indicators.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js')); ?>"></script>
<script src="<?php echo e(Module::asset('roonline:js/line-chart.js')); ?>"></script>
    <script>      
        function groupArray(datas){             
            grouped = datas.reduce((r, v, i, a) => {
                if (typeof a[i - 1] === 'undefined') {
                    r.push([v]);
                } else {
                    if (v.txtLineProcessName === a[i - 1].txtLineProcessName) {
                        r[r.length - 1].push(v);
                    } else {
                        r.push(v.txtLineProcessName === a[i + 1].txtLineProcessName ? [v] : v);
                    }
                }
                return r;
            }, []);  
            return grouped;
        }
        function chartLine(){
            $.get("<?php echo e(route('roonline.chart')); ?>", {
                start: $('input[name="start"]').val(),
                end: $('input[name="end"]').val()
            }, function(response){
                let xAxisCat = [];
                let xAxisCat2 = [];
                let datas = groupArray(response.data);
                $.each(response.data, function(i, val){
                    xAxisCat.push(val.xAxis);
                });
                chartA.xAxis[0].setCategories(xAxisCat);
                chartE.xAxis[0].setCategories(xAxisCat);
                chartJ.xAxis[0].setCategories(xAxisCat);
                for (let idx = 0; idx < datas.length; idx++) {
                    let resultVal = [];
                    let line = datas[idx];
                    // console.log(line[idx].txtLineProcessName);
                    $.each(line, function(key, val){
                        resultVal.push(val.floatValues);
                        xAxisCat2.push(val.txtBatchOrder);
                    })
                    // console.log(resultVal);
                    switch (line[idx].txtLineProcessName) {
                        case 'Filling Sachet A1':
                            chartA.series[0].setData(resultVal);
                            break;
                        case 'Filling Sachet A2':
                            chartA.series[1].setData(resultVal);                            
                            break;
                        case 'Filling Sachet E1':
                            chartE.series[0].setData(resultVal);                            
                            break;
                        case 'Filling Sachet E2':
                            chartE.series[1].setData(resultVal);                            
                            break;
                        case 'Filling Sachet J1':
                            chartJ.series[0].setData(resultVal);                            
                            break;
                        case 'Filling Sachet J2':
                            chartJ.series[1].setData(resultVal);                            
                            break;
                    }
                }
                chartA.xAxis[1].setCategories(xAxisCat2);
            })
        }
        function filterBtn(){
            let start = $('input[name="start"]').val();
            let end = $('input[name="end"]').val();
            chartLine();
        }
        function resetBtn(){
            $('input[name="start"], input[name="end"]').val('');
            chartLine();
        }
        function widget(){
            $.get("<?php echo e(route('roonline.widget')); ?>", function(response){
                let datas = response.data;
                $.each(datas, function(idx, item){
                    let wrapper = item.txtLineProcessName.replace(/\s+/g, '');
                    if (item.floatValues > 1.9) {
                        $('#'+wrapper).css('background-color', '#fd97ff');
                    } else {                        
                        $('#'+wrapper).css('background-color', '#007AFF');
                    }
                    $('#'+wrapper).find('.stats-number').html(item.floatValues+"%");
                    $('#'+wrapper).find('.stats-desc strong').html(item.txtStatus);
                    $('#'+wrapper.slice(0, -1)).find('.okp h4').html(item.txtBatchOrder);
                    $('#'+wrapper.slice(0, -1)).find('.product h4').html(item.txtProductName);
                    $('#'+wrapper.slice(0, -1)).find('.lot h4').html(item.txtProductionCode+'/'+item.dtmExpireDate);
                })
            }).then(() => {
                maxAvg();
            })
        }
        function maxAvg(){
            $.get("<?php echo e(route('roonline.maxAvg')); ?>", function(response){
                let datas = response.data;
                $('.stats-title').each(function() {
                    var $this = $(this);
                    let widget = $this.text().replace(/\s+/g, '');
                    let okp = $('#'+$this.text().slice(0, -1).replace(/\s+/g, '')).find('.okp h4').text();
                    $.each(datas, function(key, val){
                        if (val.txtLineProcessName == $this.text() && val.txtBatchOrder == okp) {
                            // $('#'+widget+' .max').find('.fw-bold span').attr('data-value', val.maximum).text(val.maximum);
                            $('#'+widget+' .avg').find('strong').text(val.average+'%');
                            return false;
                        }
                    })
                });
            })
        }
    $(document).ready(function(){
        $(".datepicker").datetimepicker({
            todayHighlight: true,
            autoclose: true
        });
        setInterval(() => {
            widget();
            chartLine();
        }, 6000);
        widget();
        chartLine();
    })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('roonline::layouts.default_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\standardization\Modules/ROonline\Resources/views/pages/dashboard.blade.php ENDPATH**/ ?>