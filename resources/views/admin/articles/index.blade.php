@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Articles List</h4>
                <h6>Manage your Articles</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('admin.article.create') }}" class="btn btn-added"><img
                        src="{{ asset('admin/assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add New Article</a>
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
                                        <option>Choose Banner</option>
                                        <option>Banner</option>
                                        <option>Banner Right Top</option>
                                        <option>Banner Right Bottom</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg col-sm-6 col-12">
                                <div class="form-group">
                                    <select class="select">
                                        <option>Choose News Type</option>
                                        <option>Trending News</option>
                                        <option>Featured News</option>
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
                                <th>Photo</th>
                                <th>Category</th>
                                <th>Tags</th>
                                <th>Created By</th>
                                <th>Slider</th>
                                <th>Banner Right Top</th>
                                <th>Banner Right Bottom</th>
                                <th>Trending News</th>
                                <th>Featured News</th>
                                <th>Status</th>
                                <th>Published Date</th>
                                <th>Date Added</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($articles)
                                @foreach ($articles as $article)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ Str::words($article->title, 5, '......') }}</td>
                                        <td>
                                            <div class="" style="width: 50px; height:50px;">
                                                <img src="{{ asset($article->image) }}" alt="product">
                                            </div>
                                        </td>
                                        <td>{{ Str::ucfirst($article->category->name) }}</td>
                                        <td>
                                            <div class="d-flex flex-wrap justify-content-start align-items-center gap-2">
                                                @isset($article->tags)
                                                    @foreach ($article->tags as $tag)
                                                        <span class="badge bg-light fw-light text-dark">{{ $tag->name }}</span>
                                                    @endforeach
                                                @endisset
                                            </div>
                                        </td>
                                        <td>{{ Str::ucfirst($article->user->firstName) . ' ' . Str::ucfirst($article->user->lastName) }}
                                        </td>
                                        <td id="slider">
                                            <div class="status-toggle d-flex justify-content-center align-items-center">
                                                <input value="{{ $article->is_slider ? 0 : 1 }}"
                                                    onchange="updateSlider(this, '{{ $article->id }}')" type="checkbox"
                                                    id="is_slider_{{ $article->id }}" class="check"
                                                    @checked((int) $article->is_slider ? true : false)>
                                                <label for="is_slider_{{ $article->id }}" class="checktoggle">checkbox</label>
                                            </div>
                                        </td>

                                        <td id="banner_right_top">
                                            <div class="status-toggle d-flex justify-content-center align-items-center">
                                                <input value="{{ $article->is_banner_right_top ? 0 : 1 }}"
                                                    onchange="updateBannerTop(this, '{{ $article->id }}', 'is_slider', 'admin')"
                                                    type="checkbox" id="is_banner_right_top_{{ $article->id }}" class="check"
                                                    @checked($article->is_banner_right_top ? 1 : 0)>
                                                <label for="is_banner_right_top_{{ $article->id }}"
                                                    class="checktoggle">checkbox</label>
                                            </div>
                                        </td>

                                        <td id="banner_right_bottom">
                                            <div class="status-toggle d-flex justify-content-center align-items-center">
                                                <input value="{{ $article->is_banner_right_bottom ? 0 : 1 }}"
                                                    onchange="updateBannerBottom(this, '{{ $article->id }}', 'is_slider', 'admin')"
                                                    type="checkbox" id="is_banner_right_bottom_{{ $article->id }}"
                                                    class="check" @checked($article->is_banner_right_bottom ? 1 : 0)>
                                                <label for="is_banner_right_bottom_{{ $article->id }}"
                                                    class="checktoggle">checkbox</label>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="status-toggle d-flex justify-content-center align-items-center">
                                                <input value="{{ $article->is_trending ? 0 : 1 }}"
                                                    onchange="updateNewsType(this, '{{ $article->id }}', 'is_trending', 'admin')"
                                                    type="checkbox" id="is_trending_{{ $article->id }}" class="check"
                                                    @checked($article->is_trending ? 1 : 0)>
                                                <label for="is_trending_{{ $article->id }}"
                                                    class="checktoggle">checkbox</label>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="status-toggle d-flex justify-content-center align-items-center">
                                                <input value="{{ $article->is_featured ? 0 : 1 }}"
                                                    onchange="updateNewsType(this, '{{ $article->id }}', 'is_featured', 'admin')"
                                                    type="checkbox" id="is_featured_{{ $article->id }}" class="check"
                                                    @checked($article->is_featured ? 1 : 0)>
                                                <label for="is_featured_{{ $article->id }}"
                                                    class="checktoggle">checkbox</label>
                                            </div>
                                        </td>

                                        <td id="status">
                                            @if ($article->status == 'active')
                                                <span class="badge bg-success fw-bold">active</span>
                                            @else
                                                <span class="badge bg-danger fw-bold">in-active</span>
                                            @endif
                                        </td>
                                        <td id="published_date">
                                            {{ !is_null($article->published_at) ? date('jS M, Y', strtotime($article->published_at)) : 'Not Published' }}
                                        </td>
                                        <td>{{ date('jS M, Y', strtotime($article->created_at)) }}</td>
                                        <td class="text-center">
                                            <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('admin.article.edit', $article->id) }}"
                                                        class="dropdown-item"><img
                                                            src="{{ asset('admin/assets/img/icons/edit.svg') }}"
                                                            class="me-2" alt="img">Edit
                                                        Article</a>
                                                </li>

                                                @if (!is_null($article->published_at))
                                                    <li>
                                                        <a onclick="updatePublishment(this, '{{ $article->id }}', 'unpublish', 'admin')"
                                                            class="dropdown-item"><img
                                                                src="{{ asset('admin/assets/img/icons/eye1.svg') }}"
                                                                class="me-2" alt="img">Unpublish Article</a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a onclick="updatePublishment(this, '{{ $article->id }}', 'publish', 'admin')"
                                                            class="dropdown-item"><img
                                                                src="{{ asset('admin/assets/img/icons/eye1.svg') }}"
                                                                class="me-2" alt="img">Publish Article</a>
                                                    </li>
                                                @endif

                                                @if ($article->status == 'active')
                                                    <li>
                                                        <a value="in-active"
                                                            onclick="updateStatus(this, '{{ $article->id }}', 'in-active')"
                                                            class="dropdown-item"><img
                                                                src="{{ asset('admin/assets/img/icons/eye1.svg') }}"
                                                                class="me-2" alt="img">
                                                            Disable
                                                        </a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a value="active"
                                                            onclick="updateStatus(this, '{{ $article->id }}', 'active')"
                                                            class="dropdown-item"><img
                                                                src="{{ asset('admin/assets/img/icons/eye1.svg') }}"
                                                                class="me-2" alt="img">
                                                            Enable
                                                        </a>
                                                    </li>
                                                @endif
                                                <li>
                                                    <a onclick="deleteArtcile(this, '{{ $article->id }}', 'admin')"
                                                        class="dropdown-item"><img
                                                            src="{{ asset('admin/assets/img/icons/delete1.svg') }}"
                                                            class="me-2" alt="img">Delete
                                                        Article</a>
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
                                <th>Photo</th>
                                <th>Category</th>
                                <th>Tags</th>
                                <th>Created By</th>
                                <th>Slider</th>
                                <th>Banner Right Top</th>
                                <th>Banner Right Bottom</th>
                                <th>Trending News</th>
                                <th>Featured News</th>
                                <th>Status</th>
                                <th>Published Date</th>
                                <th>Date Added</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{ $articles->onEachSide(1)->links('vendor.pagination.admin-panel-pagination') }}

        @if (session('status'))
            <script>
                $(document).ready(function() {
                    toastr.success("{{ session('status') }}");
                });
            </script>
        @endif

        <script src="{{ asset('admin/assets/js/articles.js') }}"></script>
    @endsection
