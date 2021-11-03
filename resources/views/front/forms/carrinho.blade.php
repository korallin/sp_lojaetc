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
                        <li class="breadcrumb-item active">Carrinho</li>
                    </ul>
                    <!-- breadcrumb-list end -->
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->
    <!-- main-content-wrap start -->
    <div class="main-content-wrap section-ptb cart-page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('front.carrinho_atz') }}" method="post">

                        @csrf
                        @method('post')

                        <div class="table-content table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="plantmore-product-thumbnail">#</th>
                                    <th class="cart-product-name">Produto</th>
                                    <th class="plantmore-product-price">Valor</th>
                                    <th class="plantmore-product-quantity">Quantidade</th>
                                    <th class="plantmore-product-subtotal">Sub Total</th>
                                    <th class="plantmore-product-remove">Excluir</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($produtos as $item)
                                    <input type="hidden" name="produto[]" value="{{$item->CdProduto}}">
                                    <input type="hidden" name="detalhe[]" value="{{$item->CdDetalhe}}">
                                <tr>
                                    <td class="plantmore-product-thumbnail"><a href="{{ route('front.produto', [$item->CdProduto, \Illuminate\Support\Str::slug($item->NmProduto)]) }}"><img style="max-height: 50px; max-width: 80px;" src="{{\Illuminate\Support\Facades\Session::get('loja_imagens')}}{{ $item->NmFoto }}" alt="{{$item->NmProduto}}"></a></td>
                                    <td class="plantmore-product-name"><a href="{{ route('front.produto', [$item->CdProduto, \Illuminate\Support\Str::slug($item->NmProduto)]) }}">{{ $item->NmProduto }} <b>{{ $item->NmDetalhe }}</b></a></td>
                                    <td class="plantmore-product-price"><span class="amount">
                                           <span class="new-price">R$ {{ number_format($item->VlPreco, 2, ',', '.') }}</span>
                                    <td class="plantmore-product-quantity">
                                        <input value="{{$item->QtProduto}}" name="quantidade[]" type="number">
                                    </td>
                                    <td class="product-subtotal"><span class="amount">
                                            <span class="new-price">R$ {{ number_format($item->VlPrecoTotal, 2, ',', '.') }}</span>
                                        </span></td>
                                    <td class="plantmore-product-remove"><a href="{{ route('front.carrinho_exc',[$item->CdProduto, $item->CdDetalhe]) }}"><i class="ion-close"></i></a></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="coupon-all">
                                    <bR><bR>
                                    <div class="coupon2">
                                        <input class="submit btn" name="update_cart" value="ATUALIZAR CARRINHO" type="submit">
                                        <a href="{{ route('front.home') }}" class="btn continue-btn">CONTINUAR COMPRANDO</a>
                                    </div>

                                    <div class="coupon d-none">
                                        <h3>CUPONS</h3>
                                        <p>Se tiver algum cupom insira abaixo.</p>
                                        <input id="coupon_code" class="input-text" name="coupon_code" value="" placeholder="Cupom" type="text">
                                        <input class="button" name="apply_coupon" value="APLICAR" type="submit">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 ml-auto">
                                <div class="cart-page-total">
                                    <h2>TOTAIS</h2>
                                    <ul>
                                        <li>Subtotal <span>R$ {{ number_format($dado_carrinho['cart_total'], 2, ',', '.') }}</span></li>
                                        <li>Entrega <span>R$ {{ number_format($dado_carrinho['cart_frete'], 2, ',', '.') }}</span></li>
                                        <li>Cupom <span>- R$ 0.00</span></li>
                                        <li>Total <span> R$ {{ number_format(($dado_carrinho['cart_total']+$dado_carrinho['cart_frete']), 2, ',', '.') }}</span></li>
                                    </ul>
                                    <a href="{{ route('front.checkout') }}" class="proceed-checkout-btn">FECHAR MINHA COMPRA</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- main-content-wrap end -->

@endsection

@section('js')
@endsection
