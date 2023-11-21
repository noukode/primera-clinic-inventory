@extends('template')
@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user"></i></div>
                        User Detail
                    </h1>
                </div>
            </div>
            <nav class="mt-4 rounded" aria-label="breadcrumb">
                <ol class="breadcrumb px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/user">User</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
    </div>
</header>
<div class="container-xl px-4 mt-n10">
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-body">
                    <form>
                        <!-- Form Row-->
                        <div class="mb-3">
                            <label class="small mb-1" for="name">Name</label>
                            <input class="form-control" id="name" name="name" type="text" placeholder="Enter your name" value="{{ $user->name }}" disabled />
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="email">Email address</label>
                            <input class="form-control" id="email" name="email" type="email" placeholder="Enter your email address" value="{{ $user->email }}" disabled />
                        </div>
                        <!-- Form Group (Roles)-->
                        <div class="mb-3">
                            <label class="small mb-1">Role</label>
                            <select class="form-select" name="role_id" aria-label="Default select example" disabled>
                                <option selected>{{ $user->role->name }}</option>
                            </select>
                        </div>
                        @if ($user->ttd !== null)
                            <div class="mb-3">
                                <img src="/storage/{{ $user->ttd }}" class="img-fluid img-thumbnail" alt="">
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
