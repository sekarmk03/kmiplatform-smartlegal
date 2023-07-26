@extends('ftq::layouts.default_layout')
@section('title', 'Verifikasi Fat Blend')
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <style>
        .modal-body td, .modal-body th{
            border: 2px solid black;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{ asset('/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('/plugins/gritter/js/jquery.gritter.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.js') }}"></script>
    <script>
        let url = '';
        let method = '';
        let pic_no = 1;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 
        function getUrl(){
            return url;
        }
        function getMethod(){
            return method;
        }
        const exportColumns = [0, 1, 2, 3, 4, 5, 6];
        var daTable = $('#daTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('ftq.verifikasi.fat-blend.index') }}",
            dom: "<'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>>rtip",
            buttons: [
                {
                    extend:    'copy',
                    text:      '<i class="fas fa-copy"></i>',
                    className: 'btn btn-sm btn-success',
                    exportOptions: {
                        columns: exportColumns,
                    }
                },
                {
                    extend:    'print',
                    text:      '<i class="fas fa-print"></i>',
                    className: 'btn btn-sm btn-success',
                    exportOptions: {
                        columns: exportColumns,
                    }
                },
                {
                    extend:    'pdfHtml5',
                    text:      '<i class="far fa-file-pdf"></i>',
                    className: 'btn btn-sm btn-success',
                    exportOptions: {
                        columns: exportColumns,
                    }
                },
                {
                    extend:    'excel',
                    text:      '<i class="fas fa-file-excel"></i>',
                    className: 'btn btn-sm btn-success',
                    exportOptions: {
                    columns: exportColumns,
                }
                },
            ],
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'dtmCreatedAt', name: 'dtmCreatedAt'},
                {data: 'txtName', name: 'txtName'},
                {data: 'txtOkp', name: 'txtOkp'},
                {data: 'txtProduct', name: 'txtProduct'},
                {data: 'txtTotal', name: 'txtTotal'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        function refresh(){
            daTable.ajax.reload(null, false);
        }
        function getOkpList(){
            let wrapper = $('select[name="nookp"]');
            let opt = '';
            wrapper.prop('disabled', false);
            wrapper.empty();
            $.get("{{ route('ftq.okp.list') }}", function(response){
                opt = '<option></option>';
                $.each(response.data, function(key, val){
                    opt += '<option value="'+val.txtOkp+'">'+val.txtOkp+'</option>';
                })
                wrapper.append(opt);
                
            })
        }
        function getOkpDetail(okp){
            $.get("{{ route('ftq.okp.list') }}", {'okp': okp}, function(response){
                let wrapper = $('tbody.ingredients');
                let td = '';
                $('span.nookp').html(response.data[0].txtOkp);
                $('span.typeokp').html(response.data[0].txtOkpType);
                $('span.product').html(response.data[0].txtProduct);
                $('span.total').html(response.data[0].txtTotal+" MIX");
                $('span.planned').html(moment(response.data[0].tmPlannedStart).format('YYYY-MM-DD'));
                $('span.moveorder').html(response.data[0].txtMoveOrder);
                $('span.formula').html(response.data[0].intFormulaVersion);
                wrapper.empty();
                $.each(response.data, function(key, val){
                    td += '<tr>'+
                            '<td>'+(key+1)+'</td>'+
                            '<td><input class="form-control" type="text" name="txtIngredient[]" value="'+val.txtIngredient+'" readonly/></td>'+
                            '<td><input class="form-control" type="text" name="txtDescription[]" value="'+val.txtDescription+'" readonly/></td>'+
                            '<td align="center"><input class="form-control" type="text" name="intQty[]" value="'+val.intQty+'" readonly/></td>'+
                            '<td align="center"><input class="form-control" type="text" name="txtTotalQty[]" value="'+val.txtTotal+'" readonly /></td>'+
                            '<td align="center"><input class="form-control" type="text" name="txtUom[]" value="'+val.txtUom+'" readonly /></td>'+
                            '<td align="center"><div class="form-check">'+
                                '<input name="isCheck[]" class="form-check-input" type="checkbox" value="1"/>'+
                            '</div></td>'+
                        '</tr>';
                })
                wrapper.append(td);
            })
        }
        function getShift(){
            switch (true) {
                case (moment().format('h:mm:ss') > '07:00:00'):
                        $('input[name="shift[]"]').val('1');
                    break;
                case (moment().format('h:mm:ss') > '15:30:00'):
                        $('input[name="shift[]"]').val('2');
                    break;
            
                default:
                    $('input[name="shift[]"]').val('3');
                    break;
            }
        }
        function create(){
            getOkpList();
            $('table#pic').find('tbody').append('<tr>'+
                                        '<td align="center"><input type="text" name="shift[]" class="form-control" readonly></td>'+
                                        '<td><input class="form-control" name="processmix[]" type="text" pattern="[1-99]*-[1-99]*" placeholder="1-x" required/></td>'+
                                        '<td><input type="text" name="pic[]" class="form-control" value="{{ Auth::user()->txtName }}" readonly/></td>'+
                                        '<td rowspan="3"></td>'+
                                    '</tr>');
            getShift();
            $('.modal-header h4').html('Buat Verifikasi');
            $('#modal-level').modal('show');
            $('button.add-pic').prop('disabled', false);
            url = "{{ route('ftq.verifikasi.fat-blend.store') }}";
            method = "POST";
        }
        function notification(status, message, bgclass){
            $.gritter.add({
                title: status,
                text: '<p class="text-light">'+message+'</p>',
                class_name: bgclass
            });
            return false;
        }        
        function confirmCloseModal(){
            swal({
                title: 'Yakin menutup form ini?',
                text: 'Data yang terisi akan dikosongkan ketika form ditutup!',
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
                        text: 'Close',
                        value: true,
                        visible: true,
                        className: 'btn btn-warning',
                        closeModal: true,
                        value: 'confirmed'
                    },
                    deny: {
                        text: 'Draft',
                        value: true,
                        visible: true,
                        className: 'btn btn-primary',
                        closeModal: true,
                        value: 'denied'
                    }
                }
            }).then(function(value) {
                switch (value) {
                    case 'denied':
                        onDraft();
                        $('#modal-level').modal('hide');
                        break;

                    case 'confirmed':
                        $('#modal-level').modal('hide');
                        break;
                }
            });
        }
        function onDraft(){
            var formData = new FormData($('.modal-body form')[0]);
            formData.append('txtOkp', $('span.nookp').text());
            formData.append('txtOkpType', $('span.typeokp').text());
            formData.append('txtProduct', $('span.product').text());
            formData.append('txtTotal', $('span.total').text());
            formData.append('tmPlannedStart', $('span.planned').text());
            formData.append('txtMoveOrder', $('span.moveorder').text());
            formData.append('intFormula', $('span.formula').text());
            formData.append('intIsDraft', 1);
            formData.append('txtCreatedBy', "{{ Auth::user()->id }}");
            formData.append('txtUpdatedBy', "{{ Auth::user()->id }}");
            $('input[name="isCheck[]"]').each(function(){
                formData.append('intIsCheck[]', $(this).is(':checked')?1:0);
            })
            $.ajax({
                url: url,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                success: function(response){
                    $('#modal-level').modal('hide');
                    refresh();
                    notification(response.status, response.message,'bg-success');
                }
            })
        }
        function addPic(){
            let wrapper = $('table#pic');
            if (pic_no < 3) {            
                pic_no += 1;
                wrapper.append('<tr>'+
                                        '<td align="center"><input type="text" name="shift[]" class="form-control" readonly></td>'+
                                        '<td><input class="form-control" name="processmix[]" type="text" pattern="[1-99]*-[1-99]*" placeholder="1-x" required/></td>'+
                                        '<td><input type="text" name="pic[]" class="form-control" list="employees"/></td>'+
                                        '<td><button class="btn btn-danger btn-sm" onclick="removePic(this)"><i class="fas fa-trash"></i></button></td>'+
                                    '</tr>');
                getShift();
            }
        }
        function removePic(that){
            pic_no -= 1;
            $(that).closest('tr').remove();
        }
        function edit(id){
            let editUrl = "{{ route('ftq.verifikasi.fat-blend.edit', ':id') }}";
            let wrapper = $('tbody.ingredients');
            let td = '';
            let wrapper_pic = $('table#pic').find('tbody');
            let list_pic = '';
            wrapper_pic.empty();
            editUrl = editUrl.replace(':id', id);
            url = "{{ route('ftq.verifikasi.fat-blend.update', ':id') }}";
            url = url.replace(':id', id);
            method = "POST";
            $('.modal-body form').append('<input type="hidden" name="_method" value="PUT">');
            $.get(editUrl, function(response){
                $('select[name="nookp"]').prop('disabled', true);
                $('.modal-header h4').html('Edit Verifikasi '+response.data.txtOkp);
                $('span.nookp').html(response.data.txtOkp);
                $('span.typeokp').html(response.data.txtOkpType);
                $('span.product').html(response.data.txtProduct);
                $('span.total').html(response.data.txtTotal);
                $('span.planned').html(moment(response.data.tmPlannedStart).format('YYYY-MM-DD'));
                $('span.moveorder').html(response.data.txtMoveOrder);
                $('span.formula').html(response.data.intFormulaVersion);
                $('button.add-pic').prop('disabled', true);
                wrapper.empty();
                $.each(response.data.trfatblend, function(key, val){
                    td += '<tr>'+
                            '<td>'+(key+1)+'</td>'+
                            '<td><input class="form-control" type="text" name="txtIngredient[]" value="'+val.txtIngredient+'" readonly/></td>'+
                            '<td><input class="form-control" type="text" name="txtDescription[]" value="'+val.txtDescription+'" readonly/></td>'+
                            '<td align="center"><input class="form-control" type="text" name="intQty[]" value="'+val.intQty+'" readonly/></td>'+
                            '<td align="center"><input class="form-control" type="text" name="txtTotalQty[]" value="'+val.txtTotalQty+'" readonly /></td>'+
                            '<td align="center"><input class="form-control" type="text" name="txtUom[]" value="'+val.txtUom+'" readonly /></td>'+
                            '<td align="center"><div class="form-check">'+
                                '<input name="isCheck[]" class="form-check-input" type="checkbox" value="1" '+(val.intIsCheck == 1?'checked':'')+'/>'+
                            '</div></td>'+
                        '</tr>';
                })
                $.each(JSON.parse(response.data.txtPic), function(key, val){
                    list_pic += '<tr>'+
                                        '<td align="center"><input type="text" name="shift[]" class="form-control" value="'+val.shift+'" readonly></td>'+
                                        '<td><input class="form-control" name="processmix[]" type="text" pattern="[1-99]*-[1-99]*" placeholder="1-x" value="'+val.processmix+'" readonly/></td>'+
                                        '<td><input type="text" name="pic[]" class="form-control" list="employees" value="'+val.pic+'" readonly/></td>'+
                                        '<td rowspan="3"></td>'+
                                    '</tr>';
                })
                wrapper_pic.append(list_pic);
                wrapper.append(td);
                $('#modal-level').modal('show');
            })
        }
        function destroy(id){
            let deleteUrl = "{{ route('ftq.verifikasi.fat-blend.destroy', ':id') }}";
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
        $(document).ready(function(){
            var myModalEl = document.getElementById('modal-level');
            myModalEl.addEventListener('hidePrevented.bs.modal', function (event) {
                confirmCloseModal();
            })
            $('.notif-icon').find('span').text();
            $('select#OKP').on('change', function(){
                getOkpDetail($(this).val());
            })
            myModalEl.addEventListener('hide.bs.modal', function(e){
                $('.modal-body form')[0].reset();
                $('span.nookp, span.typeokp, span.product, span.total, span.planned, span.moveorder, span.formula').html('');
                $('tbody.ingredients').empty();
                $('tbody.ingredients').append('<tr>'+
                                    '<td align="center" colspan="7" class="bg-light-800">Pilih OKP terlebih dahulu</td>'+
                                '</tr>');
                $('table#pic').find('tbody').empty();
                $('input[name="_method"]').remove();
                pic_no = 1;
            })
            $('select[name="nookp"]').select2({
                dropdownParent: $('#modal-level'),
                placeholder: 'Pilih OKP'
            });
            // $('.modal-body form').on('submit', function(e){
            //     e.preventDefault();
            //     $.ajax({
            //         url: getUrl(),
            //         method: getMethod(),
            //         data: $(this).serialize(),
            //         dataType: "JSON",
            //         success: function(response){
            //             $('#modal-level').modal('hide');
            //             refresh();
            //             notification(response.status, response.message,'bg-success');
            //         },
            //         error: function(response){
            //             let fields = response.responseJSON.fields;
            //             $.each(fields, function(i, val){
            //                 $.each(val, function(ind, value){
            //                     notification(response.responseJSON.status, val[ind],'bg-danger');
            //                 })
            //             })
            //         }
            //     })
            // })
        })
    </script>
@endpush
@section('content')
    <!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="{{ route('ftq.') }}">Dashboard</a></li>
		<li class="breadcrumb-item">Verification</li>
		<li class="breadcrumb-item active">Fat Blend</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">PT Kalbe Morinaga Indonesia
        <br><small>Verifikasi Fat Blend</small>
    </h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Fat Blend Verification Table</h4>
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
                            <button onclick="create()" class="btn btn-primary float-end"><i class="fas fa-plus"></i> Verifikasi</button>
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
                                    <th>OKP</th>
                                    <th>PRODUCT</th>
                                    <th>TOTAL</th>
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
    <div class="modal fade" id="modal-level" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Dialog</h4>
                    <button onclick="confirmCloseModal()" type="button" class="btn-close" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        @csrf
                        <div class="row mb-3">
                            <label class="form-label col-form-label col-md-3">Pilih OKP</label>
                            <div class="col-md-9">
                                <select class="form-select" name="nookp" id="OKP">
                                </select>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <tr>
                                <td rowspan="4" align="center" valign="middle">
                                    <img src="{{ asset('img/logo/kalbe_morinaga.png') }}" width="156" alt="Kalbe Logo">
                                </td>
                                <td rowspan="2" align="center" valign="middle">FORM</td>
                                <td>No. Dok : FR/MDP-PC/OFP/003</td>
                            </tr>
                            <tr>
                                <td>No. Rev : 01</td>
                            </tr>
                            <tr>
                                <td rowspan="2" align="center" valign="middle">ORDER KERJA PRODUKSI FAT BLEND</td>
                                <td>Tgl Berlaku : 23 April 2018</td>
                            </tr>
                            <tr>
                                <td>Halaman : 1 dari 1</td>
                            </tr>
                        </table>
                        <dl class="row">
                            <dt class="col-md-2">No OKP</dt>
                            <dd class="col-md-10">: <span class="nookp"></span></dd>
                            <dt class="col-md-2">Type OKP</dt>
                            <dd class="col-md-10">: <span class="typeokp"></span></dd>
                            <dt class="col-md-2">Product</dt>
                            <dd class="col-md-10">: <span class="product"></span></dd>
                            <dt class="col-md-2">Total</dt>
                            <dd class="col-md-10">: <span class="total"></span></dd>
                            <dt class="col-md-2">Planned Start</dt>
                            <dd class="col-md-10">: <span class="planned"></span></dd>
                            <dt class="col-md-2">Move Order</dt>
                            <dd class="col-md-10">: <span class="moveorder"></span></dd>
                            <dt class="col-md-2">Formula Version</dt>
                            <dd class="col-md-10">: <span class="formula"></span></dd>
                        </dl>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Line</th>
                                    <th>Ingredients</th>
                                    <th>Description</th>
                                    <th align="center">Qty/Mix</th>
                                    <th align="center">Total Qty</th>
                                    <th align="center">Uom</th>
                                    <th align="center">Check</th>
                                </tr>
                            </thead>
                            <tbody class="ingredients">
                                <tr>
                                    <td align="center" colspan="7" class="bg-light-800">Pilih OKP terlebih dahulu</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="col-4 ms-auto">
                            <button class="btn btn-sm btn-primary float-end mb-2 add-pic" onclick="addPic()"><i class="fas fa-plus"></i> PIC</button>
                        </div>
                        <div class="col-4 ms-auto">
                            <table id="pic" class="col-4 table ms-auto">
                                <thead>
                                    <tr>
                                        <th>Shift</th>
                                        <th>Process MIX</th>
                                        <th>PIC</th>
                                        <th>SPV/Leader</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                </div>
                <div class="modal-footer">
                    <a onclick="confirmCloseModal()" class="btn btn-white"><i class="fa-solid fa-xmark"></i> Close</a>
                    <button type="button" onclick="onDraft()" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Draft</button>
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Publish</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <datalist id="employees">
        @foreach ($qa_emp as $item)            
            <option value="{{ $item->txtName }}">
        @endforeach
    </datalist>
@endsection
