@extends('faceid::layouts.default_layout')
@section('title', 'Dashboard')
@section('content')
<!-- BEGIN breadcrumb -->
<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item active"><a href="javascript:;">Dashboard</a></li>
</ol>
<!-- END breadcrumb -->
<!-- BEGIN page-header -->
<h1 class="page-header">PT Kalbe Morinaga Indonesia
    <br><small>Dashboard Module Faceid</small>
</h1>
<!-- END page-header -->
<div class="row">
    <div class="col-12 ui-sortable">
        <div class="col-md-4 mb-3">
            <form action="" method="get" id="form-filter">
                <div class="form-group">
                    <label for="month">Month</label>
                    <input type="month" name="month" id="month" class="form-control" value="{{ request('month') }}">
                </div>
            </form>
        </div>
        <div class="panel panel-inverse">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5>Status</h5>
                                <canvas id="count-chart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h5>Scan Select Filter</h5>
                                <canvas id="month-chart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="card">
                            <div class="card-body">
                                <h5>Body Temperatur</h5>
                                <canvas id="temperatur-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('/') }}plugins/chart.js/dist/chart.min.js"></script>

<script>
    $("#month").on('change', function() {
        $("#form-filter").submit()
    })
</script>

<script>
    let counthealth = "{{ $counthealth }}"
    let countnothealth = "{{ $countnothealth }}";

    let dailyhealth = @json($dailyhealth);
    let dailynothealth = @json($dailynothealth);
    let dates = @json($dates);

    let temps = @json($temps);
    let users = @json($users);


    var ctx = document.getElementById('count-chart').getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['-'],
            datasets: [{
                label: 'Healthy',
                borderWidth: 2,
                borderColor: "#16FF00",
                backgroundColor: "#16FF00",
                data: [counthealth]
            }, {
                label: 'Not Healthy',
                borderWidth: 2,
                borderColor: "#0079FF",
                backgroundColor: "#0079FF",
                data: [countnothealth]
            }]
        }
    });

    var ctx2 = document.getElementById('month-chart').getContext('2d');
    var barChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: dates,
            datasets: [{
                label: 'Healthy',
                borderWidth: 2,
                borderColor: "#16FF00",
                backgroundColor: "#16FF00",
                data: dailyhealth
            }, {
                label: 'Not Healthy',
                borderWidth: 2,
                borderColor: "#0079FF",
                backgroundColor: "#0079FF",
                data: dailynothealth
            }]
        }
    });

    var ctx3 = document.getElementById('temperatur-chart').getContext('2d');
    var barChart = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: users,
            datasets: [{
                label: 'Temperatur',
                borderWidth: 2,
                borderColor: "#16FF00",
                backgroundColor: "#16FF00",
                data: temps
            }, ]
        }
    });
</script>
@endpush