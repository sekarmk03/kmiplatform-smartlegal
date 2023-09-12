@extends('smartlegal::layouts.default_layout')
@section('title', 'Detail Request')
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
		<li class="breadcrumb-item"><a href="javascript:;">My Task</a></li>
		<li class="breadcrumb-item active">Detail</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Detail Request</h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col ui-sortable me-1">
            <div class="panel panel-inverse">
                <div class="panel-body">
                    <div class="row px-3 pb-4">
                        <div class="text-center mb-1">
                            <h3>No. {{ $mandatory['request_number'] }}</h3>
                            <p class="fw-bolder">Requested at {{ $mandatory['created_at'] }}</p>
                        </div>
                        <hr>
                        <table class="fs-5">
                            <tr>
                                <td>No. Request</td>
                                <td>:</td>
                                <td>{{ $mandatory['request_number'] }}</td>
                            </tr>
                            <tr>
                                <td>No. Perizinan</td>
                                <td>:</td>
                                <td>{{ $mandatory['doc_number'] }}</td>
                            </tr>
                            <tr>
                                <td>Nama Dokumen</td>
                                <td>:</td>
                                <td>{{ $mandatory['doc_name'] }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td>{{ $mandatory['status'] }}</td>
                            </tr>
                            <tr>
                                <td>Tipe Perizinan</td>
                                <td>:</td>
                                <td>{{ $mandatory['type'] }}</td>
                            </tr>
                            <tr>
                                <td>PIC Dokumen</td>
                                <td>:</td>
                                <td>{{ $mandatory['pic'] }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Dokumen</td>
                                <td>:</td>
                                <td>{{ $mandatory['variant'] }}</td>
                            </tr>
                            <tr>
                                <td>Masa Berlaku</td>
                                <td>:</td>
                                <td>{{ $mandatory['exp_period'] }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Awal</td>
                                <td>:</td>
                                <td>{{ $mandatory['publish_date'] }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Akhir</td>
                                <td>:</td>
                                <td>{{ $mandatory['exp_date'] }}</td>
                            </tr>
                            <tr>
                                <td>Penerbit Dokumen</td>
                                <td>:</td>
                                <td>{{ $mandatory['issuer'] }}</td>
                            </tr>
                            <tr>
                                <td>Periode Reminder</td>
                                <td>:</td>
                                <td>{{ $mandatory['rem_period'] }}</td>
                            </tr>
                            <tr>
                                <td>Location Filling Hardcopy</td>
                                <td>:</td>
                                <td>{{ $mandatory['location'] }}</td>
                            </tr>
                            <tr>
                                <td>Biaya Renewal</td>
                                <td>:</td>
                                <td>{{ $mandatory['renewal_cost'] }}</td>
                            </tr>
                            <tr>
                                <td>Cost Center</td>
                                <td>:</td>
                                <td>{{ $mandatory['cost_center'] }}</td>
                            </tr>
                            <tr>
                                <td>Catatan</td>
                                <td>:</td>
                                <td>{{ $mandatory['note'] }}</td>
                            </tr>
                            <tr>
                                <td>Catatan Termination</td>
                                <td>:</td>
                                <td>{{ $mandatory['termination_note'] }}</td>
                            </tr>
                        </table>
                        @if ($mandatory['status'] == 'Requested' || $mandatory['status'] == 'Revised')
                        <div class="mt-4 px-5 mb-3">
                            <div class="btn-group w-100 fs-4">
                                <button type="button" class="btn btn-primary" onclick="addNote({{ $mandatory['doc_id'] }}, 1)">
                                    <i class="fas fa-pencil-alt"></i>
                                    Revise
                                </button>
                                <button type="button" class="btn btn-green" onclick="addNote({{ $mandatory['doc_id'] }}, 2)">
                                    <i class="fas fa-check"></i>
                                    Approve
                                </button>
                                <button type="button" class="btn btn-danger" onclick="addNote({{ $mandatory['doc_id'] }}, 3)">
                                    <i class="fas fa-reply"></i>
                                    Reject
                                </button>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-primary" onclick="edit({{ $mandatory['doc_id'] }})">
                                    <i class="fas fa-pencil-alt"></i>
                                    Edit Request
                                </button>
                            </div>
                        </div>
                        @endif
                        <div>
                            <form action="" method="" id="formNote">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label" for="Note">Catatan</label>
                                    <input type="text" hidden id="noteType" name="noteType">
                                    <textarea name="txtNote" id="Note" cols="30" rows="5" class="form-control" placeholder="Masukkan catatan"></textarea>
                                </div>
                                <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col ui-sortable">
            <div class="panel panel-inverse">
                <div class="panel-body">
                    <div class="row embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive embed-responsive-16by9" src="{{ asset($mandatory['file_path']) }}" frameborder="0" width="100%" height="600px"></iframe>
                    </div>
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
    </script>
@endpush