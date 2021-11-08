<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;


class CieloCheckout extends Controller
{
    static public function pedido($dados)
    {

        $cabecalhos = array();
        $produtos = array();

        $cabecalhos[] = 'MerchantId: ' . Session::get('loja_cielo_merchantid');
        $cabecalhos[] = 'Content-Type: application/json';

        foreach($dados['venda_produtos'] as $r){
            $produtos[] = array(
                "Name" => $r->NmProduto,
                "UnitPrice" => number_format($r->VlPreco,2,'',''),
                "Type" => "Asset",
                "Quantity" => $r->QtProduto
            );
        }



        $dados = array(
            "OrderNumber" => $dados['venda']->CdVenda,
            "SoftDescriptor" => Session::get('loja_cielo_softdescriptor'),
            "Cart"=>array(
                "Items" => $produtos
            ),
            "Payment"=>array(
                "MaxNumberOfInstallments" => $dados['venda_pagamento']->QtParcela,
                "numberOfPayments" => $dados['venda_pagamento']->QtParcela,
            ),
            "Shipping"=>array(
                "SourceZipCode" => Session::get('loja_cep'),
                "TargetZipCode" => $dados['cliente_endereco']->NuCep,
                "Type" => "FixedAmount",
                "Services" => [
                    [
                    'Name' => $dados['frete']['nome'],
                    'Price' => number_format($dados['frete']['valor'],2,'',''),
                    'Deadline' => $dados['frete']['prazo']
                    ]
                ],
                "Address" => [
                     "Street" => $dados['cliente_endereco']->NmEndereco,
                     "Number" => $dados['cliente_endereco']->NuEndereco,
                     "Complement" => $dados['cliente_endereco']->NmComplemento,
                     "District" => $dados['cliente_endereco']->NmCidade,
                     "City" => $dados['cliente_endereco']->NmCidade,
                     "State" => $dados['cliente_endereco']->SgEstado,
                  ]
            ),
            "Customer"=>array(
                "FullName" => $dados['cliente']->NmCliente,
                "Email" => $dados['cliente']->NmEmail,
                "Phone" => $dados['cliente']->NuTelefone,
                "Identity" => $dados['cliente']->NuCpfCnpj
            ),
            "Settings" => array(
                "ReturnUrl" => route('retorno.cielo')
            )
        );

        $data = json_encode($dados, true);


        if (json_last_error()) {
            print 'ERRO NA CODIFICACAO JSON: ' . json_last_error_msg();
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://cieloecommerce.cielo.com.br/api/public/v1/orders');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $cabecalhos);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

        return $response;

    }

    public function retorno(Request $request)
    {

        $dados = $request->all();
        $dados = json_encode($dados, true);
        file_put_contents($dados, storage_path('app/public/cielo_retorno/'.date('U').'.json'));
        if(isset($request->retorno_recibo)){
            return redirect()->route('front.recibo', ['dados' => $request->all()]);
        }
        //dd($request);
    }

}
