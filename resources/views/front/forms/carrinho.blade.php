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
                                    <td class="plantmore-product-thumbnail">

                                        <a href="{{ route('front.produto', [$item->CdProduto, \Illuminate\Support\Str::slug($item->NmProduto)]) }}">
                                            @if($item->NmFoto == '')
                                                <img style="max-width: 80px;" src="/assets/images/no-foto.jpg" alt="{{$item->NmProduto}}" title="{{$item->NmProduto}}">
                                            @else
                                                <img style="max-width: 80px;" src="{{\Illuminate\Support\Facades\Session::get('loja_imagens')}}{{ $item->NmFoto }}"  alt="{{$item->NmProduto}}" title="{{$item->NmProduto}}">
                                            @endif
                                        </a>

                                    </td>
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

                                    <div class="row">
                                        <div class="col-md-4 mr-5">
                                            <div class="cart-page-total">
                                                <h2>Simule seu frete</h2>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="NuCep" value="" required="required" class="form-control cep" placeholder="Informe seu CEP" id="NuCep">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary btenviar" type="button">Enviar</button>
                                                    </div>
                                                </div>
                                                <div id="resultado"></div>

                                            </div>
                                        </div>
                                        <div class="col-md-6 small mt-4" id="frete">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 ml-auto">
                                <div class="cart-page-total">
                                    <h2>TOTAIS</h2>
                                    <ul>
                                        <li>Subtotal <span>R$&nbsp;&nbsp;{{ number_format($dado_carrinho['cart_total'], 2, ',', '.') }}</span></li>
                                        <li>Entrega <span>R$&nbsp;&nbsp;<span class="t_frete">{{ number_format($dado_carrinho['cart_frete'], 2, ',', '.') }}</span></span></li>
                                        <li>Total <span> R$&nbsp;&nbsp;<span class="t_total">{{ number_format(($dado_carrinho['cart_total']+$dado_carrinho['cart_frete']), 2, ',', '.') }}</span></span></li>
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

    <script src="/assets/js/jquery.mask.min.js" type="text/javascript"></script>

    <script>

        $('.cep').mask('00.000-000');
        $('.telefone').mask('(00) 0000-0000');
        $('.celular').mask('(00) 0 0000-0000');
        $('.cpf').mask('000.000.000-00');

        function format_real(n, currency = ' ') {
            return currency + n.toFixed(2).replace(/(\d)(?=(\d{3})+\,)/g, '$1.');
        }

        function convertMoneyValue(number){
            number = parseFloat((number/100)).toFixed(2);
            return (new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(number));
        }


        $( "input[name=NuCep]" ).focusout(function(){
            var w_cep = $(this).val();
            $.ajax({
                type: "POST",
                url: '{{ route('front.cep') }}',
                data: {cep:w_cep, _token: '{{ @csrf_token() }}', tipoProcesso:'enderecoCep' },
                success: function( data ) {
                    $('.btenviar').html('<i class="fas fa-sync fa-spin"></i>');

                    const obj = JSON.parse(data);

                    console.log(obj);

                    if(data != '0'){
                        $('#resultado').html(obj.nome+' - '+obj.bairro+'<br>'+obj.cidade+' / '+obj.uf);

                        $.ajax({
                            type: "POST",
                            url: '{{ route('front.frete') }}',
                            data: {cep:w_cep, _token: '{{ @csrf_token() }}', tipoProcesso:'enderecoCep' },
                            success: function( frete ) {
                                 console.log(frete);

                                const obj = JSON.parse(frete);



                                if(data != '0'){
                                    $.each( obj, function( i, elem ) {
                                        if(elem.carrier == 'Correios'){
                                            $('#frete').append("<div class='total' style='cursor: pointer;' data-frete='"+elem.price+"'><b>"+elem.carrier_description+' - R$'+elem.price+'</b><br>Prazo estimado: '+elem.deliveryTime+' dia(s)</div><hr>');
                                        } else {
                                            $('#frete').append("<div class='total' style='cursor: pointer;' data-frete='"+elem.price+"'><b>"+elem.carrier+' - R$'+elem.price+'</b><br>Prazo estimado: '+elem.deliveryTime+' dia(s)</div><hr>');
                                        }
                                        var w_total = {{$dado_carrinho['cart_total']}};
                                        var w_frete = elem.price;
                                        w_total = (w_frete + w_total);
                                        $('.t_frete').text(w_frete);
                                        $('.t_total').text(w_total);
                                    });

                                    $('div.total').click(function(e){
                                        var w_total = {{$dado_carrinho['cart_total']}};
                                        var w_frete = $(this).data('frete');
                                        w_total = (w_frete + w_total);
                                        $('.t_frete').text(w_frete);
                                        $('.t_total').text(w_total);

                                    });

                                    $('.btenviar').text('Enviar');

                                } else {
                                    $('#frete').html("Cep inválido.");
                                    $('.cep').val('');
                                    $('.btenviar').text('Enviar');
                                }
                            }
                        });

                    } else {
                        $('#resultado').html("Cep inválido.");
                        $('.cep').val('');
                        $('.btenviar').text('Enviar');
                    }
                }
            });
        });

    </script>

@endsection
