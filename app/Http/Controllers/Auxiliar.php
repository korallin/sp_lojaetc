<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class Auxiliar extends Controller
{
    static public function geo(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get(
            'https://nominatim.openstreetmap.org/reverse',
            [
                'query' => [
                    'lat' => $request->latitude,
                    'lon' => $request->longitude,
                    'format' => 'json'
                ],
            ]
        );
        $body = json_decode($response->getBody(), true);
        $uf = \App\Models\AuxUfs::where('descricao', $body['address']['state'])->first();

        Session::put(['geo' => ['uf' => $uf->uf, 'latitude' => $request->latitude, 'longitude' => $request->longitude, 'local' => $body]]);

    }



    static public function dia($i)
    {
        $nome_dia = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
        return $nome_dia[$i];
    }

    static public function l_int($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }

    static public function l_float($str) {
        $str = str_replace(".","", $str);
        $str = str_replace(",",".", $str);
        $str = str_replace("%","", $str);
        return $str;
    }

    static public function telcel($nu){
        $temp = '(00) 0000-0000';
        if(strlen($nu) == 11){
            $temp = '('.substr($nu,0,2).') '.substr($nu,2,1).' '.substr($nu,3,4).'-'.substr($nu,7,4);
        }
        if(strlen($nu) == 10){
            $temp = '('.substr($nu,0,2).') '.substr($nu,2,4).'-'.substr($nu,6,4);
        }
        return $temp;
    }

    static public function esconde($str){
        $temp = '';
        $temp = substr($str,0,3).'......'.substr($str,-2);
        return $temp;
    }

    static public function mask($val, $mask){
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++)	 {
            if($mask[$i] == '#')	 {
                if(isset($val[$k]))	$maskared .= $val[$k++];
            } else {
                if(isset($mask[$i])) $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }

    static public function cpfcnpjMask($val){
        if(strlen($val) == 11){
            $maskared = '';
            $mask = '###.###.###-##';
            $k = 0;
            for($i = 0; $i<=strlen($mask)-1; $i++)	 {
                if($mask[$i] == '#')	 {
                    if(isset($val[$k]))	$maskared .= $val[$k++];
                } else {
                    if(isset($mask[$i])) $maskared .= $mask[$i];
                }
            }
        } else {
            $maskared = '';
            $mask = '##.###.###/####-##';
            $k = 0;
            for($i = 0; $i<=strlen($mask)-1; $i++)	 {
                if($mask[$i] == '#')	 {
                    if(isset($val[$k]))	$maskared .= $val[$k++];
                } else {
                    if(isset($mask[$i])) $maskared .= $mask[$i];
                }
            }
        }
        return $maskared;
    }

    static public function cep(Request $request) {
        $w_cep = \App\Http\Controllers\Auxiliar::l_int($request->cep);
        $cep = \App\Models\AuxCeps::where('cep',$w_cep)->first();
        return json_encode($cep, true);
    }

    static public function cep_f(Request $request) {
        $w_cep = \App\Http\Controllers\Auxiliar::l_int($request->cep);
        $cep = \App\Models\AuxCeps::selectRaw('endereco.*, bairro.nome as bairro, cidade.nome as cidade, endereco.id_uf as uf')
            ->join('bairro','bairro.id_bairro','endereco.id_bairro')
            ->join('cidade','cidade.id_cidade','endereco.id_cidade')
            ->where('endereco.cep',$w_cep)->first();
        return $cep->toJson();
    }

    static public function estados(Request $request) {
        $ufs = \App\Models\AuxUfs::orderBy('descricao')->whereRaw('uf in("RJ", "SP")')->get();
        return json_encode($ufs);
    }

    static public function cidades(Request $request) {
        $cidades = \App\Models\AuxCidades::where('id_uf',$request->uf)->orderBy('nome')->get();
        return json_encode($cidades);
    }

    static public function bairros(Request $request) {
        $w_cidade = \App\Http\Controllers\Auxiliar::l_int($request->cidade);
        $bairros = \App\Models\AuxBairros::where('id_cidade',$w_cidade)->orderBy('nome')->get();
        return json_encode($bairros);
    }


}
