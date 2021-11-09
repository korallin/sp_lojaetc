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
            /*
            $client = new \GuzzleHttp\Client();
            $response = $client->post(
                'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout?email='.Session::get('loja_pagseguro_email').'&token='.Session::get('loja_pagseguro_token'),
                [
                    'headers' => [
                        'Token' => 'ca67b0b184904712436430a9299c7e69'
                    ],
                    'json' => [
                        'currency' => 'BRL',

                        'itemId1' => 0001
                        'itemDescription1' => Notebook Prata
                        'itemAmount1' => 100.00
                        'itemQuantity1' => 1
                        'itemWeight1' => 1000

                        'reference' => $dados['venda']->CdVenda;
                        'senderName' => Jose Comprador
                        'senderAreaCode' => 11
                        'senderPhone' => 56713293
                        'senderCPF' => 38440987803
                        'senderBornDate' => 12/03/1990
                        'senderEmail' => email@sandbox.pagseguro.com.br
                        'shippingType' => 1
                        'shippingAddressStreet' => Av. Brig. Faria Lima
                        'shippingAddressNumber' => 1384
                        'shippingAddressComplement' => 2o andar
                        'shippingAddressDistrict' => Jardim Paulistano
                        'shippingAddressPostalCode' => 01452002
                        'shippingAddressCity' => Sao Paulo
                        'shippingAddressState' => SP
                        'shippingAddressCountry' => BRA
                        'extraAmount' => -0.01
                        'redirectURL' => http' => //sitedocliente.com
                        'notificationURL' => https' => //url_de_notificacao.com
                        'maxUses' => 1
                        'maxAge' => 3000
                        'shippingCost' => 0.00
                    ]
                ]
            );
            return json_decode((string) $response->getBody(), true);
            */

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

            //dd($result);
            return $result;

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function retorno(Request $request)
    {

        return redirect()->route('front.recibo', ['dados' => $request->all()]);
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
