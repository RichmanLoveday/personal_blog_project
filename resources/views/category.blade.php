@extends('layouts.master')
@section('content')
    <!-- About US Start -->
    <div class="about-area2 gray-bg pt-60 pb-60">
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
                                                    @if ($loop->first && empty(request()->segment(2)))
                                                        <a onclick="getArticleByCategory('{{ $category->id }}')"
                                                            class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                                                            href="#nav-home" role="tab" aria-controls="nav-home"
                                                            aria-selected="true">{{ $category->name }}</a>
                                                        @continue
                                                    @endif
                                                    <a onclick="getArticleByCategory('{{ $category->id }}')"
                                                        class="nav-item nav-link {{ request()->segment(2) === $category->slug ? 'active' : '' }}"
                                                        id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                                                        aria-controls="nav-home" aria-selected="true">{{ $category->name }}</a>
                                                @endforeach
                                            @endisset
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
                                        <div class="row" id="category-articles">
                                            @isset($articles)
                                                @foreach ($articles as $article)
                                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                                        <div class="whats-news-single mb-40 mb-40">
                                                            <div class="whates-img">
                                                                <img src="{{ asset($article->image) }}" alt="">
                                                            </div>
                                                            <div class="whates-caption whates-caption2">
                                                                <h4><a
                                                                        href="{{ route('blog.show', $article->slug . '-' . $article->id) }}">{{ Str::ucfirst($article->title) }}</a>
                                                                </h4>
                                                                <span>by
                                                                    {{ Str::ucfirst($article->user->firstName) . ' ' . Str::ucfirst($article->user->lasttName) }}
                                                                    -
                                                                    {{ date('M d, Y', strtotime($article->published_at)) }}</span>
                                                                <p>{!! Str::words($article->text, 20, '...') !!}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endisset
                                        </div>
                                    </div>

                                </div>
                                <!-- End Nav Card -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- New Poster -->
                    <div class="news-poster d-none d-lg-block">
                        <img src="{{ asset('assets/img/news/news_card.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About US End -->
    <!--Start pagination -->
    <div class="pagination-area  gray-bg pb-45">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="single-wrap" id="pagination-container">
                        {{ $articles->onEachSide(1)->links('vendor.pagination.frontend-panel-pagination2') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End pagination  -->
    <script src="{{ asset('assets/js/category.js') }}"></script>
@endsection
