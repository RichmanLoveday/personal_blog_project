@extends('layouts.master')
@section('content')
    <!--================Blog Area =================-->
    <section class="blog_area single-post-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 posts-list">
                    <div class="single-post">
                        <div class="feature-img">
                            <img class="img-fluid" src="{{ asset($article->image) }}" alt="">
                        </div>
                        <div class="blog_details">
                            <h2>
                                {{ Str::upper($article->title) }}
                            </h2>
                            <ul class="blog-info-link mt-3 mb-4">
                                <li><i class="fa fa-user"></i>
                                    @isset($artilce->tags)
                                        @foreach ($artilce->tags as $tag)
                                            {{ $tag }}
                                            @if ($loop->index > 0)
                                                <a href="#"> {{ '#' . $tag->name }}</a>
                                                @continue
                                            @endif

                                            <a href="#"> ,{{ '#' . $tag->name }}</a>
                                        @endforeach
                                    @endisset
                                </li>
                                <li><a href="#"><i class="fa fa-comments"></i> 03 Comments</a></li>
                            </ul>

                            <div>
                                {!! $article->text !!}
                            </div>
                        </div>
                    </div>
                    <div class="navigation-top"></div>
                    <div class="blog-author">
                        <div class="media align-items-center">
                            <img src=" {{ !is_null($article->user->photo) ? asset($article->user->photo) : asset('admin/assets/img/icons/person_icon.png') }}"
                                alt="{{ $article->title }}">
                            <div class="media-body">
                                <a href="#">
                                    <h4>{{ Str::ucfirst($article->user->firstName) . ' ' . Str::ucfirst($article->user->lastName) }}
                                    </h4>
                                </a>
                                <p>
                                    {{ $article->user->aboutMe }}
                                </p>
                            </div>
                        </div>
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
                                            <a href="#" class="d-flex">
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
                            <div class="media post_item">
                                <img src="{{ asset('assets/img/post/post_1.png') }}" alt="post">
                                <div class="media-body">
                                    <a href="single-blog.html">
                                        <h3>From life was you fish...</h3>
                                    </a>
                                    <p>January 12, 2019</p>
                                </div>
                            </div>
                            <div class="media post_item">
                                <img src="{{ asset('assets/img/post/post_2.png') }}" alt="post">
                                <div class="media-body">
                                    <a href="single-blog.html">
                                        <h3>The Amazing Hubble</h3>
                                    </a>
                                    <p>02 Hours ago</p>
                                </div>
                            </div>
                            <div class="media post_item">
                                <img src="{{ asset('assets/img/post/post_3.png') }}" alt="post">
                                <div class="media-body">
                                    <a href="single-blog.html">
                                        <h3>Astronomy Or Astrology</h3>
                                    </a>
                                    <p>03 Hours ago</p>
                                </div>
                            </div>
                            <div class="media post_item">
                                <img src="{{ asset('assets/img/post/post_4.png') }}" alt="post">
                                <div class="media-body">
                                    <a href="single-blog.html">
                                        <h3>Asteroids telescope</h3>
                                    </a>
                                    <p>01 Hours ago</p>
                                </div>
                            </div>
                        </aside>
                        <aside class="single_sidebar_widget tag_cloud_widget">
                            <h4 class="widget_title">Tag Clouds</h4>
                            <ul class="list">
                                <li>
                                    <a href="#">project</a>
                                </li>
                                <li>
                                    <a href="#">love</a>
                                </li>
                                <li>
                                    <a href="#">technology</a>
                                </li>
                                <li>
                                    <a href="#">travel</a>
                                </li>
                                <li>
                                    <a href="#">restaurant</a>
                                </li>
                                <li>
                                    <a href="#">life style</a>
                                </li>
                                <li>
                                    <a href="#">design</a>
                                </li>
                                <li>
                                    <a href="#">illustration</a>
                                </li>
                            </ul>
                        </aside>

                        @include('utils.newsletter')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ Blog Area end =================-->
@endsection
