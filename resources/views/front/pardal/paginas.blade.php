@extends('front.'.\Illuminate\Support\Facades\Session::get('loja').'.master')

@section('css')
@endsection

@section('content')

    <div class="breadcrumb-area section-ptb" style="background: #ccc; height: 50px; padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col">



                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $dado->NmTitulo }}</li>
                    </ul>
                    <!-- breadcrumb-list end -->
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->
    <!-- main-content-wrap start -->
    <div class="main-content-wrap about-us-page">
        <!-- about-area start -->
        <div class="about-area pb--70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 d-none">
                        <div class="about-image">
                            <a href="#"><img src="/assets/images/about1.jpg" alt="about1"></a>
                            <span class="text_left">{{ $dado->NmTitulo }}</span>
                        </div>

                    </div>
                    <div class="col-lg-12">
                        <div class="about-contents">
                            <div class="price-box">
                                <span class="new-price"> {{ $dado->NmTitulo }} </span>
                            </div>
                            <h3>{{ $dado->TxResumo }}</h3>

                            @php
                                echo $dado->TxMensagem;
                            @endphp

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- about-area End -->
        <!-- counter-area Start -->
        <div class="counter-area pb--60 d-none">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="counter">
                            <h3>Project Done</h3>
                            <div class="counter-content">
                                <span class="counter-value">728</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="counter">
                            <h3>Show Room</h3>
                            <div class="counter-content">
                                <span class="counter-value">80</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="counter">
                            <h3>Hours Worked</h3>
                            <div class="counter-content">
                                <span class="counter-value">900</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="counter">
                            <h3>Happy Customer</h3>
                            <div class="counter-content">
                                <span class="counter-value">2169</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- counter-area End -->

    </div>
    <!-- main-content-wrap end -->

@endsection

@section('js')

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlZPf84AAVt8_FFN7rwQY5nPgB02SlTKs"></script>
    <script src="assets/map/map.js"></script>

@endsection
