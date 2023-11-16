@extends('template')
@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="package"></i></div>
                        Items List
                    </h1>
                </div>
                <div class="col-auto mt-4">
                    <a href="/item/create" class="btn btn-sm btn-info"><i data-feather="plus"></i> Add</a>
                    {{-- <a href="#" class="btn btn-sm btn-success"><i data-feather="log-out"></i> Export</a>
                    <a href="#" class="btn btn-sm btn-warning"><i data-feather="log-in"></i> Import</a> --}}
                </div>
            </div>
            <nav class="mt-4 rounded" aria-label="breadcrumb">
                <ol class="breadcrumb px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item active">Items</li>
                </ol>
            </nav>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container px-4 mt-n10">
    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-{{ session('success')['status'] }}">{{ session('success')['message'] }}</div>
            @endif
            <form action="">
                <div class="row mb-2">
                    <div class="col-lg-3 mb-2">
                        <label for="unit">Unit</label>
                        <select name="unit_id" id="unit" class="form-control">
                            <option value="" {{ request('unit_id') === null ? 'selected' : '' }}></option>
                            @foreach ($units as $unit)
                                <option {{ request('unit_id') == $unit->id ? 'selected' : '' }} value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 mb-2">
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
                    <div class="col-lg-1 mb-2 align-self-end">
                        <button class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>
            <table class="table table-sm table-striped" id="item-table">
                <thead>
                    <tr>
                        <th width="10%">Kode Item</th>
                        <th>Item</th>
                        <th width="10%">Category</th>
                        <th width="10%">Unit</th>
                        <th width="10%">Stock</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Kode Item</th>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Unit</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @if (count($items) === 0)
                        <tr>
                            <td colspan="6" class="text-center">No data.</td>
                        </tr>
                    @else
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->kode_item }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->category->name }}</td>
                                <td>{{ $item->unit->name }}</td>
                                <td>{{ $item->stock_sum_quantity }}</td>
                                <td>
                                    <a class="btn btn-sm btn-info me-2" href="/item/{{ $item->id }}"><i data-feather="info"></i></a>
                                    <a class="btn btn-sm btn-success me-2" href="/item/{{ $item->id }}/edit"><i data-feather="edit"></i></a>
                                    <a class="btn btn-sm btn-danger btn-delete" data-id="{{ $item->id }}" href="#"><i data-feather="trash-2"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{ $items->appends(request()->all())->onEachSide(2)->links() }}
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
    const url = '/item/';

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
