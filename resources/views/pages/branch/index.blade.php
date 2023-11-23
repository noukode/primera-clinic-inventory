@extends('template')
@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="folder"></i></div>
                        Branch List
                    </h1>
                </div>
                <div class="col-auto mt-4">
                    <a href="{{ route('branch.create') }}" class="btn btn-sm btn-info"><i data-feather="plus"></i> Add</a>
                    {{-- <a href="#" class="btn btn-sm btn-success"><i data-feather="log-out"></i> Export</a>
                    <a href="#" class="btn btn-sm btn-warning"><i data-feather="log-in"></i> Import</a> --}}
                </div>
            </div>
            <nav class="mt-4 rounded" aria-label="breadcrumb">
                <ol class="breadcrumb px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item active">Branch</li>
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
            <table class="table table-sm table-striped" id="item-table">
                <thead>
                    <tr>
                        <th>Branch Name</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Branch Name</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @if (count($branches) === 0)
                        <tr>
                            <td colspan="6" class="text-center">No data.</td>
                        </tr>
                    @else
                        @foreach ($branches as $branch)
                            <tr>
                                <td>{{ $branch->name }}</td>
                                <td>
                                    <a class="btn btn-sm btn-info me-2" href="/branch/{{ $branch->id }}"><i data-feather="info"></i></a>
                                    <a class="btn btn-sm btn-success me-2" href="/branch/{{ $branch->id }}/edit"><i data-feather="edit"></i></a>
                                    <a class="btn btn-sm btn-danger btn-delete" data-id="{{ $branch->id }}" href="#"><i data-feather="trash-2"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{ $branches->appends(request()->all())->onEachSide(2)->links() }}
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
    const url = '/branch/';

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
