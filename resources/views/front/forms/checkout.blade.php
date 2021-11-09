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
                        <li class="breadcrumb-item active">Fechando Compra</li>
                    </ul>
                    <!-- breadcrumb-list end -->
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->



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

                                                    <h3 data-collapse-summary="" aria-expanded="true" class="open">Entrega</h3>
                                                    <div class="payment-content">
                                                        <p class="mb-0">{{ \Illuminate\Support\Facades\Session::get('cliente')[0]->NmCliente }}</p>
                                                        <p class="mb-0"> {{ \Illuminate\Support\Facades\Session::get('cliente_endereco')[0]->NmEndereco }}, {{ \Illuminate\Support\Facades\Session::get('cliente_endereco')[0]->NuEndereco }} {{ \Illuminate\Support\Facades\Session::get('cliente_endereco')[0]->NmComplemento }}</p>
                                                        <p class="mb-0">{{ \Illuminate\Support\Facades\Session::get('cliente_endereco')[0]->NmBairro }} / {{ \Illuminate\Support\Facades\Session::get('cliente_endereco')[0]->NmCidade }} / {{ \Illuminate\Support\Facades\Session::get('cliente_endereco')[0]->SgEstado }}</p>

                                                        @if(\Illuminate\Support\Facades\Session::get('enderecos')->count() > 1)
                                                        <button class="btn btn-info mt-2 ml-3" onclick="$('.lista-enderecos').toggle()">Mudar Endereço</button>
                                                        @endif
                                                        <button class="btn btn-info mt-2 ml-3" onclick="$('.novo-endereco').toggle()">Adicionar Novo</button>

                                                        <div class="lista-enderecos mt-2 ml-3" id="novo-endereco" STYLE="display: none;">

                                                            @foreach(\Illuminate\Support\Facades\Session::get('enderecos') as $endereco)
                                                                <div class="mt-3 table-striped bg-light p-2 border rounded-2">
                                                                    <p class="mb-0">{{ $endereco->NmTipoEndereco }}</p>
                                                                    <p class="mb-0"> {{ $endereco->NmEndereco }}, {{ $endereco->NuEndereco }} {{ $endereco->NmComplemento }}</p>
                                                                    <p class="mb-0">{{ $endereco->NmBairro }} / {{ $endereco->NmCidade }} / {{ $endereco->SgEstado }}</p>
                                                                    <a href="{{ route('front.troca_endereco', ['endereco' => $endereco->CdEndereco]) }}" class="btn btn-outline-info btn-sm mt-2 ml-3">Selecionar</a>
                                                                </div>
                                                            @endforeach


                                                        </div>


                                                        <div class="novo-endereco mt-2 ml-3" id="novo-endereco" STYLE="display: none;">
                                                            <form action="{{ route('front.salva_endereco') }}" method="post">
                                                                @csrf
                                                                @method('post')
                                                                <div class="row">
                                                                    <div class="form-group col-md-4">
                                                                        <label class="control-label" for="NmTipoEndereco">Nome do Endereço</label>
                                                                        <input type="text" name="NmTipoEndereco" value="" required="required" class="form-control input-lg" id="NmTipoEndereco" placeholder="Casa, loja">
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label class="control-label" for="NuCep">CEP</label>
                                                                        <input type="text" name="NuCep" value="" required="required" class="form-control input-lg cep" id="NuCep">
                                                                    </div>


                                                                </div>

                                                                <div class="row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="control-label" for="NmEndereco">Endereço</label>
                                                                        <input type="text" name="NmEndereco" readonly="readonly" value="" required="required" class="form-control input-lg " id="NmEndereco">
                                                                    </div>
                                                                    <div class="form-group col-md-2">
                                                                        <label class="control-label" for="NuEndereco">Número</label>
                                                                        <input type="text" name="NuEndereco" value="" required="required" class="form-control input-lg" id="NuEndereco">
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label class="control-label" for="NmComplemento">Complemento</label>
                                                                        <input type="text" name="NmComplemento" size="14" maxlength="100" value="" class="form-control input-lg" id="NmComplemento">
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="form-group col-md-4">
                                                                        <label class="control-label" for="NmBairro">Bairro</label>
                                                                        <input type="text" name="NmBairro" readonly="readonly" value="" required="required" class="form-control input-lg" id="NmBairro">
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label class="control-label" for="NmCidade">Cidade</label>
                                                                        <input type="text" name="NmCidade" readonly="readonly" value="" required="required" class="form-control input-lg" id="NmCidade">
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label class="control-label" for="SgEstado">Estado</label>
                                                                        <input type="text" name="SgEstado" readonly="readonly" value="" required="required" class="form-control input-lg" id="SgEstado">
                                                                    </div>
                                                                </div>

                                                                <button type="submit" class="btn btn-info mt-2 ml-3">Salvar Endereço</button>

                                                            </form>

                                                        </div>

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



            @if(!\Illuminate\Support\Facades\Session::has('login_status') and \Illuminate\Support\Facades\Session::get('login_status') != 0)

            @else
                <form action="{{ route('front.valida_venda') }}" method="post">
                @csrf
                @method('post')
                @endif

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
                                                #<a href="{{ route('front.produto', [$item->CdProduto, \Illuminate\Support\Str::slug($item->NmProduto)]) }}" class="">{{ $item->NmProduto }} <b>{{ $item->NmDetalhe }}</b></a>
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

                                        </tfoot>
                                    </table>
                                </div>
                                <!-- your-order-table end -->

                                <div class="payment-method">
                                    <h4 class="font-weight-bold">Entrega</h4>
                                    <p class="subsctibe-title">Selecione sua forma de entrega, fique atento aos prazos e valores</p>
                                    @foreach(\Illuminate\Support\Facades\Session::get('carrinho_entrega') as $item)

                                        <div class="mt-2 bg-light border pl-3">
                                            <div class="form-check ml-4">
                                                <div class="d-flex align-items-center">
                                                    <input class="form-check-input text-info" style="width: 30px; height: 30px;" required type="radio" name="frete" id="frete{{$item['carrier']}}" value="{{$item['carrier']}}">

                                                    <label class="form-check-label" for="frete{{$item['carrier']}}">
                                                        <h4 class="mb-0 mt-2 text-info font-weight-bold">{{ ($item['carrier'] != 'Correios' ? 'Transportadora '.$item['carrier'] : $item['carrier_description']) }}<br></h4>
                                                        <b>R$ {{ number_format(($item['price']), 2, ',', '.') }}</b> Prazo estimado <span class="amount font-weight-bold">{{$item['deliveryTime']}}</span> dias úteis.
                                                    </label>


                                                </div>
                                            </div>
                                        </div>

                                    @endforeach

                                </div>

                                <!-- your-order-wrap end -->
                                <div class="payment-method">
                                    <h4 class="font-weight-bold">Pagamento</h4>
                                    <p class="subsctibe-title">Selecione sua forma de pagamento</p>
                                    @foreach(\Illuminate\Support\Facades\Session::get('carrinho_pagamento') as $item)


                                        <div class="mt-2 bg-light border pl-3">
                                            <div class="form-check ml-4">
                                                <div class="d-flex align-items-center">
                                                    <input class="form-check-input text-info mr-5" style="width: 30px; height: 30px;" required type="radio" required name="pagamento" id="pagamento{{$item->CdPagamento}}" value="{{$item->CdPagamento}}">

                                                    <label class="form-check-label" for="pagamento{{$item->CdPagamento}}">
                                                        <h4 class="mb-0 mt-2 text-primary font-weight-bold">{{$item->NmPagamento}}</h4>
                                                        <p class="mb-0 small text-muted pr-5">{{ $item->TxPagamento }}</p>
                                                        <p>Em até {{ $item->NuParcelaMaximo }} X
                                                            <select class="form-control" name="parcelas">
                                                                @for($i=1;$i<=$item->NuParcelaMaximo;$i++)
                                                                    <option value="{{ $i }}"> {{ $i }} X de R$ {{ number_format((\Illuminate\Support\Facades\Session::get('carrinho_total')/$i), 2, ',', '.') }} </option>
                                                                @endfor
                                                            </select>
                                                        </p>
                                                    </label>


                                                </div>
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

    <script src="/assets/js/jquery.mask.min.js" type="text/javascript"></script>

    <script>

        $('.cep').mask('00.000-000');
        $('.telefone').mask('(00) 0000-0000');
        $('.celular').mask('(00) 0 0000-0000');
        $('.cpf').mask('000.000.000-00');

        $( "input[name=NuCep]" ).focusout(function(){
            var w_cep = $(this).val();
            $.ajax({
                type: "POST",
                url: '{{ route('front.cep') }}',
                data: {cep:w_cep, _token: '{{ @csrf_token() }}', tipoProcesso:'enderecoCep' },
                success: function( data ) {
                    $('#AjaxCarregaProcesso').html(data);

                    const obj = JSON.parse(data);

                    console.log(obj);

                    if(data){
                        $("input[name=NmEndereco]").val(obj.nome);
                        $("input[name=NmBairro]").val(obj.bairro);
                        $("input[name=NmCidade]").val(obj.cidade);
                        $("input[name=SgEstado]").val(obj.uf);
                        $("input[name=CdCepCep]").val(obj.w_cep);
                        $("input[name=CdCepBairro]").val(obj.id_bairro);
                        $("input[name=CdCepCidade]").val(obj.id_cidade);
                        $("input[name=CdCepUf]").val(obj.uf);
                        $("input[name=NuEndereco]").focus();

                    } else {
                        $('#msgCep').show();
                        $('#msgCepmsg').text($("input[name=wMensagem]").val());
                        $("input[name=NmEndereco]").val('');
                        $("input[name=NmBairro]").val('');
                        $("input[name=NmCidade]").val('');
                        $("input[name=SgEstado]").val('');
                        $("input[name=NuCep]").val('');
                        $("input[name=CdCepCep]").val('');
                        $("input[name=CdCepBairro]").val('');
                        $("input[name=CdCepCidade]").val('');
                        $("input[name=CdCepUf]").val('');
                        $("input[name=NuCep]").focus();
                    }
                }
            });
        });

    </script>

@endsection
