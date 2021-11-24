@extends('front.'.\Illuminate\Support\Facades\Session::get('loja').'.master')

@section('title', 'Pardal - Equipamentos Agricolas')
@section('image', 'https://casaverde.com.br/og-andcare-logo.png')
@section('url', request()->getUri())
@section('description', 'A maior e mais loja de moda feminina da rua teresa!')
@section('keywords', 'moda,feminina,petropolis,rio de janeiro,rj,roupa')

@include('front.'.\Illuminate\Support\Facades\Session::get('loja').'.produto-bloco')

@section('content')

    @if($banners)
        <!-- Hero Slider Start -->
        <div class="hero-slider hero-slider-one ">

        @foreach($banners as $banner)
            <!-- Single Slide Start -->
                <div class="single-slide" style="height: auto;">
                    <!-- Hero Content One Start -->
                    <div class="hero-content-one text-center w-100">
                        <img src="{{\Illuminate\Support\Facades\Session::get('loja_banners')}}{{ $banner->NmPublicidade }}" class="img-fluid" style="display: initial;">
                    </div>
                    <!-- Hero Content One End -->
                </div>
                <!-- Single Slide End -->
            @endforeach


        </div>
        <!-- Hero Section End -->
    @endif




    <div class="product-area mt--100 pb--70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- section-title start -->
                    <div class="section-title">
                        <h2>PRODUTOS DESTAQUE</h2>
                        <p>Produtos cuidadosamente separados para sua melhor experiência.</p>
                    </div>
                    <!-- section-title end -->
                </div>
            </div>
            <!-- product-warpper start -->
            <div class="product-warpper">
                <div class="row">

                    @yield('produto-bloco')


                </div>
            </div>
            <!-- product-warpper start -->
        </div>
    </div>
    <!-- product-area end -->


    <!-- service-box-area End -->
    <!-- testimonial-area start -->
    <div class="testimonial-area testimonial-bg overlay section-ptb">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-md-2 col-md-8 col-sm-12">
                    <div class="testimonial-slider">
                        <div class="testimonial-inner text-center">
                            <figure class="testimonial">
                                <blockquote>Temos um grande orgulho de trazer essa nova loja para nossos clientes, proporcionando total comodidade e segurança em suas compras, fique tranquilo, levamos tudo até você.
                                    <div class="arrow"></div>
                                </blockquote>
                                <img src="/assets/images/client4.jpg" alt="client4" />
                                <div class="author">
                                    <h5>Andrea</h5>
                                    <p class="th-margin-remove">CEO-Founder</p>
                                </div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- testimonial-area end -->

    <!-- service-box-area Start -->
    <div class="service-box-area pb--70 mt-5 d-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="service-box text-center mb--30">
                        <div class="service-icon">
                            <img src="/assets/images/icon/s-2.png" alt="">
                        </div>
                        <div class="service-box-content">
                            <h3>Payment & Delivery</h3>
                            <p>Lorem ipsum dolor sit amet consec adi elit sed do eiusmod tempor</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="service-box text-center mb--30">
                        <div class="service-icon">
                            <img src="/assets/images/icon/s-1.png" alt="">
                        </div>
                        <div class="service-box-content">
                            <h3>Money Guarantee.</h3>
                            <p>Lorem ipsum dolor sit amet consec adi elit sed do eiusmod tempor</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="service-box text-center mb--30">
                        <div class="service-icon">
                            <img src="/assets/images/icon/s-3.png" alt="">
                        </div>
                        <div class="service-box-content">
                            <h3>Online Support 24/7.</h3>
                            <p>Lorem ipsum dolor sit amet consec adi elit sed do eiusmod tempor</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- subscribe-area start -->
    <div class="secton-area mt--30 pb--50">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 offset-lg-1">
                    <div class="subscribe-area">
                        <div class="subsctibe-title text-center">
                            <h3>Inscreva-se</h3>
                            <p>Faça parte de nossa lista exclusiva e fique sabendo primeiro.</p>
                        </div>
                        <div class="subscribe-content text-center">
                            <input class="input-field" type="email" placeholder="your mail address">
                            <button class=" btn subscribe-btn">ENVIAR</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="instagram-wrapper">
                        <div class="instaram-title text-center">
                            <h3>Siganos no Instagram <a href="#">@pardaltec.2020</a></h3>
                        </div>
                        <div class="instagram-warp instagram-slider row">
                            <div class="col-lg-6">
                                <div class="single-instagram">
                                    <a href="#"><img src="/assets/images/instagram1.jpg" alt="instagram1"></a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="single-instagram">
                                    <a href="#"><img src="/assets/images/instagram2.jpg" alt="instagram2"></a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="single-instagram">
                                    <a href="#"><img src="/assets/images/instagram3.jpg" alt="instagram3"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- subscribe-area end -->


@endsection
