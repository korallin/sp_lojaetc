@extends('front.'.\Illuminate\Support\Facades\Session::get('loja').'.master')

@section('title', $departamento[0]->NmGrupo.' | Pardal - Equipamentos Agricolas')
@section('image', '/assets/pardal/img/pardal-logo.png')
@section('url', request()->getUri())
@section('description', 'A maior e mais loja de moda feminina da rua teresa!')
@section('keywords', 'moda,feminina,petropolis,rio de janeiro,rj,roupa')

@include('front.'.\Illuminate\Support\Facades\Session::get('loja').'.produto-bloco')

@section('content')

    <div class="breadcrumb-area section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="breadcrumb-title">{{ $departamento[0]->NmGrupo }}</h2>
                    <!-- breadcrumb-list start -->
                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $departamento[0]->NmGrupo }}</li>
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
                <div class="col-lg-3 order-lg-1 order-2">
                    <!-- shop-sidebar-wrap start -->
                    <div class="shop-sidebar-wrap">
                        <!-- shop-sidebar start -->
                        <div class="shop-sidebar mb--30">
                            <h4 class="title">CATEGORIAS</h4>
                            <ul>
                                @foreach($departamentos as $dep)
                                    <li><a href="{{route('front.departamento',[$dep->CdGrupo,Illuminate\Support\Str::slug($dep->NmGrupo)])}}">{{ $dep->NmGrupo }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- shop-sidebar end -->

                        <!-- shop-sidebar start -->
                        <div class="shop-sidebar mb--30 d-none">
                            <h4 class="title">FILTRE POR PREÇO</h4>
                            <!-- filter-price-content start -->
                            <div class="filter-price-content">
                                <form action="#" method="post">
                                    <div id="price-slider" class="price-slider"></div>
                                    <div class="filter-price-wapper">
                                        <div class="filter-price-cont">
                                            <span>Preço:</span>
                                            <div class="input-type">
                                                <input type="text" id="min-price" readonly=""/>
                                            </div>
                                            <span>—</span>
                                            <div class="input-type">
                                                <input type="text" id="max-price" readonly=""/>
                                            </div>
                                            <a class="add-to-cart-button" href="#">
                                                <span>FILTRAR</span>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- filter-price-content end -->
                        </div>
                        <!-- shop-sidebar end -->

                        <!-- shop-sidebar start -->
                        <div class="sidbar-product shop-sidebar mb--30">
                            <h4 class="title">PRODUTOS POPULARES</h4>
                            <!-- sidbar-product-inner start -->

                            @foreach($produtos_populares as $item)

                                <div class="sidbar-product-inner">

                                    <div class="product-image">
                                        <a href="{{ route('front.produto', [$item->CdProduto, \Illuminate\Support\Str::slug($item->NmProduto)]) }}">
                                            @if($item->NmFoto == '')
                                                <img src="/assets/images/no-foto.jpg" alt="{{$item->NmProduto}}" title="{{$item->NmProduto}}">
                                            @else
                                                <img src="{{\Illuminate\Support\Facades\Session::get('loja_imagens')}}{{ $item->NmFoto }}"  alt="{{$item->NmProduto}}" title="{{$item->NmProduto}}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="product-content text-left">
                                        <h3><a href="product-details.html" class="small">{{ $item->NmProduto }}</a></h3>
                                        <div class="price-box">
                                            <small>A partir de:</small><br>
                                            <span class="new-price text-success">R$ {{ number_format($item->VlPrecoMin, 2, ',', '.') }}</span>

                                        </div>
                                    </div>

                                </div>

                            @endforeach


                        </div>
                        <!-- shop-sidebar end -->

                        <!-- shop-sidebar start -->

                    </div>
                    <!-- shop-sidebar-wrap end -->
                </div>
                <div class="col-lg-9 order-lg-2 order-1">
                    <!-- shop-product-wrapper start -->
                    <div class="shop-product-wrapper">

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
                window.location.href="{{route('front.departamento',[$departamento[0]->CdGrupo,Illuminate\Support\Str::slug($departamento[0]->NmGrupo)])}}?ordem="+$(this).val();
            });

        </script>
@endsection
