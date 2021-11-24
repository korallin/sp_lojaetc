<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PagSeguro\Configuration\Configure;
use PagSeguro\Services\Session as PagseguroSession;
use PagSeguro\Domains\Requests\Payment as PagseguroPayment;
use PagSeguro\Services\Transactions\Search\Code as PagseguroSearchCode;
use PagSeguro\Services\Transactions\Notification as PagseguroNotification;
use PagSeguro\Helpers\Xhr;
use PagSeguro\Parsers\Transaction\Response as PagseguroResponse;

class PagSeguroController extends Controller
{
    public function __construct()
    {
        $this->_configs = new Configure();
        $this->_configs->setCharset('UTF-8');
        $this->_configs->setAccountCredentials(Session::get('loja_pagseguro_email'), Session::get('loja_pagseguro_token'));
        $this->_configs->setEnvironment(Session::get('loja_pagseguro_ambiente'));
        //pode ser false
        $this->_configs->setLog(true, storage_path('logs/pagseguro_'. date('Ymd') .'.txt'));
    }

    static public function criaRequisicao($dados)
    {

        try {

            $_configs = new Configure();
            $_configs->setCharset('UTF-8');
            $_configs->setAccountCredentials(Session::get('loja_pagseguro_email'), Session::get('loja_pagseguro_token'));
            $_configs->setEnvironment(Session::get('loja_pagseguro_ambiente'));
            $_configs->setLog(true, storage_path('logs/pagseguro_'. date('Ymd') .'.txt'));

            $paymentRequest = new PagSeguroPayment();

            foreach($dados['venda_produtos'] as $r){
                $paymentRequest->addItems()->withParameters(
                    $r->CdProduto,
                    $r->NmProduto,
                    $r->QtProduto,
                    $r->VlPreco
                );
            }

            $paymentRequest->setReference($dados['venda']->CdVenda);
            $paymentRequest->setCurrency('BRL');

            $paymentRequest->setSender(
                $dados['cliente']->NmCliente,
                $dados['cliente']->NmEmail,
                substr($dados['cliente']->NuTelefone,2),
                substr($dados['cliente']->NuTelefone,2,10),
                'CPF',
                $dados['cliente']->NuCpfCnpj
            );

            //$paymentRequest->setShipping()->setType()->withParameters($dados['frete']['nome']);

            /*
            $paymentRequest->setShipping()->setAddress()->withParameters(
                $dados['cliente_endereco']->NmEndereco,
                $dados['cliente_endereco']->NuEndereco,
                $dados['cliente_endereco']->NmCidade,
                $dados['cliente_endereco']->NuCep,
                $dados['cliente_endereco']->NmCidade,
                $dados['cliente_endereco']->SgEstado,
                'BRA',
                $dados['cliente_endereco']->NmComplemento,
            );
            */

            $paymentRequest->setShipping()->setCost()->withParameters($dados['frete']['valor']);

            $onlyCheckoutCode = true;
            $result = $paymentRequest->register($_configs->getAccountCredentials());

            $atzvenda = \App\Models\Venda::where(['CdEstabel' => Session::get('loja_estabelecimento'),'NuCaixa' => Session::get('loja_caixa'),'CdVenda' => $dados['venda']->CdVenda])->first();
            $atzvenda->NmUrlTransacao = $result;
            $atzvenda->save();

            //dd($result,$paymentRequest->get);
            return $result;

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function retorno(Request $request)
    {

        $url  = "https://ws.pagseguro.uol.com.br/v2/transactions/notifications/".$request->id."?email=".Session::get('loja_pagseguro_email')."&token=".Session::get('loja_pagseguro_token');
        $url  = "https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/".$request->id."?email=".Session::get('loja_pagseguro_email')."&token=".Session::get('loja_pagseguro_token');
        //dump($url);
        //Inicia o curl

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $resposta = curl_exec($curl);
        $http     = curl_getinfo($curl);

        dd($resposta,$http);

        if($resposta == 'Unauthorized'){

            /*
            $atzvenda = \App\Models\Venda::where(['CdEstabel' => Session::get('loja_estabelecimento'),'NuCaixa' => Session::get('loja_caixa')])->whereRaw('TxTransacao like "%'.$request->id.'"')->first();
            $atzvenda->CdSituacao = 9;
            $atzvenda->save();
            */

            return redirect()->route('front.checkout')->with('erro_pagamento','Pagamento recusado, tente novamente!');
            exit;
        }else{
            //Interpreta uma string XML e a transforma em um objeto
            $resposta= simplexml_load_string($resposta);
            //dd($resposta);
            //Verifica se existem erros

            //dd($resposta);

            if(count($resposta->error) > 0){
                return redirect()->route('front.checkout')->with('erro_pagamento', 'Pagamento recusado, tente novamente!');
                exit;
            }



            //Verifica se a transação foi paga
            if($resposta->status == 3){

                $venda_pagamento = new \App\Models\VendaPagamento();
                $venda_pagamento->CdEstabel = Session::get('loja_estabelecimento');
                $venda_pagamento->NuCaixa = Session::get('loja_caixa');
                $venda_pagamento->CdTipo = 4;
                $venda_pagamento->CdVenda = $resposta->reference;
                $venda_pagamento->CdPagamento = 11;
                $venda_pagamento->VlPagamento = $resposta->grossAmount;
                $venda_pagamento->DtVencimento = date('Y-m-d H:i');
                $venda_pagamento->NmPagamentoECF = "PagSeguro";
                $venda_pagamento->CdBanco = NULL;
                $venda_pagamento->NuCartaoCheque = $resposta->code;
                $venda_pagamento->NuCartaoSeguranca = NULL;
                $venda_pagamento->NmCartaoTitular = NULL;
                $venda_pagamento->NuCartaoValidadeData = NULL;
                $venda_pagamento->NuParcela = $resposta->installmentCount;
                $venda_pagamento->QtParcela = $resposta->installmentCount;
                $venda_pagamento->VlTaxa = $resposta->feeAmount;
                $venda_pagamento->StSincroniza = 1;
                $venda_pagamento->DtAtualizacao = date('Y-m-d H:i');
                $venda_pagamento->save();

                return redirect()->route('front.recibo', ['dados' => $request->all()]);

            }
        }




        /*
        $dados['retorno_pagseguro'] = $request->all();
        $dados['pedido'] = Session::get('espelho');
        $dados = json_encode($dados, true);
        file_put_contents(storage_path('app/public/pagseguro_retorno/'.$dados['pedido']['venda']->CdVenda.'_'.date('U').'.json'), $dados);
        if(isset($request->retorno_recibo)){
            return redirect()->route('front.recibo', ['dados' => $request->all()]);
        }
        //dd($request);
        */
    }

    static public function verificaNotificacao(Request $request)
    {
        try {

            $_configs = new Configure();
            $_configs->setCharset('UTF-8');
            $_configs->setAccountCredentials(Session::get('loja_pagseguro_email'), Session::get('loja_pagseguro_token'));
            $_configs->setEnvironment(Session::get('loja_pagseguro_ambiente'));

            if (Xhr::hasPost()) {
                $response = PagseguroNotification::check(
                    $_configs->getCredenciais()
                );
                self::atualizaPagamento($response);
            } else {
                throw new Exception('Código invalido');
            }
        } catch (Exception $e) {
            logger($e->getMessage());
        }
    }

}
