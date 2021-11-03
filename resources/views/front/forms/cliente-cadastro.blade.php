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

            <form action="{{ route('front.cadastro_grava') }}" id="cadastro" method="post">
                @csrf
                @method('post')
                <input type="hidden" name="tipoProcesso" value="grava-cadastro" />
                <input type="hidden" name="CdPessoaTemp" value="{{$dado['pessoa']->CdPessoa}}" />
                <input type="hidden" name="CdPerfil" value="1" />
                <input type="hidden" name="TpCliente" value="{{$dado['pessoa']->TpCliente}}" />
                <input type="hidden" name="TpClassificacao" value="1,9" />
                <div class="thumbnail">
                    <div class="col-sm-10 col-md-10 col-md-offset-1">

                        <fieldset>
                            <legend>Dados Basicos <small style="font-weight:normal; font-size:12px;">Informar seus dados de contato e para faturamento de eventuais notas fiscais.</small></legend>

                            <?php if($dado['pessoa']->TpCliente == 'F'){ ?>

                            <div class="pessoaFisica">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="control-label" for="NmCliente">Nome Completo</label>
                                        <input type="text" name="NmCliente" value="{{ old('NmCliente',$dado['pessoa']->NmCliente) }}" required="required" class="form-control input-lg {{ ($errors->has('NmCliente') ? 'is-invalid' : '') }}" id="NmCliente">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="control-label" for="NmContato">Apelido</label>
                                        <input type="text" name="NmContato" value="{{ old('NmContato',$dado['pessoa']->NmContato) }}" required="required" class="form-control input-lg {{ ($errors->has('NmContato') ? 'is-invalid' : '') }}" id="NmContato">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label" for="NuCpfCnpj">CPF</label>
                                        <input type="text" name="NuCpfCnpj" value="{{ $dado['pessoa']->NuCpfCnpj }}" readonly="readonly" required="required" class="form-control input-lg cpf" id="NuCpfCnpj">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label" for="NuIdentidade">Identidade</label>
                                        <input type="text" name="NuIdentidade" value="{{ old('NuIdentidade',$dado['pessoa']->NuIdentidade) }}" required="required" class="form-control input-lg {{ ($errors->has('NuIdentidade') ? 'is-invalid' : '') }}" id="NuIdentidade">
                                    </div>
                                </div>
                            </div>
                            <?php } else { ?>
                            <div class="pessoaJuridica">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="control-label" for="NmCliente">Razão Social</label>
                                        <input type="text" name="NmCliente" value="{{ old('NmCliente',$dado['pessoa']->NmCliente) }}" required="required" class="form-control input-lg {{ ($errors->has('NmCliente') ? 'is-invalid' : '') }}" id="NmCliente">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="control-label" for="NmContato">Nome Contato</label>
                                        <input type="text" name="NmContato" value="{{ old('NmContato',$dado['pessoa']->NmContato) }}" required="required" class="form-control input-lg {{ ($errors->has('NmContato') ? 'is-invalid' : '') }}" id="NmContato">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label" for="NuCpfCnpj">CNPJ</label>
                                        <input type="text" name="NuCpfCnpj" value="{{ $dado['pessoa']->NuCpfCnpj }}" readonly="readonly" required="required" class="form-control input-lg cnpj {{ ($errors->has('NuCpfCnpj') ? 'is-invalid' : '') }}" id="NuCpfCnpj">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label" for="NuInscricaoEstadual">Inscrição Estadual</label>
                                        <input type="text" name="NuInscricaoEstadual" value="{{ old('NuInscricaoEstadual',$dado['pessoa']->NuInscricaoEstadual) }}" required="required" required="required" class="form-control input-lg {{ ($errors->has('NuInscricaoEstadual') ? 'is-invalid' : '') }}" id="NuInscricaoEstadual">
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="NmEmail">Email</label>
                                    <input type="email" name="NmEmail" value="{{ $dado['pessoa_email']->NmEmail }}" readonly="readonly" required="required" class="form-control input-lg" id="NmEmail">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="NmSenha">Senha</label>
                                    <input type="password" name="password" required="required" value="" class="form-control input-lg {{ ($errors->has('NmSenha') ? 'is-invalid' : '') }}" id="NmSenha">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="NmSenha1">Confirmação de senha</label>
                                    <input type="password" name="password_confirmation" required="required" value="" class="form-control input-lg" id="NmSenha1">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="NuCelular">Celular</label>
                                    <input type="text" name="NuCelular" required="required" value="{{ old('NuCelular',$dado['pessoa_telefone']->NuCelular) }} {{ ($errors->has('NuCelular') ? 'is-invalid' : '') }}" class="form-control input-lg celular" id="NuCelular">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="NuTelefone">Telefone</label>
                                    <input type="text" name="NuTelefone" value="{{ old('NuTelefone',$dado['pessoa_telefone']->NuTelefone) }}" class="form-control input-lg telefone" id="NuTelefone">
                                </div>
                            </div>

                        </fieldset>

                        <fieldset>
                            <legend>Endereço Padrão <small style="font-weight:normal; font-size:12px;">Endereço utilizado para parte fiscal, envio de correspondencias e afins.</small></legend>
                            <input type="hidden" name="CdCepCep" value="{{ $dado['pessoa_endereco']->id_endereco  }}" />
                            <input type="hidden" name="CdCepBairro" value="{{ $dado['pessoa_endereco']->id_bairro  }}" />
                            <input type="hidden" name="CdCepCidade" value="{{ $dado['pessoa_endereco']->id_cidade  }}" />
                            <input type="hidden" name="CdCepUf" value="{{ $dado['pessoa_endereco']->id_uf  }}" />
                            <input type="hidden" name="NmTipoEndereco" value="Endereço de Cadastro" />

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="NuCep">CEP</label>
                                    <input type="text" name="NuCep" readonly="readonly" value="{{ $dado['pessoa_endereco']->NuCep }}" required="required" class="form-control input-lg cep" id="NuCep">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="NmEndereco">Endereço</label>
                                    <input type="text" name="NmEndereco" {{ ($dado['pessoa_endereco']->NmEndereco != '' ? 'readonly="readonly"' : '') }} required="required" value="{{ old('NmEndereco',$dado['pessoa_endereco']->NmEndereco) }}" class="form-control input-lg  {{ ($errors->has('NmEndereco') ? 'is-invalid' : '') }}" id="NmEndereco">
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label" for="NuEndereco">Número</label>
                                    <input type="text" name="NuEndereco" required="required" value="{{ old('NuEndereco',$dado['pessoa_endereco']->NuEndereco) }}" class="form-control input-lg {{ ($errors->has('NuEndereco') ? 'is-invalid' : '') }}" id="NuEndereco">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="NmComplemento">Complemento</label>
                                    <input type="text" name="NmComplemento" class="form-control input-lg" value="{{ old('NmComplemento',$dado['pessoa_endereco']->NmComplemento) }}" id="NmComplemento">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="NmBairro">Bairro</label>
                                    <input type="text" name="NmBairro" {{ ($dado['pessoa_endereco']->NmBairro != '' ? 'readonly="readonly"' : '') }} required="required" value="{{ old('NmBairro',$dado['pessoa_endereco']->NmBairro) }}" class="form-control input-lg" id="NmBairro">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="NmCidade">Cidade</label>
                                    <input type="text" name="NmCidade" readonly="readonly" required="required" value="{{ $dado['pessoa_endereco']->NmCidade }}" class="form-control input-lg" id="NmCidade">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="SgEstado">Estado</label>
                                    <input type="text" name="SgEstado" readonly="readonly" required="required" value="{{ $dado['pessoa_endereco']->SgEstado }}" class="form-control input-lg" id="SgEstado">
                                </div>
                            </div>

                        </fieldset>

                        <div class="form-group col-md-12 ">
                            <button type="submit" class="btn btn-warning btn-lg pull-right">Cadastrar</button>
                            <button type="button" tabindex="99" class="btn btn-default btn-voltar btn-lg pull-right " data-acao="voltar" data-local="">Cancelar cadastro</button>
                        </div>
                    </div>
                    <br />
                    <div class="clearfix"></div>
                </div>
            </form>
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
