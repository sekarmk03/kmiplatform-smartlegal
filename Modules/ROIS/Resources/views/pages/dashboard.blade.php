@extends('rois::layouts.default_layout')
@section('title', 'Dashboard')
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}">
    <link href="{{ asset('/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
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
@endpush
@push('scripts')
<script src="{{ asset('plugins/highcharts/highcharts.min.js') }}"></script>
<script src="{{ asset('plugins/highcharts/accessibility.js') }}"></script>
<script src="{{ asset('plugins/highcharts/data.js') }}"></script>
<script src="{{ asset('plugins/highcharts/exporting.js') }}"></script>
<script src="{{ asset('plugins/highcharts/export-data.js') }}"></script>
<script src="{{ asset('plugins/highcharts/indicators.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ Module::asset('rois:js/line-chart.js') }}"></script>
<script src="{{ asset('/plugins/gritter/js/jquery.gritter.js') }}"></script>
<script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/paho.mqtt.js') }}"></script>
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
            $.get("{{ route('rois.chart.new') }}", {
                start: $('input[name="start_ro"]').val(),
                end: $('input[name="end_ro"]').val()
            }, function(response){
                let xAxisA = [];
                let yAxisA1 = [];
                let yAxisA2 = [];
                let xAxisE = [];
                let yAxisE1 = [];
                let yAxisE2 = [];
                let xAxisD = [];
                let yAxisD1 = [];
                let yAxisD2 = [];
                $.each(response.categories.FillingSachetA, function(i, val){
                    xAxisA.push(val.xAxis);
                })
                $.each(response.categories.FillingSachetE, function(i, val){
                    xAxisE.push(val.xAxis);
                })
                $.each(response.categories.FillingSachetD, function(i, val){
                    xAxisD.push(val.xAxis);
                })
                chartA.xAxis[0].setCategories(xAxisA);
                chartE.xAxis[0].setCategories(xAxisE);
                chartD.xAxis[0].setCategories(xAxisD);
                $.each(response.data.FillingSachetA1, function(i, val){
                    yAxisA1.push([val.xAxis, val.yAxis]);
                })
                $.each(response.data.FillingSachetA2, function(i, val){
                    yAxisA2.push([val.xAxis, val.yAxis]);
                })
                chartA.series[0].setData(yAxisA1);
                chartA.series[1].setData(yAxisA2);
                $.each(response.data.FillingSachetE1, function(i, val){
                    yAxisE1.push([val.xAxis, val.yAxis]);
                })
                $.each(response.data.FillingSachetE2, function(i, val){
                    yAxisE2.push([val.xAxis, val.yAxis]);
                })
                chartE.series[0].setData(yAxisE1);
                chartE.series[1].setData(yAxisE2);
                $.each(response.data.FillingSachetD1, function(i, val){
                    yAxisD1.push([val.xAxis, val.yAxis]);
                })
                $.each(response.data.FillingSachetD2, function(i, val){
                    yAxisD2.push([val.xAxis, val.yAxis]);
                })
                chartD.series[0].setData(yAxisD1);
                chartD.series[1].setData(yAxisD2);
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
                chartD.update({
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
            let start = $('input[name="start_ro"]').val();
            let end = $('input[name="end_ro"]').val();
            chartLine();
        }
        function resetBtn(){
            $('input[name="start_ro"], input[name="end_ro"]').val('');
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
            $.get("{{ route('rois.widget') }}", function(response){
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
            $.get("{{ route('rois.maxAvg') }}", function(response){
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
            $.get("{{ route('rois.rhtemp') }}", function(response){
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
        let checkUrl = "{{ route('rois.reason.check') }}";
        $.post(checkUrl,{'line': line, 'waktu':tanggal, 'ro': ro}, function(response){
            $('input#LineProcess').val(line);
            $('input#RO').val(ro);
            $('input#TimeStamp').val(tanggal);
            if (response.data.reason_ro) {                  
                $('textarea#Reason').val(response.data.reason_ro.txtReason).prop('disabled', true);
                $('.modal-footer button[type="submit"]').prop('disabled', true);
                $('.log_id').remove();
            } else {
                $('.modal-body form').append('<div class="mb-3 log_id" style="display: none;">'+
                    '<input type="text" name="intLog_History_ID" class="form-control" value="'+response.data.intLog_History_ID+'"/>'+
                '</div>');
                $('textarea#Reason').val('').prop('disabled', false);
                $('.modal-footer button[type="submit"]').prop('disabled', false);
            }
            $('#modal-reason').modal('show');
        }).fail((response) => {
        })
    }
    function makeid(length) {
        let result = '';
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        const charactersLength = characters.length;
        let counter = 0;
        while (counter < length) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
        counter += 1;
        }
        return result;
    }
    function mqttConnect(){
        client = new Paho.MQTT.Client('10.175.13.146', 9001, 'client_id_'+makeid(22));
        var options = {
            onSuccess: onConnect
        };
        client.onConnectionLost = onConnectionLost;
        client.onMessageArrived = onMessageArrived;
        client.connect(options);
    }
    // called when the client connects
    function onConnect() {
        // Once a connection has been made, make a subscription and send a message.
        // console.log("Connected Successfull");
        client.subscribe('ro/a1');
        client.subscribe('ro/e1');
        client.subscribe('ro/j1');
        client.subscribe('tipping/ab/rhtemp');
        client.subscribe('tipping/e/rhtemp');
    }
    // called when the client loses its connection
    function onConnectionLost(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }

    // called when a message arrives
    function onMessageArrived(message) {
        // console.log("Pesan dari MQTT: " + message.payloadString);
        widget();
        chartLine();
        getRhTemp();
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
        mqttConnect();
        widget();
        chartLine();
        getRhTemp();
        $('#modal-reason').on('hide.bs.modal', function(){
                $('.modal-body form')[0].reset();
                $('.log_id').remove();
            })
        $('#form-reason').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "{{ route('rois.reason.store') }}",
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
@endpush
@section('content')
    <!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item active"><a href="javascript:;">Dashboard</a></li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">PT Kalbe Morinaga Indonesia
        <br><small>Residual Oxygen Inspection System | ROIS</small>
    </h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col-12 ui-sortable">
            <div class="panel">
                <div class="panel-body">
                    <div id="widget" class="row">
                        <!-- Over 2% = #fd97ff -->
                        @foreach ($lines as $key => $value)
                        <div class="col">
                            <div class="panel">
                                <div id="{{ preg_replace('/\s+/', '', $key) }}" class="panel-body">
                                    <h4>{{ $key }}</h4>
                                    <div class="row">
                                        @foreach ($lines[$key] as $item)
                                        <div class="col">
                                            <div id="{{ preg_replace('/\s+/', '', $item['txtLineProcessName']) }}" class="widget widget-stats" style="background-color: #8990a4">
                                                <div class="stats-icon stats-icon-lg"><i class="fa fa-cube fa-fw"></i></div>
                                                <div class="stats-content">
                                                    <div class="stats-title"><Strong>{{ $item['txtLineProcessName'] }}</strong></div>
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
                                        @endforeach
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
                        @endforeach
                    </div>
                    <div class="row mb-5">
                        <form target="_new" action="{{ route('rois.export.rhtemp') }}" method="post" class="row row-cols-lg-auto g-3 align-items-center">
                        @csrf
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
                                    @foreach ($areas as $item)
                                        <option value="{{ $item->intArea_ID }}">{{ $item->txtAreaName }}</option>
                                    @endforeach
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
                                    @foreach ($areas as $item)
                                        <tr id="{{ $item->intArea_ID }}">
                                            <td align="center"><label class="badge bg-default text-dark">{{ $item->txtAreaName }}</label></td>
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
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <form target="_new" action="{{ route('rois.export.histories') }}" method="post">
                            @csrf
                            <div class="form-group row">
                                <div class="col">
                                    <div class="input-group input-daterange">
                                        <input type="text" class="form-control datepicker" name="start_ro" placeholder="Date Time Start" autocomplete="off">
                                        <span class="input-group-text input-group-addon">to</span>
                                        <input type="text" class="form-control datepicker" name="end_ro" placeholder="Date Time End" autocomplete="off">
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
                                @foreach ($list_line as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
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
@endsection
