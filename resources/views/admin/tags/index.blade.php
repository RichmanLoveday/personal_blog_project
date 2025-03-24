@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Tags List</h4>
                <h6>Manage your tags</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('admin.tag.create') }}" class="btn btn-added"><img
                        src="{{ asset('admin/assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add New Tag</a>
            </div>
        </div>

        <div class="card">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tag Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($tags)
                                @foreach ($tags as $tag)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ Str::ucfirst($tag->name) }}</td>
                                        <td>{{ $tag->slug }}</td>
                                        <td>
                                            <span
                                                class=" badge {{ $tag->status == 'active' ? 'bg-success' : 'bg-danger' }}   text-2xl">{{ $tag->status == 'active' ? 'active' : 'in-active' }}</span>
                                        </td>
                                        <td>{{ date('M d, Y', strtotime($tag->created_at)) }}</td>
                                        <td class="text-center">
                                            <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('admin.tag.edit', $tag->id) }}" class="dropdown-item"><img
                                                            src="{{ asset('admin/assets/img/icons/edit.svg') }}" class="me-2"
                                                            alt="img">Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a style="display: {{ $tag->status == 'active' ? 'none' : 'block' }};"
                                                        onclick="updateTagStatus(this, '{{ $tag->id }}', 'active')"
                                                        href="#" class="dropdown-item enable"><img
                                                            src="{{ asset('admin/assets/img/icons/eye1.svg') }}"
                                                            class="me-2 enable" alt="img">Enable</a>
                                                </li>
                                                <li>
                                                    <a style="display: {{ $tag->status == 'in-active' ? 'none' : 'block' }};"
                                                        onclick="updateTagStatus(this, '{{ $tag->id }}', 'in-active')"
                                                        href="#" class="dropdown-item in-active"><img
                                                            src="{{ asset('admin/assets/img/icons/eye1.svg') }}"
                                                            class="me-2 disable" alt="img">Disable</a>
                                                </li>

                                                <li>
                                                    <a href="#" onclick="deleteTag(this, '{{ $tag->id }}')"
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

        {{ $tags->onEachSide(1)->links('vendor.pagination.admin-panel-pagination') }}

        @if (session('status'))
            <script>
                $(document).ready(function() {
                    toastr.success("{{ session('status') }}");
                });
            </script>
        @endif
        <script src="{{ asset('admin/assets/js/tags.js') }}"></script>
    @endsection
