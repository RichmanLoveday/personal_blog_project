@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="row">
            <a href="{{ route('admin.articles') }}" class="col-lg-3 col-sm-6 col-12">
                <div class=" d-flex">
                    <div class="dash-count">
                        <div class="dash-counts">
                            <h4>{{ $articles_count }}</h4>
                            <h5>Articles</h5>
                        </div>
                        <div class="dash-imgs">
                            <img src="{{ asset('admin/assets/img/icons/article-white.png') }}" alt="img">
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{ route('admin.all.category') }}" class="col-lg-3 col-sm-6 col-12">
                <div class=" d-flex">
                    <div class="dash-count das1">
                        <div class="dash-counts">
                            <h4>{{ $categories_count }}</h4>
                            <h5>Categories</h5>
                        </div>
                        <div class="dash-imgs">
                            <img src="{{ asset('admin/assets/img/icons/category-white.png') }}" alt="img">
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{ route('admin.tags') }}" class="col-lg-3 col-sm-6 col-12">
                <div class=" d-flex">
                    <div class="dash-count das2">
                        <div class="dash-counts">
                            <h4>{{ $tags_count }}</h4>
                            <h5>Tags</h5>
                        </div>
                        <div class="dash-imgs">
                            <img src="{{ asset('admin/assets/img/icons/tags-white.png') }}" alt="img">
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{ route('admin.all.author') }}" class="col-lg-3 col-sm-6 col-12">
                <div class="d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">
                            <h4>{{ $authors_count }}</h4>
                            <h5>Authors</h5>
                        </div>
                        <div class="dash-imgs">
                            <img src="{{ asset('admin/assets/img/icons/author-white.png') }}" alt="img">
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
