<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FreteNet extends Controller
{
    public function consulta(Request $request)
    {
        $token = '3C9E6860R0A46R40C9RA362RFD7770475319';
        $api = \Frenet\ApiFactory::create($token);

        $quote = $api->shipping()->quote()
            ->setRecipientCountry('BR')
            ->setSellerPostcode(Session::get('loja_cep'))
            ->setRecipientPostcode(\App\Http\Controllers\Auxiliar::l_int($request->cep))
            ->setShipmentInvoiceValue(Session::get('carrinho_total'));

        foreach (Session::get('carrinho') as $item){
            if(!isset($item->PsProduto) || $item->PsProduto == '' || $item->PsProduto < 0.300) $item->PsProduto = 0.300;
            if(!isset($item->largura) || $item->largura == '') $item->largura = 20;
            if(!isset($item->altura) || $item->altura == '') $item->altura = 20;
            if(!isset($item->profundidade) || $item->profundidade == '') $item->profundidade = 20;
            $quote_itens = $quote->addShippingItem($item->CdProduto.'-'.$item->CdDetalhe, $item->QtProduto, $item->PsProduto, $item->largura, $item->altura, $item->profundidade, 'Accessories');
        }


        $result = $quote_itens->execute();
        $services = $result->getShippingServices();
        $dados['frete'] = [];
        $cc = 0;
        foreach ($services as $service) {


            if(!$service->isError()){

                if(in_array($service->getCarrier(), Session::get('loja_transportadora'), false)) {
                    $dados['frete'][$cc]['price'] = $service->getShippingPrice();
                    $dados['frete'][$cc]['carrier'] = $service->getCarrier();
                    $dados['frete'][$cc]['carrier_description'] = $service->getServiceDescription();
                    $dados['frete'][$cc]['deliveryTime'] = $service->getDeliveryTime();
                    $dados['frete'][$cc]['responseTime'] = $service->getResponseTime();
                }

            }
            //dump($service->getServiceDescription(),$dados['frete']);
            $cc++;

        }

        return json_encode($dados['frete']);

    }
}
