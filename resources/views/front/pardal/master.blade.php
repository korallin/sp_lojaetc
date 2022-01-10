<!doctype html>
<html class="no-js" lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Language" content="pt-br">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Pardal - Equipamentos Agricolas</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/assets/images/favicon.ico">
    <!-- CSS ========================= -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="/assets/css/simple-line-icons.css">
    <link rel="stylesheet" href="/assets/css/ionicons.min.css">
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="/assets/css/plugins.css">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.css">

    @hasSection('css')
        @yield('css')
    @endif

    <link rel="stylesheet" href="/assets/{{\Illuminate\Support\Facades\Session::get('loja')}}/style.css">
    <link rel="stylesheet" href="/assets/{{\Illuminate\Support\Facades\Session::get('loja')}}/custom.css">

    <style>
        .floatzap{
            position:fixed;
            width:60px;
            height:60px;
            bottom:120px;
            right:40px;
            background-color:#25d366;
            color:#FFF;
            border-radius:50px;
            text-align:center;
            font-size:30px;
            box-shadow: 2px 2px 3px #999;
            z-index:100;
        }

        .my-floatzap{
            margin-top:16px;
        }

        .header-top a:hover{
            color:#c9c9c9 !important;
        }

    </style>



    <!-- Modernizer JS -->
    <script src="/assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<!-- preloader  -->
<div id="preloader">
    <div id="ctn-preloader" class="ctn-preloader">
        <div class="animation-preloader">
            <div class="spinner"></div>
        </div>
        <div class="loader">
            <div class="row">
                <div class="col-3 loader-section section-left">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-left">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-right">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-right">
                    <div class="bg"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- preloader end -->
<body>

<a href="https://api.whatsapp.com/send?phone=+5524988018819&text=Olá gostaria de um contato." class="floatzap" target="_blank">
    <i class="fab fa-whatsapp my-floatzap"></i>
</a>

