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
                    @if(session('success'))
                        <div class="alert alert-{{ session('success')['status'] }} mb-2">{{ session('success')['message'] }}</div>
                    @endif
                    <form method="POST" action="{{ route('do_change_password') }}">
                        <!-- Form Row-->
                        @csrf
                        <div class="mb-3">
                            <label class="small mb-1" for="name">Name</label>
                            <input class="form-control @error('name')
                                is-invalid
                            @enderror" id="name" name="name" type="text" placeholder="Enter your first name" value="{{ old('name', $user->name) }}" readonly />
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
                            @enderror" id="email" name="email" type="email" placeholder="Enter your email address" value="{{ old('email', $user->email) }}" readonly/>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1" for="old_password">Old Password</label>
                            <input class="form-control @error('old_password')
                                is-invalid
                            @enderror" id="old_password" name="old_password" type="password" placeholder="Old Password" value=""/>
                            @error('old_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="password">New Password</label>
                            <input class="form-control @error('password')
                                is-invalid
                            @enderror" id="password" name="password" type="password" placeholder="New Password" value=""/>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="password_confirmation">Confirm New Password</label>
                            <input class="form-control @error('password_confirmation')
                                is-invalid
                            @enderror" id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm New Password" value=""/>
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Form Group (Roles)-->
                        <div class="mb-3">
                            <label class="small mb-1">Role</label>
                            <input type="text" class="form-control" name="role" value="{{ $user->role->name }}" readonly>
                        </div>
                        <!-- Submit button-->
                        <button class="btn btn-primary" type="submit">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
