@extends('ftq::layouts.default_layout')
@section('title', 'Dashboard')
@section('content')
    <!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="{{ route('ftq.') }}">Dashboard</a></li>
		<li class="breadcrumb-item">Verification</li>
		<li class="breadcrumb-item active">Eductor</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">PT Kalbe Morinaga Indonesia
        <br><small>Verifikasi Material Eductor</small>
    </h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col-12 ui-sortable">
            <div class="panel panel-inverse">
                <div class="panel-body">
                    <h5>Module FTQ Siap Development !!! Laravel 8.</h5>
                </div>
            </div>
        </div>
    </div>
@endsection
