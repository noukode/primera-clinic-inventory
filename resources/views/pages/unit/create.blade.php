@extends('template')
@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="folder"></i></div>
                        Create Unit
                    </h1>
                </div>
            </div>
            <nav class="mt-4 rounded" aria-label="breadcrumb">
                <ol class="breadcrumb px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/unit">Unit</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container-fluid px-4 mt-n10">
    <div class="row justify-content-center">
        {{-- <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        Item Image
                    </div>
                    <img src="/assets/img/illustrations/profiles/profile-1.png" alt="" class="img-fluid">
                </div>
            </div>
        </div> --}}
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        Unit Details
                    </div>
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Unit Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Unit Name">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" disabled>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-2">Create</button>
                                <a href="/unit" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

