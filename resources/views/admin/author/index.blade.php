@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Authors List</h4>
                <h6>Manage your Authors</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('admin.author.create') }}" class="btn btn-added"><img
                        src="{{ asset('admin/assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add New Author</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="car" id="">
                    <div class="card-body pb-0">
                        <form action="{{ route('admin.author.filter') }}" method="GET">
                            <div class="row">
                                <div class="col-lg col-sm-6 col-12">
                                    <div class="form-group">
                                        <input id="startDate" oninput="determinEndDate(this)" type="text"
                                            value="{{ old('startDate', request('startDate')) }}" name="startDate"
                                            class="datetimepicker cal-icon" placeholder="Choose Start Date">
                                    </div>
                                </div>

                                <div class="col-lg col-sm-6 col-12">
                                    <div class="form-group">
                                        <input id="endDate" type="text" @disabled(!request('endDate'))
                                            value="{{ old('endDate', request('endDate')) }}" name="endDate"
                                            class="datetimepicker cal-icon" placeholder="Choose End Date">
                                    </div>
                                </div>
                                <div class="col-lg-1 col-sm-6 col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-filters ms-auto"><img
                                                src="{{ asset('admin/assets/img/icons/search-whites.svg') }}"
                                                alt="img"></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Photo</th>
                                <th>Status</th>
                                <th>Date Added</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($allAuthors)
                                @foreach ($allAuthors as $author)
                                    <tr>
                                        <td>{{ $articles->firstItem() + $loop->index }}</td>
                                        <td>{{ Str::ucfirst($author->firstName) . ' ' . Str::ucfirst($author->lastName) }}</td>
                                        <td>{{ $author->email }}</td>
                                        <td>
                                            <div class="" style="width: 50px; height:50px;">
                                                <img src=" {{ !is_null($author->photo) ? asset($author->photo) : asset('admin/assets/img/icons/person_icon.png') }}"
                                                    alt="product">
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="badge {{ $author->status == 'active' ? 'bg-success' : 'bg-danger' }} fw-bold">{{ $author->status == 'active' ? 'active' : 'in-active' }}</span>
                                        </td>
                                        <td>{{ date('d M, Y', strtotime($author->created_at)) }}</td>
                                        <td class="text-center">
                                            <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('admin.author.profile', $author->id) }}"
                                                        class="dropdown-item"><img
                                                            src="{{ asset('admin/assets/img/icons/edit.svg') }}" class="me-2"
                                                            alt="img">View</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        style="display: {{ $author->status == 'active' ? 'none' : 'block' }};"
                                                        onclick="updateAuthorStatus(this, '{{ $author->id }}', 'active')"
                                                        class="dropdown-item enable"><img
                                                            src="{{ asset('admin/assets/img/icons/eye1.svg') }}" class="me-2"
                                                            alt="img">Activate</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        style="display: {{ $author->status == 'in-active' ? 'none' : 'block' }};"
                                                        onclick="updateAuthorStatus(this, '{{ $author->id }}', 'in-active')"
                                                        class="dropdown-item"><img
                                                            src="{{ asset('admin/assets/img/icons/eye1.svg') }}" class="me-2"
                                                            alt="img">Deactive</a>
                                                </li>
                                                <li>
                                                    <a href="#" onclick="deleteUser('{{ $author->id }}')"
                                                        class="dropdown-item"><img
                                                            src="{{ asset('admin/assets/img/icons/delete1.svg') }}"
                                                            class="me-2" alt="img">Delete</a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{ $allAuthors->onEachSide(1)->links('vendor.pagination.admin-panel-pagination') }}
        @if (session('status'))
            <script>
                $(document).ready(function() {
                    toastr.success("{{ session('status') }}");
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
        <script src="{{ asset('admin/assets/js/authors.js') }}"></script>
    @endsection
