@extends('template')
@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="package"></i></div>
                        Item Detail
                    </h1>
                </div>
            </div>
            <nav class="mt-4 rounded" aria-label="breadcrumb">
                <ol class="breadcrumb px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/item">Items</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container px-4 mt-n10">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        Item Details
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="kode_item" class="form-label">Kode Item</label>
                                <input type="text" class="form-control" id="kode_item" name="kode_item" value="{{ $item->kode_item }}" disabled>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Item Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}" disabled>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" disabled>{{ $item->description }}</textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Item Category</label>
                                <select class="form-select" aria-label="Item Category" id="category_id" name="category_id" disabled>
                                    <option value="{{ $item->category_id }}">{{ $item->category->name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="unit_id" class="form-label">Unit</label>
                                <select class="form-select" aria-label="Unit" id="unit_id" name="unit_id" disabled>
                                    <option value="{{ $item->unit_id }}">{{ $item->unit->name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock" disabled value="{{ $item->stock_sum_quantity }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

