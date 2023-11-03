@extends('template')
@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="folder"></i></div>
                        Unit List
                    </h1>
                </div>
                <div class="col-auto mt-4">
                    <a href="/unit/create" class="btn btn-sm btn-info"><i data-feather="plus"></i> Add</a>
                </div>
            </div>
            <nav class="mt-4 rounded" aria-label="breadcrumb">
                <ol class="breadcrumb px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item active">Unit</li>
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
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Slug</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Unit</th>
                        <th>Slug</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($units as $unit)
                        <tr>
                            <td>{{ $unit->name }}</td>
                            <td></td>
                            <td>
                                <a class="btn btn-datatable btn-icon btn-info me-2" href="{{ route('unit.edit', $unit->id) }}"><i data-feather="edit"></i></a>
                                <a class="btn btn-datatable btn-icon btn-danger btn-delete" data-id="{{ $unit->id }}" href="#"><i data-feather="trash-2"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $units->onEachSide(2)->links() }}
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    const btnDelete = document.querySelectorAll('.btn-delete');
    const url = '/unit/';

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
