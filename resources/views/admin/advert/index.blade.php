@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Adverts List</h4>
                <h6>Manage your Adverts</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('admin.advert.create') }}" class="btn btn-added"><img
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
                                <th>Ads Url</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Starting Date</th>
                                <th>Expiring Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($adverts)
                                @foreach ($adverts as $advert)
                                    <tr>
                                        <td>{{ $adverts->firstItem() + $loop->index }}</td>
                                        <td>{{ $advert->title }}</td>
                                        <td><a href="{{ $advert->url }}"
                                                target="_blank">{{ Str::limit($advert->url, 50, '...') }}</a></td>
                                        <td><span
                                                class="badge {{ $advert->status == 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($advert->status) }}</span>
                                        </td>
                                        <td>{{ Str::ucfirst($advert->user->firstName) . ' ' . Str::ucfirst($advert->user->lastName) }}
                                        </td>
                                        <td>{{ date('jS M, Y', strtotime($advert->start_date)) }}</td>
                                        <td>{{ date('jS M, Y', strtotime($advert->end_date)) }}</td>
                                        <td class="text-center">
                                            <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('admin.advert.edit', $advert->id) }}"
                                                        class="dropdown-item"><img
                                                            src="{{ asset('admin/assets/img/icons/edit.svg') }}" class="me-2"
                                                            alt="img">Edit
                                                        Advert</a>
                                                </li>
                                                <li>
                                                    <a href="edit-sales.html" class="dropdown-item"><img
                                                            src="{{ asset('admin/assets/img/icons/edit.svg') }}" class="me-2"
                                                            alt="img">View Placements</a>
                                                </li>
                                                @if ($advert->status == 'active')
                                                    <li>
                                                        <a href="sales-details.html" class="dropdown-item"><img
                                                                src="{{ asset('admin/assets/img/icons/eye1.svg') }}"
                                                                class="me-2" alt="img">Deactivate Advert</a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a href="sales-details.html" class="dropdown-item"><img
                                                                src="{{ asset('admin/assets/img/icons/eye1.svg') }}"
                                                                class="me-2" alt="img">Activate Advert</a>
                                                    </li>
                                                @endif

                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item confirm-text"><img
                                                            src="{{ asset('admin/assets/img/icons/delete1.svg') }}"
                                                            class="me-2" alt="img">Delete
                                                        Advert</a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Ads Url</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Starting Date</th>
                                <th>Expiring Date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{ $adverts->onEachSide(1)->links('vendor.pagination.admin-panel-pagination') }}
        @if (session('success'))
            <script>
                $(document).ready(function() {
                    toastr.success("{{ session('success') }}");
                });
            </script>
        @endif


        @if (session('error'))
            <script>
                $(document).ready(function() {
                    toastr.error("{{ session('error') }}");
                });
            </script>
        @endif

        <script src="{{ asset('admin/assets/js/adverts.js') }}"></script>
    @endsection
