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
                        <li class="breadcrumb-item active">Área do Cliente</li>
                    </ul>
                    <!-- breadcrumb-list end -->
                </div>
            </div>
        </div>
    </div>



    <!-- breadcrumb-area end -->
    <!-- main-content-wrap start -->
    <div class="main-content-wrap section-ptb my-account-page">
        <div class="container">

            @if(\Session::has('sucesso'))
                <div class="row">
                    <div class="col-lg-12">

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ \Session::get('sucesso') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    </div>
                </div>

            @endif

            <div class="row">
                <div class="col-12">
                    <div class="account-dashboard">
                        <div class="dashboard-upper-info">
                            <div class="row align-items-center no-gutters">
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="d-single-info">
                                        <p class="user-name">Olá <span>{{ \Illuminate\Support\Facades\Session::get('cliente')[0]->NmContato }}</span></p>
                                        <p>(não é {{ \Illuminate\Support\Facades\Session::get('cliente')[0]->NmContato }}? <a href="{{ route('front.logout') }}">Saia aqui</a>.)</p>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="d-single-info">
                                        <p>Precisa de ajuda? Nos chame no whatsapp.</p>
                                        <p>{{ \Illuminate\Support\Facades\Session::get('loja_whatsapp') }}.</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="d-single-info">
                                        <p>Nos mande um e-mail </p>
                                        <p>{{ \Illuminate\Support\Facades\Session::get('loja_email') }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 col-sm-12">
                                    <div class="d-single-info text-lg-center">
                                        <a href="{{ route('front.carrinho') }}" class="view-cart"><i class="fa fa-cart-plus"></i>Carrinho</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-2">
                                <!-- Nav tabs -->
                                <ul role="tablist" class="nav flex-column dashboard-list">
                                    <li><a href="#dashboard" data-toggle="tab" class="nav-link active">Minha Área</a></li>
                                    <li> <a href="#orders" data-toggle="tab" class="nav-link">Meus Pedidos</a></li>
                                    <li><a href="#address" data-toggle="tab" class="nav-link d-none">Meus Endereços</a></li>
                                    <li><a href="#account-details" data-toggle="tab" class="nav-link">Meu Cadastro</a></li>
                                    <li><a href="#account-street" data-toggle="tab" class="nav-link ">Meus Endereços</a></li>
                                    <li><a href="{{ route('front.logout') }}" class="nav-link">Sair</a></li>
                                </ul>
                            </div>
                            <div class="col-md-12 col-lg-10">
                                <!-- Tab panes -->
                                <div class="tab-content dashboard-content">
                                    <div class="tab-pane active" id="dashboard">
                                        <h3>Minha Área </h3>
                                        <p>Olá, <span style="color:#b40d1a;">{{ \Illuminate\Support\Facades\Session::get('cliente')[0]->NmContato }}</span> </p>
                                        <p>No painel da sua conta, você pode verificar e visualizar facilmente seus pedidos recentes, gerenciar seus endereços de envio e cobrança e editar sua senha e detalhes de conta.</p>
                                    </div>
                                    <div class="tab-pane fade" id="orders">
                                        <h3>Pedidos</h3>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>Pedido</th>
                                                    <th>Data</th>
                                                    <th>Status</th>
                                                    <th>Total</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach($dados['vendas'] as $venda)
                                                <tr>
                                                    <td>{{$venda->CdVenda}}</td>
                                                    <td>{{ date('d/m/Y') }}</td>
                                                    <td>
                                                        @if($venda->CdSituacao == 1) <span class="badge badge-info">Recebido</span> @endif
                                                    </td>
                                                    <td>R$ {{ number_format($venda->VlVenda, 2, ',', '.') }}</td>
                                                    <td><button onclick="$('#det-{{$venda->CdVenda}}').toggle()" class="view">Ver</button></td>
                                                </tr>

                                                <tr style="display: none" id="det-{{$venda->CdVenda}}">
                                                    <td colspan="7">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-2">
                                                                <div class="card">
                                                                    <div class="card-body small">
                                                                        <h4>Dados Entrega</h4>
                                                                        <p class="mb-0"> {{ $venda->NmCliente }} - CPF/CNPJ: {{ $venda->NuCpfCnpj }}</p>
                                                                        <p class="mb-0"> {{ $venda->NmEndereco }}, {{ $venda->NuEndereco }} {{ $venda->NmComplemento }}</p>
                                                                        <p class="mb-0">{{ $venda->NmBairro }} / {{ $venda->NmCidade }} / {{ $venda->SgEstado }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <div class="card">
                                                                    <div class="card-body small">
                                                                        <h4>Pagamento</h4>
                                                                        <p class="mb-0">Cartão de Crédito</p>
                                                                        <p class="mb-0">Status: @if($venda->CdSituacao == 1) <span class="badge badge-info">Recebido</span> @endif</p>
                                                                        <p class="mb-0">Entrega: Correios</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">

                                                                <div class="your-order-table table-responsive">
                                                                    <table>
                                                                        <thead>
                                                                        <tr>
                                                                            <th class="product-name text-left">Produto</th>
                                                                            <th class="product-total text-right">Total&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                        @foreach($dados['vendas_produtos'][$venda->CdVenda] as $itens)

                                                                            <tr class="cart_item">
                                                                                <td class="product-name text-left">
                                                                                    {{ $itens->NmProduto }} {{ $itens->NmDetalhe }}
                                                                                </td>
                                                                                <td class="product-total text-right">
                                                                                    X {{ $itens->QtVendida }} R$ {{ number_format(($itens->VlPreco*$itens->QtVendida), 2, ',', '.') }}&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                </td>
                                                                            </tr>

                                                                        @endforeach
                                                                        </tbody>
                                                                        <tfoot>
                                                                        <tr class="cart-subtotal">
                                                                            <th class=" text-right font-weight-bold">Subtotal</th>
                                                                            <th class="text-right"><span class="amount">R$ {{ number_format($venda->VlProduto, 2, ',', '.') }}</span>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                                        </tr>
                                                                        <tr class="cart-subtotal">
                                                                            <th class=" text-right font-weight-bold">Entrega</th>
                                                                            <th class="text-right"><span class="amount">R$ {{ number_format($venda->VlFrete, 2, ',', '.') }}</span>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                                        </tr>
                                                                        <tr class="cart-subtotal">
                                                                            <th class=" text-right font-weight-bold">TOTAL</th>
                                                                            <th class="text-right"><span class="amount">R$ {{ number_format($venda->VlVenda, 2, ',', '.') }}</span>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                                        </tr>

                                                                        </tfoot>
                                                                    </table>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>

                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="downloads">
                                        <h3>Downloads</h3>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Downloads</th>
                                                    <th>Expires</th>
                                                    <th>Download</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>Khaki utility boiler jumpsuit</td>
                                                    <td>May 10, 2018</td>
                                                    <td>never</td>
                                                    <td><a href="#" class="view">Click Here To Download File</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Yellow button front tea top</td>
                                                    <td>Sep 11, 2018</td>
                                                    <td>never</td>
                                                    <td><a href="#" class="view">Click Here To Download File</a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="account-details">
                                        <h3>Editar Meu Cadastro </h3>

                                        <div class="row">
                                            <div class="col-md-12">

                                                <form action="{{ route('front.cadastro_edita') }}" id="cadastro" method="post">
                                                    @csrf
                                                    @method('post')
                                                    <input type="hidden" name="tipoProcesso" value="grava-cadastro" />
                                                    <input type="hidden" name="CdCliente" value="{{$dados['pessoa']->CdCliente}}" />
                                                    <input type="hidden" name="CdPerfil" value="1" />
                                                    <input type="hidden" name="TpCliente" value="{{$dados['pessoa']->TpCliente}}" />
                                                    <input type="hidden" name="TpClassificacao" value="1,9" />

                                                    <fieldset>

                                                        <?php if($dados['pessoa']->TpCliente == 'F'){ ?>

                                                        <div class="pessoaFisica">
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <label class="control-label" for="NmCliente">Nome Completo</label>
                                                                    <input type="text" name="NmCliente" value="{{ old('NmCliente',$dados['pessoa']->NmCliente) }}" required="required" class="form-control input-lg {{ ($errors->has('NmCliente') ? 'is-invalid' : '') }}" id="NmCliente">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="form-group col-md-4">
                                                                    <label class="control-label" for="NmContato">Apelido</label>
                                                                    <input type="text" name="NmContato" value="{{ old('NmContato',$dados['pessoa']->NmContato) }}" required="required" class="form-control input-lg {{ ($errors->has('NmContato') ? 'is-invalid' : '') }}" id="NmContato">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label class="control-label" for="NuCpfCnpj">CPF</label>
                                                                    <input type="text" name="NuCpfCnpj" value="{{ $dados['pessoa']->NuCpfCnpj }}" readonly="readonly" required="required" class="form-control input-lg cpf" id="NuCpfCnpj">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label class="control-label" for="NuIdentidade">Identidade</label>
                                                                    <input type="text" name="NuIdentidade" value="{{ old('NuIdentidade',$dados['pessoa']->NuIdentidade) }}" required="required" class="form-control input-lg {{ ($errors->has('NuIdentidade') ? 'is-invalid' : '') }}" id="NuIdentidade">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } else { ?>
                                                        <div class="pessoaJuridica">
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <label class="control-label" for="NmCliente">Razão Social</label>
                                                                    <input type="text" name="NmCliente" value="{{ old('NmCliente',$dados['pessoa']->NmCliente) }}" required="required" class="form-control input-lg {{ ($errors->has('NmCliente') ? 'is-invalid' : '') }}" id="NmCliente">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="form-group col-md-4">
                                                                    <label class="control-label" for="NmContato">Nome Contato</label>
                                                                    <input type="text" name="NmContato" value="{{ old('NmContato',$dados['pessoa']->NmContato) }}" required="required" class="form-control input-lg {{ ($errors->has('NmContato') ? 'is-invalid' : '') }}" id="NmContato">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label class="control-label" for="NuCpfCnpj">CNPJ</label>
                                                                    <input type="text" name="NuCpfCnpj" value="{{ $dados['pessoa']->NuCpfCnpj }}" readonly="readonly" required="required" class="form-control input-lg cnpj {{ ($errors->has('NuCpfCnpj') ? 'is-invalid' : '') }}" id="NuCpfCnpj">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label class="control-label" for="NuInscricaoEstadual">Inscrição Estadual</label>
                                                                    <input type="text" name="NuInscricaoEstadual" value="{{ old('NuInscricaoEstadual',$dados['pessoa']->NuInscricaoEstadual) }}" required="required" required="required" class="form-control input-lg {{ ($errors->has('NuInscricaoEstadual') ? 'is-invalid' : '') }}" id="NuInscricaoEstadual">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label class="control-label" for="NmEmail">Email</label>
                                                                <input type="email" name="NmEmail" value="{{ $dados['pessoa_email']->NmEmail }}" readonly="readonly" required="required" class="form-control input-lg" id="NmEmail">
                                                            </div>

                                                            <div class="form-group col-md-3">
                                                                <label class="control-label" for="NuCelular">Celular</label>
                                                                <input type="text" name="NuCelular" required="required" value="{{ old('NuCelular',$dados['pessoa_celular']->NuTelefone) }} {{ ($errors->has('NuCelular') ? 'is-invalid' : '') }}" class="form-control input-lg celular" id="NuCelular">
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label class="control-label" for="NuTelefone">Telefone</label>
                                                                <input type="text" name="NuTelefone" value="{{ old('NuTelefone',$dados['pessoa_telefone']->NuTelefone) }}" class="form-control input-lg telefone" id="NuTelefone">
                                                            </div>
                                                        </div>

                                                            <button type="submit" class="btn btn-info mt-2 ml-3">Salvar Alterações</button>

                                                    </fieldset>

                                                </form>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="account-street">
                                        <h3>Seus Endereços <button class="btn btn-info btn-sm float-right mt-2 ml-3" onclick="$('.novo-endereco').toggle()">Adicionar Novo</button></h3>

                                        <div class="novo-endereco mt-2 ml-3" id="novo-endereco" STYLE="display: none;">
                                            <form action="{{ route('front.salva_endereco') }}" method="post">
                                                @csrf
                                                @method('post')
                                                <input type="hidden" name="areacliente" value="1">
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
                                                <button type="button" class="btn btn-info mt-2 ml-3" onclick="$('.novo-endereco').toggle()">Cancelar</button>

                                                <hr class="my-5">

                                            </form>

                                        </div>

                                                <div class="row">
                                                    @foreach(\Illuminate\Support\Facades\Session::get('enderecos') as $endereco)
                                                        <div class="col-md-6 mb-4">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h4 class="mb-0"><b>{{ $endereco->NmTipoEndereco }}</b>
                                                                        @if(\Illuminate\Support\Facades\Session::get('enderecos_total') > 1)
                                                                            <a href="{{ route('front.exclui_endereco', ['endereco' => $endereco->CdEndereco]) }}" onclick="if(!sconfirm('Deseja realmente excluir o endereço!')){ return false; }" style="float: right;" class="btn btn-outline-danger btn-sm mt-2 bg-danger ml-3"><i class="fas fa-trash"></i></a>
                                                                        @endif
                                                                    </h4>
                                                                    <p class="mb-0"> {{ $endereco->NmEndereco }}, {{ $endereco->NuEndereco }} {{ $endereco->NmComplemento }}</p>
                                                                    <p class="mb-0">{{ $endereco->NmBairro }} / {{ $endereco->NmCidade }} / {{ $endereco->SgEstado }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>



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

        @if(session()->has('sucesso'))
        //alert('{{ session()->get('sucesso') }}');
        @endif

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
