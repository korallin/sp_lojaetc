@extends('front.'.\Illuminate\Support\Facades\Session::get('loja').'.master')

@section('css')

    <!-- thumbelina Style CSS -->
    <link rel="stylesheet" href="/assets/css/thumbelina.css">
    <link rel="stylesheet" href="https://unpkg.com/xzoom/dist/xzoom.css">

    <style>
        .xzoom {
            -webkit-box-shadow:none !important; box-shadow:none !important;
        }
    </style>
@endsection

@section('content')

    @foreach($produtos as $item)
    <!-- breadcrumb-area start -->
    <div class="breadcrumb-area section-ptb" style="background: #ccc; height: auto; padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col">

                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $item->NmProduto }}</li>
                    </ul>
                    <!-- breadcrumb-list end -->
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->
    <!-- main-content-wrap start -->
    <div class="main-content-wrap section-ptb product-details-page">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-7 col-md-6">
                    <div class="product-details-images">
                        <div class="product_details_container">
                            <!-- product_big_images start -->

                            <div class="product_big_images-top">
                                <div class="portfolio-full-image tab-content">

                                    <div role="tabpanel" class="tab-pane active product-image-position" id="img-tab-0">

                                        @if($item->NmFoto == '')
                                            <img src="/assets/images/no-foto.jpg" alt="{{$item->NmProduto}}" title="{{$item->NmProduto}}">
                                        @else
                                            <img src="{{\Illuminate\Support\Facades\Session::get('loja_imagens')}}{{ $item->NmFoto }}" style="border:0px; -webkit-box-shadow:none; box-shadow:none;" alt="{{$item->NmProduto}}" title="{{$item->NmProduto}}" class="xzoom" xoriginal="{{\Illuminate\Support\Facades\Session::get('loja_imagens')}}{{ $item->NmFoto }}">
                                        @endif

                                    </div>

                                    <div class="xzoom-thumbs">
                                        @foreach($produto_fotos as $foto)
                                            <a href="{{\Illuminate\Support\Facades\Session::get('loja_imagens')}}{{ $foto->NmFoto }}">
                                                <img class="xzoom-gallery" style="width: 80px !important; border:0px; -webkit-box-shadow:none; box-shadow:none;" width="80" src="{{\Illuminate\Support\Facades\Session::get('loja_imagens')}}{{ $foto->NmFoto }}"  xpreview="{{\Illuminate\Support\Facades\Session::get('loja_imagens')}}{{ $foto->NmFoto }}">
                                            </a>
                                        @endforeach
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-5 col-md-6">
                    <!-- product_details_info start -->
                    <div class="product_details_info">
                        <h2>{{ $item->NmProduto }}</h2>
                        <!-- pro_rating start -->
                        <div class="pro_rating d-none ">
                            <ul class="product-rating d-flex">
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                                <li><span class="icon-star"></span></li>
                            </ul>
                            <span class="rat_qun"> (Based on 3 Ratings) </span>
                        </div>
                        <!-- pro_rating end -->
                        <!-- pro_details start -->
                        <div class="pro_details">

                        </div>
                        <!-- pro_details end -->

                        @if($item->estoque > 0)

                            <form action="{{ route('front.carrinho_add') }}" method="post">

                                @csrf
                                @method('post')

                                <input type="hidden" name="produto" value="{{$item->CdProduto}}">



                                @if(count($produto_detalhe) > 1)

                                    <div class="pro_dtl_size">
                                        <h2 class="title_2">Escolha a variação</h2>
                                        @foreach($produto_detalhe as $pd)
                                            @if($pd->estoque > 0)
                                            <div class="form-check" style="padding-left: 25px;">
                                                <input class="form-check-input" type="radio" name="detalhe" id="detalhe_{{$pd->CdDetalhe}}" value="{{$pd->CdDetalhe}}" required>
                                                <label class="form-check-label" style="padding-left: 0.25rem;" for="detalhe_{{$pd->CdDetalhe}}">
                                                    {{$pd->NmDetalhe}} - <span class="new-price text-success font-weight-bolder">R$ {{ number_format($pd->VlPromocional, 2, ',', '.') }}</span>
                                                </label>
                                            </div>
                                            @endif

                                        @endforeach

                                    </div>

                                @else

                                    <ul class="pro_dtl_prize">

                                        @if($item->VlPrecoMax > $item->VlPrecoMin)
                                            <li class="old_prize">R$ {{ number_format($item->VlPrecoMax, 2, ',', '.') }}</li>
                                            <li class="new-price">R$ {{ number_format($item->VlPrecoMin, 2, ',', '.') }}</li>
                                        @else
                                            <li class="new-price">R$ {{ number_format($item->VlPrecoMax, 2, ',', '.') }}</li>
                                        @endif

                                    </ul>

                                    <input type="hidden" name="detalhe" value="{{$produto_detalhe[0]->CdDetalhe}}">

                            @endif

                            <!-- pro_dtl_prize start -->

                                <!-- pro_dtl_prize end -->


                                <!-- pro_dtl_size end -->
                                <!-- product-quantity-action start -->
                                <div class="product-quantity-action">
                                    <div class="prodict-statas"><span>Quantidade :</span></div>
                                    <div class="product-quantity">

                                        <div class="product-quantity">
                                            <div class="cart-plus-minus">
                                                <input value="1" type="number" name="quantidade" min="1" max="99">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- product-quantity-action end -->
                                <!-- pro_dtl_btn start -->
                                <ul class="pro_dtl_btn">
                                    <li><button type="submit"  class="btn buy_now_btn" style="width: 300px;">ADICIONAR AO CARRINHO</button></li>
                                </ul>

                            </form>

                        @else

                            @if(session()->has('sucesso'))

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <div>{{ session()->get('sucesso') }}</div>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            @endif

                            <ul class="pro_dtl_btn">
                                <li><button type="button" data-toggle="modal" data-target="#aviseme" class="btn buy_now_btn" style="width: 300px;">AVISE-ME</button></li>
                            </ul>

                            <div class="modal fade" id="aviseme" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-sm" style="max-width: 400px;">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title font-weight-bold" id="exampleModalLabel">AVISE-ME QUANDO CHEGAR</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form action="{{ route('front.login_senha') }}" method="post">
                                            <div class="modal-body">
                                                <p>Informe os dados abaixo para que possamos lhe enviar um e-mail avisando.</p>

                                                @if($errors->all())
                                                    <div class="container mb-3">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                    @foreach($errors->all() as $erro)
                                                                        <div>{{ $erro }}</div>
                                                                    @endforeach
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @csrf
                                                @method('post')
                                                <input type="hidden" name="id_detalhe" value="{{$produto_detalhe[0]->CdDetalhe}}">
                                                <input type="hidden" name="id_produto" value="{{$item->CdProduto}}">
                                                <div class="login-input-box">
                                                    <input type="text" required name="nome" placeholder="Seu Nome">
                                                    <input type="email" required name="email" placeholder="Seu e-mail">
                                                </div>


                                            </div>
                                            <div class="modal-footer">
                                                <div class="button-box">
                                                    <button class="login-btn btn" type="submit"><span>Enviar</span></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @endif

                        <div class="pro_social_share mx-auto">
                            <h2 class="title_2">COMPARTILHAR:</h2>
                            <ul class="pro_social_link">
                                <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="#"><i class="ion-social-tumblr"></i></a></li>
                                <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
                                <li><a href="#"><i class="ion-social-youtube"></i></a></li>
                                <li><a href="#"><i class="ion-social-linkedin"></i></a></li>
                            </ul>
                        </div>
                        <!-- pro_social_share end -->
                    </div>
                    <!-- product_details_info end -->
                </div>
            </div>
            <div class="row ">
                <div class="col-12">
                    <div class="product-details-tab mt--60">
                        <ul role="tablist" class="mb--50 nav">
                            <li class="active" role="presentation">
                                <a data-toggle="tab" role="tab" href="#description" class="active">Descrição</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12">
                    <div class="product_details_tab_content tab-content">
                        <!-- Start Single Content -->
                        <div class="product_tab_content tab-pane active" id="description" role="tabpanel">
                            <div class="product_description_wrap">
                                <div class="product_desc mb--30">
                                    <h2 class="title_3">Detalhes</h2>

                                    @php
                                        echo $item->TxProduto;
                                    @endphp

                                </div>
                            </div>
                        </div>
                        <!-- End Single Content -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- main-content-wrap end -->
    <!-- product-area start -->
    <div class="product-area section-ptb">
        <div class="container">

            <div class="row mt-4">
                <div class="col-lg-12">
                    <!-- section-title start -->
                    <div class="section-title">
                        <h2 class="bg-light my-2">OUTROS PRODUTOS</h2>
                        <p>Produtos que outras pessoas viram</p>
                    </div>
                    <!-- section-title end -->
                </div>
            </div>

            <!-- product-warpper start -->
            <div class="product-warpper">
                <div class="product-slider row">

                    @foreach($produtos_outros as $item)
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <!-- single-product-wrap start -->
                            <div class="single-product-wrap">
                                <div class="product-image bloco-foto">
                                    <a href="{{ route('front.produto', [$item->CdProduto, \Illuminate\Support\Str::slug($item->NmProduto)]) }}">
                                        @if($item->NmFoto == '')
                                            <img src="/assets/images/no-foto.jpg" alt="{{$item->NmProduto}}" title="{{$item->NmProduto}}">
                                        @else
                                            <img src="{{\Illuminate\Support\Facades\Session::get('loja_imagens')}}{{ $item->NmFoto }}"  alt="{{$item->NmProduto}}" title="{{$item->NmProduto}}">
                                        @endif
                                    </a>
                                    <div class="product-action">
                                        <a href="#" class="wishlist d-none"><i class="icon-heart"></i></a>
                                        <a href="{{ route('front.produto', [$item->CdProduto, \Illuminate\Support\Str::slug($item->NmProduto)]) }}" class="add-to-cart"><i class="icon-handbag"></i></a>
                                        <a href="#" class="quick-view d-none" data-toggle="modal" data-target="#exampleModalCenter"><i class="icon-shuffle"></i></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3><a href="{{ route('front.produto', [$item->CdProduto, \Illuminate\Support\Str::slug($item->NmProduto)]) }}" class="small">{{ $item->NmProduto }}</a></h3>
                                    <div class="price-box">
                                        <small>A partir de:</small><br>
                                        <span class="new-price text-success">R$ {{ number_format($item->VlPrecoMin, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <!-- single-product-wrap end -->
                        </div>
                    @endforeach


                </div>
            </div>
            <!-- product-warpper start -->
        </div>
    </div>
    <!-- product-area end -->

@endsection

@section('js')
    <!-- thumbelina Zoomin JS -->
    <script src="/assets/js/thumbelina.js"></script>
    <!-- cloudzoom Zoomin JS -->
    <script src="https://unpkg.com/xzoom/dist/xzoom.min.js"></script>


    <script type = "text/javascript">

        $(".xzoom, .xzoom-gallery").xzoom({tint: '#333', Xoffset: 15});

        // Initialize the slider.
        $(function(){
            $('#slider1').Thumbelina({
                $bwdBut:$('#slider1 .left'),
                $fwdBut:$('#slider1 .right')
            });
        });

        // The following piece of code can be ignored.
        $(function(){
            $(window).resize(function() {
                $('#info').text("Page width: "+$(this).width());
            });
            $(window).trigger('resize');
        });

        $('.mini').click(function (e){
           var id = $(this).attr('href');
           $('.tab-pane').each( function(i,el) {
               $(this).removeClass('active');
            });
           $(id).addClass('active');
        });



    </script>
@endsection
