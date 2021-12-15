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
        $peso = 0;
        $larg = 0;
        $altu = 0;
        $prof = 0;

        foreach (Session::get('carrinho') as $item){
            //dump($item);
            if(!isset($item->PsProduto) || $item->PsProduto == '' || $item->PsProduto < 0.300) $item->PsProduto = 0.300;
            if(!isset($item->NuLargura) || $item->NuLargura == ''){ $item->NuLargura = 30; } else { $item->NuLargura = ($item->NuLargura*100); }
            if(!isset($item->NuAltura) || $item->NuAltura == ''){ $item->NuAltura = 30; } else { $item->NuAltura = ($item->NuAltura*100); }
            if(!isset($item->NuComprimento) || $item->NuComprimento == ''){ $item->NuComprimento = 30; } else { $item->NuComprimento = ($item->NuComprimento*100); }
            $quote_itens = $quote->addShippingItem($item->CdProduto.'-'.$item->CdDetalhe, $item->QtProduto, $item->PsProduto, $item->NuLargura, $item->NuAltura, $item->NuComprimento, 'Accessories');
            $peso += $item->PsProduto;
            $larg += $item->NuLargura;
            $altu += $item->NuAltura;
            $prof += $item->NuComprimento;
        }

        //dd($quote_itens);


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

        if(!$dados['frete']){

            $dados['frete']['PsProduto'] = $peso;
            $dados['frete']['NuLargura'] = $larg;
            $dados['frete']['NuAltura'] = $altu;
            $dados['frete']['NuComprimento'] = $comp;
        }

        return json_encode($dados['frete']);

    }
}
