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
                        <li class="breadcrumb-item active">Fechando a Compra</li>
                    </ul>
                    <!-- breadcrumb-list end -->
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->

    @if(!\Illuminate\Support\Facades\Session::has('login_status') and \Illuminate\Support\Facades\Session::get('login_status') != 0)

    @else
        <form action="{{ route('front.valida_venda') }}" method="post">
            @csrf
            @method('post')
    @endif

    <!-- main-content-wrap start -->
    <div class="main-content-wrap section-ptb checkout-page">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="coupon-area">
                        @if(!\Illuminate\Support\Facades\Session::has('login_status') and \Illuminate\Support\Facades\Session::get('login_status') != 0)
                        <!-- coupon-accordion start -->
                        <div class="coupon-accordion">
                            <h3>Já tem conta? <span class="coupon" id="showlogin">Faça seu login</span></h3>
                            <div class="coupon-content" id="checkout-login">
                                <div class="coupon-info">
                                    <p>Se você já comprou conosco antes, insira seus dados nas caixas abaixo. Se você for um novo cliente, prossiga para Faturamento e Seção de envio.</p>
                                    <form action="{{ route('front.login_valida') }}" method="post">
                                        @csrf
                                        @method('post')
                                        <p class="coupon-input form-row-first">
                                            <label>CPF / CNPJ<span class="required">*</span></label>
                                            <input type="text" name="login">
                                        </p>
                                        <p class="coupon-input form-row-last">
                                            <label>Senha <span class="required">*</span></label>
                                            <input type="password" name="password">
                                        </p>
                                        <div class="clear"></div>
                                        <p>
                                            <button type="submit" class="button-login btn" name="login" value="Login">ENTRAR</button>
                                            <label class="remember"><input type="checkbox" value="1"><span>Remember</span></label>
                                        </p>
                                        <p class="lost-password">
                                            <a href="#">Lost your password?</a>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- coupon-accordion end -->
                        @else

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="your-order-wrapper">
                                        <h3 class="shoping-checkboxt-title">Seus Dados</h3>

                                        <div class="your-order-wrap">

                                            <!-- your-order-wrap end -->
                                            <div class="payment-method">
                                                <div class="payment-accordion">
                                                    <!-- ACCORDION START -->
                                                    <h3>Faturamento</h3>
                                                    <div class="payment-content">
                                                        <p class="mb-0">{{ \Illuminate\Support\Facades\Session::get('cliente')[0]->NmCliente }}</p>
                                                        <p class="mb-0">CPF/CNPJ: {{ \Illuminate\Support\Facades\Session::get('cliente')[0]->NuCpfCnpj }}</p>
                                                        <p class="mb-0">Telefone: {{ \Illuminate\Support\Facades\Session::get('cliente_telefone')[0]->NuTelefone }}</p>
                                                        <p class="mb-0">E-mail: {{ \Illuminate\Support\Facades\Session::get('cliente')[0]->NmEmail }}</p>
                                                    </div>

                                                    <h3>Entrega</h3>
                                                    <div class="payment-content">
                                                        <p class="mb-0">{{ \Illuminate\Support\Facades\Session::get('cliente')[0]->NmCliente }}</p>
                                                        <p class="mb-0"> {{ \Illuminate\Support\Facades\Session::get('cliente_endereco')[0]->NmEndereco }}, {{ \Illuminate\Support\Facades\Session::get('cliente_endereco')[0]->NuEndereco }} {{ \Illuminate\Support\Facades\Session::get('cliente_endereco')[0]->NmComplemento }}</p>
                                                        <p class="mb-0">{{ \Illuminate\Support\Facades\Session::get('cliente_endereco')[0]->NmBairro }} / {{ \Illuminate\Support\Facades\Session::get('cliente_endereco')[0]->NmCidade }} / {{ \Illuminate\Support\Facades\Session::get('cliente_endereco')[0]->SgEstado }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endif

                        <br><br>

                    </div>
                </div>
            </div>
            <!-- checkout-details-wrapper start -->
            <div class="checkout-details-wrapper">
                <div class="row">

                    <div class="col-md-12">
                        <!-- your-order-wrapper start -->
                        <div class="your-order-wrapper">
                            <h3 class="shoping-checkboxt-title">Seu Pedido</h3>
                            <!-- your-order-wrap start-->
                            <div class="your-order-wrap">
                                <!-- your-order-table start -->
                                <div class="your-order-table table-responsive">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th class="product-name text-left">Produto</th>
                                            <th class="product-total text-right">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(\Illuminate\Support\Facades\Session::get('carrinho') as $item)
                                        <tr class="cart_item">
                                            <td class="product-name text-left">
                                                #{{ $item->NmProduto }}
                                            </td>
                                            <td class="product-total text-right">
                                                <strong class="product-quantity"> × {{$item->QtProduto}}</strong> <span class="amount">R$ {{ number_format(($item->VlPreco*$item->QtProduto), 2, ',', '.') }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr class="cart-subtotal">
                                            <th class=" text-right">Subtotal</th>
                                            <th class="text-right"><span class="amount">R$ {{ number_format(\Illuminate\Support\Facades\Session::get('carrinho_total'), 2, ',', '.') }}</span></th>
                                        </tr>
                                        <tr class="shipping">
                                            <th class="text-right">Entrega</th>
                                            <td colspan="2" class="text-left pl-5">
                                                <ul class="text-left pl-2">
                                                    @foreach(\Illuminate\Support\Facades\Session::get('carrinho_entrega') as $item)
                                                    <li>
                                                        <input type="radio" name="frete" value="{{$item['carrier']}}">
                                                        <label>
                                                            {{$item['carrier']}} <span class="amount font-weight-bold">R$ {{ number_format(($item['price']), 2, ',', '.') }}</span>
                                                            <br> Prazo estimado <span class="amount font-weight-bold">{{$item['deliveryTime']}}</span> dias úteis.
                                                        </label>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>

                                        </tfoot>
                                    </table>
                                </div>
                                <!-- your-order-table end -->

                                <!-- your-order-wrap end -->
                                <div class="payment-method">
                                    @foreach(\Illuminate\Support\Facades\Session::get('carrinho_pagamento') as $item)
                                    <div class="payment-accordion">
                                        <!-- ACCORDION START -->
                                        <h3>{{$item->NmPagamento}}</h3>
                                        <div class="payment-content">

                                            <div class="form-check ml-5">
                                                <input class="form-check-input" type="radio" name="pagamento" id="pagamento{{$item->CdPagamento}}" value="{{$item->CdPagamento}}">
                                                <label class="form-check-label" for="pagamento{{$item->CdPagamento}}">
                                                    {{$item->NmPagamento}}
                                                </label>
                                            </div>
                                            <p>Parcelas:
                                                <select class="form-control" name="parcelas">
                                                    @for($i=1;$i<=$item->NuParcelaMaximo;$i++)
                                                        <option value="{{ $i }}"> {{ $i }} X de R$ {{ number_format((\Illuminate\Support\Facades\Session::get('carrinho_total')/$i), 2, ',', '.') }} </option>
                                                    @endfor
                                                </select>
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach

                                    <div class="order-button-payment">
                                        <input type="submit" value="CONCLUIR PEDIDO" />
                                    </div>
                                </div>
                                <!-- your-order-wrapper start -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- checkout-details-wrapper end -->
        </div>
    </div>
    <!-- main-content-wrap end -->

    @if(!\Illuminate\Support\Facades\Session::has('login_status') and \Illuminate\Support\Facades\Session::get('login_status') != 0)

    @else
        </form>
    @endif

@endsection

@section('js')
@endsection
