<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Frenet;

class Carrinho extends Controller
{

    public function checkout()
    {
        $this->load_cart();

        if(!Session::exists('login') || Session::get('login')['login_id'] == 0){
            $view = 'front.forms.login';
            return view($view);
        }

        $token = '3C9E6860R0A46R40C9RA362RFD7770475319';
        $api = \Frenet\ApiFactory::create($token);

        $quote = $api->shipping()->quote()
            ->setRecipientCountry('BR')
            ->setSellerPostcode(Session::get('loja_cep'))
            ->setRecipientPostcode(Session::get('cliente_endereco')[0]->NuCep)
            ->setShipmentInvoiceValue(Session::get('carrinho_total'));

        foreach (Session::get('carrinho') as $item){
            if(!isset($item->PsProduto) || $item->PsProduto == '' || $item->PsProduto < 0.300) $item->PsProduto = 0.300;
            if(!isset($item->largura) || $item->largura == '') $item->largura = 20;
            if(!isset($item->altura) || $item->altura == '') $item->altura = 20;
            if(!isset($item->profundidade) || $item->profundidade == '') $item->profundidade = 20;
            $quote_itens = $quote->addShippingItem($item->CdProduto.'-'.$item->CdDetalhe, $item->QtProduto, $item->PsProduto, $item->largura, $item->altura, $item->profundidade, 'Accessories');
        }
        /**
         * The method `execute()` sends the request and parse the body result to a object type.
         *
         * @var \Frenet\ObjectType\Entity\Shipping\QuoteInterface $result
         */
        $result = $quote_itens->execute();
        $services = $result->getShippingServices();

        //dd($services);


        /** @var Frenet\ObjectType\Entity\Shipping\Quote\ServiceInterface $service */
        $dados['frete'] = [];
        $cc = 0;



        foreach ($services as $service) {

            if(!$service->isError()){

                if(in_array($service->getCarrier(), Session::get('loja_transportadora'), false)) {
                    $dados['frete'][$service->getCarrier()]['price'] = $service->getShippingPrice();
                    $dados['frete'][$service->getCarrier()]['carrier'] = $service->getCarrier();
                    $dados['frete'][$service->getCarrier()]['carrier_description'] = $service->getServiceDescription();
                    $dados['frete'][$service->getCarrier()]['deliveryTime'] = $service->getDeliveryTime();
                    $dados['frete'][$service->getCarrier()]['responseTime'] = $service->getResponseTime();
                }
                $cc++;
            }

        }

        Session::put('carrinho_entrega', $dados['frete']);

        $pagamento = DB::connection('mysql_loja')->select('

            select * from pagamento_forma FO
            where FO.StPagamento = 1
            and FO.StLojaVirtual = 1
            and FO.VlPagamentoMinimo <= ?
            order by FO.NuApresentacao, FO.NmPagamento

        ', [Session::get('carrinho_total')]);

        Session::put('carrinho_pagamento', $pagamento);

        $enderecos = \App\Models\ClienteEndereco::where('CdCliente', Session::get('cliente')[0]->CdCliente)->get();
        $enderecos_total = \App\Models\ClienteEndereco::where('CdCliente', Session::get('cliente')[0]->CdCliente)->count();
        Session::put('enderecos', $enderecos);
        Session::put('enderecos_total', $enderecos_total);

        $view = 'front.forms.checkout';
        return view($view);
    }

    public function valida_venda(Request $request)
    {

        $cliente = Session::get('cliente')[0];
        $cliente_endereco = Session::get('cliente_endereco')[0];

        $venda_numero = DB::connection('mysql_loja')->select('select max(CdVenda) as numero from venda where CdEstabel = '.Session::get('loja_estabelecimento').' and NuCaixa = '.Session::get('loja_caixa').' and CdTipo = 1');

        if(!$venda_numero[0]->numero) {
            $venda_numero = 1;
        } else {
            $venda_numero = $venda_numero[0]->numero;
        }

        $total_venda = (Session::get('carrinho_total') + Session::get('carrinho_entrega')[$request->frete]['price']);
        $data_venda = date('Y-m-d H:i:s');

        $venda = new \App\Models\Venda();
        $venda->CdEstabel 		= Session::get('loja_estabelecimento');
		$venda->NuCaixa			= Session::get('loja_caixa');
		$venda->CdTipo			= 1;
        //$venda->CdVenda			= $venda_numero;

		$venda->DtVenda			= $data_venda;
		$venda->CdTabela		= 1;
		$venda->CdSituacao		= 1;
		$venda->VlVenda			= $total_venda;
		$venda->VlProduto		= Session::get('carrinho_total');
		$venda->VlFrete			= Session::get('carrinho_entrega')[$request->frete]['price'];
		$venda->VlDesconto		= 0;
		$venda->VlAcrescimo		= 0;

		$venda->CdVendedor		= 1;
		$venda->CdCliente		= $cliente->CdCliente;

		$venda->TpCliente		= $cliente->TpCliente;
		$venda->NmCliente		= $cliente->NmCliente;
		$venda->NuCpfCnpj		= $cliente->NuCpfCnpj;
		$venda->NmTipoEndereco  = $cliente_endereco->NmTipoEndereco;
		$venda->NmEndereco		= $cliente_endereco->NmEndereco;
		$venda->NuEndereco		= $cliente_endereco->NuEndereco;
		$venda->NmComplemento	= $cliente_endereco->NmComplemento;
		$venda->NmBairro		= $cliente_endereco->NmBairro;
		$venda->NmCidade		= $cliente_endereco->NmCidade;
		$venda->SgEstado		= $cliente_endereco->SgEstado;
		$venda->NuCep			= $cliente_endereco->NuCep;
		$venda->CdMunicipioIBGE = $cliente_endereco->CdMunicipioIBGE;
		$venda->CdUsuario		= 1;
		$venda->DtAtualizacao	= $data_venda;
		$venda->save();
		$nu_venda = \App\Models\Venda::where(['CdEstabel' => Session::get('loja_estabelecimento'),'NuCaixa' => Session::get('loja_caixa'),'CdCliente' => $cliente->CdCliente,'DtVenda' => $data_venda])->first();

		$venda_produto = DB::connection('mysql_loja')->insert('
		insert into venda_produto (CdEstabel, NuCaixa, CdTipo, CdVenda, CdProduto, CdDetalhe, CdReferencia, QtVendida, PsProduto, VlPreco, VlCusto, VlDesconto, CdSitTributariaIcms, CdSitTributariaIpi, CdSitTributariaPis, CdSitTributariaCofins, CdCFOP,  StItem, DtAtualizacao)
        (select PT.CdEstabel, '.Session::get('loja_caixa').', 1, '.$nu_venda->CdVenda.', PT.CdProduto, PT.CdDetalhe, PT.CdReferencia, PT.QtProduto, PT.PsProduto, PT.VlPreco, PE.VlCusto, PT.VlDesconto,  PR.CdSitTributariaIcms, PR.CdSitTributariaIpi, PR.CdSitTributariaPis, PR.CdSitTributariaCofins, PR.CdCFOP, 1, "'.date('Y-m-d H:i:s').'"
        from produto_temp PT
        join produto PR on (PR.CdProduto = PT.CdProduto)
        left join produto_estoque PE on (PE.CdEstabel = PT.CdEstabel and PE.CdProduto = PT.CdProduto and PE.CdDetalhe = PT.CdDetalhe)
        where PT.CdEstabel = '.Session::get('loja_estabelecimento').'
        and PT.CdMovimento = 9
        and PT.NuSessao = "'.session()->getId().'"
        order by PT.CdProduto, PT.CdDetalhe, PT.CdTemp)

		');

		$venda_pagamento = new \App\Models\VendaPagamento();
        $venda_pagamento->CdEstabel		    =	Session::get('loja_estabelecimento');
		$venda_pagamento->NuCaixa			=	Session::get('loja_caixa');
		$venda_pagamento->CdTipo			= 	1;
		$venda_pagamento->CdVenda			=	$nu_venda->CdVenda;
		$venda_pagamento->CdPagamento		=	$request->pagamento;
		$venda_pagamento->VlPagamento		= 	$total_venda;
		$venda_pagamento->DtVencimento		=	$data_venda;
		$venda_pagamento->NuParcela		    = 	$request->parcelas;
		$venda_pagamento->QtParcela		    =	$request->parcelas;
		$venda_pagamento->DtAtualizacao 	=   $data_venda;
		$venda_pagamento->save();

		$pagamento_modalidade = \App\Models\FormaPagamento::where('CdPagamento', $request->pagamento)->first();

		$dados[] = '';
		$dados['cliente'] = $cliente;
        $dados['cliente_endereco'] = $cliente_endereco;
        $dados['venda'] = $nu_venda;
        $dados['venda_produtos'] = Session::get('carrinho');
        $dados['venda_pagamento'] = $venda_pagamento;
        $dados['frete']['nome'] = $request->frete;
        $dados['frete']['valor'] = Session::get('carrinho_entrega')[$request->frete]['price'];
        $dados['frete']['prazo'] = Session::get('carrinho_entrega')[$request->frete]['deliveryTime'];

        Session::put(['espelho' => $dados]);

        if($pagamento_modalidade->CdPagamento == '3'){
            $cielo = \App\Http\Controllers\CieloCheckout::pedido($dados);
            return redirect($cielo->settings->checkoutUrl);
        }

        if($pagamento_modalidade->CdPagamento == '11'){
            $pagseguro = \App\Http\Controllers\PagSeguroController::criaRequisicao($dados);
            return redirect($pagseguro);
        }

        dd($request->all(),$pagamento_modalidade,$venda,$venda_produto,$request,$cliente,$cliente_endereco);


    }

    public function recibo(Request $request)
    {
        $cart = \App\Models\ProdutoTemp::where(array('NuSessao' => session()->getId()))->delete();
        if(!$request->retorno_recibo){
            $dados['retorno_id'] = 'Em processamento';
        } else {
            $dados['retorno_id'] = $request->retorno_recibo;
        }
        $dados['espelho'] = Session::get('espelho');



        return view('front.forms.recibo', ['dados' => $dados]);
    }


    public function exc(Request $request, $produto, $detalhe)
    {
        $cart = \App\Models\ProdutoTemp::where(array('NuSessao' => session()->getId(), 'CdProduto' => $produto, 'CdDetalhe' => $detalhe))->delete();

        $this->load_cart();

        return redirect()->route('front.carrinho');
    }

    public function add(Request $request)
    {

        $prod = DB::connection('mysql_loja')->select('
        select   PR.CdProduto, PR.NmProduto, PR.TxProduto, PC.CdReferencia,
			min(PP.VlPreco) as VlPrecoMin, max(PP.VlPreco) as VlPrecoMax,
			PF.NmFoto, PD.PsProduto as PsProduto,
			if(PF.NmFoto is null, 0,1) as StFoto, GX.CdDepartamento as CdDepartamento
        from produto PR
        join produto_detalhe PD on (PR.CdProduto = PD.CdProduto)
        join produto_preco PP on (PP.CdProduto = PR.CdProduto and PP.CdDetalhe = PD.CdDetalhe )
        join produto_estoque PE on (PE.CdProduto = PD.CdProduto and PE.CdDetalhe = PD.CdDetalhe and PE.CdEstabel = ? )
        join produto_codigo PC on (PD.CdProduto = PC.CdProduto and PD.CdDetalhe = PC.CdDetalhe and PC.StPrincipal = 1 )
        left join produto_foto PF on (PF.CdProduto = PR.CdProduto and PF.StPrincipal = 1)

        join produto_x_departamento GX on (GX.CdProduto = PR.CdProduto)
        join produto_departamento GR on (GR.CdDepartamento = GX.CdDepartamento)
        left join produto_departamento SG on (GR.CdDepartamentoPai = SG.CdDepartamento)

        where PR.DtDesativacao is null
        and PP.CdTabela in (?)
        and PR.CdProduto = ?
        and PD.CdDetalhe = ?

        group by PR.CdProduto
        limit 1;

        ', [Session::get('loja_estabelecimento'),Session::get('loja_tabelas'),$request->produto,$request->detalhe]);

        //dd(Session::get('login'));

        if(!Session::exists('login') || Session::get('login')['login_id'] == 0){
            Session::put(['login' => ['nome' => 'Visitante', 'login_id' => 0]]);
        } else {
            Session::put(['login' => ['nome' => Session::get('cliente')[0]->NmContato, 'login_id' => Session::get('cliente')[0]->CdCliente]]);
        }

        $cart = \App\Models\ProdutoTemp::firstOrNew(array('NuSessao' => session()->getId(), 'CdProduto' => $request->produto, 'CdDetalhe' => $request->detalhe));
        $cart->CdMovimento = 9;
        $cart->CdEstabel = Session::get('loja_estabelecimento');
        $cart->CdCliente = Session::get('login')['login_id'];
        $cart->NuSessao = session()->getId();
        $cart->CdProduto = $request->produto;
        $cart->CdDetalhe = $request->detalhe;
        $cart->CdReferencia = $prod[0]->CdReferencia;
        $cart->QtProduto = $request->quantidade;
        $cart->PsProduto = $prod[0]->PsProduto;
        $cart->VlPreco = $prod[0]->VlPrecoMin;
        $cart->DtAtualizacao = date('Y-m-d H:i:s');
        $cart->save();

        $this->load_cart();

        return redirect()->route('front.carrinho');

    }

    public function atz(Request $request)
    {

        $this->load_cart();

        foreach ($request->produto as $k => $v){
            if($request->quantidade[$k] == 0){
                $cart = \App\Models\ProdutoTemp::where(array('NuSessao' => session()->getId(), 'CdProduto' => $request->produto[$k], 'CdDetalhe' => $request->detalhe[$k]))->delete();
            } else {

            }
            $cart = \App\Models\ProdutoTemp::where(array('NuSessao' => session()->getId(), 'CdProduto' => $request->produto[$k], 'CdDetalhe' => $request->detalhe[$k]))->first();
            $cart->QtProduto = $request->quantidade[$k];
            $cart->DtAtualizacao = date('Y-m-d H:i:s');
            $cart->save();
        }

        $this->load_cart();
        return redirect()->route('front.carrinho');

    }

    public function lista_carrinho()
    {

        $this->load_cart();

        $view = 'front.forms.carrinho';
        return view($view, ['produtos' => \Illuminate\Support\Facades\Session::get('carrinho')]);

    }

    public function load_cart(){
        $produtos = DB::connection('mysql_loja')->select('
        select  	PT.CdTemp, PR.CdProduto, PR.CdUnidade, PR.NmProduto, PR.NuNcm, PD.PsProduto,
                    PF.NmFoto,
                    if(PF.NmFoto is null, 0,1) as StFoto,
                    UN.NmUnidade, UN.StFracionario, PD.CdDetalhe, PD.NmDetalhe,
                    PT.CdReferencia, PT.QtProduto, PT.VlPreco, PT.VlDesconto, PT.PcDesconto,
                    (PT.QtProduto * (PT.VlPreco - PT.VlDesconto) ) as VlPrecoTotal
        from produto_temp PT
        join produto_detalhe PD on (PT.CdProduto = PD.CdProduto and PT.CdDetalhe = PD.CdDetalhe)
        join produto PR on (PT.CdProduto = PR.CdProduto)
        join produto_unidade UN on (UN.CdUnidade = PR.CdUnidade)
        left join produto_foto PF on (PF.CdProduto = PR.CdProduto and PF.StPrincipal = 1)
        where PT.CdEstabel = ?
        and PT.CdMovimento = 9
            and PT.NuSessao = ?
        group by PT.CdProduto, PT.CdDetalhe
        order by PT.CdTemp;
        ', [Session::get('loja_estabelecimento'), session()->getId()]);

        Session::put('carrinho',$produtos);
        $unidade = 0;
        $valor = 0;

        foreach ($produtos as $p){
            $valor += $p->VlPrecoTotal;
            $unidade += $p->QtProduto;
        }
        Session::put('carrinho_total',$valor);
        Session::put('carrinho_itens',$unidade);

    }


}


