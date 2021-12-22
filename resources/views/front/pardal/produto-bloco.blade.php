@section('produto-bloco')
    <!-- shop-products-wrap start -->
    <div class="shop-products-wrap">
        <div class="tab-content">
            <div id="grid" class="tab-pane face active show" role="tabpanel">
                <div class="shop-product-wrap">
                    <div class="row">

                        @foreach($produtos as $item)

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
                                            @if($item->VlPrecoMin > 0)
                                            <small>A partir de:</small><br>
                                            <span class="new-price text-success">R$ {{ number_format($item->VlPrecoMin, 2, ',', '.') }}</span>
                                            @else
                                                <span class="new-price text-info">Sob Consulta</span><br>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- single-product-wrap end -->
                            </div>

                        @endforeach

                    </div>
                </div>
            </div>

            <div id="list" class="tab-pane fade" role="tabpanel">
                <div class="shop-product-list-wrap">

                    @foreach($produtos as $item)
                        <div class="row product-layout-list">
                            <div class="col-lg-4 col-md-5">
                                <!-- single-product-wrap start -->
                                <div class="single-product-wrap">
                                    <div class="product-image">
                                        <a href="{{ route('front.produto', [$item->CdProduto, \Illuminate\Support\Str::slug($item->NmProduto)]) }}"><img src="{{\Illuminate\Support\Facades\Session::get('loja_imagens')}}{{ $item->NmFoto }}" alt="{{$item->NmProduto}}"></a>
                                        <div class="product-action">
                                            <a href="#" class="wishlist d-none"><i class="icon-heart"></i></a>
                                            <a href="{{ route('front.produto', [$item->CdProduto, \Illuminate\Support\Str::slug($item->NmProduto)]) }}" class="add-to-cart"><i class="icon-handbag"></i></a>
                                            <a href="#" class="quick-view d-none" data-toggle="modal" data-target="#exampleModalCenter"><i class="icon-shuffle"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- single-product-wrap end -->
                            </div>
                            <div class="col-lg-8 col-md-7">
                                <div class="product-content text-left">
                                    <h3><a href="{{ route('front.produto', [$item->CdProduto, \Illuminate\Support\Str::slug($item->NmProduto)]) }}">{{ $item->NmProduto }}</a></h3>
                                    <div class="price-box">
                                        @if($item->VlPrecoMax > $item->VlPrecoMin)
                                            <span class="old-price text-danger">R$ {{ number_format($item->VlPrecoMax, 2, ',', '.') }}</span>
                                            <span class="new-price">R$ {{ number_format($item->VlPrecoMin, 2, ',', '.') }}</span>
                                        @else
                                            <span class="new-price">R$ {{ number_format($item->VlPrecoMax, 2, ',', '.') }}</span>
                                        @endif
                                    </div>
                                    <p>
                                        {{ $item->TxProduto }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- shop-products-wrap end -->
@endsection
