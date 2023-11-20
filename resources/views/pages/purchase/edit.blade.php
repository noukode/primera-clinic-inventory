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
                <div class="card-header">Purchase Order Details</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="purchase_no" class="text-sm">PO No</label>
                            <input type="text" class="form-control" id="purchase_no" name="purchase_no" value="{{ $purchaseOrder->purchase_no }}" readonly>
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="project_name" class="text-sm">Project Name</label>
                            <input type="text" class="form-control" id="project_name" name="project_name" value="{{ $purchaseOrder->project_name }}">
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="branch_id" class="text-sm">Branch</label>
                            <select name="branch_id" id="branch_id" class="form-control">
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ $branch->id === $purchaseOrder->branch_id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="stock_type_id" class="text-sm">Purchase Type</label>
                            <select name="stock_type_id" id="stock_type_id" class="form-control">
                                @foreach ($stock_types as $stock_type)
                                    <option value="{{ $stock_type->id }}" {{ $stock_type->id === $purchaseOrder->stock_type_id ? 'selected' : '' }}>{{ $stock_type->name }}</option>
                                @endforeach
                            </select>
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
                        <div class="col-auto">
                            <button class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#tambahItemModal">Tambah Item</button>
                        </div>
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
                                <th>Action</th>
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
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody id="table-value">
                        </tbody>
                    </table>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <form action="#" id="create-po">
                                <button class="btn btn-info" type="submit">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambahItemModal" tabindex="-1" aria-labelledby="tambahItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="tambahItemModalLabel">Tambah Item</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" id="tambah-item">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <label for="item-list" class="form-label">Item</label>
                        </div>
                        <div class="col-4">
                            <label for="qty" class="form-label">Quantity</label>
                        </div>
                        <div class="col-4">
                            <label for="price" class="form-label">Harga Satuan</label>
                        </div>
                        <div class="col-4">
                            <div id="item-list"></div>
                        </div>
                        <div class="col-4">
                            <input type="number" name="qty" id="qty" class="form-control" required>
                        </div>
                        <div class="col-4">
                            <input type="number" name="price" id="price" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="inserter">Tambah</button>
                </div>
            </form>
            <div class="modal-loadpanel"></div>
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

            const modalLoadPanel = $('.modal-loadpanel').dxLoadPanel({
                shadingColor: 'rgba(0,0,0,0.4)',
                position: {
                    my: 'middle center',
                    at: 'middle center',
                    of: "#tambahItemModal",
                    offset: '0 0'
                },
                visible: false,
                showIndicator: true,
                showPane: true,
                shading: false,
                closeOnOutsideClick: false
            }).dxLoadPanel('instance');

            let dataSource = new DevExpress.data.CustomStore({
                load: function(loadOptions){
                    let deferred = $.Deferred(),
                        args = {};

                    loadPanel.show();

                    $.ajax({
                        url: "{{ route('item.all') }}",
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: args,
                        type: 'POST',
                        success: function(result) {
                            deferred.resolve(result.data, {
                                totalCount: result.totalCount
                            });

                            loadPanel.hide();
                        },
                        error: function() {
                            loadPanel.hide();
                            Helper.simpleAlert('Error', 'Something went wrong', 'error');
                        },
                    });

                    return deferred.promise();
                }
            });
            let dxSelect = $('#item-list').dxSelectBox({
                dataSource: dataSource,
                inputAttr: { 'aria-label': 'Item' },
                displayExpr: 'name',
                valueExpr: 'id',
                acceptCustomValue: false,
                searchEnabled: true,
                height:'2.7rem'
            }).dxSelectBox('instance');

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
                                <td>
                                    <a class="btn btn-datatable btn-icon btn-danger btn-delete" data-key="${element.id}" href="#"><i data-key="${element.id}" class="fas fa-trash-alt"></i></a>
                                </td>
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
            $('#tambah-item').submit(function(e){
                e.preventDefault();
                let item = {};
                let id = dxSelect.option('value');
                const qty = $('#qty').val();
                const price = $('#price').val();
                modalLoadPanel.show();
                let filteredItem = items.filter(el => el.id === id);
                $.ajax({
                    url: `{{ route('purchase-order-detail.store') }}`,
                    dataType: "json",
                    data:{
                        purchase_order_id: po_id,
                        item_id: id,
                        qty: qty,
                        price: price,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    success: function(result) {
                        modalLoadPanel.hide();

                        tableUpdater();
                    },
                    error: function() {
                        modalLoadPanel.hide();
                        Helper.simpleAlert('Error', 'Something went wrong', 'error');
                    },
                })

                dxSelect.option('value', null);
                $('#qty').val(null);
                $('#price').val(null);


            });

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

            $('#create-po').submit(function(e){
                e.preventDefault();
                loadPanel.show();
                let formdata = {};
                formdata.project_name = $('#project_name').val();
                formdata.branch_id = $('#branch_id').val();
                formdata.stock_type_id = $('#stock_type_id').val();
                formdata._method = 'PUT';
                $.ajax({
                    url: `{!! route('purchase-order.index') !!}/${po_id}`,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formdata,
                    type: 'POST',
                    success: function(result) {
                        loadPanel.hide();
                        Helper.simpleNotification(result.message, 'Berhasil menyimpan data!', result.status);
                    },
                    error: function() {
                        loadPanel.hide();
                        Helper.simpleAlert('Error', 'Something went wrong', 'error');
                    },
                });
            });


        });
    </script>
@endsection
