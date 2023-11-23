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
                    <a href="#" data-bs-toggle="modal" data-bs-target="#createPurchaseOrderModal" class="btn btn-sm btn-info"><i data-feather="plus"></i> Add</a>
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
            <form action="">
                <div class="row mb-2">
                    <div class="col-lg-3 mb-2">
                        <label for="branch">Branch</label>
                        <select name="branch_id" id="branch" class="form-control">
                            <option value="" {{ request('branch_id') === null ? 'selected' : '' }}></option>
                            @foreach ($branches as $branch)
                            <option {{ request('branch_id') == $branch->id ? 'selected' : '' }} value="{{ $branch->id }}" >{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 mb-2">
                        <label for="stock_type">Tipe Stock</label>
                        <select name="stock_type_id" id="stock_type" class="form-control">
                            <option value="" {{ request('stock_type_id') === null ? 'selected' : '' }}></option>
                            @foreach ($stock_types as $st)
                            <option {{ request('stock_type_id') == $st->id ? 'selected' : '' }} value="{{ $st->id }}">{{ $st->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 mb-2">
                        <label for="purchase_status">Status</label>
                        <select name="purchase_status" id="purchase_status" class="form-control">
                            <option value="" {{ request('purchase_status') === null && request('purchase_status') !== 0 ? 'selected' : '' }}></option>
                            @foreach (config('config.purchase_order.status') as $key => $value)
                            <option {{ request('purchase_status') == $key && request('purchase_status') !== null ? 'selected' : '' }} value="{{ $key }}">{{ ucfirst($value) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 mb-2">
                        <label for="search">Cari</label>
                        <input type="text" name="search" class="form-control" id="search" value="{{ request('search') }}">
                    </div>
                    <div class="col-lg-1 mb-2 align-self-end">
                        <button class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>
            <table class="table table-sm table-striped" id="item-table">
                <thead>
                    <tr>
                        <th>Purchase Order No</th>
                        <th>Project Name</th>
                        <th>Total Item</th>
                        <th>Branch</th>
                        <th>Purchase Type</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Purchase Order No</th>
                        <th>Project Name</th>
                        <th>Total Item</th>
                        <th>Branch</th>
                        <th>Purchase Type</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @if (count($purchases) === 0)
                        <tr>
                            <td colspan="8" class="text-center">No data.</td>
                        </tr>
                    @else
                        @foreach ($purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->purchase_no }}</td>
                                <td>{{ $purchase->project_name }}</td>
                                <td>{{ $purchase->details_count }}</td>
                                <td>{{ $purchase->branch->name }}</td>
                                <td>{{ $purchase->stock_type->name }}</td>
                                <td><span class="badge rounded-pill bg-{{ config('config.purchase_order.status_color.'. $purchase->purchase_status) }}">{{ config('config.purchase_order.status.' . $purchase->purchase_status) }}</span></td>
                                <td>{{ $purchase->purchase_date }}</td>
                                <td>
                                    <a class="btn btn-sm btn-info me-2" href="{{ route('purchase-order.show', $purchase->id) }}"><i data-feather="info"></i></a>
                                    @if ($purchase->purchase_status < 2)
                                    <a class="btn btn-sm btn-success me-2" href="{{ route('purchase-order.edit', $purchase->id) }}"><i data-feather="edit"></i></a>
                                    @endif
                                    {{-- <a class="btn btn-sm btn-danger btn-delete" data-id="{{ $purchase->id }}" href="#"><i data-feather="trash-2"></i></a> --}}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{ $purchases->onEachSide(2)->links() }}
        </div>
    </div>
</div>
<div class="modal fade" id="createPurchaseOrderModal" tabindex="-1" aria-labelledby="createPurchaseOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createPurchaseOrderModalLabel">Create Purchase Order</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('purchase-order.store') }}" method="POST">
            <div class="modal-body">
                @csrf
                <div class="mb-3">
                    <label for="project_name" class="form-label">Project Name</label>
                    <input type="text" class="form-control" id="project_name" name="project_name" required>
                  </div>
                <div class="mb-3">
                    <label for="branch_id" class="form-label">Branch</label>
                    <select class="form-control" name="branch_id" id="branch_id" required>
                        <option selected disabled>Select Branch</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="stock_type_id" class="form-label">Purchase Type</label>
                    <select class="form-control" name="stock_type_id" id="stock_type_id" required>
                        <option selected disabled>Select Type</option>
                        @foreach ($stock_types as $stock_type)
                            <option value="{{ $stock_type->id }}">{{ $stock_type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
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
