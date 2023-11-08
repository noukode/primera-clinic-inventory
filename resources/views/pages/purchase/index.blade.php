@extends('template')
@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="download"></i></div>
                        Purchase Order
                    </h1>
                </div>
                <div class="col-auto mt-4">
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#create-purchase-order-modal"><i data-feather="plus"></i> Add</button>
                    {{-- <a href="#" class="btn btn-sm btn-success"><i data-feather="log-out"></i> Export</a>
                    <a href="#" class="btn btn-sm btn-warning"><i data-feather="log-in"></i> Import</a> --}}
                </div>
            </div>
            <nav class="mt-4 rounded" aria-label="breadcrumb">
                <ol class="breadcrumb px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item active">Purchase Order</li>
                </ol>
            </nav>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container-fluid px-4 mt-n10">
    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-{{ session('success')['status'] }}">{{ session('success')['message'] }}</div>
            @endif
            <table class="table table-sm table-striped" id="item-table">
                <thead>
                    <tr>
                        <th>Purchase Order No</th>
                        <th>Total Item</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Purchase Order No</th>
                        <th>Total Item</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->purchase_no }}</td>
                            <td></td>
                            <td>{{ $purchase->purchase_status }}</td>
                            <td>{{ $purchase->purchase_date }}</td>
                            <td>
                                <a class="btn btn-sm btn-info me-2" href="{{ route('purchase_order.show', $purchase->id) }}"><i data-feather="info"></i></a>
                                <a class="btn btn-sm btn-success me-2" href="{{ route('purchase_order.edit', $purchase->id) }}"><i data-feather="edit"></i></a>
                                {{-- <a class="btn btn-sm btn-danger btn-delete" data-id="{{ $purchase->id }}" href="#"><i data-feather="trash-2"></i></a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $purchases->onEachSide(2)->links() }}
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="create-purchase-order-modal" tabindex="-1" aria-labelledby="create-purchase-order-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="create-purchase-order-modalLabel">Create Purchase Order</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="purchase_no" class="form-label">Purchase Order No</label>
                        <input type="text" class="form-control" id="purchase_no" name="purchase_no">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
  </div>
@endsection

@section('javascript')
<script>
    let itemTable = document.getElementById('item-table');

    // itemTable.addEventListener('click', function(e){
    //     console.log(e.target.parentElement);
    //     if(e.target.parentElement){}
    // })

    const btnDelete = document.querySelectorAll('.btn-delete');
    const url = '/purchase/';

    btnDelete.forEach(el => {
        el.addEventListener('click', function(e){
            el.getAttribute('data-id');
            Helper.confirmAlert('Hapus Data', 'warning', 'Ya').then(result => {
                if(result.isConfirmed){
                    Helper.fetchDelete(`${url}${el.getAttribute('data-id')}`)
                        .then(response => response.json())
                        .then(response => {
                            Helper.simpleNotification(response.message, '', response.status).then(res => response.error === 0 ? Helper.refresh() : '');
                        })
                }
            });
        })
    });
</script>
@endsection
