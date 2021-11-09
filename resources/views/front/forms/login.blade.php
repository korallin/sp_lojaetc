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
                        <li class="breadcrumb-item active">Cliente</li>
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
                <div class="col-md-5 d-none d-sm-block">
                    <div class="single_contact_rt_thumb">
                        <img src="/assets/images/ff.png" alt="">
                    </div><br>
                </div>
                <div class="col-md-7 col-sm-6">
                    <div class="login-register-wrapper">
                        <!-- login-register-tab-list start -->
                        <div class="login-register-tab-list nav">
                            <a class="active" data-toggle="tab" href="#lg1">
                                <h4> login </h4>
                            </a>
                            <a data-toggle="tab" href="#lg2">
                                <h4> novo </h4>
                            </a>
                        </div>
                        <!-- login-register-tab-list end -->

                        @foreach($errors->all() as $erro)
                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ $erro }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                </div>
                            </div>

                        @endforeach

                        @if(\Session::has('success'))
                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ \Session::get('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                </div>
                            </div>

                        @endif

                        <div class="tab-content">
                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{ route('front.login_valida') }}" method="post">
                                            @csrf
                                            @method('post')
                                            <div class="login-input-box">
                                                <input type="number" name="login" placeholder="CPF ou CNPJ">
                                                <input type="password" name="senha" placeholder="Senha">
                                            </div>
                                            <div class="button-box">
                                                <div class="login-toggle-btn">
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#senha-modal">Perdeu a senha?</a>
                                                </div>
                                                <div class="button-box">
                                                    <button class="login-btn btn" type="submit"><span>Entrar</span></button>
                                                    <button class="login-btn btn" type="submit"><span>Novo Cadastro</span></button>
                                                </div>
                                            </div>
                                        </form>


                                        <!-- Modal -->
                                        <div class="modal fade" id="senha-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-sm" style="max-width: 400px;">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light">
                                                        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Solicitar nova senha</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <form action="{{ route('front.login_senha') }}" method="post">
                                                    <div class="modal-body">
                                                        <p>Informe os dados abaixo para que possamos lhe enviar uma nova senha.</p>

                                                            @csrf
                                                            @method('post')
                                                            <div class="login-input-box">
                                                                <input type="number" required name="login" placeholder="CPF ou CNPJ">
                                                                <input type="email" required name="email" placeholder="Seu e-mail de cadastro">
                                                            </div>


                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="button-box">
                                                            <button class="login-btn btn" type="submit"><span>Solicitar</span></button>
                                                        </div>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div id="lg2" class="tab-pane">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{ route('front.cadastro_temp') }}" method="post">
                                            @csrf
                                            @method('post')
                                            <div class="login-input-box">

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input pessoaEscolhe" checked style="position: absolute;  margin-left: -20px; margin-top: 18px;" type="radio" name="tipo" id="inlineRadio1" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">CPF</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input pessoaEscolhe" style="position: absolute;    margin-left: -20px; margin-top: 18px;" type="radio" name="tipo" id="inlineRadio2" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">CNPJ</label>
                                                </div>
                                                <br>
                                                <input type="text" name="cpfcnpj" class="cpf tipoDocumentoField" placeholder="CPF">
                                                <input type="email" name="email" placeholder="E-mail">
                                                <input type="text" name="cep" class="cep" placeholder="CEP" >
                                            </div>
                                            <div class="button-box">
                                                <button class="register-btn btn" type="submit"><span>Enviar</span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
