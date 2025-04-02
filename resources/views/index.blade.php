@extends('layouts.master')
@section('content')
    <!-- Trending Area Start -->
    <div class="trending-area fix pt-25 gray-bg">
        <div class="container">
            <div class="trending-main">
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Trending Top -->
                        <div class="slider-active">
                            @isset($sliders)
                                @foreach ($sliders as $slider)
                                    <!-- Single -->
                                    <div class="single-slider">
                                        <div class="trending-top mb-30">
                                            <div class="trend-top-img">
                                                <img src="{{ asset($slider->image) }}" alt="">
                                                <div class="trend-top-cap">
                                                    <span class="bgr" data-animation="fadeInUp" data-delay=".2s"
                                                        data-duration="1000ms"> {{ Str::upper($slider->category->name) }}
                                                    </span>
                                                    <h2><a href="{{ route('blog.show', $slider->slug . '-' . $slider->id) }}"
                                                            data-animation="fadeInUp" data-delay=".4s"
                                                            data-duration="1000ms">{{ Str::ucfirst($slider->title) }} </a></h2>
                                                    <p data-animation="fadeInUp" data-delay=".6s" data-duration="1000ms">
                                                        by
                                                        {{ Str::ucfirst($slider->user->firstName . ' ' . $slider->user->lastName) }}
                                                        - {{ date('M d, Y', strtotime($slider->published_at)) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endisset
                        </div>
                    </div>
                    <!-- Right content -->
                    <div class="col-lg-4">
                        <!-- Trending Top -->
                        <div class="row">
                            @isset($bannerRightTop)
                                <div class="col-lg-12 col-md-6 col-sm-6">
                                    <div class="trending-top mb-30">
                                        <div class="trend-top-img">
                                            <img src="{{ asset($bannerRightTop->image) }}" alt="">
                                            <div class="trend-top-cap trend-top-cap2">
                                                <span class="bgb">{{ Str::upper($bannerRightTop->category->name) }} </span>
                                                <h2><a
                                                        href="{{ route('blog.show', $bannerRightTop->slug . '-' . $bannerRightTop->id) }}">{{ $bannerRightTop->title }}
                                                    </a></h2>
                                                <p>by
                                                    {{ Str::ucfirst($bannerRightTop->user->firstName . ' ' . $bannerRightTop->user->lastName) }}
                                                    -
                                                    {{ date('M d, Y', strtotime($bannerRightTop->published_at)) }} </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endisset

                            @isset($bannerRightBottom)
                                <div class="col-lg-12 col-md-6 col-sm-6">
                                    <div class="trending-top mb-30">
                                        <div class="trend-top-img">
                                            <img src="{{ asset($bannerRightBottom->image) }}"
                                                alt="{{ $bannerRightBottom->title }}">
                                            <div class="trend-top-cap trend-top-cap2">
                                                <span class="bgg">{{ Str::upper($bannerRightBottom->category->name) }}
                                                </span>
                                                <h2><a
                                                        href="{{ route('blog.show', $bannerRightBottom->slug . '-' . $bannerRightBottom->id) }}">{{ $bannerRightBottom->title }}
                                                    </a></h2>
                                                <p>by
                                                    {{ $bannerRightBottom->user->firstName . ' ' . $bannerRightBottom->user->lastName }}
                                                    -
                                                    {{ date('M d, Y', strtotime($bannerRightBottom->published_at)) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Trending Area End -->
    <!-- Whats New Start -->
    <section class="whats-news-area pt-50 pb-20 gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="whats-news-wrapper">
                        <!-- Heading & Nav Button -->
                        <div class="row justify-content-between align-items-end mb-15">
                            <div class="col-xl-4">
                                <div class="section-tittle mb-30">
                                    <h3>Whats New</h3>
                                </div>
                            </div>
                            <div class="col-xl-8 col-md-9">
                                <div class="properties__button">
                                    <!--Nav Button  -->
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            @isset($categories)
                                                @foreach ($categories as $category)
                                                    @if ($loop->first)
                                                        <a onclick="getArticleByCategory('{{ $category->id }}')"
                                                            class="nav-item nav-link active" id="nav-home-tab"
                                                            data-category="{{ $category->id }}" data-toggle="tab"
                                                            href="#nav-home" role="tab" aria-controls="nav-home"
                                                            aria-selected="true">{{ $category->name }}
                                                        </a>
                                                        @continue
                                                    @endif

                                                    @if ($loop->index == 4)
                                                        <a href="#" class="nav-item nav-link" id="nav-home-tab"
                                                            data-toggle="tab" href="#nav-home" role="tab"
                                                            aria-controls="nav-home" aria-selected="true">
                                                            +More
                                                        </a>
                                                        @break
                                                    @endif
                                                    <a onclick="getArticleByCategory('{{ $category->id }}')"
                                                        class="nav-item nav-link" id="nav-home-tab"
                                                        data-category="{{ $category->id }}" data-toggle="tab" href="#nav-home"
                                                        role="tab" aria-controls="nav-home"
                                                        aria-selected="true">{{ $category->name }}
                                                    </a>
                                                @endforeach
                                            @endisset

                                            {{-- <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab"
                                                href="#nav-profile" role="tab" aria-controls="nav-profile"
                                                aria-selected="false">Travel</a>
                                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab"
                                                href="#nav-contact" role="tab" aria-controls="nav-contact"
                                                aria-selected="false">Fashion</a>
                                            <a class="nav-item nav-link" id="nav-last-tab" data-toggle="tab"
                                                href="#nav-last" role="tab" aria-controls="nav-contact"
                                                aria-selected="false">Sports</a>
                                            <a class="nav-item nav-link" id="nav-Sports" data-toggle="tab"
                                                href="#nav-nav-Sport" role="tab" aria-controls="nav-contact"
                                                aria-selected="false">Technology</a> --}}
                                        </div>
                                    </nav>
                                    <!--End Nav Button  -->
                                </div>
                            </div>
                        </div>
                        <!-- Tab content -->
                        <div class="row">
                            <div class="col-12">
                                <!-- Nav Card -->
                                <div class="tab-content" id="nav-tabContent">
                                    <!-- card one -->
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                        aria-labelledby="nav-home-tab">
                                        <div class="row" id="whatsNewContainer">
                                            @isset($activeArticle)
                                                @if (count($activeArticle) > 0)
                                                    @foreach ($activeArticle as $article)
                                                        @if ($loop->first)
                                                            <!-- Left Details Caption -->
                                                            <div class="col-xl-6 col-lg-12">
                                                                <div class="whats-news-single mb-40 mb-40">
                                                                    <div class="whates-img">
                                                                        <img src="{{ asset($article->image) }}" alt="">
                                                                    </div>
                                                                    <div class="whates-caption">
                                                                        <h4><a
                                                                                href="{{ route('blog.show', $article->slug . '-' . $article->id) }}">{{ Str::ucfirst($article->title) }}</a>
                                                                        </h4>
                                                                        <span>by
                                                                            {{ Str::ucfirst($article->user->firstName) . ' ' . Str::ucfirst($article->user->lasttName) }}
                                                                            -
                                                                            {{ date('M d, Y', strtotime($article->published_at)) }}</span>
                                                                        <p>{{ Str::words($article->text, 20, '...') }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @break
                                                        @endif
                                                    @endforeach

                                                    <!-- Right single caption -->
                                                    <div class="col-xl-6 col-lg-12">
                                                        <div class="row">
                                                            @foreach ($activeArticle as $article)
                                                                @if ($loop->first)
                                                                    @continue
                                                                @endif

                                                                @php
                                                                    $color = '';
                                                                    if ($loop->index == 1) {
                                                                        $color = 'colorb';
                                                                    }
                                                                    if ($loop->index == 2) {
                                                                        $color = 'colorb';
                                                                    }
                                                                    if ($loop->index == 3) {
                                                                        $color = 'colorg';
                                                                    }
                                                                    if ($loop->index == 4) {
                                                                        $color = 'colorr';
                                                                    }
                                                                @endphp
                                                                <!-- single -->
                                                                <div class="col-xl-12 col-lg-6 col-md-6 col-sm-10">
                                                                    <div class="whats-right-single mb-20">
                                                                        <div class="whats-right-img">
                                                                            <img style="width: 120px; height:100px;"
                                                                                src="{{ asset($article->image) }}"
                                                                                alt="">
                                                                        </div>
                                                                        <div class="whats-right-cap">
                                                                            <span
                                                                                class="{{ $color }}">{{ Str::upper($article->category->name) }}</span>
                                                                            <h4><a
                                                                                    href="{{ route('blog.show', $article->slug . '-' . $article->id) }}">{{ Str::words(Str::ucfirst($article->title), 10, '...') }}</a>
                                                                            </h4>
                                                                            <p> {{ date('M d, Y', strtotime($article->published_at)) }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="text-center w-100">
                                                        <p>No Recent Arcticle</p>
                                                    </div>
                                                @endif
                                            @endisset
                                        </div>
                                    </div>
                                </div>
                                <!-- End Nav Card -->
                            </div>
                        </div>
                    </div>
                    <!-- Banner -->
                    <div class="banner-one mt-20 mb-30">
                        <img src="{{ asset('assets/img/gallery/body_card1.png') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-4">

                    <!-- Most Recent Area -->
                    <div class="most-recent-area">
                        <!-- Section Tittle -->
                        <div class="small-tittle mb-20">
                            <h4>Most Recent</h4>
                        </div>
                        <!-- Details -->
                        @isset($recentNews)
                            @foreach ($recentNews as $article)
                                @if ($loop->first)
                                    <div class="most-recent mb-40">
                                        <div class="most-recent-img">
                                            <img src="{{ asset($article->image) }}" alt="">
                                            <div class="most-recent-cap">
                                                <span class="bgbeg">{{ Str::upper($article->category->name) }}</span>
                                                <h4><a href="{{ route('blog.show', $article->slug . '-' . $slider->id) }}">
                                                        {{ Str::ucfirst($article->title) }} </a></h4>
                                                <p>{{ Str::ucfirst($article->user->firstName) . ' ' . Str::ucfirst($article->user->lasttName) }}
                                                    | @if (\Carbon\Carbon::parse($article->published_at)->diffInHours(now()) < 24)
                                                        {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}
                                                    @else
                                                        {{ \Carbon\Carbon::parse($article->published_at)->format('M d, Y') }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @continue
                                @endif

                                <!-- Single -->
                                <div class="most-recent-single">
                                    <div class="most-recent-images">
                                        <img style="width: 90px; height:80px;" src="{{ asset($article->image) }}"
                                            alt="">
                                    </div>
                                    <div class="most-recent-capt">
                                        <h4><a
                                                href="{{ route('blog.show', $article->slug . '-' . $article->id) }}">{{ Str::ucfirst($article->title) }}</a>
                                        </h4>
                                        <p> {{ Str::ucfirst($article->user->firstName) . ' ' . Str::ucfirst($article->user->lasttName) }}
                                            | @if (\Carbon\Carbon::parse($article->published_at)->diffInHours(now()) < 24)
                                                {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}
                                            @else
                                                {{ \Carbon\Carbon::parse($article->published_at)->format('M d, Y') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Whats New End -->
    <!--   Weekly2-News start -->
    <div class="weekly2-news-area pt-50 pb-30 gray-bg">
        <div class="container">
            <div class="weekly2-wrapper">
                <div class="row">
                    <!-- Banner -->
                    <div class="col-lg-3">
                        <div class="home-banner2 d-none d-lg-block">
                            <img src="{{ asset('assets/img/gallery/body_card2.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="slider-wrapper">
                            <!-- section Tittle -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="small-tittle mb-30">
                                        <h4>Most Popular</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- Slider -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="weekly2-news-active d-flex">
                                        <!-- Single -->
                                        @isset($mostPopularArticles)
                                            @foreach ($mostPopularArticles as $article)
                                                <div class="weekly2-single">
                                                    <div class="weekly2-img">
                                                        <img src="{{ asset('assets/img/gallery/weeklyNews1.png') }}"
                                                            alt="">
                                                    </div>
                                                    <div class="weekly2-caption">
                                                        <h4><a href="#">{{ Str::ucfirst($article->title) }}</a></h4>
                                                        <p>{{ Str::ucfirst($article->user->firstName) . ' ' . Str::ucfirst($article->user->lasttName) }}
                                                            | @if (\Carbon\Carbon::parse($article->published_at)->diffInHours(now()) < 24)
                                                                {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}
                                                            @else
                                                                {{ \Carbon\Carbon::parse($article->published_at)->format('M d, Y') }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Weekly-News -->
    <!--  Recent Articles start -->
    <div class="recent-articles pt-80">
        <div class="container">
            <div class="recent-wrapper">
                <!-- section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle">
                            <h3>Trending News</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="weekly3-news-area pt-80 pb-80">
                            <div class="container">
                                <div class="weekly3-wrapper">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="slider-wrapper">
                                                <!-- Slider -->
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="weekly3-news-active dot-style d-flex">
                                                            @isset($trendingNews)
                                                                @foreach ($trendingNews as $article)
                                                                    <div class="weekly3-single">
                                                                        <div class="weekly3-img">
                                                                            <img src="{{ asset($article->image) }}"
                                                                                alt="">
                                                                        </div>
                                                                        <div class="weekly3-caption">
                                                                            <h4><a
                                                                                    href="{{ route('blog.show', $article->slug . '-' . $article->id) }}">
                                                                                    {{ Str::ucfirst($article->title) }}</a>
                                                                            </h4>
                                                                            <p> {{ date('M d, Y', strtotime($article->published_at)) }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endisset
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Recent Articles End -->

    <!--   Weekly3-News start -->
    <div class="weekly3-news-area pt-80 pb-130">
        <div class="container">
            <div class="weekly3-wrapper">
                <!-- section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle">
                            <h3>Featured News</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="slider-wrapper">
                            <!-- Slider -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="weekly3-news-active dot-style d-flex pt-80">
                                        @isset($featureNews)
                                            @foreach ($featureNews as $article)
                                                <div class="weekly3-single">
                                                    <div class="weekly3-img">
                                                        <img src="{{ asset($article->image) }}" alt="">
                                                    </div>
                                                    <div class="weekly3-caption">
                                                        <h4><a
                                                                href="{{ route('blog.show', $article->slug . '-' . $article->id) }}">
                                                                {{ Str::ucfirst($article->title) }}</a>
                                                        </h4>
                                                        <p> {{ date('M d, Y', strtotime($article->published_at)) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/home.js') }}"></script>
    <!-- End Weekly-News -->
    @include('utils.banner1')
@endsection
