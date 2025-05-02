@extends('layouts.master')
@section('content')
    <!--================Blog Area =================-->
    <section class="blog_area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="blog_left_sidebar">
                        @isset($articles)
                            @foreach ($articles as $article)
                                <article class="blog_item">
                                    <div class="blog_item_img">
                                        <img class="card-img rounded-0" src="{{ asset($article->image) }}" alt="">
                                        <a href="#" class="blog_item_date">
                                            <h3>{{ $article->published_at ? \Illuminate\Support\Carbon::parse($article->published_at)->day : 'N/A' }}
                                            </h3>
                                            <p>{{ $article->published_at ? \Illuminate\Support\Carbon::parse($article->published_at)->format('M') : 'N/A' }}
                                            </p>
                                        </a>
                                    </div>

                                    <div class="blog_details">
                                        <a class="d-inline-block"
                                            href="{{ route('blog.show', $article->slug . '-' . $article->id) }}">
                                            <h2>{{ Str::ucfirst($article->title) }}</h2>
                                        </a>
                                        <p>{!! Str::words($article->text, 25, '...') !!}</p>
                                        <ul class="blog-info-link">
                                            <li><i class="fa fa-user"></i>
                                                @foreach ($article->tags as $tag)
                                                    <a href="{{ route('blog.tag.name', $tag->slug) }}">
                                                        {{ '#' . $tag->name }},</a>
                                                @endforeach
                                            </li>
                                            {{-- <li><a href="#"><i class="fa fa-comments"></i> 03 Comments</a></li> --}}
                                        </ul>
                                    </div>
                                </article>
                            @endforeach
                        @endisset

                        {{ $articles->onEachSide(1)->links('vendor.pagination.frontend-panel-pagination') }}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">
                        <aside class="single_sidebar_widget search_widget">
                            <form action="#">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder='Search Keyword'
                                            onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search Keyword'">
                                        <div class="input-group-append">
                                            <button class="btns" type="button"><i class="ti-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                                    type="submit">Search</button>
                            </form>
                        </aside>

                        <aside class="single_sidebar_widget post_category_widget">
                            <h4 class="widget_title">Category</h4>
                            <ul class="list cat-list">
                                @isset($categories)
                                    @foreach ($categories as $category)
                                        <li>
                                            <a href="{{ route('blog.category.name', $category->slug) }}" class="d-flex">
                                                <p>{{ Str::ucfirst($category->name) }}</p>
                                                <p> ({{ count($category->posts) }})</p>
                                            </a>
                                        </li>
                                    @endforeach
                                @endisset
                            </ul>
                        </aside>

                        <aside class="single_sidebar_widget popular_post_widget">
                            <h3 class="widget_title">Recent Post</h3>
                            @foreach ($recentPosts as $article)
                                <div class="media post_item">
                                    <img style="width: 80px; height:90px;" src="{{ asset($article->image) }}"
                                        alt="post">
                                    <div class="media-body">
                                        <a href="{{ route('blog.show', $article->slug . '-' . $article->id) }}">
                                            <h3>{{ $article->title }}</h3>
                                        </a>
                                        <p>
                                            @if (\Carbon\Carbon::parse($article->published_at)->diffInHours(now()) < 24)
                                                {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}
                                            @else
                                                {{ \Carbon\Carbon::parse($article->published_at)->format('M d, Y') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </aside>
                        <aside class="single_sidebar_widget tag_cloud_widget">
                            <h4 class="widget_title">Tag Clouds</h4>
                            <ul class="list">
                                @foreach ($tags as $tag)
                                    <li>
                                        <a href="{{ route('blog.tag.name', $tag->slug) }}">{{ $tag->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </aside>

                        @include('utils.newsletter')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================Blog Area =================-->
@endsection
