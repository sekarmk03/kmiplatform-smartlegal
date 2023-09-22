
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startPush('css'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css')); ?>">
    <link href="<?php echo e(asset('/plugins/gritter/css/jquery.gritter.css')); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('plugins/select2/dist/css/select2.min.css')); ?>">
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
            color: #8990a4;
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
        .highcharts-tooltip {
            pointer-events: auto;
        }
        .rhsuhu tr th{
            border-right: 2px solid #8990a4;
        }
        .rhsuhu tr td{
            border-right: 2px solid #8990a4;
        }
        tr:last-child {
            border-bottom: 2px solid #8990a4;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('plugins/highcharts/highcharts.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/highcharts/accessibility.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/highcharts/data.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/highcharts/exporting.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/highcharts/export-data.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/highcharts/indicators.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js')); ?>"></script>
<script src="<?php echo e(Module::asset('roonline:js/line-chart.js')); ?>"></script>
<script src="<?php echo e(asset('/plugins/gritter/js/jquery.gritter.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/select2/dist/js/select2.full.min.js')); ?>"></script>
    <script>      
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 
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
                chartA.update({
                    legend: {
                        labelFormatter: function() {
                            var lastVal = this.yData[this.yData.length - 1] != undefined?this.yData[this.yData.length - 1]:0,
                            chart = this.chart,
                            xAxis = this.xAxis,
                            points = this.points,
                            avg = 0,
                            counter = 0,
                            min = 0, max = 0;

                            $.each(points, function(inx, point) {
                                if (!min || min > point.y) {
                                    min = point.y;
                                }

                                if (!max || max < point.y) {
                                    max = point.y;
                                }

                                counter++;
                                avg += point.y;
                            });
                            counter--;
                            avg /= counter;

                            return this.name + '<br>' + 'Now: ' + lastVal + ' %<br>' +
                            '<span style="color: green">Min: ' + min + ' %</span><br/>' +
                            '<span style="color: red">Max: ' + max + ' %</span><br/>' +
                            '<span style="color: blue">Average: ' + avg.toFixed(2); + ' %</span><br/>'
                        }
                    }
                });
                chartE.update({
                    legend: {
                        labelFormatter: function() {
                            var lastVal = this.yData[this.yData.length - 1] != undefined?this.yData[this.yData.length - 1]:0,
                            chart = this.chart,
                            xAxis = this.xAxis,
                            points = this.points,
                            avg = 0,
                            counter = 0,
                            min = 0, max = 0;

                            $.each(points, function(inx, point) {
                                if (!min || min > point.y) {
                                    min = point.y;
                                }

                                if (!max || max < point.y) {
                                    max = point.y;
                                }

                                counter++;
                                avg += point.y;
                            });
                            counter--;
                            avg /= counter;

                            return this.name + '<br>' + 'Now: ' + lastVal + ' %<br>' +
                            '<span style="color: green">Min: ' + min + ' %</span><br/>' +
                            '<span style="color: red">Max: ' + max + ' %</span><br/>' +
                            '<span style="color: blue">Average: ' + avg.toFixed(2); + ' %</span><br/>';
                        }
                    }
                });
                chartJ.update({
                    legend: {
                        labelFormatter: function() {
                            var lastVal = this.yData[this.yData.length - 1] != undefined?this.yData[this.yData.length - 1]:0,
                            chart = this.chart,
                            xAxis = this.xAxis,
                            points = this.points,
                            avg = 0,
                            counter = 0,
                            min = 0, max = 0;

                            $.each(points, function(inx, point) {
                                if (!min || min > point.y) {
                                    min = point.y;
                                }

                                if (!max || max < point.y) {
                                    max = point.y;
                                }

                                counter++;
                                avg += point.y;
                            });
                            counter--;
                            avg /= counter;

                            return this.name + '<br>' + 'Now: ' + lastVal + ' %<br>' +
                            '<span style="color: green">Min: ' + min + ' %</span><br/>' +
                            '<span style="color: red">Max: ' + max + ' %</span><br/>' +
                            '<span style="color: blue">Average: ' + avg.toFixed(2); + ' %</span><br/>'
                        }
                    }
                });
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
        function notification(status, message, bgclass){
            $.gritter.add({
                title: status,
                text: '<p class="text-light">'+message+'</p>',
                class_name: bgclass
            });
            return false;
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
                    (item.txtBatchOrder != 'undefined'?$('#'+wrapper.slice(0, -1)).find('.okp h4').html(item.txtBatchOrder):'');
                    (item.txtProductName != 'undefined'?$('#'+wrapper.slice(0, -1)).find('.product h4').html(item.txtProductName):'');
                    (item.txtProductionCode != 'undefined' && item.dtmExpireDate != 'undefined'?$('#'+wrapper.slice(0, -1)).find('.lot h4').html(item.txtProductionCode+' / '+item.dtmExpireDate):'');
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
                            $('#'+widget).find('.minmax').find('.min strong').text(val.minimum+'%');
                            $('#'+widget).find('.minmax').find('.avg strong').text(val.average+'%');
                            $('#'+widget).find('.minmax').find('.max strong').text(val.maximum+'%');
                            return false;
                        }
                    })
                });
            })
        }
        function getRhTemp(){
            $.get("<?php echo e(route('roonline.rhtemp')); ?>", function(response){
                $.each(response.data, function(inx, val){
                    $('table.rhsuhu')
                        .find('tr#'+val.intArea_ID)
                        .find('td.'+val.txtLineProcessName.replace(/\s+/g, '')+'RH')
                        .html(val.floatRH+'%')
                        .css('background-color', (val.floatRH > 55)?'#F44336':'#FFF')
                        .css('color', (val.floatRH > 55)?'#FFF':'#000');
                    $('table.rhsuhu')
                        .find('tr#'+val.intArea_ID)
                        .find('td.'+val.txtLineProcessName.replace(/\s+/g, '')+'Temp')
                        .html(val.floatTemp+'<span>&#176;</span>C')
                        .css('background-color', (val.floatTemp > 25)?'#F44336':'#FFF')
                        .css('color', (val.floatTemp > 25)?'#FFF':'#000');
                })
            })
        }
    function reasonModal(line, tanggal, ro){
        let checkUrl = "<?php echo e(route('roonline.reason.check')); ?>";
        $.post(checkUrl,{'line': line, 'waktu':tanggal}, function(response){
            $('input#LineProcess').val(line);
            $('input#RO').val(ro);
            $('input#TimeStamp').val(tanggal);
            $('textarea#Reason').val(response.data.txtReason).prop('disabled', true);
            $('.modal-footer button[type="submit"]').prop('disabled', true);
            $('#modal-reason').modal('show');
        }).fail((response) => {
            $('input#LineProcess').val(line);
            $('input#RO').val(ro);
            $('input#TimeStamp').val(tanggal);
            $('textarea#Reason').val('').prop('disabled', false);
            $('.modal-footer button[type="submit"]').prop('disabled', false);
            $('#modal-reason').modal('show');
        })
    }
    $(document).ready(function(){
        $(".datepicker").datetimepicker({
            todayHighlight: true,
            autoclose: true
        });        
        $('Select#Line').select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select Lines'
            },
            allowClear: true,
        });
        $('Select#Area').select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select Areas'
            },
            allowClear: true,
        });
        setInterval(() => {
            widget();
            chartLine();
        }, 8000);
        setInterval(() => {
            getRhTemp();
        }, 60000);
        widget();
        chartLine();
        getRhTemp();
        $('#form-reason').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "<?php echo e(route('roonline.reason.store')); ?>",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(response){
                    $('#modal-reason').modal('hide');
                    notification(response.status, response.message,'bg-success');
                },
                error: function(response){
                    let fields = response.responseJSON.fields;
                    $.each(fields, function(i, val){
                        notification(response.status, val[0],'bg-danger');
                    })
                }
            });
        })
    })
    </script>
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
                                                    <div class="text-center minmax mt-3">
                                                        <span class="text-start min">Min : <strong>0</strong></span><br>
                                                        <span class="text-start avg">Avg : <strong>0</strong></span><br>
                                                        <span class="text-start max">Max : <strong>0</strong></span>
                                                    </div>
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
                    <div class="row mb-5">
                        <form target="_new" action="<?php echo e(route('roonline.export.rhtemp')); ?>" method="post" class="row row-cols-lg-auto g-3 align-items-center">
                        <?php echo csrf_field(); ?>
                        <div class="col-4">
                            <div class="form-group row">
                                <div class="col">
                                    <div class="input-group input-daterange">
                                        <input type="text" class="form-control datepicker" name="start" placeholder="Date Time Start" autocomplete="off" required>
                                        <span class="input-group-text input-group-addon">to</span>
                                        <input type="text" class="form-control datepicker" name="end" placeholder="Date Time End" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">                            
                            <div class="form-group row">
                                <select name="intArea_ID[]" id="Area" class="form-control" multiple required>
                                    <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->intArea_ID); ?>"><?php echo e($item->txtAreaName); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-sm btn-success float-end"><i class="fa-solid fa-file-excel"></i> Export</button>
                        </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-panel align-middle rhsuhu mb-5">
                                    <tr>
                                        <th style="border-bottom: 2px solid #8990a4; font-size: 18px;"></th>
                                        <th style="border-bottom: 2px solid #8990a4; font-size: 18px;" colspan="2" class="text-center">Line J</th>
                                        <th style="border-bottom: 2px solid #8990a4; font-size: 18px;" colspan="2" class="text-center">Line E</th>
                                        <th style="border-bottom: 2px solid #8990a4; font-size: 18px;" colspan="2" class="text-center">Line A</th>
                                        <th style="border-bottom: 2px solid #8990a4; font-size: 18px;" colspan="2" class="text-center">Sample</th>
                                        <th style="border-bottom: 2px solid #8990a4; font-size: 18px;" colspan="2" class="text-center">Canning</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Room</th>
                                        <th class="text-center">Temp</th>
                                        <th class="text-center">RH</th>
                                        <th class="text-center">Temp</th>
                                        <th class="text-center">RH</th>
                                        <th class="text-center">Temp</th>
                                        <th class="text-center">RH</th>
                                        <th class="text-center">Temp</th>
                                        <th class="text-center">RH</th>
                                        <th class="text-center">Temp</th>
                                        <th class="text-center">RH</th>
                                    </tr>
                                    <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr id="<?php echo e($item->intArea_ID); ?>">
                                            <td align="center"><label class="badge bg-default text-dark"><?php echo e($item->txtAreaName); ?></label></td>
                                            <td align="center" class="SachetJTemp">#N/A</td>
                                            <td align="center" class="SachetJRH">#N/A</td>
                                            <td align="center" class="SachetETemp">#N/A</td>
                                            <td align="center" class="SachetERH">#N/A</td>
                                            <td align="center" class="SachetATemp">#N/A</td>
                                            <td align="center" class="SachetARH">#N/A</td>
                                            <td align="center" class="SachetBTemp">#N/A</td>
                                            <td align="center" class="SachetBRH">#N/A</td>
                                            <td align="center" class="SachetBTemp">#N/A</td>
                                            <td align="center" class="SachetBRH">#N/A</td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <form target="_new" action="<?php echo e(route('roonline.export.histories')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="form-group row">
                                <div class="col">
                                    <div class="input-group input-daterange">
                                        <input type="text" class="form-control datepicker" name="start" placeholder="Date Time Start" autocomplete="off">
                                        <span class="input-group-text input-group-addon">to</span>
                                        <input type="text" class="form-control datepicker" name="end" placeholder="Date Time End" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="button" onclick="filterBtn()" class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Filter</button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="resetBtn()"><i class="fa-solid fa-times"></i> Reset</button>
                        </div>
                        <div class="col-3">
                            <select name="txtLineProcess[]" id="Line" class="form-control" multiple required>
                                <?php $__currentLoopData = $list_line; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item); ?>"><?php echo e($item); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-1">
                            <button type="submit" class="btn btn-sm btn-success float-end"><i class="fa-solid fa-file-excel"></i> Export</button>
                        </form>
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
    <!-- #modal-dialog -->
<div class="modal fade" id="modal-reason">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Penyebab >2%</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="form-reason" data-parsley-validate="true">
            <div class="mb-3">
                <label class="form-label" id="LineProcess">Line Process</label>
                <input class="form-control" type="text" name="txtLineProcessName" id="LineProcess" placeholder="Line Process" readonly required/>
            </div>
            <div class="mb-3">
                <label class="form-label" id="RO">RO</label>
                <input class="form-control" type="text" name="floatValues" id="RO" placeholder="RO" readonly required/>
            </div>
            <div class="mb-3">
                <label class="form-label" id="TimeStamp">Waktu</label>
                <input class="form-control" type="text" name="TimeStamp" id="TimeStamp" placeholder="Waktu" readonly required/>
            </div>
            <div class="mb-3">
                <label class="form-label" id="Reason">Remark:*</label>
                <textarea name="txtReason" class="form-control" id="Reason" rows="2" maxlength="256" placeholder="Masukan keterangan"></textarea>
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

<?php echo $__env->make('roonline::layouts.default_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\standardization\Modules/ROonline\Resources/views/pages/dashboard.blade.php ENDPATH**/ ?>