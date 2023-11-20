@extends('template')
@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="package"></i></div>
                        Stock List
                    </h1>
                </div>
                <div class="col-auto mt-4">
                    {{-- <a href="#" class="btn btn-sm btn-success"><i data-feather="log-out"></i> Export</a>
                    <a href="#" class="btn btn-sm btn-warning"><i data-feather="log-in"></i> Import</a> --}}
                </div>
            </div>
            <nav class="mt-4 rounded" aria-label="breadcrumb">
                <ol class="breadcrumb px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item active">Stock</li>
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
                    <div class="col-lg-4 mb-2">
                        <label for="branch">Branch</label>
                        <select name="branch_id" id="branch" class="form-control">
                            <option value="" {{ request('branch_id') === null ? 'selected' : '' }}></option>
                            @foreach ($branches as $branch)
                            <option {{ request('branch_id') == $branch->id ? 'selected' : '' }} value="{{ $branch->id }}" >{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4 mb-2">
                        <label for="stock_type">Tipe Stock</label>
                        <select name="stock_type_id" id="stock_type" class="form-control">
                            <option value="" {{ request('stock_type_id') === null ? 'selected' : '' }}></option>
                            @foreach ($stock_types as $st)
                            <option {{ request('stock_type_id') == $st->id ? 'selected' : '' }} value="{{ $st->id }}">{{ $st->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4 mb-2">
                        <label for="unit">Unit</label>
                        <select name="unit_id" id="unit" class="form-control">
                            <option value="" {{ request('unit_id') === null ? 'selected' : '' }}></option>
                            @foreach ($units as $unit)
                                <option {{ request('unit_id') == $unit->id ? 'selected' : '' }} value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-5 mb-2">
                        <label for="category">Category</label>
                        <select name="category_id" id="category" class="form-control">
                            <option value="" {{ request('category_id') === null ? 'selected' : '' }}></option>
                            @foreach ($categories as $category)
                                <option {{ request('category_id') == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-5 mb-2">
                        <label for="search">Cari</label>
                        <input type="text" name="search" class="form-control" id="search" value="{{ request('search') }}">
                    </div>
                    <div class="col-lg-2 mb-2 align-self-end">
                        <button class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>
            <table class="table table-sm table-striped" id="item-table">
                <thead>
                    <tr>
                        <th>Kode Item</th>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Branch</th>
                        <th>Tipe Stock</th>
                        <th>Stock</th>
                        <th>Unit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Kode Item</th>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Branch</th>
                        <th>Tipe Stock</th>
                        <th>Stock</th>
                        <th>Unit</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @if (count($stocks) === 0)
                        <tr>
                            <td colspan="9" class="text-center">No data.</td>
                        </tr>
                    @else
                        @foreach ($stocks as $stock)
                            <tr>
                                <td>{{ $stock->item->kode_item }}</td>
                                <td>{{ $stock->item->name }}</td>
                                <td>{{ $stock->item->category->name }}</td>
                                <td>{{ $stock->location->name }}</td>
                                <td>{{ $stock->location->branch->name }}</td>
                                <td>{{ $stock->stock_type->name }}</td>
                                <td>{{ $stock->sum }}</td>
                                <td>{{ $stock->item->unit->name }}</td>
                                <td>
                                    <a class="btn btn-sm btn-info me-2" href="/stock/{{ $stock->item->id }}?branch_id={{ $stock->location->branch_id }}&location_id={{ $stock->location_id }}&stock_type={{ $stock->stock_type_id }}"><i data-feather="info"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{ $stocks->appends(request()->all())->onEachSide(2)->links() }}
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
