@extends('template')
@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user"></i></div>
                        Edit User
                    </h1>
                </div>
            </div>
            <nav class="mt-4 rounded" aria-label="breadcrumb">
                <ol class="breadcrumb px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/user">User</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
</header>
<div class="container-xl px-4 mt-n10">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.update', $user->id) }}">
                        <!-- Form Row-->
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="small mb-1" for="name">Name</label>
                            <input class="form-control @error('name')
                                is-invalid
                            @enderror" id="name" name="name" type="text" placeholder="Enter your first name" value="{{ old('name', $user->name) }}" />
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="email">Email address</label>
                            <input class="form-control @error('email')
                                is-invalid
                            @enderror" id="email" name="email" type="email" placeholder="Enter your email address" value="{{ old('email', $user->email) }}" />
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Form Group (Roles)-->
                        <div class="mb-3">
                            <label class="small mb-1">Role</label>
                            <select class="form-select @error('role_id')
                                is-invalid
                            @enderror" name="role_id" aria-label="Default select example">
                                <option selected disabled>Select a role:</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Submit button-->
                        <button class="btn btn-primary" type="submit">Update user</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
