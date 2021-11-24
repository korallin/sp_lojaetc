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
                        <li class="breadcrumb-item active">Recibo</li>
                    </ul>
                    <!-- breadcrumb-list end -->
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->
    <!-- main-content-wrap start -->
    <div class="main-content-wrap section-ptb lagin-and-register-page">
        <div class="container">
            <div class="row cnt_box align-items-center">
                <div class="col-md-3 d-none d-sm-block">

                </div>
                <div class="col-md-5 col-sm-6 mt-sm-5 mb-sm-5">
                    <h3>Pedido Colocado!</h3>

                    <p>Agradecemos seu pedido, assim que o pagamento for confirmado vamos iniciar a separação dos itens.</p>
                    <p>Seu pedido em nossa loja é <b>{{ $dados['espelho']['venda']->CdVenda }}</b></p>

                    @if($dados['retrono_id'] == 'deposito')
                        <p>Os dados para deposito e/ou transferência são:</p>
                        <p>{{ $dados['venda_pagamento'][0]->TxPagamento }}</p>
                    @else
                        <p>TID <b>{{ $dados['retorno_id'] }}</b></p>
                    @endif




                </div>
            </div>
        </div>
    </div>
    <!-- main-content-wrap end -->

@endsection

@section('js')

    <script src="/assets/js/jquery.mask.min.js" type="text/javascript"></script>

    <script>
        $(document).ready(function(e){

            $('.pessoaEscolhe').bind('click', function() {
                $('.tipoDocumentoField').attr('disabled','disabled');
                if($(this).val() == 1){
                    console.log('1');
                    //$('.tipoDocumentoLabel').text('CPF');
                    $('.tipoDocumentoField').removeClass('cnpj');
                    $('.tipoDocumentoField').addClass('cpf');
                    $('.tipoDocumentoField').mask('000.000.000-00');
                    $('.tipoDocumentoField').attr('placeholder','000.000.000-00');
                    $('.tipoDocumentoField').removeAttr('disabled');
                    $('.tipoDocumentoField').focus();
                } else {
                    console.log('2');
                    //$('.tipoDocumentoLabel').text('CNPJ');
                    $('.tipoDocumentoField').removeClass('cpf');
                    $('.tipoDocumentoField').addClass('cnpj');
                    $('.tipoDocumentoField').mask('00.000.000/0000-00');
                    $('.tipoDocumentoField').attr('placeholder','00.000.000/0000-00');
                    $('.tipoDocumentoField').removeAttr('disabled');
                    $('.tipoDocumentoField').focus();
                }
            });

            $('.cep').mask('00.000-000');
            $('.telefone').mask('(00) 0000-0000');
            $('.celular').mask('(00) 0 0000-0000');
            $('.cpf').mask('000.000.000-00');

            $( "input[name=NuCep]" ).focusout(function(){
                $.ajax({
                    type: "POST",
                    url: '/processo/cliente-endereco',
                    data: {cep:$(this).val(), tipoProcesso:'enderecoCep' },
                    success: function( data ) {
                        $('#AjaxCarregaProcesso').html(data);

                        if($("input[name=wRetorno]").val() == 1){
                            $("input[name=NmEndereco]").val($("input[name=wNmEndereco]").val());
                            $("input[name=NmBairro]").val($("input[name=wNmBairro]").val());
                            $("input[name=NmCidade]").val($("input[name=wNmCidade]").val());
                            $("input[name=SgEstado]").val($("input[name=wSgEstado]").val());
                            $("input[name=CdCepCep]").val($("input[name=wCdCepCep]").val());
                            $("input[name=CdCepBairro]").val($("input[name=wCdCepBairro]").val());
                            $("input[name=CdCepCidade]").val($("input[name=wCdCepCidade]").val());
                            $("input[name=CdCepUf]").val($("input[name=wCdCepUf]").val());
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
        });
    </script>

@endsection
