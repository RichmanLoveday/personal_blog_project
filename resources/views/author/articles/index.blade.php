@extends('author.layouts.master')
@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Articles List</h4>
                <h6>Manage your Articles</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('author.article.create') }}" class="btn btn-added"><img
                        src="{{ asset('admin/assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add New Article</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="car" id="">
                    <div class="card-body pb-0">
                        <form action="{{ route('author.article.filter') }}" method="get">
                            <div class="row">
                                <div class="col-sm-6 col-md-4 col-12">
                                    <div class="form-group">
                                        <input id="startDate" oninput="determinEndDate(this)" type="text"
                                            value="{{ old('startDate', request('startDate')) }}" name="startDate"
                                            class="datetimepicker cal-icon" placeholder="Choose Start Date">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-4 col-12">
                                    <div class="form-group">
                                        <input id="endDate" type="text" @disabled(!request('endDate'))
                                            value="{{ old('endDate', request('endDate')) }}" name="endDate"
                                            class="datetimepicker cal-icon" placeholder="Choose End Date">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-12">
                                    <div class="form-group">
                                        <select class="select" name="news_type">
                                            <option value="">Choose News Type</option>
                                            <option @selected(old('news_type', request('news_type')) == 'is_trending' ? true : false) value="is_trending">Trending News</option>
                                            <option @selected(old('news_type', request('news_type')) == 'is_featured' ? true : false) value="is_featured">Featured News</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-12">
                                    <div class="form-group">
                                        <select class="select" name="category">
                                            <option value="">Choose Category</option>
                                            @isset($categories)
                                                @foreach ($categories as $category)
                                                    <option @selected(old('category', request('category')) == $category->id) value="{{ $category->id }}">
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-12">
                                    <div class="form-group">
                                        <select class="select" name="publish">
                                            <option value="">Choose Publish Type</option>
                                            <option @selected(old('publish', request('publish')) == 'draft' ? true : false) value="draft">Unpublish</option>
                                            <option @selected(old('publish', request('publish')) == 'pubished' ? true : false) value="pubished">Published</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
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
                                <th>Title</th>
                                <th>Photo</th>
                                <th>Category</th>
                                <th>Tags</th>
                                <th>Trending News</th>
                                <th>Featured News</th>
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
                                        <td>
                                            <div class="status-toggle d-flex justify-content-center align-items-center">
                                                <input value="{{ $article->is_trending ? 0 : 1 }}"
                                                    onchange="updateNewsType(this, '{{ $article->id }}', 'is_trending', 'author')"
                                                    type="checkbox" id="trending_news_{{ $article->id }}" class="check"
                                                    @checked($article->is_trending ? 1 : 0)>
                                                <label for="trending_news_{{ $article->id }}"
                                                    class="checktoggle">checkbox</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="status-toggle d-flex justify-content-center align-items-center">
                                                <input
                                                    onchange="updateNewsType(this, '{{ $article->id }}', 'is_featured', 'author')"
                                                    value="{{ $article->is_featured ? 0 : 1 }}" @checked($article->is_featured ? true : false)
                                                    type="checkbox" id="featured_news_{{ $article->id }}" class="check">
                                                <label for="featured_news_{{ $article->id }}"
                                                    class="checktoggle">checkbox</label>
                                            </div>
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
                                                    <a href="{{ route('author.article.edit', $article->id) }}"
                                                        class="dropdown-item"><img
                                                            src="{{ asset('admin/assets/img/icons/edit.svg') }}" class="me-2"
                                                            alt="img">Edit
                                                        Article</a>
                                                </li>

                                                @if (!is_null($article->published_at))
                                                    <li>
                                                        <a onclick="updatePublishment(this, '{{ $article->id }}', 'unpublish', 'author')"
                                                            class="dropdown-item"><img
                                                                src="{{ asset('admin/assets/img/icons/eye1.svg') }}"
                                                                class="me-2" alt="img">Unpublish Article</a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a onclick="updatePublishment(this, '{{ $article->id }}', 'publish', 'author')"
                                                            class="dropdown-item"><img
                                                                src="{{ asset('admin/assets/img/icons/eye1.svg') }}"
                                                                class="me-2" alt="img">Publish Article</a>
                                                    </li>
                                                @endif
                                                <li>
                                                    <a onclick="deleteArtcile(this, '{{ $article->id }}', 'author')"
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
                                <th>Trending News</th>
                                <th>Featured News</th>
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
