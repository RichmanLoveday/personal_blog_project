@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Category List</h4>
                <h6>Manage your categories</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('admin.category.add') }}" class="btn btn-added"><img
                        src="{{ asset('admin/assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add New Category</a>
            </div>
        </div>

        <div class="card">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($categories)
                                @forelse ($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ Str::ucfirst($category->name) }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>
                                            <span
                                                class="badges 
                                                @if ($category->status == 'active') bg-lightgreen 
                                                @else bg-lightred @endif">
                                                {{ $category->status == 'active' ? 'Enabled' : 'Disabled' }}
                                            </span>
                                        </td>
                                        <td>{{ date('M d, Y', strtotime($category->created_at)) }}</td>
                                        <td class="text-center">
                                            <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('admin.category.edit', $category->id) }}"
                                                        class="dropdown-item"><img
                                                            src="{{ asset('admin/assets/img/icons/edit.svg') }}" class="me-2"
                                                            alt="img">Edit Category</a>
                                                </li>

                                                <li>
                                                    <a href="#"
                                                        onclick="updateCategoryStatus(this, '{{ $category->id }}', 'active')"
                                                        class="dropdown-item enable"
                                                        style="display: {{ $category->status == 'active' ? 'none' : 'block' }}"><img
                                                            src="{{ asset('admin/assets/img/icons/eye1.svg') }}" class="me-2"
                                                            alt="img">Enable</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        onclick="updateCategoryStatus(this, '{{ $category->id }}', 'in-active')"
                                                        class="dropdown-item in-active"
                                                        style="display: {{ $category->status == 'in-active' ? 'none' : 'block' }};"><img
                                                            src="{{ asset('admin/assets/img/icons/eye1.svg') }}" class="me-2"
                                                            alt="img">Disable</a>
                                                </li>
                                                <li>
                                                    <a href="#" onclick="deleteCategory(this, '{{ $category->id }}')"
                                                        class="dropdown-item"><img
                                                            src="{{ asset('admin/assets/img/icons/delete1.svg') }}"
                                                            class="me-2" alt="img">Delete
                                                        Category</a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{ $categories->onEachSide(1)->links('vendor.pagination.admin-panel-pagination') }}

        @if (session('status'))
            <script>
                $(document).ready(function() {
                    toastr.success("{{ session('status') }}");
                });
            </script>
        @endif
        <script src="{{ asset('admin/assets/js/categories.js') }}"></script>
    @endsection
