<footer>
    <!-- Footer Start-->
    <div class="footer-main footer-bg">
        <div class="footer-area footer-padding">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <div class="col-xl-3 col-lg-3 col-md-5 col-sm-8">
                        <div class="single-footer-caption mb-50">
                            <div class="single-footer-caption mb-30">
                                <!-- logo -->
                                <div class="footer-logo">
                                    <a href="index.html"><img src="{{ asset('assets/img/logo/logo2_footer.png') }}"
                                            alt=""></a>
                                </div>
                                <div class="footer-tittle">
                                    <div class="footer-pera">
                                        <p class="info1">Lorem ipsum dolor sit amet, nsectetur adipiscing elit,
                                            sed do eiusmod tempor incididunt ut labore.</p>
                                        <p class="info2">{{ isset($settings->address) ? $settings->address : '' }}</p>
                                        <p class="info2">Phone: {{ isset($settings->phone) ? $settings->phone : '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-5 col-sm-7">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4>Popular post</h4>
                            </div>
                            <!-- Popular post -->
                            @isset($popularArticles)
                                @foreach ($popularArticles as $article)
                                    <!-- Popular post -->
                                    <div class="whats-right-single mb-20">
                                        <div class="whats-right-img">
                                            <img style="width: 90px; height:80px" src="{{ asset($article->image) }}"
                                                alt="{{ $article->title }}">
                                        </div>
                                        <div class="whats-right-cap">
                                            <h4><a
                                                    href="{{ route('blog.show', $article->slug . '-' . $article->id) }}">{{ $article->title }}</a>
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
                    <div class="col-xl-3 col-lg-3 col-md-5 col-sm-7">
                        <div class="single-footer-caption mb-50">
                            <div class="banner">
                                @php
                                    $foundAdvert = false;
                                @endphp
                                @foreach ($adverts as $advert)
                                    @foreach ($advert->placements as $placement)
                                        @if ($placement->page === $currentPage && $placement->position === 'footer_banner' && $advert->status === 'active')
                                            <a href="{{ $advert->url }}" target="_blank">
                                                <img src="{{ asset($placement->image) }}" alt="{{ $advert->title }}">
                                            </a>
                                            @php
                                                $foundAdvert = true;
                                            @endphp
                                            @break(2)
                                        @endif
                                    @endforeach
                                @endforeach
                                @if (!$foundAdvert)
                                    <img src="{{ asset('assets/img/gallery/body_card4.png') }}" alt="">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer-bottom aera -->
        <div class="footer-bottom-area footer-bg">a
            <div class="container">
                <div class="footer-border">
                    <div class="row d-flex align-items-center">
                        <div class="col-xl-12 ">
                            <div class="footer-copy-right text-center">
                                <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                    Copyright &copy;
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script> All rights reserved | This template is made with <i
                                        class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com/"
                                        target="_blank">Richman Loveday</a>
                                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End-->
</footer>
