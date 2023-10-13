@extends('template')
@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="package"></i></div>
                        Edit Item
                    </h1>
                </div>
            </div>
            <nav class="mt-4 rounded" aria-label="breadcrumb">
                <ol class="breadcrumb px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/item">Items</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
                    <form action="/item/{{ $item->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="kode_item" class="form-label">Kode Item</label>
                                    <input type="text" class="form-control" id="kode_item" name="kode_item" placeholder="Kode Item" value="{{ $item->kode_item }}" disabled>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Item Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Item Name" value="{{ $item->name }}">
                                    <div class="invalid-feedback">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ $item->description }}</textarea>
                                    <div class="invalid-feedback">
                                        @error('description')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Item Category</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" aria-label="Item Category" id="category_id" name="category_id">
                                        <option disabled>Open this select menu</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $item->category_id === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        @error('category_id')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="unit_id" class="form-label">Unit</label>
                                    <select class="form-select @error('unit_id') is-invalid @enderror" aria-label="Unit" id="unit_id" name="unit_id">
                                        <option disabled>Open this select menu</option>
                                        @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}" {{ $item->unit_id === $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        @error('unit_id')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stock</label>
                                    <input type="number" class="form-control" id="stock" name="stock" disabled value="{{ $item->stock_sum_quantity }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-2">Update</button>
                                <a href="/item" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

