@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Team Management List</h4>
                <h6>Manage your Team Members</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('team.management.add') }}" class="btn btn-added"><img
                        src="{{ asset('admin/assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add New Team
                    Member</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Photo</th>
                                <th>Date Added</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Pitt</td>
                                <td>Graphic Designer</td>
                                <td>
                                    <div class="" style="width: 50px; height:50px;">
                                        <img src="{{ asset('admin/assets/img/customer/customer1.jpg') }}" alt="product">
                                    </div>
                                </td>
                                <td>1st Jan, 2025</td>
                                <td class="text-center">
                                    <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                        aria-expanded="true">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('author.profile') }}" class="dropdown-item"><img
                                                    src="{{ asset('admin/assets/img/icons/edit.svg') }}" class="me-2"
                                                    alt="img">Edit</a>
                                        </li>

                                        <li>
                                            <a href="sales-details.html" class="dropdown-item"><img
                                                    src="{{ asset('admin/assets/img/icons/eye1.svg') }}" class="me-2"
                                                    alt="img">Delete</a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Pitt</td>
                                <td>Graphic Designer</td>
                                <td>
                                    <div class="" style="width: 50px; height:50px;">
                                        <img src="{{ asset('admin/assets/img/customer/customer1.jpg') }}" alt="product">
                                    </div>
                                </td>
                                <td>1st Jan, 2025</td>
                                <td class="text-center">
                                    <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                        aria-expanded="true">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('author.profile') }}" class="dropdown-item"><img
                                                    src="{{ asset('admin/assets/img/icons/edit.svg') }}" class="me-2"
                                                    alt="img">Edit</a>
                                        </li>

                                        <li>
                                            <a href="sales-details.html" class="dropdown-item"><img
                                                    src="{{ asset('admin/assets/img/icons/eye1.svg') }}" class="me-2"
                                                    alt="img">Delete</a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
