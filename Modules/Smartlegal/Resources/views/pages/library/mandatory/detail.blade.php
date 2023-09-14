@extends('smartlegal::layouts.default_layout')
@section('title', 'Library Detail')
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
		<li class="breadcrumb-item"><a href="javascript:;">Library</a></li>
		<li class="breadcrumb-item active">Detail</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Library Detail</h1>
	<!-- END page-header -->
    <div class="row mt-4 pe-3">
        <div class="col">
            <h3>No. {{ substr($mandatory['doc_number'], 0, 11) }}</h3>
            <p class="fst-italic my-0">Terakhir diperbarui {{ $mandatory['updated_at'] }}</p>
            <?php 
                $color = [
                    'Requested' => '',
                    'Revised' => '',
                    'Rejected' => '',
                    'Approved' => '',
                    'Active' => 'green',
                    'Warning' => 'yellow',
                    'Expired' => 'red',
                    'Terminated' => 'black'
                ];
            ?>
            <p class="mt-0 fw-bolder"><span><i class="fas fa-circle" style="color: {{ $color[$mandatory['status']] }}"></i></span>&nbsp;{{ $mandatory['status'] }}</p>
        </div>
        <div class="card mx-2 me-5 fs-5">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <table>
                            <tr>
                                <td>No. Request</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['request_number'] }}</td>
                            </tr>
                            <tr>
                                <td>No. Perizinan</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['doc_number'] }}</td>
                            </tr>
                            <tr>
                                <td>Nama Perizinan</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['doc_name'] }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Perizinan</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['variant'] }}</td>
                            </tr>
                            <tr>
                                <td>Nama PIC</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['pic'] }}</td>
                            </tr>
                            <tr>
                                <td>Tipe Dokumen</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['type'] }}</td>
                            </tr>
                            <tr>
                                <td>Instansi Penerbit</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['issuer'] }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col">
                        <table>
                            <tr>
                                <td>Periode Berlaku</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['exp_period'] }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal berlaku</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['date'] }}</td>
                            </tr>
                            <tr>
                                <td>Reminder pembaruan</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['rem_period'] }}</td>
                            </tr>
                            <tr>
                                <td>Biaya pembaruan</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['renewal_cost'] }}</td>
                            </tr>
                            <tr>
                                <td>PIC Reminder</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td><?php 
                                for ($i=0; $i < count($mandatory['picReminder']); $i++) { 
                                    echo $mandatory['picReminder'][$i];
                                    if ($i != count($mandatory['picReminder']) - 1) echo ' | ';
                                }
                                ?></td>
                            </tr>
                            <tr>
                                <td>Location filling hardcopy</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['location'] }}</td>
                            </tr>
                            <tr>
                                <td>Cost Center</td>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td>{{ $mandatory['cost_center'] }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2 pe-3">
        <div class="card mx-2 me-5">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table id="daTable" class="table table-striped table-bordered align-middle">
                                <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Kode Perizinan</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Nama Perizinan</th>
                                    <th class="text-center">Penerbit</th>
                                    <th class="text-center">Nama File</th>
                                    <th class="text-center">Action</th>
                                    <th class="text-center">Attachment</th>
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
@endsection
@push('scripts')
    <script src="{{ asset('/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/plugins/gritter/js/jquery.gritter.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 
        var daTable = $('#daTable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            responsive: true,
            ajax: "{{ route('smartlegal.library.mandatory.show', $mandatory['doc_id']) }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center'},
                {data: 'doc_number', name: 'doc_number', className: 'text-center'},
                {data: 'date', name: 'date', className: 'text-center'},
                {data: 'doc_name', name: 'doc_name', className: 'text-center'},
                {data: 'issuer_name', name: 'issuer_name', className: 'text-center'},
                {data: 'file_name', name: 'file_name', className: 'text-center'},
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'},
                {data: 'attachment', name: 'attachment', orderable: false, searchable: false, className: 'text-center'},
            ]
        });
        function refresh(){
            daTable.ajax.reload(null, false);
        }
    </script>
@endpush