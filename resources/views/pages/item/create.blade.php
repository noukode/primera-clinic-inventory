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
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container-fluid px-4 mt-n10">
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        Item Image
                    </div>
                    <img src="/assets/img/illustrations/profiles/profile-1.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        Item Details
                    </div>
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Item Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Item Name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Item Category</label>
                                    <select class="form-select" aria-label="Item Category" id="category" name="category">
                                        <option value="0" selected>Open this select menu</option>
                                        <option value="1">Dispose</option>
                                        <option value="2">Alat</option>
                                        <option value="3">Obat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="unit" class="form-label">Unit</label>
                                    <select class="form-select" aria-label="Unit" id="unit" name="unit">
                                        <option value="0" selected>Open this select menu</option>
                                        <option value="1">pcs</option>
                                        <option value="2">pack</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-2">Create</button>
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

