@extends('template')
@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="package"></i></div>
                        Stock {{ $item->name }}
                    </h1>
                </div>
            </div>
            <nav class="mt-4 rounded" aria-label="breadcrumb">
                <ol class="breadcrumb px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/stock">Stock</a></li>
                    <li class="breadcrumb-item active">{{ $item->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container-fluid px-4 mt-n10">
    <div class="card">
        <div class="card-body">
            <form action="">
                <div class="row mb-2">
                    <div class="col-lg-4 mb-2">
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
                        <select name="stock_type" id="stock_type" class="form-control">
                            <option value="" {{ request('stock_type') === null ? 'selected' : '' }}></option>
                            @foreach ($stock_types as $st)
                            <option {{ request('stock_type') == $st->id ? 'selected' : '' }} value="{{ $st->id }}">{{ $st->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4 mb-2">
                        <label for="location_id">Location</label>
                        <select name="location_id" id="location_id" class="form-control">
                            <option value="" {{ request('location_id') === null ? 'selected' : '' }}></option>
                            @foreach ($locations as $st)
                            <option {{ request('location_id') == $st->id ? 'selected' : '' }} value="{{ $st->id }}">{{ $st->name }} ({{ $st->branch->name }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-1 mb-2 align-self-end">
                        <button class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container-fluid px-4 mt-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="mb-3">
                        <label for="kode_item" class="form-label">Kode Item</label>
                        <div class="fs-4 fw-bold">{{ $item->kode_item }}</div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Item Name</label>
                        <div class="fs-4 fw-bold">{{ $item->name }}</div>
                    </div>
                </div>
                @if (request('location_id'))
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Lokasi</label>
                            <div class="fs-4 fw-bold">{{ $location->name }}</div>
                        </div>
                    </div>
                @endif
                @if (request('stock_type'))
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tipe Stock</label>
                            <div class="fs-4 fw-bold">{{ $stock_type->name }}</div>
                        </div>
                    </div>
                @endif
                {{-- <div class="col-12">
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" disabled>{{ $item->description }}</textarea>
                    </div>
                </div> --}}
                <div class="col-6">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Item Category</label>
                        <div class="fs-4 fw-bold">{{ $item->category->name }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="unit_id" class="form-label">Unit</label>
                        <div class="fs-4 fw-bold">{{ $item->unit->name }}</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <div class="fs-4 fw-bold">{{ $stock }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid px-4 mt-3">
    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-{{ session('success')['status'] }}">{{ session('success')['message'] }}</div>
            @endif
            <table class="table table-sm table-striped" id="item-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Unit</th>
                        <th>Location</th>
                        <th>Branch</th>
                        <th>Tipe Stock</th>
                        <th>Type</th>
                        <th>Qty</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Tanggal</th>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Unit</th>
                        <th>Location</th>
                        <th>Branch</th>
                        <th>Tipe Stock</th>
                        <th>Type</th>
                        <th>Qty</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($stock_histories as $stock)
                        <tr>
                            <td>{{ $stock->created_at }}</td>
                            <td>{{ $stock->detail->item_detail->name }}</td>
                            <td>{{ $stock->detail->item_detail->category->name }}</td>
                            <td>{{ $stock->detail->item_detail->unit->name }}</td>
                            {{-- <td></td> --}}
                            {{-- <td></td> --}}
                            <td>{{ $stock->detail->item_detail->location }}</td>
                            <td>{{ $stock->detail->item_detail->branch }}</td>
                            <td>{{ $stock->detail->item_detail->stock_type }}</td>
                            <td>{{ $stock->type }}</td>
                            <td><span class="{{ $stock->type == "in" ? 'text-success' : 'text-danger' }}">{{ $stock->qty }}</span></td>
                            <td>
                                <a href="#" data-bs-toggle="tooltip" data-bs-title="123/POMUK3PC/XI/2023 ({{ $stock->detail->foreign_id->project_name }})"><i data-feather="info"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $stock_histories->appends(request()->all())->onEachSide(2)->links() }}
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

    // const btnDelete = document.querySelectorAll('.btn-delete');
    // const url = '/item/';

    // btnDelete.forEach(el => {
    //     el.addEventListener('click', function(e){
    //         el.getAttribute('data-id');
    //         Helper.confirmAlert('Hapus Data', 'warning', 'Ya').then(result => {
    //             if(result.isConfirmed){
    //                 Helper.fetchDelete(`${url}${el.getAttribute('data-id')}`)
    //                     .then(response => response.json())
    //                     .then(response => {
    //                         Helper.simpleNotification(response.message, '', response.status).then(res => response.error === 0 ? Helper.refresh() : '');
    //                     })
    //             }
    //         });
    //     })
    });
</script>
@endsection