<!-- Main Wrapper Start -->
<div class="main-wrapper home-2">
    <!-- newsletter-popup-area Start -->
    <div class="newsletter-popup-area d-none" id="newsletter-popup-area">
        <div class="newsletter-popup-content-wrapper">
            <div class="newsletter-popup-content text-left">
                <a href="javascript:void(0)" class="close-newsletter-popup" id="close-newsletter-popup">Fechar</a>
                <h2>NEWSLETTER</h2>
                <p>Adicione seu e-mail para receber em primeira mão as novas peças e coleções.</p>
                <div class="subscription-form">
                    <form  id="mc-form2" class="mc-form">
                        <input type="email" placeholder="Informe seu melhor e-mail">
                        <a href="#" class="btn3">Inscrever</a>
                    </form>
                    <!-- mailchimp-alerts Start -->

                    <div class="mailchimp-alerts mt-5 mb-5">
                        <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                        <div class="mailchimp-success"></div><!-- mailchimp-success end -->
                        <div class="mailchimp-error"></div><!-- mailchimp-error end -->
                    </div>

                    <!-- mailchimp-alerts end -->
                </div>
                <div class="subscribe-bottom">
                    <input type="checkbox" id="newsletter_popup_dont_show_again">
                    <label for="newsletter_popup_dont_show_again">Não mostrar novamente</label>
                </div>
            </div>
        </div>
    </div>
    <!-- newsletter-popup-area End -->
    <!-- header-area start -->
    <div class="header-area">
        <!-- header-top start -->
        <div class="header-top">
            <div class="container">
                <div class="row">

                    <div class="col-md-4 col-sm-6">
                        <p>
                            <a href="https://api.whatsapp.com/send?phone=+5524988018819&text=Olá gostaria de um contato." class="mr-3"> <i class="fab fa-whatsapp"></i> (24) 98801-8819</a>
                            <a href="tel:2422483799"> <i class="fas fa-phone"></i> (24) 2248-3799</a>
                        </p>
                    </div>
                    <div class="col-md-8 col-sm-6">
                        <!-- language-currency-wrapper start -->
                        <div class="language-currency-wrapper">
                            <ul>

                                <li class="drodown-show"><a href="{{ route('front.home') }}">Home</a></li>
                                <li class="drodown-show"><a href="{{ route('front.paginas', [1,'quem-somos']) }}">Quem Somos</a></li>
                                <li class="drodown-show"><a href="{{ route('front.faleconosco') }}">Fale Conosco</a></li>

                                <li class="drodown-show"><a href="https://twitter.com/Pardaltec" target="_blank"><i class="ion-social-twitter"></i></a></li>
                                <li class="drodown-show"><a href="https://www.youtube.com/channel/UCEOsKJlaL6Ir1i9oeE0WNDw" target="_blank"><i class="ion-social-youtube"></i></a></li>
                                <li class="drodown-show"><a href="https://www.facebook.com/pardaldesidratadores/" target="_blank"><i class="ion-social-facebook"></i></a></li>
                                <li class="drodown-show"><a href="https://www.instagram.com/pardaltec.2020" target="_blank"><i class="ion-social-instagram-outline"></i></a></li>

                                @if(\Illuminate\Support\Facades\Session::get('login_status') > 0)
                                <li class="drodown-show"><a href="#">Olá {{ \Illuminate\Support\Facades\Session::get('cliente')[0]->NmContato }} <i class="ion-ios-arrow-down"></i></a>
                                    <ul class="open-dropdown" style="min-width: 200px;">

                                            <li><a href="{{ route('front.cliente_area') }}"> Minha Conta </a></li>
                                            <li><a href="{{ route('front.cliente_area') }}"> Meus Pedidos </a></li>
                                            <li><a href="{{ route('front.logout') }}" >Sair</a></li>

                                    </ul>
                                </li>
                                @else
                                    <li class="drodown-show"><a href="#">Acessar Conta <i class="ion-ios-arrow-down"></i></a>
                                        <ul class="open-dropdown" style="min-width: 200px;">
                                            <li><a href="{{ route('front.login') }}"> Novo Registro </a></li>
                                            <li><a href="{{ route('front.login') }}"> Entrar</a></li>
                                        </ul>
                                    </li>
                                @endif

                            </ul>
                        </div>
                        <!-- language-currency-wrapper end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- header-top end -->
        <div class="header-bottom-area header-sticky">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-5 col-5">
                        <div class="logo">
                            <a href="{{ route('front.home') }}"><img src="/assets/{{\Illuminate\Support\Facades\Session::get('loja')}}/img/pardal-logo.png" alt="logo"></a>
                        </div>
                    </div>
                    <div class="col-lg-5 d-none d-lg-block">
                        <div class="main-menu-area text-center">
                            <nav class="main-navigation">
                                <ul>

                                    @foreach($departamentos as $dep)

                                        @php

                                            $departamentos1 = DB::connection('mysql_loja')->select('
                                                select 	GR.CdDepartamento as CdSubGrupo, GR.CdDepartamentoPai as CdGrupo, GR.NmDepartamento as NmSubGrupo
                                                from produto PR
                                                join produto_estoque PE on (PE.CdProduto = PR.CdProduto and PE.CdEstabel = ?  )
                                                join produto_x_departamento GX on (GX.CdProduto = PR.CdProduto)
                                                join produto_departamento GR on (GR.CdDepartamento = GX.CdDepartamento)
                                                where PR.DtDesativacao is null
                                                and GR.StDepartamento = 1

                                                and GR.CdDepartamentoPai = ?

                                                group by GX.CdDepartamento
                                                order by GR.NmDepartamento;
                                            ', [Session::get('loja_estabelecimento'), $dep->CdGrupo]);

                                        @endphp

                                        @if($departamentos1)

                                            <li><a href="{{route('front.departamento',[$dep->CdGrupo,Illuminate\Support\Str::slug($dep->NmGrupo)])}}?ordem=0">{{ $dep->NmGrupo }}</a>
                                                <ul class="mega-menu">

                                                    @foreach($departamentos1 as $dep1)
                                                        <li class="p-2"><a href="{{route('front.departamento',[$dep1->CdSubGrupo,Illuminate\Support\Str::slug($dep1->NmSubGrupo)])}}?ordem=0">{{ $dep1->NmSubGrupo }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>

                                        @else
                                            <li><a href="{{route('front.departamento',[$dep->CdGrupo,Illuminate\Support\Str::slug($dep->NmGrupo)])}}">{{ $dep->NmGrupo }}</a></li>
                                        @endif
                                    @endforeach

                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-7 col-7">
                        <div class="right-blok-box d-flex align-items-center">
                            <div class="search-wrap d-none d-md-block d-lg-block d-xl-block">
                                <form action="{{ route('front.busca') }}" method="get">
                                    @csrf
                                    @method('get')
                                    <div class="input-group">
                                        <input id="search" name="busca" class="form-control" value="" placeholder="Busque na loja ..." type="search">
                                        <div class="input-group-append">
                                            <button class="btn btn-link" type="button"><i class="icon-magnifier"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="user-wrap">
                                @if(\Illuminate\Support\Facades\Session::get('login_status') == 0)
                                    <a href="{{ route('front.login') }}"><i class="icon-user"></i></a>
                                @else
                                    <a href="{{ route('front.cliente_area') }}"><i class="icon-user"></i></a>
                                @endif

                            </div>

                            <div class="shopping-cart-wrap">
                                <a href="#"><i class="icon-handbag"></i> <span id="cart-total">{{ $dado_carrinho['cart_itens'] }}</span></a>
                                <ul class="mini-cart">

                                    @foreach($dado_carrinho['cart_produtos'] as $item)
                                        <li class="cart-item">
                                            <div class="cart-image">
                                                <a href="{{ route('front.produto', [$item->CdProduto, \Illuminate\Support\Str::slug($item->NmProduto)]) }}">
                                                    @if($item->NmFoto == '')
                                                        <img style="max-height: 100px; max-width: 80px;" src="/assets/images/no-foto.jpg" alt="{{$item->NmProduto}}" title="{{$item->NmProduto}}">
                                                    @else
                                                        <img style="max-height: 100px; max-width: 80px;" src="{{\Illuminate\Support\Facades\Session::get('loja_imagens')}}{{ $item->NmFoto }}"  alt="{{$item->NmProduto}}" title="{{$item->NmProduto}}">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="cart-title">
                                                <a href="single-product.html"><h4>{{ $item->NmProduto }}</h4></a>
                                                <span class="quantity">{{$item->QtProduto}} ×</span>
                                                <div class="price-box"><span class="new-price">R$ {{ number_format($item->VlPrecoTotal, 2, ',', '.') }}</span></div>
                                            </div>
                                        </li>
                                    @endforeach

                                    <li class="subtotal-titles">
                                        <div class="subtotal-titles"><h3>Sub-Total :</h3><span>R$ {{ number_format($dado_carrinho['cart_total'], 2, ',', '.') }}</span></div>
                                    </li>

                                    <li class="mini-cart-btns">
                                        <div class="cart-btns">
                                            <a href="{{ route('front.carrinho') }}">Ver Carrinho</a>
                                            <a href="{{ route('front.checkout') }}">Fechar</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="d-md-none d-lg-none d-xl-none">
                        <div class="right-blok-box d-flex align-items-center">
                            <div class="">
                                <form action="{{ route('front.busca') }}" method="get">
                                    @csrf
                                    @method('get')
                                    <div class="input-group">
                                        <input id="search" name="busca" class="form-control" value="" placeholder="Busque na loja ..." type="search">
                                        <div class="input-group-append">
                                            <button class="btn btn-link" type="button"><i class="icon-magnifier"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="">
                                <div class="mobile-menu d-block d-lg-none"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header-area end -->
    <!-- main-search start -->
    <div class="main-search-active">
        <div class="sidebar-search-icon">
            <button class="search-close"><span class="icon-close"></span></button>
        </div>
        <div class="sidebar-search-input">
            <form action="{{ route('front.busca') }}" method="get">
                @csrf
                @method('get')
                <div class="form-search">
                    <input id="search" name="busca" class="input-text" value="" placeholder="Busque na loja ..." type="search">
                    <button class="search-btn" type="submit">
                        <i class="icon-magnifier"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- main-search end -->

    <!-- main-search start -->
    <div class="main-search-active">
        <div class="sidebar-search-icon">
            <button class="search-close"><span class="icon-close"></span></button>
        </div>
        <div class="sidebar-search-input">
            <form action="{{ route('front.busca') }}" method="get">
                @csrf
                @method('get')
                <div class="form-search">
                    <input id="search" class="input-text" value="" placeholder="Busque na loja ..." type="search">
                    <button class="search-btn" type="submit">
                        <i class="icon-magnifier"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- main-search end -->

    @yield('content')

    <!-- footer-area start -->
    <footer class="footer-area" style="background: #564a3e;">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="footer-info mt-3">
                            <ul class="footer-info-list">
                                <li>
                                    <i class="ion-ios-location-outline"></i> Endereco : Travessa Goitacazes, 107
                                </li>
                                <li>
                                    <i class="ion-ios-email-outline"></i> E-mail : <a href="mailto:contato@pardal.com.br">contato@pardal.com.br</a>
                                </li>
                                <li>
                                    <i class="ion-ios-telephone-outline"></i> Telefone: + 55 24 2248-3799
                                </li>
                                <li>
                                    <i class="ion-ios-id-card-outline"></i> CNPJ: 01.174.561/0001-70
                                </li>
                            </ul>
                            <div class="payment-cart">
                                <img src="/assets/images/card.png" alt="card">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 d-none">
                        <div class="footer-info mt-3">
                            <div class="footer-title">
                                <h3>Categories</h3>
                            </div>
                            <ul class="footer-list">
                                <li><a href="#">Accessories</a></li>
                                <li><a href="#">Clothing</a></li>
                                <li><a href="#">Prestashop</a></li>
                                <li><a href="#">Opencart</a></li>
                                <li><a href="#">Magento</a></li>
                                <li><a href="#">Jigoshop</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 offset-md-1">
                        <div class="footer-info mt-3">
                            <div class="footer-title">
                                <h3>Informativos</h3>
                            </div>

                            <ul class="footer-list">

                                @foreach($paginas_bl1 as $item)
                                <li><a href="{{ route('front.paginas', [$item->CdMensagem, \Illuminate\Support\Str::slug($item->NmTitulo)] ) }}">{{$item->NmTitulo}}</a></li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer-info mt-3">
                            <div class="footer-title">
                                <h3>&nbsp;</h3>
                            </div>
                            <ul class="footer-list">
                                @foreach($paginas_bl2 as $item)
                                    <li><a href="{{ route('front.paginas', [$item->CdMensagem, \Illuminate\Support\Str::slug($item->NmTitulo)] ) }}">{{$item->NmTitulo}}</a></li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6  col-md-6"><div class="copyright">
                            <p>© 2021 Serraplan Informática.</p>
                        </div></div>
                    <div class="col-lg-6 col-md-6">
                        <div class="footer-social">
                            <ul>
                                <li><a href="https://twitter.com/Pardaltec" target="_blank"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="https://www.youtube.com/channel/UCEOsKJlaL6Ir1i9oeE0WNDw" target="_blank"><i class="ion-social-youtube"></i></a></li>
                                <li><a href="https://www.facebook.com/pardaldesidratadores/" target="_blank"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="https://www.facebook.com/pardaltec.2020/" target="_blank"><i class="ion-social-instagram-outline"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer-area end -->
    <!-- Modal-wrapper start -->
    <div class="modal-wrapper">
        <div class="modal fade " id="exampleModalCenter" >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <!-- modal-inner-area start -->
                        <div class="modal-inner-area row">
                            <div class="col-xl-6 col-lg-7 col-md-6">
                                <div class="product-details-images">
                                    <div class="product_details_container">
                                        <!-- product_big_images start -->
                                        <div class="product_big_images-top">
                                            <div class="portfolio-full-image tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="img-tab-5">
                                                    <img src="/assets/images/product1.jpg" alt="product1">
                                                </div>
                                                <div role="tabpanel" class="tab-pane product-video-position" id="img-tab-6">
                                                    <img src="/assets/images/product2.jpg" alt="product2">
                                                </div>
                                                <div role="tabpanel" class="tab-pane product-video-position" id="img-tab-7">
                                                    <img src="/assets/images/product3.jpg" alt="product3">
                                                </div>
                                                <div role="tabpanel" class="tab-pane product-video-position" id="img-tab-8">
                                                    <img src="/assets/images/product4.jpg" alt="product4">
                                                </div>
                                                <div role="tabpanel" class="tab-pane product-video-position" id="img-tab-9">
                                                    <img src="/assets/images/product5.jpg" alt="product5">
                                                </div>
                                                <div role="tabpanel" class="tab-pane product-video-position" id="img-tab-10">
                                                    <img src="/assets/images/product6.jpg" alt="product6">
                                                </div>
                                                <div role="tabpanel" class="tab-pane product-video-position" id="img-tab-11">
                                                    <img src="/assets/images/product7.jpg" alt="product7">
                                                </div>
                                                <div role="tabpanel" class="tab-pane product-video-position" id="img-tab-12">
                                                    <img src="/assets/images/product8.jpg" alt="product8">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- product_big_images end -->

                                        <!-- Start Small images -->
                                        <ul class="product_small_images-bottom horizantal-product-active nav" role="tablist">
                                            <li role="presentation" class="pot-small-img active">
                                                <a href="#img-tab-5" role="tab" data-toggle="tab">
                                                    <img src="/assets/images/product/small/product1.jpg" alt="product1">
                                                </a>
                                            </li>
                                            <li role="presentation" class="pot-small-img">
                                                <a href="#img-tab-6" role="tab" data-toggle="tab">
                                                    <img src="/assets/images/product/small/product2.jpg" alt="product2">
                                                </a>
                                            </li>
                                            <li role="presentation" class="pot-small-img">
                                                <a href="#img-tab-7" role="tab" data-toggle="tab">
                                                    <img src="/assets/images/product/small/product3.jpg" alt="product3">
                                                </a>
                                            </li>
                                            <li role="presentation" class="pot-small-img">
                                                <a href="#img-tab-8" role="tab" data-toggle="tab">
                                                    <img src="/assets/images/product/small/product4.jpg" alt="product4">
                                                </a>
                                            </li>
                                            <li role="presentation" class="pot-small-img">
                                                <a href="#img-tab-9" role="tab" data-toggle="tab">
                                                    <img src="/assets/images/product/small/product5.jpg" alt="product5">
                                                </a>
                                            </li>
                                            <li role="presentation" class="pot-small-img">
                                                <a href="#img-tab-10" role="tab" data-toggle="tab">
                                                    <img src="/assets/images/product/small/product6.jpg" alt="product6">
                                                </a>
                                            </li>
                                            <li role="presentation" class="pot-small-img">
                                                <a href="#img-tab-11" role="tab" data-toggle="tab">
                                                    <img src="/assets/images/product/small/product7.jpg" alt="product7">
                                                </a>
                                            </li>
                                            <li role="presentation" class="pot-small-img">
                                                <a href="#img-tab-12" role="tab" data-toggle="tab">
                                                    <img src="/assets/images/product/small/product8.jpg" alt="product8">
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- End Small images -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-5 col-md-6">
                                <!-- product_details_info start -->
                                <div class="product_details_info">
                                    <h2>Neck empire sleeve t-shirts</h2>
                                    <!-- pro_rating start -->
                                    <div class="pro_rating d-flex">
                                        <ul class="product-rating d-flex">
                                            <li><span class="icon-star"></span></li>
                                            <li><span class="icon-star"></span></li>
                                            <li><span class="icon-star"></span></li>
                                            <li><span class="icon-star"></span></li>
                                            <li><span class="icon-star"></span></li>
                                        </ul>
                                        <span class="rat_qun"> (Based on 0 Ratings) </span>
                                    </div>
                                    <!-- pro_rating end -->
                                    <!-- pro_details start -->
                                    <div class="pro_details">
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod temf incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, nostr exercitation ullamco laboris nisi ut aliquip ex ea. </p>
                                    </div>
                                    <!-- pro_details end -->
                                    <!-- pro_dtl_prize start -->
                                    <ul class="pro_dtl_prize">
                                        <li class="old_prize">$191.00</li>
                                        <li> $120.00</li>
                                    </ul>
                                    <!-- pro_dtl_prize end -->
                                    <!-- pro_dtl_color start-->
                                    <div class="pro_dtl_color">
                                        <h2 class="title_2">Choose Colour</h2>
                                        <ul class="pro_choose_color">
                                            <li class="red"><a href="#"><i class="ion-record"></i></a></li>
                                            <li class="blue"><a href="#"><i class="ion-record"></i></a></li>
                                            <li class="perpal"><a href="#"><i class="ion-record"></i></a></li>
                                            <li class="yellow"><a href="#"><i class="ion-record"></i></a></li>
                                        </ul>
                                    </div>
                                    <!-- pro_dtl_color end-->
                                    <!-- pro_dtl_size start -->
                                    <div class="pro_dtl_size">
                                        <h2 class="title_2">Size</h2>
                                        <ul class="pro_choose_size">
                                            <li><a href="#">S</a></li>
                                            <li><a href="#">M</a></li>
                                            <li><a href="#">XL</a></li>
                                            <li><a href="#">XXL</a></li>
                                        </ul>
                                    </div>
                                    <!-- pro_dtl_size end -->
                                    <!-- product-quantity-action start -->
                                    <div class="product-quantity-action">
                                        <div class="prodict-statas"><span>Quantity :</span></div>
                                        <div class="product-quantity">
                                            <form action="#">
                                                <div class="product-quantity">
                                                    <div class="cart-plus-minus">
                                                        <input type="text" value="01" name="qtybutton" class="cart-plus-minus-box">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- product-quantity-action end -->
                                    <!-- pro_dtl_btn start -->
                                    <ul class="pro_dtl_btn">
                                        <li><a href="cart.html"  class="buy_now_btn">Add to cart</a></li>
                                        <li><a href="wishlist.html"  class="buy_now_btn">Wishlist</a></li>
                                    </ul>
                                    <!-- pro_dtl_btn end -->
                                    <!-- pro_dtl_btn start -->
                                    <ul class="pro_dtl_btn">
                                        <li><a href="#"  class="buy_now_btn">buy now</a></li>
                                        <li><a href="#"><i class="ion-heart"></i></a></li>
                                    </ul>
                                    <!-- pro_dtl_btn end -->
                                    <!-- pro_social_share start -->
                                    <div class="pro_social_share d-flex">
                                        <h2 class="title_2">Share :</h2>
                                        <ul class="pro_social_link">
                                            <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                            <li><a href="#"><i class="ion-social-tumblr"></i></a></li>
                                            <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                            <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
                                            <li><a href="#"><i class="ion-social-youtube"></i></a></li>
                                            <li><a href="#"><i class="ion-social-linkedin"></i></a></li>
                                        </ul>
                                    </div><br>
                                    <ul class="feature_list">
                                        <li><a href="#"><i class="ion-ios-checkmark"></i>Security Policy</a></li>
                                        <li><a href="#"><i class="ion-ios-pricetags"></i>Delivery Policy </a></li>
                                        <li><a href="#"><i class="ion-ios-refresh"></i>Return Policy </a></li>

                                    </ul>
                                    <!-- pro_social_share end -->

                                </div>
                                <!-- product_details_info end -->
                            </div>
                        </div>
                        <!-- modal-inner-area end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal-wrapper end -->

</div>
<!-- Main Wrapper End -->

<!-- START Bootstrap-Cookie-Alert -->
<div class="alert text-center terxt-dark cookiealert" role="alert" style="background: #000 !important; color: #fff !important;">

    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 text-left" style="font-size: 16px;">
                Ao clicar em "Aceitar todos os cookies", concorda com o armazenamento de cookies no seu dispositivo para melhorar a navegação no site, analisar a utilização do site e ajudar nas nossas iniciativas de marketing.
            </div>
            <div class="col-md-4 text-md-right text-center">
                <button type="button" class="btn btn-success btn-lg acceptcookies">
                    Aceitar todos os cookies
                </button>
            </div>
        </div>
    </div>

</div>
<!-- END Bootstrap-Cookie-Alert -->

<!-- JS
============================================ -->
<!-- jQuery JS -->
<script src="/assets/js/vendor/jquery-1.12.0.min.js"></script>
<!-- Popper JS -->
<script src="/assets/js/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="/assets/js/bootstrap.min.js"></script>
<!-- Plugins JS -->
<script src="/assets/js/plugins.js"></script>
<!-- Ajax Mail -->
<script src="/assets/js/ajax-mail.js"></script>
<!-- Main JS -->
<script src="/assets/js/main.js"></script>

<script src="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.js"></script>

@hasSection('js')
    @yield('js')
@endif

<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/619e9d376885f60a50bd6907/1fl9pc89g';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->

</body>
</html>
