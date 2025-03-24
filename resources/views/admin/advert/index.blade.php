@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Adverts List</h4>
                <h6>Manage your Adverts</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('article.add') }}" class="btn btn-added"><img
                        src="{{ asset('admin/assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add New Advert</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="car" id="">
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-lg col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" class="datetimepicker cal-icon" placeholder="Choose Start Date">
                                </div>
                            </div>

                            <div class="col-lg col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" class="datetimepicker cal-icon" placeholder="Choose End Date">
                                </div>
                            </div>
                            <div class="col-lg col-sm-6 col-12">
                                <div class="form-group">
                                    <select class="select">
                                        <option>Choose Status</option>
                                        <option>Active</option>
                                        <option>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-6 col-12">
                                <div class="form-group">
                                    <a class="btn btn-filters ms-auto"><img src="assets/img/icons/search-whites.svg"
                                            alt="img"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Ads Url</th>
                                <th>Position</th>
                                <th>Page</th>
                                <th>Status</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Created By</th>
                                <th>Date Added</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Pitt</td>
                                <td>
                                    <div class="" style="width: 50px; height:50px;">
                                        <img src="{{ asset('admin/assets/img/customer/customer1.jpg') }}" alt="product">
                                    </div>
                                </td>
                                <td><a href="www.google.com">Google</a></td>
                                <td>Header</td>
                                <td>Home Page</td>
                                <td><span class="badges bg-lightgreen">Active</span></td>
                                <td>1st Jan, 2025</td>
                                <td>10th Jan, 2025</td>
                                <td>Admin</td>
                                <td>10th Jan, 2025</td>
                                <td class="text-center">
                                    <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                        aria-expanded="true">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="edit-sales.html" class="dropdown-item"><img
                                                    src="{{ asset('admin/assets/img/icons/edit.svg') }}" class="me-2"
                                                    alt="img">Edit
                                                Advert</a>
                                        </li>
                                        <li>
                                            <a href="sales-details.html" class="dropdown-item"><img
                                                    src="{{ asset('admin/assets/img/icons/eye1.svg') }}" class="me-2"
                                                    alt="img">Activate Advert</a>
                                        </li>
                                        <li>
                                            <a href="sales-details.html" class="dropdown-item"><img
                                                    src="{{ asset('admin/assets/img/icons/eye1.svg') }}" class="me-2"
                                                    alt="img">Deactivate Advert</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item confirm-text"><img
                                                    src="{{ asset('admin/assets/img/icons/delete1.svg') }}" class="me-2"
                                                    alt="img">Delete
                                                Advert</a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Pitt</td>
                                <td>
                                    <div class="" style="width: 50px; height:50px;">
                                        <img src="{{ asset('admin/assets/img/customer/customer1.jpg') }}" alt="product">
                                    </div>
                                </td>
                                <td><a href="www.google.com">Google</a></td>
                                <td>Header</td>
                                <td>Home Page</td>
                                <td><span class="badges bg-lightred">Active</span></td>
                                <td>1st Jan, 2025</td>
                                <td>10th Jan, 2025</td>
                                <td>Admin</td>
                                <td>10th Jan, 2025</td>
                                <td class="text-center">
                                    <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                        aria-expanded="true">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="edit-sales.html" class="dropdown-item"><img
                                                    src="{{ asset('admin/assets/img/icons/edit.svg') }}" class="me-2"
                                                    alt="img">Edit
                                                Advert</a>
                                        </li>
                                        <li>
                                            <a href="sales-details.html" class="dropdown-item"><img
                                                    src="{{ asset('admin/assets/img/icons/eye1.svg') }}" class="me-2"
                                                    alt="img">Activate Advert</a>
                                        </li>
                                        <li>
                                            <a href="sales-details.html" class="dropdown-item"><img
                                                    src="{{ asset('admin/assets/img/icons/eye1.svg') }}" class="me-2"
                                                    alt="img">Deactivate Advert</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item confirm-text"><img
                                                    src="{{ asset('admin/assets/img/icons/delete1.svg') }}"
                                                    class="me-2" alt="img">Delete
                                                Advert</a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="w-100 d-flex justify-content-center">
            <ul class="pagination">
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:void(0);" aria-label="Previous">
                        <span aria-hidden="true">«</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
                <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" aria-label="Next">
                        <span aria-hidden="true">»</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </div>
    @endsection
