@extends('template')
@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="tag"></i></div>
                        Edit Category
                    </h1>
                </div>
            </div>
            <nav class="mt-4 rounded" aria-label="breadcrumb">
                <ol class="breadcrumb px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/category">Category</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
                    <form action="{{ route('category.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Category Name</label>
                                    <input type="text" class="form-control @error('name')
                                        is-invalid
                                    @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" placeholder="Category Name">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control @error('slug')
                                        is-invalid
                                    @enderror" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" placeholder="Slug" readonly>
                                    @error('slug')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-2">Update</button>
                                <a href="/category" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('javascript')
    <script>
        const nameInput = document.getElementById('name');

        nameInput.addEventListener('change', function(e){
            const slugInput = document.getElementById('slug');
            slugInput.value = nameInput.value.toLowerCase().trim().split(/\s+/).join('-');
        });
    </script>
@endsection
