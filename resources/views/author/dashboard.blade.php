@extends('author.layouts.master')
@section('content')
    <div class="content">
        <div class="row">
            <a href="{{ route('author.articles') }}">
                <div class="col-lg-3 col-sm-6 col-12 d-flex">
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
        </div>
    </div>
@endsection
