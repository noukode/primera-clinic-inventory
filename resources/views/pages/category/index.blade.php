@extends('template')
@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="tag"></i></div>
                        Category List
                    </h1>
                </div>
                <div class="col-auto mt-4">
                    <a href="/category/create" class="btn btn-sm btn-info"><i data-feather="plus"></i> Add</a>
                </div>
            </div>
            <nav class="mt-4 rounded" aria-label="breadcrumb">
                <ol class="breadcrumb px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item active">Category</li>
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
                    <div class="col-lg-5 mb-2">
                        <label for="search">Cari</label>
                        <input type="text" name="search" class="form-control" id="search" value="{{ request('search') }}">
                    </div>
                    <div class="col-lg-1 mb-2 align-self-end">
                        <button class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th width="90%">Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @if (count($categories) === 0)
                        <tr>
                            <td colspan="2" class="text-center">No data.</td>
                        </tr>
                    @else

                    @endif
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>
                                <a class="btn btn-datatable btn-icon btn-success me-2" href="{{ route('category.edit', $category->id) }}"><i data-feather="edit"></i></a>
                                <a class="btn btn-datatable btn-icon btn-danger btn-delete" data-id="{{ $category->id }}" href="#"><i data-feather="trash-2"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $categories->appends(request()->all())->onEachSide(2)->links() }}
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    const btnDelete = document.querySelectorAll('.btn-delete');
    const url = '/category/';

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
