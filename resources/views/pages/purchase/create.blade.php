@extends('template')
@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="plus"></i></div>
                        Create Purchase Order
                    </h1>
                </div>
            </div>
            <nav class="mt-4 rounded" aria-label="breadcrumb">
                <ol class="breadcrumb px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/user">Purchase Order</a></li>
                    <li class="breadcrumb-item active">Create</li>
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
                    <div class="mb-3">
                        <label for="po_no" class="text-sm">PO No</label>
                        <input type="text" class="form-control" id="po_no" name="po_no" aria-describedby="poHelp">
                        <div id="poHelp" class="form-text">Leave this blank to automatically generate upon saving.</div>
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
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Kode Item</th>
                                <th>Nama Item</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody id="table-value">
                        </tbody>
                    </table>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <form action="#" id="create-po">
                                <button class="btn btn-info" id="draft" type="button">Save as Draft</button>
                                <button class="btn btn-primary" id="submit" type="submit">Submit</button>
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
                            <label for="price" class="form-label">Price</label>
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
        </div>
    </div>
</div>
<div class="loadpanel"></div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function(){
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

            let items = [
            ];

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
                            deferred.reject("Data Loading Error");
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

            const tableUpdater = function(e = null){
                let html = ``;
                items.forEach((element, key) => {
                    html += `
                    <tr>
                        <td>${element.kode_item}</td>
                        <td>${element.name}</td>
                        <td>${element.category.name}</td>
                        <td>${element.unit.name}</td>
                        <td>${element.qty}</td>
                        <td>${element.price}</td>
                        <td>
                            <a class="btn btn-datatable btn-icon btn-danger btn-delete" data-key="${key}" href="#"><i data-key="${key}" class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    `;
                });

                $('#table-value').html(html);
            }

            tableUpdater();
            $('#tambah-item').submit(function(e){
                e.preventDefault();
                let item = {};
                let id = dxSelect.option('value');
                // console.log(id);
                const qty = $('#qty').val();
                const price = $('#price').val();
                // console.log(id, qty, price);
                loadPanel.show();
                let filteredItem = items.filter(el => el.id === id);
                console.log(filteredItem);
                if(filteredItem.length > 0){
                    items = items.map(e => {
                        if(e.id === id){
                            e.qty += parseInt(qty);
                            e.price = parseInt(price);
                            return e;
                        }
                        return e;
                    })
                    tableUpdater();
                    loadPanel.hide();
                }else{
                    console.log(id);
                    $.ajax({
                        url: `{{ route('item.get', '') }}/${id}`,
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        success: function(result) {
                            item = result.data;
                            console.log(item);

                            item.qty = parseInt(qty);
                            item.price = parseInt(price);

                            items.push(item);
                            tableUpdater();

                            loadPanel.hide();
                        },
                        error: function() {
                            deferred.reject("Data Loading Error");
                        },
                    })
                }

                dxSelect.option('value', null);
                $('#qty').val(null);
                $('#price').val(null);


            });

            $('#table-value').on('click', '.btn-delete', function(e){
                let key = $(e.currentTarget).data('key');
                items = items.slice(key+1).concat(items.slice(0, key));
                tableUpdater();
            })

            $('#create-po').submit(function(e){
                e.preventDefault();
                submit(1);
            });

            $('#draft').click(function(e){
                e.preventDefault();
                submit(0);
            });

            function submit(status){
                let formdata = FormData();
                formdata.purchase_no = $('#po_no').val();
                formdata.project_name = $('#project_name').val();
                formdata.branch_id = $('#branch_id').val();
                formdata.stock_type_id = $('#stock_type_id').val();
                formdata.purchase_status = status;
                $.ajax({
                    url: "{{ route('purchase-order.store') }}",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formdata,
                    type: 'POST',
                    success: function(result) {
                        console.log(result);

                        loadPanel.hide();
                    },
                    error: function() {
                        alert('Gagal');
                    },
                });
            }


        });
    </script>
@endsection
