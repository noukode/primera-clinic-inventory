@extends('template')
@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user"></i></div>
                        Create User
                    </h1>
                </div>
            </div>
            <nav class="mt-4 rounded" aria-label="breadcrumb">
                <ol class="breadcrumb px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/user">User</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
    </div>
</header>
<div class="container-xl px-4 mt-n10">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img class="img-account-profile rounded-circle mb-2" src="/assets/img/demo/user-placeholder.svg" alt="" />
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <form>
                        <!-- Form Row-->
                        <div class="mb-3">
                            <label class="small mb-1" for="name">Name</label>
                            <input class="form-control" id="name" name="name" type="text" placeholder="Enter your name" value="Name" disabled />
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="email">Email address</label>
                            <input class="form-control" id="email" name="email" type="email" placeholder="Enter your email address" value="name@example.net" disabled />
                        </div>
                        <!-- Form Group (Group Selection Checkboxes)-->
                        {{-- <div class="mb-3">
                            <label class="small mb-1">Group(s)</label>
                            <div class="form-check">
                                <input class="form-check-input" id="groupSales" type="checkbox" value="" />
                                <label class="form-check-label" for="groupSales">Sales</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="groupDevs" type="checkbox" value="" />
                                <label class="form-check-label" for="groupDevs">Developers</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="groupMarketing" type="checkbox" value="" />
                                <label class="form-check-label" for="groupMarketing">Marketing</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="groupManagers" type="checkbox" value="" />
                                <label class="form-check-label" for="groupManagers">Managers</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="groupCustomer" type="checkbox" value="" />
                                <label class="form-check-label" for="groupCustomer">Customer</label>
                            </div>
                        </div> --}}
                        <!-- Form Group (Roles)-->
                        <div class="mb-3">
                            <label class="small mb-1">Role</label>
                            <select class="form-select" name="role_id" aria-label="Default select example" disabled>
                                <option selected disabled>Select a role:</option>
                                <option value="1">Administrator</option>
                                <option value="2">Registered</option>
                                <option value="3">Editor</option>
                                <option value="4">Guest</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
