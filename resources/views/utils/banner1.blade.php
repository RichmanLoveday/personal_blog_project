<!-- banner-last Start -->
<div class="banner-area gray-bg pt-90 pb-90">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-10">
                <div class="banner-one">
                    @php
                        $foundAdvert = false;
                    @endphp
                    @foreach ($adverts as $advert)
                        @foreach ($advert->placements as $placement)
                            @if ($placement->page === $currentPage && $placement->position === 'featured_banner' && $advert->status === 'active')
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
                        <img src="{{ asset('assets/img/gallery/body_card3.png') }}" alt="">
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- banner-last End -->
