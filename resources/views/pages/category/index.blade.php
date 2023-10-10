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
                    <li class="breadcrumb-item"><a href="dashboard-1.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Category</li>
                </ol>
            </nav>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container-fluid px-4 mt-n10">
    <div class="card">
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Slug</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Category</th>
                        <th>Slug</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td>Dispose</td>
                        <td>dispose</td>
                        <td>
                            <a class="btn btn-datatable btn-icon btn-info me-2" href="/item/1"><i data-feather="info"></i></a>
                            <a class="btn btn-datatable btn-icon btn-success me-2" href="#"><i data-feather="edit"></i></a>
                            <a class="btn btn-datatable btn-icon btn-danger" href="#"><i data-feather="trash-2"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    window.addEventListener('DOMContentLoaded', event => {
        // Simple-DataTables
        // https://github.com/fiduswriter/Simple-DataTables/wiki

        const datatablesSimple = document.getElementById('datatablesSimple');
        if (datatablesSimple) {
            new simpleDatatables.DataTable(datatablesSimple);
        }
    });
</script>
@endsection
