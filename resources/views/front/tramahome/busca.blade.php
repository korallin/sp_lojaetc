@extends('front.'.\Illuminate\Support\Facades\Session::get('loja').'.master')

@section('title', 'Busca | Pardal - Equipamentos Agricolas')
@section('image', '/assets/pardal/img/pardal-logo.png')
@section('url', request()->getUri())
@section('description', 'A maior e mais loja de moda feminina da rua teresa!')
@section('keywords', 'moda,feminina,petropolis,rio de janeiro,rj,roupa')

@include('front.'.\Illuminate\Support\Facades\Session::get('loja').'.produto-bloco')

@section('content')

    <div class="breadcrumb-area section-ptb" style="background: #ccc; height: 50px; padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col">

                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Home</a></li>
                        <li class="breadcrumb-item">Busca</li>
                        <li class="breadcrumb-item active">{{ $request->busca }}</li>
                    </ul>
                    <!-- breadcrumb-list end -->
                </div>
            </div>
        </div>
    </div>


    <!-- breadcrumb-area end -->
    <!-- main-content-wrap start -->
    <div class="main-content-wrap shop-list-left section-ptb">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 order-lg-2 order-1">
                    <!-- shop-product-wrapper start -->
                    <div class="shop-product-wrapper">

                        @if($produtos)
                        <div class="row">
                            <div class="col">
                                <!-- shop-top-bar start -->
                                <div class="shop-top-bar">
                                    <!-- product-view-mode start -->
                                    <div class="product-view-mode">
                                        <!-- shop-item-filter-list start -->
                                        <ul role="tablist" class="nav shop-item-filter-list">
                                            <li role="presentation" class="active"><a class="active show" href="#grid" aria-controls="grid" role="tab" data-toggle="tab" aria-selected="true"><i class="ion-ios-keypad-outline"></i></a></li>
                                            <li role="presentation"><a href="#list" aria-controls="list" role="tab" data-toggle="tab"><i class="ion-ios-list-outline"></i> </a></li>
                                        </ul>
                                        <!-- shop-item-filter-list end -->
                                    </div>
                                    <!-- product-view-mode end -->
                                    <!-- product-short start -->
                                    <div class="product-short">
                                        <p>Ordem:</p>
                                        <select class="nice-select" name="sortby">
                                            <option @if($request->ordem == 'R') selected @endif value="R">Relevancia</option>
                                            <option @if($request->ordem == 'A') selected @endif value="A">Nome de (A - Z)</option>
                                            <option @if($request->ordem == 'Z') selected @endif value="Z">Nome de (Z - A)</option>
                                            <option @if($request->ordem == '0') selected @endif value="0">Valor (Menor p/ Maior)</option>
                                            <option @if($request->ordem == '9') selected @endif value="9">Valor (Maior p/ Menor)</option>
                                        </select>
                                    </div>
                                    <!-- product-short end -->
                                </div>
                                <!-- shop-top-bar end -->
                            </div>
                        </div>

                        @yield('produto-bloco')

                        <!-- paginatoin-area start -->
                        <div class="paginatoin-area d-none">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <p>Showing 10-13 of 13 item(s) </p>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <ul class="pagination-box">
                                        <li><a class="Previous" href="#">Previous</a>
                                        </li>
                                        <li class="active"><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li>
                                            <a class="Next" href="#"> Next </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- paginatoin-area end -->
                        @else
                            <h4 class="py-5 my-5">Não localizamos nenhum produtos para a busca: <b>{{ $request->busca }}</b></h4>
                        @endif
                    </div>
                    <!-- shop-product-wrapper end -->
                </div>
            </div>
        </div>
    </div>
    <!-- main-content-wrap end -->

@endsection

@section('js')
        <script>

            $('[name=sortby]').change(function(e){
                window.location.href="{{route('front.busca',['busca' => $request->busca])}}?ordem="+$(this).val();
            });

        </script>
@endsection
