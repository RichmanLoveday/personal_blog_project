@extends('layouts.master')
@section('content')
    <div class="about-details section-padding30">
        <div class="container">
            <div class="row">
                <div class="offset-xl-1 col-lg-8">
                    <div class="about-details-cap mb-50">
                        <h4>Our Mission</h4>
                        <p>Consectetur adipiscing elit, sued do eiusmod tempor ididunt udfgt labore et dolore magna aliqua.
                            Quis ipsum suspendisces gravida. Risus commodo viverra sebfd dho eiusmod tempor maecenas
                            accumsan lacus. Risus commodo viverra sebfd dho eiusmod tempor maecenas accumsan lacus.
                        </p>
                        <p> Risus commodo viverra sebfd dho eiusmod tempor maecenas accumsan lacus. Risus commodo viverra
                            sebfd dho eiusmod tempor maecenas accumsan.</p>
                    </div>
                    <div class="about-details-cap mb-50">
                        <h4>Our Vision</h4>
                        <p>Consectetur adipiscing elit, sued do eiusmod tempor ididunt udfgt labore et dolore magna aliqua.
                            Quis ipsum suspendisces gravida. Risus commodo viverra sebfd dho eiusmod tempor maecenas
                            accumsan lacus. Risus commodo viverra sebfd dho eiusmod tempor maecenas accumsan lacus.
                        </p>
                        <p> Risus commodo viverra sebfd dho eiusmod tempor maecenas accumsan lacus. Risus commodo viverra
                            sebfd dho eiusmod tempor maecenas accumsan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--? About Area Start-->
    <div class="support-company-area pt-100 pb-100 section-bg fix"
        data-background="{{ asset('assets/img/gallery/section_bg02.jpg') }}">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6">
                    <div class="support-location-img">
                        <img src="{{ asset('assets/img/gallery/about.png') }}" alt="">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="right-caption">
                        <!-- Section Tittle -->
                        <div class="section-tittles section-tittles2 mb-50">
                            <span>Our Top Services</span>
                            <h2>Our Best Services</h2>
                        </div>
                        <div class="support-caption">
                            <p class="pera-top">Mollit anim laborum duis adseu dolor iuyn voluptcate velit ess cillum dolore
                                egru lofrre dsu quality mollit anim laborumuis au dolor in voluptate velit cillu.</p>
                            <p class="mb-65">Mollit anim laborum.Dvcuis aute serunt iruxvfg dhjkolohr indd re voluptate
                                velit esscillumlore eu quife nrulla parihatur. Excghcepteur sfwsignjnt occa cupidatat non
                                aute iruxvfg dhjinulpadeserunt moll.</p>
                            <a href="about.html" class="btn post-btn ">More About Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Area End-->
    @include('utils.banner1')
@endsection
