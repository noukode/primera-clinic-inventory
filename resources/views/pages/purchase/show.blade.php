@extends('template')
@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="plus"></i></div>
                        Edit Purchase Order
                    </h1>
                </div>
            </div>
            <nav class="mt-4 rounded" aria-label="breadcrumb">
                <ol class="breadcrumb px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/purchase-order">Purchase Order</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
</header>
<div class="container-xl px-4 mt-n10">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            Purchase Order Details
                        </div>
                        @if ($purchaseOrder->purchase_status > 0)
                            <div class="col-auto">
                                <a href="{{ route('purchase-order.print', $purchaseOrder->id) }}" class="btn btn-primary"><i class="fas fa-print me-2"></i> Cetak</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="purchase_no" class="text-sm">PO No</label>
                            <div class="fs-4 fw-bold">{{ $purchaseOrder->purchase_no }}</div>
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="project_name" class="text-sm">Project Name</label>
                            <div class="fs-4 fw-bold">{{ $purchaseOrder->project_name }}</div>
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="branch_id" class="text-sm">Branch</label>
                            <div class="fs-4 fw-bold">{{ $purchaseOrder->branch->name }}</div>
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="stock_type_id" class="text-sm">Purchase Type</label>
                            <div class="fs-4 fw-bold">{{ $purchaseOrder->stock_type->name }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-xl px-4 mt-3">
    <div class="row">
        <div class="col">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            Item Details
                        </div>
                        @if (auth()->user()->role->code === "ADMIN" && $purchaseOrder->purchase_status < 2)
                            <div class="col-auto">
                                <a href="#" class="btn btn-success" id="approve"><i class="fas fa-check me-2"></i>Approve</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Kode Item</th>
                                <th>Nama Item</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th class="text-center">Qty</th>
                                <th>Harga Satuan</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Kode Item</th>
                                <th>Nama Item</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th class="text-center">Qty</th>
                                <th>Harga Satuan</th>
                                <th>Harga</th>
                            </tr>
                        </tfoot>
                        <tbody id="table-value">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="loadpanel"></div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function(){

            const po_id = `{{ $purchaseOrder->id }}`;
            const loadPanel = $('.loadpanel').dxLoadPanel({
                shadingColor: 'rgba(0,0,0,0.4)',
                position: {
                    my: 'middle center',
                    at: 'middle center',
                    of: ".table",
                    offset: '0 0'
                },
                visible: false,
                showIndicator: true,
                showPane: true,
                shading: false,
                closeOnOutsideClick: false
            }).dxLoadPanel('instance');

            const tableUpdater = function(){
                loadPanel.show();
                $.ajax({
                    url: `{{ route('purchase-order-detail.get_by_po') }}`,
                    dataType: "json",
                    data:{
                        purchase_order_id: po_id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    success: function(result) {
                        let html = ``;
                        result.data.forEach((element, key) => {
                            html += `
                            <tr>
                                <td>${element.item.kode_item}</td>
                                <td>${element.item.name}</td>
                                <td>${element.item.category.name}</td>
                                <td>${element.item.unit.name}</td>
                                <td class="text-center">${element.qty}</td>
                                <td>Rp. ${element.price.toLocaleString()}</td>
                                <td>Rp. ${(element.price * element.qty).toLocaleString()}</td>
                            </tr>
                            `;
                        });

                        $('#table-value').html(html);

                        loadPanel.hide();
                    },
                    error: function() {
                        loadPanel.hide();
                        Helper.simpleAlert('Error', 'Something went wrong', 'error');
                    },
                })

            }

            tableUpdater();

            $('#table-value').on('click', '.btn-delete', function(e){
                let id = $(e.currentTarget).data('key');
                Helper.confirmAlert('Anda yakin ingin menghapus data ini?', 'warning', 'Ya').then(result => {
                    if(result.isConfirmed){
                        loadPanel.show();
                        $.ajax({
                            url: `{{ route('purchase-order-detail.delete') }}`,
                            dataType: "json",
                            data:{
                                id: id,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            success: function(result) {
                                loadPanel.hide();
                                tableUpdater();
                            },
                            error: function() {
                                loadPanel.hide();
                                Helper.simpleAlert('Error', 'Something went wrong', 'error');
                            },
                        })
                    }
                })
            })

            $('#approve').click(function(e){
                e.preventDefault();
                Helper.confirmAlert('Anda yakin ingin meng-approve PO ini?', 'question', 'Yes').then(res => {
                    if(res.isConfirmed){
                        loadPanel.show();
                        let formdata = {};
                        formdata._method = 'PUT';
                        formdata.purchase_status = 2;
                        $.ajax({
                            url: `{!! route('purchase-order.index') !!}/${po_id}/approve`,
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: formdata,
                            type: 'POST',
                            success: function(result) {
                                loadPanel.hide();
                                Helper.simpleNotification(result.message, 'Berhasil approve PO!', result.status);
                            },
                            error: function() {
                                loadPanel.hide();
                                Helper.simpleAlert('Error', 'Something went wrong', 'error');
                            },
                        });
                    }
                })
            })
        });
    </script>
@endsection
